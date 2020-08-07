<?php
////////////////////////////////////  Authentication Urls   //////////////////////////////////////
Route::get('/', 'Client\ClientController@welcome')->name('client.welcome');
Route::get('/client/ballot', 'Client\ClientController@ballot')->name('client.ballot');
Route::get('client/', 'Client\ClientController@index')->name('client.index');
Route::post('client/sendpincode', 'Client\ClientController@sendpincode')->name('client.sendpincode');

Route::group(['middleware' => 'client', 'prefix'=>'client', 'namespace'=>'Client'], function () {
    Route::get('/viewcand', 'ClientController@viewcand')->name('client.viewcand');
    Route::get('/lang', 'ClientController@lang')->name('client.lang');
    Route::get('/race', 'ClientController@race')->name('client.race');
    Route::get('/prop', 'ClientController@prop')->name('client.prop');
    Route::post('/propcount', 'ClientController@propcount')->name('client.propcount');
    Route::post('/updateprops', 'ClientController@updateprops')->name('client.updateprops');
    Route::get('/mass', 'ClientController@mass')->name('client.mass');
    Route::post('/masscount', 'ClientController@masscount')->name('client.masscount');
    Route::post('/updatemass', 'ClientController@updatemass')->name('client.updatemass');
    Route::get('/review', 'ClientController@review')->name('client.review');
    Route::post('/racecount', 'ClientController@racecount')->name('client.racecount');
    Route::post('/updaterace', 'ClientController@updaterace')->name('client.updaterace');
    Route::get('/back/{id}', 'ClientController@back')->name('client.back');
    Route::get('/backrace/{id}', 'ClientController@backrace')->name('client.backrace');
    Route::post('/racedecount', 'ClientController@racedecount')->name('client.racedecount');
    Route::post('/cast', 'ClientController@cast')->name('client.cast');
});
Route::get('admin/', 'AuthController@login')->name('request');

Route::get('/forgotPassword', 'AuthController@forgotPassword')->name('request');
Route::get('/logout', 'AuthController@logout')->name('request');
Route::post('/login', 'AuthController@loginApi')->name('request');

////////////////////////////////////  Dashboard Urls   //////////////////////////////////////
Route::get('/dashboard', 'DashboardController@index')->name('request');

////////////////////////////////////  Manage Urls   /////////////////////////////////////////
Route::prefix('/manage')->group(function() {
    Route::get('/ballot', 'BallotController@index')->name('request');
    Route::get('/race', 'RaceController@index')->name('request');
    Route::get('/candidate', 'CandidateController@index')->name('request');
    Route::get('/proposition', 'PropositionController@index')->name('request');
    Route::get('/mass_proposition', 'MassPropositionController@index')->name('request');
    Route::get('/voter', 'VoterController@index')->name('request');
    Route::get('/party', 'PartyController@index')->name('request');
    Route::get('/county', 'CountyController@index')->name('request');
    Route::get('/language', 'LanguageController@index')->name('request');
    Route::get('/location', 'LocationController@index')->name('request');
});

////////////////////////////////////  User Url   ////////////////////////////////////////////
Route::get('/users', 'UserController@index')->name('request');

Route::get('/profile/{id}', 'AuthController@profile')->name('profile');
Route::get('/changepwd/{id}', 'AuthController@changepwd')->name('changepwd');

Route::prefix('result')->group(function () {
    Route::get('candidate', 'ResultController@candidate');
    Route::get('proposition', 'ResultController@proposition');
    Route::get('ballot', 'ResultController@ballot');
    Route::get('ballotcal', 'ResultController@ballotcal');
    Route::get('voter', 'ResultController@voter');
    Route::get('votercal', 'ResultController@votercal');
});

///////////////////////////////////////////////////////////////////////////////////////////////
Route::post('/deleteData', 'BaseController@deleteData')->name('request');
Route::post('/mutiDeleteData', 'BaseController@mutiDeleteData')->name('request');
Route::post('/pinDeleteData', 'BaseController@pinDeleteData')->name('request');

Route::post('/createUser', 'UserController@createUser')->name('request');
Route::post('/updateUser', 'UserController@updateUser')->name('request');
Route::post('/getOneUser', 'UserController@getOneUser')->name('request');

Route::post('/createBallot', 'BallotController@createBallot')->name('request');
Route::post('/updateBallot', 'BallotController@updateBallot')->name('request');
Route::post('/deleteBallot', 'BallotController@deleteBallot')->name('request');
Route::post('/deleteBallots', 'BallotController@deleteBallots')->name('request');
Route::post('/changeBallotActive', 'BallotController@changeBallotActive')->name('request');
Route::post('/getChangedBallot', 'BallotController@getChangedBallot')->name('request');

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
Route::post('/getChangedCand1', 'CandidateController@getChangedCand1')->name('request');
Route::post('/getCandRaces', 'CandidateController@getCandRaces')->name('request');

Route::post('/getOneParty', 'PartyController@getOneParty')->name('request');
Route::post('/createParty', 'PartyController@createParty')->name('request');
Route::post('/updateParty', 'PartyController@updateParty')->name('request');
Route::post('/getChangedParty', 'PartyController@getChangedParty')->name('request');

Route::post('/createVoter', 'VoterController@createVoter')->name('request');
Route::post('/getOneVoter', 'VoterController@getOneVoter')->name('request');
Route::post('/updateVoter', 'VoterController@updateVoter')->name('request');
Route::post('/verifiyVoter', 'VoterController@verifiyVoter')->name('request');

Route::post('/getChangedLangs', 'LanguageController@getChangedLangs')->name('request');
Route::post('/setAvalBallotLang', 'LanguageController@setAvalBallotLang')->name('request');
Route::post('/saveAllLang', 'LanguageController@saveAllLang')->name('request');

Route::post('/setAvalBallotCounty', 'CountyController@setAvalBallotCounty')->name('request');
Route::post('/saveAllCounty', 'CountyController@saveAllCounty')->name('request');
Route::post('/getChangedCountyOfBallot', 'CountyController@getChangedCountyOfBallot')->name('request');

Route::get('/setOldVB', 'VoterController@setOldVB')->name('request');
Route::get('/setOldRVB', 'ResultController@setOldRVB')->name('request');
Route::get('/setOldRVP', 'ResultController@setOldRVP')->name('request');

Route::post('/createState', 'LocationController@createState')->name('request');
Route::post('/updateState', 'LocationController@updateState')->name('request');

Route::post('/createCounty', 'LocationController@createCounty')->name('request');
Route::post('/updateCounty', 'LocationController@updateCounty')->name('request');
Route::post('/getChangedCountyOfState', 'LocationController@getChangedCountyOfState')->name('request');