<?php

//Generate new create migrate table
php artisan make:migration create_users_table --create=users

//Generate new alter migrate column
php artisan make:migration add_votes_to_users_table --table=users

// Running Migrations
php artisan migrate
// OR carefully
php artisan migrate --force


//Rolling Back Migrations
//Rollback to the last migration
php artisan migrate:rollback

//Reset Migration
//Rollback all Migration
php artisan migrate:reset

//Rollback and Migrate In Single Command
//Also re insert into databse by seeder
php artisan migrate:refresh
php artisan migrate:refresh --seed

//Creating Tables
Schema::create('users', function (Blueprint $table) {
    $table->increments('id');
});

//Checking For Table Exists
if (Schema::hasTable('users')) {
    //
}

//Checking Column Exists
if (Schema::hasColumn('users', 'email')) {
    //
}

// Migrate to other connection
Schema::connection('foo')->create('users', function ($table) {
    $table->increments('id');
});

//Migrate Storage Engine
Schema::create('users', function ($table) {
    $table->engine = 'InnoDB';
});

//Renaming / Dropping Tables
Schema::rename($from, $to);
Schema::drop('users');
Schema::dropIfExists('users');

//Creating Columns
Schema::table('users', function ($table) {
    $table->string('email');
});