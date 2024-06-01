<?php

use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function(){


    Route::middleware(['jwt.check'])->group(function () { //jwt:auth、jwt.check、jwt.refresh、jwt.renew  有四种用法jwt自带的中间件    官方自带的auth:backend
        Route::post('me','TestController@me');
    });
    Route::post('login','TestController@login');


    //管理员模块
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::post('create', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'create'])->name('create');
        Route::post('update',[\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'update'])->name('update');
        Route::post('delete', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'delete'])->name('delete');
        Route::post('detail', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'detail'])->name('detail');
        Route::post('list', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'list'])->name('list');
    });
    //通用配置模块
    Route::name('conf.')->prefix('conf')->group(function () {
        Route::post('create', [\App\Http\Controllers\Backend\V1\ConfController::class, 'create'])->name('create');
        Route::post('update',[\App\Http\Controllers\Backend\V1\ConfController::class, 'update'])->name('update');
        Route::post('delete', [\App\Http\Controllers\Backend\V1\ConfController::class, 'delete'])->name('delete');
        Route::post('detail', [\App\Http\Controllers\Backend\V1\ConfController::class, 'detail'])->name('detail');
        Route::post('list', [\App\Http\Controllers\Backend\V1\ConfController::class, 'list'])->name('list');
        Route::post('updateCache', [\App\Http\Controllers\Backend\V1\ConfController::class, 'updateCache'])->name('updateCache');
    });

});