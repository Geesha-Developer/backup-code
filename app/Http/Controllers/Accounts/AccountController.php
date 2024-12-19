<?php

namespace App\Http\Controllers\Accounts;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountsAdmin;
use App\Models\Load;
use App\Models\customer;
use App\Models\Shipper;
use App\Models\Country;
use App\Models\States;
use App\Models\Consignee;
use Carbon\Carbon;
use App\Models\External;
use App\Models\User;
use App\Models\Manger;
use App\Models\TeamLeader;
use App\Models\Office;
use App\Models\InvoicesEmail;
use App\Mail\CustomMail;
use TCPDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Mail\InvoiceMail;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Mime\Part\HtmlPart;
use Symfony\Component\Mime\Part\Attachment;


class AccountController extends Controller
{
    public function AccountLogin()
    {
        return view('accounts.login');
    }

    public function authenticate(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the user from the accountslogin table
        $user = AccountsAdmin::where('email', $request->email)->first();

        // Check if user exists and passwords match
        if ($user && $user->password === $request->password) {
            // Store user info in session
            Session::put('user', $user);
            // Redirect to accounts route
            return redirect()->route('accounts');
        }

        // If authentication fails, set flash message
        return redirect()->route('login')->with('success', 'Load updated successfully');
    }
    
    public function AccountLogout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
    

    public function AccountAdminDashboard(){
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
    
    
    

        return view('accounts.dashboard', [
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
        ]);
    }

    public function accounting(){
        $loads = Load::with('user')->orderBy('id', 'DESC')->get();
        $loads_completed = Load::with('user')->where('invoice_status', 'Completed')->get();
        $loads_paid = Load::with('user')->where('invoice_status', 'Paid')->get();
        $loads_paid_record = Load::with('user')->where('invoice_status', 'Paid Record')->get();
        $manager = Manger::get();
        $teamlead = TeamLeader::get();
        $office = Office::get();
        $customers = customer::get();
        return view('accounts.accounting', compact('loads','loads_completed','loads_paid','loads_paid_record','manager','teamlead','office','customers'));
    }
    

    public function updateInvoiceStatus($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            if ($load->invoice_status === 'Paid') {
                return response()->json(['message' => 'Load is already marked as Paid'], 400);
            }
    
            if (!$load->invoice_number) {
                // Generate a new invoice number starting from 2000
                $lastInvoice = Load::whereNotNull('invoice_number')->orderBy('invoice_number', 'desc')->first();
                $lastInvoiceNumber = $lastInvoice ? intval($lastInvoice->invoice_number) : 7999; // Use 1999 so that the first number is 2000
                $newInvoiceNumber = $lastInvoiceNumber + 1;
                $load->invoice_number = $newInvoiceNumber;
            }
    
            $load->invoice_status = 'Paid';
            $load->invoice_date = now();
            $load->save();
    
            return response()->json([
                'message' => 'Marked as Paid successfully',
                'invoice_number' => $load->invoice_number,
                'invoice_date' => $load->invoice_date, // Include invoice date in the response
            ], 200);
        }
    
        return response()->json(['message' => 'Load not found'], 404);
    }
    
    


    public function updateInvoiceStatusAsCompleted($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            $load->invoice_status = 'Completed';
            $load->save();
    
            \Log::info('Marked as Completed successfully'); // Add this line
    
            return response()->json(['message' => 'Marked as Completed successfully'], 200);
        }
    
        \Log::error('Load not found'); // Add this line
    
        return response()->json(['message' => 'Load not found'], 404);
    }

    public function markInvoiceAsPaid($id)
    {
        $load = Load::find($id);

        if ($load) {
            $load->invoice_status = 'Paid';
            $load->save();

            \Log::info('Marked as Paid successfully'); // Add this line

            return response()->json(['message' => 'Marked as Paid successfully'], 200);
        }

        \Log::error('Load not found'); // Add this line

        return response()->json(['message' => 'Load not found'], 404);
    }
    
    public function updateInvoiceStatusAsPaidRecord($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            $load->invoice_status = 'Paid Record';
            $load->invoice_status_date = now()->format('Y-m-d H:i:s');
            $load->save();
    
            \Log::info('Marked as Paid Record successfully');
    
            return response()->json(['success' => true, 'message' => 'Marked as Paid Record successfully'], 200);
        }
    
        \Log::error('Load not found');
    
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }
    
    


    public function editLoadDeliveredData($id)
    {
        $load = Load::find($id);

        if ($load) {
            return view('accounts.accounting', compact('load'));
        }

        return abort(404);
    }

    public function updateLoadDeliveredData(Request $request, $id)
    {
        $load = Load::find($id);

        if (!$load) {
            return redirect()->route('accounts')->with('error', 'Load not found');
        }

        $load = Load::findOrFail($id);

        // Get the ID of the Load instance
        $loadId = $load->id;
    
        $load->update([
            'load_bill_to' => $request->input('load_bill_to'),
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
            'load_number' =>  $loadId,
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
            'comment' => $request->input('comment') ?? '',
        ]);


        return redirect()->route('accounts')->with('success', 'Load updated successfully');
    
}

public function accounts_broker_status(){

    $status = Load::get();
    // print_r($status); die;

    return view('accounts.admin_broker_status', ['status' => $status]);

}

public function AccountsManagerDashboard(){

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



    return view('accounts.manager_dashboard', [
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

public function fetchCustomerDetailsAccount(Request $request) {
    $query = $request->input('query');
    $customersName = customer::where('customer_name', 'like', '%' . $query . '%')->distinct()->pluck('customer_name');
    return $customersName->toJson();
}


// public function fetchShipperDetailsAccounts(Request $request) {
//     $query = $request->input('query');
//     $shipperNames = Shipper::where('shipper_name', 'like', '%' . $query . '%')->distinct()->pluck('shipper_name')->toArray();
//     return response()->json($shipperNames);
// }


public function fetchShipperDetailsAccounts(Request $request) {
    $query = $request->input('query');
    $shipperDetails = Shipper::where('shipper_name', 'like', '%' . $query . '%')->get(['shipper_name', 'shipper_address', 'shipper_country', 'shipper_state', 'shipper_city', 'shipper_zip']);
    $shipperNames = $shipperDetails->pluck('shipper_name')->toArray();
    return response()->json(['shipperNames' => $shipperNames, 'shipperDetails' => $shipperDetails]);
}



public function fetchCarrierNames(Request $request) {
    $query = $request->input('query');
    $carrierNames = External::where('carrier_name', 'like', '%' . $query . '%')->pluck('carrier_name');
    $customersName = customer::where('customer_name', 'like', '%'. $query . '%')->pluck('customer_name');
    return $carrierNames->toJson();
}


public function fetchConsigneeDetailsAccount(Request $request) {
    $query = $request->input('query');
    $consigneeNames = Consignee::where('consignee_name', 'like', '%' . $query . '%')->pluck('consignee_name')->toArray();
    return response()->json($consigneeNames);
}


public function fetchCarrierDetails(Request $request){
$mcNumber = $request->input('mcNumber');
$carrierName = External::where('carrier_mc_ff_input', $mcNumber)->value('carrier_name');
return response()->json($carrierName);
}


public function fetchConsigneeLocation(Request $request)
{
    $consigneeName = $request->input('consignee_name');
    $consignee = Consignee::where('consignee_name', $consigneeName)->first();
    if ($consignee) {
        $consigneeLocation = $consignee->consignee_address . ', ' . $consignee->consignee_country . ', ' . $consignee->consignee_state . ', ' . $consignee->consignee_city;
        return response()->json($consigneeLocation);
    } else {
        return response()->json('Consignee not found', 404);
    }
}

// public function markAsOpen($loadId)
// {
//     try {
//         $load = Load::findOrFail($loadId);
//         $load->load_status = 'Open';
//         $load->save();

//         return response()->json(['message' => 'Load status updated successfully'], 200);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Failed to update load status'], 500);
//     }
// }

public function markAsOpen($id)
{
    $load = Load::find($id);

    if ($load) {
        $load->load_status = 'Open';
        $load->invoice_status = null;
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
        $load->load_status = 'Delivered'; // Corrected spelling
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
            $load->load_status = 'Delivered';
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
            $load->load_status = 'Delivered';
            $load->invoice_status = 'Paid';
            $load->save();
    
            \Log::info('Back to Invoice successfully');
    
            return response()->json(['success' => true, 'message' => 'Back to Invoice successfully'], 200);
        }    
        \Log::error('Load not found');
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }


    // public function AccountsEditLoad($id)
    // {
    //     $loads = Load::where('load_status', 'Delivered')->with('user')->get();
    //     $loads_completed = Load::where('invoice_status', 'Completed')->get();
    //     $loads_paid = Load::where('invoice_status', 'Paid')->get();
    //     $loads_paid_record = Load::where('invoice_status', 'Paid Record')->get();
    //     $load = Load::find($id);
    
    //     if (!$load) {
    //         return redirect()->back()->with('error', 'Load not found.');
    //     }
    
    //     return view('accounts.accountsupdateload', compact('loads', 'loads_completed', 'loads_paid', 'loads_paid_record', 'load'));
    // }

    public function AccountsEditLoad($id)
    {
        // $loads = Load::where('load_status', 'Delivered')->with('user')->get();
        // $loads = Load::join('customers', 'load.customer_id', '=', 'customers.id')
        // ->join('external', 'load.carrier_id', '=', 'external.id')
        // ->select('load.*', 'customers.*', 'external.*') // Select needed columns
        // ->where('load.load_status', 'Delivered')
        // ->get();

        $loads = Load::join('customers', 'load.customer_id', '=', 'customers.id')
                        ->select(
                            'load.*', // Select all columns from the loads table
                            'customers.customer_address' // Select customer address from customers table
                        )
                        ->where('load.load_status', 'Delivered')
                        ->get();


        // echo "<pre>"; print_r($loads); die;
    

    

        // echo "<pre>"; print_r($loads); die;
        $loads_completed = Load::where('invoice_status', 'Completed')->get();
        $loads_paid = Load::where('invoice_status', 'Paid')->get();
        $loads_paid_record = Load::where('invoice_status', 'Paid Record')->get();
        $load = Load::find($id);
    
        if (!$load) {
            return redirect()->back()->with('error', 'Load not found.');
        }
    
        return view('accounts.accountsupdateload', compact('loads', 'loads_completed', 'loads_paid', 'loads_paid_record', 'load'));
    }

    // Method to update data based on form submission
    public function AccountsUpdateLoad(Request $request, $id)
    {
        // dd($request->all());
        
    
        
        $load = Load::findOrFail($id);
   
        
    $shipper_name = [];
    $shipper_location = [];
    $shipper_description = [];
    $shipper_appointment = [];
    $shipper_type = [];
    $shipper_commodity_name = [];
    $shipper_qty = [];
    $shipper_weight = [];
    $shipper_value = [];
    $shipper_note = [];
    $shipper_po_number = [];
    $shipper_contact = [];
    $shipper_delivery_note = [];
    
     for ($i = 1; $i <= 15; $i++) { // Assuming a maximum of 15 shippers
        if ($request->has("load_shipper_{$i}")) {
            $shipper = [
                'name' => $request->input("load_shipper_{$i}"),
            ];
            if (!empty($shipper['name'])) {
                $shipper_name[] = $shipper;
            }
        }

        if ($request->has("load_shipper_location_{$i}")) {
            $shipper = [
                'location' => $request->input("load_shipper_location_{$i}"),
            ];
            if (!empty($shipper['location'])) {
                $shipper_location[] = $shipper;
            }
        }

        if ($request->has("load_shipper_appointment_{$i}")) {
            $shipper = [
                'appointment' => $request->input("load_shipper_appointment_{$i}"),
            ];
            if (!empty($shipper['appointment'])) {
                $shipper_appointment[] = $shipper;
            }
        }
        if ($request->has("load_shipper_type_{$i}")) {
            $shipper = [
                'type' => $request->input("load_shipper_type_{$i}"),
            ];
            if (!empty($shipper['type'])) {
                $shipper_type[] = $shipper;
            }
        }

        if ($request->has("load_shipper_description_{$i}")) {
            $shipper = [
                'description' => $request->input("load_shipper_description_{$i}"),
            ];
            if (!empty($shipper['description'])) {
                $shipper_description[] = $shipper;
            }
        }

        if ($request->has("load_shipper_commodity_{$i}")) {
            $shipper = [
                'commodity' => $request->input("load_shipper_commodity_{$i}"),
            ];
            if (!empty($shipper['commodity'])) {
                $shipper_commodity_name[] = $shipper;
            }
        }

        if ($request->has("load_shipper_qty_{$i}")) {
            $shipper = [
                'qty' => $request->input("load_shipper_qty_{$i}"),
            ];
            if (!empty($shipper['qty'])) {
                $shipper_qty[] = $shipper;
            }
        }

        if ($request->has("load_shipper_weight_{$i}")) {
            $shipper = [
                'weight' => $request->input("load_shipper_weight_{$i}"),
            ];
            if (!empty($shipper['weight'])) {
                $shipper_weight[] = $shipper;
            }
        }

        if ($request->has("load_shipper_value_{$i}")) {
            $shipper = [
                'value' => $request->input("load_shipper_value_{$i}"),
            ];
            if (!empty($shipper['value'])) {
                $shipper_value[] = $shipper;
            }
        }

        if ($request->has("load_shipper_delivery_notes_{$i}")) {
            $shipper = [
                'delivery_notes' => $request->input("load_shipper_delivery_notes_{$i}"),
            ];
            if (!empty($shipper['delivery_notes'])) {
                $shipper_delivery_note[] = $shipper;
            }
        }

        if ($request->has("load_shipper_po_numbers_{$i}")) {
            $shipper = [
                'po_number' => $request->input("load_shipper_po_numbers_{$i}"),
            ];
            if (!empty($shipper['po_number'])) {
                $shipper_po_number[] = $shipper;
            }
        }

        if ($request->has("load_shipper_contact_{$i}")) {
            $shipper = [
                'contact' => $request->input("load_shipper_contact_{$i}"),
            ];
            if (!empty($shipper['contact'])) {
                $shipper_contact[] = $shipper;
            }
        }

        if ($request->has("load_shipper_notes_{$i}")) {
            $shipper = [
                'notes' => $request->input("load_shipper_notes_{$i}"),
            ];
            if (!empty($shipper['notes'])) {
                $shipper_note[] = $shipper;
            }
        }
    }

    // Loop through the request to extract shipper data
    foreach ($request->all() as $key => $value) {
        // Assuming shipper fields are structured similarly to consignee fields
        if (preg_match('/^load_shipper(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_name[$index]['name'] = $value;
        } elseif (preg_match('/^load_shipper_location(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_location[$index]['location'] = $value;
        } elseif (preg_match('/^load_shipper_description(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_description[$index]['description'] = $value;
        } elseif (preg_match('/^load_shipper_appointment(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_appointment[$index]['appointment'] = $value;
        } elseif (preg_match('/^load_shipper_type(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_type[$index]['shipper_type'] = $value;
        } elseif (preg_match('/^load_shipper_commodity(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_commodity_name[$index]['shipper_commodity'] = $value;
        } elseif (preg_match('/^load_shipper_qty(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_qty[$index]['shipper_qty'] = $value;
        } elseif (preg_match('/^load_shipper_weight(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_weight[$index]['shipper_weight'] = $value;
        } elseif (preg_match('/^load_shipper_value(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_value[$index]['shipper_value'] = $value;
        } elseif (preg_match('/^load_shipper_delivery_notes(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_delivery_note[$index]['shipper_delivery_notes'] = $value;
        } elseif (preg_match('/^load_shipper_po_numbers(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_po_number[$index]['shipper_po_number'] = $value;
        } elseif (preg_match('/^load_shipper_contact(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_contact[$index]['shipper_contact'] = $value;
        } elseif (preg_match('/^load_shipper_notes(\d*)$/', $key, $matches)) {
            $index = $matches[1] ?: 0;
            $shipper_note[$index]['shipper_notes'] = $value;
        }
      
       
    
            // Continue with other shipper fields...
    
            elseif (preg_match('/^load_consignee(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_name[$index]['name'] = $value;
            } elseif (preg_match('/^load_consignee_location(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_location[$index]['location'] = $value;
            } elseif (preg_match('/^load_consignee_description(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_description[$index]['description'] = $value;
            } elseif (preg_match('/^load_consignee_appointment(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consignee_appointment[$index]['appointment'] = $value;
            } elseif (preg_match('/^load_consignee_type(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_commodity_type[$index]['consignee_type'] = $value;
            } elseif (preg_match('/^load_consignee_commodity(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_commodity_name[$index]['consignee_commodity'] = $value;
            } elseif (preg_match('/^load_consignee_qty(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_qty[$index]['consignee_qty'] = $value;
            } elseif (preg_match('/^load_consignee_weight(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_weight[$index]['consignee_weight'] = $value;
            } elseif (preg_match('/^load_consignee_value(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_value[$index]['consignee_value'] = $value;
            } elseif (preg_match('/^load_consignee_delivery_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_delivery_note[$index]['consignee_delivery_notes'] = $value;
            } elseif (preg_match('/^load_consignee_po_numbers(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_po_number[$index]['consignee_po_number'] = $value;
            } elseif (preg_match('/^load_consignee_contact(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consigneer_contact[$index]['consignee_contact'] = $value;
            } elseif (preg_match('/^load_consignee_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consignee_notes[$index]['load_consignee_notes'] = $value;
            }
            // } elseif (preg_match('/^load_consignee_notes(\d*)$/', $key, $matches)) {
            //     $index = $matches[1] ?: 0;
            //     $consignee_note[$index]['consignee_notes'] = $value;
            // }
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
        $load->load_shipper_appointment = json_encode($shipper_appointment);
        $load->load_shipper_discription = json_encode($shipper_description);
        $load->load_shipper_commodity_type = json_encode($shipper_type);
        $load->load_shipper_commodity = json_encode($shipper_commodity_name);
        $load->load_shipper_qty = json_encode($shipper_qty);
        $load->load_shipper_weight = json_encode($shipper_weight);
        $load->load_shipper_value = json_encode($shipper_value);
        $load->load_shipper_shipping_notes = json_encode($shipper_delivery_note);
        $load->load_shipper_po_numbers = json_encode($shipper_po_number);
        $load->load_shipper_contact = json_encode($shipper_contact);
        $load->load_shipper_shipping_notes = json_encode($shipper_note);
        
        $load->load_consignee = json_encode($consignee_name);
        $load->load_consignee_location = json_encode($consignee_location);
        $load->load_consignee_appointment = json_encode($load_consignee_appointment);
        $load->load_consignee_discription = json_encode($consignee_description);
        $load->load_consignee_type = json_encode($load_consignee_type);
        $load->load_consignee_commodity = json_encode($load_consignee_commodity);
        $load->load_consignee_qty = $consignee_qty ? json_encode($consignee_qty) : '0';
        $load->load_consignee_weight = json_encode($consignee_weight);
        $load->load_consignee_value = json_encode($consignee_value);
        $load->load_consigneer_notes = json_encode($consignee_note);
        $load->load_consignee_po_numbers = json_encode($consignee_po_number);
        $load->load_consigneer_contact = json_encode($load_consigneer_contact);
        $load->load_consignee_delivery_notes = json_encode($consignee_delivery_note);
        $load->load_consignee_appointment = json_encode($load_consignee_appointment);


        $load->load_bill_to = $request->input('load_bill_to') ?? '';
        $load->load_dispatcher = $request->input('load_dispatcher') ?? '';
        $load->load_status = $request->input('load_status') ?? '';
        $load->load_workorder = $request->input('load_workorder') ?? '';
        $load->load_payment_type = $request->input('load_payment_type') ?? '';
        $load->load_type = $request->input('load_type') ?? '';
        $load->load_shipper_rate = $request->input('load_shipper_rate') ?? '';
        $load->load_pds = $request->input('load_pds') ?? '';
        // $load->load_fsc_rate = $request->input('load_fsc_rate') ?? '';
        $load->load_telephone = $request->input('load_telephone') ?? '';
        // $load->shipper_load_other_charge = $request->input('shipper_load_other_charge') ?? '';
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
    

        return redirect()->back()->with('success', 'Load status updated successfully');

    } 


    public function InvoiceMail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
        ]);
    

        $account = Account::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);
    
        return redirect()->back()->with('success', 'Account created successfully!');
    }

    public function printInvoicePaid($id)
    {
        $invoice = Load::findOrFail($id);
        $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
        return view('invoices_print', compact('invoice'));
    }
    

    public function printInvoice($id)
    {
        // Fetch the invoice based on load_number
        $invoice = DB::table('load')
            ->join('customers', 'load.customer_id', '=', 'customers.id')
            ->select(
                'load.*', 
                'customers.customer_address', 
                'customers.customer_state', 
                'customers.customer_city', 
                'customers.customer_zip', 
                'customers.customer_country'
            )
            ->where('load.load_number', $id)
            ->first();
        
        if (!$invoice) {
            abort(404, 'Invoice not found'); // Return a 404 error if no invoice is found
        }
        
        // Clean up the address data
        $invoice->customer_address = trim($invoice->customer_address);
        $invoice->customer_city = trim($invoice->customer_city);
        $invoice->customer_state = trim($invoice->customer_state);
        $invoice->customer_zip = trim($invoice->customer_zip);
        $invoice->customer_country = trim($invoice->customer_country);
        $invoice->customer_country = preg_replace('/^\d+\s*\|\s*/', '', $invoice->customer_country);
        
        // Parse the invoice date if it exists
        if ($invoice->invoice_date) {
            $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
        }
    
        // Generate the custom file name
        $fileName = "Load #{$invoice->load_number} - Invoice#{$invoice->invoice_number}";
    
        // Render the view and pass the invoice data and file name
        return view('invoices_print', compact('invoice', 'fileName'));
    }
    
    public function vendorManagement()
    {
        // Retrieve all records from the Load model
        $vendormanagement = Load::all();
    
        // Pass the data to the view
        return view('accounts.vendormanagement', compact('vendormanagement'));
    }
    


    public function updateLoadDate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:load,id', 
            'load_carrier_due_date' => 'required|date',
        ]);

        try {
            DB::table('load')->where('id', $request->id)->update(['load_carrier_due_date' => $request->load_carrier_due_date]);
            return response()->json(['success' => true, 'message' => 'Date updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update date: ' . $e->getMessage()], 500);
        }
    }
    
    
    public function updateLoadCheckbox(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:load,id',
            'carrier_mark_as_paid' => 'nullable|string',
        ]);
    
        try {
            $isChecked = $request->has('carrier_mark_as_paid') && $request->carrier_mark_as_paid === 'Paid';
            $load_carrier_due_date_on = $isChecked ? now()->format('Y-m-d H:i:s') : null;
            $carrier_mark_as_paid = $isChecked ? 'Paid' : '';
            DB::table('load')->where('id', $request->id)->update(['load_carrier_due_date_on' => $load_carrier_due_date_on,'carrier_mark_as_paid' => $carrier_mark_as_paid]);
            return response()->json(['success' => true, 'message' => 'Date and status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update date and status: ' . $e->getMessage()], 500);
        }
    }

    public function updateReceivingAmount(Request $request)
    {
        $request->validate([
            'load_id' => 'required|integer',
            'receiving_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0'
        ]);
    
        $load = Load::find($request->load_id);
    
        if ($load) {
            $load->receiving_amount = $request->receiving_amount;
            $load->remaining_amount = $request->remaining_amount;
            $load->save();
    
            return response()->json([
                'success' => true,
                'remaining_amount' => number_format($load->remaining_amount, 2)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Load not found'
            ]);
        }
    }
    
    
    public function carrierUploadFiles(Request $request)
    {
        $request->validate([
            'carrierDocs.*' => 'mimes:png,jpg,jpeg,pdf,doc,docx,xlsx,xls|max:10000',
        ]);
    
        $loadNumber = $request->input('load_number');
        $load = Load::where('load_number', $loadNumber)->first();
    
        if (!$load) {
            Log::error('Invalid load number: ' . $loadNumber);
            return response()->json(['error' => 'Invalid load number.'], 400);
        }
    
        $uploadedFilePaths = [];
    
        if ($request->hasFile('carrierDocs')) {
            foreach ($request->file('carrierDocs') as $file) {
                $filename = $loadNumber . '_' . time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/carrierDocs/' . $loadNumber, $filename);
                $uploadedFilePaths[] = $path;
                Log::info('Uploaded file: ' . $path); // Log the uploaded file path
            }
    
            // Save the file paths to the carrierDoc field
            $load->carrierDoc = json_encode($uploadedFilePaths);
            if ($load->save()) {
                Log::info('Files saved successfully for load number: ' . $loadNumber);
                return response()->json(['success' => 'Files have been uploaded successfully!']);
            } else {
                Log::error('Failed to save file paths for load number: ' . $loadNumber);
                return response()->json(['error' => 'Failed to save file paths.'], 500);
            }
        }
    
        return response()->json(['error' => 'No files were uploaded.'], 400);
    }
    
    

public function fetchFiles($loadNumber)
{
    $load = Load::where('load_number', $loadNumber)->first();

    if (!$load) {
        return response()->json(['error' => 'Invalid load number.'], 400);
    }

    $files = json_decode($load->carrierDoc, true) ?? [];

    // Prepare file URLs and names
    $fileData = array_map(function ($file) {
        return [
            'url' => asset('storage/' . $file), // Ensure 'storage/' is correct
            'name' => basename($file) // Get the filename for display
        ];
    }, $files);

    return response()->json(['files' => $fileData]);
}


public function deleteFile(Request $request)
{
    $request->validate([
        'file_url' => 'required|string',
        'load_number' => 'required|string',
    ]);

    $loadNumber = $request->input('load_number');
    $load = Load::where('load_number', $loadNumber)->first();

    if (!$load) {
        return response()->json(['error' => 'Invalid load number.'], 400);
    }

    $files = json_decode($load->carrierDoc, true) ?? [];
    $filePath = str_replace(asset('storage/') . '/', '', $request->input('file_url')); // Convert to storage path

    if (($key = array_search($filePath, $files)) !== false) {
        unset($files[$key]); // Remove the file path from the array
        $load->carrierDoc = json_encode(array_values($files)); // Re-index the array
        $load->save();
        Storage::delete('public/carrierDocs/' . $loadNumber . '/' . $filePath); // Ensure path matches storage location
        return response()->json(['success' => 'File deleted successfully!']);
    }

    return response()->json(['error' => 'File not found.'], 404);
}

    
    
    public function saveCarrierCheck(Request $request)
    {
        // Find the load by ID
        $load = External::find($request->id);
    
        if ($load) {
            // Update the mc_check field, defaulting to 'Not Approved' if null
            $load->mc_check = $request->mc_check ?? 'Not Approved';
            $load->save();
    
            Log::info('Load updated successfully.', ['load_id' => $load->id]);
    
            return response()->json(['success' => true, 'message' => 'MC checks updated successfully.']);
        } else {
            Log::error('Load not found.', ['load_id' => $request->id]);
            return response()->json(['success' => false, 'message' => 'MC not found.'], 404);
        }
    }

    public function saveLoadCprCheck(Request $request)
    {
        // Find the load by ID
        $load = Load::find($request->id);
    
        if ($load) {
            // Update the cpr_check field, defaulting to 'Not Approved' if null
            $load->cpr_check = $request->cpr_check ?? 'Not Approved';
            $load->save();
    
            Log::info('Load updated successfully.', ['load_id' => $load->id]);
    
            // Check if cpr_check is 'Verified' and send an email
            if ($request->cpr_check === 'Verified') {
                $userEmail = $load->user->email;
                $loadNumber = $load->load_number;
                $user =     $load->user->name;
                $subject = "CPR Verified for Your Load $loadNumber";
                $message = "Dear $user,\n\nYour load $loadNumber has been verified for CPR.\n\nRegards,\compliance Team";
    
                // Send the email
                $headers = "From: no-reply@cargoconvoy.co\r\n";
                mail($userEmail, $subject, $message, $headers);
    
                Log::info('CPR verification email sent.', ['email' => $userEmail, 'load_id' => $load->id]);
            }
    
            return response()->json(['success' => true, 'message' => 'CPR checks updated successfully.']);
        } else {
            Log::error('Load not found.', ['load_id' => $request->id]);
            return response()->json(['success' => false, 'message' => 'CPR not found.'], 404);
        }
    }
    
    
    public function compliance()
    {
        $carrier = External::orderBy('id', 'DESC')->get();
        $loads = Load::orderBy('id', 'DESC')->get();
        return view('accounts.compliance', compact('carrier', 'loads'));
    }
    
    public function getComplianceLoadInfo($id)
    {
        $load = Load::find($id);
    
        if ($load) {
            // Fetch the carrier's address based on the carrier_id
            $carrier = External::find($load->carrier_id);
    
            // Concatenate the address fields from the carrier
            $carrier_address = $carrier ? 
                ($carrier->carrier_address_two ? $carrier->carrier_address_two . ', ' : '') .
                ($carrier->carrier_city ? $carrier->carrier_city . ', ' : '') .
                ($carrier->carrier_state ? $carrier->carrier_state . ', ' : '') .
                ($carrier->carrier_country ? $carrier->carrier_country . ', ' : '') .
                ($carrier->carrier_zip ? $carrier->carrier_zip : '')
                : 'Address not available'; 
    
            return response()->json([
                'load_number' => $load->load_number,
                'load_dispatcher' => $load->load_dispatcher,
                'load_workorder' => $load->load_workorder,
                'customer_refrence_number' => $load->customer_refrence_number,
                'load_carrier' => $load->load_carrier,
                'load_bill_to' => $load->load_bill_to,
                'load_shipper_rate' => $load->load_shipper_rate,
                'load_carrier_fee' => $load->load_carrier_fee,
                'load_shipper_location' => $load->load_shipper_location,
                'load_shipperr' => json_decode($load->load_shipperr, true) ?? [],
                'load_consignee_location' => $load->load_consignee_location,
                'load_consignee' => $load->load_consignee,
                'load_carrier_location' => $carrier_address, // Add the concatenated address
            ]);
        } else {
            return response()->json(['error' => 'Load not found'], 404);
        }
    }
    
    


    
    
    

    
    public function vendorUpdateLoadDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quick_pay' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'ready_to_pay' => 'nullable|string',
        ]);
    
        $load = Load::find($request->id);
        if ($load) {
            $load->quick_pay = $request->quick_pay ?? '';
            $load->payment_method = $request->payment_method ?? '';
            $load->ready_to_pay = $request->ready_to_pay ?? '';
            $load->save();
    
            return response()->json(['message' => 'Data updated successfully']);
        }
    
        return response()->json(['message' => 'Load not found'], 404);
    }
    

    public function uploadCarrierDocs(Request $request)
    {
        $id = $request->input('id');
        $load = Load::find($id);
    
        if (!$load) {
            return response()->json(['success' => false, 'message' => 'Load not found'], 404);
        }
    
        $loadNumber = $load->load_number;
        $uploadedFiles = [];
    
        // Get existing files
        $existingFiles = json_decode($load->carrierDoc, true) ?: [];
    
        if ($request->hasFile('carrierDoc')) {
            $files = $request->file('carrierDoc');
    
            foreach ($files as $file) {
                // Define the destination path with the load number
                $destinationPath = 'uploads/' . $loadNumber;
    
                // Get the original file name
                $originalName = $file->getClientOriginalName();
    
                // Sanitize the file name
                $safeFileName = $this->sanitizeFileName($originalName);
    
                // Store the file in the specified directory with the sanitized name
                $filePath = $file->storeAs($destinationPath, $safeFileName, 'public');
    
                // Save the file path to the array (removing 'public/' prefix)
                $uploadedFiles[] = str_replace('public/', '', $filePath);
            }
    
            // Merge existing files with newly uploaded files
            $allFiles = array_merge($existingFiles, $uploadedFiles);
    
            // Update the Load record with the JSON-encoded file paths
            $load->carrierDoc = json_encode($allFiles);
            $load->save();
    
            return response()->json(['success' => true, 'files' => $uploadedFiles]);
        }
    
        return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
    }
    
    // Helper function to sanitize the file name
    private function sanitizeFileName($filename)
    {
        // Remove any characters that are not alphanumeric, underscores, or dashes
        // Replace spaces with underscores
        return preg_replace('/[^a-zA-Z0-9-_\.]/', '_', str_replace(' ', '_', $filename));
    }
    


public function deleteCarrierDoc(Request $request)
{
    $id = $request->input('id');
    $filename = $request->input('filename');
    $load = Load::find($id);

    if (!$load) {
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }

    // Get existing files
    $existingFiles = json_decode($load->carrierDoc, true) ?: [];

    // Filter out the file to be deleted
    $remainingFiles = array_filter($existingFiles, function($file) use ($filename) {
        return basename($file) !== $filename;
    });

    // Update the Load record with the remaining files
    $load->carrierDoc = json_encode(array_values($remainingFiles));
    $load->save();

    // Delete the file from storage
    \Storage::disk('public')->delete($filename);

    return response()->json(['success' => true, 'message' => 'File deleted successfully']);
}

public function deleteSelectedFiles(Request $request)
{
    $id = $request->input('id');
    $filenames = $request->input('filenames');
    $load = Load::find($id);

    if (!$load) {
        return response()->json(['success' => false, 'message' => 'Load not found'], 404);
    }

    $existingFiles = json_decode($load->carrierDoc, true) ?: [];

    // Filter out files to delete
    $remainingFiles = array_filter($existingFiles, function($file) use ($filenames) {
        return !in_array($file, $filenames);
    });

    foreach ($filenames as $filename) {
        $filePath = 'storage/uploads/' . $load->load_number . '/' . $filename;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    // Update the Load record with the remaining files
    $load->carrierDoc = json_encode(array_values($remainingFiles));
    $load->save();

    return response()->json(['success' => true]);
}


public function getFiles(Request $request)
{
    // Find the Load by its ID
    $load = Load::find($request->id);

    // Decode the JSON array of file paths stored in carrierDoc
    $files = json_decode($load->carrierDoc, true);

    // Initialize an array to hold file URLs and names
    $fileUrls = [];

    // Loop through the files array
    foreach ($files as $file) {
        // Generate the full URL for each file and its name
        $fileUrls[] = [
            'url' => asset('storage/' . $file), // Corrected file path
            'name' => basename($file)
        ];
    }

    // Return the array of file URLs as a JSON response
    return response()->json($fileUrls);
}






public function fetchUploadedFiles(Request $request)
{
    $loadNumber = $request->input('load_number');
    $load = Load::where('load_number', $loadNumber)->first();
    
    // Handle case when load is not found
    if (!$load || !$load->carrierDoc) {
        return response()->json(['files' => []]);
    }

    $filePaths = explode(',', $load->carrierDoc);
    $files = [];

    foreach ($filePaths as $path) {
        $files[] = [
            'name' => basename($path),
            'url' => Storage::url($path),
            'type' => Storage::mimeType($path)
        ];
    }

    return response()->json(['files' => $files]);
}

public function deleteUploadedFile(Request $request)
{
    $loadNumber = $request->input('load_number');
    $fileName = $request->input('file_name');

    // Check if the load exists
    $load = Load::where('load_number', $loadNumber)->first();
    if (!$load) {
        return response()->json(['error' => 'Load not found'], 404);
    }

    // Split the existing carrierDoc field into an array
    $files = explode(',', $load->carrierDoc);

    // Find the file path
    $filePath = null;
    foreach ($files as $file) {
        if (basename($file) === $fileName) {
            $filePath = $file;
            break;
        }
    }

    if (!$filePath) {
        return response()->json(['error' => 'File not found'], 404);
    }

    // Remove the file from the storage
    Storage::delete($filePath);

    // Remove the file from the carrierDoc field
    $files = array_filter($files, function($file) use ($fileName) {
        return basename($file) !== $fileName;
    });

    $load->carrierDoc = implode(',', $files);
    $load->save();

    return response()->json(['success' => 'File deleted successfully']);
}


public function customerCarriersDetails(){
    $carrier = External::with('user')->get();
    $customers = Customer::get(); // Ensure that the model name `Customer` is correctly capitalized
    return view('accounts.alldetail', compact('carrier', 'customers'));
}

public function updateMacro(Request $request)
{
    $load = Load::find($request->load_id);
    if ($load) {
        $load->macro = $request->macro;
        $load->no_of_macro = $request->no_of_macro;
        $load->save();

        return response()->json(['success' => 'Macro and No of Macro updated successfully!']);
    } else {
        return response()->json(['error' => 'Load not found'], 404);
    }
}

public function saveInternalNotes(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'id' => 'required|integer|exists:load,id', // Change delivered_table to your actual table name
        'notes' => 'nullable|string',
    ]);

    // Find the record and update the notes
    $delivered = Load::find($request->id);
    $delivered->internal_notes = $request->notes; // Make sure to have the 'internal_notes' field in your table
    $delivered->save();

    return response()->json(['message' => 'Notes saved successfully!']);
}

public function fetchInvoiceDetails(Request $request)
{
    // Find the invoice by invoice_number, NOT by primary key
    // $invoice = Load::where('invoice_number', $request->invoice_number)->first();
    $loadNumber = $request->load_number;
    $invoiceNumber = $request->invoice_number;
    $workOrderNumber = $request->load_workorder;

    if (!$invoiceNumber) {
        return response()->json(['error' => 'Invoice not found'], 404);
    }
    $invoice = Load::where('invoice_number', $invoiceNumber)->first();

    if (!$invoice) {
        return response()->json(['error' => 'Invoice not found'], 404);
    }
    // Fetch user email (related user)
    $userEmail = $invoice->user->email;

    // Manually decode the JSON stored in public_files
    $publicFiles = json_decode($invoice->public_file, true);

    // Ensure that publicFiles is an array before proceeding
    if (!is_array($publicFiles)) {
        return response()->json(['error' => 'Invalid public file data'], 500);
    }

    // Initialize the attachments array
    $attachments = [];

    // Check for and retrieve each type of document from the public_files field
    if (isset($publicFiles['carrer_rate_cnfrm_doc']) && is_array($publicFiles['carrer_rate_cnfrm_doc'])) {
        foreach ($publicFiles['carrer_rate_cnfrm_doc'] as $file) {
            $attachments[] = [
                'file_name' => basename($file),
                'file_path' => asset('storage/' . $file),
            ];
        }
    }

    if (isset($publicFiles['pod_doc']) && is_array($publicFiles['pod_doc'])) {
        foreach ($publicFiles['pod_doc'] as $file) {
            $attachments[] = [
                'file_name' => basename($file),
                'file_path' => asset('storage/' . $file),
            ];
        }
    }

    if (isset($publicFiles['shipper_rate_approval_doc']) && is_array($publicFiles['shipper_rate_approval_doc'])) {
        foreach ($publicFiles['shipper_rate_approval_doc'] as $file) {
            $attachments[] = [
                'file_name' => basename($file),
                'file_path' => asset('storage/' . $file),
            ];
        }
    }

    if (isset($publicFiles['carrier_invoice_doc']) && is_array($publicFiles['carrier_invoice_doc'])) {
        foreach ($publicFiles['carrier_invoice_doc'] as $file) {
            $attachments[] = [
                'file_name' => basename($file),
                'file_path' => asset('storage/' . $file),
            ];
        }
    }

    return response()->json([
        'userEmail' => 'sumit@gmail.com',
        'subject' => 'Invoice for load #' . $loadNumber . ' (' . $invoiceNumber . ') Ref #' . $workOrderNumber,
        'attachments' => $attachments,
        'cc' => $userEmail,  // User email in CC
        'to' => 'sumit@geeshasolutions.com', // Static recipient
    ]);
}


  

public function invoiceSendEmail(Request $request)
{
    $validator = Validator::make($request->all(), [
        'toEmail' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string',
        'selected_attachments' => 'array',
        'selected_attachments.*' => 'string',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    try {
        $toEmail = $request->input('toEmail');
        $subject = $request->input('subject');
        $messageContent = $request->input('message');
        $attachments = $request->input('selected_attachments', []);

        // Send email using Mailable class
        Mail::to($toEmail)->send(new InvoiceMail($subject, $messageContent, $attachments));

        return response()->json(['success' => true, 'message' => 'Email sent successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}



public function getComplianceData()
{
    $carrier = External::with('user')->get(); // Fetch data as per your needs
    $loads = Load::with('user')->get(); // Fetch loads data as per your needs

    return response()->json([
        'carrier' => $carrier,
        'loads' => $loads
    ]);
}


public function accounteditCustomer($id)
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
    return view('accounts.edit_customer', compact('customer', 'usedAmount', 'remainingCredit', 'totalFinalRate','users'));
}


public function accountupdateCustomer(Request $request, $id)
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
        'commenter_name' => $request->input('commenter_name') ?? null,
        'approved_limit' => $request->input('approved_limit') ?? null,
    ]);

    return redirect()->back()->with('success', 'Customer updated successfully');
}
    

    
    
    
    
}
