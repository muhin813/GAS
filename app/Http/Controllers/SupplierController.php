<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;

class SupplierController extends Controller
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
            $suppliers = Supplier::select('suppliers.*');
            $suppliers = $suppliers->whereIn('suppliers.status',['active','inactive']);
            $suppliers = $suppliers->paginate(50);
            return view('supplier.index',compact('suppliers'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            return view('supplier.create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{
            $user = Auth::user();

            $old_supplier = Supplier::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_supplier)){
                return ['status'=>401, 'reason'=>'This supplier name already exists'];
            }

            $supplier = NEW Supplier();
            $supplier->name = $request->name;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;

            /*
             * Update supplier photo
             * */
            $photo_path = '';
            if($request->hasFile('photo')){
                $file = $request->File('photo');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/suppliers');
                if(!File::exists($destinationPath)){
                    File::makeDirectory($destinationPath, 0775, true);
                }
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/suppliers/'.$file_name;
                $supplier->photo = $photo_path;
            }

            $supplier->created_by = $user->id;
            $supplier->created_at = date('Y-m-d h:i:s');
            $supplier->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function edit(Request $request)
    {
        try{
            $supplier = Supplier::select('suppliers.*')
                ->where('suppliers.id',$request->id)
                ->first();
            return view('supplier.edit',compact('supplier'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            $old_supplier = Supplier::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_supplier) && $old_supplier->id != $request->id){
                return ['status'=>401, 'reason'=>'This supplier name already exists'];
            }

            $supplier = Supplier::where('id',$request->id)->first();
            $supplier->name = $request->name;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;

            /*
             * Update supplier photo
             * */
            $photo_path = '';
            $old_photo_path = $request->old_photo_path;
            if($request->hasFile('photo')){
                $file = $request->File('photo');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/suppliers');
                if(!File::exists($destinationPath)){
                    File::makeDirectory($destinationPath, 0775, true);
                }
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/suppliers/'.$file_name;
                $supplier->photo = $photo_path;

                // Delete previous photo from physical folder
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }
            $supplier->updated_by = $user->id;
            $supplier->updated_at = date('Y-m-d h:i:s');
            $supplier->save();

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

            $supplier = Supplier::where('id',$request->supplier_id)->first();
            $supplier->status = 'deleted';
            $supplier->deleted_by = $user->id;
            $supplier->deleted_at = date('Y-m-d h:i:s');
            $supplier->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
