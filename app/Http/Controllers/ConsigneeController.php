<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewConsigneeAdded;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\States;
use App\Models\Cities;
use App\Models\Consignee;
use App\Models\customer;
use App\Models\Shipper;
use App\Models\Load;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConsigneeController extends Controller
{

   
    public function add_consignee(){
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $consignees = Consignee::where('user_id', auth()->user()->id)->get();
        $states = States::orderBy('name')->get();
        $cities = Cities::all();
        // print_r($consignees); die();

        return view('broker.consignee', compact('countries', 'states', 'cities', 'consignees'));
    }

    public function consignee_list()
    {
        $consignees = Consignee::all();
        return view('broker.consignee', ['consignees' => $consignees]);
    }

    public function destroy($id)
    {

        Consignee::findOrFail($id)->delete();
    
        return redirect()->route('consignee_list')->with('success', 'Consignee deleted successfully!');
    }


    public function edit($id)
    {
        $consignee = Consignee::findOrFail($id);
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::orderBy('name')->get();
        $cities = Cities::all();  
        $customers = Customer::where('user_id', auth()->user()->id)->get();
        $customers->transform(function ($customer) {
            $totalLoadRate = Load::where('user_id', $customer->user_id)->sum(DB::raw('CAST(shipper_load_final_rate AS UNSIGNED)'));

            $customer->remaining_credit = (int)$customer->adv_customer_credit_limit - $totalLoadRate;
    
            return $customer;
        });
        // print_r($consignee); die();
        return view('broker.consignee_edit', compact('consignee','countries', 'states', 'cities', 'customers'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'consignee_name' => 'required|string|max:255',
        ]);
    
        // Find the consignee by ID or fail if not found
        $consignee = Consignee::findOrFail($id);
    
        // Update the consignee details
        $consignee->update([
            'consignee_name' => $request->input('consignee_name') ?? '',
            'consignee_address' => $request->input('consignee_address') ?? '',
            'consignee_country' => $request->input('consignee_country')?? '',
            'consignee_state' => $request->input('consignee_state')?? '',
            'consignee_city' => $request->input('consignee_city')?? '',
            'consignee_zip' => $request->input('consignee_zip') ?? '',
            'consignee_contact_name' => $request->input('consignee_contact_name') ?? '',
            'consignee_contact_email' => $request->input('consignee_contact_email') ?? '',
            'consignee_telephone' => $request->input('consignee_telephone') ?? '',
            'consignee_ext' => $request->input('consignee_ext') ?? '',
            'consignee_toll_free' => $request->input('consignee_toll_free') ?? '',
            'consignee_fax' => $request->input('consignee_fax') ?? '',
            'consignee_hours' => $request->input('consignee_hours') ?? '',
            'consignee_appointments' => $request->input('consignee_appointments'),
            'consignee_major_intersections' => $request->input('consignee_major_intersections') ?? '',
            'consignee_status' => $request->input('consignee_status') ?? '',
            'consignee_shipping_notes' => $request->input('consignee_shipping_notes') ?? '',
            'consignee_internal_notes' => $request->input('consignee_internal_notes') ?? '',
        ]);
    
        // If the "Add as Shipper" checkbox is checked, update or create shipper
        if($request->consignee_add_shippper) {
            $shipper = Shipper::where('consignee_id', $consignee->id)->first();
    
            if ($shipper) {
                // Update existing shipper details
                $shipper->update([
                    'shipper_name' => $request->input('consignee_name') ?? '',
                    'shipper_address' => $request->input('consignee_address') ?? '',
                    'shipper_country' => $request->input('consignee_country') ?? '',
                    'shipper_state' => $request->input('consignee_state') ?? '',
                    'shipper_city' => $request->input('consignee_city') ?? '',
                    'shipper_zip' => $request->input('consignee_zip') ?? '',
                    'shipper_contact_name' => $request->input('consignee_contact_name') ?? '',
                    'shipper_contact_email' => $request->input('consignee_contact_email') ?? '',
                    'shipper_telephone' => $request->input('consignee_telephone') ?? '',
                    'shipper_extn' => $request->input('consignee_ext') ?? '',
                    'shipper_toll_free' => $request->input('consignee_toll_free') ?? '',
                    'shipper_fax' => $request->input('consignee_fax') ?? '',
                    'shipper_hours' => $request->input('consignee_hours') ?? '',
                    'shipper_appointments' => $request->input('consignee_appointments') ?? '',
                    'shipper_major_intersections' => $request->input('consignee_major_intersections') ?? '',
                    'shipper_status' => $request->input('consignee_status') ?? '',
                    'shipper_shipping_notes' => $request->input('consignee_shipping_notes') ?? '',
                    'shipper_internal_notes' => $request->input('consignee_internal_notes') ?? '',
                ]);
            } else {
                // Create new shipper if it does not exist
                Shipper::create([
                    'user_id' => auth()->user()->id,
                    'shipper_name' => $request->input('consignee_name') ?? '',
                    'shipper_address' => $request->input('consignee_address') ?? '',
                    'shipper_country' => $request->input('consignee_country') ?? '',
                    'shipper_state' => $request->input('consignee_state') ?? '',
                    'shipper_city' => $request->input('consignee_city') ?? '',
                    'shipper_zip' => $request->input('consignee_zip') ?? '',
                    'shipper_contact_name' => $request->input('consignee_contact_name') ?? '',
                    'shipper_contact_email' => $request->input('consignee_contact_email') ?? '',
                    'shipper_telephone' => $request->input('consignee_telephone') ?? '',
                    'shipper_extn' => $request->input('consignee_ext') ?? '',
                    'shipper_toll_free' => $request->input('consignee_toll_free') ?? '',
                    'shipper_fax' => $request->input('consignee_fax') ?? '',
                    'shipper_hours' => $request->input('consignee_hours') ?? '',
                    'shipper_appointments' => $request->input('consignee_appointments') ?? '',
                    'shipper_major_intersections' => $request->input('consignee_major_intersections') ?? '',
                    'shipper_status' => $request->input('consignee_status') ?? '',
                    'shipper_shipping_notes' => $request->input('consignee_shipping_notes') ?? '',
                    'shipper_internal_notes' => $request->input('consignee_internal_notes') ?? '',
                ]);
            }
        }
    
        return redirect()->route('consignee')->with('success', 'Consignee Update successfully!');
    }
    
    

    
    
    public function store(Request $request)
    {
                // echo '<pre>'; print_r($request->all()); die();

        Consignee::create([
            'user_id' => auth()->user()->id,
            'consignee_name' => $request->input('consignee_name') ?? '',
            'consignee_address' => $request->input('consignee_address') ?? '',
            'consignee_country' => $request->input('consignee_country') ?? '',
            'consignee_state' => $request->input('consignee_state') ?? '',
            'consignee_city' => $request->input('consignee_city') ?? '',
            'consignee_zip' => $request->input('consignee_zip') ?? '',
            'consignee_contact_name' => $request->input('consignee_contact_name') ?? '',
            'consignee_contact_email' => $request->input('consignee_contact_email') ?? '',
            'consignee_telephone' => $request->input('consignee_telephone') ?? '',
            'consignee_ext' => $request->input('consignee_ext') ?? '',
            'consignee_toll_free' => $request->input('consignee_toll_free') ?? '',
            'consignee_fax' => $request->input('consignee_fax') ?? '',
            'consignee_hours' => $request->input('consignee_hours') ?? '',
            'consignee_appointments' => $request->input('consignee_appointments') ?? '',
            'consignee_major_intersections' => $request->input('consignee_major_intersections') ?? '',
            'consignee_status' => $request->input('consignee_status') ?? '',
            'consignee_shipping_notes' => $request->input('consignee_shipping_notes') ?? '',
            'consignee_internal_notes' => $request->input('consignee_internal_notes') ?? '',
        ]);


        if($request->consignee_add_shippper) {
        Shipper::create([
            'user_id' => auth()->user()->id,
            'shipper_name' => $request->consignee_name ?? '',
            'shipper_address' => $request->consignee_address ?? '',
            'shipper_country' => $request->consignee_country ?? '',
            'shipper_state' => $request->consignee_state ?? '',
            'shipper_city' => $request->consignee_city ?? '',
            'shipper_zip' => $request->consignee_zip ?? '',
            'shipper_contact_name' => $request->consignee_contact_name ?? '',
            'shipper_contact_email' => $request->consignee_contact_email ?? '',
            'shipper_telephone' => $request->consignee_telephone ?? '',
            'shipper_extn' => $request->consignee_ext ?? '',
            'shipper_toll_free' => $request->consignee_toll_free ?? '',
            'shipper_fax' => $request->consignee_fax ?? '',
            'shipper_hours' => $request->consignee_hours ?? '',
            'shipper_appointments' => $request->consignee_appointments ?? '',
            'shipper_major_intersections' => $request->consignee_major_intersections ?? '',
            'shipper_status' => $request->consignee_status ?? '',
            'shipper_shipping_notes' => $request->consignee_shipping_notes ?? '',
            'shipper_internal_notes' => $request->consignee_internal_notes ?? '',
        ]);
    }

        // $newConsigneeEmail = new NewConsigneeAdded($consignee);
        // Mail::to('sumit@geeshasolutions.com')->send($newConsigneeEmail);

        return redirect()->back()->with(['message' => 'Consignee added successfully']);
    }
    
    
    public function destroyconsignee($id)
    {
        $consignee = Consignee::find($id);
    
        if ($consignee) {
            $consignee->delete();
            return redirect()->back()->with('success', 'Consignee deleted successfully.');
        }
    
        return redirect()->back()->with('error', 'Consignee not found.');
    }
    

}
