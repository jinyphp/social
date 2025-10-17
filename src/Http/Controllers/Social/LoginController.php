<?php

namespace Jiny\Auth\Social\Http\Controllers\Auth\Social;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Auth\Social\Models\UserOAuthProvider;
use Laravel\Socialite\Facades\Socialite;

/**
 * 소셜 로그인 컨트롤러
 *
 * OAuth 제공자(Google, Facebook, GitHub 등)를 통한 소셜 로그인을
 * 시작하는 컨트롤러입니다. 사용자를 각 제공자의 인증 페이지로
 * 리다이렉트시키는 역할을 담당합니다.
 *
 * @package Jiny\Auth\Social\Http\Controllers\Auth\Social
 * @author Jiny Framework Team
 */
class LoginController extends Controller
{
    /**
     * 소셜 로그인 시작
     *
     * 지정된 OAuth 제공자를 통한 소셜 로그인을 시작합니다.
     * 제공자가 활성화되어 있는지 확인한 후, 해당 제공자의
     * 인증 페이지로 사용자를 리다이렉트시킵니다.
     *
     * @param string $provider OAuth 제공자 식별자 (google, facebook, github 등)
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \InvalidArgumentException 지원하지 않는 제공자인 경우
     *
     * 사용 예시:
     * - GET /auth/google → Google OAuth 로그인 시작
     * - GET /auth/facebook → Facebook OAuth 로그인 시작
     */
    public function __invoke($provider)
    {
        // 요청된 OAuth 제공자의 설정 정보 조회
        $providerConfig = UserOAuthProvider::findByProvider($provider);

        // 제공자가 존재하지 않거나 비활성화된 경우 에러 처리
        if (!$providerConfig || !$providerConfig->isEnabled()) {
            return redirect()->route('login')
                ->with('error', '지원하지 않는 소셜 로그인입니다.');
        }

        // Laravel Socialite를 사용하여 OAuth 인증 시작
        // 제공자의 인증 페이지로 사용자를 리다이렉트
        return Socialite::driver($provider)
            ->with($providerConfig->getConfig())
            ->redirect();
    }
}