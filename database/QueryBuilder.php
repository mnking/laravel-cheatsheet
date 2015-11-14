<?php

use DB;

////Retrieving Results

//Retrieving All Rows From A Table
$users = DB::table('users')->get();

//Retrieving A Single Row
$user = DB::table('users')->where('name', 'John')->first();

//Retriving A Column From A Tables
$email = DB::table('users')->where('name', 'John')->value('email');

//Chunking Results From A Table
//This method retrieves a small "chunk" (limit) of the results at a time
DB::table('users')->chunk(100, function($users) {
    foreach ($users as $user) {
        //Retrieving each 100 user and processing
    }
});
//only process first 100 users
DB::table('users')->chunk(100, function($users) {
    // Process the records...

    return false;
});

//Retrieving A List Of Column Values
$titles = DB::table('roles')->lists('title');
$roles = DB::table('roles')->lists('title', 'name');
//name is a key and must be a column in that table. Example:
foreach ($roles as $name => $title) {
    echo $title;
}

//Aggregates
//such as count, max, min, avg, and sum
$users = DB::table('users')->count();
$price = DB::table('orders')->max('price');
$price = DB::table('orders')
                ->where('finalized', 1)
                ->avg('price');




////Selects
//Specifying A Select Clause
$users = DB::table('users')->select('name', 'email as user_email')->get();

//Retrieving Distinst result
$users = DB::table('users')->distinct()->get();

//Add a column to its existing select clause
$query = DB::table('users')->select('name');
$users = $query->addSelect('age')->get();

//Raw Expressions
//Using DB::raw()
$users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count, status'))
                     ->where('status', '<>', 1)
                     ->groupBy('status')
                     ->get();


//Joins
//Inner Join Statement
$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders AS o', 'users.id', '=', 'o.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

//Left Join Statement
$users = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->get();

//Advanced Join Statements
DB::table('users')
        ->join('contacts', function ($join) {
            $join->on('users.id', '=', 'contacts.user_id')->orOn(...);
        })
        ->get();
//or
DB::table('users')
        ->join('contacts', function ($join) {
            $join->on('users.id', '=', 'contacts.user_id')
                 ->where('contacts.user_id', '>', 5);
        })
        ->get();