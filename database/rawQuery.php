<?php

//Running Raw SQL Queries

//SELECT
$users = DB::select('select * from users where active = ?', [1]);

//Using Named Bindings
$results = DB::select('select * from users where id = :id', ['id' => 1]);

// INSERT
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);

//UPDATE
//Return number of effected row
$affected = DB::update('update users set votes = 100 where name = ?', ['John']);

//DELETE
//Return number of effected row
$deleted = DB::delete('delete from users');

//Running A General Statement
DB::statement('drop table users');

//Listening For Query Events
//This method is useful for logging queries or debugging
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function($sql, $bindings, $time) {
            //
        });
    }
}

//Database Transactions

//Automatic rollback and commit in closure
DB::transaction(function () {
    DB::table('users')->update(['votes' => 1]);

    DB::table('posts')->delete();
});

//Manually Using Transactions
DB::beginTransaction();
DB::rollBack();
DB::commit();

//Using Multiple Database Connections
$users = DB::connection('foo')->select(...);

//Access basic PDO instance
$pdo = DB::connection()->getPdo();