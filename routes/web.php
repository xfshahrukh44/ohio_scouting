<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ADMIN PANEL ROUTES---------------------------------------
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    // DASHBOARD
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // BLADE INDEXES----------------------------------------------------------------
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/index_realtors', 'Admin\UserController@index_realtors')->name('index_realtors');
    Route::get('/index_cleaners', 'Admin\UserController@index_cleaners')->name('index_cleaners');
    // ----------------------------------------------------------------------------

    // API RESOURCES-------------------------------------------------
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['logo'=>'Admin\LogoController']);
    Route::apiResources(['setting'=>'Admin\SettingController']);
    Route::apiResources(['testimonial'=>'Admin\TestimonialController']);
    Route::apiResources(['cms_page'=>'Admin\CmsPageController']);
    Route::apiResources(['banner'=>'Admin\BannerController']);
    // --------------------------------------------------------------

    // SEARCH ROUTES--------------------------------------------------------------------------------------------
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_testimonials', 'Admin\TestimonialController@search_testimonials')->name('search_testimonials');
    Route::get('/search_cms_pages', 'Admin\TestimonialController@search_cms_pages')->name('search_cms_pages');
    Route::get('/search_banners', 'Admin\TestimonialController@search_banners')->name('search_banners');
    // ---------------------------------------------------------------------------------------------------------
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
