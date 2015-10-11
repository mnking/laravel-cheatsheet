<?php


// Basic Routing

Route::get('user/profile', [
    'as' => 'profile', 
    'uses' => 'userController@profileAction',
    'middleware' => 'auth',
]);

Route::get('/', function () {
    return 'Hello World';
});

Route::post('foo/bar', function () {
    return 'Hello World';
});

Route::put('foo/bar', function () {
    //
});

Route::delete('foo/bar', function () {
    //
});


// Route For Multiple HTTP Requests

Route::match(['get', 'post'], '/', function () {
    return 'Hello World';
});

Route::any('foo', function () {
    return 'Hello World';
});

// Route Parameters

Route::get('user/{id}', function ($id) {
    return 'User ' . $id;
});

Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});

//Note: Route parameters cannot contain the - character. Use an underscore (_) instead.
//Not use user-id
Route::get('user/{user_id}', function ($id) {
    return 'User ' . $id;
});

//Optional Parameters
//If param not has name, system will get default value
Route::get('user/{name?}', function ($name = null) {
    return $name;
});

Route::get('user/{name?}', function ($name = 'John') {
    return $name;
});

//Regular Expression Constraints

Route::get('user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);


//Global Constraints
//Define global pattern in App\Providers\RouteServiceProvider
//After Define, your {id} param will be numeric
public function boot(Router $router)
{
    $router->pattern('id', '[0-9]+');

    parent::boot($router);
}

//Named Routes

Route::get('user/profile', [
    'as' => 'profile', 
    'uses' => 'userController@profileAction',
]);

//Group with middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function ()    {
        // Uses Auth Middleware
    });

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });
});

//Group with NameSpace
Route::group(['namespace' => 'Admin'], function()
{
    // Controllers Within The "App\Http\Controllers\Admin" Namespace

    Route::group(['namespace' => 'User'], function()
    {
        // Controllers Within The "App\Http\Controllers\Admin\User" Namespace
    });
});

//Group with Sub-Domain Routing
Route::group(['domain' => '{account}.myapp.com'], function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
});

//Group with Prefixes
Route::group(['prefix' => 'accounts/{account_id}'], function () {
    Route::get('detail', function ($account_id)    {
        // Matches The accounts/{account_id}/detail URL
    });
});

