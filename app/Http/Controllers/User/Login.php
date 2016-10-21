<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class Login extends Controller
{
    public function check(Request $request)
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