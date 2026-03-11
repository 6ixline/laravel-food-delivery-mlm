<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function index(){
        return view("admin.login");
    }

    public function authenticate(Request $request){
        $validater = Validator::make($request->all(), [
            "username" => 'required',
            'password' => 'required'
        ]);

        if($validater->passes()){
            if(Auth::guard("admin")->attempt(["username"=> $request->username, "password"=> $request->password])){
                if(Auth::guard('admin')->user()->type != "admin"){
                    Auth::logout();
                    return redirect()->route("admin.login")->with('error',"Not a valid User!!")->withInput();
                }
                return redirect()->route("admin.dashboard")->with("success", "Logged in Successfully!!");
            }else{
                return redirect()->route("admin.login")->with('error',"Invalid Credentails!!")->withInput();
            }
        }else{
            return redirect()->route("admin.login")->withErrors($validater)->withInput();
        }
    }


    public function logout(){
        Auth::guard("admin")->logout();
        return redirect()->route("admin.login")->with('success',"Logout Successfully!!")->withInput();
    }
}
