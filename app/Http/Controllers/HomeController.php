<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Size;
use App\Models\Color;
use App\Models\Supplier;
use App\Common;
use Auth;
use Session;

class HomeController extends Controller
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
            return view('dashboard');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }

    public function customerDashboard(Request $request)
    {
        try{
            return view('customer_dashboard');
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }
}