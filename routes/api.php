<?php

// header('Access-Control-Allow-Origin:  http://localhost:4200/');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth', 'namespace' => 'App\Api\V1\Controllers'], function (Router $api) {
        $api->post('signup', 'SignUpController@signUp');
        $api->post('login', 'LoginController@login');

        $api->post('recovery', 'ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'ResetPasswordController@resetPassword');

        $api->post('logout', 'LogoutController@logout');
        $api->post('refresh', 'RefreshController@refresh');
        $api->get('me', 'UserController@me');
    });

    $api->group(['middleware' => ['jwt.auth', 'bindings'], 'namespace' => 'App\Api\V1\Controllers'], function (Router $api) {
        $api->get('protected', function () {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.',
            ]);
        });

        $api->resource('molecular-dynamics', '\App\Http\Controllers\MolecularDynamicsController');

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function () {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!',
                ]);
            },
        ]);

        //Users
        $api->get('users', 'UserController@index');
        $api->get('users/{id}', 'UserController@show');
        $api->post('users/', 'UserController@store');
        $api->put('users/{id}', 'UserController@update');
        $api->delete('users/{id}', 'UserController@destroy');
        $api->post('users/{user}/restore', 'UserController@restore');
        $api->get('search/users', 'UserController@search');
        $api->get('roles/users', 'UserController@roles');
        $api->get('permissions/users', 'UserController@permissions');
    });

    $api->resource('studies', '\App\Http\Controllers\StudiesController');

    $api->get('hello', function () {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.',
        ]);
    });
});
