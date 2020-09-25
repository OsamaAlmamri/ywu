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

Route::get('/', 'AdminLoginController@Admin_login')->name('Admin_login');
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
    Route::get('user/destroy/{id}', 'UserController@destroy');
    Route::get('userShow/{id?}', 'UserController@index')->name('user');
    Route::get('userShowId/{id}', 'UserController@index');
    Route::get('user-trashed', 'UserController@index_trashed')->name('user-trashed');
    Route::get('trashedShow/{id}', 'UserController@index_trashed');
    Route::get('user/edit-trashed/{id}', 'UserController@edit_trashed');
    Route::get('restore-user/{id}', 'UserController@restore_post');
    Route::get('force-user/{id}', 'UserController@force');

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
    Route::get('subject/edit/{id}', 'SubjectController@edit');
    Route::post('subject/store', 'SubjectController@store')->name('subject.store');
    Route::post('subject/update', 'SubjectController@update')->name('subject.update');
    Route::get('subject/destroy/{id}', 'SubjectController@destroy');
    Route::get('subjectShow', 'SubjectController@index')->name('subject');
    Route::get('subject-trashed', 'SubjectController@index_trashed')->name('subject-trashed');
    Route::get('subject/edit-trashed/{id}', 'SubjectController@edit_trashed');
    Route::get('restore-subject/{id}', 'SubjectController@restore_post');
    Route::get('force-subject/{id}', 'SubjectController@force');

#################################################### Trainings
    Route::get('training/show/{id}', 'TrainingController@show');
    Route::get('training/edit/{id}', 'TrainingController@edit');
    Route::post('training/store', 'TrainingController@store')->name('training.store');
    Route::post('training/update', 'TrainingController@update')->name('training.update');
    Route::get('training/destroy/{id}', 'TrainingController@destroy');
    Route::get('trainingShow', 'TrainingController@index')->name('training');
    Route::get('training-trashed', 'TrainingController@index_trashed')->name('training-trashed');
    Route::get('training/show-trashed/{id}', 'TrainingController@show_trashed');
    Route::get('restore-training/{id}', 'TrainingController@restore_post');
    Route::get('force-training/{id}', 'TrainingController@force');

#################################################### Titles
    Route::get('title/show/{id}', 'TitleController@show');
    Route::get('title/edit/{id}', 'TitleController@edit');
    Route::post('title/store', 'TitleController@store')->name('title.store');
    Route::post('title/update', 'TitleController@update')->name('title.update');
    Route::get('title/destroy/{id}', 'TitleController@destroy');
    Route::get('titleShow', 'TitleController@index')->name('title');
    Route::get('/showID/{id}', 'TitleController@index')->name('showTitles');
    Route::get('Show_title/{id}', 'TitleController@Show_title');
    Route::get('title-trashed', 'TitleController@index_trashed')->name('title-trashed');
    Route::get('title/show-trashed/{id}', 'TitleController@show_trashed');
    Route::get('restore-title/{id}', 'TitleController@restore_post');
    Route::get('force-title/{id}', 'TitleController@force');

#################################################### questions
    Route::get('results/index/{id}', 'QuestionsController@results')->name('questions.results');
    Route::post('questions/update', 'QuestionsController@update')->name('questions.update');
    Route::get('questions/destroy/{id}', 'QuestionsController@destroy');
    Route::get('questions/edit/{id}', 'QuestionsController@edit');
    Route::get('questions/index/{id}', 'QuestionsController@index')->name('questions.index');
    Route::resource('questions', 'QuestionsController')->except('index', 'update');

#################################################### sliders
    Route::post('slides/update', 'SlideController@update')->name('slides.update');
    Route::get('slides/destroy/{id}', 'SlideController@destroy');
    Route::get('slides/edit/{id}', 'SlideController@edit');
    Route::post('slides/changeOrder', 'SlideController@changeOrder')->name('slides.changeOrder');
    Route::post('slides/active', 'SlideController@active')->name('slides.active');
    Route::resource('slides', 'SlideController')->except('update');

#################################################### activates
    Route::get('activates/show/{id}', 'ActivitiesController@show');
    Route::post('activates/update', 'ActivitiesController@update')->name('activates.update');
    Route::get('activates/destroy/{id}', 'ActivitiesController@destroy');
    Route::get('activates/edit/{id}', 'ActivitiesController@edit');
    Route::post('activates/changeOrder', 'ActivitiesController@changeOrder')->name('activates.changeOrder');
    Route::post('activates/active', 'ActivitiesController@active')->name('activates.active');
    Route::resource('activates', 'ActivitiesController')->except('update');

#################################################### results

#################################################### Contents
    Route::get('content/show/{id}', 'ContentController@show');
    Route::post('upload_image', 'ContentController@upload_image')->name('upload_image');

    Route::get('content/edit/{id}', 'ContentController@edit');
    Route::post('content/store', 'ContentController@store')->name('content.store');
    Route::post('content/update', 'ContentController@update')->name('content.update');
    Route::get('content/destroy/{id}', 'ContentController@destroy');
    Route::get('contentShow', 'ContentController@index')->name('content');
    Route::get('content-trashed', 'ContentController@index_trashed')->name('content-trashed');
    Route::get('content/show-trashed/{id}', 'ContentController@show_trashed');
    Route::get('restore-content/{id}', 'ContentController@restore_post');
    Route::get('force-content/{id}', 'ContentController@force');
    Route::get('/showContentID/{id}', 'ContentController@index_edit')->name('showContentID');

#################################################### Employees Categories
    Route::get('Category/edit/{id}', 'EmployeeCategory@edit');
    Route::post('Category/store', 'EmployeeCategory@store')->name('Emp_Category.store');
    Route::post('Category/update', 'EmployeeCategory@update')->name('Emp_Category.update');
    Route::get('Category/destroy/{id}', 'EmployeeCategory@destroy');
    Route::get('CategoryShow', 'EmployeeCategory@index')->name('Emp_Category');

    #################################################### emp_jobs
    Route::get('jobs/edit/{id}', 'JobsController@edit');
    Route::post('jobs/store', 'JobsController@store')->name('jobs.store');
    Route::post('jobs/update', 'JobsController@update')->name('jobs.update');
    Route::get('jobs/destroy/{id}', 'JobsController@destroy');
    Route::get('jobs', 'JobsController@index')->name('jobs');


    #### category_trainings
    Route::get('CategoryShowId/{id}', 'EmployeeCategory@index_edit')->name('CategoryShowId');
    Route::post('Category_training/store', 'EmployeeCategory@store_training')->name('Emp_Category_Training.store');
    Route::get('Category_training/destroy/{id}', 'EmployeeCategory@destroy_training');

    ##################################### Employees
    Route::get('EmployeeShowId/{id}', 'EmployeeController@index_id');
    Route::get('Employee/show/{id}', 'EmployeeController@show');
    Route::get('Employee/edit/{id}', 'EmployeeController@edit');
    Route::post('Employee/store', 'EmployeeController@store')->name('employee.store');
    Route::post('Employee/update', 'EmployeeController@update')->name('employee.update');
    Route::get('Employee/destroy/{id}', 'EmployeeController@destroy');
    Route::get('EmployeeShow/{id?}', 'EmployeeController@index')->name('employee');
    Route::get('Employee-trashed/{id?}', 'EmployeeController@index_trashed')->name('employee-trashed');
    Route::get('E_trashedShow/{id}', 'EmployeeController@index_trashed_id');
    Route::get('Employee/edit-trashed/{id}', 'EmployeeController@edit_trashed');
    Route::get('restore-Employee/{id}', 'EmployeeController@restore_post');
    Route::get('force-Employee/{id}', 'EmployeeController@force');
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
