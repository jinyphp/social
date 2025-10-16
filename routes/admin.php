<?php
use Illuminate\Support\Facades\Route;

/**
 * 관리자 Social 라우트
 * 미들웨어: admin (관리자 전용)
 */

// OAuth 프로바이더 관리 (OAuthProviders)
Route::prefix('auth/oauth-providers')->middleware(['admin'])->name('admin.auth.oauth.providers.')->group(function () {
    Route::get('/', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\CreateController::class)->name('create');
    Route::post('/', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\DeleteController::class)->name('destroy');
});

// 소셜 계정 관리 (UserSocial)
Route::prefix('auth/user/social')->middleware(['admin'])->name('admin.auth.user.social.')->group(function () {
    Route::get('/', \Jiny\Auth\Social\Http\Controllers\UserSocial\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Auth\Social\Http\Controllers\UserSocial\CreateController::class)->name('create');
    Route::post('/', \Jiny\Auth\Social\Http\Controllers\UserSocial\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Auth\Social\Http\Controllers\UserSocial\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\DeleteController::class)->name('destroy');
});