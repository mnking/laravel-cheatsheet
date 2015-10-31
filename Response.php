<?php

//Dependency Injection
use Illuminate\Http\Response;

//Basic Responses
Route::get('home', function () {
    return (new Response($content, $status))
                  ->header('Content-Type', $value);
});
// OR for convennience, you may use response helper
Route::get('home', function () {
    return response($content, $status)
                  ->header('Content-Type', $value);
});

//For a full list of available Response methods,
// check out its API documentation 
// http://laravel.com/api/master/Illuminate/Http/Response.html

//Attaching Headers To Responses
return response($content)
            ->header('Content-Type', $type)
            ->header('X-Header-One', 'Header Value')
            ->header('X-Header-Two', 'Header Value');

//Attaching Cookies To Responses
//->withCookie($name, $value, $minutes, $path, $domain, $secure, $httpOnly)
return response($content)->header('Content-Type', $type)
                 ->withCookie('name', 'value');
// OR
$response->withCookie(cookie('name', 'value', $minutes));
$response->withCookie(cookie()->forever('name', 'value'));

//Can except encrypt cookies in middleware 
//Illuminate\Cookie\Middleware\EncryptCookies
protected $except = [
    'cookie_name',
];

//View Responses
return response()->view('hello', $data)->header('Content-Type', $type);

//JSON Responses
return response()->json(['name' => 'Abigail', 'state' => 'CA']);

//JSONP callback
return response()->json(['name' => 'Abigail', 'state' => 'CA'])
                 ->setCallback($request->input('callback'));

//Response Macros
//It define a custom response that you can re-use in a variety of 
//your routes and controllers
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param  ResponseFactory  $factory
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('caps', function ($value) use ($factory) {
            return $factory->make(strtoupper($value));
        });
    }
}

return response()->caps('foo'); // FOO


