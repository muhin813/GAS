<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemUom;
use App\Models\ItemCategory;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;

class ItemController extends Controller
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
            $items = Item::select('items.*','item_categories.name as category_name');
            $items = $items->join('item_categories','item_categories.id','=','items.category_id');
            $items = $items->whereIn('items.status',['active','inactive']);
            $items = $items->paginate(50);
            return view('item.index',compact('items'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function create(Request $request)
    {
        try{
            $categories = ItemCategory::whereIn('item_categories.status',['active','inactive'])->get();
            return view('item.create',compact('categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function store(Request $request)
    {
        try{
            $user = Auth::user();

            $old_item = Item::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_item)){
                return ['status'=>401, 'reason'=>'This item name already exists'];
            }

            $item = NEW Item();
            $item->category_id = $request->category_id;
            $item->name = $request->name;
            $item->created_by = $user->id;
            $item->created_at = date('Y-m-d h:i:s');
            $item->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function edit(Request $request)
    {
        try{
            $categories = ItemCategory::whereIn('item_categories.status',['active','inactive'])->get();
            $item = Item::select('items.*')
                ->where('items.id',$request->id)
                ->first();
            return view('item.edit',compact('categories','item'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function update(Request $request)
    {
        try{
            $user = Auth::user();

            $old_item = Item::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_item) && $old_item->id != $request->id){
                return ['status'=>401, 'reason'=>'This item name already exists'];
            }

            $item = Item::where('id',$request->id)->first();
            $item->category_id = $request->category_id;
            $item->name = $request->name;
            $item->updated_by = $user->id;
            $item->updated_at = date('Y-m-d h:i:s');
            $item->save();

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

            $item = Item::where('id',$request->item_id)->first();
            $item->status = 'deleted';
            $item->deleted_by = $user->id;
            $item->deleted_at = date('Y-m-d h:i:s');
            $item->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*############################# Item UOM section ##################################*/
    public function itemUomIndex(Request $request)
    {
        try{
            $item_uoms = ItemUom::select('item_uoms.*');
            $item_uoms = $item_uoms->whereIn('item_uoms.status',['active','inactive']);
            $item_uoms = $item_uoms->paginate(50);
            return view('item.item_uom_index',compact('item_uoms'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemUomCreate(Request $request)
    {
        try{
            return view('item.item_uom_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemUomStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_uom = ItemUom::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_uom)){
                return ['status'=>401, 'reason'=>'This item UOM name already exists'];
            }

            $item_uom = NEW ItemUom();
            $item_uom->name = $request->name;

            $item_uom->created_by = $user->id;
            $item_uom->created_at = date('Y-m-d h:i:s');
            $item_uom->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function itemUomEdit(Request $request)
    {
        try{
            $item_uom = ItemUom::select('item_uoms.*')
                ->where('item_uoms.id',$request->id)
                ->first();
            return view('item.item_uom_edit',compact('item_uom'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemUomUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_uom = ItemUom::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_uom) && $old_uom->id != $request->id){
                return ['status'=>401, 'reason'=>'This item UOM name already exists'];
            }

            $item_uom = ItemUom::where('id',$request->id)->first();
            $item_uom->name = $request->name;
            $item_uom->updated_by = $user->id;
            $item_uom->updated_at = date('Y-m-d h:i:s');
            $item_uom->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function itemUomDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $item_uom = ItemUom::where('id',$request->item_uom_id)->first();
            $item_uom->status = 'deleted';
            $item_uom->deleted_by = $user->id;
            $item_uom->deleted_at = date('Y-m-d h:i:s');
            $item_uom->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    /*############################# Item category section ##################################*/
    public function itemCategoryIndex(Request $request)
    {
        try{
            $item_categories = ItemCategory::select('item_categories.*');
            $item_categories = $item_categories->whereIn('item_categories.status',['active','inactive']);
            $item_categories = $item_categories->paginate(50);
            return view('item.item_category_index',compact('item_categories'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemCategoryCreate(Request $request)
    {
        try{
            return view('item.item_category_create');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemCategoryStore(Request $request)
    {
        try{
            $user = Auth::user();

            $old_category = ItemCategory::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_category)){
                return ['status'=>401, 'reason'=>'This item category name already exists'];
            }

            $item_category = NEW ItemCategory();
            $item_category->name = $request->name;

            $item_category->created_by = $user->id;
            $item_category->created_at = date('Y-m-d h:i:s');
            $item_category->save();


            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function itemCategoryEdit(Request $request)
    {
        try{
            $item_category = ItemCategory::select('item_categories.*')
                ->where('item_categories.id',$request->id)
                ->first();
            return view('item.item_category_edit',compact('item_category'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function itemCategoryUpdate(Request $request)
    {
        try{
            $user = Auth::user();

            $old_category = ItemCategory::where('name',$request->name)->where('status','!=','deleted')->first();
            if(!empty($old_category) && $old_category->id != $request->id){
                return ['status'=>401, 'reason'=>'This item category name already exists'];
            }

            $item_category = ItemCategory::where('id',$request->id)->first();
            $item_category->name = $request->name;
            $item_category->updated_by = $user->id;
            $item_category->updated_at = date('Y-m-d h:i:s');
            $item_category->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function itemCategoryDelete(Request $request)
    {
        try{
            $user = Auth::user();

            $item_category = ItemCategory::where('id',$request->item_category_id)->first();
            $item_category->status = 'deleted';
            $item_category->deleted_by = $user->id;
            $item_category->deleted_at = date('Y-m-d h:i:s');
            $item_category->save();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch(\Exception $e){
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
