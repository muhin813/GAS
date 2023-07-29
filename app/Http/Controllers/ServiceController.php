<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
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
            return view('service.service_type_create');
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
            $service_type = ServiceType::select('service_types.*')
                ->where('service_types.id',$request->id)
                ->first();
            return view('service.service_type_edit',compact('service_type'));
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
}
