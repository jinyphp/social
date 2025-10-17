<?php
use Illuminate\Support\Facades\Route;

/**
 * Jiny Social Authentication - User Account Routes
 *
 * 로그인한 사용자가 자신의 소셜 계정을 관리할 수 있는 라우트들을 정의합니다.
 * 사용자는 연동된 소셜 계정을 조회하고, 프로필 정보를 수정할 수 있습니다.
 *
 * 접근 권한: auth 미들웨어 (로그인 사용자 전용)
 * 기본 URL: /home/account/...
 *
 * 사용자 기능:
 * - 연동된 소셜 계정 목록 조회
 * - 소셜 프로필 정보 수정
 * - 소셜 계정 연동/해제
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 */

/**
 * 사용자 계정 관리 라우트 그룹
 *
 * 로그인한 사용자가 자신의 소셜 계정 정보를 관리할 수 있는 기능을 제공합니다.
 * 마이페이지의 일부로 사용되며, 사용자 친화적인 인터페이스를 제공합니다.
 *
 * URL 패턴: /home/account/*
 * 라우트 이름: home.account.*
 */
Route::middleware(['auth'])->prefix('home/account')->name('home.account.')->group(function () {
    /**
     * 소셜 프로필 관리 페이지
     *
     * 사용자의 소셜 계정 연동 상태와 프로필 정보를 표시합니다.
     * 연동된 소셜 계정들(Google, Facebook 등)의 목록과 각 계정의 상태를 보여줍니다.
     *
     * GET /home/account/social
     * 기능:
     * - 연동된 소셜 계정 목록 표시
     * - 각 계정의 프로필 정보 표시
     * - 계정 연동/해제 버튼 제공
     */
    Route::get('/social', \Jiny\Auth\Social\Http\Controllers\Home\Social\IndexController::class)
        ->name('social');

    /**
     * 소셜 프로필 정보 업데이트
     *
     * 사용자가 소셜 프로필 정보를 수정하거나 계정 연동을 관리합니다.
     * 트위터, GitHub, LinkedIn 등의 소셜 미디어 링크를 추가/수정할 수 있습니다.
     *
     * POST /home/account/social
     * Request Body:
     * - twitter: 트위터 계정
     * - github: GitHub 계정
     * - linkedin: LinkedIn 프로필
     * - instagram: 인스타그램 계정
     * - description: 프로필 설명
     */
    Route::post('/social', \Jiny\Auth\Social\Http\Controllers\Home\Social\UpdateController::class)
        ->name('social.update');
});