<?php
use Illuminate\Support\Facades\Route;

/**
 * Jiny Social Authentication - API Routes
 *
 * 소셜 로그인 기능을 위한 RESTful API 라우트들을 정의합니다.
 * JWT 토큰 기반 인증을 사용하여 모바일 앱이나 SPA에서 활용할 수 있습니다.
 *
 * 인증 방식: JWT (JSON Web Token)
 * 미들웨어: jwt.auth
 * API 버전: v1
 *
 * 주요 기능:
 * - OAuth 토큰 관리 (발급, 갱신, 폐기)
 * - 인증된 사용자 정보 조회
 * - 소셜 계정 연동/해제
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 */

/**
 * API v1 라우트 그룹
 *
 * JWT 인증이 필요한 API 엔드포인트들을 정의합니다.
 * 모든 요청은 Authorization 헤더에 유효한 JWT 토큰이 필요합니다.
 *
 * 헤더 예시: Authorization: Bearer {jwt_token}
 */
Route::middleware(['jwt.auth'])->prefix('api/v1')->group(function () {
    /**
     * OAuth 토큰 관리 API 그룹
     *
     * JWT 토큰의 생성, 갱신, 폐기 및 사용자 정보 조회를 담당합니다.
     * 소셜 로그인으로 받은 OAuth 토큰을 JWT로 변환하거나 관리합니다.
     *
     * URL 패턴: /api/v1/oauth/*
     * 라우트 이름: api.oauth.*
     */
    Route::prefix('oauth')->name('api.oauth.')->group(function () {
        /**
         * JWT 토큰 발급
         *
         * 소셜 로그인 완료 후 JWT 토큰을 발급받습니다.
         * OAuth 인증 코드나 기존 토큰을 사용하여 새 JWT 토큰을 생성합니다.
         *
         * POST /api/v1/oauth/token
         * Request Body: { "code": "auth_code", "provider": "google" }
         * Response: { "access_token": "jwt_token", "refresh_token": "refresh_token" }
         */
        Route::post('/token', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@token')->name('token');

        /**
         * JWT 토큰 갱신
         *
         * 만료된 JWT 토큰을 리프레시 토큰을 사용하여 갱신합니다.
         *
         * POST /api/v1/oauth/refresh
         * Request Body: { "refresh_token": "refresh_token" }
         * Response: { "access_token": "new_jwt_token" }
         */
        Route::post('/refresh', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@refresh')->name('refresh');

        /**
         * JWT 토큰 폐기
         *
         * 현재 사용 중인 JWT 토큰을 무효화합니다.
         * 로그아웃 시 보안을 위해 사용됩니다.
         *
         * POST /api/v1/oauth/revoke
         * Headers: Authorization: Bearer {jwt_token}
         * Response: { "message": "Token revoked successfully" }
         */
        Route::post('/revoke', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@revoke')->name('revoke');

        /**
         * 인증된 사용자 정보 조회
         *
         * JWT 토큰으로 인증된 사용자의 기본 정보를 조회합니다.
         *
         * GET /api/v1/oauth/user
         * Headers: Authorization: Bearer {jwt_token}
         * Response: { "id": 1, "name": "User Name", "email": "user@example.com" }
         */
        Route::get('/user', \Jiny\Auth\Social\Http\Controllers\OAuthController::class.'@user')->name('user');
    });
});