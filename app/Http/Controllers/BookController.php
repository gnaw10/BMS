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
    public function New(Request $request)
    {
        $book = new Book;
        $book->name = $request['name'];
        $book->inTime = time();
        $book->outTime = $book->inTime;
        $book->coverUrl= $request['coverUrl'];
        $book->save();
        return FuncController::handle('0000');
    }
    public function BookOut(Request $request)
    {
        $uid = $request['uid'];
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
        
        $uid = $request['uid'];
        $bid = $request['bid'];
        $books = User::find(2)->books->count();
        $book = Book::find($bid);
        $book->outTime = time();
        $book->inTime = $book->outTime;
        $book->user()->dissociate();
        $book->save();
        return FuncController::handle('0000');
    }
    public function List()
    {

        $books = Book::all();
        foreach( $books as &$book)
        {
            if($book->outTime > $book->inTime)
                $book['nowIn'] = 0;
            else 
                $book['nowIn'] = 1;
        }
        return FuncController::handle('0000'.json_encode($books));
    }
}