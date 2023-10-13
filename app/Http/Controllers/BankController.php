<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankBranch;
use App\Models\ChequeBook;
use App\Models\Party;
use App\Models\PartyCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class BankController extends Controller
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

    /*##################################### Bank section #######################################*/

    public function index(Request $request)
    {
        try{
            $banks = Bank::select('banks.*');
            $banks = $banks->where('banks.status','active');
            $banks = $banks->orderBy('banks.id','ASc');
            $banks = $banks->paginate(100);
            return view('bank.index',compact('banks'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            return view('bank.create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank = Bank::where('name',$request->name)->first();
            if(!empty($old_bank)){
                return ['status'=>401, 'reason'=>'Bank with this name already exists'];
            }

            $bank = NEW Bank();
            $bank->name = $request->name;
            $bank->created_by = $user->id;
            $bank->created_at = date('Y-m-d h:i:s');
            $bank->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function edit(Request $request)
    {
        try{
            $bank = Bank::select('banks.*')
                ->where('banks.id',$request->id)
                ->first();
            return view('bank.edit',compact('bank'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank = Bank::where('name',$request->name)->first();
            if(!empty($old_bank) && $old_bank->id != $request->id){
                return ['status'=>401, 'reason'=>'Bank with this name already exists'];
            }

            $bank = Bank::where('id',$request->id)->first();
            $bank->name = $request->name;
            $bank->updated_by = $user->id;
            $bank->updated_at = date('Y-m-d h:i:s');
            $bank->save();

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

            $bank = Bank::where('id',$request->bank_id)->first();
            $bank->status = 'deleted';
            $bank->deleted_by = $user->id;
            $bank->deleted_at = date('Y-m-d h:i:s');
            $bank->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*##################################### Bank Branch section #######################################*/

    public function bankBranch(Request $request)
    {
        try{
            $bank_branches = BankBranch::select('bank_branches.*','banks.name as bank_name');
            $bank_branches = $bank_branches->join('banks','banks.id','=','bank_branches.bank_id');
            $bank_branches = $bank_branches->where('bank_branches.status','active');
            $bank_branches = $bank_branches->orderBy('bank_branches.id','ASc');
            $bank_branches = $bank_branches->paginate(100);
            return view('bank.bank_branch_index',compact('bank_branches'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankBranchcreate(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            return view('bank.bank_branch_create',compact('banks'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankBranchStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_branch = BankBranch::where('bank_id',$request->bank_id)->where('name',$request->name)->first();
            if(!empty($old_bank_branch)){
                return ['status'=>401, 'reason'=>'Bank with this branch already added'];
            }

            $bank_branch = NEW BankBranch();
            $bank_branch->bank_id = $request->bank_id;
            $bank_branch->name = $request->name;
            $bank_branch->created_by = $user->id;
            $bank_branch->created_at = date('Y-m-d h:i:s');
            $bank_branch->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBranchEdit(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            $bank_branch = BankBranch::select('bank_branches.*')
                ->where('bank_branches.id',$request->id)
                ->first();
            return view('bank.bank_branch_edit',compact('banks','bank_branch'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankBranchUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_branch = BankBranch::where('bank_id',$request->bank_id)->where('name',$request->name)->first();
            if(!empty($old_bank_branch) && $old_bank_branch->id != $request->id){
                return ['status'=>401, 'reason'=>'Bank with this branch already added'];
            }

            $bank_branch = BankBranch::where('id',$request->id)->first();
            $bank_branch->bank_id = $request->bank_id;
            $bank_branch->name = $request->name;
            $bank_branch->updated_by = $user->id;
            $bank_branch->updated_at = date('Y-m-d h:i:s');
            $bank_branch->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankBranchDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $bank_branch = BankBranch::where('id',$request->bank_branch_id)->first();
            $bank_branch->status = 'deleted';
            $bank_branch->deleted_by = $user->id;
            $bank_branch->deleted_at = date('Y-m-d h:i:s');
            $bank_branch->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*##################################### Bank account section #######################################*/

    public function bankAccount(Request $request)
    {
        try{
            $bank_accounts = BankAccount::select('bank_accounts.*','banks.name as bank_name','bank_branches.name as branch_name');
            $bank_accounts = $bank_accounts->join('banks','banks.id','=','bank_accounts.bank_id');
            $bank_accounts = $bank_accounts->join('bank_branches','bank_branches.id','=','bank_accounts.branch_id');
            $bank_accounts = $bank_accounts->where('bank_accounts.status','active');
            $bank_accounts = $bank_accounts->orderBy('bank_accounts.id','ASc');
            $bank_accounts = $bank_accounts->paginate(100);
            return view('bank.bank_account_index',compact('bank_accounts'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankAccountcreate(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            $bank_branches = BankBranch::where('status','active')->get();
            return view('bank.bank_account_create',compact('banks','bank_branches'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankAccountStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_account = BankAccount::where('account_number',$request->account_number)->first();
            if(!empty($old_bank_account)){
                return ['status'=>401, 'reason'=>'Bank with this account already added'];
            }

            $bank_account = NEW BankAccount();
            $bank_account->bank_id = $request->bank_id;
            $bank_account->branch_id = $request->branch_id;
            $bank_account->account_name = $request->account_name;
            $bank_account->account_number = $request->account_number;
            $bank_account->created_by = $user->id;
            $bank_account->created_at = date('Y-m-d h:i:s');
            $bank_account->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankAccountEdit(Request $request)
    {
        try{
            $banks = Bank::where('status','active')->get();
            $bank_branches = BankBranch::where('status','active')->get();
            $bank_account = BankAccount::select('bank_accounts.*')
                ->where('bank_accounts.id',$request->id)
                ->first();
            return view('bank.bank_account_edit',compact('banks','bank_branches','bank_account'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function bankAccountUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_bank_account = BankAccount::where('account_number',$request->account_number)->first();
            if(!empty($old_bank_account) && $old_bank_account->id != $request->id){
                return ['status'=>401, 'reason'=>'Bank with this account already added'];
            }

            $bank_account = BankAccount::where('id',$request->id)->first();
            $bank_account->bank_id = $request->bank_id;
            $bank_account->branch_id = $request->branch_id;
            $bank_account->account_name = $request->account_name;
            $bank_account->account_number = $request->account_number;
            $bank_account->updated_by = $user->id;
            $bank_account->updated_at = date('Y-m-d h:i:s');
            $bank_account->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function bankAccountDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $bank_account = BankAccount::where('id',$request->bank_account_id)->first();
            $bank_account->status = 'deleted';
            $bank_account->deleted_by = $user->id;
            $bank_account->deleted_at = date('Y-m-d h:i:s');
            $bank_account->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }



    /*##################################### Cheque book section #######################################*/

    public function chequeBook(Request $request)
    {
        try{
            $cheque_books = ChequeBook::select('cheque_books.*','banks.name as bank_name','bank_accounts.account_number');
            $cheque_books = $cheque_books->leftJoin('bank_accounts','bank_accounts.id','=','cheque_books.bank_account_id');
            $cheque_books = $cheque_books->leftJoin('banks','banks.id','=','bank_accounts.bank_id');
            $cheque_books = $cheque_books->where('cheque_books.status','active');
            $cheque_books = $cheque_books->orderBy('cheque_books.id','ASc');
            $cheque_books = $cheque_books->paginate(100);
            return view('bank.cheque_book_index',compact('cheque_books'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function chequeBookcreate(Request $request)
    {
        try{
            $bank_accounts = BankAccount::select('bank_accounts.*')->get();
            return view('bank.cheque_book_create',compact('bank_accounts'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function chequeBookStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_cheque_book = ChequeBook::where('bank_account_id',$request->bank_account_id)->where('book_number',$request->book_number)->where('status','active')->first();
            if(!empty($old_cheque_book)){
                return ['status'=>401, 'reason'=>'This checkbook already added'];
            }

            $cheque_book = NEW ChequeBook();
            $cheque_book->bank_account_id = $request->bank_account_id;
            $cheque_book->book_number = $request->book_number;
            $cheque_book->created_by = $user->id;
            $cheque_book->created_at = date('Y-m-d h:i:s');
            $cheque_book->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function chequeBookEdit(Request $request)
    {
        try{
            $bank_accounts = BankAccount::select('bank_accounts.*')->get();
            $cheque_book = ChequeBook::select('cheque_books.*')
                ->where('cheque_books.id',$request->id)
                ->first();
            return view('bank.cheque_book_edit',compact('bank_accounts','cheque_book'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function chequeBookUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_cheque_book = ChequeBook::where('bank_account_id',$request->bank_account_id)->where('book_number',$request->book_number)->where('status','active')->first();
            if(!empty($old_cheque_book) && $old_cheque_book->id != $request->id){
                return ['status'=>401, 'reason'=>'This checkbook already added'];
            }

            $cheque_book = ChequeBook::where('id',$request->id)->first();
            $cheque_book->bank_account_id = $request->bank_account_id;
            $cheque_book->book_number = $request->book_number;
            $cheque_book->updated_by = $user->id;
            $cheque_book->updated_at = date('Y-m-d h:i:s');
            $cheque_book->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function chequeBookDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $cheque_book = ChequeBook::where('id',$request->cheque_book_id)->first();
            $cheque_book->status = 'deleted';
            $cheque_book->deleted_by = $user->id;
            $cheque_book->deleted_at = date('Y-m-d h:i:s');
            $cheque_book->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*##################################### Party category section #######################################*/

    public function partyCategories(Request $request)
    {
        try{
            $party_categories = PartyCategory::select('party_categories.*');
            $party_categories = $party_categories->where('party_categories.status','active');
            $party_categories = $party_categories->orderBy('party_categories.id','ASc');
            $party_categories = $party_categories->paginate(100);
            return view('bank.party_category_index',compact('party_categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyCategoryCreate(Request $request)
    {
        try{
            return view('bank.party_category_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyCategoryStore(Request $request)
    {
        try{
            $user = Auth::user();

            $party_category = NEW PartyCategory();
            $party_category->name = $request->name;
            $party_category->created_by = $user->id;
            $party_category->created_at = date('Y-m-d h:i:s');
            $party_category->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function partyCategoryEdit(Request $request)
    {
        try{
            $party_category = PartyCategory::select('party_categories.*')
                ->where('party_categories.id',$request->id)
                ->first();
            return view('bank.party_category_edit',compact('party_category'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyCategoryUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $party_category = PartyCategory::where('id',$request->id)->first();
            $party_category->name = $request->name;
            $party_category->updated_by = $user->id;
            $party_category->updated_at = date('Y-m-d h:i:s');
            $party_category->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function partyCategoryDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $party_category = PartyCategory::where('id',$request->party_category_id)->first();
            $party_category->status = 'deleted';
            $party_category->deleted_by = $user->id;
            $party_category->deleted_at = date('Y-m-d h:i:s');
            $party_category->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*##################################### Party section #######################################*/

    public function parties(Request $request)
    {
        try{
            $parties = Party::select('parties.*','party_categories.name as category_name');
            $parties = $parties->join('party_categories','party_categories.id','=','parties.party_category_id');
            $parties = $parties->where('parties.status','active');
            $parties = $parties->orderBy('parties.id','ASc');
            $parties = $parties->paginate(100);
            return view('bank.party_index',compact('parties'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyCreate(Request $request)
    {
        try{
            $party_categories = PartyCategory::where('status','active')->get();
            return view('bank.party_create',compact('party_categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyStore(Request $request)
    {
        try{
            $user = Auth::user();

            $party = NEW Party();
            $party->party_category_id = $request->party_category_id;
            $party->party_name = $request->party_name;
            $party->created_by = $user->id;
            $party->created_at = date('Y-m-d h:i:s');
            $party->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function partyEdit(Request $request)
    {
        try{
            $party_categories = PartyCategory::where('status','active')->get();
            $party = Party::select('parties.*')
                ->where('parties.id',$request->id)
                ->first();
            return view('bank.party_edit',compact('party_categories','party'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function partyUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $party = Party::where('id',$request->id)->first();
            $party->party_category_id = $request->party_category_id;
            $party->party_name = $request->party_name;
            $party->updated_by = $user->id;
            $party->updated_at = date('Y-m-d h:i:s');
            $party->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function partyDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $party = Party::where('id',$request->party_id)->first();
            $party->status = 'deleted';
            $party->deleted_by = $user->id;
            $party->deleted_at = date('Y-m-d h:i:s');
            $party->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }


}
