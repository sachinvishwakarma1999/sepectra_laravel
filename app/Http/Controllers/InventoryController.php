<?php

namespace App\Http\Controllers;

use App\Color;
use App\Customer;
use Illuminate\Http\Request;
use App\Inventory;
use App\InventoryProject;
use App\InventoryProjectItem;
use App\Project;
use App\Service;
use Session;

class InventoryController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::orderBy('id','desc')->get();
        $projects = Project::orderBy('id','desc')->get();
        $colors = Color::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        $inventorys = Inventory::orderBy('id','desc')->with('customer')->with('project')->with('color')->with('service')->get();
        return view('pages.page-inventorys-list')->with('inventorys',$inventorys)->with('customers',$customers)->with('projects',$projects)->with('colors',$colors)->with('services',$services);
    }

    public function store(Request $request)
    {
        $Inventory = new Inventory;
        $Inventory->title = $request->input('title');
        $Inventory->description = $request->input('description');
        $Inventory->customer_id = $request->input('customer_id');
        $Inventory->project_type_id = 0;
        // $Inventory->color_id = $request->input('color_id');
        // $Inventory->service_id = $request->input('service_id');
        $Inventory->save();

        $project_arr = $request->input('project');
        $project_type_id_arr = $request->input('project_type_id');
        $color_arr = $request->input('color_id');
        $service_arr = $request->input('service_id');
        foreach($project_arr as $key=>$project)
        {

          $InventoryProject = new InventoryProject;
          $InventoryProject->name = $project;
          $InventoryProject->type = $project_type_id_arr[$key];
          $InventoryProject->inventory_id = $Inventory->id;
          $InventoryProject->color_id = $color_arr[$key];
          $InventoryProject->service_id = $service_arr[$key];
          $InventoryProject->save();
          $index = $key+1;
          $params = 'Item'.$index;
          $params2 = 'Item_Description'.$index;
          $itemsDescription = array();
          if($request->has($params2))
          {
            $itemsDescription = $request->input($params2);
          }
          if($request->has($params))
          {
              $items_arr = $request->input($params);
              foreach($items_arr as $keyitem=>$items)
              {
                  $itemDesc = "";
                  if(isset($itemsDescription[$keyitem]))
                  {
                      $itemDesc = $itemsDescription[$keyitem];
                  }
                  $InventoryProjectItem = new InventoryProjectItem;
                  $InventoryProjectItem->name = $items;
                  $InventoryProjectItem->description = $itemDesc;
                  $InventoryProjectItem->inventory_project_id = $InventoryProject->id;
                  $InventoryProjectItem->save();
              }
          }
        }


        Session::flash('message', 'Inventory Created Successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Inventory::where('id',$id)->delete();
        Session::flash('message', 'Inventory Deleted Successfully!');
        return redirect()->back();
    }

    public function editInventory($id){
        $Inventory = Inventory::where('id',$id)->first();
        $inventory_projects = InventoryProject::where('inventory_id',$id)->get();
        foreach($inventory_projects as $inventory_project)
        {
            $InventoryProjectItem = InventoryProjectItem::where('inventory_project_id',$inventory_project->id)->get();
            $inventory_project->items = $InventoryProjectItem;
        }
        $Inventory->project = $inventory_projects;
        $customers = Customer::orderBy('id','desc')->get();
        $projects = Project::orderBy('id','desc')->get();
        $colors = Color::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        if(!isset($Inventory->id))
        {
          Session::flash('message', 'Inventory Not Found!');
          return redirect()->back();
        }else{
          return view('pages.page-inventory-edit')->with('Inventory',$Inventory)->with('customers',$customers)->with('projects',$projects)->with('colors',$colors)->with('services',$services);
        }
    }

    public function viewinventory($id)
    {
        $Inventory = Inventory::where('id',$id)->first();
        $inventory_projects = InventoryProject::where('inventory_id',$id)->get();
        foreach($inventory_projects as $inventory_project)
        {
            $InventoryProjectItem = InventoryProjectItem::where('inventory_project_id',$inventory_project->id)->get();
            $inventory_project->items = $InventoryProjectItem;
        }
        $Inventory->project = $inventory_projects;
        $customers = Customer::orderBy('id','desc')->get();
        $projects = Project::orderBy('id','desc')->get();
        $colors = Color::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        if(!isset($Inventory->id))
        {
          Session::flash('message', 'Inventory Not Found!');
          return redirect()->back();
        }else{
          return view('pages.page-inventory-view')->with('Inventory',$Inventory)->with('customers',$customers)->with('projects',$projects)->with('colors',$colors)->with('services',$services);
        }
    }

    public function updateinventory(Request $request)
    {

        Inventory::where('id',$request->input('id'))->update(
            array(
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'customer_id' => $request->input('customer_id'),
                'project_type_id' => 0
                // 'color_id' => $request->input('color_id'),
                // 'service_id' => $request->input('service_id')
            )
        );

        InventoryProject::where('inventory_id',$request->input('id'))->delete();

        $project_arr = $request->input('project');
        $project_type_id_arr = $request->input('project_type_id');
        $color_arr=$request->input('color_id');
        $service_arr=$request->input('service_id');
        foreach($project_arr as $key=>$project)
        {
          $InventoryProject = new InventoryProject;
          $InventoryProject->name = $project;
          $InventoryProject->type = $project_type_id_arr[$key];
          $InventoryProject->color_id=$color_arr[$key];
          $InventoryProject->service_id=$service_arr[$key];
          $InventoryProject->inventory_id = $request->input('id');
          $InventoryProject->save();
          $index = $key+1;
          $params = 'Item'.$index;
          $params2 = 'Item_Description'.$index;

          $itemsDescription = array();
          if($request->has($params2))
          {
            $itemsDescription = $request->input($params2);
          }
          if($request->has($params))
          {
              $items_arr = $request->input($params);
              foreach($items_arr as $keyitem=>$items)
              {
                  $itemDesc = "";
                  if(isset($itemsDescription[$keyitem]))
                  {
                      $itemDesc = $itemsDescription[$keyitem];
                  }
                  $InventoryProjectItem = new InventoryProjectItem;
                  $InventoryProjectItem->name = $items;
                  $InventoryProjectItem->description = $itemDesc;
                  $InventoryProjectItem->inventory_project_id = $InventoryProject->id;
                  $InventoryProjectItem->save();
              }
          }
        }

        Session::flash('message', 'Inventory Updated Successfully!');
        return redirect()->back();
    }
}
