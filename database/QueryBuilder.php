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

//Unions
$first = DB::table('users')
            ->whereNull('first_name');

$users = DB::table('users')
            ->whereNull('last_name')
            ->union($first)
            ->get();
//Similar with unionAll()
$users = DB::table('users')
            ->whereNull('last_name')
            ->unionAll($first);


////Where Clauses
//Simple Where Clauses
$users = DB::table('users')->where('votes', 100)->get();
$users = DB::table('users')
                ->where('votes', '>=', 100)
                ->get();
$users = DB::table('users')
                ->where('votes', '<>', 100)
                ->get();
$users = DB::table('users')
                ->where('name', 'like', 'T%')
                ->get();


// Or Statements
$users = DB::table('users')
                    ->where('votes', '>', 100)
                    ->orWhere('name', 'John')
                    ->get();

// whereBetween
$users = DB::table('users')
                    ->whereBetween('votes', [1, 100])->get();

// whereNotBetween
$users = DB::table('users')
                    ->whereNotBetween('votes', [1, 100])
                    ->get();

// whereIn
$users = DB::table('users')
                    ->whereIn('id', [1, 2, 3])
                    ->get();

// whereNotIn
$users = DB::table('users')
                    ->whereNotIn('id', [1, 2, 3])
                    ->get();

// whereNull 
$users = DB::table('users')
                    ->whereNull('updated_at')
                    ->get();

// whereNotNull
$users = DB::table('users')
                    ->whereNotNull('updated_at')
                    ->get();

// Where Parameter Grouping
// select * from users where name = 'John' or (votes > 100 and title <> 'Admin')
DB::table('users')
            ->where('name', '=', 'John')
            ->orWhere(function ($query) {
                $query->where('votes', '>', 100)
                      ->where('title', '<>', 'Admin');
            })->get();

// Where Exists Statements
// select * from users
// where exists (
//     select 1 from orders where orders.user_id = users.id
// )
DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('orders')
                      ->whereRaw('orders.user_id = users.id');
            })->get();



////Ordering, Grouping, Limit, & Offset
//orderBy
$users = DB::table('users')
                ->orderBy('name', 'desc')
                ->get();

//groupBy
$users = DB::table('users')
                ->groupBy('account_id')
                ->get();

//having 
$users = DB::table('users')
                ->groupBy('account_id')
                ->having('account_id', '>', 100)
                ->get();

// havingRaw
$users = DB::table('orders')
                ->select('department', DB::raw('SUM(price) as total_sales'))
                ->groupBy('department')
                ->havingRaw('SUM(price) > 2500')
                ->get();

//skip / take (Offset / Limit)
// select * from `users` limit 5 offset 2
$users = DB::table('users')->skip(2)->take(5)->get();

////Inserts
//Insert a Row into the database table
DB::table('users')->insert(
    ['email' => 'john@example.com', 'votes' => 0]
);
//OR Multiple Insert
DB::table('users')->insert([
    ['email' => 'taylor@example.com', 'votes' => 0],
    ['email' => 'dayle@example.com', 'votes' => 0]
]);

//Retriving Auto-Incrementing IDs
$id = DB::table('users')->insertGetId(
    ['email' => 'john@example.com', 'votes' => 0]
);

////Updates
// Update existing record
DB::table('users')
            ->where('id', 1)
            ->update(['votes' => 1]);

//Update Increment / Decrement value of a given column
//second parameter is number that you wanna to increment or decrement
//Default increment or decrement 1
DB::table('users')->increment('votes');
DB::table('users')->increment('votes', 5);
DB::table('users')->decrement('votes');
DB::table('users')->decrement('votes', 5);

// AND More update can be used in three param
// update `users` set `votes` = `votes` + 1, `name` = 'John'
DB::table('users')->increment('votes', 1, ['name' => 'John']);

////Deletes
DB::table('users')->where('votes', '<', 100)->delete();

//Very carefully below delete and truncate statement
//================carefully===============//
DB::table('users')->delete();
DB::table('users')->truncate();
//================carefully===============//


////Pessimistic Locking

//lock in share mode
//SELECT * FROM users WHERE id=1 lock in share mode
//will allow other transaction to READ the locked row but 
//it will not allow other transaction to UPDATE or DELETE the row
DB::table('users')->where('id', 1)->sharedLock()->get();

//Lock for update
//SELECT * FROM users WHERE id=1 for update
//will not allow other transactions to READ, UPDATE or DELETE the row
DB::table('users')->where('id', 1)->lockForUpdate()->get();

