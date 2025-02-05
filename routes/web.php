<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use  Illuminate\Support\Facades\Cookie;

;

Route::get('/migrate', 'ArtisanCommandsController@migrate');
Route::get('/test', 'ArtisanCommandsController@test');
Route::get('/role_seed', 'ArtisanCommandsController@role_seed');
Route::get('/clear', 'ArtisanCommandsController@clearCache');
Route::get('/optimize', 'ArtisanCommandsController@optimizeCache');
Route::get('/rout_cache', 'ArtisanCommandsController@routeCache');
Route::get('/clear_compiled', 'ArtisanCommandsController@clearCompiled');
Route::get('/storage_link', 'ArtisanCommandsController@storageLnk');
Route::get('lang/{lang}', function () {
    $lang = request('lang');

    session()->put('lang', $lang);
    session(['lang'=>$lang]);
    Cookie::queue(Cookie::forever('lang', "en"));

//    \Illuminate\Support\Facades\Session::put('lang',$lang);

//    app()->setLocale('en');
//    return dd()
    return back();
});
Route::group(['prefix' => 'admin/', 'namespace' => 'AdminControllers'], function () {
    Route::get('/login', 'AuthAdminController@Admin_login')->name('admin.login');
    Route::get('/forget', 'AuthAdminController@Admin_forget')->name('admin.forget');
    Route::post('/forget_check', 'AuthAdminController@Admin_forget_check')->name('admin.forget_check');
    Route::any('/check_login', 'AuthAdminController@adminLoginCheck')->name('login_admin');
});
Route::group(['middleware' => ('auth:admin')], function () {
    Route::post('notification/send', 'FireBaseController@sendNotification')->name('notification.send');

    Route::get('/admin/edit', 'HomeController@Update_Admin_Details')->name('Admin_Edit');
    Route::post('/admin/update', 'HomeController@Admin_update')->name('Admin_Update');
});
Route::group(['middleware' => ('auth:admin'), 'namespace' => 'AdminControllers'], function () {
    Route::get('/admin', 'AdminsController@Admin')->name('Admin');
    Route::get('/admin', 'AdminsController@Admin')->name('admin.home');
    Route::get('/admin_logout', 'AuthAdminController@LogoutAdmin')->name('Admin_logout');

    Route::group(['as' => 'admin.permissions.'], function () {
        Route::get('permissions/index/{section_id?}', 'PermissionsController@index')->name('index');
        Route::post('permissions/addNewRole', 'PermissionsController@addNewRole')->name('addNewRole');
        Route::get('permissions/{id}/delete', 'PermissionsController@delete')->name('delete');
        Route::resource('permissions', 'PermissionsController',
            [
                'names' => [
                    'edit' => 'edit',
                    'update' => 'update',
                    'store' => 'store',
                    // etc...
                ]
            ])->except('index');
    });

    Route::group(['prefix' => 'admin/shop/', 'middleware' => ('auth:admin'), 'namespace' => 'Shop'], function () {

        Route::group(['as' => 'admin.shop.sellers.'], function () {
            Route::get('sellers/index', 'SellersController@index')->name('index');
            Route::get('sellers/showImages/{id}', 'SellersController@showImages')->name('showImages');
            Route::post('sellers/active', 'SellersController@active')->name('active');
            Route::get('sellers/destroy/{id}', 'SellersController@destroy')->name('destroy');

        });

        Route::get('sellers/index/{id}', 'SellersController@destroy')->name('admin.shop.orders.showNotification');

        Route::group(['as' => 'admin.shop.categories.'], function () {
            Route::post('categories/update', 'CategoriesController@update')->name('update');
            Route::get('categories/destroy/{id}', 'CategoriesController@destroy')->name('destroy');
            Route::get('categories/edit/{id}', 'CategoriesController@edit')->name('edit');
            Route::post('categories/changeOrder', 'CategoriesController@changeOrder')->name('changeOrder');
            Route::post('categories/active', 'CategoriesController@active')->name('active');
            Route::post('categories/changeType', 'CategoriesController@changeType')->name('changeType');
            Route::resource('categories', 'CategoriesController', [
                'names' => [
                    'index' => 'index',
                    'store' => 'store',
                    // etc...
                ]
            ])->except('update');
        });
        Route::group(['as' => 'admin.shop.coupons.'], function () {
            Route::post('coupons/update', 'CouponsController@update')->name('update');
            Route::post('coupons/update_selected', 'CouponsController@update_selected')->name('update_selected');
            Route::post('coupons/delete_selected', 'CouponsController@delete_selected')->name('delete_selected');
            Route::post('coupons/store', 'CouponsController@store')->name('store');
            Route::get('coupons/destroy/{id}', 'CouponsController@destroy')->name('destroy');
            Route::get('coupons/index/{year?}', 'CouponsController@index')->name('index');
            Route::get('coupons/statistics/{year?}', 'CouponsController@statistics')->name('statistics');
            Route::get('coupons/sta/{year?}', 'CouponsController@sta')->name('sta');
        });
#################################################### sliders
        Route::group(['as' => 'admin.shop.spaces.'], function () {
            Route::post('spaces/update', 'SpacesController@update')->name('update');
            Route::get('spaces/destroy/{id}', 'SpacesController@destroy')->name('destroy');
            Route::get('spaces/show/{id}', 'SpacesController@show')->name('show');
            Route::get('spaces/edit/{id}', 'SpacesController@edit')->name('edit');
            Route::post('spaces/active', 'SpacesController@active')->name('active');
            Route::resource('spaces', 'SpacesController', [
                'names' => [
                    'index' => 'index',
                    'store' => 'store',
                ]
            ])->except('update');
        });
#################################################### sliders
        Route::group(['as' => 'admin.shop.products_options.'], function () {
            Route::post('products_options_values/update', 'ProductsOptionsController@update_options_values')->name('update_options_values');
            Route::post('products_options_values/store', 'ProductsOptionsController@store_options_values')->name('store_options_values');

            Route::post('products_options/update', 'ProductsOptionsController@update')->name('update');
            Route::get('products_options/destroy/{id}/{type}', 'ProductsOptionsController@destroy')->name('destroy');
            Route::get('products_options/edit/{id}', 'ProductsOptionsController@edit')->name('edit');
            Route::post('products_options/active', 'ProductsOptionsController@active')->name('active');
            Route::resource('products_options', 'ProductsOptionsController', [
                'names' => [
                    'index' => 'index',
                    'store' => 'store',
                ]
            ])->except('update');
        });
        Route::group(['prefix' => 'products/', 'as' => 'admin.shop.products.ratings.'], function () {
            Route::get('ratings/{id}', 'ProductRatingsController@index')->name('index');
        });
        Route::group(['as' => 'admin.shop.products.'], function () {
            Route::post('products/update', 'ProductsController@update')->name('update');
            Route::get('products/destroy/{id}', 'ProductsController@destroy')->name('destroy');
            Route::get('products/show/{id}', 'ProductsController@show')->name('show');
            Route::get('products/edit/{id}', 'ProductsController@edit')->name('edit');
            Route::get('products/attributes/{id}', 'ProductsController@attributes')->name('attributes');
            Route::post('products/active', 'ProductsController@active')->name('active');
            Route::post('products/changeOrder', 'ProductsController@changeOrder')->name('changeOrder');
            Route::resource('products', 'ProductsController', [
                'names' => [
                    'index' => 'index',
                    'store' => 'store',
                ]
            ])->except('update');
        });
        Route::group(['as' => 'admin.shop.products.images.'], function () {
            Route::post('products/images/update', 'ProductImagesController@update')->name('update');
            Route::get('products/images/destroy/{id}', 'ProductImagesController@destroy')->name('destroy');
            Route::get('products/images/index/{id}', 'ProductImagesController@index')->name('index');
            Route::get('products/images/edit/{id}', 'ProductImagesController@edit')->name('edit');
            Route::post('products/images/changeOrder', 'ProductImagesController@changeOrder')->name('changeOrder');
            Route::post('products/images/store', 'ProductImagesController@store')->name('store');

        });
        #################################################### media
        Route::group(['prefix' => 'media', 'as' => 'admin.shop.media.'], function () {
            Route::get('display', 'MediaController@display');
            Route::get('add', 'MediaController@add');
            Route::post('updatemediasetting', 'MediaController@updatemediasetting');
            Route::post('uploadimage', 'MediaController@fileUpload');
            Route::post('delete', 'MediaController@deleteimage');
            Route::get('detail/{id}', 'MediaController@detailimage');
            Route::get('refresh', 'MediaController@refresh');
            Route::post('regenerateimage', 'MediaController@regenerateimage');
        });
        Route::group(['prefix' => 'product_questions', 'as' => 'admin.shop.product_questions.'], function () {
            Route::get('/index', 'ProductQuestionController@index')->name('index');
            Route::get('/destroy/{id}', 'ProductQuestionController@destroy')->name('destroy');
            Route::post('/active', 'ProductQuestionController@active')->name('active');
            Route::post('/changeOrder', 'ProductQuestionController@changeOrder')->name('changeOrder');
            Route::get('/show_replies/{id}', 'ProductQuestionController@show_replies')->name('show_replies');
            Route::post('/replay', 'ProductQuestionController@replay_product_questions')->name('replay');
            Route::post('/delete_replay', 'ProductQuestionController@delete_replay')->name('delete_replay');
            Route::get('/edit/{id}/{status}', 'ProductQuestionController@edit_product_questions')->name('edit_product_questions');
        });

        Route::group(['prefix' => 'orders', 'as' => 'admin.shop.orders.'], function () {
            Route::get('/index/{type?}', 'OrdersController@index')->name('index');
            Route::get('/destroy/{id}', 'OrdersController@destroy')->name('destroy');
            Route::any('/show_seller_order/{id}', 'OrdersController@show_seller_order')->name('show_seller_order');
            Route::get('/show_main_order/{id}', 'OrdersController@show_main_order')->name('show_main_order');
            Route::post('/active', 'OrdersController@active')->name('active');
            Route::post('/change_sub_status', 'OrdersController@change_sub_status')->name('change_sub_status');
            Route::post('/change_sub_status_payment', 'OrdersController@change_sub_status_payment')->name('change_sub_status_payment');
            Route::post('/new_delivery_location', 'OrdersController@new_delivery_location')->name('new_delivery_location');
        });

        Route::group(['prefix' => 'payment', 'as' => 'admin.shop.payments.'], function () {
            Route::get('/index/{type?}', 'PaymentController@index')->name('index');
            Route::post('/change_status', 'PaymentController@change_status')->name('change_status');
        });
        Route::group(['prefix' => 'contacts', 'as' => 'admin.shop.contacts.'], function () {
            Route::get('/index', 'ContactController@index')->name('index');
            Route::get('/destroy/{id}', 'ContactController@destroy')->name('destroy');
        });

    });
    Route::group(['middleware' => ('auth:admin'), 'namespace' => 'Training'], function () {
        Route::get('user/destroy/{id}', 'UserController@destroy');
        Route::get('userShow/{id?}', 'UserController@index')->name('user');
        Route::post('users/update', 'UserController@update')->name('users.update');
        Route::get('userShowId/{id}', 'UserController@index');
        Route::get('user-trashed', 'UserController@index_trashed')->name('user-trashed');
        Route::get('trashedShow/{id}', 'UserController@index_trashed');
        Route::get('user/edit-trashed/{id}', 'UserController@edit_trashed');
        Route::get('restore-user/{id}', 'UserController@restore_post');
        Route::get('force-user/{id}', 'UserController@force');

####################### ajax الاستشارات
        Route::get('admin/home', 'DashboardController@index')->name('home');
        Route::delete('delete-multiple-category', ['as' => 'post.multiple-delete', 'uses' => 'DashboardController@deleteMultiple']);
        Route::post('update-multiple-category', ['as' => 'post.multiple-update', 'uses' => 'DashboardController@update_multi']);
        Route::delete('force-multiple-category', ['as' => 'post.multiple-force', 'uses' => 'DashboardController@forceMultiple']);
        Route::post('restore-multiple-category', ['as' => 'post.multiple-restore', 'uses' => 'DashboardController@restoreMultiple']);
        Route::post('showPost', 'DashboardController@fetch')->name('fetch');
        Route::get('editConsultant/{id}', 'DashboardController@editConsultant')->name('editPost');
        Route::post('rePublish', 'DashboardController@rePublish')->name('rePublish');
        Route::post('updatePost', 'DashboardController@update')->name('update');
        Route::post('deletePost', 'DashboardController@destroy')->name('delete');
        Route::get('deletedPost', 'DashboardController@deletedPost')->name('deleted_Post');
        Route::post('restorePost', 'DashboardController@restore')->name('restore');
        Route::post('forcePost', 'DashboardController@force')->name('force');
        Route::get('showPost', 'DashboardController@show')->name('showPosts');
        Route::get('showForworConsultant/{id}', 'DashboardController@showForworConsultant')->name('showForworConsultant');
        Route::post('deleteComment', 'DashboardController@comment_D')->name('delete_comment');


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
//        Route::get('subject/edit/{id}', 'SubjectController@edit');
//        Route::post('subject/store', 'SubjectController@store')->name('subject.store');
//        Route::post('subject/update', 'SubjectController@update')->name('subject.update');
//        Route::get('subject/destroy/{id}', 'SubjectController@destroy');
//        Route::get('subjectShow', 'SubjectController@index')->name('subject');
//        Route::get('subject-trashed', 'SubjectController@index_trashed')->name('subject-trashed');
//        Route::get('subject/edit-trashed/{id}', 'SubjectController@edit_trashed');
//        Route::get('restore-subject/{id}', 'SubjectController@restore_post');
//        Route::get('force-subject/{id}', 'SubjectController@force');

#################################################### Subjects
        Route::get('subject/edit/{id}', 'SubjectCategoriesController@edit');
        Route::post('subject/store', 'SubjectCategoriesController@store')->name('subject.store');
        Route::post('subject/update', 'SubjectCategoriesController@update')->name('subject.update');
        Route::get('subject/destroy/{id}', 'SubjectCategoriesController@destroy');
        Route::get('subjectShow', 'SubjectCategoriesController@index')->name('subject');
        Route::get('subject-trashed', 'SubjectCategoriesController@index_trashed')->name('subject-trashed');
        Route::get('subject/edit-trashed/{id}', 'SubjectCategoriesController@edit_trashed');
        Route::get('restore-subject/{id}', 'SubjectCategoriesController@restore_post');
        Route::get('force-subject/{id}', 'SubjectCategoriesController@force');

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
        Route::post('training/active', 'TrainingController@active')->name('training.active');

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
        Route::get('/user_trainings/{id?}', 'UserTrainingController@index')->name('user_trainings');
        Route::get('user_trainings/destroy/{id}/{action_type}', 'UserTrainingController@destroy');

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
        Route::post('slides/changeType', 'SlideController@changeType')->name('slides.changeType');
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
    Route::group(['middleware' => ('auth:admin'), 'namespace' => 'Shop', 'prefix' => 'admin/products/attach/attribute'], function () {
        Route::get('/display/{id}', 'ProductsController@attributes');
        Route::group(['prefix' => '/default'], function () {
            Route::post('/', 'ProductsController@addnewdefaultattribute');
            Route::post('/edit', 'ProductsController@editdefaultattribute');
            Route::post('/update', 'ProductsController@updatedefaultattribute');
            Route::post('/deletedefaultattributemodal', 'ProductsController@deletedefaultattributemodal');
            Route::post('/delete', 'ProductsController@deletedefaultattribute');
            Route::group(['prefix' => '/options'], function () {
                Route::post('/add', 'ProductsController@showoptions');
                Route::post('/edit', 'ProductsController@editoptionform');
                Route::post('/update', 'ProductsController@updateoption');
                Route::post('/showdeletemodal', 'ProductsController@showdeletemodal');
                Route::post('/delete', 'ProductsController@deleteoption');
                Route::post('/getOptionsValue', 'ProductsController@getOptionsValue');
                Route::post('/currentstock', 'ProductsController@currentstock');

            });

        });

    });
    Route::group(['prefix' => 'admin/', 'as' => 'admin.admins.'], function () {
        Route::post('admins/update', 'AdminsController@update')->name('update');
        Route::get('admins/destroy/{id}', 'AdminsController@destroy')->name('destroy');
        Route::get('admins/edit/{id}', 'AdminsController@edit')->name('edit');
        Route::post('admins/active', 'AdminsController@active')->name('active');
        Route::resource('admins', 'AdminsController', [
            'names' => [
                'index' => 'index',
                'store' => 'store',
            ]
        ])->except('update');
    });


});

//Auth::routes();
///////////////////////////
///
Route::get('/', 'HomeController@index');
//Route::get('/login', 'HomeController@index');
//Route::get('/home', 'HomeController@index')->name('site.home');
//Route::get('/training', 'HomeController@index')->name('site.training');
//Route::get('/courses/{type?}', 'HomeController@index')->name('site.courses');
//Route::get('/consultant', 'HomeController@index')->name('site.consultant');
//Route::get('/shop/seller/{id}', 'HomeController@index');
//Route::get('/women', 'HomeController@index')->name('site.women');
//Route::get('/privacy', 'HomeController@index')->name('site.privacy');
//Route::get('/concatUs', 'HomeController@index')->name('site.concatUs');
//Route::get('/about', 'HomeController@index')->name('site.about');
//Route::get('/course_details/{id?}', 'HomeController@index')->name('site.course_detail');
//Route::get('/womwn_details/{id?}', 'HomeController@index')->name('site.womwn_details');
//Route::get('/product_details/{id?}', 'HomeController@index')->name('site.product_details');
//Route::get('/myProfile', 'HomeController@index')->name('site.myProfile');
//Route::get('/site_login', 'HomeController@login')->name('site.login');
////Route::get('/login', 'HomeController@register')->name('site.login');
//Route::post('zones/getZones', 'HomeController@getZones')->name('zones.getZones');

Route::get('/reset_password/{token}', 'HomeController@register')->name('reset.password.get');

Route::get('download_app', function () {
    $id = setting('app_link');
    $headers = [
        'Content-Type:' => 'application/apk',
    ];;
    $path = 'YemenWE.apk';
    $pathToFile = public_path($path);
//        $file_name = ($file_name = $ass->originalName);
    return response()->download($pathToFile, Str::ascii($id, 'en'), $headers);


})->name('download_app');

Route::get('/{any?}', 'HomeController@index')->where('any', '^(?!api\/)[\/\w\.-]*');

