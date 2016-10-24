<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers;

class RoleController extends Controller
{
    
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
    public function List()
    {
        $data = Role::all();
        return FuncController::handle('0000'.json_encode($data));
    }
}