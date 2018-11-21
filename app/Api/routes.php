<?php
//栏目下的新闻列表
Route::get('api/scrapys/{type}','App\Admin\Controllers\ScrapyController@scrapys');

//获取新闻详情
Route::get('api/scrapy/{id}','App\Admin\Controllers\ScrapyController@show');

//获取新闻轮播图
Route::get('api/banners','App\Admin\Controllers\ScrapyController@banners');

//获取新闻首页封面图
Route::get('api/banner','App\Admin\Controllers\ScrapyController@banner');

Route::group([
    'namespace' => 'App\Api\Controllers',
    'middleware' => ['api']
], function () {
    /// 认证
    Route::post('/auth/login', 'AuthController@login');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::post('/auth/refresh', 'AuthController@refresh');
    Route::group([
        'namespace' =>'Hear'
    ],function(){
        //听漳州轮播图api
        Route::get('api/carousels','HearController@carousels');

        //听漳州栏目列表
        Route::get('api/categorys','HearController@categorys');

        //栏目详情
        Route::get('api/categorys/{category}','HearController@category');

        //某个栏目下的所有节目
        Route::get('api/programs/{id}','HearController@programs');


        //节目增加播放量
        Route::post('api/programs/addpayvolume/{program}','HearController@addpayvolume');


    });
    Route::group([
        'namespace'=> 'About'
    ],function(){
        //关于我们的api
        Route::get('api/about','AboutController@show');
    });
    Route::group([
        'namespace'=>'Offaccount'
    ],function(){
        //关联公众号列表
        Route::get('api/offaccounts','OffaccountController@offaccounts');

        //关联公众号详情
        Route::get('api/offaccounts/{offaccount}','OffaccountController@offaccount');

    });

    Route::group([
        'namespace'=>'Feedback',
        'middleware' => ['auth:api']
       
    ],function(){
        //意见反馈api
        Route::post('api/feedback','FeedbackController@store');
    });

    Route::group([
        'namespace' =>'Subscription',
        'middleware' => ['auth:api']
    ],function(){
        //用户订阅
        Route::post('api/subscription','SubscriptionController@store');
        //用户取消订阅
        Route::delete('api/subscription/{category}','SubscriptionController@destroy');

        //用户订阅列表
        Route::get('api/subscriptions','SubscriptionController@show');
    });

    Route::group([
        'namespace'=>'Collection',
        'middleware' => ['auth:api']
    ],function(){
        //用户收藏
        Route::post('api/collection','CollectionController@store');
    });

    Route::group([
        'namespace'=>'Member',
        'middleware' => ['auth:api']
    ],function(){
        //修改用户信息
        Route::post('api/member','MemberController@store');

    });




});