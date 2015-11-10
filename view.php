<?php

//render and passing array to view
return view('admin.profile', []);

//or 
$view = view('greeting')
	->with('name', 'Victoria')
	->with('salary', '10k');

//Check view exists
if (view()->exists('emails.customer')) {
    //
}

//Sharing Data With All Views
//Typically, you would place calls to share within 
//a service provider's boot method of AppServiceProvider 
//Or generate a separate service provider to house them
view()->share('key', 'value');

//Implement viewComposer in serviceProvider
public function boot()
{
    // Using class based composers...
    view()->composer(
        'profile', 'App\Http\ViewComposers\ProfileComposer'
    );

    // Using Closure based composers...
    view()->composer('dashboard', function ($view) {

    });
}

//Attaching A Composer To Multiple Views
view()->composer(
    ['profile', 'dashboard'],
    'App\Http\ViewComposers\MyViewComposer'
);

//Or for all view
view()->composer('*', function ($view) {
    //
});

//View Creators
//View creators are very similar to view composers
//however, they are fired immediately when the view is instantiated instead of waiting until the view is about to render
//Mean data can be override in controller or other else if using creator, composer is not
view()->creator('profile', 'App\Http\ViewCreators\ProfileCreator');

