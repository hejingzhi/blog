<?php

use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function(){
    Route::get('test','TestController@index');
    //管理员模块
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::post('create',    [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'create'])->name('create');//添加
    });
});