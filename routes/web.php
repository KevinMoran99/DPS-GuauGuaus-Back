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
    $router->get('/usertypes', 'UserType@index');
    $router->get('/usertypes/{id}', 'UserType@show');
    $router->post('/usertypes', 'UserType@store');
    $router->put('/usertypes', 'UserType@update');

    /*routes Permissions*/
    $router->get('/permissions', 'Permission@index');
    $router->get('/permissions/{id}', 'Permission@show');
    $router->post('/permissions', 'Permission@store');
    $router->put('/permissions', 'Permission@update');

    /*routes Medical Conditions*/
    $router->get('/medicalconditions', 'MedicalCondition@index');
    $router->get('/medicalconditions/{id}', 'MedicalCondition@show');
    $router->post('/medicalconditions', 'MedicalCondition@store');
    $router->put('/medicalconditions', 'MedicalCondition@update');

    /*routes Appointment Types*/
    $router->get('/appointmenttypes', 'AppointmentType@index');
    $router->get('/appointmenttypes/{id}', 'AppointmentType@show');
    $router->post('/appointmenttypes', 'AppointmentType@store');
    $router->put('/appointmenttypes', 'AppointmentType@update');

    /*routes User*/
    $router->get('/users', 'User@index');
    $router->get('/users/{id}', 'User@show');
    $router->post('/users', 'User@store');
    $router->put('/users', 'User@update');
//});