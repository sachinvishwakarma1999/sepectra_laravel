<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Support\Facades\Auth;
use App\Inventory;
use App\Customer;
use App\InventoryProject;
use App\InventoryProjectItem;
use App\Project;
use App\Service;
use Illuminate\Http\Request;
use League\OAuth2\Server\RequestEvent;

class DashboardController extends Controller
{
    //ecommerce
    public function dashboardEcommerce(){
        if (Auth::check() && Auth::user()->role == 'employee') {
            $inventorys = Inventory::orderBy('id','desc')->get();
            return view('pages.employeedashboard')->with('inventorys',$inventorys);
        }else{
            return view('pages.dashboard-ecommerce');
        }
    }



    public function inventoryadd()
    {
        $customers = Customer::orderBy('id','desc')->get();
        $projects = Project::orderBy('id','desc')->get();
        $colors = Color::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        return view('pages/inventory-add')->with('customers',$customers)->with('projects',$projects)->with('colors',$colors)->with('services',$services);
    }

    public function inventoryCheckout(){

      $InventoryProjectItem = InventoryProjectItem::all();

      return view('pages.inventoryCheck-out')->with('InventoryProjectItem',$InventoryProjectItem);

    }

    public function getitemsproject(Request $request,$id){

      $InventoryProjectItem = InventoryProjectItem::where('inventory_project_id',$id)->get();
      return $InventoryProjectItem;

 }


    //inventoryList
    public function inventoryList()
    {
        $customers = Customer::orderBy('id','desc')->get();
        $projects = Project::orderBy('id','desc')->get();
        $colors = Color::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        $inventorys = Inventory::orderBy('id','desc')->with('customer')->with('project')->with('color')->with('service')->get();
        return view('pages.inventorylist')->with('inventorys',$inventorys)->with('customers',$customers)->with('projects',$projects)->with('colors',$colors)->with('services',$services);
    }
    // analystic
    public function dashboardAnalytics(){
        return view('pages.dashboard-analytics');
    }

}
