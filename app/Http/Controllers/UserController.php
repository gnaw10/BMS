<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function Signup(Request $request)
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

    public function Signin(Request $request)
    {
        $username=$request->username;
        $password=$request->password;
        //echo $password;
        
        $count=User::where('username',$username)->count();
        $data=User::where('username',$username)->first()->password;
        
        if($count==0)
            return handle('0101');
        else 
            {
                if($data==$password)
                    {
                        $response=User::where('username',$username)->first()->id;
                        return FuncController::handle('0000{"uid":'.$response.'}');
                    }
                else 
                    {
                        return handle('0101');
                    }
            }

        //var_dump($data);

    }
}