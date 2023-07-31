<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerVehicleCredential;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class CustomerController extends Controller
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
            $customers = Customer::select('customers.*');
            $customers = $customers->whereIn('customers.status',['active','inactive']);
            $customers = $customers->paginate(50);
            return view('customer.index',compact('customers'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            return view('customer.create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        //try{
            $user = Auth::user();

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
            $customer->created_by = $user->id;
            $customer->created_at = date('Y-m-d h:i:s');
            $customer->save();

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
        /*}
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }*/
    }

    public function edit(Request $request)
    {
        try{
            $customer = Customer::select('customers.*')
                ->where('customers.id',$request->id)
                ->first();
            return view('customer.edit',compact('customer'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            $old_customer = Customer::where('first_name',$request->first_name)->where('last_name',$request->last_name)->where('status','!=','deleted')->first();
            if(!empty($old_customer) && $old_customer->id != $request->id){
                return ['status'=>401, 'reason'=>'This customer name already exists'];
            }

            $customer = Customer::where('id',$request->id)->first();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;

            /*
             * Update customer photo
             * */
            $photo_path = '';
            $old_photo_path = $request->old_photo_path;
            if($request->hasFile('photo')){
                $file = $request->File('photo');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/customers');
                if(!File::exists($destinationPath)){
                    File::makeDirectory($destinationPath, 0775, true);
                }
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/customers/'.$file_name;
                $customer->photo = $photo_path;

                // Delete previous photo from physical folder
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }
            $customer->updated_by = $user->id;
            $customer->updated_at = date('Y-m-d h:i:s');
            $customer->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function delete(Request $request)
    {
        try{
            $user = Auth::user();

            $customer = Customer::where('id',$request->customer_id)->first();
            $customer->status = 'deleted';
            $customer->deleted_by = $user->id;
            $customer->deleted_at = date('Y-m-d h:i:s');
            $customer->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
