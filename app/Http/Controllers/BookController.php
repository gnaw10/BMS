<?php

namespace App\Http\Controllers;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Providers;

class BookController extends Controller
{
    public function Add(Request $request)
    {
        $book = new Book;
        if($request->has('name'))
            $book->name = $request['name'];
        else 
            return FuncController::handle('0331');
        $book->inTime = time();
        $book->outTime = $book->inTime;
        if($request->has('coverUrl'))
            $book->coverUrl= $request['coverUrl'];
        else 
            return FuncController::handle('0331');

        $book->save();
        return FuncController::handle('0000');
    }

    public function BookOut(Request $request)
    {
        $nowUser = \Auth::user();
        $role = \App\Model\Role::find($nowUser->roleId);
        $num = User::find($nowUser->id)->books->count();
        $book = Book::find($request['bid']);

        if($role->numLimit <= $num)   // 超出借书限制
            return FuncController::handle('0132');
        
        if($book->outTime > $book->inTime)   // 该书已借出
            return FuncController::handle('0132');

        $uid = \Auth::user()->id;
        $bid = $request['bid'];
        $book = Book::find($bid);
        $book->outTime = time();
        $user = User::find($uid);
        $book->user()->associate($user);
        $book->save();
        return FuncController::handle('0000');
    }

    public function BookIn(Request $request)
    {
        
        $nowUser = \Auth::user();
        $bid = $request['bid'];
        $books = User::find($nowUser['id'])->books;
        $book = User::find($nowUser['id'])->books->find($bid);
        if(isset($book) == 0)
            return FuncController::handle('0133');  // 该书已归还或该书非当前用户借出
        $book->outTime = time();
        $book->inTime = $book->outTime;
        $book->user()->dissociate();
        $book->save();
        return FuncController::handle('0000');
    }

    public function BookList()
    {
        $books = Book::all();
        foreach( $books as &$book)
        {
            unset($book['inTime']);
            unset($book['outTime']);
            
            if($book->outTime > $book->inTime)
                {
                    //$book['nowIn'] = 0;
                    //$book['borrowTime'] = BookController::timediff(time(),$book->outTime);//($book->inTime - $book->inTime)/(3600*24);
                    $book['borrowUser'] = Book::find($book['id'])->user->username;
                }
            else 
                {
                    //$book['nowIn'] = 1;
                    //$book['borrowTime'] = [];
                    $book['borrowUser'] = '';
                }

        }
        return FuncController::handle('0000'.json_encode($books));
    }

   public function Modify(Request $request)
    {
        $book = Book::find($request['bid']);
        $user = \Auth::user();
        if($user->roleId != 1)
            return FuncController::handle('0235');

        if($request->has('name'))
            $book->name = $request['name'];
        
        if($request->has('coverUrl'))
            $book->coverUrl= $request['coverUrl'];
       

        $book->save();
        return FuncController::handle('0000');
    }
    
}