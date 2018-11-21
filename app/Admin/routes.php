<?php

Admin::registerAdminRoutes();


Route::group([
    'namespace' => 'App\Admin\Controllers',
    'prefix' => 'admin',
    'middleware' => ['web', 'admin'],
    'as' => 'admin::'
], function () {
    Route::get('/scrapy','ScrapyController@index')->name('scrapy.index');
    Route::get('/scrapy/time','ScrapyController@scrapytime')->name('scrapy.time');
    Route::post('/scrapy/store','ScrapyController@store')->name('scrapy.store');
    Route::get('/', 'HomeController@index')->name('main');
    Route::post('/upload/image', 'UploadController@image')->name('upload.image');

    Route::group([
        'middleware' => ['admin.check_permission']
    ],function(){
        //听漳州
        Route::group([
            'namespace' =>'Hear'
        ],function(){
            //节目管理
             Route::resource('programs','ProgramController');


             //栏目管理
            Route::resource('categorys','CategoryController');

            //轮播图管理
            Route::resource('carousels','CarouselController');
        });
        //数据统计
        Route::group([
            'namespace' =>'Math'
        ],function(){
            //会员管理
            Route::resource('members','MemberController');


        });
        Route::group([
            'namespace' => 'Compre'
        ],function(){
            //公众号管理
            Route::resource('offaccounts','OffaccountController');

            //意见反馈
            Route::resource('feedbacks','FeedbackController');

            //关于我们
            Route::resource('about','AboutController');
        });
    });
});