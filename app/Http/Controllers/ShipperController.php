<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipper;
use App\Models\Country;
use App\Models\States;
use App\Models\Consignee;

class ShipperController extends Controller
{
    public function shipper_insert(Request $request){
        // echo '<pre>'; print_r($request->all()); die();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        Shipper::create([
            'user_id' => auth()->user()->id,
            'shipper_name' => $request->input('shipper_name') ?? '',
            'shipper_address' => $request->input('shipper_address') ?? '',
            'shipper_country' => $request->input('customer_country') ?? '',
            'shipper_state' => $request->input('customer_state') ?? '',
            'shipper_city' => $request->input('customer_city') ?? '',
            'shipper_zip' => $request->input('customer_zip') ?? '',
            'shipper_contact_name' => $request->input('shipper_contact_name') ?? '',
            'shipper_contact_email' => $request->input('shipper_contact_email') ?? '',
            'shipper_telephone' => $request->input('shipper_telephone') ?? '',
            'shipper_extn' => $request->input('shipper_extn') ?? '',
            'shipper_toll_free' => $request->input('shipper_toll_free') ?? '',
            'shipper_fax' => $request->input('shipper_fax') ?? '',
            'shipper_hours' => $request->input('shipper_hours') ?? '',
            'shipper_appointments' => $request->input('shipper_appointments') ?? '',
            'shipper_major_intersections' => $request->input('shipper_major_intersections') ?? '',
            'shipper_status' => $request->input('shipper_status') ?? '',
            'shipper_shipping_notes' => $request->input('shipper_shipping_notes') ?? '',
            'shipper_internal_notes' => $request->input('shipper_internal_notes') ?? '',
        ]);
    }

        if($request->same_as_consignee) {
            Consignee::create([
                'user_id' => auth()->user()->id,
                'consignee_name' => $request->input('shipper_name') ?? '',
                'consignee_address' => $request->input('shipper_address') ?? '',
                'consignee_country' => $request->input('customer_country') ?? '',
                'consignee_state' => $request->input('customer_state') ?? '',
                'consignee_city' => $request->input('customer_city') ?? '',
                'consignee_zip' => $request->input('customer_zip') ?? '',
                'consignee_contact_name' => $request->input('shipper_contact_name') ?? '',
                'consignee_contact_email' => $request->input('shipper_contact_email') ?? '',
                'consignee_telephone' => $request->input('shipper_telephone') ?? '',
                'consignee_ext' => $request->input('shipper_extn') ?? '',
                'consignee_toll_free' => $request->input('shipper_toll_free') ?? '',
                'consignee_fax' => $request->input('shipper_fax') ?? '',
                'consignee_hours' => $request->input('shipper_hours') ?? '',
                'consignee_appointments' => $request->input('shipper_appointments') ?? '',
                'consignee_major_intersections' => $request->input('shipper_major_intersections') ?? '',
                'consignee_status' => $request->input('shipper_status') ?? '',
                'consignee_shipping_notes' => $request->input('shipper_shipping_notes') ?? '',
                'consignee_internal_notes' => $request->input('shipper_internal_notes') ?? '',
            ]);
        }
        return redirect()->back()->with('success', 'Data has been saved!');
    }

    public function shipper(){
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::all();
        $fetch = Shipper::where('user_id', auth()->user()->id)->get();
        return view('broker.shipper', compact('countries', 'states', 'fetch'));
    }

    public function shipper_list(){
        
        $fetch = Shipper::all();
        return view('broker.shipper_list',['fetch' => $fetch]);
    }

    public function delete_shipper($id)
    {
    $external = Shipper::find($id);
    if ($external) {
        $external->delete();
        return redirect()->back()->with('success', 'Row deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Row not found');
    }
    }

    public function shipperEdit($id)
    {
        $shipper = Shipper::findOrFail($id);
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::all(); // Assuming your state model is named State, change accordingly if different
        return view('broker.shipper_edit', compact('shipper', 'countries', 'states'));
    }

    public function shipperUpdate(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'shipper_name' => 'required|string|max:255',
        ]);
    
        // Find the shipper
        $shipper = Shipper::findOrFail($id);
    
        // Update shipper data
        $shipper->update([
            'user_id' => auth()->user()->id,
            'shipper_name' => $request->input('shipper_name', ''),
            'shipper_address' => $request->input('shipper_address', ''),
            'shipper_country' => $request->input('customer_country', ''),
            'shipper_state' => $request->input('customer_state', ''),
            'shipper_city' => $request->input('customer_city', ''),
            'shipper_zip' => $request->input('customer_zip', ''),
            'shipper_contact_name' => $request->input('shipper_contact_name', ''),
            'shipper_contact_email' => $request->input('shipper_contact_email', ''),
            'shipper_telephone' => $request->input('shipper_telephone', ''),
            'shipper_extn' => $request->input('shipper_extn', ''),
            'shipper_toll_free' => $request->input('shipper_toll_free', ''),
            'shipper_fax' => $request->input('shipper_fax', ''),
            'shipper_hours' => $request->input('shipper_hours', ''),
            'shipper_appointments' => $request->input('shipper_appointments', ''),
            'shipper_major_intersections' => $request->input('shipper_major_intersections', ''),
            'shipper_status' => $request->input('shipper_status', ''),
            'shipper_shipping_notes' => $request->input('shipper_shipping_notes', ''),
            'shipper_internal_notes' => $request->input('shipper_internal_notes', ''),
        ]);
    
        // Create consignee if 'same_as_consignee' is checked
        if ($request->input('same_as_consignee')) {
            Consignee::updateOrCreate([ // use updateOrCreate to update existing or create new
                'user_id' => auth()->user()->id,
                'consignee_name' => $request->input('shipper_name'),
            ], [
                'consignee_address' => $request->input('shipper_address', ''),
                'consignee_country' => $request->input('customer_country', ''),
                'consignee_state' => $request->input('customer_state', ''),
                'consignee_city' => $request->input('customer_city', ''),
                'consignee_zip' => $request->input('customer_zip', ''),
                'consignee_contact_name' => $request->input('shipper_contact_name', ''),
                'consignee_contact_email' => $request->input('shipper_contact_email', ''),
                'consignee_telephone' => $request->input('shipper_telephone', ''),
                'consignee_ext' => $request->input('shipper_extn', ''),
                'consignee_fax' => $request->input('shipper_fax', ''),
                'consignee_appointments' => $request->input('shipper_appointments', ''),
                'consignee_status' => $request->input('shipper_status', ''),
                'consignee_shipping_notes' => $request->input('shipper_shipping_notes', ''),
                'consignee_internal_notes' => $request->input('shipper_internal_notes', ''),
            ]);
        }
    
        // Redirect back with success message
        return redirect()->route('shipper')->with('success', 'Shipper data has been updated!');
    }
    
    



    public function destroyshipper($id)
    {
        $shipper = Shipper::find($id);
        
        if ($shipper) {
            $shipper->delete();
            return redirect()->back()->with('success', 'Shipper deleted successfully.');
        }

        return redirect()->back()->with('error', 'Shipper not found.');
    }
}
