<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVehicleCredential;
use App\Models\Mechanic;
use App\Models\ServiceCategory;
use App\Models\ServiceBooking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class OperationController extends Controller
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

    /*##################################### Job section #######################################*/

    public function job(Request $request)
    {
        try{
            $jobs = Job::select('jobs.*','service_categories.name as job_category_name','service_types.name as job_type_name','customers.first_name','customers.last_name','customers.registration_number as customer_registration_number','mechanics.name as assigned_person','customer_vehicle_credentials.name as vehicle_name','customer_vehicle_credentials.registration_number as vehicle_registration_number','customer_vehicle_credentials.model as vehicle_model');
            $jobs = $jobs->leftJoin('service_categories','service_categories.id','=','jobs.job_category');
            $jobs = $jobs->leftJoin('service_types','service_types.id','=','jobs.job_type');
            $jobs = $jobs->leftJoin('customers','customers.id','=','jobs.customer_id');
            $jobs = $jobs->leftJoin('customer_vehicle_credentials','customer_vehicle_credentials.id','=','jobs.customer_vehicle_credential_id');
            $jobs = $jobs->leftJoin('mechanics','mechanics.id','=','jobs.job_assigned_person_id');
            $jobs = $jobs->where('jobs.status','active');
            $jobs = $jobs->orderBy('jobs.id','ASc');
            $jobs = $jobs->paginate(100);
            return view('operation.job_index',compact('jobs'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function jobCreate(Request $request)
    {
        try{
            $service_categories = ServiceCategory::where('status','active')->get();
            $customers = Customer::where('status','active')->get();
            $mechanics = Mechanic::where('status','active')->get();
            return view('operation.job_create',compact('service_categories','customers','mechanics'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function jobStore(Request $request)
    {
        try{
            $user = Auth::user();

            $job = NEW Job();
            $job->opening_time = date('Y-m-d h:i:s',strtotime($request->opening_time));
            $job->job_category = $request->job_category;
            $job->job_type = $request->job_type;
            $job->customer_id = $request->customer_id;
            $job->customer_vehicle_credential_id = $request->customer_vehicle_credential_id;
            $job->job_assigned_person_id = $request->job_assigned_person_id;
            $job->created_by = $user->id;
            $job->created_at = date('Y-m-d h:i:s');
            $job->save();

            /*
             * Update job tracking number
             * */
            $job_update = Job::where('id',$job->id)->first();
            $job_update->tracking_number = 'Job'.Common::addLeadingZero($job->id,5);
            $job_update->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function jobEdit(Request $request)
    {
        try{
            $service_categories = ServiceCategory::where('status','active')->get();
            $customers = Customer::where('status','active')->get();
            $mechanics = Mechanic::where('status','active')->get();
            $job = Job::select('jobs.*')
                ->where('jobs.id',$request->id)
                ->first();
            return view('operation.job_edit',compact('service_categories','customers','mechanics','job'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function jobUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $job = Job::where('id',$request->id)->first();
            $job->opening_time = date('Y-m-d h:i:s',strtotime($request->opening_time));
            $job->job_category = $request->job_category;
            $job->job_type = $request->job_type;
            $job->customer_id = $request->customer_id;
            $job->customer_vehicle_credential_id = $request->customer_vehicle_credential_id;
            $job->job_assigned_person_id = $request->job_assigned_person_id;
            if($request->job_closing_date != ''){
                $job->job_closing_date = date('Y-m-d h:i:s',strtotime($request->job_closing_date));
            }
            else{
                $job->job_closing_date = '';
            }
            $job->updated_by = $user->id;
            $job->updated_at = date('Y-m-d h:i:s');
            $job->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function jobDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $job = Job::where('id',$request->job_id)->first();
            $job->status = 'deleted';
            $job->deleted_by = $user->id;
            $job->deleted_at = date('Y-m-d h:i:s');
            $job->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*##################################### Job section #######################################*/

    public function booking(Request $request)
    {
        try{
            $bookings = ServiceBooking::select('service_bookings.*','service_categories.name as service_category','service_types.name as service_type','customers.first_name','customers.last_name','customers.phone','customer_vehicle_credentials.name as vehicle_name','customer_vehicle_credentials.model as vehicle_model');
            $bookings = $bookings->leftJoin('service_categories','service_categories.id','service_bookings.service_category_id');
            $bookings = $bookings->leftJoin('service_types','service_types.id','service_bookings.service_type_id');
            $bookings = $bookings->leftJoin('customers','customers.id','service_bookings.customer_id');
            $bookings = $bookings->leftJoin('customer_vehicle_credentials','customer_vehicle_credentials.id','service_bookings.vehicle_credential_id');
            $bookings = $bookings->whereIn('service_bookings.status',['active','inactive']);
            $bookings = $bookings->paginate(50);
            return view('operation.booking_index',compact('bookings'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bookingEdit(Request $request)
    {
        try{
            $booking = ServiceBooking::select('service_bookings.*','service_categories.name as service_category','service_types.name as service_type','customers.first_name','customers.last_name','customers.phone','customer_vehicle_credentials.name as vehicle_name','customer_vehicle_credentials.model as vehicle_model')
                ->leftJoin('service_categories','service_categories.id','service_bookings.service_category_id')
                ->leftJoin('service_types','service_types.id','service_bookings.service_type_id')
                ->leftJoin('customers','customers.id','service_bookings.customer_id')
                ->leftJoin('customer_vehicle_credentials','customer_vehicle_credentials.id','service_bookings.vehicle_credential_id')
                ->where('service_bookings.id',$request->id)
                ->first();
            return view('operation.booking_edit',compact('booking'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bookingUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $booking = ServiceBooking::where('id',$request->id)->first();
            $booking->confirmation_status = 'confirmed';
            $booking->confirmation_date = date('Y-m-d', strtotime($request->confirmation_date));
            $booking->confirmation_time = $request->confirmation_time;
            $booking->confirmed_by = $user->id;
            $booking->updated_at = date('Y-m-d h:i:s');
            $booking->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bookingDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $booking = ServiceBooking::where('id',$request->booking_id)->first();
            $booking->status = 'deleted';
            $booking->deleted_at = date('Y-m-d h:i:s');
            $booking->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

}
