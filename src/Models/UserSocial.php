<?php

namespace Jiny\Auth\Social\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 사용자 소셜 프로필 모델
 *
 * 사용자의 소셜 미디어 계정 정보와 프로필을 관리합니다.
 * OAuth 연동 정보(UserOAuth)와는 별개로 사용자의 소셜 미디어
 * 프로필 링크와 설명 등을 저장합니다.
 *
 * @package Jiny\Auth\Social\Models
 * @author Jiny Framework Team
 *
 * @property int $id 고유 식별자
 * @property int|null $user_id 연결된 사용자 ID
 * @property string|null $user_uuid 사용자 UUID (샤딩 지원)
 * @property int|null $shard_id 샤드 ID (분산 저장시 사용)
 * @property string $enable 활성화 여부
 * @property string|null $name 소셜 프로필 이름
 * @property string|null $email 소셜 프로필 이메일
 * @property string|null $type 프로필 타입
 * @property string|null $twitter 트위터 계정
 * @property string|null $github GitHub 계정
 * @property string|null $youtube YouTube 채널
 * @property string|null $linkedin LinkedIn 프로필
 * @property string|null $instagram 인스타그램 계정
 * @property string|null $link 웹사이트 링크
 * @property string|null $description 프로필 설명
 * @property int|null $manager_id 관리자 ID
 * @property \Carbon\Carbon $created_at 생성일시
 * @property \Carbon\Carbon $updated_at 수정일시
 */
class UserSocial extends Model
{
    use HasFactory;

    /**
     * 연결된 데이터베이스 테이블명
     *
     * @var string
     */
    protected $table = 'users_social';

    /**
     * 대량 할당 가능한 속성들
     *
     * @var array
     */
    protected $fillable = [
        'user_id',          // 연결된 사용자 ID
        'user_uuid',        // 사용자 UUID (샤딩 지원)
        'shard_id',         // 샤드 ID
        'enable',           // 활성화 여부
        'name',             // 소셜 프로필 이름
        'email',            // 소셜 프로필 이메일
        'type',             // 프로필 타입
        'twitter',          // 트위터 계정
        'github',           // GitHub 계정
        'youtube',          // YouTube 채널
        'linkedin',         // LinkedIn 프로필
        'instagram',        // 인스타그램 계정
        'link',             // 웹사이트 링크
        'description',      // 프로필 설명
        'manager_id',       // 관리자 ID
    ];

    /**
     * 속성 타입 캐스팅
     *
     * @var array
     */
    protected $casts = [
        'provider_expires_at' => 'datetime',
    ];

    /**
     * 연결된 사용자와의 관계 (Belongs To)
     *
     * 이 소셜 프로필이 속한 사용자 모델을 반환합니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }
}