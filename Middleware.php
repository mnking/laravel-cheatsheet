//HTTP middleware is a mechanism for filtering HTTP requests

//Make new middleware file by artisan
php artisan make:middleware AuthenticateMiddleware

<?php

//Before / After Middleware

//Before done a request
public function handle($request, Closure $next)
{
    // Perform action

    return $next($request);
}

//after done a request
//Mean begin a response
public function handle($request, Closure $next)
{
    $response = $next($request);

    // Perform action

    return $response;
}

//Global Middleware
//list the middleware class in the $middleware property of your 
//app/Http/Kernel.php class.


//Assigning Middleware To Routes
//Two step
//1. Add the middleware a short-hand key in the $routeMiddleware
//property of your app/Http/Kernel.php file and get alias
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
];
//2. Assign alias to route
Route::get('admin/profile', ['middleware' => 'auth', function () {
    //
}]);

//or assign multiple middleware
Route::get('/', ['middleware' => ['first', 'second'], function () {
    //
}]);


//Middleware Parameters
public function handle($request, Closure $next, $role)
{
    if (! $request->user()->hasRole($role)) {
        // Redirect...
    }

    return $next($request);
}
// and assign it
Route::put('post/{id}', ['middleware' => 'role:editor', function ($id) {
    //
}]);
//or Multiple parameters should be delimited by commas
Route::put('post/{id}', ['middleware' => 'role:editor,admin,tester', function ($id) {
    //
}]);

