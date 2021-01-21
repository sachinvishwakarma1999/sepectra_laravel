<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Session;

class ProjectController extends Controller
{
    //
    public function index()
    {
        $projects = Project::orderBy('id','desc')->get();
        return view('pages.page-project-list')->with('projects',$projects);
    }

    public function store(Request $request)
    {
        $Project = new Project;
        $Project->title = $request->input('title');
        $Project->description = $request->input('description');
        $Project->type = $request->input('type');
        $Project->save();
        Session::flash('message', 'Project Created Successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Project::where('id',$id)->delete();
        Session::flash('message', 'Project Deleted Successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $project = Project::where('id',$id)->first();
        if(!isset($project->id))
        {
          Session::flash('message', 'Project Not Found!');
          return redirect()->back();
        }else{
          return view('pages.page-project-edit')->with('project',$project);
        }
    }

    public function update(Request $request)
    {
      Project::where('id',$request->input('id'))->update(
        array(
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type')
          )
      );
      Session::flash('message', 'Project Updated Successfully!');
      return redirect()->back();
    }
}
