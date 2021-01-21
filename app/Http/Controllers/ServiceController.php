<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Session;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $services = Service::orderBy('id','desc')->get();
        return view('pages.page-services-list')->with('services',$services);
    }

    public function store(Request $request)
    {
        $Service = new Service;
        $Service->title = $request->input('title');
        $Service->description = $request->input('description');
        $Service->save();
        Session::flash('message', 'Service Created Successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Service::where('id',$id)->delete();
        Session::flash('message', 'Service Deleted Successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $service = Service::where('id',$id)->first();
        if(!isset($service->id))
        {
          Session::flash('message', 'Service Not Found!');
          return redirect()->back();
        }else{
          return view('pages.page-service-edit')->with('service',$service);
        }
    }

    public function update(Request $request)
    {
      Service::where('id',$request->input('id'))->update(
        array(
            'title' => $request->input('title'),
            'description' => $request->input('description')
          )
      );
      Session::flash('message', 'Service Updated Successfully!');
      return redirect()->back();
    }
}
