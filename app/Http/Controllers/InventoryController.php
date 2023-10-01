<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\StockIssue;
use App\Models\StockReturn;
use App\Models\Job;
use App\Common;
use Auth;
use File;
use Session;

class InventoryController extends Controller
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
    public function stockRecord(Request $request)
    {
        try{
            $items = Item::whereIn('items.status',['active'])->get();
            $suppliers = Supplier::whereIn('suppliers.status',['active'])->get();
            $all_purchases = Purchase::whereIn('status',['active'])->get();

            $purchases = Purchase::select('purchases.*','items.name as item_name','items.description as item_description','item_categories.name as category_name','suppliers.name as supplier_name','item_uoms.name as item_uom','package_uoms.name as package_uom');
            $purchases = $purchases->join('items','items.id','=','purchases.item_id');
            $purchases = $purchases->join('item_categories','item_categories.id','=','items.category_id');
            $purchases = $purchases->join('suppliers','suppliers.id','=','purchases.supplier_id');
            $purchases = $purchases->join('item_uoms','item_uoms.id','=','purchases.item_uom_id');
            $purchases = $purchases->join('package_uoms','package_uoms.id','=','purchases.package_uom_id');
            $purchases = $purchases->whereIn('purchases.status',['active','inactive']);
            if($request->month != ''){
                $purchases = $purchases->whereMonth('date_of_purchase',$request->month);
                $purchases = $purchases->whereYear('date_of_purchase',date('Y'));
            }
            if($request->item_id != ''){
                $purchases = $purchases->where('item_id',$request->item_id);
            }
            if($request->supplier_id != ''){
                $purchases = $purchases->where('supplier_id',$request->supplier_id);
            }
            if($request->challan_no != ''){
                $purchases = $purchases->where('challan_no',$request->challan_no);
            }
            $purchases = $purchases->paginate(50);
            return view('inventory.stock_record',compact('all_purchases','items','suppliers','purchases'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockIssueIndex(Request $request)
    {
        try{
        $stock_issues = StockIssue::select('stock_issues.*','purchases.unit_price','items.name as item_name','item_uoms.name as item_uom');
        $stock_issues = $stock_issues->join('purchases','purchases.challan_no','=','stock_issues.supplier_invoice_number');
        $stock_issues = $stock_issues->join('items','items.id','=','purchases.item_id');
        $stock_issues = $stock_issues->join('item_uoms','item_uoms.id','=','purchases.item_uom_id');
        $stock_issues = $stock_issues->whereIn('stock_issues.status',['active','inactive']);
        $stock_issues = $stock_issues->paginate(50);
        return view('inventory.stock_issue_index',compact('stock_issues'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockIssueCreate(Request $request)
    {
        try{
            $purchases = Purchase::whereIn('status',['active'])->get();
            $jobs = Job::whereIn('status',['active'])->get();
            return view('inventory.stock_issue_create',compact('purchases','jobs'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockIssueStore(Request $request)
    {
        try{
            $user = Auth::user();

            $purchase = Purchase::select('purchases.*')->where('purchases.challan_no',$request->supplier_invoice_number)->first();

            $total_value = $request->quantity*$purchase->unit_price;

            $stock_issue = NEW StockIssue();
            $stock_issue->date_of_issue = date('Y-m-d',strtotime($request->date_of_issue));
            $stock_issue->supplier_invoice_number = $request->supplier_invoice_number;
            $stock_issue->quantity = $request->quantity;
            $stock_issue->item_id = $purchase->item_id;
            $stock_issue->item_uom_id = $purchase->item_uom_id;
            $stock_issue->unit_price = $purchase->unit_price;
            $stock_issue->total_value = $total_value;
            $stock_issue->job_tracking_number = $request->job_tracking_number;
            $stock_issue->created_by = $user->id;
            $stock_issue->created_at = date('Y-m-d h:i:s');
            $stock_issue->save();

            /*
             * Updating purchase balance quantity
             * */
            $this->updatePurchaseBalanceQuantity($request->supplier_invoice_number);


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function stockIssueEdit(Request $request)
    {
        try{
            $purchases = Purchase::whereIn('status',['active'])->get();
            $jobs = Job::whereIn('status',['active'])->get();

            $stock_issue = StockIssue::select('stock_issues.*','items.name as item_name')
                ->join('purchases','purchases.challan_no','=','stock_issues.supplier_invoice_number')
                ->join('items','items.id','=','purchases.item_id')
                ->where('stock_issues.id',$request->id)
                ->first();
            return view('inventory.stock_issue_edit',compact('purchases','jobs','stock_issue'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockIssueUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            //$purchase = Purchase::select('purchases.*')->where('purchases.challan_no',$request->supplier_invoice_number)->first();
            //$total_value = $request->quantity*$purchase->unit_price;

            $stock_issue = StockIssue::where('id',$request->id)->first();
            $stock_issue->date_of_issue = date('Y-m-d',strtotime($request->date_of_issue));
            //$stock_issue->supplier_invoice_number = $request->supplier_invoice_number;
            //$stock_issue->quantity = $request->quantity;
            //$stock_issue->item_id = $purchase->item_id;
            //$stock_issue->item_uom_id = $purchase->item_uom_id;
            //$stock_issue->unit_price = $purchase->unit_price;
            //$stock_issue->total_value = $total_value;
            $stock_issue->job_tracking_number = $request->job_tracking_number;
            $stock_issue->updated_by = $user->id;
            $stock_issue->updated_at = date('Y-m-d h:i:s');
            $stock_issue->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function stockIssueDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $stock_issue = StockIssue::where('id',$request->stock_issue_id)->first();
            $supplier_invoice_number = $stock_issue->supplier_invoice_number;

            $stock_issue->status = 'deleted';
            $stock_issue->deleted_by = $user->id;
            $stock_issue->deleted_at = date('Y-m-d h:i:s');
            $stock_issue->save();

            /*
             * Updating purchase balance quantity
             * */
            $this->updatePurchaseBalanceQuantity($supplier_invoice_number);

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function getPurchaseDetails(Request $request)
    {
        try{
            $purchase = Purchase::select('purchases.*','items.name as item_name')
                ->join('items','items.id','=','purchases.item_id')
                ->where('purchases.challan_no',$request->invoice_number)
                ->first();
            return ['status'=>200, 'purchase'=>$purchase];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function stockReturnIndex(Request $request)
    {
        try{
            $stock_returns = StockReturn::select('stock_returns.*','purchases.unit_price','items.name as item_name','item_uoms.name as item_uom');
            $stock_returns = $stock_returns->join('purchases','purchases.challan_no','=','stock_returns.supplier_invoice_number');
            $stock_returns = $stock_returns->join('items','items.id','=','purchases.item_id');
            $stock_returns = $stock_returns->join('item_uoms','item_uoms.id','=','purchases.item_uom_id');
            $stock_returns = $stock_returns->whereIn('stock_returns.status',['active','inactive']);
            $stock_returns = $stock_returns->paginate(50);
            return view('inventory.stock_return_index',compact('stock_returns'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockReturnCreate(Request $request)
    {
        try{
            $purchases = Purchase::whereIn('status',['active'])->get();
            $jobs = Job::whereIn('status',['active'])->get();
            return view('inventory.stock_return_create',compact('purchases','jobs'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockReturnStore(Request $request)
    {
        try{
            $user = Auth::user();

            $purchase = Purchase::select('purchases.*')->where('purchases.challan_no',$request->supplier_invoice_number)->first();

            $total_value = $request->quantity*$purchase->unit_price;

            $stock_return = NEW StockReturn();
            $stock_return->date_of_return = date('Y-m-d',strtotime($request->date_of_return));
            $stock_return->supplier_invoice_number = $request->supplier_invoice_number;
            $stock_return->quantity = $request->quantity;
            $stock_return->item_id = $purchase->item_id;
            $stock_return->total_value = $total_value;
            $stock_return->job_tracking_number = $request->job_tracking_number;
            $stock_return->created_by = $user->id;
            $stock_return->created_at = date('Y-m-d h:i:s');
            $stock_return->save();

            /*
             * Updating purchase balance quantity
             * */
            $this->updatePurchaseBalanceQuantity($request->supplier_invoice_number);


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function stockReturnEdit(Request $request)
    {
        try{
            $purchases = Purchase::whereIn('status',['active'])->get();
            $jobs = Job::whereIn('status',['active'])->get();

            $stock_return = StockReturn::select('stock_returns.*','items.name as item_name')
                ->join('purchases','purchases.challan_no','=','stock_returns.supplier_invoice_number')
                ->join('items','items.id','=','purchases.item_id')
                ->where('stock_returns.id',$request->id)
                ->first();
            return view('inventory.stock_return_edit',compact('purchases','jobs','stock_return'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function stockReturnUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            //$purchase = Purchase::select('purchases.*')->where('purchases.challan_no',$request->supplier_invoice_number)->first();
            //$total_value = $request->quantity*$purchase->unit_price;

            $stock_return = StockReturn::where('id',$request->id)->first();
            $stock_return->date_of_return = date('Y-m-d',strtotime($request->date_of_return));
            //$stock_return->supplier_invoice_number = $request->supplier_invoice_number;
            //$stock_return->quantity = $request->quantity;
            //$stock_return->item_id = $purchase->item_id;
            //$stock_return->item_uom_id = $purchase->item_uom_id;
            //$stock_return->unit_price = $purchase->unit_price;
            //$stock_return->total_value = $total_value;
            $stock_return->job_tracking_number = $request->job_tracking_number;
            $stock_return->updated_by = $user->id;
            $stock_return->updated_at = date('Y-m-d h:i:s');
            $stock_return->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function stockReturnDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $stock_return = StockReturn::where('id',$request->stock_return_id)->first();
            $supplier_invoice_number = $stock_return->supplier_invoice_number;

            $stock_return->status = 'deleted';
            $stock_return->deleted_by = $user->id;
            $stock_return->deleted_at = date('Y-m-d h:i:s');
            $stock_return->save();

            /*
             * Updating purchase balance quantity
             * */
            $this->updatePurchaseBalanceQuantity($supplier_invoice_number);

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    private function updatePurchaseBalanceQuantity($supplier_invoice_number){
        $purchase = Purchase::select('purchases.*')->where('purchases.challan_no',$supplier_invoice_number)->first();

        $total_issue_quantity = StockIssue::where('supplier_invoice_number',$supplier_invoice_number)->where('status', 'active')->sum('quantity');
        $total_return_quantity = StockReturn::where('supplier_invoice_number',$supplier_invoice_number)->where('status', 'active')->sum('quantity');
        $purchase->balance_quantity = $purchase->quantity-($total_issue_quantity-$total_return_quantity);
        $purchase->save();
    }

}
