<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers;
use App\Http\Controllers;


class UserController extends Controller
{
    public function Signup(Request $request)
    {
        $this->validate($request, [
        'username' => 'required|unique:user',
        'password' => 'required|max:15|min:4',
        'email' => 'required|email',
        'phone' => 'required',
        'gender'=> 'required|boolean'
        ]);
        
        $user = new User;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->gender   = $request->gender;

        if($request->has('studentId'))   $user->studentId= $request->studentId;
        if($request->has('roleId'))      $user->roleId   = $request->roleId;
        $user->apikey = str_random(9); 
        $user->save(); 
        $response = User::where('username',$request->username)->first()->id;
        return FuncController::handle('0000{"uid":'.$response.'}');
    }

    public function Signin(Request $request)
    {
        $this->validate($request, [
        'username' => 'required|exists:user',
        'password' => 'required',
         ]);
        $username = $request->username;
        $password = $request->password;
      
        
        $data     = User::where('username',$username)->first()->password;
        if($data == $password)
        {
            $response ['Api-Token'] =   $username . '-' . 
                                        User::where('username',$username)->first()->apikey . '-' .
                                        User::where('username',$username)->first()->id;
            
            return FuncController::handle('0000'.json_encode($response));
        }
        else 
        {
            return FuncController::handle('0312');
        }
         
    }

    public function Show(Request $request)
    {
        $this->validate($request, [
        'uid' => 'required|exists:user,id'
         ]);
         
        if(\Auth::check() == false)
            $roleId = 4;
        else 
            $roleId = \Auth::user()->roleId;
        $uid   = $request->uid;
        //$user  = new User;
        $count = User::find($uid)->books->count();
        if($roleId <= 2 || ( \Auth::check() && \Auth::user()->id == $uid ))
            {
                $user = User::where('id',$uid)->first();
                $user['bookNum'] = $count; 
            }
        else 
            {
                $user = User::where('id',$uid)->first();
                unset($user['phone']);
                unset($user['gender']);
                unset($user['roleId']);
                unset($user['studentId']);
            }
        
        return FuncController::handle('0000'.json_encode($user));
    }

    public function UserList(Request $request)
    {
        if(\Auth::check() == false)
            $roleId = 4;
        else 
            $roleId = \Auth::user()->roleId;
        
        //$user  = new User;
        if($roleId <= 2)
            {
                $users  = User::all();
                foreach($users as &$user)
                {
                   $user['borrowNum'] = User::find($user['id'])->books->count();
                }
            }
        else 
            {
                $users = User::all();
                foreach($users as &$user)
                {
                    unset($user['phone']);
                    unset($user['gender']);
                    unset($user['roleId']);
                    unset($user['studentId']);
                }
            }
        //var_dump($user);
        return FuncController::handle('0000'.json_encode($users));
    }
    public function Modify(Request $request)
    {
        $this->validate($request, [
        'uid' => 'required|exists:user,id',
        ]);
        if(\Auth::check() == false)
            return FuncController::handle('0215');

        if($request['uid'] == $nowUser['id'] || $nowUser['roleId'] == 1 )
        {
            
            $user = User::find($request['uid']);
            if($request->has('password'))    $user->password = $request->password;            
            if($request->has('email'))       $user->email    = $request->email;
            if($request->has('phone'))       $user->phone    = $request->phone;
            if($request->has('gender'))      $user->gender   = $request->gender;
            if($request->has('studentId'))   $user->studentId= $request->studentId;
            if($request->has('roleId'))      $user->roleId   = $request->roleId;

            $user->save();
            return FuncController::handle('0000');
        }
        else
            return FuncController::handle('0215');
    }
}