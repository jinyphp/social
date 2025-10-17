<?php

namespace Jiny\Auth\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 사용자 OAuth 계정 모델
 *
 * 사용자와 소셜 로그인 계정 간의 연동 정보를 관리합니다.
 * Google, Facebook, GitHub, Kakao, Naver 등의 OAuth 제공자와 연결된
 * 사용자 계정 정보를 저장하고 관리합니다.
 *
 * @package Jiny\Auth\Social\Models
 * @author Jiny Framework Team
 *
 * @property int $id 고유 식별자
 * @property int $user_id 연결된 사용자 ID
 * @property string $email OAuth 계정의 이메일
 * @property string $provider OAuth 제공자 (google, facebook, github 등)
 * @property string $provider_id 제공자별 사용자 고유 ID
 * @property string $oauth_id OAuth 고유 식별자
 * @property string|null $avatar 프로필 이미지 URL
 * @property string $status 계정 상태 (active, inactive)
 * @property int $cnt 로그인 횟수
 * @property \Carbon\Carbon $created_at 생성일시
 * @property \Carbon\Carbon $updated_at 수정일시
 */
class UserOAuth extends Model
{
    use HasFactory;

    /**
     * 연결된 데이터베이스 테이블명
     *
     * @var string
     */
    protected $table = 'user_oauth';

    /**
     * 대량 할당 가능한 속성들
     *
     * @var array
     */
    protected $fillable = [
        'user_id',          // 연결된 사용자 ID
        'email',            // OAuth 계정 이메일
        'provider',         // OAuth 제공자
        'provider_id',      // 제공자별 사용자 ID
        'oauth_id',         // OAuth 고유 식별자
        'avatar',           // 프로필 이미지 URL
        'status',           // 계정 상태
        'cnt'               // 로그인 횟수
    ];

    /**
     * 속성 타입 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'cnt' => 'integer',
    ];

    /**
     * 연결된 사용자와의 관계 (Belongs To)
     *
     * OAuth 계정이 소속된 사용자 모델을 반환합니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * OAuth 제공자 정보와의 관계 (Belongs To)
     *
     * 이 OAuth 계정의 제공자 설정 정보를 반환합니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function providerInfo()
    {
        return $this->belongsTo(UserOAuthProvider::class, 'provider', 'provider');
    }

    /**
     * 로그인 횟수 증가
     *
     * 사용자가 이 OAuth 계정으로 로그인할 때마다 카운터를 증가시킵니다.
     * 사용 통계 및 분석 목적으로 활용됩니다.
     *
     * @return $this
     */
    public function incrementLoginCount()
    {
        $this->increment('cnt');
        return $this;
    }

    /**
     * 계정 활성 상태 확인
     *
     * OAuth 계정이 활성화되어 있는지 확인합니다.
     * 비활성화된 계정은 로그인에 사용할 수 없습니다.
     *
     * @return bool 활성 상태이면 true, 그렇지 않으면 false
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * 제공자와 제공자 ID로 OAuth 계정 찾기
     *
     * 특정 OAuth 제공자(google, facebook 등)와 해당 제공자의
     * 사용자 ID로 기존 OAuth 계정을 찾습니다.
     *
     * @param string $provider OAuth 제공자명
     * @param string $providerId 제공자별 사용자 ID
     * @return \Jiny\Auth\Social\Models\UserOAuth|null
     */
    public static function findByProvider($provider, $providerId)
    {
        return static::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();
    }

    /**
     * 특정 사용자의 모든 소셜 계정 조회
     *
     * 한 사용자가 연결한 모든 OAuth 계정들을 반환합니다.
     * 소셜 계정 관리 페이지에서 사용됩니다.
     *
     * @param int $userId 사용자 ID
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function findByUser($userId)
    {
        return static::where('user_id', $userId)->get();
    }
}