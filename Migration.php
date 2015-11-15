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

//Available Column Types
$table->bigIncrements('id');	//Incrementing ID (primary key) using a "UNSIGNED BIG INTEGER" equivalent.
$table->bigInteger('votes');	//BIGINT equivalent for the database.
$table->binary('data');	//BLOB equivalent for the database.
$table->boolean('confirmed');	//BOOLEAN equivalent for the database.
$table->char('name', 4);	//CHAR equivalent with a length.
$table->date('created_at');	//DATE equivalent for the database.
$table->dateTime('created_at');	//DATETIME equivalent for the database.
$table->decimal('amount', 5, 2);	//DECIMAL equivalent with a precision and scale.
$table->double('column', 15, 8);	//DOUBLE equivalent with precision, 15 digits in total and 8 after the decimal point.
$table->enum('choices', ['foo', 'bar']);	//ENUM equivalent for the database.
$table->float('amount');	//FLOAT equivalent for the database.
$table->increments('id');	//Incrementing ID (primary key) using a "UNSIGNED INTEGER" equivalent.
$table->integer('votes');	//INTEGER equivalent for the database.
$table->json('options');	//JSON equivalent for the database.
$table->jsonb('options');	//JSONB equivalent for the database.
$table->longText('description');	//LONGTEXT equivalent for the database.
$table->mediumInteger('numbers');	//MEDIUMINT equivalent for the database.
$table->mediumText('description');	//MEDIUMTEXT equivalent for the database.
$table->morphs('taggable');	//Adds INTEGER taggable_id and STRING taggable_type.
$table->nullableTimestamps();	//Same as timestamps(), except allows NULLs.
$table->rememberToken();	//Adds remember_token as VARCHAR(100) NULL.
$table->smallInteger('votes');	//SMALLINT equivalent for the database.
$table->softDeletes();	//Adds deleted_at column for soft deletes.
$table->string('email');	//VARCHAR equivalent column.
$table->string('name', 100);	//VARCHAR equivalent with a length.
$table->text('description');	//TEXT equivalent for the database.
$table->time('sunrise');	//TIME equivalent for the database.
$table->tinyInteger('numbers');	//TINYINT equivalent for the database.
$table->timestamp('added_on');	//TIMESTAMP equivalent for the database.
$table->timestamps();	//Adds created_at and updated_at columns.

//Column Modifiers
Schema::table('users', function ($table) {
    $table->string('email')->nullable();
});


//Column Modifiers Type
$table->first()	//Place the column "first" in the table (MySQL Only)
$table->after('column')	//Place the column "after" another column (MySQL Only)
$table->nullable()	//Allow NULL values to be inserted into the column
$table->default($value)	//Specify a "default" value for the column
$table->unsigned()	//Set integer columns to UNSIGNED


////////////////////////////////////////////////////////
// Modifying Columns                                  //
// Use doctrine/dbal dependency to your composer.json //
// https://packagist.org/packages/doctrine/dbal       //
////////////////////////////////////////////////////////

// Updating Column Attributes
Schema::table('users', function ($table) {
    $table->string('name', 50)->change();
});
// OR
Schema::table('users', function ($table) {
    $table->string('name', 50)->nullable()->change();
});

// Renaming Columns
// Renaming columns in a table with a enum column is not currently supported.
Schema::table('users', function ($table) {
    $table->renameColumn('from', 'to');
});

//Dropping Columns
Schema::table('users', function ($table) {
    $table->dropColumn('votes');
});

//Drop multiple column
Schema::table('users', function ($table) {
    $table->dropColumn(['votes', 'avatar', 'location']);
});

// Creating Indexes
$table->string('email')->unique();
$table->unique('email');
$table->index(['account_id', 'created_at']);

// Available Index Types
$table->primary('id');	//Add a primary key.
$table->primary(['first', 'last']);	//Add composite keys.
$table->unique('email');	//Add a unique index.
$table->index('state');	//Add a basic index.


// Dropping Indexes
$table->dropPrimary('users_id_primary');	//Drop a primary key from the "users" table.
$table->dropUnique('users_email_unique');	//Drop a unique index from the "users" table.
$table->dropIndex('geo_state_index');	//Drop a basic index from the "geo" table.




/////////////////////////////
// Foreign Key Constraints //
/////////////////////////////
Schema::table('posts', function ($table) {
    $table->integer('user_id')->unsigned();

    $table->foreign('user_id')->references('id')->on('users');
});

$table->foreign('user_id')
      ->references('id')->on('users')
      ->onDelete('cascade');

$table->dropForeign('posts_user_id_foreign');