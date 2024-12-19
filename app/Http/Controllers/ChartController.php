<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use App\Models\ProfileData;

class ChartController extends Controller
{
    public function userChart(){
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                       ->whereYear('create_at',date('Y'))
                       ->groupBy('month')
                       ->orderBy('month')
                       ->get();
                    echo "<pre>"; print_r( $users); die();

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
                    return view('home', compact('datasets', 'labels'));

    }
}
