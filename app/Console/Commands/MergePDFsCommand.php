<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TCPDF;

class MergePDFsCommand extends Command
{
    protected $signature = 'pdf:merge {outputFileName}';
    protected $description = 'Merge PDF files into one';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = [
            public_path('uploads/file1.pdf'),
            public_path('uploads/file2.pdf'),
            // Add more files as needed
        ];

        $outputPath = '/home/u698476407/domains/geeshamart.com/public_html/public/merged/merged_document.pdf';
        $outputFilePath = public_path('merged/' . $outputFileName);

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        foreach ($files as $file) {
            if (file_exists($file)) {
                $pageCount = $pdf->setSourceFile($file);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $pdf->AddPage();
                    $tplIdx = $pdf->importPage($pageNo);
                    $pdf->useTemplate($tplIdx);
                }
            }
        }

        $pdf->Output($outputPath, 'F'); // 'F' saves the file to the path

        $this->info('PDF files merged successfully!');
        $this->info('Merged PDF saved at: ' . $outputFilePath);
    }
}
