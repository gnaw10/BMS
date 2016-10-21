<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function Register(Request $request)
    {
        $user = new User;
        $user->username=$request->username;
        $user->password=$request->password;
        if(User::where('username',$request->username)->count()!=0)
            return 'No';
        $user->email='123546';
        $user->phone='123546';
        $user->gender='123546';
        $user->studentId='123546';
        $user->roleId='123546';
        $user->save();
    }

    public function Login(Request $request)
    {
        $username=$request->username;
        $password=$request->password;
        //echo $password;
        
        $count=User::where('username',$username)->count();
        $data=User::where('username',$username)->first()->password;
        
        if($count==0)
            return false;
        else 
            {
                if($data==$password)
                    return 'yes';
                else 
                    return 'no';
            }

        //var_dump($data);

    }
}