<?php
//Redirect responses are instances of 
//the Illuminate\Http\RedirectResponse
Route::get('dashboard', function () {
    return redirect('home/dashboard');
});

//Redirect to previous location
return back()->withInput();

//Redirecting To Named Routes
return redirect()->route('login');

// For a route with the following URI: profile/{id}
return redirect()->route('profile', [1]);

//Redirecting To Controller Actions
return redirect()->action('HomeController@index');

// if your controller route requires parameters
return redirect()->action('UserController@profile', [1]);

//Redirecting With Flashed Session Data
Route::post('user/profile', function () {
    // Update the user's profile...

    return redirect('dashboard')->with('status', 'Profile updated!');
});

//get in blade syntax
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif