<?php

namespace Jiny\Auth\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * OAuth 제공자 설정 모델
 *
 * Google, Facebook, GitHub, Kakao, Naver 등의 OAuth 제공자들의
 * 설정 정보를 관리합니다. 각 제공자별로 클라이언트 ID, 시크릿,
 * 콜백 URL 등의 OAuth 설정을 저장합니다.
 *
 * @package Jiny\Auth\Social\Models
 * @author Jiny Framework Team
 *
 * @property int $id 고유 식별자
 * @property string $enable 활성화 여부 (yes/no)
 * @property string $name 제공자 표시명
 * @property string $provider 제공자 식별자 (google, facebook 등)
 * @property string $client_id OAuth 클라이언트 ID
 * @property string $client_secret OAuth 클라이언트 시크릿
 * @property string|null $redirect_url 리다이렉트 URL
 * @property string|null $callback_url 콜백 URL
 * @property string|null $logout_url 로그아웃 URL
 * @property string|null $icon 아이콘 URL 또는 경로
 * @property string|null $color 브랜드 색상
 * @property int $users 이 제공자를 사용하는 사용자 수
 * @property \Carbon\Carbon $created_at 생성일시
 * @property \Carbon\Carbon $updated_at 수정일시
 */
class UserOAuthProvider extends Model
{
    use HasFactory;

    /**
     * 연결된 데이터베이스 테이블명
     *
     * @var string
     */
    protected $table = 'user_oauth_providers';

    /**
     * 대량 할당 가능한 속성들
     *
     * @var array
     */
    protected $fillable = [
        'enable',           // 활성화 여부
        'name',             // 제공자 표시명
        'provider',         // 제공자 식별자
        'client_id',        // OAuth 클라이언트 ID
        'client_secret',    // OAuth 클라이언트 시크릿
        'redirect_url',     // 리다이렉트 URL
        'callback_url',     // 콜백 URL
        'logout_url',       // 로그아웃 URL
        'icon',             // 아이콘 URL/경로
        'color',            // 브랜드 색상
        'users'             // 사용자 수
    ];

    /**
     * 속성 타입 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'users' => 'integer',
    ];

    /**
     * 이 제공자를 사용하는 OAuth 계정들과의 관계 (Has Many)
     *
     * 특정 OAuth 제공자(예: Google)를 사용하는 모든 사용자 계정들을 반환합니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthAccounts()
    {
        return $this->hasMany(UserOAuth::class, 'provider', 'provider');
    }

    /**
     * 활성화된 OAuth 제공자들 조회
     *
     * 현재 활성화되어 사용 가능한 모든 OAuth 제공자들을 반환합니다.
     * 로그인 페이지에서 사용할 수 있는 소셜 로그인 옵션들을 표시할 때 사용됩니다.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getEnabled()
    {
        return static::where('enable', 'yes')->get();
    }

    /**
     * 제공자 식별자로 OAuth 제공자 찾기
     *
     * 특정 제공자(google, facebook 등)의 설정 정보를 조회합니다.
     *
     * @param string $provider 제공자 식별자
     * @return \Jiny\Auth\Social\Models\UserOAuthProvider|null
     */
    public static function findByProvider($provider)
    {
        return static::where('provider', $provider)->first();
    }

    /**
     * 제공자 활성화 상태 확인
     *
     * 이 OAuth 제공자가 현재 활성화되어 사용 가능한지 확인합니다.
     *
     * @return bool 활성화되어 있으면 true, 그렇지 않으면 false
     */
    public function isEnabled()
    {
        return $this->enable === 'yes';
    }

    /**
     * 사용자 수 증가
     *
     * 새로운 사용자가 이 제공자로 가입했을 때 사용자 수를 증가시킵니다.
     * 통계 목적으로 사용됩니다.
     *
     * @return $this
     */
    public function incrementUserCount()
    {
        $this->increment('users');
        return $this;
    }

    /**
     * 사용자 수 감소
     *
     * 사용자가 이 제공자와의 연동을 해제했을 때 사용자 수를 감소시킵니다.
     * 0 이하로는 감소하지 않도록 보호됩니다.
     *
     * @return $this
     */
    public function decrementUserCount()
    {
        if ($this->users > 0) {
            $this->decrement('users');
        }
        return $this;
    }

    /**
     * OAuth 설정 배열 반환
     *
     * Laravel Socialite나 다른 OAuth 라이브러리에서 사용할 수 있는
     * 형태의 설정 배열을 반환합니다.
     *
     * @return array OAuth 설정 정보
     */
    public function getConfig()
    {
        return [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect' => $this->callback_url ?: url('/auth/callback/' . $this->provider),
        ];
    }

    /**
     * 제공자 아이콘 URL 가져오기
     *
     * 커스텀 아이콘이 설정되어 있으면 그것을 사용하고,
     * 그렇지 않으면 각 제공자의 기본 아이콘을 반환합니다.
     *
     * @return string|null 아이콘 URL
     */
    public function getIconUrl()
    {
        // 커스텀 아이콘이 HTTP URL로 설정되어 있는 경우
        if ($this->icon && str_starts_with($this->icon, 'http')) {
            return $this->icon;
        }

        // 제공자별 기본 아이콘 URL 매핑
        $defaultIcons = [
            'google' => 'https://www.google.com/favicon.ico',
            'facebook' => 'https://www.facebook.com/favicon.ico',
            'github' => 'https://github.com/favicon.ico',
            'kakao' => 'https://t1.kakaocdn.net/kakaocorp/kakaocorp/admin/5f9c58c2017800001.png',
            'naver' => 'https://www.naver.com/favicon.ico',
        ];

        return $defaultIcons[$this->provider] ?? null;
    }
}