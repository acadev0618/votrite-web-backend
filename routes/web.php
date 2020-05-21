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

////////////////////////////////
Route::get('/profile/{id}', 'AuthController@profile')->name('profile');
Route::get('/changepwd/{id}', 'AuthController@changepwd')->name('changepwd');
///////////////////////////////

Route::post('/deleteData', 'BaseController@deleteData')->name('request');
Route::post('/mutiDeleteData', 'BaseController@mutiDeleteData')->name('request');

Route::post('/login', 'AuthController@loginApi')->name('request');

Route::post('/createUser', 'UserController@createUser')->name('request');
Route::post('/updateUser', 'UserController@updateUser')->name('request');
Route::post('/getOneUser', 'UserController@getOneUser')->name('request');

Route::post('/createBallot', 'BallotController@createBallot')->name('request');
Route::post('/updateBallot', 'BallotController@updateBallot')->name('request');
Route::post('/deleteBallot', 'BallotController@deleteBallot')->name('request');
Route::post('/deleteBallots', 'BallotController@deleteBallots')->name('request');

Route::post('/createRace', 'RaceController@createRace')->name('request');
Route::post('/updateRace', 'RaceController@updateRace')->name('request');
Route::post('/getOneRace', 'RaceController@getOneRace')->name('request');
Route::post('/getChangedRaces', 'RaceController@getChangedRaces')->name('request');

Route::post('/createProposition', 'PropositionController@createProposition')->name('request');
Route::post('/updateProposition', 'PropositionController@updateProposition')->name('request');
Route::post('/getOneProp', 'PropositionController@getOneProp')->name('request');
Route::post('/getChangedProps', 'PropositionController@getChangedProps')->name('request');
Route::post('/getChangedMassProps', 'MassPropositionController@getChangedMassProps')->name('request');

Route::post('/createCandidate', 'CandidateController@createCandidate')->name('request');
Route::post('/getOneCand', 'CandidateController@getOneCand')->name('request');
Route::post('/updateCandidate', 'CandidateController@updateCandidate')->name('request');
Route::post('/getChangedCand', 'CandidateController@getChangedCand')->name('request');
Route::post('/getCandRaces', 'CandidateController@getCandRaces')->name('request');

Route::post('/getOneParty', 'PartyController@getOneParty')->name('request');
Route::post('/createParty', 'PartyController@createParty')->name('request');
Route::post('/updateParty', 'PartyController@updateParty')->name('request');
Route::post('/getChangedParty', 'PartyController@getChangedParty')->name('request');

Route::post('/createVoter', 'VoterController@createVoter')->name('request');
Route::post('/getOneVoter', 'VoterController@getOneVoter')->name('request');
Route::post('/updateVoter', 'VoterController@updateVoter')->name('request');
Route::post('/verifiyVoter', 'VoterController@verifiyVoter')->name('request');