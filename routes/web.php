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

$router->post('/users/login',['uses'=>'UsersController@getToken']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/////////////////////////////////////////////////////////////////////
//Metodos GET para obtener usuarios, alarmas y movimientos

$router->get('/users', ['uses'=>'UsersController@index']);
$router->post('/alarms',['uses'=>'AlarmsController@index']);
$router->get('/movements',['uses'=>'MovementsController@index']);

////////////////////////////////////////////////////////////////////

// Metodos post de usuarios

$router->post('/users', ['uses'=>'UsersController@createUser']);
$router->post('/user/update',['uses'=>'UsersController@update']);

////////////////////////////////////////////////////////////////

//Metodos post movimientos

$router->post('/movement/create',['uses'=>'MovementsController@createMovement']);


////////////////////////////////////////////////////////////////////////

$router->post('/alarms/create',['uses'=>'AlarmsController@createAlarm']);
$router->post('/alarms/delete',['uses'=>'AlarmsController@destroy']);
$router->post('/alarms/update',['uses'=>'AlarmsController@update']);