<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ItemUom;
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
}
