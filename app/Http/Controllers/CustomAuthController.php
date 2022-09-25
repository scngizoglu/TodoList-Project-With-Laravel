<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }
    public function registration()
    {
        return view("auth.registration");    
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:6|max:12'
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user=$user->save();
        if($user)
        {
            return back()->with('success','You have registered successfuly');
        }
        else{
            return back()->with('fail','Something wrong');
        }
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required|min:6|max:12'
        ]);
        $user=User::where('email','=',$request->email)->first();
        if($user)
        {
            if(Hash::check($request->password,$user->password))
            {
                $request->session()->put('loginId',$user->id);
                session(['loginId' => $user->id]);
                session()->save();
                return redirect('/todolist');   
            }else{
                return back()->with('fail','Password not matches');
            }
        }else{
            return back()->with('fail','This email is not registered');
        }
    }
    public function dashboard()
    {
        return "Welcome!! To your Dashboard";
    }
    public function logout()
    {
        Session::forget('loginId');
        if(!Session::has('loginId'))
        {
            return redirect('/login'); 
        } 
    }
    
}
