<?php

//Generate a Seeder
php artisan make:seeder UsersTableSeeder

// Seed by insert new record
public function run()
{
    DB::table('users')->insert([
        'name' => str_random(10),
        'email' => str_random(10).'@gmail.com',
        'password' => bcrypt('secret'),
    ]);
}

//Use Model Factories
public function run()
{
	factory(App\User::class, 50)->create();
}
//OR with relationship
public function run()
{
    factory(App\User::class, 50)->create()->each(function($u) {
        $u->posts()->save(factory(App\Post::class)->make());
    });
}

// Running Seeders
php artisan db:seed //Run ala seeder that call in DatabaseSeeder
php artisan db:seed --class=UserTableSeeder
