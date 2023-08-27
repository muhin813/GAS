<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Common;
use Auth;
use Session;

class SettingController extends Controller
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
    public function generalSetting(Request $request)
    {
        try{
            $general_settings = Setting::first();
            return view('general_settings',compact('general_settings'));

        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function generalSettingUpdate(Request $request)
    {
        try{
            $general_settings = Setting::first();
            $general_settings->company_name = $request->company_name;
            $general_settings->cash_in_hand_opening_balance = $request->cash_in_hand_opening_balance;
            $general_settings->updated_at = date('Y-m-d h:i:s');
            $general_settings->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Please try again later.'];
        }
    }
}
