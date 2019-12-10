<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){
    Route::get('/login','LoginController@index')->name('login');
    Route::post('admin-login', 'LoginController@handleLogin')->name('handleLogin');
    Route::post('admin-logout', 'LoginController@handleLogout')->name('handleLogout');

});

Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['web', 'check.admin.login'],
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/posts','PostsController@index')->name('posts');
    Route::get('/create-post', 'PostsController@createPost')->name('createPost');
    Route::post('create-post', 'PostsController@handleCreatePost')->name('handleCreatePost');
    Route::post('/delete-post','PostsController@deletePost')->name('deletePost');
    Route::get('{slug}~{id}','PostsController@editPost')->name('editPost');
    Route::post('update-post/{id}','PostsController@handleUpdatePost')->name('handleUpdatePost');
    Route::get('/category','CategoriesController@index')->name('category');
    Route::get('/tag','TagsController@index')->name('tag');
    Route::get('/user','UsersController@index')->name('user');
});
