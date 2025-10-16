<?php
use Illuminate\Support\Facades\Route;

/**
 * 소셜 인증 라우트
 * 게스트 및 사용자 모두 접근 가능
 */

// 소셜 로그인 라우트
Route::get('/auth/{provider}', \Jiny\Auth\Social\Http\Controllers\Social\LoginController::class)
    ->name('social.login')
    ->where('provider', 'google|facebook|twitter|github|linkedin|kakao|naver');

Route::get('/auth/{provider}/callback', \Jiny\Auth\Social\Http\Controllers\Social\CallbackController::class)
    ->name('social.callback')
    ->where('provider', 'google|facebook|twitter|github|linkedin|kakao|naver');