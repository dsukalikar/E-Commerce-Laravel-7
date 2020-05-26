<?php
Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');

        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');

        Route::resource('categories', 'Admin\CategoryController');
        Route::resource('attributes', 'Admin\AttributeController');
        Route::resource('brands', 'Admin\BrandController');
        Route::resource('products', 'Admin\ProductController');

        Route::group(['prefix' => 'attributes'], function () {
            Route::post('/get-values', 'Admin\AttributeValueController@getValues');
            Route::post('/add-values', 'Admin\AttributeValueController@addValues');
            Route::post('/update-values', 'Admin\AttributeValueController@updateValues');
            Route::post('/delete-values', 'Admin\AttributeValueController@deleteValues');
        });

        Route::group(['prefix' => 'products'], function () {
 
            Route::post('images/upload', 'Admin\ProductImageController@upload')->name('admin.products.images.upload');
            Route::get('images/{id}/delete', 'Admin\ProductImageController@delete')->name('admin.products.images.delete');
 
            Route::get('attributes/load', 'Admin\ProductAttributeController@loadAttributes');
            Route::post('attributes', 'Admin\ProductAttributeController@productAttributes');
            Route::post('attributes/values', 'Admin\ProductAttributeController@loadValues');
            Route::post('attributes/add', 'Admin\ProductAttributeController@addAttribute');
            Route::post('attributes/delete', 'Admin\ProductAttributeController@deleteAttribute');
 
         });

         Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'Admin\OrderController@index')->name('admin.orders.index');
            Route::get('/{order}/show', 'Admin\OrderController@show')->name('admin.orders.show');
         });

    });

});
