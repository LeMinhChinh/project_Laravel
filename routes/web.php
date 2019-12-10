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

Route::group([
    'namespace' => 'Services',
    'as' => 'service.'
], function () {
    Route::get('create-token','CreateTokenController@index')->name('createToken');
    Route::get('decode-token/{token}','CreateTokenController@decodeToken')->name('decodeToken');
});

require_once 'frontend.php';

Route::get('switch-lang/{lang?}',function($lang = null){
    App::setlocale($lang);
    Session::put('lang',$lang);
    LaravelLocalization::setLocale($lang);

    $url = LaravelLocalization::getLocalizedURL(App::getLocale(),\URL::previous());

    return Redirect::to($url);
})->name('switchLang');

/***************** FOR ADMIN *****************/
require_once 'admin.php';

/***************** END ADMIN *****************/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
