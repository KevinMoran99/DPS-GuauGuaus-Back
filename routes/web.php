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

//Login route
$router->post('/login', 'UserController@login');

$router->group(['middleware' => 'auth'], function () use ($router) {
    
    /*routes pets*/
    $router->get('/pets', 'PetController@index');
    $router->post('/pets', 'PetController@store');
    $router->get('/pets/active', 'PetController@getActivePets');
    $router->get('/pets/specie/{specie_id}', 'PetController@getPetbySpecie');
    $router->get('/pets/{id}', 'PetController@show');
    $router->post('/pets/update', 'PetController@update');
    $router->put('/pets', 'PetController@update');
    $router->get('/pets/client/{owner_id}', 'PetController@getPetbyOwner');

    /*routes species*/
    $router->get('/species', 'SpecieController@index');
    $router->get('/species/active', 'SpecieController@getActiveSpecies');
    $router->get('/species/{id}', 'SpecieController@show');
    $router->post('/species', 'SpecieController@store');
    $router->put('/species', 'SpecieController@update');


    /*routes User Types*/
    $router->get('/usertypes', 'UserTypesController@index');
    $router->get('/usertypes/active', 'UserTypesController@getActiveUserTypes');
    $router->get('/usertypes/{id}', 'UserTypesController@show');
    $router->post('/usertypes', 'UserTypesController@store');
    $router->put('/usertypes', 'UserTypesController@update');

    /*routes Permissions*/
    $router->get('/permissions', 'PermissionController@index');
    $router->get('/permissions/active', 'PermissionController@getActivePermission');
    $router->get('/permissions/users/{type_users_id}', 'PermissionController@getTypeUsersPermissions');
    $router->get('/permissions/users/active/{type_users_id}', 'PermissionController@getActiveTypeUsersPermissions');
    $router->get('/permissions/{id}', 'PermissionController@show');
    $router->post('/permissions', 'PermissionController@store');
    $router->put('/permissions', 'PermissionController@update');

    /*routes Medical Conditions*/
    $router->get('/medicalconditions', 'MedicalConditionController@index');
    $router->get('/medicalconditions/active', 'MedicalConditionController@getActiveMedicalCondition');
    $router->get('/medicalconditions/{id}', 'MedicalConditionController@show');
    $router->post('/medicalconditions', 'MedicalConditionController@store');
    $router->put('/medicalconditions', 'MedicalConditionController@update');

    /*routes Appointment Types*/
    $router->get('/appointmenttypes', 'AppointmentTypeController@index');
    $router->get('/appointmenttypes/active', 'AppointmentTypeController@getActiveAppointmentTypes');
    $router->get('/appointmenttypes/{id}', 'AppointmentTypeController@show');
    $router->post('/appointmenttypes', 'AppointmentTypeController@store');
    $router->put('/appointmenttypes', 'AppointmentTypeController@update');

    /*routes User*/
    $router->get('/users', 'UserController@index');
    $router->get('/users/active', 'UserController@getActiveUsers');
    $router->get('/users/{id}', 'UserController@show');
    $router->post('/users', 'UserController@store');
    $router->put('/users', 'UserController@update');
    $router->get('/logout', 'UserController@logout');
    $router->get('/profile', 'UserController@profile');
    $router->post('/socials', 'UserController@storeSocial');

    /*routes PetDetails*/
    $router->get('/petdetails', 'PetDetailController@index');
    $router->get('/petdetails/active', 'PetDetailController@getActivePetDetails');
    $router->get('/petdetails/pets/active/{pet_id}', 'PetDetailController@showActiveMediConditionsForPets');
    $router->get('/petdetails/condition/active/{condition_id}', 'PetDetailController@showMediConditionsForConditionsactive');
    $router->get('/petdetails/condition/{condition_id}', 'PetDetailController@showMediConditionsForConditions');
    $router->get('/petdetails/pets/{pet_id}', 'PetDetailController@showMediConditionsForPets');
    $router->get('/petdetails/{id}', 'PetDetailController@show');
    $router->post('/petdetails', 'PetDetailController@store');
    $router->put('/petdetails', 'PetDetailController@update');

    /*routes Schedules*/
    $router->get('/schedules', 'ScheduleController@index');
    $router->get('/schedules/active', 'ScheduleController@getActiveSchedules');
    $router->get('/schedules/doctor/active/{doctor_id}', 'ScheduleController@getDoctorActiveSchedules');
    $router->get('/schedules/{id}', 'ScheduleController@show');
    $router->get('/schedules/doctor/{doctor_id}', 'ScheduleController@getDoctorSchedules');
    $router->post('/schedules', 'ScheduleController@store');
    $router->put('/schedules', 'ScheduleController@update');

    /*routes Specials*/
    $router->get('/specials', 'SpecialController@index');
    $router->get('/specials/{id}', 'SpecialController@show');
    $router->post('/specials', 'SpecialController@store');
    $router->put('/specials', 'SpecialController@update');
    $router->get('/specials/doctor/{doctor_id}', 'SpecialController@getDoctorSpecials');
    $router->get('/specials/doctor/active/{doctor_id}', 'SpecialController@getDoctorActiveSpecials');


});