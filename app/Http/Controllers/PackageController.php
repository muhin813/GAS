<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageUom;
use App\Models\PackageDetail;
use App\Models\PackageSubDetail;
use App\Models\PackageBenefitFeature;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;
use DB;

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
    public function index(Request $request)
    {
        try{
            $packages = Package::select('packages.*');
            $packages = $packages->whereIn('packages.status',['active','inactive']);
            $packages = $packages->paginate(50);
            return view('package.index',compact('packages'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            return view('package.create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{
            $user = Auth::user();

            DB::beginTransaction();

            $old_package = Package::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_package)){
                return ['status'=>401, 'reason'=>'This package name already exists'];
            }

            $package = NEW Package();
            $package->name = $request->name;
            $package->vehicle_name = $request->vehicle_name;
            $package->package_price = $request->package_price;
            $package->package_validity = date('Y-m-d',strtotime($request->package_validity));
            $package->conditions = $request->conditions;
            $package->created_by = $user->id;
            $package->created_at = date('Y-m-d h:i:s');
            $package->save();

            /*
             * Saving package details
             * */
            $package_detail_names = $request->package_detail_name;
            $package_detail_indexes = $request->package_detail_index;
            $package_sub_detail_names = $request->package_sub_detail_name;

            foreach($package_detail_names as $key=>$value){
                if($package_detail_names[$key] != ''){
                    $package_detail = NEW PackageDetail();
                    $package_detail->package_id = $package->id;
                    $package_detail->description = $package_detail_names[$key];
                    $package_detail->save();


                    /*
                     * Saving package sub details
                     * */
                    $index = $package_detail_indexes[$key];
                    foreach($package_sub_detail_names[$index] as $key2=>$value){
                        if($package_sub_detail_names[$index][$key2] != ''){
                            $package_sub_detail = NEW PackageSubDetail();
                            $package_sub_detail->package_details_id = $package_detail->id;
                            $package_sub_detail->description = $package_sub_detail_names[$index][$key2];
                            $package_sub_detail->save();
                        }
                    }
                }
            }

            /*
             * Saving package features and benefit
             * */
            $package_benefits = $request->package_benefits;

            foreach($package_benefits as $key3=>$value){
                if($package_benefits[$key3] != ''){
                    $package_benefit = NEW PackageBenefitFeature();
                    $package_benefit->package_id = $package->id;
                    $package_benefit->description = $package_benefits[$key3];
                    $package_benefit->save();
                }
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function edit(Request $request)
    {
        try{
            $package = Package::with('details.sub_details','benefits')
                ->select('packages.*')
                ->where('packages.id',$request->id)
                ->first();
            //echo "<pre>"; print_r($package); echo "</pre>"; exit();
            return view('package.edit',compact('package'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            DB::beginTransaction();

            $old_package = Package::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_package) && $old_package->id != $request->id){
                return ['status'=>401, 'reason'=>'This package name already exists'];
            }

            $package = Package::where('id',$request->id)->first();
            $package->name = $request->name;
            $package->vehicle_name = $request->vehicle_name;
            $package->package_price = $request->package_price;
            $package->package_validity = date('Y-m-d',strtotime($request->package_validity));
            $package->conditions = $request->conditions;
            $package->updated_by = $user->id;
            $package->updated_at = date('Y-m-d h:i:s');
            $package->save();

            /*
             * Saving package details
             * */

            $package_detail_ids = PackageDetail::select('id')->where('package_id',$request->id)->pluck('id')->toArray();
            PackageDetail::where('package_id',$request->id)->delete();

            $package_detail_names = $request->package_detail_name;
            $package_detail_indexes = $request->package_detail_index;
            $package_sub_detail_names = $request->package_sub_detail_name;

            foreach($package_detail_names as $key=>$value){
                if($package_detail_names[$key] != ''){
                    $package_detail = NEW PackageDetail();
                    $package_detail->package_id = $package->id;
                    $package_detail->description = $package_detail_names[$key];
                    $package_detail->save();


                    /*
                     * Saving package sub details
                     * */
                    PackageSubDetail::whereIN('package_details_id',$package_detail_ids)->delete();

                    $index = $package_detail_indexes[$key];
                    foreach($package_sub_detail_names[$index] as $key2=>$value){
                        if($package_sub_detail_names[$index][$key2] != ''){
                            $package_sub_detail = NEW PackageSubDetail();
                            $package_sub_detail->package_details_id = $package_detail->id;
                            $package_sub_detail->description = $package_sub_detail_names[$index][$key2];
                            $package_sub_detail->save();
                        }
                    }
                }
            }

            /*
             * Saving package features and benefit
             * */
            PackageBenefitFeature::where('package_id',$request->id)->delete();

            $package_benefits = $request->package_benefits;

            foreach($package_benefits as $key3=>$value){
                if($package_benefits[$key3] != ''){
                    $package_benefit = NEW PackageBenefitFeature();
                    $package_benefit->package_id = $package->id;
                    $package_benefit->description = $package_benefits[$key3];
                    $package_benefit->save();
                }
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function delete(Request $request)
    {
        try{
            $user = Auth::user();

            $package = Package::where('id',$request->package_id)->first();
            $package->status = 'deleted';
            $package->deleted_by = $user->id;
            $package->deleted_at = date('Y-m-d h:i:s');
            $package->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*####################### Package UOM Section #############################*/

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
