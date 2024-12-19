<?php

namespace App\Http\Controllers\Admin;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\CreditApprovedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\External;
use App\Models\User;
use App\Models\Load;
use App\Models\BrowserUsage;
use App\Models\Office;
use App\Models\Manger;
use App\Models\Accounts;
use App\Models\TeamLeader;
use App\Models\Shipper;
use App\Models\Consignee;
use App\Models\AdminData;
use App\Models\Country;
use App\Models\States;
use App\Models\Cities;
use App\Models\SuperAdmin;
use App\Models\AccountsAdmin;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\Svg;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Carbon\Carbon;
use App\Mail\PasswordChanged;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class AdminCustomerController extends Controller
{

    public function SuperAdminLogin(Request $req)
    {
        $submit = $req->input('submit'); // Retrieve the 'submit' value
    
        if ($submit == 'submit') {
            $req->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            // Fetch the user based on the email
            $user = SuperAdmin::where('email', $req->input('email'))->first();
    
            // Check if user exists and password is correct
            if ($user && \Hash::check($req->input('password'), $user->password)) {
                // Manually log in the user by storing user data in session
                $req->session()->put('superadmin', $user);
    
                // Redirect to the desired route
                return redirect()->route('all.load.status');
            } else {
                return redirect()->route('SuperAdminLogin')
                                 ->withErrors(['error' => 'Incorrect Username or Password']);
            }
        }
    
        return view('admin.auth.login');
    }
    

    
    public function SuperAdminLogout(Request $req)
    {
        // Clear the specific session key
        $req->session()->forget('superadmin');
        
        // Invalidate the session
        $req->session()->invalidate();
        
        // Regenerate the CSRF token
        $req->session()->regenerateToken();
        
        // Redirect to the login page
        return redirect()->route('SuperAdminLogin');
    }
    



    public function showRegistrationForm()
    {
        // Assuming you have these variables defined elsewhere in your controller
        $offices = Office::all();
        $managers = Manger::all();
        $team_leaders = TeamLeader::all();

        return view('auth.register', compact('offices', 'managers', 'team_leaders'));
    }

    public function registerUser(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'manager' => 'nullable|string|max:255',
            'team_lead' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emp_code' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
        ]);

        // Create the user
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
            'office' => $request->input('office'),
            'manager' => $request->input('manager'),
            'team_lead' => $request->input('team_lead'),
            'emergency_contact' => $request->input('emergency_contact'),
            'emp_code' => $request->input('emp_code'),
            'bio' => '',
            'profile_picture' => ''
        ]);

        // Send confirmation email
        $to = $request->input('email');
        $subject = 'Registration Successful';
        $message = 'Dear ' . $request->input('name') . ',<br><br>';
        $message .= 'Your registration was successful. Please log in with your credentials. Your Email ID is: ' . $request->input('email') . ' and your Password is: ' . $request->input('password') . ' <br><br>';
        $headers = "From: adam@cargoconvoy.co\r\n";
        $headers .= "Content-type: text/html\r\n";
        mail($to, $subject, $message, $headers);

        return redirect()->back()->with('success', 'Registration successful. Please log in.');
    }


    public function userChart(){

        $usersCount = User::count();
        $loadCount = Load::count();
        $status = Load::get();
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at',date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        $labels = [];
        $data = [];
        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#39CCCC', '#605ca8', '#2c3e50', '#b71c1c', '#00bcd4', '#4caf50'];


        for($i=1; $i <= 12; $i++){
            $month = date('F Y', mktime(0, 0, 0, $i, 1));
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
                'label' => 'Users',
                'data' => $data,
                'backgroundColor' => $colors
            ]
            ]; 



            $loads = Load::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
            $labels2 = [];
            $data2 = [];
            $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#39CCCC', '#605ca8', '#2c3e50', '#b71c1c', '#00bcd4', '#4caf50'];

        
        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;
        
            foreach ($loads as $load) {
                $get_month = $load->month;
        
                if ($get_month == $i) {
                    $count = $load->count;
                    break;
                }
            }
        
            array_push($labels2, $month);
            array_push($data2, $count);
        }
        
        $datasets2 = [
            [
                'label' => 'Load',
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
                'data' => $data2, // Corrected key here
                'backgroundColor' => $colors
            ]
        ];
        
        // return view('admin.auth.dashboard', compact('datasets', 'datasets2', 'labels', 'labels2','usersCount','loadCount'));
        return view('admin.auth.dashboard', compact('datasets', 'datasets2', 'labels', 'labels2', 'usersCount', 'loadCount','status'));

    }

    public function broker_data(Request $request)
    {
            // Get the OTP from the request (query parameter or input)
        $otp = $request->query('otp'); // You can also use $request->input('otp') if sent via POST.

        // Verify OTP (example logic; replace with actual OTP verification process)
        if (!$otp || !$this->verifyOtp($otp)) {
            // Return an error response if OTP is invalid or missing
            return response()->json(['error' => 'Invalid or missing OTP. Please verify and try again.'], 401);
        }
        $customers = Customer::orderBy('id', 'DESC')->get();
        $countries = Country::orderByRaw('CASE WHEN id = 233 THEN 0 WHEN id = 39 THEN 1 ELSE 2 END')
                            ->orderBy('name')
                            ->get();
        $states = States::orderBy('name')->get();
        $cities = Cities::all();    
        $users = User::get();
        $approvedCustomers = $customers->where('status', 'Approved');
        $external = External::orderBy('id', 'ASC')->get();
        $shipper = Shipper::select(
                        'shippers.*', 
                        'users.name as user_name',
                        'users.manager',
                        'users.team_lead'
                    )
                    ->join('users', 'shippers.user_id', '=', 'users.id')
                    ->orderBy('shippers.id', 'ASC')
                    ->get();  
        $consignee = Consignee::orderBy('id', 'ASC')->get();
        $loads = Load::orderBy('id', 'ASC')->get();
        $manager = Manger::get();
        $teamlead = TeamLeader::get();
        $office = Office::get();

        return view('admin.auth.customer_data', compact('countries', 'states', 'cities', 'customers', 'approvedCustomers', 'users', 'external', 'shipper', 'consignee', 'loads','manager','teamlead','office'));
    }

    private function verifyOtp($otp)
    {
        // Example logic: Replace this with actual OTP verification logic
        // For instance, you could check the OTP against a database record
        return $otp === 'CCI1512751'; // Replace with your actual OTP validation condition
    }

    

    public function approveCustomer($id)
{
    $customer = customer::find($id);

    if ($customer) {
        $customer->status = 'Approved';
        $customer->save();
        return response()->json(['message' => 'Customer approved successfully'], 200);
    }

    return response()->json(['message' => 'Customer not found'], 404);
}

public function delete_customer($id)
{
    try {
        $customer = customer::findOrFail($id);

        $customer->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting record: ' . $e->getMessage());
    }
}

public function editCustomer($id)
{
    $users = User::get();
    $customer = customer::find($id);

    // Query all loads for the customer
    $loads = Load::where('customer_id', $customer->id)->get();

    // Initialize variables
    $totalFinalRate = 0;
    $recordPaidAmount = 0;

    foreach ($loads as $load) {
        // Add up the shipper_load_final_rate for all loads
        $totalFinalRate += $load->shipper_load_final_rate;

        // Check for "Record Paid" status and calculate the adjustment
        if ($load->invoice_status == "Paid Record") {
            $recordPaidAmount += $load->shipper_load_final_rate;
        }
    }

    // Adjust used and remaining credit based on Record Paid loads
    $usedAmount = $totalFinalRate - $recordPaidAmount;
    $remainingCredit = $customer->credit_limit - $usedAmount;

    // print_r($remainingCredit); die;

    return view('admin.auth.edit_customer', compact('customer', 'usedAmount', 'remainingCredit', 'totalFinalRate','users'));
}


public function updateCustomer(Request $request, $id)
{
    $customer = Customer::find($id);

    $customer->update([
        'customer_name' => $request->input('customer_name'),
        'customer_address' => $request->input('customer_address'),
        'status' => $request->input('status'),
        'customer_telephone' => $request->input('customer_telephone'),
        'adv_customer_credit_limit' => $request->input('adv_customer_credit_limit'),
        'user_id' => $request->input('user_id'),
        'comment_notes' => $request->input('comment_notes')[0] ?? null,
        'commenter_name' => $request->input('commenter_name'),
        'approved_limit' => $request->input('approved_limit'),
        'remaining_credit' => $request->input('remaining_credit'),
        'remaining_credit_amount' => $request->input('remaining_credit_amount'),

    ]);
    $otp = $request->query('otp', 'CCI1512751');
    return redirect()->route('broker_data', ['otp' => $otp])->with('success', 'Customer updated successfully');
}




public function carrier_data()
{
    $external = External::orderBy('id','ASC')->get();
    return view('admin.auth.carrier_data', ['external' => $external]);
}

public function shipper_data()
{
    $shipper = Shipper::orderBy('id','ASC')->get();
    return view('admin.auth.shipper_data', ['shipper' => $shipper]);
}

public function consignee_data(){
    $consignee = Consignee::orderBy('id','ASC')->get();
    return view('admin.auth.consignee_data', ['consignee' => $consignee]);
}

public function delete_carrier_data($id)
{
    try {

        $customer = External::findOrFail($id);

        $customer->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    } catch (\Exception $e) {

        return redirect()->route('carrier.data')->back()->with('error', 'Error deleting record: ' . $e->getMessage());
    }
}



public function officeAdded(){

    $office_add = Office::get();
    return view('admin.auth.office_add',['office_add' => $office_add]);
}

public function OfficeUpdateStatus(Request $request, $id)
{
    $office = Office::find($id);

    if (!$office) {
        return response()->json(['success' => false, 'message' => 'Office not found'], 404);
    }

    $office->status = $request->input('status');
    $office->save();

    return response()->json(['success' => true, 'message' => 'Office status updated successfully'], 200);
}



public function addOffice(Request $request)
{
    
    $request->validate([
        'office_name' => 'required|string|max:255|unique:assign_offices,office_name',
    ]);

    try {
       
        Office::create([
            'office_name' => $request->office_name,
            'status' => 'Active',
        ]);

        
        return redirect()->back()->with('success', 'New Office has been added!');
    } catch (\Exception $e) {
       
        \Log::error('Error adding office: '.$e->getMessage());

        return redirect()->back()->with('error', 'There was an issue adding the new office.');
    }
}




public function updateOfficeStatus(Request $request)
{
    $office = Office::find($request->officeId);
    if ($office) {
        $office->status = $request->status;
        $office->save();
        return response()->json(['success' => 'Office status updated successfully.']);
    }
    return response()->json(['error' => 'Office not found.'], 404);
}


public function addLeader()
{
    $offices = Office::all();
    return view('admin.auth.add_leader',compact('offices'));
}

public function LeaderAdd(Request $request)
{
    // dd($request->all());
    $request->validate([
        'leader' => 'required|string|max:255',
        'leader_email' => 'required|email|max:255',
        'leader_manager' => 'required|string|max:255',
    ]);

    if ($request->Manager) {
        Manger::create([
            'leader' => $request->leader,  
            'manager' => $request->leader,
            'leader_email' => $request->leader_email,
            'leader_manager' => $request->leader_manager,
            'office' => $request->leader_office,
        ]);
    }

    if ($request->TL) {
        TeamLeader::create([
            'leader' => $request->leader,  
            'tl' => $request->leader,
            'leader_email' => $request->leader_email,
            'leader_manager' => $request->leader_manager,
            'office' => $request->leader_office,
        ]);
    }

    return redirect()->back()->with('success', 'New Leader has been added!');
}


    public function office()
    {
        $offices = Office::get();
        return view('auth.register', compact('offices'));
    }

    public function mangerdelete($id)
    {
        $manager_delete = Manger::find($id)->delete();
    
        return redirect()->back()->with('success', 'Manager deleted successfully');
    }

    public function tldelete($id)
    {
        $tl_delete = TeamLeader::find($id)->delete();
    
        return redirect()->back()->with('success', 'Team Leader deleted successfully');
    }

    public function edit_teamleader($id)
    {
        $tl = TeamLeader::find($id);
        return view('admin.auth.edit_tl', compact('tl'));
    }

    public function updatetl(Request $request, $id)
    {
        $tl = TeamLeader::find($id);

        $tl->update([
            'tl' => $request->input('team_lead'),
        ]);

        return redirect()->route('add.leader')->with('success', 'TL updated successfully');
    }


public function manager_update(Request $request, $id)
{
    $manager = Manger::find($id);

    $manager->update([
        'manager' => $request->input('manager'),
    ]);

    return redirect()->route('add.leader')->with('success', 'Manager updated successfully');
}

public function edit_manager($id)
{
    $manager = Manger::find($id);
    return view('admin.auth.edit_manager', compact('manager'));
}

public function load_data(){
    $loads = Load::with('user')->get();
    return view('admin.auth.load_data', ['loads' => $loads]);
}

public function accounting_admin()
{
    $loads = Load::where('load_status', 'Delivered')->orwhere('load_status','Delivered')->get();
    $loads_completed = Load::where('invoice_status', 'Completed')->get();
    $loads_paid = Load::where('invoice_status', 'Paid')->get();
    $loads_paid_record = Load::where('invoice_status', 'Paid Record')->get();
    $load_open = Load::where('load_status', 'Open')->get();

    return view('admin.auth.accounting',compact('loads','loads_completed','loads_paid','loads_paid_record'));
}

public function AdmineditLoadDeliveredData($id)
{
    $load = Load::find($id);

    if ($load) {
        return view('admin.auth.edit_delivery_data', compact('load'));
    }

    return abort(404);
}

public function updateLoadDeliveredData(Request $request, $id)
{
    $load = Load::find($id);

    if (!$load) {
        return redirect()->back()->with('error', 'Load not found');
    }

    $load->update([
        'load_bill_to' => $request->input('load_bill_to') ?? '',
        'load_dispatcher' => $request->input('load_dispatcher') ?? '',
        'load_status' => $request->input('load_status') ?? '',
        'load_workorder' => $request->input('load_workorder') ?? '',
        'load_payment_type' => $request->input('load_payment_type') ?? '',
        'load_type' => $request->input('load_type') ?? '',
        'load_shipper_rate' => $request->input('load_shipper_rate') ?? '',
        'load_pds' => $request->input('load_pds') ?? '',
        'load_fsc_rate' => $request->input('load_fsc_rate') ?? '',
        'load_telephone' => $request->input('load_telephone') ?? '',
        'shipper_load_other_charge' => $request->input('shipper_load_other_charge') ?? '',
        'load_carrier' => $request->input('load_carrier') ?? '',
        'load_advance_payment' => $request->input('load_advance_payment') ?? '',
        'load_type_two' => $request->input('load_type_two') ?? '',
        'load_billing_type' => $request->input('load_billing_type') ?? '',
        'load_mc_no' => $request->input('load_mc_no') ?? '',
        'load_equipment_type' => $request->input('load_equipment_type') ?? '',
        'load_carrier_fee' => $request->input('load_carrier_fee') ?? '',
        'load_currency' => $request->input('load_currency') ?? '',
        'load_pds_two' => $request->input('load_pds_two') ?? '',
        'load_billing_fsc_rate' => $request->input('load_billing_fsc_rate') ?? '',
        'load_final_carrier_fee' => $request->input('load_final_carrier_fee') ?? '',
        'load_number' =>  $request->input('load_number'),
        'load_other_change' => $request->input('load_other_change') ?? '',
        'load_final_rate' => $request->input('load_final_rate') ?? '',
        'load_other_charge' => $request->input('load_other_charge') ?? '',
        'load_shipperr' => $request->input('load_shipperr') ?? '',
        'load_shipper_location' => $request->input('load_shipper_location') ?? '',
        'load_shipper_date' => $request->input('load_shipper_date') ?? '',
        'load_shipper_discription' => $request->input('load_shipper_discription') ?? '',
        'load_shipper_commodity_type' => $request->input('load_shipper_commodity_type') ?? '',
        'load_shipper_qty' => $request->input('load_shipper_qty') ?? '',
        'load_shipper_weight' => $request->input('load_shipper_weight') ?? '',
        'load_shipper_commodity' => $request->input('load_shipper_commodity') ?? '',
        'load_shipper_value' => $request->input('load_shipper_value') ?? '',
        'load_shipper_shipping_notes' => $request->input('load_shipper_shipping_notes') ?? '',
        'load_shipper_po_numbers' => $request->input('load_shipper_po_numbers') ?? '',
        'load_consignee' => $request->input('load_consignee') ?? '',
        'load_consignee_location' => $request->input('load_consignee_location') ?? '',
        'load_consignee_date' => $request->input('load_consignee_date') ?? '',
        'load_consignee_discription' => $request->input('load_consignee_discription') ?? '',
        'load_consignee_type' => $request->input('load_consignee_type') ?? '',
        'load_consignee_qty' => $request->input('load_consignee_qty') ?? '',
        'load_consignee_weight' => $request->input('load_consignee_weight') ?? '',
        'load_consignee_commodity' => $request->input('load_consignee_commodity') ?? '',
        'load_consignee_value' => $request->input('load_consignee_value') ?? '',
        'load_consignee_delivery_notes' => $request->input('load_consignee_delivery_notes') ?? '',
        'load_consignee_po_numbers' => $request->input('load_consignee_po_numbers') ?? '',
        'load_consignee_pro_miles' => $request->input('load_consignee_pro_miles') ?? '',
        'load_consignee_empty' => $request->input('load_consignee_empty') ?? '',
        'load_shipper_contact' => $request->input('load_shipper_contact') ?? '',
        'load_shipper_appointment' => $request->input('load_shipper_appointment') ?? '',
        'load_consignee_appointment' => $request->input('load_consignee_appointment') ?? '',
        'load_consigneer_contact' => $request->input('load_consigneer_contact') ?? '',
        'load_consigneer_notes' => $request->input('load_consigneer_notes') ?? '',
        'shipper_load_final_rate' => $request->input('shipper_load_final_rate') ?? '',
    ]);

    return redirect()->back()->with('success', 'Load updated successfully');

}

public function CustomerInsertByAdmin(Request $request) {

    $yourModel = new customer();
    $yourModel->user_id = $request->input('user_id') ?? '';
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
    $yourModel->adv_customer_credit_limit =  $request->input('adv_customer_credit_limit') ?? '';
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
    $yourModel->status = 'Approved' ;
    $yourModel->comment_notes = $request->input('comment_notes') ?? '';
    $yourModel->commenter_name = $request->input('commenter_name') ?? '';


    if($request->AddAsConsignee){
        Consignee::create([
            'user_id' => $request->input('user_id') ?? '',
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
            'consignee_hours' => now()->format('Y-m-d H:i:s'),
            'consignee_appointments' => 'NA',
            'consignee_major_intersections' => 'NA',
            'consignee_status' => $request->input('customer_status') ?? '',
            'consignee_shipping_notes' => 'NA',
            'consignee_internal_notes' => $request->input('adv_customer_internal_notes') ?? '',
        ]);
    }

   if($request->AddAsShipper){
    Shipper::create([
        'user_id' => $request->input('user_id') ?? '',
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
        'shipper_internal_notes' => $request->input('adv_customer_internal_notes') ?? '',
    ]);
   }

    $yourModel->save();
    return redirect()->back()->with('success', 'Data has been saved! By Admin');


}

public function AllBrokerLoadStatus()
{
    $broker_status = Load::with('user')->get(); 

    return view('admin.auth.broker_data', ['broker_status' => $broker_status]);
}

public function admin_broker_status(){

    $status = Load::get();
    return view('admin.auth.admin_broker_status', ['status' => $status]);

}

public function ManagerDashboard(){

    $dashboard = Load::with('user')->get();
        
    $revenueResult = Load::selectRaw("SUM(shipper_load_final_rate) AS total_revenue")->first();
    $revenue = $revenueResult->total_revenue ?? 0;

    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    $salesToday = Load::where('created_at', '>=', $today->startOfDay())
        ->where('created_at', '<=', $today->endOfDay())
        ->where('invoice_status', 'Paid Record')
        ->sum('load_shipper_rate');

    $salesYesterday = Load::where('created_at', '>=', $yesterday->startOfDay())
        ->where('created_at', '<=', $yesterday->endOfDay())
        ->where('invoice_status', 'Paid Record')
        ->sum('load_shipper_rate');

    if ($salesYesterday != 0) {
        $percentIncrease = (($salesToday - $salesYesterday) / $salesYesterday) * 100;
    } else {
        $percentIncrease = 0; 
    }

    $count = Load::count();
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    $loadsTodayCount = Load::whereDate('created_at', $today)->count();
    $loadsYesterdayCount = Load::whereDate('created_at', $yesterday)->count();
    $loadsTodayMaxId = Load::whereDate('created_at', $today)->max('id');
    $loadsYesterdayMaxId = Load::whereDate('created_at', $yesterday)->max('id');
    $loadsAddedToday = ($loadsTodayMaxId ?? 0) - ($loadsYesterdayMaxId ?? 0);
    $today = Carbon::today();
    $customers = Customer::whereDate('created_at', now()->toDateString())->get();
    $shipperCountDashboard = Shipper::count();
    $carrierCountDashboard = External::count();
    $agents = User::count();

    $totalCarrierFee = Load::selectRaw("SUM(load_final_carrier_fee) AS total_revenue")->first();

    $revenueValue = $revenueResult->total_revenue ?? 0; // Default to 0 if null
    $carrierFeeValue = $totalCarrierFee->total_revenue ?? 0; // Default to 0 if null

    $finalTotal = $revenueValue - $carrierFeeValue;

    $startDate = Carbon::now()->subDays(20)->startOfDay();
    $endDate = Carbon::now()->endOfDay();
    $salesData = DB::table('load')
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(shipper_load_final_rate) as total_shipper_rate'),
                        DB::raw('SUM(load_final_carrier_fee) as total_carrier_fee')
                    )
                    ->where('cpr_check', '=', 'Verified')
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('date', 'ASC')
                    ->get();


    $yesterdayStart = Carbon::yesterday()->startOfDay();
    $yesterdayEnd = Carbon::yesterday()->endOfDay();
    
    $loadCount = Load::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
                     ->count();
    

    $newCoustmerAdded = customer::count('customer_name');

    $bestPerformance = User::select('users.id', 'users.name', DB::raw('COUNT(load.load_number) AS load_number'),
                         DB::raw('SUM(load.load_final_carrier_fee) AS total_fee'), 'load.load_status', 'load.load_final_carrier_fee')
                        ->join('load', 'users.id', '=', 'load.user_id')
                        ->where('load.created_at', '>=', now()->subYear())
                        ->groupBy('users.id', 'users.name', 'load.load_status', 'load.load_final_carrier_fee')
                        ->orderByDesc('total_fee')
                        ->orderByDesc('load.load_final_carrier_fee') // Order by margin in descending order
                        ->limit(5)
                        ->get();

    $topMaximumLoadCustomers = Load::select('load_bill_to', DB::raw('COUNT(*) AS load_count'))
    ->groupBy('load_bill_to')
    ->orderByDesc('load_count')
    ->limit(5)
    ->get();

    // Fetch all load details grouped by customer
    $customerLoads = Load::whereIn('load_bill_to', $topMaximumLoadCustomers->pluck('load_bill_to'))
        ->get()
        ->groupBy('load_bill_to');

    $totalRevenueCarrier = Load::join('users', 'load.user_id', '=', 'users.id')
    ->select('users.name')
    ->selectRaw('SUM(load.shipper_load_final_rate) AS total_revenue')
    ->selectRaw('SUM(load.load_final_carrier_fee) AS total_carrier_fee')
    ->selectRaw('SUM(load.shipper_load_final_rate - load.load_final_carrier_fee) AS revenue_difference')
    ->selectRaw('COUNT(load.id) AS load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Open" THEN 1 ELSE 0 END) AS open_load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Delivered" THEN 1 ELSE 0 END) AS delivered_load_count')
    ->selectRaw('SUM(CASE WHEN load.invoice_status = "Paid" THEN 1 ELSE 0 END) AS invoiced_load_count')
    ->selectRaw('SUM(load.load_final_carrier_fee) AS sum_load_final_carrier_fee')
    ->groupBy('users.name')
    ->get();

    $totalRevenueloadcarrier =  Load::join('users', 'load.user_id', '=', 'users.id')
    ->select('load.load_carrier', 'users.name as user_name')
    ->selectRaw('SUM(load.load_final_carrier_fee) AS total_revenue')
    ->selectRaw('SUM(load.load_final_carrier_fee - load.load_carrier_fee) AS revenue_difference')
    ->selectRaw('COUNT(load.id) AS load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Open" THEN 1 ELSE 0 END) AS open_load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Delivered" THEN 1 ELSE 0 END) AS delivered_load_count')
    ->selectRaw('SUM(CASE WHEN load.invoice_status = "Completed" THEN 1 ELSE 0 END) AS completed_load_count')
    ->groupBy('load.load_carrier', 'users.name')
    ->get();

    $totalRevenueCustomer = Load::join('users', 'load.user_id', '=', 'users.id')
    ->join('customers', 'users.id', '=', 'customers.user_id')
    ->select('load.load_bill_to', 'users.name as user_name', 'customers.adv_customer_credit_limit')
    ->selectRaw('SUM(load.shipper_load_final_rate) AS total_revenue')
    ->selectRaw('SUM(load.shipper_load_final_rate - load.load_carrier_fee) AS revenue_difference')
    ->selectRaw('COUNT(load.id) AS load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Open" THEN 1 ELSE 0 END) AS open_load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Delivered" THEN 1 ELSE 0 END) AS deliverd_load_count')
    ->selectRaw('SUM(CASE WHEN load.invoice_status = "Completed" THEN 1 ELSE 0 END) AS completed_load_count')
    ->groupBy('load.load_bill_to', 'users.name', 'customers.adv_customer_credit_limit')
    ->get();

    $get_customers = customer::get();

    $totalRevenueBroker = Load::join('users', 'load.user_id', '=', 'users.id')
    ->select('users.name')
    ->selectRaw('SUM(load.load_shipper_rate ) AS total_revenue')
    ->selectRaw('SUM(load.load_carrier_fee) AS total_carrier_fee')
    ->selectRaw('SUM(load.load_shipper_rate  - load.load_carrier_fee) AS revenue_difference')
    ->selectRaw('COUNT(load.id) AS load_count')
    ->selectRaw('SUM(CASE WHEN load.load_status = "Open" THEN 1 ELSE 0 END) AS open_load_count')
    ->groupBy('users.name')
    ->get();



    return view('admin.auth.manager_dashboard', [
        'dashboard' => $dashboard,
        'revenue' => $revenue,
        'percentIncrease' => $percentIncrease,
        'count' => $count,
        'loadsTodayCount' => $loadsTodayCount,
        'loadsYesterdayCount' => $loadsYesterdayCount,
        'loadsAddedToday' => $loadsAddedToday,
        'loadCount' => $loadCount,
        'newCoustmerAdded' => $newCoustmerAdded,
        'bestPerformance' => $bestPerformance,
        'shipperCountDashboard' => $shipperCountDashboard,
        'carrierCountDashboard' => $carrierCountDashboard,
        'topMaximumLoadCustomers' => $topMaximumLoadCustomers,
        'customerLoads' => $customerLoads,
        'finalTotal' => $finalTotal,
        'agents' => $agents,
        'salesData' =>$salesData,
        'totalRevenueCarrier' => $totalRevenueCarrier,
        'totalRevenueloadcarrier' => $totalRevenueloadcarrier,
        'totalRevenueCustomer' => $totalRevenueCustomer,
        'get_customers' => $get_customers,
        'totalRevenueBroker' => $totalRevenueBroker,
        ]);
}

public function GetUsersAll(){
    $getusers = User::orderBy('id', 'desc')->get();
    return view('admin.auth.usersget',['getusers'=>$getusers]);
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}

public function update(Request $request)
{
    $user = User::findOrFail($request->id);
   
    $user->emp_code = $request->employee_code;
    $user->name = $request->agent_name;
    $user->email  = $request->email;
    $user->address = $request->address;
    $user->office = $request->office;
    $user->manager = $request->manager;
    $user->team_lead = $request->team_leader;
    $user->emergency_contact = $request->emergency_number;
    $user->save();

    return response()->json(['success' => 'User updated successfully']);
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['success' => 'User deleted successfully']);
}




public function markAsOpen($id)
{
    $load = Load::find($id);

    if ($load) {
        $load->load_status = 'Open';
        $load->invoice_status="";
        $load->save();

        \Log::info('Marked as Open Status successfully');

        return response()->json(['success' => true, 'message' => 'Marked as Open Status successfully'], 200);
    }

    \Log::error('Load not found');

    return response()->json(['success' => false, 'message' => 'Load not found'], 404);
}

public function updateInvoiceStatusAsBackDelivered($id)
{
    $load = Load::find($id);

    if ($load) {
        $load->load_status = 'Deliverd'; // Corrected spelling
        $load->invoice_status = ''; // Set to appropriate value if needed
        $load->save();

        \Log::info('Back to Deliver successfully');

        return response()->json(['success' => true, 'message' => 'Back to Deliver successfully'], 200);
    }    

    \Log::error('Load not found');

    return response()->json(['success' => false, 'message' => 'Load not found'], 404);
}


    public function markAsBackCompleteRecord($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            $load->load_status = 'Deliverd';
            $load->invoice_status = 'Completed';
            $load->save();
    
            \Log::info('Back to Complete successfully');
    
            return response()->json(['success' => true, 'message' => 'Back to Complete successfully'], 200);
        }    
    
        \Log::error('Load not found');
    
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }
    

    public function markAsBackInvoiceRecord($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            $load->load_status = 'Deliverd';
            $load->invoice_status = 'Paid';
            $load->save();
    
            \Log::info('Back to Invoice successfully');
    
            return response()->json(['success' => true, 'message' => 'Back to Invoice successfully'], 200);
        }    
    
        \Log::error('Load not found');
    
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }


    public function AccountsLoginCreatePage(){
        return view('admin.auth.accounts_create_page');
    }

//     public function AccountsCreateLogin(Request $request){
//     $existingUser = AccountsAdmin::where('email', $request->input('email'))->first();
//     if($existingUser){
//         return redirect()->back()->with('error', 'Email Already Registered');
//     }

//     $yourModel = new AccountsAdmin();
//     $yourModel->name = $request->input('name') ?? '';
//     $yourModel->email = $request->input('email') ?? '';
//     $yourModel->password = $request->input('password') ?? '';
//     $yourModel->confirm_password = $request->input('confirm_password') ?? '';
//     $yourModel->manager = $request->input('manager') ?? '';
//     $yourModel->team_lead = $request->input('team_lead') ?? '';
//     $yourModel->role = $request->input('role') ?? '';
//     // print_r($yourMode); die();
//     $yourModel->save();

//     return redirect()->back()->with('success', 'Data has been saved!');
// }
    
public function AccountsCreateLogin(Request $request) {
    $existingUser = AccountsAdmin::where('email', $request->input('email'))->first();
    if ($existingUser) {
        return redirect()->back()->with('error', 'Email Already Registered');
    }

    $yourModel = new AccountsAdmin();
    $yourModel->name = $request->input('name') ?? '';
    $yourModel->email = $request->input('email') ?? '';
    $yourModel->password = $request->input('password') ?? '';
    $yourModel->confirm_password = $request->input('confirm_password') ?? '';
    $yourModel->manager = $request->input('manager') ?? '';
    $yourModel->team_lead = $request->input('team_lead') ?? '';
    $yourModel->role = $request->input('role') ?? '';
    // echo "<pre>"; print_r($yourModel); die;
    $yourModel->save();

    // Send email
    $to = $request->input('email');
    $subject = "Accounts Login Credentials";
    $message = "
    <html>
    <head>
    <title>Accounts Login Credentials</title>
    </head>
    <body>
    <p>Dear " . htmlspecialchars($request->input('name')) . ",</p>
    <p>Your account has been created successfully. Please click the link below to login:</p>
    <p><a href='https://crmcargoconvoy.co/account-login'>Login to your account</a></p>
    <p>Username: " . htmlspecialchars($request->input('email')) . "</p>
    <p>Password: " . htmlspecialchars($request->input('password')) . "</p>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= 'From: noreply@yourdomain.com' . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        return redirect()->back()->with('success', 'Data has been saved and email sent!');
    } else {
        return redirect()->back()->with('success', 'Data has been saved, but email could not be sent.');
    }
}


public function AdminEditLoad($id)
{
    $loads = Load::where('load_status', 'Delivered')->with('user')->get();
    $loads_completed = Load::where('invoice_status', 'Completed')->get();
    $loads_paid = Load::where('invoice_status', 'Paid')->get();
    $loads_paid_record = Load::where('invoice_status', 'Paid Record')->get();
    $allCustomers = customer::get();
    $load = Load::find($id);
    $post = Load::find($id);
    $consignee = Consignee::get();

    if (!$load) {
        return redirect()->back()->with('error', 'Load not found.');
    }

    return view('admin.auth.adminupdateload', compact('loads', 'loads_completed', 'loads_paid', 'loads_paid_record', 'load','post','allCustomers','consignee'));
}


    // Method to update data based on form submission
    public function AdminUpdateLoad(Request $request, $id)
    {
        // dd($request->all());
         // Find the load instance
         $load = Load::find($id);
    
         // Handle shipper data
         $shipper_name = [];
         $shipper_location = [];
         $shipper_appointment = [];
         $shipper_description = [];
         $shipper_commodity_type = [];
         $shipper_commodity_name = [];
         $shipper_qty = [];
         $shipper_weight = [];
         $shipper_value = [];
         $shipper_note = [];
         $shipper_po_number = [];
         $shipper_contact = [];
 
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper{$i}")) {
                 $shipper = [
                     'name' => $request->input("load_shipper{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['name'])) {
                     $shipper_name[] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_location{$i}")) {
                 $shipper = [
                     'location' => $request->input("load_shipper_location{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['location'])) {
                     $shipper_location[] = $shipper;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_appointment{$i}")) {
                 $shipper = [
                     'appointment' => $request->input("load_shipper_appointment{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['appointment'])) {
                     $shipper_appointment [] = $shipper;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_description{$i}")) {
                 $shipper = [
                     'description' => $request->input("load_shipper_description{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['description'])) {
                     $shipper_description [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_commodity_type{$i}")) {
                 $shipper = [
                     'commodity_type' => $request->input("load_shipper_commodity_type{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['commodity_type'])) {
                     $shipper_commodity_type [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_commodity{$i}")) {
                 $shipper = [
                     'commodity_name' => $request->input("load_shipper_commodity{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['commodity_name'])) {
                     $shipper_commodity_name [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_qty{$i}")) {
                 $shipper = [
                     'shipper_qty' => $request->input("load_shipper_qty{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipper_qty'])) {
                     $shipper_qty [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_weight{$i}")) {
                 $shipper = [
                     'shipper_weight' => $request->input("load_shipper_weight{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipper_weight'])) {
                     $shipper_weight [] = $shipper;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_value{$i}")) {
                 $shipper = [
                     'shipper_value' => $request->input("load_shipper_value{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipper_value'])) {
                     $shipper_value [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_shipping_notes{$i}")) {
                 $shipper = [
                     'shipping_notes' => $request->input("load_shipper_shipping_notes{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipping_notes'])) {
                     $shipper_note [] = $shipper;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_po_numbers{$i}")) {
                 $shipper = [
                     'shipping_po_numbers' => $request->input("load_shipper_po_numbers{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipping_po_numbers'])) {
                     $shipper_po_number [] = $shipper;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 shippers based on your form
             if ($request->has("load_shipper_contact{$i}")) {
                 $shipper = [
                     'shipping_contact' => $request->input("load_shipper_contact{$i}"),
                 ];
     
                 // Add shipper data to array if name is not null
                 if (!empty($shipper['shipping_contact'])) {
                     $shipper_contact [] = $shipper;
                 }
             }
         }
     
         // Handle consignee dataaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
         $consignee_name = [];
         $consignee_location = [];
         $load_consignee_appointment = [];
         $consignee_description = [];
         $load_consignee_type = [];
         $consignee_commodity_name = [];
         $consignee_qty = [];
         $consignee_weight = [];
         $consignee_value = [];
         $consignee_note = [];
         $consignee_po_number = [];
         $consignee_contact = [];
         $consignee_delivery_note = [];
         $load_consignee_commodity = [];
         $load_consigneer_contact = [];
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_{$i}")) {
                 $consignee = [
                     'name' => $request->input("load_consignee_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['name'])) {
                     $consignee_name [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_location_{$i}")) {
                 $consignee = [
                     'location' => $request->input("load_consignee_location_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['location'])) {
                     $consignee_location [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_appointment_{$i}")) {
                 $consignee = [
                     'appointment' => $request->input("load_consignee_appointment_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['appointment'])) {
                     $load_consignee_appointment [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_discription_{$i}")) {
                 $consignee = [
                     'description' => $request->input("load_consignee_discription_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['description'])) {
                     $consignee_description [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_commodity_{$i}")) {
                 $consignee = [
                     'consignee_commodity' => $request->input("load_consignee_commodity_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_commodity'])) {
                     $load_consignee_commodity [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_type_{$i}")) {
                 $consignee = [
                     'consignee_type' => $request->input("load_consignee_type_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_type'])) {
                     $load_consignee_type [] = $consignee;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_qty_{$i}")) {
                 $consignee = [
                     'consignee_qty' => $request->input("load_consignee_qty_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_qty'])) {
                     $consignee_qty [] = $consignee;
                 }
             }
         }
 
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_weight_{$i}")) {
                 $consignee = [
                     'consignee_weight' => $request->input("load_consignee_weight_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_weight'])) {
                     $consignee_weight [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_value_{$i}")) {
                 $consignee = [
                     'consignee_value' => $request->input("load_consignee_value_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_value'])) {
                     $consignee_value [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consigneer_notes_{$i}")) {
                 $consignee = [
                     'consignee_notes' => $request->input("load_consigneer_notes_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_notes'])) {
                     $consignee_note [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_po_numbers_{$i}")) {
                 $consignee = [
                     'consignee_po_number' => $request->input("load_consignee_po_numbers_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_po_number'])) {
                     $consignee_po_number [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consigneer_contact_{$i}")) {
                 $consignee = [
                     'consignee_contact' => $request->input("load_consigneer_contact_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_contact'])) {
                     $load_consigneer_contact [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
             if ($request->has("load_consignee_delivery_notes_{$i}")) {
                 $consignee = [
                     'consignee_delivery_notes' => $request->input("load_consignee_delivery_notes_{$i}"),
                 ];
     
                 // Add consignee data to array if name is not null
                 if (!empty($consignee['consignee_delivery_notes'])) {
                     $consignee_delivery_note  [] = $consignee;
                 }
             }
         }
 
         for ($i = 1; $i <= 15; $i++) {
             // Check if the form input for consignee note exists
             if ($request->has("load_consignee_notes_{$i}")) {
                 // Get the consignee note value from the request
                 $note = $request->input("load_consignee_notes_{$i}");
         
                 // Add consignee note to array if not empty
                 if (!empty($note)) {
                     $consignee_note[] = ['load_consignee_notes' => $note];
                 }
             }
         }
 
     
         $load->load_shipperr = json_encode($shipper_name);
         $load->load_shipper_location = json_encode($shipper_location);
         $load->load_shipper_discription = json_encode($shipper_description);
         $load->load_shipper_commodity_type = json_encode($shipper_commodity_type);
         $load->load_shipper_qty = json_encode($shipper_qty);
         $load->load_shipper_weight = json_encode($shipper_weight);
         $load->load_shipper_commodity = json_encode($shipper_commodity_name);
         $load->load_shipper_value = json_encode($shipper_value);
         $load->load_shipper_shipping_notes = json_encode($shipper_note);
         $load->load_shipper_po_numbers = json_encode($shipper_po_number);
         $load->load_shipper_contact = json_encode($shipper_contact);
         $load->load_shipper_appointment = json_encode($shipper_appointment);
     
         $load->load_consignee = json_encode($consignee_name);
         $load->load_consignee_location = json_encode($consignee_location);
         $load->load_consignee_appointment = json_encode($load_consignee_appointment);
         $load->load_consignee_discription = json_encode($consignee_description);
         $load->load_consignee_type = json_encode($load_consignee_type);
         $load->load_consignee_commodity = json_encode($load_consignee_commodity);
         $load->load_consignee_qty = json_encode($consignee_qty);
         $load->load_consignee_weight = json_encode($consignee_weight);
         $load->load_consignee_value = json_encode($consignee_value);
         $load->load_consigneer_notes = json_encode($consignee_note);
         $load->load_consignee_po_numbers = json_encode($consignee_po_number);
         $load->load_consigneer_contact = json_encode($load_consigneer_contact);
         $load->load_consignee_delivery_notes = json_encode($consignee_delivery_note);
         $load->load_consignee_appointment = json_encode($load_consignee_appointment);
 
 
         $load->load_bill_to = $request->input('load_bill_to', null);
         $load->load_dispatcher = $request->input('load_dispatcher') ?? '';
         $load->load_status = $request->input('load_status') ?? '';
         $load->load_workorder = $request->input('load_workorder') ?? '';
         $load->load_payment_type = $request->input('load_payment_type') ?? '';
         $load->load_type = $request->input('load_type') ?? '';
         $load->load_shipper_rate = $request->input('load_shipper_rate') ?? '';
         $load->load_pds = $request->input('load_pds') ?? '';
         $load->load_fsc_rate = $request->input('load_fsc_rate') ?? '';
         $load->load_telephone = $request->input('load_telephone') ?? '';
         $load->shipper_load_other_charge = $request->input('shipper_load_other_charge') ?? '';
         $load->load_carrier = $request->input('load_carrier') ?? '';
         $load->load_carrier_phone = $request->input('load_carrier_phone') ?? '';
         $load->load_advance_payment = $request->input('load_advance_payment') ?? '';
         $load->load_type_two = $request->input('load_type_two') ?? '';
         $load->load_billing_type = $request->input('load_billing_type') ?? '';
         $load->load_mc_no = $request->input('load_mc_no') ?? '';
         $load->load_equipment_type = $request->input('load_equipment_type') ?? '';
         $load->load_carrier_fee = $request->input('load_carrier_fee') ?? '';
         $load->load_currency = $request->input('load_currency') ?? '';
         $load->load_pds_two = $request->input('load_pds_two') ?? '';
         $load->load_billing_fsc_rate = $request->input('load_billing_fsc_rate') ?? '';
         $load->load_final_carrier_fee = $request->input('load_final_carrier_fee') ?? '';
         $load->load_final_rate = $request->input('shipper_load_final_rate') ?? '';
         $load->load_other_charge = $request->input('load_other_charge') ?? '';
         $load->shipper_load_final_rate = $request->input('shipper_load_final_rate') ?? '';
 
         $load->shipper_load_final_rate = $request->input('shipper_load_final_rate') ?? '';
         $load->customer_id = $request->input('customer_id') ?? '';
         $load->comment = $request->input('comment') ?? '';
         $load->invoice_number = '';
         $load->invoice_date = '0000-00-00';
         $load->load_carrier_due_date = '';
         $load->carrier_mark_as_paid = '';
         $load->carrierDoc = '';
         $load->quick_pay = '';
         $load->payment_method = '';
         $load->ready_to_pay = '';
         $load->customer_refrence_number = $request->input('customer_refrence_number') ?? '';
         $load->carrier_dot = $request->input('carrier_dot') ?? '';
         $load->invoicing_payment_terms = $request->input('invoicing_payment_terms') ?? '';
 
         // Initialize shipperCharges array
         $shipperCharges = [];
         if ($request->has('shipperchargeType') && $request->has('shipperchargeAmount')) {
             foreach ($request->shipperchargeType as $index => $chargeType) {
                 $chargeAmount = $request->shipperchargeAmount[$index] ?? null;
                 if ($chargeAmount !== null) {
                     $shipperCharges[] = [
                         'type' => $chargeType,
                         'amount' => $chargeAmount,
                     ];
                 }
             }
         }
         
         // Initialize carrierCharges array
         $carrierCharges = [];
         if ($request->has('shipper_type_charge') && $request->has('shipper_other_charge')) {
             foreach ($request->shipper_type_charge as $index => $carrierchargeType) {
                 $carrierchargeAmount = $request->shipper_other_charge[$index] ?? null;
                 if ($carrierchargeAmount !== null) {
                     $carrierCharges[] = [
                         'type' => $carrierchargeType,
                         'amount' => $carrierchargeAmount,
                     ];
                 }
             }
         }
         
         $load->carrier_load_other_charge = json_encode($carrierCharges);
         $load->shipper_load_other_charge = json_encode($shipperCharges);
 
         
         if ($request->hasFile('load_delivery_do_file')) {
             $file = $request->file('load_delivery_do_file');
             if ($file->isValid()) {
                 $filename = $request->input('load_bill_to') . '.' . $file->getClientOriginalExtension();
                 $path = $file->storeAs('public/upload/delivery-order', $filename);
                 $load->load_delivery_do_file = 'upload/delivery-order/' . $filename; // Save the relative path
                 $load->save();
             } else {
                 return back()->withErrors(['load_delivery_do_file' => 'Uploaded file is not valid.']);
             }
         }
         
 
         
        
     // echo "<pre>"; print_r($load); die();
         $load->save();
     
         // Return success response
         // return response()->json(['message' => 'Load updated successfully']);
         return redirect()->back()->with('success', 'Load status updated successfully');
 
     } 
 

    public function adminRcDownload($id)
    {
        // Fetch the load based on the provided id
        $load = Load::find($id);
    
        // Check if $load is found
        if (!$load) {
            abort(404, 'Load not found.');
        }
    
        // Consolidate consignee data
        $consigneeData = [
            'load_consignee' => $load->load_consignee,
            'load_consignee_location' => $load->load_consignee_location,
            'load_consignee_date' => $load->load_consignee_date,
            'load_consignee_discription' => $load->load_consignee_discription,
            'load_consignee_type' => $load->load_consignee_type,
            'load_consignee_qty' => $load->load_consignee_qty,
            'load_consignee_weight' => $load->load_consignee_weight,
            'load_consignee_commodity' => $load->load_consignee_commodity,
            'load_consignee_value' => $load->load_consignee_value,
            'load_consignee_delivery_notes' => $load->load_consignee_delivery_notes,
            'load_consignee_po_numbers' => $load->load_consignee_po_numbers,
            'load_consignee_appointment' => $load->load_consignee_appointment
        ];
    
        // Prepare shipper data
        $shipperData = [
            'load_shipperr' => $load->load_shipperr,
            'load_shipper_location' => $load->load_shipper_location,
            'load_shipper_date' => $load->load_shipper_date,
            'load_shipper_discription' => $load->load_shipper_discription,
            'load_shipper_commodity_type' => $load->load_shipper_commodity_type,
            'load_shipper_qty' => $load->load_shipper_qty,
            'load_shipper_weight' => $load->load_shipper_weight,
            'load_shipper_commodity' => $load->load_shipper_commodity,
            'load_shipper_value' => $load->load_shipper_value,
            'load_shipper_shipping_notes' => $load->load_shipper_shipping_notes,
            'load_shipper_po_numbers' => $load->load_shipper_po_numbers,
            'load_shipper_contact' => $load->load_shipper_contact,
            'load_shipper_appointment' => $load->load_shipper_appointment
        ];
    
        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);
    
        // Pass title and other data to the view
        $view = view('broker.invoice_html', compact('load', 'consigneeData', 'shipperData'))->render();
    
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
    
        // Get the load number for the filename
        $filename = 'Load No - ' . $load->load_number . '.pdf';
    
        // Stream the PDF to the browser for preview
        return $pdf->stream($filename, ['Attachment' => false]);
    }

    public function adminShipperRcDownload($id)
    {
        // Fetch the load based on the provided id
        $load = Load::find($id);
    
        // Check if $load is found
        if (!$load) {
            abort(404, 'Load not found.');
        }
    
        // Consolidate consignee data
        $consigneeData = [
            'load_consignee' => $load->load_consignee,
            'load_consignee_location' => $load->load_consignee_location,
            'load_consignee_date' => $load->load_consignee_date,
            'load_consignee_discription' => $load->load_consignee_discription,
            'load_consignee_type' => $load->load_consignee_type,
            'load_consignee_qty' => $load->load_consignee_qty,
            'load_consignee_weight' => $load->load_consignee_weight,
            'load_consignee_commodity' => $load->load_consignee_commodity,
            'load_consignee_value' => $load->load_consignee_value,
            'load_consignee_delivery_notes' => $load->load_consignee_delivery_notes,
            'load_consignee_po_numbers' => $load->load_consignee_po_numbers,
            'load_consignee_appointment' => $load->load_consignee_appointment
        ];
    
        // Prepare shipper data
        $shipperData = [
            'load_shipperr' => $load->load_shipperr,
            'load_shipper_location' => $load->load_shipper_location,
            'load_shipper_date' => $load->load_shipper_date,
            'load_shipper_discription' => $load->load_shipper_discription,
            'load_shipper_commodity_type' => $load->load_shipper_commodity_type,
            'load_shipper_qty' => $load->load_shipper_qty,
            'load_shipper_weight' => $load->load_shipper_weight,
            'load_shipper_commodity' => $load->load_shipper_commodity,
            'load_shipper_value' => $load->load_shipper_value,
            'load_shipper_shipping_notes' => $load->load_shipper_shipping_notes,
            'load_shipper_po_numbers' => $load->load_shipper_po_numbers,
            'load_shipper_contact' => $load->load_shipper_contact,
            'load_shipper_appointment' => $load->load_shipper_appointment
        ];
    
        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);
    
        // Pass title and other data to the view
        $view = view('broker.shipper_rc', compact('load', 'consigneeData', 'shipperData'))->render();
    
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
    
        // Get the load number for the filename
        $filename = 'Load No - ' . $load->load_number . '.pdf';
    
        // Stream the PDF to the browser for preview
        return $pdf->stream($filename, ['Attachment' => false]);
    }

// OfficeController.php
public function officeDestroy($id)
{
    $office = Office::findOrFail($id);
    $office->delete();

    return redirect()->back()->with('success', 'Office deleted successfully.');
}


public function mangerDestroy($id)
{
    $manager = Manger::findOrFail($id);
    $manager->delete();

    return redirect()->back()->with('success', 'Manager deleted successfully.');
}


public function teamleadDestroy($id)
{
    $teamLeader = TeamLeader::findOrFail($id);
    $teamLeader->delete();

    return redirect()->back()->with('success', 'Team Leader deleted successfully.');
}

public function getManager($id)
{
    $manager = Manger::findOrFail($id);
    return response()->json($manager);
}


public function updateManager(Request $request)
{
    $manager = Manger::findOrFail($request->id);
    $manager->update([
        'manager' => $request->manager_name,
        'leader_email' => $request->manager_email,
        'leader_manager' => $request->leader_main_manager,
        'office' => $request->manager_office,
    ]);

    return response()->json(['success' => true]);
}

public function getTeamLeader($id)
{
    $manager = TeamLeader::findOrFail($id);
    return response()->json($manager);
}


public function updateTeamLeader(Request $request)
{
    $manager = TeamLeader::findOrFail($request->id);
    $manager->update([
        'tl' => $request->tl_name,
        'leader_email' => $request->tl_email,
        'leader_manager' => $request->tl_main_manager,
        'office' => $request->tl_office,
    ]);

    return response()->json(['success' => true]);
}


public function getOffices($id)
{
    $office = Office::findOrFail($id);
    return response()->json($office);
}

public function updateOffices(Request $request, $id)
{
    $office = Office::findOrFail($id);
    $office->update([
        'office_name' => $request->office,
        'status' => $request->office_status,
    ]);

    return response()->json(['success' => true]);
}


public function getAccountUser()
{
    $getAccountsUser = DB::table('accountslogin')
        ->orderByRaw("CASE 
            WHEN role = 'Master Admin' THEN 1 
            WHEN role = 'Admin' THEN 2 
            WHEN role = 'Accounts' THEN 3 
            WHEN role = 'Compliance' THEN 4 
            ELSE 5 
        END")
        ->get();

    return view('admin.auth.admin_get_accounts_user', compact('getAccountsUser'));
}



public function accountUserEdit($id)
{
    $account = Accounts::findOrFail($id);
    return response()->json($account);
}

public function accountUserUpdate(Request $request)
{
    $account = Accounts::findOrFail($request->id);
    $account->name = $request->username;
    $account->password = $request->password; // Encrypt the password
    $account->manager = $request->manager;
    $account->team_lead = $request->team_lead;
    $account->role = $request->role;
    $account->save();

    return response()->json(['success' => true]);
}

public function accountUserDelete($id)
{
    $account = Accounts::findOrFail($id);
    $account->delete();

    return response()->json(['success' => true]);
}


public function accountsCompliance()
{
    $carrier = External::orderBy('id', 'DESC')->get();
    $loads = Load::orderBy('id','DESC')->get();
    return view('admin.auth.accountscompliance', compact('carrier','loads'));
}

public function accountsvendorManagement(){
    $vendormanagement = Load:: get();
    return view('admin.auth.vendormanagement',compact('vendormanagement'));
}

public function adminDestroyLoad($id)
{
    try {
        $load = Load::findOrFail($id);
        $load->delete();

        return redirect()->back()->with('success', 'Load deleted from Admin successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting load: ' . $e->getMessage());
    }
}

public function destroyCustomer($id)
{
    $customer = Customer::find($id);
    if (!$customer) {
        return response()->json(['error' => 'Customer not found.'], 404);
    }
    $customer->delete();
    return response()->json(['success' => 'Customer deleted successfully.']);
}


public function destroyCarrier($id)
{
    $carrier = External::find($id);
    if (!$carrier) {
        return response()->json(['error' => 'Carrier not found.'], 404);
    }
    $carrier->delete();
    return response()->json(['success' => 'Carrier deleted successfully.']);
}

public function itsData()
{
    $its = DB::select("SELECT * FROM load_bkp");
    return view('admin.auth.its_data',compact('its'));
}


public function consignee_edit($id)
{
    // Fetch the consignee data by ID
    $consignee = Consignee::findOrFail($id);
    $countries = Country::get();
    $states    = States::get();
    // Pass the consignee data to the edit view
    return view('admin.auth.consignee_edit', compact('consignee','countries','states'));
}

public function consignee_update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'consignee_name' => 'required|string|max:255',
        'consignee_address' => 'nullable|string',
        'consignee_country' => 'nullable|string',
        'consignee_state' => 'nullable|string',
        'consignee_city' => 'nullable|string',
        'consignee_zip' => 'nullable|string',
        'consignee_contact_name' => 'nullable|string',
        'consignee_contact_email' => 'nullable|email',
        'consignee_telephone' => 'nullable|string',
        'consignee_ext' => 'nullable|string',
        'consignee_toll_free' => 'nullable|string',
        'consignee_fax' => 'nullable|string',
        'consignee_hours' => 'nullable|string',
        'consignee_appointments' => 'nullable|string',
        'consignee_major_intersections' => 'nullable|string',
        'consignee_status' => 'nullable|string',
        'consignee_shipping_notes' => 'nullable|string',
        'consignee_internal_notes' => 'nullable|string',
        'consignee_add_shippper' => 'nullable|boolean',
    ]);

    // Find the consignee by ID
    $consignee = Consignee::findOrFail($id);

    // Update consignee data
    $consignee->update($request->only([
        'consignee_name', 'consignee_address', 'consignee_country', 'consignee_state', 'consignee_city', 'consignee_zip',
        'consignee_contact_name', 'consignee_contact_email', 'consignee_telephone', 'consignee_ext', 'consignee_toll_free',
        'consignee_fax', 'consignee_hours', 'consignee_appointments', 'consignee_major_intersections',
        'consignee_status', 'consignee_shipping_notes', 'consignee_internal_notes'
    ]));

    // Handle "Add as Shipper" checkbox
    if ($request->input('consignee_add_shippper')) {
        $shipper = Shipper::where('consignee_id', $consignee->id)->first();

        $shipperData = [
            'shipper_name' => $request->input('consignee_name'),
            'shipper_address' => $request->input('consignee_address'),
            'shipper_country' => $request->input('consignee_country'),
            'shipper_state' => $request->input('consignee_state'),
            'shipper_city' => $request->input('consignee_city'),
            'shipper_zip' => $request->input('consignee_zip'),
            'shipper_contact_name' => $request->input('consignee_contact_name'),
            'shipper_contact_email' => $request->input('consignee_contact_email'),
            'shipper_telephone' => $request->input('consignee_telephone'),
            'shipper_extn' => $request->input('consignee_ext'),
            'shipper_toll_free' => $request->input('consignee_toll_free'),
            'shipper_fax' => $request->input('consignee_fax'),
            'shipper_hours' => $request->input('consignee_hours'),
            'shipper_appointments' => $request->input('consignee_appointments'),
            'shipper_major_intersections' => $request->input('consignee_major_intersections'),
            'shipper_status' => $request->input('consignee_status'),
            'shipper_shipping_notes' => $request->input('consignee_shipping_notes'),
            'shipper_internal_notes' => $request->input('consignee_internal_notes'),
            'user_id' => auth()->id()
        ];

        if ($shipper) {
            // Update existing shipper
            $shipper->update($shipperData);
        } else {
            // Create new shipper if none exists
            Shipper::create($shipperData);
        }
    }

    // Redirect to consignee index or anywhere appropriate with success message
    return redirect()->back()->with('success', 'Consignee updated successfully!');
}

public function changePassword(Request $request)
{
    // Get the currently authenticated user
    $user = auth()->user();

    // Generate a new password
    $newPassword = Str::random(10); // You can change the length of the password

    // Update the user's password in the database
    $user->password = Hash::make($newPassword);
    $user->save();

    // Send email with the new password using core PHP (PHPMailer)
    $this->sendPasswordChangedEmail($user, $newPassword);

    // Return a response
    return response()->json(['status' => 'success']);
}

private function sendPasswordChangedEmail($user, $newPassword)
{
    // Use PHPMailer to send the email
    require 'path/to/PHPMailer/PHPMailer.php';
    require 'path/to/PHPMailer/Exception.php';
    require 'path/to/PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.yourmailserver.com'; // Set your SMTP server here
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // SMTP username
        $mail->Password = 'your_email_password'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('your_email@example.com', 'Your CRM');
        $mail->addAddress($user->email); // User email

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Password Has Been Changed';
        $mail->Body    = "
            <h1>Your Password Has Been Changed</h1>
            <p>Hello, <strong>{$user->email}</strong></p>
            <p>Your password has been successfully changed.</p>
            <p>Your new password is: <strong>{$newPassword}</strong></p>
            <p>Kind regards,<br>Your CRM Team</p>
        ";

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

public function getCustomersData(Request $request)
{
    $query = Customer::query();

    // Apply date range filter
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('created_at', [
            \Carbon\Carbon::parse($request->start_date)->startOfDay(),
            \Carbon\Carbon::parse($request->end_date)->endOfDay(),
        ]);
    }

    // Apply manager filter
    if ($request->manager) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('manager', $request->manager);
        });
    }

    // Apply team lead filter
    if ($request->team_lead) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('team_lead', $request->team_lead);
        });
    }

    // Apply office filter
    if ($request->office) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('office', $request->office);
        });
    }

    $customers = $query->get();

    return response()->json(['data' => $customers]);
}


}
