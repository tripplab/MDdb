<?php

// header('Access-Control-Allow-Origin:  http://localhost:4200/');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers'], function (Router $api) {
        $api->post('signup', 'AuthController@signUp');
        $api->post('login', 'AuthController@login');

        $api->post('recovery', 'AuthController@sendResetEmail');
        $api->post('reset', 'AuthController@resetPassword');

        $api->post('logout', 'AuthController@logout');
        $api->post('refresh', 'AuthController@refresh');
        $api->get('me', 'UsersController@me');
    });


    $api->group(['middleware' => ['jwt.auth', 'bindings'], 'namespace' => 'App\Http\Controllers'], function (Router $api) {
        $api->get('protected', function () {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.',
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function () {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!',
                ]);
            },
        ]);

        //Users
        $api->get('users', 'UsersController@index');
        $api->get('users/{id}', 'UsersController@show');
        $api->post('users/', 'UsersController@store');
        $api->put('users/{id}', 'UsersController@update');
        $api->delete('users/{id}', 'UsersController@destroy');
        $api->post('users/{user}/restore', 'UsersController@restore');
        $api->get('search/users', 'UsersController@search');
        $api->get('roles/users', 'UsersController@roles');
        $api->get('permissions/users', 'UsersController@permissions');

        //Studies
        $api->post('study', 'StudiesController@store');
        $api->put('study/{id}', 'StudiesController@update');
        $api->delete('study/{id}', 'StudiesController@destroy');
    });


// Routes for visitors not login required
    $api->group(['namespace' => 'App\Http\Controllers'], function (Router $api) {
        $api->get('studies', 'StudiesController@index');
        $api->get('study/{id}', 'StudiesController@show');
    });

    $api->get('hello', function () {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.',
        ]);
    });
});
