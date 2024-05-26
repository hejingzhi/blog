<?php

use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function(){
    Route::get('test','TestController@index');
    //管理员模块
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::post('create',    [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'create'])->name('create');//添加
        Route::post('update',[\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'update'])->name('update');//编辑
        Route::post('delete', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'delete'])->name('delete');//删除
        Route::post('detail', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'detail'])->name('detail');//详情
        Route::post('list', [\App\Http\Controllers\Backend\V1\AdminConreoller::class, 'list'])->name('list');//列表
    });
});