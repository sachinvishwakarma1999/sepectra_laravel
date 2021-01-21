<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Http\Request;
use Session;

class ColorController extends Controller
{
    //
    public function index()
    {
        $colors = Color::orderBy('id','desc')->get();
        return view('pages.page-color-list')->with('colors',$colors);
    }

    public function store(Request $request)
    {
        $Color = new Color;
        $Color->title = $request->input('title');
        $Color->description = $request->input('description');
        $Color->code = $request->input('code');
        $Color->save();
        Session::flash('message', 'Color Created Successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
      Color::where('id',$id)->delete();
        Session::flash('message', 'Color Deleted Successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $color = Color::where('id',$id)->first();
        if(!isset($color->id))
        {
          Session::flash('message', 'Color Not Found!');
          return redirect()->back();
        }else{
          return view('pages.page-color-edit')->with('color',$color);
        }
    }

    public function update(Request $request)
    {
      Color::where('id',$request->input('id'))->update(
        array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'code' => $request->input('code')
          )
      );
      Session::flash('message', 'Color Updated Successfully!');
      return redirect()->back();
    }
}
