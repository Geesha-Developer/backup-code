<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\File; // Add this line for importing the File facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Load;
use TCPDI;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Tcpdf\Fpdi;
use File;
use setasign\Fpdi\PdfParser\TcpdfParser;
use TCPDF;
use setasign\Fpdi\PdfReader;
use Carbon\Carbon;

class FilesUploadController extends Controller
{
    public function index(int $filesId)
    {
        $load = Load::findOrFail($filesId);
        $uploadedFiles = json_decode($load->public_file, true);
        return view('files.files', compact('load', 'uploadedFiles'));
    }
    



    public function getFiles($recordId)
    {
        $record = Load::findOrFail($recordId);

        $files = json_decode($record->public_file, true);
    
        $fileList = [];
        foreach ($files as $field => $fileArray) {
            if (is_array($fileArray)) {
                foreach ($fileArray as $file) {
                    $fileList[] = asset('storage/' . $file); // Use storage path
                }
            } else {
                $fileList[] = asset('storage/' . $fileArray); // Use storage path
            }
        }
    
        return response()->json(['files' => $fileList]);
    }
    
    

    public function deleteFile(Request $request)
    {
        $recordId = $request->input('record_id');
        $fileName = $request->input('file_name');

        $record = Load::findOrFail($recordId);
        $files = json_decode($record->public_file, true);

        foreach ($files as $key => $fileArray) {
            if (is_array($fileArray)) {
                foreach ($fileArray as $index => $file) {
                    if (basename($file) == $fileName) {
                        unset($files[$key][$index]);
                        if (empty($files[$key])) {
                            unset($files[$key]);
                        }
                        File::delete(public_path($file));
                        break 2;
                    }
                }
            } else {
                if (basename($fileArray) == $fileName) {
                    unset($files[$key]);
                    File::delete(public_path($fileArray));
                    break;
                }
            }
        }

        $record->public_file = json_encode($files);
        $record->save();

        return response()->json(['success' => true]);
    }

public function showForm($loadId)
{
    // Retrieve the load
    $load = Load::findOrFail($loadId);
    
    // Get the uploaded files for this load
    $uploadedFiles = json_decode($load->public_file, true);
    
    // Pass the load and uploaded files to the view
    return view('files.files', compact('load', 'uploadedFiles'));
}


public function mergeFiles(Request $request)
{
    $recordId = $request->input('recordId');
    $inputFilePaths = $request->input('filePaths');

    try {
        $load = Load::findOrFail($recordId);
        $filePathsJson = $load->public_file;
        $filePaths = !empty($filePathsJson) ? json_decode($filePathsJson, true) : [];

        // Ensure inputFilePaths is an array, initialize if null
        if (is_null($inputFilePaths)) {
            $inputFilePaths = [];
        }

        // Merge the input file paths with the existing file paths
        $filePaths = array_merge($filePaths, $inputFilePaths);

        // Flatten and filter the filePaths to ensure they are strings
        $filePaths = array_filter($filePaths, 'is_string');

        // Log the merged file paths for debugging
        \Log::info('Merged File Paths: ' . print_r($filePaths, true));

        $mergedFileName = 'load_' . $load->load_number . '.pdf';
        $outputPath = public_path('uploads/mergedfiles/' . $mergedFileName);

        // Create a new PDF document
        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        foreach ($filePaths as $filePath) {
            // Log the file path
            \Log::info('Merging file: ' . $filePath);

            if (is_string($filePath) && file_exists(public_path($filePath))) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (strtolower($extension) === 'pdf') {
                    // Merge PDF
                    $pageCount = $pdf->setSourceFile(public_path($filePath));
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $tplIdx = $pdf->importPage($pageNo);
                        $pdf->AddPage();
                        $pdf->useTemplate($tplIdx, 10, 10, 200);
                    }
                } elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Add image to PDF
                    $pdf->AddPage();
                    $pdf->Image(public_path($filePath), 10, 10, 190, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);
                }
            } else {
                \Log::error('File does not exist or invalid path: ' . print_r($filePath, true));
            }
        }

        // Output the merged file
        $pdf->Output($outputPath, 'F');

        \Log::info('Merged file created at: ' . $outputPath);

        return response()->json([
            'success' => true,
            'url' => asset('uploads/mergedfiles/' . $mergedFileName)
        ]);
    } catch (\Exception $e) {
        \Log::error('Error merging files: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error merging files: ' . $e->getMessage()
        ], 500);
    }
}






// public function uploadFiles(Request $request, int $filesId)
// {
//     $request->validate([
//         'carrer_rate_cnfrm_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
//         'pod_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
//         'shipper_rate_approval_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
//         'carrier_invoice_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
//         'optional_docs.*' => 'nullable|mimes:pdf,jpg,png|max:10240',
//     ]);

//     $load = Load::findOrFail($filesId);

//     $filePaths = json_decode($load->public_file, true) ?: [];

//     $fileFields = [
//         'carrer_rate_cnfrm_doc',
//         'pod_doc',
//         'shipper_rate_approval_doc',
//         'carrier_invoice_doc',
//         'optional_docs'
//     ];

//     foreach ($fileFields as $field) {
//         if ($request->hasFile($field)) {
//             $files = $request->file($field);
//             if (!is_array($files)) {
//                 $files = [$files];
//             }
//             foreach ($files as $file) {
//                 $fileName = time() . '_' . $file->getClientOriginalName();
//                 $directory = 'uploads/load/' . $load->load_number . '-' . $load->load_bill_to;
//                 $file->move(public_path($directory), $fileName);
//                 if (!isset($filePaths[$field])) {
//                     $filePaths[$field] = []; // Initialize as array if not set
//                 }
//                 $filePaths[$field][] = $directory . '/' . $fileName;
//             }
//         }
//     }

//     $load->public_file = json_encode($filePaths);
//     $load->save();

//     return back()->with('success', 'Files uploaded successfully');
// }

public function uploadFiles(Request $request, int $filesId)
{
    // Validate the incoming request
    $request->validate([
        'carrer_rate_cnfrm_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'pod_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'shipper_rate_approval_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'carrier_invoice_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'optional_docs.*' => 'nullable|mimes:pdf,jpg,png|max:10240',
    ]);

    $load = Load::findOrFail($filesId);

    // Decode existing file paths or initialize as an empty array
    $filePaths = json_decode($load->public_file, true) ?: [];

    // Define the fields that contain file uploads
    $fileFields = [
        'carrer_rate_cnfrm_doc',
        'pod_doc',
        'shipper_rate_approval_doc',
        'carrier_invoice_doc',
        'optional_docs'
    ];

    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $files = $request->file($field);
            if (!is_array($files)) {
                $files = [$files]; // Ensure we have an array of files
            }

            foreach ($files as $file) {
                // Create a unique file name
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Define the storage directory
                $directory = 'Load-files/' . $load->load_number . '-' . $load->load_bill_to;
                // Store the file
                $filePath = $file->storeAs($directory, $fileName, 'public');

                // Initialize array if not set
                if (!isset($filePaths[$field])) {
                    $filePaths[$field] = [];
                }

                // Store the file path in the array
                $filePaths[$field][] = $filePath;
            }
        }
    }

    // Update the database with the new file paths
    $load->public_file = json_encode($filePaths);
    $load->public_file_upload_date = Carbon::now();
    // echo "<pre>"; print_r($load); die;
    $load->save();

    return back()->with('success', 'Files uploaded successfully');
}


public function deleteFilebroker(Request $request)
{
    $recordId = $request->input('record_id');
    $fileName = $request->input('file_name');
    
    $record = Load::find($recordId);

    if (!$record) {
        return response()->json(['error' => 'Record not found'], 404);
    }

    $files = json_decode($record->public_file, true);

    foreach ($files as $key => $fileArray) {
        if (is_array($fileArray)) {
            foreach ($fileArray as $index => $file) {
                if (basename($file) == basename($fileName)) {
                    unset($files[$key][$index]);
                    if (empty($files[$key])) {
                        unset($files[$key]);
                    }
                    File::delete(public_path($file));
                    break 2;
                }
            }
        } else {
            if (basename($fileArray) == basename($fileName)) {
                unset($files[$key]);
                File::delete(public_path($fileArray));
                break;
            }
        }
    }

    // Re-index the array to remove any gaps
    $files = array_values($files);

    $record->public_file = json_encode($files);
    $record->save();

    return response()->json(['success' => true]);
}






    
}
