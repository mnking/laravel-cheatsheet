<?php

//Automatic use htmlentities php function when using 
// {{ $var }}

//Run PHP code in Blade
{{ time() }}

//Blade & JavaScript Frameworks (AngularJS)
@{{ $var }}

// Echoing Data If It Exists
{{ isset($name) ? $name : 'Default' }} = {{ $name or 'Default' }}

//Displaying Unescaped Data. Be careful when use it
Hello, {!! $name !!}

//If Statements
@if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I dont have any records!
@endif

//OR
@unless (Auth::check())
    You are not signed in
@endunless

//Loops
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach

@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>Im looping forever.</p>
@endwhile

// Including Sub-Views
// all data available in the parent view will pass to include view
// Also can pass array to include view
@include('view.name', ['some' => 'data'])

// Rendering Views For Collections
$jobs = [
	'one', 'two', 'three'
];
@each('view.name', $jobs, 'job')
//Will render empty view when job is a empty array
@each('view.name', $jobs, 'job', 'view.empty')


// Comments
{{-- This comment will not be present in the rendered HTML --}}

// Service Injection
@inject('metrics', 'App\Services\MetricsService')

<div>
    Monthly Revenue: {{ $metrics->monthlyRevenue() }}
</div>


//Extending Blade
//Blade even allows you to define your own custom directives


class AppServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('datetime', function($expression) {
            return "<?php echo with{$expression}->format('m/d/Y H:i'); ?>";
        });
    }

}
