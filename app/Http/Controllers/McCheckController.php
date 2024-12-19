<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\customer;
use App\Models\User;
use App\Models\Country;
use App\Models\States;
use App\Models\Cities;
use App\Models\External;
use App\Models\Shipper;
use App\Models\Load;
use App\Models\Consignee;
use App\Models\ProfileData;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Carbon\Carbon;
use App\Models\McCheck;


class McCheckController extends Controller
{
    public function mcCheck()
    {
        // Fetch MC Check records for the authenticated user
        $mc = McCheck::where('user_id', auth()->user()->id)->get();
        return view('broker.mc', compact('mc'));
    }

    public function mc_check(Request $request)
    {
        // Handle the file upload if present
        if ($request->hasFile('carrier_commodity_value_proof')) {
            $fileName = time() . '.' . $request->file('carrier_commodity_value_proof')->getClientOriginalExtension();
            $filePath = $request->file('carrier_commodity_value_proof')->storeAs('public/mc_files/commodity_files', $fileName);
            $validated['carrier_commodity_value_proof'] = $fileName;
        }
    
        // Save the data to the External model
        $external = new McCheck();
        $external->dispatcher_name = Auth::user()->name;
        $external->carrier_mc_ff_input = $request->input('carrier_mc_ff_input');
        $external->carrier_dot = $request->input('carrier_dot');
        $external->carrier_name = $request->input('carrier_name');
        $external->carrier_email = $request->input('carrier_email');
        $external->carrier_telephone = $request->input('carrier_telephone');
        $external->carrier_commodity_type = $request->input('carrier_commodity_type');
        $external->carrier_commodity_name = $request->input('carrier_commodity_name');
        $external->carrier_commodity_value = $request->input('carrier_commodity_value');
        $external->carrier_equipment_type = $request->input('carrier_equipment_type');
        $external->carrier_mc_purpose = $request->input('carrier_mc_purpose');
        $external->carrier_commodity_value_proof = $validated['carrier_commodity_value_proof'] ?? '';
    
        // Add the authenticated user's ID
        $external->user_id = Auth::id();  // This is the key line that sets the user ID
    // echo "<pre>"; print_r($external); die;
        // Save the model
        $external->save();
    
        // Redirect or return response
        return redirect()->back()->with('success', 'MC Check added successfully.');
    }
    


}