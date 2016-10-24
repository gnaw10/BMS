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
    public function New(Request $request)
    {
        $log = new Log;
        $log->title = $request['title'];
        $log->body = $request['body'];
        
        $user = User::find($request['uid']);
        $log->user()->associate($user);
        $book = Book::find($request['bid']);
        $log->book()->associate($book);
        echo $log->title;
        $log->save();
    }

    public function List(Request $request)
    {
        $logs = Log::all();
        
        echo User::find(2)->logs->count();
        echo User::find(1)->logs->count();
        echo Book::find(2)->logs->count();
        echo Book::find(1)->logs->count();
        
        return FuncController::handle('0000'.json_encode($logs));
    }

    public function Search(Request $request)
    {
        $uid = $request['uid'];
        $logs = User::find($uid)->logs;
        return FuncController::handle('0000'.json_encode($logs));
    }
}
