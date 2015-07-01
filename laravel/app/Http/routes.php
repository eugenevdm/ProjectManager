<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/search', 'SearchController@index');

Route::get('/queryTasks', 'SearchController@queryTasks');
Route::get('/queryTasklists', 'SearchController@queryTasklists');
Route::get('/queryProjects', 'SearchController@queryProjects');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');

Route::model('projects', 'Project');
Route::model('tasklists', 'Tasklist');
Route::model('tasks', 'Task');

Route::bind('project', function($value, $route) {
    return App\Project::whereSlug($value)->first();
});

Route::bind('tasklist', function($value, $route) {
    return App\Tasklist::whereSlug($value)->first();
});

Route::bind('task', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});

Route::resource('project', 'ProjectController');
Route::resource('project.tasklist', 'TasklistController');
Route::resource('project.tasklist.task', 'TaskController');

