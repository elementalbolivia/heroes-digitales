<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('index');
});

Route::prefix('api/v1')->group(function(){
	Route::get('cities', [
		'uses'	=> 'CityCtrl@index'
	]);
	Route::get('new-admin', [
		'uses'	=> 'RegisterCtrl@newAdmin'
	]);
	Route::get('shirts', [
		'uses'	=> 'ShirtCtrl@index'
	]);
	Route::get('genres', [
		'uses'	=> 'GenreCtrl@index'
	]);
	Route::post('register', [
		'uses'	=> 'RegisterCtrl@create'
	]);
	Route::get('email-verification/{id}/{token}/{email}', [
		'uses'	=> 'VerificatorCtrl@redirect'
	]);
	Route::post('creds-verification', [
		'uses'	=> 'VerificatorCtrl@confirmRegisterEmail'
	]);
	Route::post('login', [
		'uses'	=> 'LoginCtrl@login'
	]);
	Route::post('send-verification-email', [
		'uses'	=> 'ResetPasswordCtrl@sendVerifEmail'
	]);
	Route::put('reset-password', [
		'uses'	=> 'ResetPasswordCtrl@reset'
	]);
  Route::put('user/parents-auth', [
		'uses'	=> 'ParentsAuthCtrl@parentSign',
	]);
  Route::get('stages', [
		'uses'	=> 'StageCtrl@index',
	]);
  Route::get('confirm-invitation/{invId}/{token}/team/{teamid}/{bool}', [
		'uses'	=> 'TeamCtrl@confirmEmailInvitation',
	]);
});

Route::prefix('api/v1/auth')->group(function(){
	Route::get('user/{uid}', [
		'uses'			=> 'DashboardCtrl@userInfo',
		'middleware'	=> 'jwt.auth'
	]);
  Route::put('user/password/{uid}', [
		'uses'			=> 'UserCtrl@updatePassword',
		// 'middleware'	=> 'jwt.auth'
	]);
  Route::post('user/email-invitation', [
		'uses'			=> 'UserCtrl@sendEmailInvitation',
		'middleware'	=> 'jwt.auth'
	]);
  Route::put('user-active', [
		'uses'			=> 'UserCtrl@setActive',
		'middleware'	=> 'jwt.auth'
	]);
  Route::post('user/teachable', [
		'uses'			=> 'UserCtrl@setTeachableCreds',
		'middleware'	=> 'jwt.auth'
	]);
  Route::put('user/teachable/{teachable_id}', [
		'uses'			=> 'UserCtrl@setTeachableActive',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('divisions', [
		'uses'			=> 'DivisionCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('skills', [
		'uses'			=> 'SkillCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('expertises', [
		'uses'			=> 'ExpertiseCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('categories', [
		'uses'			=> 'CategoryCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('judges', [
		'uses'			=> 'JudgeCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('experts', [
		'uses'			=> 'ExpertCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('user/honor-code', [
		'uses'	=> 'HonorCodeCtrl@accept',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('user/parents-auth', [
		'uses'	=> 'ParentsAuthCtrl@accept',
		'middleware'	=> 'jwt.auth'
	]);
	Route::put('user/student/edit/{id}', [
		'uses'	=> 'StudentCtrl@edit',
		'middleware'	=> 'jwt.auth'
	]);
	Route::put('user/mentor/edit/{id}', [
		'uses'	=> 'MenthorCtrl@edit',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('user/edit/img/{id}', [
		'uses'	=> 'UserCtrl@updateImg',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('team', [
		'uses'	=> 'RegisterCtrl@createTeam',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('team/img', [
		'uses'	=> 'TeamCtrl@editTeamImg',
		'middleware'	=> 'jwt.auth'
	]);
	Route::put('team', [
		'uses'	=> 'TeamCtrl@editTeam',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('team', [
		'uses'	=> 'TeamCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('team-admin', [
		'uses'	=> 'TeamCtrl@indexAdmin',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('team/{id}', [
		'uses'	=> 'TeamCtrl@getTeam',
		'middleware'	=> 'jwt.auth'
	]);
  Route::delete('team/{id}', [
		'uses'	=> 'TeamCtrl@deleteTeam',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('team/member/invitation/{teamid}/{uid}/{role}', [
		'uses'	=> 'TeamCtrl@hasRequestSentTo',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('team/member', [
		'uses'	=> 'TeamCtrl@requestJoin',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('team/member/request', [
		'uses'	=> 'TeamCtrl@confirmRequestToJoin',
		'middleware'	=> 'jwt.auth'
	]);
  Route::delete('team/member/{mid}/invitation/{invid?}', [
		'uses'	=> 'TeamCtrl@deleteMembership',
		'middleware'	=> 'jwt.auth'
	]);
	Route::post('team/invitation', [
		'uses'	=> 'TeamCtrl@sendInvitation',
		'middleware'	=> 'jwt.auth'
	]);
	Route::put('team/invitation', [
		'uses'	=> 'TeamCtrl@confirmInvitation',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('students/{page}', [
		'uses'	=> 'StudentCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('students-admin/{num}', [
		'uses'	=> 'StudentCtrl@indexAdmin',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('student-parents/{id}', [
		'uses'	=> 'StudentCtrl@getParents',
		'middleware'	=> 'jwt.auth'
	]);
  Route::put('student/parents-auth-admin', [
		'uses'	=> 'StudentCtrl@authParent',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('mentors/{page}', [
		'uses'	=> 'MenthorCtrl@index',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('mentors-admin/{num}', [
		'uses'	=> 'MenthorCtrl@indexAdmin',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('stages/{id}', [
		'uses'	=> 'StageCtrl@getStage',
		'middleware'	=> 'jwt.auth'
	]);
  Route::post('stages', [
		'uses'	=> 'StageCtrl@create',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('stages/{sid}/checkpoints', [
		'uses'	=> 'CheckpointCtrl@getCheckPointsAtStage',
		'middleware'	=> 'jwt.auth'
	]);
  Route::post('checkpoints', [
		'uses'	=> 'CheckpointCtrl@createCheckpoint',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('checkpoints/{checkid}/questions', [
		'uses'	=> 'QuestionCtrl@getQuestionsFromCheckpoint',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('stages/{sid}/checkpoints/{cid}', [
		'uses'	=> 'CheckpointCtrl@getCheckpoint',
		'middleware'	=> 'jwt.auth'
	]);
  Route::post('checkpoints/{checkid}/questions', [
		'uses'	=> 'QuestionCtrl@createQuestions',
		'middleware'	=> 'jwt.auth'
	]);
	Route::get('cv/{name}', [
		'uses'	=> 'CVCtrl@getCV',
		'middleware'	=> 'jwt.auth'
	]);
	Route::put('request', [
		'uses'	=> 'RequestCtrl@accept',
		'middleware'	=> 'jwt.auth'
	]);
  Route::get('students/report/excel', [
    'uses'	=> 'StudentCtrl@excelReport',
		'middleware'	=> 'jwt.auth'
  ]);
  Route::get('mentors/report/excel', [
    'uses'	=> 'MenthorCtrl@excelReport',
		'middleware'	=> 'jwt.auth'
  ]);
  Route::get('teams/report/excel', [
    'uses'	=> 'TeamCtrl@excelReport',
		'middleware'	=> 'jwt.auth'
  ]);
  Route::post('project/video', [
    'uses'  => 'TeamCtrl@uploadVideo',
    'middleware'  => 'jwt.auth'
  ]);
  Route::put('project/video/{idVideo}/edit', [
    'uses'  => 'TeamCtrl@updateVideo',
    'middleware'  => 'jwt.auth'
  ]);
  Route::post('project/app-doc',[
    'uses'  => 'TeamCtrl@uploadAppDoc',
    'middleware'  => 'jwt.auth'
  ]);
  Route::post('project/app-apk',[
    'uses'  => 'TeamCtrl@uploadAppApk',
    'middleware'  => 'jwt.auth'
  ]);
  Route::get('expert/assignation', [
		'uses'	=> 'ExpertCtrl@expertAssign',
    'middleware'  => 'jwt.auth'
	]);
  Route::post('expert/team/assignation', [
		'uses'	=> 'ExpertCtrl@assignToTeam',
    'middleware'  => 'jwt.auth'
	]);
});


Route::get('{any?}', function(){
	return view('index');
})->where('any', '.+');
