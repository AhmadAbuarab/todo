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

// using jwt token



// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'ExampleController@register');
    $router->post('login', 'ExampleController@postLogin');
//    $router->get('profile', 'TodoController@profile');

});


// profile route group
$router->group(['prefix' => 'profile'], function () use ($router) {
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('add', 'TodoController@add');
        $router->get('get', 'TodoController@show');
        $router->get('get/{id}', 'TodoController@showById');
        $router->get('getByUser/{id}', 'TodoController@showByUserId');

    });
});
