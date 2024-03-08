<?php

use App\Models\Setting;
use App\Http\Controllers\User\HomeController;
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


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')->prefix('admin')->namespace('Admin')->group(function () {


    // dashboard route
    Route::get('/', 'AdminDashboardController@index')->name('admin.home');
    Route::get('/visits-data', 'ChartController@getData')->can('view-chart-admin');
    Route::get('/reports-data', 'ChartController@getReport')->can('view-chart-admin');

    // section admin profile in admin panel
    Route::prefix('profile')->controller("ProfileController")->group(function () {
        Route::get('/{user:slug?}', 'index')->name('admin.profile.index');
        Route::get('/edit/{user}', 'edit')->name('admin.profile.edit');
        Route::put('/update/{user}', 'update')->name('admin.profile.update');
    });


    // Content Module

    // section content in admin panel
    Route::prefix('content')->namespace('Content')->group(function () {

        // section content and category side in admin panel
        Route::prefix('reports/category')->controller("CategoryController")->group(function () {
            Route::get('/', 'index')->name('admin.content.reports.category.index')->can('view-report-categories-list');
            Route::get('/create', 'create')->name('admin.content.reports.category.create')->can('create-report-category');
            Route::post('/store', 'store')->name('admin.content.reports.category.store')->can('create-report-category');
            Route::get('/edit/{reportCategory}', 'edit')->name('admin.content.reports.category.edit')->can('edit-report-category');
            Route::put('/update/{reportCategory}', 'update')->name('admin.content.reports.category.update')->can('edit-report-category');
            Route::delete('/destroy/{reportCategory}', 'destroy')->name('admin.content.reports.category.destroy')->can('delete-report-category');
            Route::get('/status/{reportCategory}', 'status')->name('admin.content.reports.category.status')->can('edit-report-category');
        });


        // section content and comment side in admin panel
        Route::prefix('comment')->controller("CommentController")->group(function () {
            Route::get('/', 'index')->name('admin.content.comment.index')->can('view-content-comments-list');
            Route::get('/show/{comment}', 'show')->name('admin.content.comment.show')->can('show-content-comment');
            Route::get('/status/{comment}', 'status')->name('admin.content.comment.status')->can('approved-content-comment');
            Route::get('/approved/{comment}', 'approved')->name('admin.content.comment.approved')->can('approved-content-comment');
        });


        // section content and guest comment side in admin panel
        Route::prefix('comment/guest')->controller("GuestCommentController")->group(function () {
            Route::get('/', 'index')->name('admin.content.guest-comment.index')->can('view-content-comments-list');
            Route::get('/show/{comment}', 'show')->name('admin.content.guest-comment.show')->can('show-content-comment');
            Route::get('/status/{comment}', 'status')->name('admin.content.guest-comment.status')->can('approved-content-comment');
            Route::get('/approved/{comment}', 'approved')->name('admin.content.guest-comment.approved')->can('approved-content-comment');
        });


        // section content and menu side in admin panel
        Route::prefix('menu')->controller("MenuController")->group(function () {
            Route::get('/', 'index')->name('admin.content.menu.index')->can('view-menus-list');
            Route::get('/create', 'create')->name('admin.content.menu.create')->can('create-menu');
            Route::post('/store', 'store')->name('admin.content.menu.store')->can('create-menu');
            Route::get('/edit/{menu}', 'edit')->name('admin.content.menu.edit')->can('edit-menu');
            Route::put('/update/{menu}', 'update')->name('admin.content.menu.update')->can('edit-menu');
            Route::delete('/destroy/{menu}', 'destroy')->name('admin.content.menu.destroy')->can('delete-menu');
            Route::get('/status/{menu}', 'status')->name('admin.content.menu.status')->can('edit-menu');
        });


        // section content and reports side in admin panel
        Route::prefix('reports')->controller("reportController")->group(function () {
            Route::get('/', 'index')->name('admin.content.reports.index')->can('view-reports-list');
            Route::get('/create', 'create')->name('admin.content.reports.create')->can('create-report');
            Route::post('/store', 'store')->name('admin.content.reports.store')->can('create-report');
            Route::post('/upload-images', 'uploadImagesCkeditor')->name('admin.content.reports.upload-images-ckeditor')->can('create-report')->can('edit-report');
            Route::get('/edit/{report}', 'edit')->name('admin.content.reports.edit')->can('edit-menu');
            Route::put('/update/{report}', 'update')->name('admin.content.reports.update')->can('edit-menu');
            Route::delete('/destroy/{report}', 'destroy')->name('admin.content.reports.destroy')->can('delete-report');
            Route::get('/status/{report}', 'status')->name('admin.content.reports.status')->can('edit-menu');
            Route::get('/commentable/{report}', 'commentable')->name('admin.content.reports.commentable')->can('edit-menu');
        });


        // section content and page side in admin panel
        Route::prefix('page')->controller("PageController")->group(function () {
            Route::get('/', 'index')->name('admin.content.page.index')->can('view-pages-list');
            Route::get('/create', 'create')->name('admin.content.page.create')->can('create-page');
            Route::post('/store', 'store')->name('admin.content.page.store')->can('create-page');
            Route::post('/upload-images', 'uploadImagesCkeditor')->name('admin.content.page.upload-images-ckeditor')->can('edit-page')->can('create-page');
            Route::get('/edit/{page}', 'edit')->name('admin.content.page.edit');
            Route::put('/update/{page}', 'update')->name('admin.content.page.update')->can('edit-page');
            Route::delete('/destroy/{page}', 'destroy')->name('admin.content.page.destroy')->can('delete-page');
            Route::get('/status/{page}', 'status')->name('admin.content.page.status')->can('edit-page');
        });


        // section content and banner side in admin panel
        Route::prefix('banner')->controller("BannerController")->group(function () {
            Route::get('/', 'index')->name('admin.content.banner.index')->can('view-banners-list');
            Route::get('/create', 'create')->name('admin.content.banner.create')->can('create-banner');
            Route::post('/store', 'store')->name('admin.content.banner.store')->can('create-banner');
            Route::get('/edit/{banner}', 'edit')->name('admin.content.banner.edit')->can('edit-banner');
            Route::put('/update/{banner}', 'update')->name('admin.content.banner.update')->can('edit-banner');
            Route::delete('/destroy/{banner}', 'destroy')->name('admin.content.banner.destroy')->can('delete-banner');
            Route::get('/status/{banner}', 'status')->name('admin.content.banner.status')->can('edit-banner');
        });
    });


    // User Module

    // section user in admin panel
    Route::prefix('user')->namespace('User')->group(function () {

        // section user and admin-user side in admin panel
        Route::prefix('admin-user')->controller("AdminUserController")->group(function () {
            Route::get('/', 'index')->name('admin.user.admin-user.index')->can('view-admins-list');
            Route::get('/create', 'create')->name('admin.user.admin-user.create')->can('create-admin');
            Route::post('/store', 'store')->name('admin.user.admin-user.store')->can('create-admin');
            Route::get('/edit/{admin}', 'edit')->name('admin.user.admin-user.edit')->can('edit-admin');
            Route::put('/update/{admin}', 'update')->name('admin.user.admin-user.update')->can('edit-admin');
            Route::delete('/destroy/{admin}', 'destroy')->name('admin.user.admin-user.destroy')->can('delete-admin');
            Route::get('/status/{admin}', 'status')->name('admin.user.admin-user.status')->can('edit-admin');
            Route::get('/activation/{admin}', 'activation')->name('admin.user.admin-user.activation')->can('edit-admin');
            Route::get('/roles/{admin}', 'roles')->name('admin.user.admin-user.roles')->can('edit-admin-role');
            Route::post('/roles/{admin}/store', 'rolesStore')->name('admin.user.admin-user.roles.store')->can('edit-admin-role');
            Route::get('/permissions/{admin}', 'permissions')->name('admin.user.admin-user.permissions')->can('edit-admin-permission');
            Route::post('/permissions/{admin}/store', 'permissionsStore')->name('admin.user.admin-user.permissions.store')->can('edit-admin-permission');
        });


        // section user and users side in admin panel
        Route::controller("UserController")->group(function () {
            Route::get('/', 'index')->name('admin.user.user.index')->can('view-users-list');
            Route::get('/create', 'create')->name('admin.user.user.create')->can('create-user');
            Route::post('/store', 'store')->name('admin.user.user.store')->can('create-user');
            Route::get('/edit/{user}', 'edit')->name('admin.user.user.edit')->can('edit-user');
            Route::put('/update/{user}', 'update')->name('admin.user.user.update')->can('edit-user');
            Route::delete('/destroy/{user}', 'destroy')->name('admin.user.user.destroy')->can('delete-user');
            Route::get('/status/{user}', 'status')->name('admin.user.user.status')->can('edit-user');
            Route::get('/activation/{user}', 'activation')->name('admin.user.user.activation')->can('edit-user');
        });


        // section user and role side in admin panel
        Route::prefix('role')->controller("RoleController")->group(function () {
            Route::get('/', 'index')->name('admin.user.role.index')->can('view-roles-list');
            Route::get('/create', 'create')->name('admin.user.role.create')->can('create-role');
            Route::post('/store', 'store')->name('admin.user.role.store')->can('create-role');
            Route::get('/edit/{role}', 'edit')->name('admin.user.role.edit')->can('edit-role');
            Route::put('/update/{role}', 'update')->name('admin.user.role.update')->can('edit-role');
            Route::delete('/destroy/{role}', 'destroy')->name('admin.user.role.destroy')->can('delete-role');
            Route::get('/status/{role}', 'status')->name('admin.user.role.status')->can('edit-role');
            Route::get('/permission-form/{role}', 'permissionForm')->name('admin.user.role.permission-form')->can('permission-role-sync');
            Route::put('/permission-upadte/{role}', 'permissionUpadte')->name('admin.user.role.permission-update')->can('permission-role-sync');
        });


        // section user and permission side in admin panel
        Route::prefix('permission')->controller("PermissionController")->group(function () {
            Route::get('/', 'index')->name('admin.user.permission.index')->can('view-permissions');
            Route::get('/create', 'create')->name('admin.user.permission.create')->can('create-permission');
            Route::post('/store', 'store')->name('admin.user.permission.store')->can('create-permission');
            Route::get('/edit/{permission}', 'edit')->name('admin.user.permission.edit')->can('view-products-category-list');
            Route::put('/update/{permission}', 'update')->name('admin.user.permission.update')->can('edit-permission');
            Route::delete('/destroy/{permission}', 'destroy')->name('admin.user.permission.destroy')->can('delete-permission');
            Route::get('/status/{permission}', 'status')->name('admin.user.permission.status')->can('edit-permission');
        });
    });

    // Setting Module

    // section setting in admin panel
    Route::prefix('setting')->controller("SettingController")->namespace('Setting')->group(function () {
        Route::get('/', 'index')->name('admin.setting.index')->can('view-settings-list');
        Route::get('/create', 'create')->name('admin.setting.create')->can('create-setting');
        Route::post('/store', 'store')->name('admin.setting.store')->can('create-setting');
        Route::get('/edit/{setting}', 'edit')->name('admin.setting.edit')->can('edit-setting');
        Route::put('/update/{setting}', 'update')->name('admin.setting.update')->can('edit-setting');
        Route::delete('/destroy/{setting}', 'destroy')->name('admin.setting.destroy')->can('delete-setting');
        Route::get('/status/{setting}', 'status')->name('admin.setting.status')->can('edit-setting');

        // section index of website and admin settings side in admin panel
        Route::get('/edit-index-page/{setting}', 'editIndexPage')->name('admin.setting.index-page.edit')->can('manage-index-page');
        Route::put('/update-index-page/{setting}', 'updateIndexPage')->name('admin.setting.index-page.update')->can('manage-index-page');

        // section province and admin settings side in admin panel
        Route::prefix('province')->controller("ProvinceController")->group(function () {
            Route::get('/', 'index')->name('admin.setting.province.index')->can('view-provinces-list');
            Route::get('/create', 'create')->name('admin.setting.province.create')->can('create-province');
            Route::post('/store', 'store')->name('admin.setting.province.store')->can('create-province');
            Route::get('/edit/{province}', 'edit')->name('admin.setting.province.edit')->can('edit-province');
            Route::put('/update/{province}', 'update')->name('admin.setting.province.update')->can('edit-province');
            Route::delete('/destroy/{province}', 'destroy')->name('admin.setting.province.destroy')->can('delete-province');
            Route::get('/status/{province}', 'status')->name('admin.setting.province.status')->can('edit-province');


            // section city and admin settings side in admin panel
            Route::controller("CityController")->group(function () {
                Route::get('/city/{province}', 'index')->name('admin.setting.city.index')->can('view-cities-list');
                Route::get('/city/create/{province}', 'create')->name('admin.setting.city.create')->can('create-city');
                Route::post('/city/store/{province}', 'store')->name('admin.setting.city.store')->can('create-city');
                Route::get('/city/edit/{province}/{city}', 'edit')->name('admin.setting.city.edit')->can('edit-city');
                Route::put('/city/update/{province}/{city}', 'update')->name('admin.setting.city.update')->can('edit-city');
                Route::delete('/city/destroy/{province}/{city}', 'destroy')->name('admin.setting.city.destroy')->can('delete-city');
                Route::get('/city/status/{city}', 'status')->name('admin.setting.city.status')->can('edit-city');
            });
        });
    });

    Route::post('/notification/read-all', 'NotificationController@readAll')->name('admin.notification.read-all');
});


/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware('web.visits')->namespace('user')->group(function () {

    Route::controller("HomeController")->group(function () {
        Route::get('/', 'index')->name('user.home');
    });

    Route::middleware('user.auth')->prefix('profile')->controller("ProfileController")->group(function () {
        Route::get('/', 'index')->name('user.profile.index');
        Route::get('/edit', 'edit')->name('user.profile.edit');
        Route::put('/update/{user}', 'update')->name('user.profile.update');
        Route::get('/my-comments', 'comments')->name('user.profile.comments');
        Route::get('/my-favorites', 'favorites')->name('user.profile.favorites');
    });

    Route::prefix('reports')->controller("ReportController")->group(function () {
        Route::get('/{reportCategory:slug?}', 'index')->name('user.reports.index');
        Route::get('/detail/{report:slug}', 'detail')->name('user.reports.detail');
        Route::post('/detail/comment/{report}', 'comment')->name('user.reports.detail.comment');
        Route::get('/add-to-favorite/{report:slug}', 'addToFavorite')->name('user.reports.add-to-favorite');
    });

    Route::prefix('page')->controller("PageController")->group(function () {
        Route::get('/{page:slug}', 'index')->name('user.pages');
    });
});



/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin/auth', 'namespace' => 'Auth\Admin'], function () {

    // admin login
    Route::controller("LoginController")->group(function () {
        Route::get('login', 'showLoginForm')->name('admin.auth.login.form');
        Route::post('login', 'login')->name('admin.auth.login');
        Route::get('logout', 'logout')->name('admin.auth.logout');
    });

    // admin email verification 
    Route::controller("VerificationController")->group(function () {
        Route::get('email/send-verification', 'send')->name('admin.auth.email.send.verification');
        Route::get('email/verify', 'verify')->name('admin.auth.email.verify');
    });

    // admin forget password
    Route::controller("ForgotPasswordController")->group(function () {
        Route::get('password/forget', 'showForgetForm')->name('admin.auth.password.forget.form');
        Route::post('password/forget', 'sendResetLink')->name('admin.auth.password.forget');
    });

    // admin account reset password
    Route::controller("ResetPasswordController")->group(function () {
        Route::get('password/reset', 'showResetForm')->name('admin.auth.password.reset.form');
        Route::post('password/reset', 'reset')->name('admin.auth.password.reset');
    });


    // admin login with social media (google)
    Route::controller("SocialController")->group(function () {
        Route::get('redirect/{provider}', 'redirectToProvider')->name('admin.auth.login.provider.redirect');
        Route::get('{provider}/callback', 'providerCallback')->name('admin.auth.login.provider.callback');
    });
});


/*
|--------------------------------------------------------------------------
| User Auth
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'web.visits', 'prefix' => 'auth', 'namespace' => 'Auth\User'], function () {

    // user login
    Route::controller("LoginRegesterController")->group(function () {
        Route::get('register', 'registerForm')->name('user.auth.register-form');
        Route::post('register', 'register')->name('user.auth.register');
        Route::get('login', 'login')->name('user.auth.login');
        Route::middleware('user.auth')->get('logout', 'logout')->name('user.auth.logout');
        Route::get('captcha', function () {
            return new \App\Http\Services\Captcha\Captcha();
        })->name('user.auth.register.captcha');
        Route::get('/get-cities/{province}', 'getCities')->name('user.auth.get-cities');
    });


    // user forget password
    Route::controller("ForgotPasswordController")->group(function () {
        Route::get('password/forget', 'showForgetForm')->name('user.auth.password.forget.form');
        Route::post('password/forget', 'sendResetLink')->name('user.auth.password.forget');
    });

    // user account reset password
    Route::controller("ResetPasswordController")->group(function () {
        Route::get('password/reset', 'showResetForm')->name('user.auth.password.reset.form');
        Route::post('password/reset', 'reset')->name('user.auth.password.reset');
    });
});
