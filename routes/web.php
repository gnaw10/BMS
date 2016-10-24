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


$app->get('/user', function ()  {
    $data=User::find(1)->username;
    var_dump($data);
});
                        
$app->post('/user/signin','UserController@Signin');
$app->post('/user/signup','UserController@Signup');
$app->post('/user/show','UserController@Show');
$app->post('/role/list','RoleController@List');
$app->post('/book/new','BookController@New');
$app->post('/book/borrow','BookController@BookOut');
$app->post('/book/loan','BookController@BookIn');
$app->post('/book/list','BookController@List');
$app->post('/log/new','LogController@New');
$app->post('/log/list','LogController@List');
$app->post('/log/search','LogController@Search');


//$app->post()

$app->get('/post/{id}', ['middleware' => 'auth', function (Request $request, $id) {
    $user = Auth::user();
    $user = $request->user();

    //
}]);
