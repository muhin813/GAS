<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Job;
use App\Models\Operation;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SalesDetail;
use App\Models\SalesServiceCostingDetail;
use App\Models\SalesProductCostingDetail;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role == 4) {
                return redirect('error_404');
            }
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try{
            $sales_types = ['service'=>'Service Sales','product'=>'Product Sales'];
            $sales = Sale::with('details');
            $sales = $sales->select('sales.*','customers.first_name','customers.last_name','customers.registration_number as customer_registration_number');
            $sales = $sales->join('customers','customers.registration_number','=','sales.customer_registration_number');
            $sales = $sales->whereIn('sales.status',['active','inactive']);
            $sales = $sales->paginate(50);
            return view('sale.index',compact('sales_types','sales'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            $jobs = Job::whereIn('status',['active'])->get();
            $customers = Customer::where('status','active')->get();
            $service_categories = ServiceCategory::where('status','active')->get();
            $items = Item::where('status','active')->get();
            return view('sale.create',compact('jobs','customers','service_categories','items'));
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

            if($request->sales_type=='service'){
                $total_amount = $request->service_amount;
                if($request->discount != '' && $request->discount != 0){
                    $discount_amount = $total_amount*($request->discount/100);
                    $total_amount = $total_amount-$discount_amount;
                }
                if($request->vat != '' && $request->vat != 0){
                    $vat_amount = $total_amount*($request->vat/100);
                    $grand_total_amount = $total_amount+$vat_amount;
                }
            }


            $sale = NEW Sale();
            $sale->date_of_sale = date('Y-m-d');
            $sale->sales_type = $request->sales_type;
            $sale->job_tracking_number = $request->job_tracking_number;
            $sale->customer_registration_number = $request->customer_registration_number;
            $sale->service_category_id = $request->service_category_id;
            $sale->service_type_id = $request->service_type_id;
            $sale->service_amount = $request->service_amount;
            $sale->discount = $request->discount;
            $sale->vat = $request->vat;
            $sale->created_by = $user->id;
            $sale->created_at = date('Y-m-d h:i:s');
            $sale->save();

            /*
             * Saving sales type product details
             * */
            if($request->sales_type=='product'){
                $products = $request->products;
                $product_quantities = $request->product_quantities;
                $product_unit_prices = $request->unit_prices;
                $product_discounts = $request->discounts;

                $grand_total_amount = 0;

                foreach($products as $key=>$product){
                    $total_amount = $product_quantities[$key]*$product_unit_prices[$key];
                    if($product_discounts[$key] != '' && $product_discounts[$key] != 0){
                        $discount_amount = $total_amount*($product_discounts[$key]/100);
                        $total_amount = $total_amount-$discount_amount;
                    }
                    $grand_total_amount = $grand_total_amount+$total_amount;

                    $sale_detail = NEW SalesDetail();
                    $sale_detail->sales_id = $sale->id;
                    $sale_detail->item_id = $products[$key];
                    $sale_detail->quantity = $product_quantities[$key];
                    $sale_detail->unit_price = $product_unit_prices[$key];
                    $sale_detail->discount = $product_discounts[$key];
                    $sale_detail->total_value = $total_amount;
                    $sale_detail->save();
                }

                // Calculating total amount
                if($request->vat != '' && $request->vat != 0){
                    $vat_amount = $grand_total_amount*($request->vat/100);
                    $grand_total_amount = $grand_total_amount+$vat_amount;
                }
            }

            /*
             * Generate and update invoice number and total amount
             * */
            $sale_update = Sale::where('id',$sale->id)->first();
            if($request->sales_type=='service'){
                $sale_update->invoice_number = 'S-'.Common::addLeadingZero($sale->id,5);
            }
            else{
                $sale_update->invoice_number = 'P-'.Common::addLeadingZero($sale->id,5);
            }
            $sale_update->total_amount = $grand_total_amount;
            $sale_update->save();

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function getDetails(Request $request)
    {
        try{
            $sale = Sale::with('details')->select('sales.*','customers.first_name','customers.last_name','customers.address as customer_address','customers.phone as customer_phone','customers.email as customer_email','service_categories.name as service_category_name','service_types.name as service_type_name','customer_vehicle_credentials.registration_number as vehicle_number')
                ->join('customers','customers.registration_number','=','sales.customer_registration_number')
                ->leftJoin('service_categories','service_categories.id','=','sales.service_category_id')
                ->leftJoin('service_types','service_types.id','=','sales.service_type_id')
                ->leftJoin('jobs','jobs.tracking_number','=','sales.job_tracking_number')
                ->leftJoin('customer_vehicle_credentials','customer_vehicle_credentials.id','=','jobs.customer_vehicle_credential_id')
                ->where('sales.id',$request->sales_id)
                ->first();
            return ['status'=>200, 'sale'=>$sale];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function getCostingDetails(Request $request)
    {
        try{
            $sale = Sale::select('sales.*')->where('sales.id',$request->sales_id)->first();

            if($sale->sales_type=='service'){
                $items = [];
                $sale_costings = SalesServiceCostingDetail::where('sales_id',$sale->id)->get();
            }
            else{
                $sales_item_ids = SalesDetail::select('item_id')->where('sales_id',$request->sales_id)->pluck('item_id')->toArray(); // Getting item ids of this sale
                $items = Item::whereIn('id',$sales_item_ids)->where('status','active')->get();
                $sale_costings = SalesProductCostingDetail::where('sales_id',$sale->id)->get();
            }
            return ['status'=>200, 'items'=>$items, 'sale'=>$sale, 'sale_costings'=>$sale_costings];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function storeCosting(Request $request)
    {
        try{
            $user = Auth::user();
            $sale = Sale::select('sales.*')->where('sales.id',$request->sales_id)->first();

            $grand_total_amount = 0;

            if($sale->sales_type=='product'){
                SalesProductCostingDetail::where('sales_id',$request->sales_id)->delete();

                $item_id = $request->products;
                //$unit_price = $request->unit_price;
                $total_value = $request->total_amount;
                foreach($item_id as $key=>$item){
                    $sale_costings = NEW SalesProductCostingDetail();
                    $sale_costings->sales_id = $request->sales_id;
                    $sale_costings->item_id = $item_id[$key];
                    //$sale_costings->unit_price = $unit_price[$key];
                    $sale_costings->total_value = $total_value[$key];
                    $sale_costings->created_at = date('Y-m-d h:i:s');
                    $sale_costings->save();

                    $grand_total_amount = $grand_total_amount+$total_value[$key];
                }
            }
            else{ // If sales type is service sales
                SalesServiceCostingDetail::where('sales_id',$request->sales_id)->delete();

                $cost_name = $request->cost_name;
                $cost_amount = $request->amount;
                foreach($cost_name as $key=>$name){
                    $sale_costings = NEW SalesServiceCostingDetail();
                    $sale_costings->sales_id = $request->sales_id;
                    $sale_costings->cost_name = $cost_name[$key];
                    $sale_costings->total_value = $cost_amount[$key];
                    $sale_costings->created_at = date('Y-m-d h:i:s');
                    $sale_costings->save();

                    $grand_total_amount = $grand_total_amount+$cost_amount[$key];
                }
            }

            // Now update sales total costing
            $sale->costing_amount = $grand_total_amount;
            $sale->updated_by = $user->id;
            $sale->updated_at = date('Y-m-d h:i:s');
            $sale->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function edit(Request $request)
    {
        try{
            $jobs = Job::whereIn('status',['active'])->get();
            $customers = Customer::where('status','active')->get();
            $service_categories = ServiceCategory::where('status','active')->get();
            $items = Item::where('status','active')->get();

            $sale = Sale::with('details')->select('sales.*')
                ->where('sales.id',$request->id)
                ->first();
            return view('sale.edit',compact('jobs','customers','service_categories','items','sale'));
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

            if($request->sales_type=='service'){
                $total_amount = $request->service_amount;
                if($request->discount != '' && $request->discount != 0){
                    $discount_amount = $total_amount*($request->discount/100);
                    $total_amount = $total_amount-$discount_amount;
                }
                if($request->vat != '' && $request->vat != 0){
                    $vat_amount = $total_amount*($request->vat/100);
                    $grand_total_amount = $total_amount+$vat_amount;
                }
            }

            $sale = Sale::where('id',$request->id)->first();
            $sale->sales_type = $request->sales_type;
            $sale->job_tracking_number = $request->job_tracking_number;
            $sale->customer_registration_number = $request->customer_registration_number;
            $sale->service_category_id = $request->service_category_id;
            $sale->service_type_id = $request->service_type_id;
            $sale->service_amount = $request->service_amount;
            $sale->discount = $request->discount;
            $sale->vat = $request->vat;
            $sale->updated_by = $user->id;
            $sale->updated_at = date('Y-m-d h:i:s');
            $sale->save();

            /*
             * Saving sales type product details
             * */
            SalesDetail::where('sales_id',$sale->id)->delete();
            if($request->sales_type=='product') {
                $products = $request->products;
                $product_quantities = $request->product_quantities;
                $product_unit_prices = $request->unit_prices;
                $product_discounts = $request->discounts;

                $grand_total_amount = 0;

                foreach($products as $key=>$product){
                    $total_amount = $product_quantities[$key]*$product_unit_prices[$key];
                    if($product_discounts[$key] != '' && $product_discounts[$key] != 0){
                        $discount_amount = $total_amount*($product_discounts[$key]/100);
                        $total_amount = $total_amount-$discount_amount;
                    }
                    $grand_total_amount = $grand_total_amount+$total_amount;

                    $sale_detail = NEW SalesDetail();
                    $sale_detail->sales_id = $sale->id;
                    $sale_detail->item_id = $products[$key];
                    $sale_detail->quantity = $product_quantities[$key];
                    $sale_detail->unit_price = $product_unit_prices[$key];
                    $sale_detail->discount = $product_discounts[$key];
                    $sale_detail->total_value = $total_amount;
                    $sale_detail->save();
                }

                // Calculating total amount
                if($request->vat != '' && $request->vat != 0){
                    $vat_amount = $grand_total_amount*($request->vat/100);
                    $grand_total_amount = $grand_total_amount+$vat_amount;
                }
            }

            /*
             * Generate and update invoice number and total amount
             * */
            $sale_update = Sale::where('id',$sale->id)->first();
            $sale_update->total_amount = $grand_total_amount;
            $sale_update->save();

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

            $sale = Sale::where('id',$request->sale_id)->first();
            $sale->status = 'deleted';
            $sale->deleted_by = $user->id;
            $sale->deleted_at = date('Y-m-d h:i:s');
            $sale->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function serviceSalesReport(Request $request)
    {
        try{
            $sales = Sale::with('details');
            $sales = $sales->select('sales.*','customers.first_name','customers.last_name','customers.registration_number as customer_registration_number');
            $sales = $sales->join('customers','customers.registration_number','=','sales.customer_registration_number');
            $sales = $sales->where('sales.sales_type','service');
            $sales = $sales->whereIn('sales.status',['active','inactive']);
            $sales = $sales->paginate(50);
            return view('sale.service_sales_report',compact('sales'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function productSalesReport(Request $request)
    {
        try{
            $sales = Sale::with('details');
            $sales = $sales->select('sales.*','customers.first_name','customers.last_name','customers.registration_number as customer_registration_number');
            $sales = $sales->join('customers','customers.registration_number','=','sales.customer_registration_number');
            $sales = $sales->where('sales.sales_type','product');
            $sales = $sales->whereIn('sales.status',['active','inactive']);
            $sales = $sales->paginate(50);
            return view('sale.product_sales_report',compact('sales'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }
}
