<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVehicleCredential;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;

class ServiceController extends Controller
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
    public function serviceCategoryIndex(Request $request)
    {
        try{
            $service_categories = ServiceCategory::select('service_categories.*');
            $service_categories = $service_categories->whereIn('service_categories.status',['active','inactive']);
            $service_categories = $service_categories->paginate(50);
            return view('service.service_category_index',compact('service_categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceCategoryCreate(Request $request)
    {
        try{
            return view('service.service_category_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceCategoryStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_category = ServiceCategory::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_category)){
                return ['status'=>401, 'reason'=>'This service category already exists'];
            }

            $service_category = NEW ServiceCategory();
            $service_category->name = $request->name;

            $service_category->created_by = $user->id;
            $service_category->created_at = date('Y-m-d h:i:s');
            $service_category->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceCategoryEdit(Request $request)
    {
        try{
            $service_category = ServiceCategory::select('service_categories.*')
                ->where('service_categories.id',$request->id)
                ->first();
            return view('service.service_category_edit',compact('service_category'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceCategoryUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_category = ServiceCategory::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_category) && $old_category->id != $request->id){
                return ['status'=>401, 'reason'=>'This service category already exists'];
            }

            $service_category = ServiceCategory::where('id',$request->id)->first();
            $service_category->name = $request->name;
            $service_category->updated_by = $user->id;
            $service_category->updated_at = date('Y-m-d h:i:s');
            $service_category->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceCategoryDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $service_category = ServiceCategory::where('id',$request->service_category_id)->first();
            $service_category->status = 'deleted';
            $service_category->deleted_by = $user->id;
            $service_category->deleted_at = date('Y-m-d h:i:s');
            $service_category->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceTypeIndex(Request $request)
    {
        try{
            $service_types = ServiceType::select('service_types.*');
            $service_types = $service_types->whereIn('service_types.status',['active','inactive']);
            $service_types = $service_types->paginate(50);
            return view('service.service_type_index',compact('service_types'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceTypeCreate(Request $request)
    {
        try{
            $service_categories = ServiceCategory::where('status','active')->get();
            return view('service.service_type_create',compact('service_categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceTypeStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_type = ServiceType::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_type)){
                return ['status'=>401, 'reason'=>'This service type already exists'];
            }

            $service_type = NEW ServiceType();
            $service_type->name = $request->name;
            $service_type->service_category_id = $request->service_category_id;

            $service_type->created_by = $user->id;
            $service_type->created_at = date('Y-m-d h:i:s');
            $service_type->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceTypeEdit(Request $request)
    {
        try{
            $service_categories = ServiceCategory::where('status','active')->get();
            $service_type = ServiceType::select('service_types.*')
                ->where('service_types.id',$request->id)
                ->first();
            return view('service.service_type_edit',compact('service_categories','service_type'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceTypeUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_type = ServiceType::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_type) && $old_type->id != $request->id){
                return ['status'=>401, 'reason'=>'This service type already exists'];
            }

            $service_type = ServiceType::where('id',$request->id)->first();
            $service_type->name = $request->name;
            $service_type->service_category_id = $request->service_category_id;
            $service_type->updated_by = $user->id;
            $service_type->updated_at = date('Y-m-d h:i:s');
            $service_type->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceTypeDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $service_type = ServiceType::where('id',$request->service_type_id)->first();
            $service_type->status = 'deleted';
            $service_type->deleted_by = $user->id;
            $service_type->deleted_at = date('Y-m-d h:i:s');
            $service_type->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*################################## Service Booking section ################################*/

    public function serviceBookingIndex(Request $request)
    {
        try{
            $service_bookings = ServiceBooking::select('service_bookings.*','service_categories.name as service_category','service_types.name as service_type','customer_vehicle_credentials.name as vehicle_name');
            $service_bookings = $service_bookings->join('service_categories','service_categories.id','service_bookings.service_category_id');
            $service_bookings = $service_bookings->join('service_types','service_types.id','service_bookings.service_type_id');
            $service_bookings = $service_bookings->join('customer_vehicle_credentials','customer_vehicle_credentials.id','service_bookings.vehicle_credential_id');
            $service_bookings = $service_bookings->whereIn('service_bookings.status',['active','inactive']);
            $service_bookings = $service_bookings->paginate(50);
            return view('customer.service_booking_index',compact('service_bookings'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceBookingCreate(Request $request)
    {
        try{
            $customer_details = Customer::where('user_id',Auth::user()->id)->first();
            $service_categories = ServiceCategory::where('status','active')->get();
            $vehicle_credentials = CustomerVehicleCredential::where('customer_id',$customer_details->id)->get();
            return view('customer.service_booking_create',compact('service_categories','vehicle_credentials'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceBookingStore(Request $request)
    {
        try{
            $user = Auth::user();
            $customer = Customer::where('user_id',$user->id)->first();

            $service_booking = NEW ServiceBooking();
            $service_booking->customer_id = $customer->id;
            $service_booking->service_category_id = $request->service_category_id;
            $service_booking->service_type_id = $request->service_type_id;
            $service_booking->vehicle_credential_id = $request->vehicle_credential_id;
            $service_booking->special_note = $request->special_note;
            if($request->emergency=='Yes'){
                $service_booking->emergency = 'Yes';
            }
            else{
                $service_booking->emergency = 'No';
            }
            $service_booking->created_at = date('Y-m-d h:i:s');
            $service_booking->save();

            /*
             * Update booking number
             * */
            $booking_update = ServiceBooking::where('id',$service_booking->id)->first();
            $booking_update->booking_number = 'BR'.Common::addLeadingZero($service_booking->id,4);
            $booking_update->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceBookingEdit(Request $request)
    {
        try{
            $customer_details = Customer::where('user_id',Auth::user()->id)->first();
            $service_categories = ServiceCategory::where('status','active')->get();
            $vehicle_credentials = CustomerVehicleCredential::where('customer_id',$customer_details->id)->get();

            $service_booking = ServiceBooking::select('service_bookings.*')
                ->where('service_bookings.id',$request->id)
                ->first();
            return view('customer.service_booking_edit',compact('service_categories','vehicle_credentials','service_booking'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function serviceBookingUpdate(Request $request)
    {
        try{
            $service_booking = ServiceBooking::where('id',$request->id)->first();
            $service_booking->service_category_id = $request->service_category_id;
            $service_booking->service_type_id = $request->service_type_id;
            $service_booking->vehicle_credential_id = $request->vehicle_credential_id;
            $service_booking->special_note = $request->special_note;
            if($request->emergency=='Yes'){
                $service_booking->emergency = 'Yes';
            }
            else{
                $service_booking->emergency = 'No';
            }
            $service_booking->updated_at = date('Y-m-d h:i:s');
            $service_booking->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceBookingDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $service_booking = ServiceBooking::where('id',$request->service_booking_id)->first();
            $service_booking->status = 'deleted';
            $service_booking->deleted_at = date('Y-m-d h:i:s');
            $service_booking->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function getServiceTypeByCategory(Request $request)
    {
        try{
            $service_types = ServiceType::select('service_types.*')
                ->where('service_category_id',$request->service_category_id)
                ->get();
            return ['status'=>200, 'service_types'=>$service_types];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
