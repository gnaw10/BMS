<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers;
use Closure;
class UserController extends Controller
{
    public function Signup(Request $request)
    {
        $user = new User;

        $user->username = $request->username;
        $user->password = $request->password;
        if($request->has('email'))       $user->email    = $request->email;
        if($request->has('phone'))       $user->phone    = $request->phone;
        if($request->has('gender'))      $user->gender   = $request->gender;
        if($request->has('studentId'))   $user->studentId= $request->studentId;
        if($request->has('roleId'))      $user->roleId   = $request->roleId;

        $user->save(); 
        $response = User::where('username',$request->username)->first()->id;

        return FuncController::handle('0000{"uid":'.$response.'}');
    }

    public function Signin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        
        $count    = User::where('username',$username)->count();
        $data     = User::where('username',$username)->first()->password;
        
        if($count == 0)
            return handle('0312');
        else 
            {
                if($data == $password)
                    {
                        $response = User::where('username',$username)->first()->id;
                        //Auth::login($username);
                        return FuncController::handle('0000{"uid":'.$response.'}');
                    }
                else 
                    {
                        return FuncController::handle('0312');
                    }
            }
        //var_dump($data);
    }

    public function Show(Request $request)
    {
        
        $uid   = $request->uid;
        
        //$user  = new User;
        $count = User::where('id',$uid)->count();
       
       
        if($count === 0)
            return FuncController::handle('0313');
        
        $user  = User::where('id',$uid)->first();

        //var_dump($user);
        return FuncController::handle('0000'.json_encode($user));
    }
}