<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\ChequeBook;
use App\Models\IncomeTax;
use App\Models\Party;
use App\Models\StockIssue;
use App\Models\StockReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\CashBook;
use App\Models\BankBook;
use App\Models\BankReconciliation;
use App\Models\SupplierPayment;
use App\Models\Sale;
use App\Models\OtherPayment;
use App\Models\Setting;
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
    public function cashBook(Request $request)
    {
        try{
            $cash_books = CashBook::select('cash_books.*');
            $cash_books = $cash_books->where('cash_books.status','active');
            $cash_books = $cash_books->orderBy('cash_books.id','ASC');
            $cash_books = $cash_books->paginate(100);
            return view('account.cash_book',compact('cash_books'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function cashBookCreate(Request $request)
    {
        try{
            return view('account.cash_book_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function cashBookStore(Request $request)
    {
        try{
            $user = Auth::user();

            $cash_book = NEW CashBook();
            $cash_book->date = date('Y-m-d', strtotime($request->date));
            $cash_book->debit_party = $request->debit_party;
            $cash_book->credit_party = $request->credit_party;
            $cash_book->amount = $request->amount;
            $cash_book->narration = $request->narration;
            $cash_book->created_by = $user->id;
            $cash_book->created_at = date('Y-m-d h:i:s');
            $cash_book->save();

            /*
             * Update system cash in hand
             * */
            $general_settings = Setting::first();
            if($request->debit_party=='cash' || $request->debit_party=='Cash'){
                $general_settings->cash_in_hand_opening_balance = $general_settings->cash_in_hand_opening_balance+$request->amount;
            }
            else if($request->credit_party=='cash' || $request->credit_party=='Cash'){
                $general_settings->cash_in_hand_opening_balance = $general_settings->cash_in_hand_opening_balance-$request->amount;
            }
            $general_settings->updated_at = date('Y-m-d h:i:s');
            $general_settings->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function cashBookEdit(Request $request)
    {
        try{
            $cash_book = CashBook::select('cash_books.*')
                ->where('cash_books.id',$request->id)
                ->first();
            return view('account.cash_book_edit',compact('cash_book'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function cashBookUpdate(Request $request)
    {
        try{
            $user = Auth::user();


            $cash_book = CashBook::where('id',$request->id)->first();
            $cash_book->date = date('Y-m-d', strtotime($request->date));
            $cash_book->debit_party = $request->debit_party;
            $cash_book->credit_party = $request->credit_party;
            $cash_book->amount = $request->amount;
            $cash_book->narration = $request->narration;
            $cash_book->updated_by = $user->id;
            $cash_book->updated_at = date('Y-m-d h:i:s');
            $cash_book->save();

            /*
             * Update system cash in hand
             * */
            $general_settings = Setting::first();
            //First revert to original cash_in_hand_opening_balance
            if($request->debit_party_old=='cash' || $request->debit_party_old=='Cash'){
                $cash_in_hand_opening_balance = $general_settings->cash_in_hand_opening_balance-$request->amount_old; // Revert to original amount by substracting added amount (as debit party was cash)
            }
            else if($request->credit_party_old=='cash' || $request->credit_party_old=='Cash'){
                $cash_in_hand_opening_balance = $general_settings->cash_in_hand_opening_balance+$request->amount_old; // Revert to original amount by adding substracted amount (as credit party was cash)
            }

            // Now calculate and update cash_in_hand_opening_balance with edited amount and party
            if($request->debit_party=='cash' || $request->debit_party=='Cash'){
                $general_settings->cash_in_hand_opening_balance = $cash_in_hand_opening_balance+$request->amount;
            }
            else if($request->credit_party=='cash' || $request->credit_party=='Cash'){
                $general_settings->cash_in_hand_opening_balance = $cash_in_hand_opening_balance-$request->amount;
            }

            $general_settings->updated_at = date('Y-m-d h:i:s');
            $general_settings->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function cashBookDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $cash_book = CashBook::where('id',$request->cash_book_id)->first();
            $cash_book->status = 'deleted';
            $cash_book->deleted_by = $user->id;
            $cash_book->deleted_at = date('Y-m-d h:i:s');
            $cash_book->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBook(Request $request)
    {
        try{
            $bank_books = BankBook::select('bank_books.*','banks.name as bank_name','parties.party_name');
            $bank_books = $bank_books->join('banks','banks.id','=','bank_books.bank_id');
            $bank_books = $bank_books->join('parties','parties.id','=','bank_books.party');
            $bank_books = $bank_books->where('bank_books.status','active');
            $bank_books = $bank_books->orderBy('bank_books.id','ASC');
            $bank_books = $bank_books->paginate(100);
            return view('account.bank_book',compact('bank_books'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function getBankBookByMonth(Request $request)
    {
        try{
            $bank_books = BankBook::select('bank_books.*');
            $bank_books = $bank_books->whereMonth('bank_books.date',$request->month);
            $bank_books = $bank_books->whereYear('bank_books.date',$request->year);
            $bank_books = $bank_books->where('bank_books.status','active');
            $bank_books = $bank_books->orderBy('bank_books.id','ASC');
            $bank_books = $bank_books->get();
            return ['status'=>200, 'bank_books'=>$bank_books];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBookCreate(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            $bank_accounts = BankAccount::where('status','active')->get();
            $cheque_books = ChequeBook::where('status','active')->get();
            $parties = Party::where('status','active')->get();
            return view('account.bank_book_create',compact('banks','bank_accounts','cheque_books','parties'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankBookStore(Request $request)
    {
        try{
            $user = Auth::user();

            DB::beginTransaction();

            $bank_book = NEW BankBook();
            $bank_book->transaction_type = $request->transaction_type;
            $bank_book->date = date('Y-m-d', strtotime($request->date));
            $bank_book->bank_id = $request->bank_id;
            $bank_book->account_number = $request->account_number;
            $bank_book->cheque_book_number = $request->cheque_book_number;
            $bank_book->cheque_number = $request->cheque_number;
            $bank_book->party = $request->party;
            $bank_book->amount = $request->amount;
            $bank_book->narration = $request->narration;
            $bank_book->created_by = $user->id;
            $bank_book->created_at = date('Y-m-d h:i:s');
            $bank_book->save();

            /*
             * Update bank account opening balance
             * */
            $bank_account = BankAccount::where('account_number',$request->account_number)->first();
            if($request->transaction_type=='Receive'){
                $bank_account->opening_balance = $bank_account->opening_balance+$request->amount;
            }
            else{
                $bank_account->opening_balance = $bank_account->opening_balance-$request->amount;
            }
            $bank_account->updated_at = date('Y-m-d h:i:s');
            $bank_account->save();

            DB::commit();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBookEdit(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            $bank_accounts = BankAccount::where('status','active')->get();
            $cheque_books = ChequeBook::where('status','active')->get();
            $parties = Party::where('status','active')->get();
            $bank_book = BankBook::select('bank_books.*')
                ->where('bank_books.id',$request->id)
                ->first();
            return view('account.bank_book_edit',compact('banks','cheque_books','bank_accounts','parties','bank_book'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankBookUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            DB::beginTransaction();

            $bank_book = BankBook::where('id',$request->id)->first();
            $bank_book->transaction_type = $request->transaction_type;
            $bank_book->date = date('Y-m-d', strtotime($request->date));
            $bank_book->bank_id = $request->bank_id;
            $bank_book->account_number = $request->account_number;
            $bank_book->cheque_book_number = $request->cheque_book_number;
            $bank_book->cheque_number = $request->cheque_number;
            $bank_book->party = $request->party;
            $bank_book->amount = $request->amount;
            $bank_book->narration = $request->narration;
            $bank_book->updated_by = $user->id;
            $bank_book->updated_at = date('Y-m-d h:i:s');
            $bank_book->save();

            /*
             * Update bank account opening balance
             * */

            // First revert old back account opening balance transaction
            $bank_account_old = BankAccount::where('account_number',$request->account_number_old)->first();
            if($request->transaction_type_old=='Receive'){
                $bank_account_old->opening_balance = $bank_account_old->opening_balance-$request->amount_old;
            }
            else{
                $bank_account_old->opening_balance = $bank_account_old->opening_balance+$request->amount;
            }
            $bank_account_old->save();

            // Now calculate and update back account opening balance new transaction
            $bank_account = BankAccount::where('account_number',$request->account_number)->first();
            if($request->transaction_type=='Receive'){
                $bank_account->opening_balance = $bank_account->opening_balance+$request->amount;
            }
            else{
                $bank_account->opening_balance = $bank_account->opening_balance-$request->amount;
            }
            $bank_account->updated_at = date('Y-m-d h:i:s');
            $bank_account->save();

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            DB::rollback();
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBookDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $bank_book = BankBook::where('id',$request->bank_book_id)->first();
            $bank_book->status = 'deleted';
            $bank_book->deleted_by = $user->id;
            $bank_book->deleted_at = date('Y-m-d h:i:s');
            $bank_book->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankReconciliation(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            if($request->year != '' && $request->month != '') {
                $bank_reconciliations = BankReconciliation::select('bank_reconciliations.*', 'banks.name as bank_name',
                    'bank_accounts.account_number');
                $bank_reconciliations = $bank_reconciliations->leftJoin('banks', 'banks.id', '=',
                    'bank_reconciliations.bank_id');
                $bank_reconciliations = $bank_reconciliations->leftJoin('bank_accounts', 'bank_accounts.id', '=',
                    'bank_reconciliations.account_id');
                $bank_reconciliations = $bank_reconciliations->where('bank_reconciliations.status', 'active');
                $bank_reconciliations = $bank_reconciliations->where('bank_reconciliations.year', $request->year);
                $bank_reconciliations = $bank_reconciliations->where('bank_reconciliations.month', $request->month);
                $bank_reconciliations = $bank_reconciliations->orderBy('bank_reconciliations.id', 'ASC');
                $bank_reconciliations = $bank_reconciliations->first();
            }
            else{
                $bank_reconciliations = [];
            }
            return view('account.bank_reconciliation',compact('months','bank_reconciliations'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankReconciliationCreate(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $banks = Bank::where('status','active')->get();
            $bank_accounts = BankAccount::where('status','active')->get();
            $cheque_books = ChequeBook::where('status','active')->get();
            $parties = Party::where('status','active')->get();
            return view('account.bank_reconciliation_create',compact('months','banks','bank_accounts','cheque_books','parties'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankReconciliationStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_reconciliation = BankReconciliation::where('year',$request->year)->where('month',$request->month)->first();
            if(!empty($old_bank_reconciliation)){
                return ['status'=>401, 'reason'=>'Bank reconciliation for this month and year already stored'];
            }

            $bank_reconciliation = NEW BankReconciliation();
            $bank_reconciliation->year = $request->year;
            $bank_reconciliation->month = $request->month;
            $bank_reconciliation->bank_id = $request->bank_id;
            $bank_reconciliation->account_id = $request->account_id;
            $bank_reconciliation->bank_statement_closing_balance = $request->bank_statement_closing_balance;

            $bank_reconciliation->outstanding_cheques = implode(',',$request->outstanding_cheques);
            $bank_reconciliation->outstanding_cheque_amount = $request->outstanding_cheque_amount;

            $bank_reconciliation->outstanding_deposits = json_encode($request->outstanding_deposit);
            $bank_reconciliation->outstanding_deposit_amount = $request->total_outstanding_deposit_amount;

            $bank_reconciliation->other_payments = json_encode($request->other_payment);
            $bank_reconciliation->other_payment_amount = $request->total_other_payment_amount;

            $bank_reconciliation->other_deposits = json_encode($request->other_deposit);
            $bank_reconciliation->other_deposit_amount = $request->total_other_deposit_amount;

            $bank_reconciliation->closing_balance_bank_book = $request->closing_balance_bank_book;
            $bank_reconciliation->opening_variance = $request->opening_variance;

            $bank_reconciliation->created_by = $user->id;
            $bank_reconciliation->created_at = date('Y-m-d h:i:s');
            $bank_reconciliation->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function getDetails(Request $request)
    {
        try{
            $bank_reconciliation = BankReconciliation::select('bank_reconciliations.*')
                ->where('bank_reconciliations.id',$request->id)
                ->first();
            return ['status'=>200, 'bank_reconciliation'=>$bank_reconciliation];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankReconciliationEdit(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $banks = Bank::where('status','active')->get();
            $bank_accounts = BankAccount::where('status','active')->get();
            $cheque_books = ChequeBook::where('status','active')->get();
            $parties = Party::where('status','active')->get();
            $bank_reconciliation = BankReconciliation::select('bank_reconciliations.*')
                ->where('bank_reconciliations.id',$request->id)
                ->first();
            return view('account.bank_reconciliation_edit',compact('months','banks','cheque_books','bank_accounts','parties','bank_reconciliation'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankReconciliationUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_reconciliation = BankReconciliation::where('year',$request->year)->where('month',$request->month)->first();
            if(!empty($old_bank_reconciliation) && $old_bank_reconciliation->id != $request->id){
                return ['status'=>401, 'reason'=>'Bank reconciliation for this month and year already stored'];
            }

            $bank_reconciliation = BankReconciliation::where('id',$request->id)->first();
            $bank_reconciliation->year = $request->year;
            $bank_reconciliation->month = $request->month;
            $bank_reconciliation->bank_id = $request->bank_id;
            $bank_reconciliation->account_id = $request->account_id;
            $bank_reconciliation->bank_statement_closing_balance = $request->bank_statement_closing_balance;

            $bank_reconciliation->outstanding_cheques = implode(',',$request->outstanding_cheques);
            $bank_reconciliation->outstanding_cheque_amount = $request->outstanding_cheque_amount;

            $bank_reconciliation->outstanding_deposits = json_encode($request->outstanding_deposit);
            $bank_reconciliation->outstanding_deposit_amount = $request->total_outstanding_deposit_amount;

            $bank_reconciliation->other_payments = json_encode($request->other_payment);
            $bank_reconciliation->other_payment_amount = $request->total_other_payment_amount;

            $bank_reconciliation->other_deposits = json_encode($request->other_deposit);
            $bank_reconciliation->other_deposit_amount = $request->total_other_deposit_amount;

            $bank_reconciliation->closing_balance_bank_book = $request->closing_balance_bank_book;
            $bank_reconciliation->opening_variance = $request->opening_variance;

            $bank_reconciliation->updated_by = $user->id;
            $bank_reconciliation->updated_at = date('Y-m-d h:i:s');
            $bank_reconciliation->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankReconciliationDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $bank_reconciliation = BankReconciliation::where('id',$request->bank_reconciliation_id)->first();
            $bank_reconciliation->status = 'deleted';
            $bank_reconciliation->deleted_by = $user->id;
            $bank_reconciliation->deleted_at = date('Y-m-d h:i:s');
            $bank_reconciliation->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

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
            return view('account.other_payment_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function otherPaymentStore(Request $request)
    {
        try{
            $user = Auth::user();

            $other_payment = NEW OtherPayment();
            $other_payment->purpose_of_payment = $request->purpose_of_payment;
            $other_payment->amount = $request->amount;
            $other_payment->payment_mode = $request->payment_mode;
            $other_payment->voucher_number = $request->voucher_number;
            $other_payment->remarks = $request->remarks;
            $other_payment->payment_type = $request->payment_type;
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
            $other_payment = OtherPayment::select('other_payments.*')
                ->where('other_payments.id',$request->id)
                ->first();
            return view('account.other_payment_edit',compact('other_payment'));
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
            $other_payment->purpose_of_payment = $request->purpose_of_payment;
            $other_payment->amount = $request->amount;
            $other_payment->payment_mode = $request->payment_mode;
            $other_payment->voucher_number = $request->voucher_number;
            $other_payment->remarks = $request->remarks;
            $other_payment->payment_type = $request->payment_type;
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

    public function incomeTax(Request $request)
    {
        try{
            $income_taxes = IncomeTax::select('income_taxes.*');
            $income_taxes = $income_taxes->where('income_taxes.status','active');
            if($request->year != ''){
                $income_taxes = $income_taxes->where('income_taxes.year',$request->year);
            }
            $income_taxes = $income_taxes->paginate(50);
            return view('account.income_tax',compact('income_taxes'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function incomeTaxCreate(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            return view('account.income_tax_create',compact('months'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function incomeTaxStore(Request $request)
    {
        try{
            $user = Auth::user();

            $duplicate_income_tax = IncomeTax::where('income_taxes.year',$request->year)
                ->where('income_taxes.month',$request->month)
                ->first();
            if(!empty($duplicate_income_tax)){
                return ['status'=>401, 'reason'=>"You have already saved this month's income tax. Instead you can update this month's tax if you want."];
            }

            $income_tax = NEW IncomeTax();
            $income_tax->month = $request->month;
            $income_tax->year = $request->year;
            $income_tax->tax_amount = (float)$request->tax_amount;
            $income_tax->created_by = $user->id;
            $income_tax->created_at = date('Y-m-d h:i:s');
            $income_tax->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function incomeTaxEdit(Request $request)
    {
        try{
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $income_tax = IncomeTax::select('income_taxes.*')
                ->where('income_taxes.id',$request->id)
                ->first();
            return view('account.income_tax_edit',compact('months','income_tax'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function incomeTaxUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $duplicate_income_tax = IncomeTax::where('income_taxes.year',$request->year)
                ->where('income_taxes.month',$request->month)
                ->first();
            if(!empty($duplicate_income_tax) && $duplicate_income_tax->id != $request->id){
                return ['status'=>401, 'reason'=>"You have already saved this month's income tax."];
            }

            $income_tax = IncomeTax::where('id',$request->id)->first();
            $income_tax->month = $request->month;
            $income_tax->year = $request->year;
            $income_tax->tax_amount = (float)$request->tax_amount;
            $income_tax->updated_by = $user->id;
            $income_tax->updated_at = date('Y-m-d h:i:s');
            $income_tax->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function incomeTaxDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $income_tax = IncomeTax::where('id',$request->income_tax_id)->first();
            $income_tax->status = 'deleted';
            $income_tax->deleted_by = $user->id;
            $income_tax->deleted_at = date('Y-m-d h:i:s');
            $income_tax->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function monthlyProfitLoss(Request $request)
    {
        //try{
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
                $sales = Sale::selectRaw("SUM(total_amount) as total_sale_amount")
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
                $productions_issue = StockIssue::selectRaw("SUM(total_value) as total_amount")
                ->where('stock_issues.status','active')
                ->where('stock_issues.date_of_issue','>=',$start_date)
                ->where('stock_issues.date_of_issue','<=',$end_date)
                ->first();
                if(empty($productions_issue)){
                    $profit_loss[$month]['cost_of_sales'] = '';
                }
                else{
                    $productions_return = StockReturn::selectRaw("SUM(total_value) as total_amount")
                        ->where('stock_returns.status','active')
                        ->where('stock_returns.date_of_return','>=',$start_date)
                        ->where('stock_returns.date_of_return','<=',$end_date)
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

                if($profit_loss[$month]['gross_profit']==''){
                    $profit_loss[$month]['salary_expense'] = '';
                }
                else{
                    $profit_loss[$month]['salary_expense'] = (float)$request->salary;
                }

                /*
                 * Getting other expense record for this month
                 * */
                $other_expense = OtherPayment::selectRaw("SUM(amount) as total_expense_amount")
                    ->where('payment_type','=','Paid')
                    ->where('payment_date','>=',$start_date)
                    ->where('payment_date','<=',$end_date)
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
        /*}
        catch(\Exception $e){
            return redirect('error_404');
        }*/
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
