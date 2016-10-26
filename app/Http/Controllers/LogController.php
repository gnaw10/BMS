<?php

namespace App\Http\Controllers;

use App\Model\Log;
use App\Model\Book;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers;

class LogController extends Controller
{
    public function Add(Request $request)
    {
        $log = new Log;
        if($request->has('title'))
            $log->title = $request['title'];
        if($request->has('body'))
            $log->body = $request['body'];
        if($request->has('bid'))
        {
            $book = Book::find($request['bid']);
            $log->book()->associate($book);
        }

        $user = \Auth::user();
        $log->user()->associate($user);

        $log->save();
        return FuncController::handle('0000');
    }

    public function LogList(Request $request)
    {
        $logs = Log::all();
        
        return FuncController::handle('0000'.json_encode($logs));
    }

    public function Search(Request $request)
    {
        $uid = $request['uid'];
        $logs = User::find($uid)->logs;
        return FuncController::handle('0000'.json_encode($logs));
    }

    public function Modify(Request $request)
    {
        $user = \Auth::user();
        $log = Log::find($request['lid']);
        if(($user->roleId == 1 || $user->id === $log->user->id) == false)
        {
            return FuncController::handle('0244');
        }

        if(isset($log) == 0)
            return FuncController::handle('0344');
        if($request->has('title'))   $log->title = $request['title'];
        if($request->has('body'))     $log->body = $request['body'];
        if($request->has('bid'))    
        {
            $book = Book::find($request['bid']);
            $log->book()->associate($book);
        }
        $log->save();
        return FuncController::handle('0000');
    }
}
