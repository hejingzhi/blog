<?php

use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function(){


    Route::middleware(['jwt.check'])->group(function () { //jwt:auth、jwt.check、jwt.refresh、jwt.renew  有四种用法jwt自带的中间件    官方自带的auth:backend
        Route::post('me','TestController@me');
    });
    Route::post('login','TestController@login');
    Route::post('create','TestController@create');
});
