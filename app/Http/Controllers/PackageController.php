<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\PackageUom;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;

class PackageController extends Controller
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
    public function packageUomIndex(Request $request)
    {
        try{
            $package_uoms = PackageUom::select('package_uoms.*');
            $package_uoms = $package_uoms->whereIn('package_uoms.status',['active','inactive']);
            $package_uoms = $package_uoms->paginate(50);
            return view('package.package_uom_index',compact('package_uoms'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function packageUomCreate(Request $request)
    {
        try{
            return view('package.package_uom_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function packageUomStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_uom = PackageUom::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_uom)){
                return ['status'=>401, 'reason'=>'This package UOM name already exists'];
            }

            $package_uom = NEW PackageUom();
            $package_uom->name = $request->name;

            $package_uom->created_by = $user->id;
            $package_uom->created_at = date('Y-m-d h:i:s');
            $package_uom->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function packageUomEdit(Request $request)
    {
        try{
            $package_uom = PackageUom::select('package_uoms.*')
                ->where('package_uoms.id',$request->id)
                ->first();
            return view('package.package_uom_edit',compact('package_uom'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function packageUomUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_uom = PackageUom::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_uom) && $old_uom->id != $request->id){
                return ['status'=>401, 'reason'=>'This package UOM name already exists'];
            }

            $package_uom = PackageUom::where('id',$request->id)->first();
            $package_uom->name = $request->name;
            $package_uom->updated_by = $user->id;
            $package_uom->updated_at = date('Y-m-d h:i:s');
            $package_uom->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function packageUomDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $package_uom = PackageUom::where('id',$request->package_uom_id)->first();
            $package_uom->status = 'deleted';
            $package_uom->deleted_by = $user->id;
            $package_uom->deleted_at = date('Y-m-d h:i:s');
            $package_uom->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
