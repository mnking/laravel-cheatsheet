<?php

//Assign variable to view in controller
return view('user.profile', ['user' => User::findOrFail($id)]);
// or
return view('home', compact('user'));

//Generate url with named route
$url = route('name');

//Generate url with controller and action name
$url = action('FooController@method');

//Access the name of controller and action
use Illuminate\Support\Facades\Route;
$action = Route::currentRouteAction();

//Using middleware in __contruct method of controller
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);

        $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }
}