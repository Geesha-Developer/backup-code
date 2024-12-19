<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\customer;
use App\Models\User;
use App\Models\Country;
use App\Models\States;
use App\Models\Cities;
use App\Models\External;
use App\Models\Shipper;
use App\Models\Load;
use App\Models\ProfileData;
use App\Models\Consignee;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{

   public function IndexDashboard(){
        $load = Load::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at',date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        $labels = [];
        $data = [];
        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];

        for($i=1; $i <= 12; $i++){
        $month = date('F', mktime(0,0,0,$i,1));
        $count = 0; 

        foreach($users as $user){
        $get_month = $user->month;
        if($get_month == $i){
            $count = $user->count;
            break;
        }
        }
        array_push($labels,$month);
        array_push($data,$count);
        }
        $datasets = [
            [
                'labels' => 'Users',
                'data' => $data,
                'backgroundColor' => $colors
            ]
            ]; 

     return view('home', compact('datasets', 'labels','load'));
    }


     public function index(){

        $load = Load::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();       
        $carrierNames = External::pluck('carrier_name');
        $brokerLoadStatus =  Load::where('user_id', auth()->user()->id)->get();
        return view('broker.load', compact('load','carrierNames','brokerLoadStatus'));
    }

   
    public function customer_insert(Request $request){

        $admin_user = customer::get();
        $user = auth()->user();
        $yourModel = new customer();
        $yourModel->user_id = Auth::id();
        $yourModel->customer_name = $request->input('customer_name') ?? ''; 
        $yourModel->customer_mc_ff = $request->input('customer_mc_ff') ?? '';
        $yourModel->customer_mc_ff_input = $request->input('customer_mc_ff_input') ?? '';
        $yourModel->customer_address = $request->input('customer_address') ?? '';
        $yourModel->customer_country = $request->input('customer_country') ?? '';
        $yourModel->customer_state = $request->input('customer_state') ?? '';
        $yourModel->customer_city = $request->input('customer_city') ?? '';
        $yourModel->customer_zip = $request->input('customer_zip') ?? '';
        $yourModel->customer_billing_address = $request->input('customer_billing_address') ?? '';
        $yourModel->customer_billing_country = $request->input('customer_billing_country') ?? '';
        $yourModel->customer_billing_state = $request->input('customer_billing_state') ?? '';
        $yourModel->customer_billing_city = $request->input('customer_billing_city') ?? '';
        $yourModel->customer_billing_zip = $request->input('customer_billing_zip') ?? '';
        $yourModel->customer_primary_contact = $request->input('customer_primary_contact') ?? '';
        $yourModel->customer_telephone = $request->input('customer_telephone') ?? '';
        $yourModel->customer_extn = $request->input('customer_extn') ?? '';
        $yourModel->customer_email = $request->input('customer_email') ?? '';
        $yourModel->customer_tollfree = $request->input('customer_tollfree') ?? '';
        $yourModel->customer_fax = $request->input('customer_fax') ?? '';
        $yourModel->customer_secondary_contact = $request->input('customer_secondary_contact') ?? '';
        $yourModel->customer_secondary_email = $request->input('customer_secondary_email') ?? '';
        $yourModel->customer_billing_email = $request->input('customer_billing_email') ?? '';
        $yourModel->customer_billing_telephone =  $request->input('customer_billing_telephone') ?? '';
        $yourModel->customer_billing_extn =  $request->input('customer_billing_extn') ?? '';
        $yourModel->adv_customer_currency_Setting =  $request->input('adv_customer_currency_Setting') ?? '';
        // $yourModel->adv_customer_credit_limit =  $request->input('adv_customer_credit_limit') ?? '0';
        $yourModel->remaining_credit =  $request->input('remaining_credit') ?? '0';
        $yourModel->adv_customer_payment_terms = $request->input('adv_customer_payment_terms') ?? '';
        $yourModel->adv_customer_factoring_company =  $request->input('adv_customer_factoring_company') ?? '';
        $yourModel->adv_customer_webiste_url =  $request->input('adv_customer_webiste_url') ?? '';
        $yourModel->adv_customer_duplicate =  $request->input('adv_customer_duplicate') ?? '';
        $yourModel->adv_customer_duplicate_two =  $request->input('adv_customer_duplicate_two') ?? '';
        $yourModel->adv_customer_internal_notes =  $request->input('adv_customer_internal_notes') ?? '';
        $yourModel->adv_customer_payment_terms_custome =  $request->input('adv_customer_payment_terms_custome') ?? '';
        $yourModel->customer_blacklisted =  $request->input('customer_blacklisted') ?? '';
        $yourModel->customer_status = $request->input('customer_status') ?? '';
        $yourModel->customer_corporation = $request->input('customer_corporation') ?? '';
        $yourModel->status = 'Not Approved' ;
        $yourModel->commenter_name = '';
        $remainingCredit = $request->input('remaining_credit');
        $remainingCredit = is_numeric($remainingCredit) ? (float) $remainingCredit : 0.0;
        
        if ($request->hasFile('customer_file_uploads')) {
            $files = $request->file('customer_file_uploads');
    
            $filePaths = [];
    
            foreach ($files as $file) {
                $fileName = $yourModel->customer_name . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/customers/' . $yourModel->customer_name, $fileName, 'public');
                $filePaths[] = 'uploads/customers/' . $yourModel->customer_name . '/' . $fileName;
            }
    
            $yourModel->customer_file_upload = json_encode($filePaths);
        } else {
            $yourModel->customer_file_upload = '';
        }
    
        if($request->AddAsConsignee){
            Consignee::create([
                'user_id' => auth()->user()->id,
                'consignee_name' => $request->input('customer_name') ?? '',
                'consignee_address' => $request->input('customer_address') ?? '',
                'consignee_country' => $request->input('customer_country') ?? '',
                'consignee_state' => $request->input('customer_state') ?? '',
                'consignee_city' => $request->input('customer_city') ?? '',
                'consignee_zip' => $request->input('customer_zip') ?? '',
                'consignee_contact_name' => $request->input('customer_primary_contact') ?? '',
                'consignee_contact_email' => $request->input('customer_email') ?? '' ,
                'consignee_telephone' => $request->input('customer_telephone') ?? '' ,
                'consignee_ext' => $request->input('customer_extn') ?? '',
                'consignee_toll_free' => 'NA',
                'consignee_fax' => $request->input('customer_fax') ?? '',
                'consignee_hours' => now(),
                'consignee_appointments' => '',
                'consignee_major_intersections' => 'NA',
                'consignee_status' => $request->input('customer_status') ?? '',
                'consignee_shipping_notes' => 'NA' ?? '',
                'consignee_internal_notes' => $request->input('adv_customer_internal_notes') ?? '',
            ]);
        }

       if($request->AddAsShipper){
        Shipper::create([
            'user_id' => auth()->user()->id,
            'shipper_name' => $request->input('customer_name') ?? '',
            'shipper_address' => $request->input('customer_address') ?? '',
            'shipper_country' => $request->input('customer_country') ?? '',
            'shipper_state' => $request->input('customer_state') ?? '',
            'shipper_city' => $request->input('customer_city') ?? '',
            'shipper_zip' => $request->input('customer_zip') ?? '',
            'shipper_contact_name' => $request->input('customer_primary_contact') ?? '',
            'shipper_contact_email' => $request->input('customer_email') ?? '',
            'shipper_telephone' => $request->input('customer_telephone') ?? '',
            'shipper_extn' => $request->input('customer_extn') ?? '' ,
            'shipper_toll_free' => 'NA',
            'shipper_fax' => $request->input('customer_fax') ?? '',
            'shipper_hours' => 'NA',
            'shipper_appointments' => 'NA',
            'shipper_major_intersections' => 'NA',
            'shipper_status' => $request->input('customer_status') ?? '',
            'shipper_shipping_notes' => 'NA',
            'shipper_internal_notes' => $request->input('shipper_shipping_notes') ?? '',
            'commenter_name' => 'NA',
        ]);
       }
        $yourModel->save();
        return redirect()->back()->with('success', 'Data has been saved!');
    }
    
    public function customerEdit($id)
    {
        $customer = customer::findOrFail($id); // Find the customer by ID
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        $states = States::orderBy('name')->get();
        return view('broker.customer-edit', compact('countries', 'states','customer'));
    }

    public function customerupdate(Request $request, $id)
    {
        $customer = Customer::findOrFail($id); // Find the customer by ID
    
        // Update customer fields with validated data
        $customer->user_id = Auth::id();
        $customer->customer_name = $request->input('customer_name') ?? ''; 
        $customer->customer_mc_ff = $request->input('customer_mc_ff') ?? '';
        $customer->customer_mc_ff_input = $request->input('customer_mc_ff_input') ?? '';
        $customer->customer_address = $request->input('customer_address') ?? '';
        $customer->customer_country = $request->input('customer_country') ?? '';
        $customer->customer_state = $request->input('customer_state') ?? '';
        $customer->customer_city = $request->input('customer_city') ?? '';
        $customer->customer_zip = $request->input('customer_zip') ?? '';
        $customer->customer_billing_address = $request->input('customer_billing_address') ?? '';
        $customer->customer_billing_country = $request->input('customer_billing_country') ?? '';
        $customer->customer_billing_state = $request->input('customer_billing_state') ?? '';
        $customer->customer_billing_city = $request->input('customer_billing_city') ?? '';
        $customer->customer_billing_zip = $request->input('customer_billing_zip') ?? '';
        $customer->customer_primary_contact = $request->input('customer_primary_contact') ?? '';
        $customer->customer_telephone = $request->input('customer_telephone') ?? '';
        $customer->customer_extn = $request->input('customer_extn') ?? '';
        $customer->customer_email = $request->input('customer_email') ?? '';
        $customer->customer_tollfree = $request->input('customer_tollfree') ?? '';
        $customer->customer_fax = $request->input('customer_fax') ?? '';
        $customer->customer_secondary_contact = $request->input('customer_secondary_contact') ?? '';
        $customer->customer_secondary_email = $request->input('customer_secondary_email') ?? '';
        $customer->customer_billing_email = $request->input('customer_billing_email') ?? '';
        $customer->customer_billing_telephone = $request->input('customer_billing_telephone') ?? '';
        $customer->customer_billing_extn = $request->input('customer_billing_extn') ?? '';
        $customer->adv_customer_currency_Setting = $request->input('adv_customer_currency_Setting') ?? '';
        $customer->adv_customer_credit_limit = $request->input('adv_customer_credit_limit') ?? '0';
        $customer->remaining_credit = $request->input('adv_customer_credit_limit') ?? '0';
        $customer->adv_customer_payment_terms = $request->input('adv_customer_payment_terms') ?? '';
        $customer->adv_customer_factoring_company = $request->input('adv_customer_factoring_company') ?? '';
        $customer->adv_customer_webiste_url = $request->input('adv_customer_webiste_url') ?? '';
        $customer->adv_customer_duplicate = $request->input('adv_customer_duplicate') ?? '';
        $customer->adv_customer_duplicate_two = $request->input('adv_customer_duplicate_two') ?? '';
        $customer->adv_customer_internal_notes = $request->input('adv_customer_internal_notes') ?? '';
        $customer->adv_customer_payment_terms_custome = $request->input('adv_customer_payment_terms_custome') ?? '';
        $customer->customer_blacklisted = $request->input('customer_blacklisted') ?? '';
        $customer->customer_status = $request->input('customer_status') ?? '';
        $customer->customer_corporation = $request->input('customer_corporation') ?? '';
        $customer->remaining_credit_amount = $request->input('adv_customer_credit_limit') ?? '0';
        
        // print_r($customer); die;
        
            
        if ($request->hasFile('customer_file_uploads')) {
            $files = $request->file('customer_file_uploads');
            $filePaths = [];
    
            foreach ($files as $file) {
                $fileName = $customer->customer_name . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/customers/' . $customer->customer_name, $fileName, 'public');
                $filePaths[] = 'uploads/customers/' . $customer->customer_name . '/' . $fileName;
            }
    
            $customer->customer_file_upload = json_encode($filePaths);
        }
    
        // Update or create related Consignee if AddAsConsignee is checked
        if ($request->AddAsConsignee) {
            Consignee::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'consignee_name' => $request->input('customer_name') ?? '',
                    'consignee_address' => $request->input('customer_address') ?? '',
                    'consignee_country' => $request->input('customer_country') ?? '',
                    'consignee_state' => $request->input('customer_state') ?? '',
                    'consignee_city' => $request->input('customer_city') ?? '',
                    'consignee_zip' => $request->input('customer_zip') ?? '',
                    'consignee_contact_name' => $request->input('customer_primary_contact') ?? '',
                    'consignee_contact_email' => $request->input('customer_email') ?? '',
                    'consignee_telephone' => $request->input('customer_telephone') ?? '',
                    'consignee_ext' => $request->input('customer_extn') ?? '',
                    'consignee_fax' => $request->input('customer_fax') ?? '',
                    'consignee_status' => $request->input('customer_status') ?? '',
                    'consignee_internal_notes' => $request->input('adv_customer_internal_notes') ?? '',
                ]
            );
        }
    
        // Update or create related Shipper if AddAsShipper is checked
        if ($request->AddAsShipper) {
            Shipper::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'shipper_name' => $request->input('customer_name') ?? '',
                    'shipper_address' => $request->input('customer_address') ?? '',
                    'shipper_country' => $request->input('customer_country') ?? '',
                    'shipper_state' => $request->input('customer_state') ?? '',
                    'shipper_city' => $request->input('customer_city') ?? '',
                    'shipper_zip' => $request->input('customer_zip') ?? '',
                    'shipper_contact_name' => $request->input('customer_primary_contact') ?? '',
                    'shipper_contact_email' => $request->input('customer_email') ?? '',
                    'shipper_telephone' => $request->input('customer_telephone') ?? '',
                    'shipper_extn' => $request->input('customer_extn') ?? '',
                    'shipper_fax' => $request->input('customer_fax') ?? '',
                    'shipper_status' => $request->input('customer_status') ?? '',
                    'shipper_internal_notes' => $request->input('shipper_shipping_notes') ?? '',
                ]
            );
        }
    
        // Save the updated customer details
        $customer->save();
    
      return redirect()->route('customer')->with('success', 'Customer updated successfully!');
    }
    


    public function customer()
    {
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')->orderBy('name')->get();
        // echo "<pre>"; print_r($countries); die;
        $states = States::orderBy('name')->get();
        $cities = Cities::all();  
        $customers = Customer::where('user_id', auth()->user()->id)->get();     
        $customers->transform(function ($customer) {
            $loads = Load::where('customer_id', $customer->id)->get();
            $lastLoad = $loads->sortByDesc('created_at')->first();
            $customer->last_load_created_at = $lastLoad ? $lastLoad->created_at : null;
            $customer->aging_days = $lastLoad ? now()->diffInDays($lastLoad->created_at) : null;
            $totalLoadRate = $loads->sum(function ($load) {
                return (float)$load->shipper_load_final_rate;
            });
            $customer->credit_used = $totalLoadRate;
            $customer->remaining_credit = (float)$customer->adv_customer_credit_limit - $totalLoadRate;
            $customer->individual_load_rates = $loads->pluck('shipper_load_final_rate');
            return $customer;
        });
    
        
        $approvedCustomers = $customers->where('status', 'Approved');
        // print_r($approvedCustomers); die;
        return view('broker.customer', compact('countries', 'states', 'cities', 'customers', 'approvedCustomers'));
    }
    
    


    public function profile(){
        // Get the currently authenticated user
        $user = Auth::user();    
        if ($user) {
            $user->load('profileData');
            return view('broker.profile', ['user' => $user]);
        } else {
            return redirect()->route('login');
        }
    }

    public function edit()
    {
        // Fetch the currently authenticated user and related profile data
        $user = Auth::user();
        $user->load('profileData');
    
        // Pass the user data to the view
        return view('broker.profile_edit', ['user' => $user]);
    }
    

    public function update(Request $request, $id)
    {
        // Validate and update the profile data
        $request->validate([
            'employee_code' => 'required',
            'employee_bio' => 'required',
            'employee_mobile' => 'required',
            'employee_facebook' => 'required',
            'employee_linkedin' => 'required', 
        ]);
    
        $user = User::find($id);
        $user->profileData->update([
            'employee_code' => $request->input('employee_code'),
            'employee_bio' => $request->input('employee_bio'),
            'employee_mobile' => $request->input('employee_mobile'),
            'employee_facebook' => $request->input('employee_facebook'),
            'employee_linkedin' => $request->input('employee_linkedin'),
            ]);
    
        // Redirect back with a success message
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
    
    public function profile_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'adv_customer_sales_rep' => 'required',
        ]);
        $user = auth()->user();
        $yourModel = new customer();
        $yourModel->customer_status = $request->input('customer_status') ?? '';
        return redirect()->back()->with('success', 'Data has been saved!');

    }

    public function profile_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_code' => 'required',
            'employee_bio' => 'required',
            'employee_mobile' => 'required',
            'employee_facebook' => 'required',
            'employee_linkedin' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = auth()->user(); // Get the currently authenticated user
    
        // Assuming you have a relationship between User and Profile models
        $user->profileData()->create([
            'employee_code' => $request->input('employee_code'),
            'employee_bio' => $request->input('employee_bio'),
            'employee_mobile' => $request->input('employee_mobile'),
            'employee_facebook' => $request->input('employee_facebook'),
            'employee_linkedin' => $request->input('employee_linkedin'),
            // Update other fields as needed
        ]);
    
        return view('add_profile_data')->with('success', 'Data has been Saved');
    }
    
    public function encryptedCarrier($encryptedUrl)
    {
        $decryptedUrl = Crypt::decryptString($encryptedUrl); // Decrypt the encrypted URL
        // print_r($encryptedUrl); die();
        return view('broker.carrier', ['decryptedUrl' => $decryptedUrl]); // Pass the decrypted URL to the view
    }


    public function shipper(){
        $encryptedUrl = Crypt::encryptString(url()->full()); // Encrypt the current URL
        $encryptedRoute = route('encryptedShipper', ['encryptedUrl' => $encryptedUrl]); // Generate the encrypted route
        return redirect()->to($encryptedRoute); // Redirect to the encrypted route;
    }
    public function encryptedShipper($encryptedUrl)
    {
        $decryptedUrl = Crypt::decryptString($encryptedUrl); // Decrypt the encrypted URL
        return view('broker.shipper', ['decryptedUrl' => $decryptedUrl]); // Pass the decrypted URL to the view
    }
    // private function  auth(){
    //     if( $encryptedUrl){

    //         echo 'validition error';
    //     }
    //     }

    public function customerlist(){
        $fetch = Customer::all();
        $approvedCustomers = [];
        foreach ($fetch as $customer) {
            if ($customer->status === "In-Active") {
                $approvedCustomers[] = $customer;
            }
        }
        return view('broker.customer',['fetch' => $approvedCustomers]);
    }

    
    public function delete_customer($id)
    {
    $external = customer::find($id);
    if ($external) {
        $external->delete();
        return redirect()->back()->with('success', 'Row deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Row not found');
    }
    }


    public function getStatesByCountry(Request $request)
    {
        $countryId = $request->get('country_id');
        $states = States::where('country_id', $countryId)->get();
        return response()->json($states);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => 'Password updated successfully.']);
    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Confirm validation
        ]);
    
        $user = Auth::user();
    
        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'The provided password does not match our records.'], 401);
        }
    
        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Send email notification
        $this->sendPasswordChangeEmail($user->email, $user->name, $request->new_password);
    
        return response()->json(['message' => 'Password changed successfully!']);
    }
    
    // Function to send the email
    private function sendPasswordChangeEmail($email, $username, $newPassword)
    {
        $to = $email;
        $subject = "Your Password Has Been Changed";
        $message = "Hello $username,\n\nYour password has been changed successfully.\n\nYour username is: $email\nYour new password is: $newPassword\n\nIf you did not request this change, please contact support.\n\nBest regards,\nCargoconvoy Team";
        $headers = "From: no-reply@cargoconvoy.co" . "\r\n" .
                   "Reply-To: no-reply@cargoconvoy.co" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();
    
        // Send the email
        mail($to, $subject, $message, $headers);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email does not exist'], 404);
        }

        // Generate a new random password
        $newPassword = Str::random(8);
        $hashedPassword = Hash::make($newPassword);

        // Update user's password
        $user->password = $hashedPassword;
        $user->save();

        // Send the new password to the user's email
        $this->sendPasswordResetEmail($user, $newPassword);

        // return response()->json(['message' => 'A new password has been sent to your email address.']);
        return redirect()->route('password.request')->with('success', 'Email Sent Successfully');
    }

    protected function sendPasswordResetEmail($user, $newPassword)
    {
        $to = $user->email;
        $subject = "Your Password has been Reset";
        $message = "Hello " . $user->name . ",\n\nYour password has been reset. Your new password is: " . $newPassword . "\n\nPlease log in and change your password.\n\nThank you.";
        $headers = "From: no-reply@cargoconvoy.co";

        mail($to, $subject, $message, $headers);
    }

    public function updateUserDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employe_code' => 'required|string|max:255',
            'bio' => 'required|string',
            'mobile' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $user = auth()->user();
        $user->emergency_contact = $request->mobile;
        $user->bio = $request->bio;
        $user->emp_code = $request->employe_code;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User details updated successfully.']);
    }

    public function updateProfilePicture(Request $request)
    {
        $user = auth()->user();
    
        // Validate the request
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust max size as needed
        ]);
    
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = $user->username . '.' . $file->getClientOriginalExtension(); // Save with username
    
            // Store the file and get the path
            $path = $file->storeAs('public/profile_picture', $filename);
    
            // Update user profile picture path to include the relative path
            $user->profile_picture = 'profile_picture/' . $filename; // Save the relative path
            $user->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false]);
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }


}
