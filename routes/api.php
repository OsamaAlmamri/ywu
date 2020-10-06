<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api', 'CheckPass']], function () {
    Route::post('all', 'Users\UserController@getallEmployee');
    Route::post('get_user_by_id', 'Users\UserController@getEmployeeById');
    Route::post('updateUserName', 'Users\UserController@updateUserName');

    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', 'AuthAdminController@login');
    });
});

Route::group(['middleware' => ['api', 'CheckPass', 'CheckAdminT:admin-api']], function () {
    Route::post('employees', 'Users\UserController@getallEmployee');
});


##################################################### Api Routes
######### user login and register
Route::post('login', 'Api\Users\UserController@login');
Route::post('register', 'Api\Users\UserController@register');

######### employee login and register
Route::post('emp-login', 'Api\Employees\EmployeeController@login');
Route::post('emp-register', 'Api\Employees\EmployeeController@register');
Route::post('shared-user-login', 'SharedUserController@login');
Route::post('shared-user-register', 'SharedUserController@register');
Route::post('AllPosts', 'Api\Users\PostController@index');
Route::post('actives', 'Api\Users\ActivatesController@index');
Route::post('slides', 'Api\Users\ActivatesController@slides');

Route::post('AllCategories', 'Api\Users\PostController@all_category');
Route::post('showTrainingByCategory', 'Api\Trainings\TrainingController@showTrainingByCategory');


Route::group(['middleware' => 'CheckAdminT:api'], function () {

######## user logout and details
    Route::post('logout', 'Api\Users\UserController@logout');
    Route::post('user', 'Api\Users\UserController@getAuthUser');
    Route::post('update_user', 'Api\Users\UserController@Update_User_Details');
    Route::post('reset_user', 'Api\Users\UserController@Reset_User_Password');
    Route::post('changePassword', 'Api\Users\UserController@changePassword');

######## employee logout and details
    Route::post('emp-logout', 'Api\Employees\EmployeeController@logout');
    Route::post('emp-user', 'Api\Employees\EmployeeController@getAuthUser');
    Route::post('update_emp', 'Api\Employees\EmployeeController@Update_Employee_Details');
    Route::post('reset_emp', 'Api\Employees\EmployeeController@Reset_Employee_Password');

######## SharedUser logout and details
    Route::post('sharedUser-logout', 'SharedUserController@logout');
    Route::post('sharedUser-user', 'SharedUserController@getAuthUser');
    Route::post('update_sharedUser', 'SharedUserController@Update_SharedUser_Details');
    Route::post('reset_sharedUser', 'SharedUserController@Reset_SharedUser_Password');

############## Posts Routes
    Route::post('MyPosts', 'Api\Users\PostController@myPosts');
    Route::post('ShPost/{id}', 'Api\Users\PostController@show');
    Route::post('StPost', 'Api\Users\PostController@store');
    Route::post('UpPost/{id}', 'Api\Users\PostController@update');
    Route::post('DePost/{id}', 'Api\Users\PostController@destroy');

############## user Comments
    Route::post('StComment', 'Api\Users\CommentController@store');
    Route::post('UpComment/{id}', 'Api\Users\CommentController@update');
    Route::post('DeComment/{id}', 'Api\Users\CommentController@destroy');

############## employee Comments
    Route::post('Replay', 'Api\Users\CommentController@replay');
    Route::post('UpReplay/{id}', 'Api\Users\CommentController@update_replay');
    Route::post('DeReplay/{id}', 'Api\Users\CommentController@destroy_replay');

######################################## trainings part
    Route::post('ShowTrainings', 'Api\Trainings\TrainingController@index');
    Route::post('getTrainingDetails', 'Api\Trainings\TrainingController@getTrainingDetails');
    Route::post('getTrainingQuestions', 'Api\Trainings\TrainingController@getTrainingQuestions');
//    Route::post('showTrainingByCategory', 'Api\Trainings\TrainingController@showTrainingByCategory');
    Route::post('complete_title', 'Api\Trainings\TrainingController@complete_title');
    Route::post('set_result', 'Api\Trainings\TrainingController@set_result');
    Route::post('like', 'Api\Trainings\TrainingController@like');
    Route::post('my_likes', 'Api\Trainings\TrainingController@my_likes');
    Route::post('myTraining', 'Api\Trainings\TrainingController@myTraining');

    Route::post('ShowTrainings_public', 'Api\Trainings\TrainingController@index_others');
    Route::post('ShowTrainingId/{id}', 'Api\Trainings\TrainingController@show');
    Route::post('StoreTraining', 'Api\Trainings\TrainingController@store');
    Route::post('UpdateTraining/{id}', 'Api\Trainings\TrainingController@update');
    Route::post('DeleteTraining/{id}', 'Api\Trainings\TrainingController@destroy');
});

######################################## women part
Route::post('ShowP', 'Api\Women\PostController@index');
Route::post('ShowPId/{id}', 'Api\Women\PostController@show');
Route::post('StorePost', 'Api\Women\PostController@store');
Route::post('UpdatePost/{id}', 'Api\Women\PostController@update');
Route::post('DeletePost/{id}', 'Api\Women\PostController@destroy');

######################################## subjects part
Route::post('ShowSubjects', 'Api\Trainings\SubjectController@index');
Route::post('ShowSubjectId/{id}', 'Api\Trainings\SubjectController@show');
Route::post('StoreSubject', 'Api\Trainings\SubjectController@store');
Route::post('UpdateSubject/{id}', 'Api\Trainings\SubjectController@update');
Route::post('DeleteSubject/{id}', 'Api\Trainings\SubjectController@destroy');

######################################## training titles part
Route::post('ShowTitles', 'Api\Trainings\TitleController@index');
Route::post('ShowTitleId/{id}', 'Api\Trainings\TitleController@show');
Route::post('StoreTitle', 'Api\Trainings\TitleController@store');
Route::post('UpdateTitle/{id}', 'Api\Trainings\TitleController@update');
Route::post('DeleteTitle/{id}', 'Api\Trainings\TitleController@destroy');

######################################## training title contents part
Route::post('ShowContents', 'Api\Trainings\ContentController@index');
Route::post('ShowContentId/{id}', 'Api\Trainings\ContentController@show');
Route::post('StoreContent', 'Api\Trainings\ContentController@store');
Route::post('UpdateContent/{id}', 'Api\Trainings\ContentController@update');
Route::post('DeleteContent/{id}', 'Api\Trainings\ContentController@destroy');

######################################## employee categories and trainings part
Route::post('ShowTrainingsCategory', 'EmpCateTrainingsController@index');
Route::post('ShowTrainings2', 'Api\Trainings\TrainingController@index2');

//Route::post('ShowContentId/{id}', 'Api\Trainings\ContentController@show');
//Route::post('StoreContent', 'Api\Trainings\ContentController@store');
//Route::post('UpdateContent/{id}', 'Api\Trainings\ContentController@update');
//Route::post('DeleteContent/{id}', 'Api\Trainings\ContentController@destroy');

######################################## exam part
//Route::post('ShowExams', 'ExamController@index');
//Route::post('ShowQuestions', 'ExamController@index_1');
//Route::post('ShowContentId/{id}', 'Api\Trainings\ContentController@show');
//Route::post('StoreContent', 'Api\Trainings\ContentController@store');
//Route::post('UpdateContent/{id}', 'Api\Trainings\ContentController@update');
//Route::post('DeleteContent/{id}', 'Api\Trainings\ContentController@destroy');
##################################################### End Routs
