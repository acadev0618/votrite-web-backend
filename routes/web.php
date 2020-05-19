<?php

Route::get('/', 'AuthController@login')->name('request');
Route::get('/forgotPassword', 'AuthController@forgotPassword')->name('request');
Route::get('/dashboard', 'DashboardController@index')->name('request');
Route::get('/ballot', 'BallotController@index')->name('request');
Route::get('/race', 'RaceController@index')->name('request');
Route::get('/candidate', 'CandidateController@index')->name('request');
Route::get('/language', 'LanguageController@index')->name('request');
Route::get('/country', 'CountryController@index')->name('request');
Route::get('/proposition', 'PropositionController@index')->name('request');
Route::get('/mass_proposition', 'MassPropositionController@index')->name('request');
Route::get('/voter', 'VoterController@index')->name('request');
Route::get('/users', 'UserController@index')->name('request');
Route::get('/party', 'PartyController@index')->name('request');
Route::get('/logout', 'AuthController@logout')->name('request');

Route::post('/deleteData', 'BaseController@deleteData')->name('request');
Route::post('/mutiDeleteData', 'BaseController@mutiDeleteData')->name('request');

Route::post('/login', 'AuthController@loginApi')->name('request');

Route::post('/createUser', 'UserController@createUser')->name('request');
Route::post('/updateUser', 'UserController@updateUser')->name('request');

Route::post('/createBallot', 'BallotController@createBallot')->name('request');
Route::post('/updateBallot', 'BallotController@updateBallot')->name('request');
Route::post('/deleteBallot', 'BallotController@deleteBallot')->name('request');
Route::post('/deleteBallots', 'BallotController@deleteBallots')->name('request');

Route::post('/createRace', 'RaceController@createRace')->name('request');
Route::post('/updateRace', 'RaceController@updateRace')->name('request');
Route::post('/getRaceData', 'RaceController@getRaceData')->name('request');
Route::post('/getOneRace', 'RaceController@getOneRace')->name('request');