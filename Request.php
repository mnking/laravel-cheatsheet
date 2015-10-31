<?php

//Dependency Injection
use Illuminate\Http\Request;

// list your route arguments after your other dependencies
public function update(Request $request, $id)
{
    //
}

//http://domain.com/foo/bar, the path method will return foo/bar:
$uri = $request->path();

//The is method allows you to verify that the incoming 
//request URI matches a given pattern
//Can use *
if ($request->is('admin/*')) {
    //
}

//get the full URL
$url = $request->url();

//Retrieving and Verify The Request Method
$method = $request->method();

if ($request->isMethod('post')) {
    //
}

//Retrieving An Input Value
$name = $request->input('name');
$name = $request->name;
$name = $request->input('name', 'Sally'); //default is SAlly
//with array inputs
$input = $request->input('products.0.name');

//Determining If An Input Value Is Present
if ($request->has('name')) {
    //
}

//Retrieving All Input Data
$input = $request->all();

//Retrieving A Portion Of The Input Data
$input = $request->only(['username', 'password']);

$input = $request->only('username', 'password');

$input = $request->except(['credit_card']);

$input = $request->except('credit_card');

//flash the current input to the session
$request->flash();

$request->flashOnly('username', 'email');

$request->flashExcept('password');

//Flash Input Into Session Then Redirect
return redirect('form')->withInput();

return redirect('form')->withInput($request->except('password'));

//Retrieving Old Data (flash data)
$username = $request->old('username');
{{ old('username') }}

//Retrieving Cookies From The Request
$value = $request->cookie('name');

// Retrieving Uploaded Files
$file = $request->file('photo');

//Verifying File Presence
if ($request->hasFile('photo')) {
    //
}

//Validating Successful Uploads
if ($request->file('photo')->isValid()) {
    //
}

//Moving Uploaded Files
$request->file('photo')->move($destinationPath);

$request->file('photo')->move($destinationPath, $fileName);

//other file api
//http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/File/UploadedFile.html
$request->file('photo')->api();