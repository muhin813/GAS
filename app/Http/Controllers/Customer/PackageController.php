<?php

namespace App\Http\Controllers\Customer;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageUom;
use App\Models\PackageDetail;
use App\Models\PackageSubDetail;
use App\Models\PackageBenefitFeature;
use App\Models\User;
use App\Common;
use Auth;
use File;
use Session;
use DB;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role != 4) {
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
            $packages = Package::select('packages.*');
            $packages = $packages->whereIn('packages.status',['active','inactive']);
            $packages = $packages->paginate(50);
            return view('customer.package_index',compact('packages'));
        }
        catch(\Exception $e){
            return redirect('error_404');
        }
    }
}
