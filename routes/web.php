<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use App\Http\Controllers;
use Illuminate\Http\Request;


$app->get('/', function () use ($app) {
   
    \Auth::check();
    echo \Auth::user();
    return $app->version();
});
                        
$app->post('/user/signin','UserController@Signin');
$app->post('/user/signup','UserController@Signup');
$app->post('user/show','UserController@Show');
$app->post('user/modify','UserController@Modify');
$app->post('user/list','UserController@UserList');

$app->post('/role/list','RoleController@RoleList');
$app->post('/role/show','RoleController@Show');
$app->post('/role/modify','RoleController@Modify');

$app->post('/book/new','BookController@Add');
$app->post('/book/borrow','BookController@BookOut');
$app->post('/book/loan','BookController@BookIn');
$app->post('/book/list','BookController@BookList');
$app->post('/book/modify','BookController@Modify');

$app->post('/log/new','LogController@Add');
$app->post('/log/list','LogController@LogList');
$app->post('/log/search','LogController@Search');
$app->post('/log/modify','LogController@Modify');



$app->get('/post/{id}', ['middleware' => 'auth', function (Request $request, $id) {
    $user = Auth::user();
    $user = $request->user();

    //
}]);
