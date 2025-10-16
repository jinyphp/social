<?php
use Illuminate\Support\Facades\Route;

/**
 * 사용자 계정 관리 - 소셜 라우트
 * 미들웨어: auth (로그인 사용자 전용)
 */

Route::middleware(['auth'])->prefix('home/account')->name('home.account.')->group(function () {
    // 소셜 프로필 관리
    Route::get('/social', \Jiny\Auth\Social\Http\Controllers\Home\Social\IndexController::class)
        ->name('social');
    Route::post('/social', \Jiny\Auth\Social\Http\Controllers\Home\Social\UpdateController::class)
        ->name('social.update');
});