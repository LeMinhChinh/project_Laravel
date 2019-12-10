<?php
Route::group([
    'namespace' => 'Frontend',
    'as' => 'fr.',
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function () {
    Route::get('/','HomeController@index')->name('home');
    Route::get('{slug}','DetailController@index')->name('detailBlog');
    Route::POST('update-count-view','DetailController@updateCountView')->name('updateCountView');
    Route::get('/category/{slug}~{id}','CategoryController@listCate')->name('categories');
    Route::get('search/key','SeachController@index')->name('searchBlog');
    Route::get('ajaxSearch/ajax','SeachController@ajaxSearch')->name('ajaxSearch');
});
