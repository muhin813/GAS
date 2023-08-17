<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\CustomerPayment;
use App\Models\OtherPayment;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class AccountController extends Controller
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
    public function supplierPayment(Request $request)
    {
        try{
            $suppliers = Supplier::where('status','active')->get();
            $purchases = Purchase::where('status','active')->get();

            $supplier_payments = SupplierPayment::select('supplier_payments.*','purchases.challan_no','purchases.total_value','suppliers.name as supplier_name');
            $supplier_payments = $supplier_payments->join('purchases','purchases.challan_no','=','supplier_payments.invoice_number');
            $supplier_payments = $supplier_payments->join('suppliers','suppliers.id','=','purchases.supplier_id');
            $supplier_payments = $supplier_payments->where('supplier_payments.status','active');
            if($request->supplier_id != ''){
                $supplier_payments = $supplier_payments->where('purchases.supplier_id',$request->supplier_id);
            }
            if($request->challan_number != ''){
                $supplier_payments = $supplier_payments->where('supplier_payments.invoice_number',$request->challan_number);
            }
            $supplier_payments = $supplier_payments->orderBy('purchases.challan_no','ASC');
            $supplier_payments = $supplier_payments->orderBy('supplier_payments.id','ASC');
            $supplier_payments = $supplier_payments->paginate(100);
            return view('account.supplier_payment',compact('suppliers','purchases','supplier_payments'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function supplierPaymentCreate(Request $request)
    {
        try{
            $purchases = Purchase::where('status','active')->get();
            return view('account.supplier_payment_create',compact('purchases'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function supplierPaymentStore(Request $request)
    {
        try{
            $user = Auth::user();
            $payment_data = SupplierPayment::selectRaw("SUM(paid_amount) as total_paid_amount")
                ->where('invoice_number',$request->invoice_number)
                ->where('status','active')
                ->first();
            $due_amount = $request->total_amount-($payment_data->total_paid_amount+$request->paid_amount);

            $supplier_payment = NEW SupplierPayment();
            $supplier_payment->invoice_number = $request->invoice_number;
            $supplier_payment->total_value = $request->total_amount;
            $supplier_payment->paid_amount = $request->paid_amount;
            $supplier_payment->due_amount = $due_amount;
            $supplier_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $supplier_payment->created_by = $user->id;
            $supplier_payment->created_at = date('Y-m-d h:i:s');
            $supplier_payment->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function supplierPaymentEdit(Request $request)
    {
        try{
            $purchases = Purchase::where('status','active')->get();
            $supplier_payment = SupplierPayment::select('supplier_payments.*','purchases.challan_no','purchases.total_value')
                ->join('purchases','purchases.challan_no','=','supplier_payments.invoice_number')
                ->where('supplier_payments.id',$request->id)
                ->first();
            return view('account.supplier_payment_edit',compact('purchases','supplier_payment'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function supplierPaymentUpdate(Request $request)
    {
        try{
            $user = Auth::user();
            $due_amount = $request->total_amount-$request->paid_amount;

            $supplier_payment = SupplierPayment::where('id',$request->id)->first();
            $supplier_payment->invoice_number = $request->invoice_number;
            $supplier_payment->total_value = $request->total_amount;
            $supplier_payment->paid_amount = $request->paid_amount;
            $supplier_payment->due_amount = $due_amount;
            $supplier_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $supplier_payment->updated_by = $user->id;
            $supplier_payment->updated_at = date('Y-m-d h:i:s');
            $supplier_payment->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function supplierPaymentDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $supplier_payment = SupplierPayment::where('id',$request->supplier_payment_id)->first();
            $supplier_payment->status = 'deleted';
            $supplier_payment->deleted_by = $user->id;
            $supplier_payment->deleted_at = date('Y-m-d h:i:s');
            $supplier_payment->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function otherPayment(Request $request)
    {
        try{
            $purchases = Purchase::where('status','active')->get();

            $other_payments = OtherPayment::select('other_payments.*');
            $other_payments = $other_payments->where('other_payments.status','active');
            /*if($request->challan_number != ''){
                $other_payments = $other_payments->where('other_payments.invoice_number',$request->challan_number);
            }*/
            $other_payments = $other_payments->orderBy('other_payments.id','ASC');
            $other_payments = $other_payments->paginate(100);
            return view('account.other_payment',compact('purchases','other_payments'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function otherPaymentCreate(Request $request)
    {
        try{
            $purchases = Purchase::where('status','active')->get();
            return view('account.other_payment_create',compact('purchases'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function otherPaymentStore(Request $request)
    {
        try{
            $user = Auth::user();
            $payment_data = OtherPayment::selectRaw("SUM(paid_amount) as total_paid_amount")
                ->where('invoice_number',$request->invoice_number)
                ->where('status','active')
                ->first();
            $due_amount = $request->total_amount-($payment_data->total_paid_amount+$request->paid_amount);

            $other_payment = NEW OtherPayment();
            $other_payment->invoice_number = $request->invoice_number;
            $other_payment->total_value = $request->total_amount;
            $other_payment->paid_amount = $request->paid_amount;
            $other_payment->due_amount = $due_amount;
            $other_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $other_payment->created_by = $user->id;
            $other_payment->created_at = date('Y-m-d h:i:s');
            $other_payment->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function otherPaymentEdit(Request $request)
    {
        try{
            $purchases = Purchase::where('status','active')->get();
            $other_payment = OtherPayment::select('other_payments.*','purchases.challan_no','purchases.total_value')
                ->join('purchases','purchases.challan_no','=','other_payments.invoice_number')
                ->where('other_payments.id',$request->id)
                ->first();
            return view('account.other_payment_edit',compact('purchases','other_payment'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function otherPaymentUpdate(Request $request)
    {
        try{
            $user = Auth::user();
            $due_amount = $request->total_amount-$request->paid_amount;

            $other_payment = OtherPayment::where('id',$request->id)->first();
            $other_payment->invoice_number = $request->invoice_number;
            $other_payment->total_value = $request->total_amount;
            $other_payment->paid_amount = $request->paid_amount;
            $other_payment->due_amount = $due_amount;
            $other_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $other_payment->updated_by = $user->id;
            $other_payment->updated_at = date('Y-m-d h:i:s');
            $other_payment->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function otherPaymentDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $other_payment = OtherPayment::where('id',$request->other_payment_id)->first();
            $other_payment->status = 'deleted';
            $other_payment->deleted_by = $user->id;
            $other_payment->deleted_at = date('Y-m-d h:i:s');
            $other_payment->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*public function customerPayment(Request $request)
    {
        try{
            $customers = Customer::where('status','active')->get();
            $sales = Sale::where('status','active')->get();

            $customer_payments = CustomerPayment::select('customer_payments.*','sales.invoice_number','sales.total_value','customers.name as customer_name');
            $customer_payments = $customer_payments->join('sales','sales.id','=','customer_payments.sales_id');
            $customer_payments = $customer_payments->join('customers','customers.id','=','sales.customer_id');
            $customer_payments = $customer_payments->where('customer_payments.status','active');
            if($request->invoice_number != ''){
                $customer_payments = $customer_payments->where('sales.invoice_number',$request->invoice_number);
            }
            if($request->customer_id != ''){
                $customer_payments = $customer_payments->where('sales.customer_id',$request->customer_id);
            }
            $customer_payments = $customer_payments->orderBy('sales.invoice_number','ASC');
            $customer_payments = $customer_payments->orderBy('customer_payments.id','ASC');
            $customer_payments = $customer_payments->paginate(100);
            return view('account.customer_payment',compact('customers','sales','customer_payments'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function customerPaymentCreate(Request $request)
    {
        try{
            $sales = Sale::where('status','active')->get();
            return view('account.customer_payment_create',compact('sales'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function customerPaymentStore(Request $request)
    {
        try{
            $user = Auth::user();
            $payment_data = CustomerPayment::selectRaw("SUM(received_amount) as total_received_amount")
                ->where('sales_id',$request->sales_id)
                ->where('status','active')
                ->first();
            $due_amount = $request->total_amount-($payment_data->total_received_amount+$request->received_amount);

            $customer_payment = NEW CustomerPayment();
            $customer_payment->sales_id = $request->sales_id;
            $customer_payment->received_amount = $request->received_amount;
            $customer_payment->due_amount = $due_amount;
            $customer_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $customer_payment->created_by = $user->id;
            $customer_payment->created_at = date('Y-m-d h:i:s');
            $customer_payment->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function customerPaymentEdit(Request $request)
    {
        try{
            $sales = Sale::where('status','active')->get();
            $customer_payment = CustomerPayment::select('customer_payments.*','sales.invoice_number','sales.total_value')
                ->join('sales','sales.id','=','customer_payments.sales_id')
                ->where('customer_payments.id',$request->id)
                ->first();
            return view('account.customer_payment_edit',compact('sales','customer_payment'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function customerPaymentUpdate(Request $request)
    {
        try{
            $user = Auth::user();
            $due_amount = $request->total_amount-$request->received_amount;

            $customer_payment = CustomerPayment::where('id',$request->id)->first();
            $customer_payment->sales_id = $request->sales_id;
            $customer_payment->received_amount = $request->received_amount;
            $customer_payment->due_amount = $due_amount;
            $customer_payment->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $customer_payment->updated_by = $user->id;
            $customer_payment->updated_at = date('Y-m-d h:i:s');
            $customer_payment->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function customerPaymentDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $customer_payment = CustomerPayment::where('id',$request->customer_payment_id)->first();
            $customer_payment->status = 'deleted';
            $customer_payment->deleted_by = $user->id;
            $customer_payment->deleted_at = date('Y-m-d h:i:s');
            $customer_payment->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }*/

    public function monthlyProfitLoss(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $year = $request->year;
            $month = $request->month;
            $profit_loss = [];
            foreach($months as $key=>$month){
                $start_date = $year.'/'.($key+1).'/'.'01';
                $end_date = $year.'/'.($key+1).'/'.'31';

                /*
                 * Getting sales record for this month
                 * */
                $sales = Sale::selectRaw("SUM(total_value) as total_sale_amount")
                    ->where('sales.status','active')
                    ->where('date_of_sale','>=',$start_date)
                    ->where('date_of_sale','<=',$end_date)
                    ->first();
                if(empty($sales)){
                    $profit_loss[$month]['sales'] = '';
                }
                else{
                    $profit_loss[$month]['sales'] = $sales->total_sale_amount;
                }

                /*
                 * Getting cost of sales record for this month
                 * */
                $productions_issue = Production::selectRaw("SUM(amount) as total_amount")
                    ->where('productions.type','issue')
                ->where('productions.status','active')
                ->where('productions.date_of_issue','>=',$start_date)
                ->where('productions.date_of_issue','<=',$end_date)
                ->first();
                if(empty($productions_issue)){
                    $profit_loss[$month]['cost_of_sales'] = '';
                }
                else{
                    $productions_return = Production::selectRaw("SUM(amount) as total_amount")
                        ->where('productions.type','return')
                        ->where('productions.status','active')
                        ->where('productions.date_of_issue','>=',$start_date)
                        ->where('productions.date_of_issue','<=',$end_date)
                        ->first();

                    $profit_loss[$month]['cost_of_sales'] = $productions_issue->total_amount-$productions_return->total_amount;
                }

                /*
                 * Calculating gross profit for this month
                 * */
                $gross_profit = (int)$profit_loss[$month]['sales']-(int)$profit_loss[$month]['cost_of_sales'];
                if($gross_profit==0){
                    $profit_loss[$month]['gross_profit'] = '';
                }
                else{
                    $profit_loss[$month]['gross_profit'] = $gross_profit;
                }

                /*
                 * Getting salary expense record for this month
                 * */
                $salary_expense = MonthlySalaryStatement::selectRaw("SUM(total_amount) as total_expense_amount")
                    ->where('year',$year)
                    ->where('month',$month)
                    ->where('status','active')
                    ->first();
                if(empty($salary_expense)){
                    $profit_loss[$month]['salary_expense'] = '';
                }
                else{
                    $profit_loss[$month]['salary_expense'] = $salary_expense->total_expense_amount;
                }

                /*
                 * Getting other expense record for this month
                 * */
                $other_expense = DailyExpense::selectRaw("SUM(amount) as total_expense_amount")
                    ->where('date_of_expense','>=',$start_date)
                    ->where('date_of_expense','<=',$end_date)
                    ->where('status','active')
                    ->first();
                if(empty($other_expense)) {
                    $profit_loss[$month]['other_expense'] = '';
                }
                else{
                    $profit_loss[$month]['other_expense'] = $other_expense->total_expense_amount;
                }

                /*
                 * Calculating net profit for this month
                 * */
                $net_profit = $gross_profit-((int)$profit_loss[$month]['salary_expense']+(int)$profit_loss[$month]['other_expense']);
                if($net_profit==0){
                    $profit_loss[$month]['net_profit'] = '';
                }
                else{
                    $profit_loss[$month]['net_profit'] = $net_profit;
                }

                /*
                 * Getting income tax record for this month
                 * */
                $income_tax = IncomeTax::where('year',$year)->where('month',$month)->first();
                if(empty($income_tax)){
                    $profit_loss[$month]['income_tax'] = '';
                }
                else{
                    $profit_loss[$month]['income_tax'] = $income_tax->tax_amount;
                }

                /*
                 * Calculating profit/loss for this month
                 * */
                $profit = $net_profit-(int)$profit_loss[$month]['income_tax'];
                if($profit==0){
                    $profit_loss[$month]['profit'] = '';
                }
                else{
                    $profit_loss[$month]['profit'] = $profit;
                }
            }
            return view('account.monthly_profit_loss',compact('months','profit_loss'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function costOfSale(Request $request)
    {
        try{
            $productions = Production::select('productions.*','production_machines.machine_number','purchases.goods_description','purchases.challan_number','purchases.unit_price','suppliers.name as supplier_name');
            $productions = $productions->leftJoin('production_machines','production_machines.id','=','productions.production_machine_id');
            $productions = $productions->join('purchases','purchases.challan_number','=','productions.challan_number');
            $productions = $productions->join('suppliers','suppliers.id','=','purchases.supplier_id');
            $productions = $productions->where('productions.status','active');
            if($request->month != ''){
                $productions = $productions->whereMonth('productions.date_of_issue',$request->month);
            }
            if($request->production_machine_id != ''){
                $productions = $productions->where('productions.production_machine_id',$request->production_machine_id);
            }
            if($request->challan_number != ''){
                $productions = $productions->where('productions.challan_number',$request->challan_number);
            }
            $productions = $productions->orderBy('productions.date_of_issue','DESC');
            $productions = $productions->paginate(100);
            return view('account.cost_of_sales',compact('productions'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }
}
