<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

// use App\External;
use App\Models\External;
use App\Models\Country;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\Crypt;


class ExternalController extends Controller
{
    public function insert_carrier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carrier_name' => 'required',
            'carrier_dot' => 'required',
            'carrier_mc_ff' => 'required',
            'carrier_mc_ff_input' => 'required',
            'carrier_address' => 'required',
            'carrier_address_two' => 'required',
            'carrier_country' => 'required',
            'carrier_address_three' => 'required',
            'carrier_state' => 'required',
            'carrier_city' => 'required',
            'carrier_zip' => 'required',
            'carrier_contact_name' => 'required',
            'carrier_email' => 'required',
            'carrier_telephone' => 'required',
            'carrier_extn' => 'required',
            'carrier_fax' => 'required',
            'carrier_payment_terms' => 'required',
            'carrier_username' => 'required',
            'carrier_password' => 'required',
            'carrier_factoring_company' => 'required',
            'carrier_notes' => 'required',
            'carrier_status' => 'required',
            'carrier_load_type' => 'required',
            'carrier_blacklisted' => 'required',
            'carrier_corporation' => 'required',
            'carrier_file_upload.*' => 'file|mimes:jpeg,png,pdf,docx|max:2048' // Adjust file types and size as needed

        ]);

        $yourModel = new External();
        $yourModel->user_id = Auth::id();
        $yourModel->carrier_name = $request->input('carrier_name') ?? '';
        $yourModel->carrier_dot = $request->input('carrier_dot') ?? '';
        $yourModel->carrier_mc_ff = $request->input('carrier_mc_ff') ?? '';
        $yourModel->carrier_mc_ff_input = $request->input('carrier_mc_ff_input') ?? '';
        $yourModel->carrier_address = $request->input('carrier_address') ?? '';
        $yourModel->carrier_address_two = $request->input('carrier_address_two') ?? '';
        $yourModel->carrier_country	 = $request->input('carrier_country') ?? '';
        $yourModel->carrier_address_three = $request->input('carrier_address_three') ?? '';
        $yourModel->carrier_state = $request->input('carrier_state') ?? '';
        $yourModel->carrier_city = $request->input('carrier_city') ?? '';
        $yourModel->carrier_zip = $request->input('carrier_zip') ?? '';
        $yourModel->carrier_contact_name = $request->input('carrier_contact_name') ?? '';
        $yourModel->carrier_email = $request->input('carrier_email') ?? '';
        $yourModel->carrier_telephone = $request->input('carrier_telephone') ?? '';
        $yourModel->carrier_extn = $request->input('carrier_extn') ?? '';
        $yourModel->carrier_fax = $request->input('carrier_fax') ?? '';
        $yourModel->carrier_payment_terms = $request->input('carrier_payment_terms') ?? '';
        $yourModel->carrier_username = $request->input('carrier_username') ?? '';
        $yourModel->carrier_password = $request->input('carrier_password') ?? '';
        $yourModel->carrier_factoring_company = $request->input('carrier_factoring_company') ?? '';
        $yourModel->carrier_notes = $request->input('carrier_notes') ?? '';
        $yourModel->carrier_status = $request->input('carrier_status') ?? '';
        $yourModel->carrier_load_type = $request->input('carrier_load_type') ?? '';
        $yourModel->carrier_blacklisted	= $request->input('carrier_blacklisted	') ?? '';
        $yourModel->carrier_corporation = $request->input('carrier_corporation') ?? '';
        $yourModel->carrier_file_upload = $request->input('carrier_file_upload') ?? '';
        
    if ($request->hasFile('carrier_file_upload')) {
        $filePaths = [];
        foreach ($request->file('carrier_file_upload') as $file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads/carrier', $fileName);
            $filePaths[] = $fileName;
        }
        $yourModel->carrier_file_upload = implode(',', $filePaths); // Save file names as a comma-separated string
    }
        $yourModel->save();
        return redirect()->back()->with('success', 'Data has been saved!');
    }


    public function carrier(){
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::all();
        $cities = Cities::all();
        $user = auth()->user();
        
        if(!$user){
            $user = Auth::guard('teamlead')->user();  
        }
        $fetch = External::where('user_id', $user->id)->get();
        $allcarrier = External::orderBy('id', 'DESC')->get(); // Specify the column to order by
        return view('broker.carrier',compact('countries', 'states','fetch','user','allcarrier'));
    }




    public function carrier_list(){
   
        $fetch = External::all();
        return view('broker.carrier',['fetch' => $fetch]);
    }
    public function delete_external($id)
    {
    $external = External::find($id);
    if ($external) {
        $external->delete();
        return redirect()->back()->with('success', 'Row deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Row not found');
    }
    }

    public function getStates(Request $request)
    {
        $country = $request->input('country');
        $states = States::where('country', $country)->pluck('name');
        return response()->json($states);
    }


    public function carrierEdit($id)
    {
        $carrier = External::findOrFail($id);  
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::all();  
        return view('broker.edit_carrier', compact('carrier','countries','states'));
    }

    public function carriersUpdate(Request $request, $id)
{
    $carrier = External::findOrFail($id);
    
    // Update fields based on form inputs
    $carrier->carrier_name = $request->input('carrier_name') ?? '';
    $carrier->carrier_dot = $request->input('carrier_dot') ?? '';
    $carrier->carrier_mc_ff = $request->input('carrier_mc_ff') ?? '';
    $carrier->carrier_mc_ff_input = $request->input('carrier_mc_ff_input') ?? '';
    $carrier->carrier_address = $request->input('carrier_address') ?? '';
    $carrier->carrier_address_two = $request->input('carrier_address_two') ?? '';
    $carrier->carrier_country = $request->input('carrier_country') ?? '';
    $carrier->carrier_address_three = $request->input('carrier_address_three') ?? '';
    $carrier->carrier_state = $request->input('carrier_state') ?? '';
    $carrier->carrier_city = $request->input('carrier_city') ?? '';
    $carrier->carrier_zip = $request->input('carrier_zip') ?? '';
    $carrier->carrier_contact_name = $request->input('carrier_contact_name') ?? '';
    $carrier->carrier_email = $request->input('carrier_email') ?? '';
    $carrier->carrier_telephone = $request->input('carrier_telephone') ?? '';
    $carrier->carrier_extn = $request->input('carrier_extn') ?? '';
    $carrier->carrier_fax = $request->input('carrier_fax') ?? '';
    $carrier->carrier_payment_terms = $request->input('carrier_payment_terms') ?? '';
    $carrier->carrier_username = $request->input('carrier_username') ?? '';
    $carrier->carrier_password = $request->input('carrier_password') ?? '';
    $carrier->carrier_factoring_company = $request->input('carrier_factoring_company') ?? '';
    $carrier->carrier_notes = $request->input('carrier_notes') ?? '';
    $carrier->carrier_status = $request->input('carrier_status') ?? '';
    $carrier->carrier_load_type = $request->input('carrier_load_type') ?? '';
    $carrier->carrier_blacklisted = $request->input('carrier_blacklisted') ?? '';
    $carrier->carrier_corporation = $request->input('carrier_corporation') ?? '';

    if ($request->hasFile('carrier_file_upload')) {
        $filePaths = [];
        foreach ($request->file('carrier_file_upload') as $file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads/carrier', $fileName);
            $filePaths[] = $fileName;
        }
        $carrier->carrier_file_upload = implode(',', $filePaths);
    }

    $carrier->update($request->all());
    return redirect()->route('carrier')->with('success', 'Carrier updated successfully.');
}


public function destroy_carrier($id)
{
    $carrier = External::find($id);
    
    if ($carrier) {
        $carrier->delete();
        return response()->json(['success' => 'Carrier deleted successfully.']);
    }

    return response()->json(['error' => 'Carrier not found.'], 404);
}






    



}