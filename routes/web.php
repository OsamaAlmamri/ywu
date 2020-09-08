<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('asking.tryshow');
//});

Route::get('/admin_login', 'AdminLoginController@Admin_login')->name('Admin_login');
Route::get('/admin_forget', 'AdminLoginController@Admin_forget')->name('Admin_Forget');
Route::post('/admin_forget_check', 'AdminLoginController@Admin_forget_check')->name('Admin_Forget_check');

//Route::get('/admin', 'AdminLoginController@Admin')->middleware('auth:admin')->name('Admin');

Route::post('/check_admin_login', 'AdminLoginController@adminLoginCheck')->name('login_admin');

Route::group(['middleware' => ('auth:admin')], function () {
    Route::get('/admin', 'AdminLoginController@Admin')->name('Admin');
    Route::get('/admin_edit', 'AdminLoginController@Update_Admin_Details')->name('Admin_Edit');
    Route::post('/admin_update', 'AdminLoginController@Admin_update')->name('Admin_Update');
    Route::get('/admin_logout', 'AdminLoginController@LogoutAdmin')->name('Admin_logout');
#################################################### Users
    Route::get('user/destroy/{id}', 'FrontUserController@destroy');
    Route::get('userShow/{id?}', 'FrontUserController@index')->name('user');
    Route::get('userShowId/{id}', 'FrontUserController@index');
    Route::get('user-trashed', 'FrontUserController@index_trashed')->name('user-trashed');
    Route::get('trashedShow/{id}', 'FrontUserController@index_trashed');
    Route::get('user/edit-trashed/{id}', 'FrontUserController@edit_trashed');
    Route::get('restore-user/{id}', 'FrontUserController@restore_post');
    Route::get('force-user/{id}', 'FrontUserController@force');

####################### ajax الاستشارات
    Route::get('home_age', 'AdminController@index')->name('home');
    Route::delete('delete-multiple-category', ['as' => 'post.multiple-delete', 'uses' => 'AdminController@deleteMultiple']);
    Route::post('update-multiple-category', ['as' => 'post.multiple-update', 'uses' => 'AdminController@update_multi']);
    Route::delete('force-multiple-category', ['as' => 'post.multiple-force', 'uses' => 'AdminController@forceMultiple']);
    Route::post('restore-multiple-category', ['as' => 'post.multiple-restore', 'uses' => 'AdminController@restoreMultiple']);
    Route::post('showPost', 'AdminController@fetch')->name('fetch');
    Route::post('updatePost', 'AdminController@update')->name('update');
    Route::post('deletePost', 'AdminController@destroy')->name('delete');
    Route::get('deletedPost', 'AdminController@deletedPost')->name('deleted_Post');
    Route::post('restorePost', 'AdminController@restore')->name('restore');
    Route::post('forcePost', 'AdminController@force')->name('force');
    Route::get('showPost', 'AdminController@show')->name('showPosts');
    Route::post('deleteComment', 'AdminController@comment_D')->name('delete_comment');


#################################################### data table women contents
    Route::resource('ajax-crud', 'WomenController');
    Route::get('show/{id}', 'WomenController@show');
    Route::get('edit/{id}', 'WomenController@edit');
    Route::post('ajax-crud/update', 'WomenController@update')->name('ajax-crud.update');
    Route::get('ajax-crud/destroy/{id}', 'WomenController@destroy');
    Route::get('WShow', 'WomenController@index')->name('women');
    Route::get('WShow-trashed', 'WomenController@index_trashed')->name('women-trashed');
    Route::get('edit-trashed/{id}', 'WomenController@edit_trashed');
    Route::get('restore-post/{id}', 'WomenController@restore_post');
    Route::get('force-delete/{id}', 'WomenController@force');

#################################################### Subjects
    Route::get('subject/edit/{id}', 'FrontSubjectController@edit');
    Route::post('subject/store', 'FrontSubjectController@store')->name('subject.store');
    Route::post('subject/update', 'FrontSubjectController@update')->name('subject.update');
    Route::get('subject/destroy/{id}', 'FrontSubjectController@destroy');
    Route::get('subjectShow', 'FrontSubjectController@index')->name('subject');
    Route::get('subject-trashed', 'FrontSubjectController@index_trashed')->name('subject-trashed');
    Route::get('subject/edit-trashed/{id}', 'FrontSubjectController@edit_trashed');
    Route::get('restore-subject/{id}', 'FrontSubjectController@restore_post');
    Route::get('force-subject/{id}', 'FrontSubjectController@force');

#################################################### Trainings
    Route::get('training/show/{id}', 'FrontTrainingController@show');
    Route::get('training/edit/{id}', 'FrontTrainingController@edit');
    Route::post('training/store', 'FrontTrainingController@store')->name('training.store');
    Route::post('training/update', 'FrontTrainingController@update')->name('training.update');
    Route::get('training/destroy/{id}', 'FrontTrainingController@destroy');
    Route::get('trainingShow', 'FrontTrainingController@index')->name('training');
    Route::get('training-trashed', 'FrontTrainingController@index_trashed')->name('training-trashed');
    Route::get('training/show-trashed/{id}', 'FrontTrainingController@show_trashed');
    Route::get('restore-training/{id}', 'FrontTrainingController@restore_post');
    Route::get('force-training/{id}', 'FrontTrainingController@force');

#################################################### Titles
    Route::get('title/show/{id}', 'FrontTitleController@show');
    Route::get('title/edit/{id}', 'FrontTitleController@edit');
    Route::post('title/store', 'FrontTitleController@store')->name('title.store');
    Route::post('title/update', 'FrontTitleController@update')->name('title.update');
    Route::get('title/destroy/{id}', 'FrontTitleController@destroy');
    Route::get('titleShow', 'FrontTitleController@index')->name('title');
    Route::get('/showID/{id}', 'FrontTitleController@index')->name('showTitles');
    Route::get('Show_title/{id}', 'FrontTitleController@Show_title');
    Route::get('title-trashed', 'FrontTitleController@index_trashed')->name('title-trashed');
    Route::get('title/show-trashed/{id}', 'FrontTitleController@show_trashed');
    Route::get('restore-title/{id}', 'FrontTitleController@restore_post');
    Route::get('force-title/{id}', 'FrontTitleController@force');

#################################################### questions
    Route::get('results/index/{id}', 'QuestionsController@results')->name('questions.results');
    Route::post('questions/update', 'QuestionsController@update')->name('questions.update');
    Route::get('questions/destroy/{id}', 'QuestionsController@destroy');
    Route::get('questions/edit/{id}', 'QuestionsController@edit');
    Route::get('questions/index/{id}', 'QuestionsController@index')->name('questions.index');
    Route::resource('questions', 'QuestionsController')->except('index', 'update');

#################################################### results

#################################################### Contents
    Route::get('content/show/{id}', 'FrontContentController@show');
    Route::get('content/edit/{id}', 'FrontContentController@edit');
    Route::post('content/store', 'FrontContentController@store')->name('content.store');
    Route::post('content/update', 'FrontContentController@update')->name('content.update');
    Route::get('content/destroy/{id}', 'FrontContentController@destroy');
    Route::get('contentShow', 'FrontContentController@index')->name('content');
    Route::get('content-trashed', 'FrontContentController@index_trashed')->name('content-trashed');
    Route::get('content/show-trashed/{id}', 'FrontContentController@show_trashed');
    Route::get('restore-content/{id}', 'FrontContentController@restore_post');
    Route::get('force-content/{id}', 'FrontContentController@force');
    Route::get('/showContentID/{id}', 'FrontContentController@index_edit')->name('showContentID');

#################################################### Employees Categories
    Route::get('Category/edit/{id}', 'FrontEmployeeCategory@edit');
    Route::post('Category/store', 'FrontEmployeeCategory@store')->name('Emp_Category.store');
    Route::post('Category/update', 'FrontEmployeeCategory@update')->name('Emp_Category.update');
    Route::get('Category/destroy/{id}', 'FrontEmployeeCategory@destroy');
    Route::get('CategoryShow', 'FrontEmployeeCategory@index')->name('Emp_Category');

    #################################################### emp_jobs
    Route::get('jobs/edit/{id}', 'JobsController@edit');
    Route::post('jobs/store', 'JobsController@store')->name('jobs.store');
    Route::post('jobs/update', 'JobsController@update')->name('jobs.update');
    Route::get('jobs/destroy/{id}', 'JobsController@destroy');
    Route::get('jobs', 'JobsController@index')->name('jobs');


    #### category_trainings
    Route::get('CategoryShowId/{id}', 'FrontEmployeeCategory@index_edit')->name('CategoryShowId');
    Route::post('Category_training/store', 'FrontEmployeeCategory@store_training')->name('Emp_Category_Training.store');
    Route::get('Category_training/destroy/{id}', 'FrontEmployeeCategory@destroy_training');

    ##################################### Employees
    Route::get('EmployeeShowId/{id}', 'FrontEmployeeController@index_id');
    Route::get('Employee/show/{id}', 'FrontEmployeeController@show');
    Route::get('Employee/edit/{id}', 'FrontEmployeeController@edit');
    Route::post('Employee/store', 'FrontEmployeeController@store')->name('employee.store');
    Route::post('Employee/update', 'FrontEmployeeController@update')->name('employee.update');
    Route::get('Employee/destroy/{id}', 'FrontEmployeeController@destroy');
    Route::get('EmployeeShow/{id?}', 'FrontEmployeeController@index')->name('employee');
    Route::get('Employee-trashed/{id?}', 'FrontEmployeeController@index_trashed')->name('employee-trashed');
    Route::get('E_trashedShow/{id}', 'FrontEmployeeController@index_trashed_id');
    Route::get('Employee/edit-trashed/{id}', 'FrontEmployeeController@edit_trashed');
    Route::get('restore-Employee/{id}', 'FrontEmployeeController@restore_post');
    Route::get('force-Employee/{id}', 'FrontEmployeeController@force');
    ##################################### SharedUser
    Route::get('SharedUser/agree/{id}', 'FrontSharedUserController@agree');
    Route::get('SharedUser/destroy/{id}', 'FrontSharedUserController@destroy');
    Route::get('SharedUserShow/{id?}', 'FrontSharedUserController@index')->name('SharedUser');
    Route::get('SharedUserAgree', 'FrontSharedUserController@agreeUsers')->name('SharedUserAgree');
    Route::get('SharedUserTrashed/{id?}', 'FrontSharedUserController@trashedUsers')->name('SharedUserTrashed');
    Route::get('SharedUserRestore/{id}', 'FrontSharedUserController@restoreUser');
    Route::get('SharedUserForce/{id}', 'FrontSharedUserController@forceUser');
});
Auth::routes();
