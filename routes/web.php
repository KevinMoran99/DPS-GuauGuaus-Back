<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();

});
//$router->group(['middleware' => 'auth'], function () use ($router) {
    
    /*routes pets*/
    $router->get('/pets', 'PetController@index');
    $router->post('/pets', 'PetController@store');
    $router->get('/pets/{id}', 'PetController@show');
    $router->put('/pets', 'PetController@update');
    $router->get('/pets/client/{owner_id}', 'PetController@getPetbyOwner');
    $router->get('/pets/specie/{specie_id}', 'PetController@getPetbySpecie');

    /*routes species*/
    $router->get('/species', 'SpecieController@index');
    $router->get('/species/{id}', 'SpecieController@show');
    $router->post('/species', 'SpecieController@store');
    $router->put('/species', 'SpecieController@update');


    /*routes User Types*/
    $router->get('/usertypes', 'UserTypesController@index');
    $router->get('/usertypes/{id}', 'UserTypesController@show');
    $router->post('/usertypes', 'UserTypesController@store');
    $router->put('/usertypes', 'UserTypesController@update');

    /*routes Permissions*/
    $router->get('/permissions', 'PermissionController@index');
    $router->get('/permissions/{id}', 'PermissionController@show');
    $router->post('/permissions', 'PermissionController@store');
    $router->put('/permissions', 'PermissionController@update');

    /*routes Medical Conditions*/
    $router->get('/medicalconditions', 'MedicalConditionController@index');
    $router->get('/medicalconditions/{id}', 'MedicalConditionController@show');
    $router->post('/medicalconditions', 'MedicalConditionController@store');
    $router->put('/medicalconditions', 'MedicalConditionController@update');

    /*routes Appointment Types*/
    $router->get('/appointmenttypes', 'AppointmentTypeController@index');
    $router->get('/appointmenttypes/{id}', 'AppointmentTypeController@show');
    $router->post('/appointmenttypes', 'AppointmentTypeController@store');
    $router->put('/appointmenttypes', 'AppointmentTypeController@update');

    /*routes User*/
    $router->get('/users', 'UserController@index');
    $router->get('/users/{id}', 'UserController@show');
    $router->post('/users', 'UserController@store');
    $router->put('/users', 'UserController@update');
    $router->post('/login', 'UserController@login');
    $router->get('/profile', 'UserController@profile');

//});