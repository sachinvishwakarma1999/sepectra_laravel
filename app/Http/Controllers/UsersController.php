<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
  //user List
  public function listUser(){
    $users = User::where('role','employee')->get();
    return view('pages.page-users-list')->with('users',$users);
  }
    //user view
    public function viewUser(){
    return view('pages.page-users-view');
  }
   //user edit
   public function editUser($id){
    $user = User::where('id',$id)->first();
    if(!isset($user->id))
    {
      Session::flash('message', 'User Not Found!');
      return redirect()->back();
    }else{
      return view('pages.page-users-edit')->with('user',$user);
    }
  }

  public function updateuser(Request $request)
  {
      User::where('id',$request->input('id'))->update(
        array(
          'name' => $request->input('name'),
          'pincode' => $request->input('pincode'),
          'status' => $request->input('status')
        )
      );
      Session::flash('message', 'User Updated Successfully!');
      return redirect()->back();
  }

  public function changePassword(Request $request)
  {
      $arr_rules['password']      = "required|string|min:6|same:password_confirmation";
      $validator = validator::make($request->all(),$arr_rules);
      if ($validator->fails())
      {
          Session::flash('error', 'Password and Confirm Password Not Matched!');
      }else{
          $password = $request->input('password');
          User::where('id',Auth::user()->id)->update(
            array(
                'password' => Hash::make($password)
            )
          );
          Session::flash('message', 'User Change Password Successfully!');
      }
      return redirect()->back();
  }

  public function store(Request $request)
  {
      $inputs = $request->all();
      $count = User::where('email',$inputs['email'])->where('role','employee')->count();
      if($count > 0)
      {
        Session::flash('error', 'Email Address Already Exist!');
      }else{
        $count = User::where('pincode',$inputs['pincode'])->where('role','employee')->count();
        if($count > 0)
        {
          Session::flash('error', 'Pincode Already Exist!');
        }else{
          $User = new User;
          $User->name = $inputs['name'];
          $User->email = $inputs['email'];
          $User->status = $inputs['status'];
          $User->pincode = $inputs['pincode'];
          $User->password = "";
          $User->role = "employee";
          $User->save();
          Session::flash('message', 'User Created Successfully!');
        }
      }
      return redirect()->back();
  }

  public function destroy($id)
  {
      User::where('id',$id)->delete();
      Session::flash('message', 'User Deleted Successfully!');
      return redirect()->back();
  }

  public function logout()
  {
     Auth::logout();
     return redirect('/login');
  }

}
