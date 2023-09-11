<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemUom;
use App\Models\ItemCategory;
use App\Models\Purchase;
use App\Models\Package;
use App\Models\PackageUom;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;

class PurchaseController extends Controller
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
            $items = Item::whereIn('items.status',['active'])->get();
            $suppliers = Supplier::whereIn('suppliers.status',['active'])->get();

            $purchases = Purchase::select('purchases.*','items.name as item_name','item_categories.name as category_name','suppliers.name as supplier_name','item_uoms.name as item_uom','package_uoms.name as package_uom');
            $purchases = $purchases->join('items','items.id','=','purchases.item_id');
            $purchases = $purchases->join('item_categories','item_categories.id','=','items.category_id');
            $purchases = $purchases->join('suppliers','suppliers.id','=','purchases.supplier_id');
            $purchases = $purchases->join('item_uoms','item_uoms.id','=','purchases.item_uom_id');
            $purchases = $purchases->join('package_uoms','package_uoms.id','=','purchases.package_uom_id');
            $purchases = $purchases->whereIn('purchases.status',['active','inactive']);
            if($request->item != ''){
                $purchases = $purchases->where('purchases.item_id',$request->item);
            }
            if($request->supplier != ''){
                $purchases = $purchases->where('purchases.supplier_id',$request->supplier);
            }
            $purchases = $purchases->paginate(50);
            return view('purchase.index',compact('items','suppliers','purchases'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            $items = Item::whereIn('items.status',['active'])->get();
            $item_uoms = ItemUom::whereIn('item_uoms.status',['active'])->get();
            $suppliers = Supplier::whereIn('suppliers.status',['active'])->get();
            $package_uoms = PackageUom::whereIn('package_uoms.status',['active'])->get();
            return view('purchase.create',compact('items','item_uoms','suppliers','package_uoms'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{
            $user = Auth::user();

            $old_purchase = Purchase::where('challan_no',$request->challan_no)->where('status','!=','deleted')->first();
            if(!empty($old_purchase)){
                return ['status'=>401, 'reason'=>'The purchase with this challan number already exists'];
            }

            $total_value = $request->quantity*$request->unit_price;

            $purchase = NEW Purchase();
            $purchase->date_of_purchase = date('Y-m-d',strtotime($request->date_of_purchase));
            $purchase->item_id = $request->item_id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->quantity = $request->quantity;
            $purchase->item_uom_id = $request->item_uom_id;
            $purchase->package = $request->package;
            $purchase->package_uom_id = $request->package_uom_id;
            $purchase->challan_no = $request->challan_no;
            $purchase->unit_price = $request->unit_price;
            $purchase->total_value = $total_value;
            $purchase->balance_quantity = $request->quantity;
            $purchase->created_by = $user->id;
            $purchase->created_at = date('Y-m-d h:i:s');
            $purchase->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
    public function getDetails(Request $request)
    {
        try{
            $purchase = Purchase::select('purchases.*')
                ->where('purchases.challan_no',$request->invoice_number)
                ->first();
            return ['status'=>200, 'purchase'=>$purchase];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>$e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try{
            $items = Item::whereIn('items.status',['active'])->get();
            $item_uoms = ItemUom::whereIn('item_uoms.status',['active'])->get();
            $suppliers = Supplier::whereIn('suppliers.status',['active'])->get();
            $package_uoms = PackageUom::whereIn('package_uoms.status',['active'])->get();

            $purchase = Purchase::select('purchases.*')
                ->where('purchases.id',$request->id)
                ->first();
            return view('purchase.edit',compact('items','item_uoms','suppliers','package_uoms','purchase'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            $old_purchase = Purchase::where('challan_no',$request->challan_no)->where('status','!=','deleted')->first();
            if(!empty($old_purchase) && $old_purchase->id != $request->id){
                return ['status'=>401, 'reason'=>'The purchase with this challan number already exists'];
            }

            $total_value = $request->quantity*$request->unit_price;

            $purchase = Purchase::where('id',$request->id)->first();
            $purchase->date_of_purchase = date('Y-m-d',strtotime($request->date_of_purchase));
            $purchase->item_id = $request->item_id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->quantity = $request->quantity;
            $purchase->item_uom_id = $request->item_uom_id;
            $purchase->package = $request->package;
            $purchase->package_uom_id = $request->package_uom_id;
            $purchase->challan_no = $request->challan_no;
            $purchase->unit_price = $request->unit_price;
            $purchase->total_value = $total_value;
            $purchase->updated_by = $user->id;
            $purchase->updated_at = date('Y-m-d h:i:s');
            $purchase->save();

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

            $purchase = Purchase::where('id',$request->purchase_id)->first();
            $purchase->status = 'deleted';
            $purchase->deleted_by = $user->id;
            $purchase->deleted_at = date('Y-m-d h:i:s');
            $purchase->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
