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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1 
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');


    //jurusan
    $router->get('/jur','DevJurController@index');
    $router->get('/jur/{id}','DevJurController@show');
    $router->post('/jur','DevJurController@store');
    $router->put('/jur/{id}','DevJurController@update');
    $router->delete('/jur/{id}','DevJurController@destroy');
    //jenis tagihan
    $router->get('/jenis','DevJenisController@index');
    $router->get('/jenis/{id}','DevJenisController@show');
    $router->post('/jenis','DevJenisController@store');
    $router->put('/jenis/{id}','DevJenisController@update');
    $router->delete('/jenis/{id}','DevJenisController@destroy');

    //siswa
    $router->get('/siswa','DevSiswaController@index');
    $router->get('/siswa/{id}','DevSiswaController@show');
    $router->post('/siswa','DevSiswaController@store');
    $router->put('/siswa/{id}','DevSiswaController@update');
    $router->delete('/siswa/{id}','DevSiswaController@destroy');

    //tgh
    $router->get('/tgh','DevTagihanController@index');
    $router->post('/tgh','DevTagihanController@store');


});
 
