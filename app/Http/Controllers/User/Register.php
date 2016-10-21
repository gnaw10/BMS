<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Register extends Controller
{
    public function scan(Request $request)
    {
        $user = new User;
        $user->username=$request->username;
        $user->password=$request->password;
        $user->email='123546';
        $user->phone='123546';
        $user->gender='123546';
        $user->studentId='123546';
        $user->roleId='123546';
        $user->save();
        //echo $password;
        
        //$count=User::where('username',$username)->count();
        //$data=User::where('username',$username)->first()->password;
        
       
        

        //var_dump($data);

    }
}