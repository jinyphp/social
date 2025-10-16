<?php
use Illuminate\Support\Facades\Route;

/**
 * 소셜 API 라우트
 * JWT 토큰 인증
 */

Route::middleware(['jwt.auth'])->prefix('api/v1')->group(function () {
    // OAuth API
    Route::prefix('oauth')->name('api.oauth.')->group(function () {
        Route::post('/token', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@token')->name('token');
        Route::post('/refresh', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@refresh')->name('refresh');
        Route::post('/revoke', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@revoke')->name('revoke');
        Route::get('/user', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@user')->name('user');
    });
});