<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Size;
use App\Models\Color;
use App\Models\Supplier;
use App\Common;
use Auth;
use Session;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try{
            if(Auth::user()->role != 4){
                $start_date = date('Y-m-d').' 00:00:01';
                $end_date = date('Y-m-d').' 11:59:59';

                $product_sale = Sale::select('sales.*')
                    ->where('date_of_sale',date('Y-m-d'))
                    ->where('sales_type','product')
                    ->where('status','active')
                    ->count();

                $service_sale = Sale::select('sales.*')
                    ->where('date_of_sale',date('Y-m-d'))
                    ->where('sales_type','service')
                    ->where('status','active')
                    ->count();

                $ongoing_jobs = Job::select('jobs.*')
                    ->whereNull('job_closing_date')
                    ->where('status','active')
                    ->count();

                $new_job_received = Job::select('jobs.*')
                    ->where('opening_time','>',$start_date)
                    ->where('opening_time','<',$end_date)
                    ->where('status','active')
                    ->count();

                $new_job_completed = Job::select('jobs.*')
                    ->where('job_closing_date','>',$start_date)
                    ->where('job_closing_date','<',$end_date)
                    ->where('status','active')
                    ->count();

                $settings = Setting::first();

                $bank_account = DB::table('bank_accounts')->select(DB::raw('SUM(opening_balance) as cash_at_bank'))
                    ->where('status','active')
                    ->first();

                return view('dashboard',compact('product_sale','service_sale','ongoing_jobs','new_job_received','new_job_completed','settings','bank_account'));
            }
            else{
                return redirect('crm');
            }

        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }
}
