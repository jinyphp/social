<?php
use Illuminate\Support\Facades\Route;

/**
 * Jiny Social Authentication - Admin Routes
 *
 * 소셜 로그인 기능의 관리자 페이지 라우트들을 정의합니다.
 * OAuth 제공자 설정과 사용자 소셜 계정을 관리할 수 있습니다.
 *
 * 접근 권한: admin 미들웨어 (관리자 전용)
 * 기본 URL: /admin/auth/...
 *
 * 관리 기능:
 * 1. OAuth 제공자 설정 관리
 *    - Google, Facebook, GitHub 등의 OAuth 설정
 *    - 클라이언트 ID, 시크릿, 콜백 URL 등 관리
 *
 * 2. 사용자 소셜 계정 관리
 *    - 사용자별 연동된 소셜 계정 조회/관리
 *    - 소셜 프로필 정보 관리
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 */

/**
 * OAuth 제공자 관리 라우트 그룹
 *
 * Google, Facebook, GitHub 등의 OAuth 제공자 설정을 관리합니다.
 * 각 제공자별로 클라이언트 ID, 시크릿, 활성화 여부 등을 설정할 수 있습니다.
 *
 * URL 패턴: /admin/auth/oauth-providers/*
 * 라우트 이름: admin.auth.oauth.providers.*
 */
Route::prefix('auth/oauth-providers')->middleware(['admin'])->name('admin.auth.oauth.providers.')->group(function () {
    // OAuth 제공자 목록 조회
    Route::get('/', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\IndexController::class)->name('index');

    // 새 OAuth 제공자 추가 폼
    Route::get('/create', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\CreateController::class)->name('create');

    // OAuth 제공자 생성 처리
    Route::post('/', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\StoreController::class)->name('store');

    // 특정 OAuth 제공자 상세 조회
    Route::get('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\ShowController::class)->name('show');

    // OAuth 제공자 수정 폼
    Route::get('/{id}/edit', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\EditController::class)->name('edit');

    // OAuth 제공자 정보 업데이트
    Route::put('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\UpdateController::class)->name('update');

    // OAuth 제공자 삭제
    Route::delete('/{id}', \Jiny\Auth\Social\Http\Controllers\OAuthProviders\DeleteController::class)->name('destroy');
});

/**
 * 사용자 소셜 계정 관리 라우트 그룹
 *
 * 사용자들이 연동한 소셜 계정들을 관리합니다.
 * 각 사용자의 소셜 프로필 정보와 연동 상태를 조회하고 관리할 수 있습니다.
 *
 * URL 패턴: /admin/auth/user/social/*
 * 라우트 이름: admin.auth.user.social.*
 */
Route::prefix('auth/user/social')->middleware(['admin'])->name('admin.auth.user.social.')->group(function () {
    // 사용자 소셜 계정 목록 조회
    Route::get('/', \Jiny\Auth\Social\Http\Controllers\UserSocial\IndexController::class)->name('index');

    // 새 사용자 소셜 계정 추가 폼
    Route::get('/create', \Jiny\Auth\Social\Http\Controllers\UserSocial\CreateController::class)->name('create');

    // 사용자 소셜 계정 생성 처리
    Route::post('/', \Jiny\Auth\Social\Http\Controllers\UserSocial\StoreController::class)->name('store');

    // 특정 사용자 소셜 계정 상세 조회
    Route::get('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\ShowController::class)->name('show');

    // 사용자 소셜 계정 수정 폼
    Route::get('/{id}/edit', \Jiny\Auth\Social\Http\Controllers\UserSocial\EditController::class)->name('edit');

    // 사용자 소셜 계정 정보 업데이트
    Route::put('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\UpdateController::class)->name('update');

    // 사용자 소셜 계정 삭제
    Route::delete('/{id}', \Jiny\Auth\Social\Http\Controllers\UserSocial\DeleteController::class)->name('destroy');
});