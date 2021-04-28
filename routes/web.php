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
    Route::apiResources(['brand'=>'Admin\BrandController']);
    Route::apiResources(['listing'=>'Admin\ListingController']);
    Route::apiResources(['listing_image'=>'Admin\ListingImageController']);
    // --------------------------------------------------------------

    // SEARCH ROUTES--------------------------------------------------------------------------------------------
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_testimonials', 'Admin\TestimonialController@search_testimonials')->name('search_testimonials');
    Route::get('/search_cms_pages', 'Admin\CmsPageController@search_cms_pages')->name('search_cms_pages');
    Route::get('/search_banners', 'Admin\BannerController@search_banners')->name('search_banners');
    Route::get('/search_brands', 'Admin\BrandController@search_brands')->name('search_brands');
    Route::get('/search_listings', 'Admin\ListingController@search_listings')->name('search_listings');
    // ---------------------------------------------------------------------------------------------------------

    // HELPERS---------------------------------------------------------------------------------------------------------------
    Route::get('/toggle_cms_page_status', 'Admin\CmsPageController@toggle_cms_page_status')->name('toggle_cms_page_status');
    Route::get('/toggle_banner_status', 'Admin\BannerController@toggle_banner_status')->name('toggle_banner_status');
    Route::get('/toggle_testimonial_status', 'Admin\TestimonialController@toggle_testimonial_status')->name('toggle_testimonial_status');
    // ----------------------------------------------------------------------------------------------------------------------
});

// ARTISAN COMMAND ROUTES---------------------------------------
Route::get('/install', function () {
    // Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
    //     '--seed' => true
    // ]);
});
// Admin Seeder
Route::get('/admin_seed', function () {
    Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'AdminSeeder'
    ]);
});
Route::get('/migrate', function () {
    Illuminate\Support\Facades\Artisan::call('migrate');
});
Route::get('/stepmigrate', function () {
    Illuminate\Support\Facades\Artisan::call('migrate:rollback', [
        '--step' => 1
    ]);
});
Route::get('/clear', function () {
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('config:clear');
    Illuminate\Support\Facades\Artisan::call('config:cache');
    Illuminate\Support\Facades\Artisan::call('view:clear');
});
Route::get('/passport', function () {
    Illuminate\Support\Facades\Artisan::call('passport:install');
});
Route::get('/key', function () {
    Illuminate\Support\Facades\Artisan::call('key:generate');
});
Route::get('/storage', function () {
    Illuminate\Support\Facades\Artisan::call('storage:link');
});
Route::get('/composer-du', function()
{
    Illuminate\Support\Facades\Artisan::call('dump-autoload');
});
//--------------------------------------------------------------

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
