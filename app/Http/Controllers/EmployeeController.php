<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\User;
use App\Inventory;
use App\InventoryProjectItem;
use App\invoice;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    //
    public function dashboard(Request $request)
    {
        if(Auth::check() && Auth::user()->role == 'admin')
        {
            return redirect()->route('/');
        }else{
            if (Auth::check() && Auth::user()->role == 'employee') {
                $inventorys = Inventory::orderBy('id','desc')->get();
                $customer = Customer::orderBy('id','desc')->get();
                $projectitem = InventoryProjectItem::orderBy('id','desc')->get();
                $invoicename = invoice::orderBy('id','desc')->get();


                return view('pages.employeedashboard')->with('invoicenames',$invoicename)->with('projectitems',$projectitem)->with('customers',$customer)->with('inventorys',$inventorys);
            }else{
                return view('pages.employeelogin');
            }
        }
    }

    public function login(Request $request)
    {
        $user = User::where('pincode',$request->input('pincode'))->first();
        if(isset($user->id))
        {
            if(Auth::loginUsingId($user->id))
            {
                return redirect()->route('dashboard');
            }else{
                Session::flash('message', 'Wrong Pincode Entered!');
                return redirect()->back();
            }
            Session::flash('message', 'User Logged In Successfully!');
            return redirect()->back();
        }else{
            Session::flash('message', 'Wrong Pincode Entered!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::flush();
        return view('pages.employeelogin');
    }

}
