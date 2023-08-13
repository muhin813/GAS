<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVehicleCredential;
use Illuminate\Http\Request;
use App\Common;
use Auth;
use Session;
use DB;

class RegistrationController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try{
            return view('registration');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{

            DB::beginTransaction();

            $old_customer = Customer::where('first_name',$request->first_name)->where('last_name',$request->last_name)->where('status','!=','deleted')->first();
            if(!empty($old_customer)){
                return ['status'=>401, 'reason'=>'This customer name already exists'];
            }

            $customer = NEW Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->password = bcrypt($request->password);
            $customer->created_at = date('Y-m-d h:i:s');
            $customer->save();

            /*
             * Update GAS customer number
             * */
            $customer_update = Customer::where('id',$customer->id)->first();
            $customer_update->registration_number = 'GAS'.Common::addLeadingZero($customer->id,5);
            $customer_update->save();

            /*
             * Adding customer vehicle credentials
             * */
            $vehicle_name = $request['vehicle_name'];
            $vehicle_registration_number = $request['vehicle_registration_number'];
            $vehicle_model = $request['vehicle_model'];

            foreach($vehicle_name as $key=>$value){
                $vehicle_credential = NEW CustomerVehicleCredential();
                $vehicle_credential->customer_id = $customer->id;
                $vehicle_credential->name = $vehicle_name[$key];
                $vehicle_credential->registration_number = $vehicle_registration_number[$key];
                $vehicle_credential->model = $vehicle_model[$key];
                $vehicle_credential->created_at = date('Y-m-d h:i:s');
                $vehicle_credential->save();
            }

            Db::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
