<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceCategory;
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
            $jobs = Job::select('jobs.*','customers.name as customer_name');
            $jobs = $jobs->join('customers','customers.registration_number','=','jobs.customer_registration_number');
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
            return view('operation.job_create',compact('service_categories','customers'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function jobStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_job = Job::where('name',$request->name)->first();
            if(!empty($old_job)){
                return ['status'=>401, 'reason'=>'job with this name already exists'];
            }

            $job = NEW Job();
            $job->name = $request->name;
            $job->created_by = $user->id;
            $job->created_at = date('Y-m-d h:i:s');
            $job->save();


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
            $job = Job::select('jobs.*')
                ->where('jobs.id',$request->id)
                ->first();
            return view('operation.job_edit',compact('service_categories','customers','job'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function jobUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_job = Job::where('name',$request->name)->first();
            if(!empty($old_job) && $old_job->id != $request->id){
                return ['status'=>401, 'reason'=>'job with this name already exists'];
            }

            $job = Job::where('id',$request->id)->first();
            $job->name = $request->name;
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

}
