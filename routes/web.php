<?php
use Illuminate\Support\Facades\Route;

/**
 * Jiny Social Authentication - Web Routes
 *
 * 소셜 로그인 기능을 위한 웹 라우트들을 정의합니다.
 * OAuth 2.0 프로토콜을 사용하여 다양한 소셜 플랫폼과 연동합니다.
 *
 * 지원하는 OAuth 제공자:
 * - Google (google)
 * - Facebook (facebook)
 * - Twitter (twitter)
 * - GitHub (github)
 * - LinkedIn (linkedin)
 * - Kakao (kakao)
 * - Naver (naver)
 *
 * 인증 플로우:
 * 1. /auth/{provider} → OAuth 제공자 인증 페이지로 리다이렉트
 * 2. /auth/{provider}/callback → 인증 완료 후 콜백 처리
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 */

/**
 * 소셜 로그인 시작 라우트
 *
 * 사용자를 선택한 OAuth 제공자의 인증 페이지로 리다이렉트합니다.
 * 제공자가 활성화되어 있는지 확인한 후 OAuth 인증을 시작합니다.
 *
 * URL 예시:
 * - GET /auth/google → Google OAuth 인증 시작
 * - GET /auth/kakao → Kakao OAuth 인증 시작
 */
Route::get('/auth/{provider}', \Jiny\Auth\Social\Http\Controllers\Social\LoginController::class)
    ->name('social.login')
    ->where('provider', 'google|facebook|twitter|github|linkedin|kakao|naver');

/**
 * 소셜 로그인 콜백 라우트
 *
 * OAuth 제공자에서 인증 완료 후 돌아오는 콜백을 처리합니다.
 * 사용자 정보를 받아와서 계정 연동/생성 후 로그인을 완료합니다.
 *
 * URL 예시:
 * - GET /auth/google/callback → Google OAuth 콜백 처리
 * - GET /auth/kakao/callback → Kakao OAuth 콜백 처리
 *
 * 쿼리 파라미터:
 * - code: OAuth 인증 코드
 * - state: CSRF 보호를 위한 상태값
 * - error: 인증 실패시 에러 코드 (선택적)
 */
Route::get('/auth/{provider}/callback', \Jiny\Auth\Social\Http\Controllers\Social\CallbackController::class)
    ->name('social.callback')
    ->where('provider', 'google|facebook|twitter|github|linkedin|kakao|naver');