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
        'gender'=> 'boolean'
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
        $nowUser = \Auth::user();
        $uid   = $request->uid;
        //$user  = new User;
        
        if($nowUser->roleId <= 2)
            $user  = User::where('id',$uid)->first();
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
        $nowUser = \Auth::user();
        //$user  = new User;
        
        if($nowUser->roleId <= 2)
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
        $nowUser = \Auth::user();
        if($request['uid'] == $nowUser['id'] || $nowUser['roleId'] == 1 )
        {
            
            $user = User::find($request['uid']);
            if(isset($user)==0)
                return FuncController::handle('0315');
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