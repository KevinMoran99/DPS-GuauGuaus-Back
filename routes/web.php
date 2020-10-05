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
    $router->get('/users', 'UserController@index');
    $router->get('/species', 'SpecieController@index');

    $router->get('/pets', 'PetController@index');
    $router->post('/pets', 'PetController@store');
    $router->get('/pets/{id}', 'PetController@show');
    $router->put('/pets', 'PetController@update');
    $router->get('/pets/client/{owner_id}', 'PetController@getPetbyOwner');
    $router->get('/pets/specie/{specie_id}', 'PetController@getPetbySpecie');


    $router->get('/species/{id}', 'SpecieController@show');
    $router->post('/species', 'SpecieController@store');
    $router->put('/species', 'SpecieController@update');
//});