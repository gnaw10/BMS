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
         $this->validate($request, [
        'rid'=> 'required|exists:role,id'
        ]);
        $rid  = $request->rid;
        $role = Role::find($rid);
        if(isset($role) == 0)
            return FuncController::handle('0321');
             
        return FuncController::handle('0000'.json_encode($role));
    }

    public function RoleList()
    {
        $roles = Role::all();
        return FuncController::handle('0000'.json_encode($roles));
    }

    public function Modify(Request $request)
    {
        $this->validate($request, [
        'rid'=> 'required|exists:role,id'
        ]);
        $nowUser = \Auth::user();
        if($nowUser->roleId == 1 )
        {
            $role = Role::find($request['rid']);
            if(isset($role) == 0)
                return FuncController::handle('0323');
            if($request->has('name'))               $role->name = $request->name;
            if($request->has('timeLimit'))     $role->timeLimit = $request->timeLimit;
            if($request->has('numLimit'))       $role->numLimit = $request->numLimit;
            $role->save();
            return FuncController::handle('0000');
        }
        else 
        {
            return FuncController::handle('0223');
        }
    }

}