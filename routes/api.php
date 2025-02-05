<?php

use App\Http\Controllers\Api2\NotificationsController;
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
Route::post('info', 'Api\Users\UserController@info');
Route::post('login', 'Api\Users\UserController@login');
Route::post('forget_password', 'Api\Users\UserController@submitForgetPasswordForm');
Route::post('reset_password', 'Api\Users\UserController@submitResetPasswordForm');
Route::post('register', 'Api\Users\UserController@register');
Route::get('seller/{id}', 'Api\Seller\CategoreisController@get_seller_info');

######### employee login and register
Route::post('upload_image', 'Api\Shop\ZoneController@upload_image');
Route::post('get_district', 'Api\Shop\ZoneController@get_district');
Route::post('get_gov', 'Api\Shop\ZoneController@get_gov');
Route::post('shop/all_categories', 'Api\Shop\CategoreisController@all_categories');
Route::post('shop/seller_name', 'Api\Shop\CategoreisController@seller_name');
Route::post('shop/get_product_by_categories', 'Api\Shop\CategoreisController@get_product_by_categories');
Route::post('shop/get_product_by_categories22', 'Api\Shop\CategoreisController@get_product_by_categories22');
Route::post('shop/get_product_by_categories33', 'Api\Shop\CategoreisController@get_product_by_categories33');
Route::post('shop/get_category_products', 'Api\Shop\CategoreisController@get_category_products');
Route::post('shop/get_products_by_type', 'Api\Shop\CategoreisController@get_products_by_type');
Route::post('shop/product_details', 'Api\Shop\CategoreisController@product_details');
Route::post('shop/gov_seller', 'Api\Shop\CategoreisController@gov_seller');
Route::post('shop/gov_sellers', 'Api\Shop\CategoreisController@gov_sellers');
Route::post('emp-login', 'Api\Employees\EmployeeController@login');
Route::post('AllPosts', 'Api2\Consultants\ConsultantController@index');
//Route::post('AllPosts', 'Api2\Consultants\ConsultantController@index');

Route::post('actives', 'Api\Users\ActivatesController@index');
Route::post('slides', 'Api\Users\ActivatesController@slides');

Route::post('AllCategories', 'Api\Users\PostController@all_category');
Route::post('showTrainingByCategory', 'Api\Trainings\TrainingController@showTrainingByCategory');
Route::group(['prefix' => 'v2'], function () {

    Route::post('consultants', 'Api2\Consultants\ConsultantController@index');
    Route::get('forewordConsultantUsers', 'Api2\Consultants\ConsultantController@forewordConsultantUsers');
    Route::post('forewordToUsers', 'Api2\Consultants\ConsultantController@forewordToUsers');
});

Route::group(['prefix' => 'admin', 'middleware' => ['assign.guard:admins', 'jwt.auth']], function () {
    Route::get('/demo', 'AdminController@demo');
});


Route::group(['middleware' => 'CheckAdminT:api', 'prefix' => 'seller'], function () {


    Route::group(['prefix' => 'orders'], function () {
        Route::post('/', 'Api\Seller\OrdersController@index');
        Route::post('/detail', 'Api\Seller\OrdersController@show_seller_order');
        Route::post('/change_status', 'Api\Seller\OrdersController@change_sub_status');
        Route::post('/delivery_location', 'Api\Seller\OrdersController@new_delivery_location');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::post('/', 'Api\Seller\CategoreisController@get_products');
        Route::post('/add', 'Api\Seller\ProductsController@store');
        Route::post('/update', 'Api\Seller\ProductsController@update');
        Route::post('/delete', 'Api\Seller\ProductsController@destroy');
    });

    Route::group(['prefix' => 'product-images'], function () {
        Route::post('/add', 'Api\Seller\ProductImagesController@store');
        Route::post('/update', 'Api\Seller\ProductImagesController@update');
        Route::post('/delete', 'Api\Seller\ProductImagesController@destroy');
    });

    Route::post('/deleteQuestion', 'Api\Seller\ProductsController@deleteQuestion');
    Route::post('/addReplay', 'Api\Seller\ProductsController@addReplay');
    Route::post('/updateReplay', 'Api\Seller\ProductsController@updateReplay');
    Route::post('/deleteReplay', 'Api\Seller\ProductsController@deleteReplay');
});


Route::group(['middleware' => 'CheckUserT:api'], function () {
    Route::post('notification', [NotificationsController::class, 'notification']);

    Route::group(['prefix' => 'v2/forewordConsultants'], function () {

        Route::post('/index', 'Api2\Consultants\ForwordConsultantController@index');
        Route::post('/add_sovle', 'Api2\Consultants\ForwordConsultantController@update');
        Route::post('/store', 'Api2\Consultants\ForwordConsultantController@storeComment');
        Route::post('/delete/{id}', 'Api2\Consultants\ForwordConsultantController@deleteComment');
    });

    Route::post('seller/add_to_cart', 'Api\Shop\CartController@add_to_cart');

    Route::post('shop/add_to_cart', 'Api\Shop\CartController@add_to_cart');
    Route::post('shop/delete_from_cart', 'Api\Shop\CartController@delete_from_cart');
    Route::post('shop/update_cart', 'Api\Shop\CartController@update_cart');
    Route::post('shop/apply_coupon', 'Api\Shop\CartController@apply_coupon');
    Route::post('shop/delete_coupon', 'Api\Shop\CartController@delete_coupon');
    Route::post('shop/my_cart2', 'Api\Shop\CartController@my_cart2');
    Route::post('shop/my_cart', 'Api\Shop\CartController@my_cart');
    Route::post('shop/my_orders', 'Api\Shop\CartController@my_orders');
    Route::post('shop/add_payment', 'Api\Shop\CartController@add_payment');
    Route::post('shop/confirm_order', 'Api\Shop\CartController@confirm_order');
    Route::post('shop/cancel_order', 'Api\Shop\CartController@cancel_order');
    Route::post('shop/product_rate', 'Api\Shop\ProductsController@product_rate');
    Route::post('shop/product_rate2', 'Api\Shop\ProductsController@rate2');

    Route::post('shop/addQuestion', 'Api\Shop\ProductsController@addQuestion');
    Route::post('shop/updateQuestion', 'Api\Shop\ProductsController@updateQuestion');
    Route::post('shop/deleteQuestion', 'Api\Shop\ProductsController@deleteQuestion');
    Route::post('shop/addReplay', 'Api\Shop\ProductsController@addReplay');
    Route::post('shop/updateReplay', 'Api\Shop\ProductsController@updateReplay');
    Route::post('shop/deleteReplay', 'Api\Shop\ProductsController@deleteReplay');


######## user logout and details
    Route::post('logout', 'Api\Users\UserController@logout');
    Route::post('user', 'Api\Users\UserController@getAuthUser');
    Route::post('update_user', 'Api\Users\UserController@Update_User_Details');
    Route::post('update_profile', 'Api\Users\UserController@update_profile');
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
    Route::post('myPosts_pages', 'Api\Users\PostController@myPosts_pages');
    Route::post('ShPost/{id}', 'Api\Users\PostController@show');
    Route::post('StPost', 'Api\Users\PostController@store');
    Route::post('store_post', 'Api\Users\PostController@store_post');
    Route::post('UpPost/{id}', 'Api\Users\PostController@update');
    Route::post('update_post_web', 'Api\Users\PostController@update_post_web');
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
//    Route::post('getTrainingDetails', 'Api\Trainings\TrainingController@getTrainingDetails');
    Route::post('getTrainingQuestions', 'Api\Trainings\TrainingController@getTrainingQuestions');
    Route::post('set_result', 'Api\Trainings\TrainingController@set_result');
//    Route::post('showTrainingByCategory', 'Api\Trainings\TrainingController@showTrainingByCategory');
    Route::post('complete_content', 'Api\Trainings\TrainingController@complete_content');
    Route::post('like', 'Api\Trainings\TrainingController@like');
    Route::post('my_likes', 'Api\Trainings\TrainingController@my_likes');
    Route::post('my_likes_page', 'Api\Trainings\TrainingController@my_likes_page');
    Route::post('myTraining', 'Api\Trainings\TrainingController@myTraining');
    Route::post('training/rate', 'Api\Trainings\TrainingController@rate');
    Route::post('training/rate2', 'Api\Trainings\TrainingController@rate2');
    Route::post('training/delete_rate', 'Api\Trainings\TrainingController@delete_rate');
    Route::post('training/delete_rate2', 'Api\Trainings\TrainingController@delete_rate2');
    Route::post('register_to_training', 'Api\Trainings\TrainingController@register_to_training');


    Route::post('ShowTrainings_public', 'Api\Trainings\TrainingController@index_others');
    Route::post('ShowTrainingId/{id}', 'Api\Trainings\TrainingController@show');
    Route::post('StoreTraining', 'Api\Trainings\TrainingController@store');
    Route::post('UpdateTraining/{id}', 'Api\Trainings\TrainingController@update');
    Route::post('DeleteTraining/{id}', 'Api\Trainings\TrainingController@destroy');
});


######################################## women part
Route::post('ShowP', 'Api\Women\PostController@index');
Route::post('ShowPId/{id}', 'Api\Women\PostController@show');
Route::get('women_details/{id}', 'Api\Women\PostController@show');
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
Route::post('getTrainingQuestions2', 'Api\Trainings\TrainingController@getTrainingQuestions');
Route::post('getLastPosts', 'Api\Trainings\TrainingController@getLastPosts');
Route::post('search', 'Api\Trainings\TrainingController@search');
Route::post('getTrainingDetails', 'Api\Trainings\TrainingController@getTrainingDetails');
Route::post('concatUs', 'Api\Trainings\TrainingController@concatUs');


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
