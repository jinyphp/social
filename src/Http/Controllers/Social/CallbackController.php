<?php

namespace Jiny\Auth\Social\Http\Controllers\Social;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jiny\Auth\Social\Models\User;
use Jiny\Auth\Social\Models\UserOAuth;
use Jiny\Auth\Social\Models\UserOAuthProvider;
use Laravel\Socialite\Facades\Socialite;

/**
 * 소셜 로그인 콜백 컨트롤러
 *
 * OAuth 제공자로부터 인증 완료 후 콜백을 처리하는 컨트롤러입니다.
 * 사용자 정보를 받아와서 기존 계정과 연동하거나 새 계정을 생성하고,
 * 최종적으로 사용자를 로그인시킵니다.
 *
 * @package Jiny\Auth\Social\Http\Controllers\Auth\Social
 * @author Jiny Framework Team
 */
class CallbackController extends Controller
{
    /**
     * OAuth 콜백 처리
     *
     * OAuth 제공자에서 인증 완료 후 돌아오는 콜백을 처리합니다.
     * 다음과 같은 과정을 거칩니다:
     * 1. OAuth 제공자로부터 사용자 정보 조회
     * 2. 기존 OAuth 계정 확인
     * 3. 기존 계정이 있으면 로그인, 없으면 이메일로 사용자 찾기
     * 4. 사용자가 없으면 새 계정 생성
     * 5. OAuth 계정 연동 및 로그인 처리
     *
     * @param string $provider OAuth 제공자 식별자
     * @return \Illuminate\Http\RedirectResponse
     *
     * 플로우:
     * 1. 기존 OAuth 계정 존재 → 해당 사용자로 로그인
     * 2. 기존 사용자 존재 (이메일 기준) → OAuth 계정 연동 후 로그인
     * 3. 신규 사용자 → 계정 생성 및 OAuth 연동 후 로그인
     */
    public function __invoke($provider)
    {
        try {
            // OAuth 제공자로부터 사용자 정보 조회
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // OAuth 인증 실패시 로그인 페이지로 리다이렉트
            return redirect()->route('login')
                ->with('error', '소셜 로그인에 실패했습니다.');
        }

        // 기존 OAuth 계정 조회 (제공자 + 제공자 사용자 ID 기준)
        $oauthAccount = UserOAuth::findByProvider($provider, $socialUser->getId());

        if ($oauthAccount) {
            // 케이스 1: 기존 OAuth 계정이 존재하는 경우
            $user = $oauthAccount->user;
            $oauthAccount->incrementLoginCount(); // 로그인 횟수 증가
        } else {
            // 케이스 2 & 3: 신규 OAuth 계정인 경우

            // 이메일을 기준으로 기존 사용자 찾기
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // 케이스 3: 완전히 새로운 사용자 - 계정 생성
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(str()->random(16)), // 랜덤 비밀번호
                    'email_verified_at' => now(), // 소셜 인증으로 이메일 검증 완료
                ]);
            }
            // 케이스 2: 기존 사용자 - OAuth 계정만 새로 연동

            // OAuth 계정 정보 생성 및 연결
            $oauthAccount = UserOAuth::create([
                'user_id' => $user->id,
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'oauth_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'status' => 'active',
                'cnt' => 1, // 첫 로그인
            ]);

            // 해당 제공자의 사용자 수 통계 증가
            $providerConfig = UserOAuthProvider::findByProvider($provider);
            if ($providerConfig) {
                $providerConfig->incrementUserCount();
            }
        }

        // 사용자 로그인 (Remember 토큰 사용)
        Auth::login($user, true);

        // 원래 접근하려던 페이지 또는 홈페이지로 리다이렉트
        return redirect()->intended('/');
    }
}