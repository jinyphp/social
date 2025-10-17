<?php

namespace Jiny\Auth\Social;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Routing\Router;

/**
 * Jiny Social Authentication Service Provider
 *
 * 소셜 로그인 기능을 제공하는 서비스 프로바이더입니다.
 * Google, Facebook, GitHub, Kakao, Naver 등의 OAuth 제공자를 지원합니다.
 *
 * 주요 기능:
 * - OAuth 2.0 소셜 로그인
 * - 사용자 계정 연동/해제
 * - 소셜 프로필 정보 관리
 * - JWT 토큰 기반 API 인증
 *
 * @package Jiny\Auth\Social
 * @author Jiny Framework Team
 * @version 1.0.0
 */
class JinySocialServiceProvider extends ServiceProvider
{
    /**
     * 패키지 식별자
     *
     * @var string
     */
    private $package = "jiny-social";

    /**
     * 서비스 부트스트랩
     *
     * 애플리케이션이 부트스트랩될 때 실행되며, 라우트, 뷰, 마이그레이션 등을 등록합니다.
     *
     * @return void
     */
    public function boot()
    {
        // 소셜 인증 관련 미들웨어 등록
        $this->registerMiddleware();

        // 라우트 파일들 로드 (웹, 관리자, 홈, API)
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/home.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // 뷰 파일들 등록
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스 마이그레이션 파일들 로드
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // 설정 파일 publish (vendor:publish 명령어로 복사 가능)
        $this->publishes([
            __DIR__.'/../config/social.php' => config_path('social.php'),
        ], 'config');

        // 뷰 파일 publish (커스터마이징을 위해)
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/jiny-social'),
        ], 'views');

        // 정적 자산 파일들 publish
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/jiny-social'),
        ], 'assets');
    }

    /**
     * 소셜 인증 관련 미들웨어 등록
     *
     * 필요한 경우 소셜 인증 전용 미들웨어를 등록합니다.
     * 현재는 기본 auth 미들웨어를 사용하므로 비활성화되어 있습니다.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // 소셜 인증 전용 미들웨어 (필요시 활성화)
        // $router->aliasMiddleware('social.auth', \Jiny\Auth\Social\Http\Middleware\SocialAuthMiddleware::class);
    }

    /**
     * 서비스 컨테이너에 바인딩 등록
     *
     * 소셜 로그인 관련 서비스들을 싱글톤으로 등록하고 설정을 병합합니다.
     *
     * @return void
     */
    public function register()
    {
        // 패키지 설정 파일을 애플리케이션 설정에 병합
        $this->mergeConfigFrom(__DIR__.'/../config/social.php', 'social');

        // 소셜 매니저 서비스 바인딩 (현재 미구현)
        $this->app->singleton('jiny.social', function ($app) {
            return new \Jiny\Auth\Social\Services\SocialManager($app);
        });

        // OAuth 서비스 바인딩 - 소셜 로그인의 핵심 로직 담당
        $this->app->singleton('jiny.oauth', function ($app) {
            return new \Jiny\Auth\Social\Services\OAuthService($app);
        });
    }

    /**
     * 프로바이더가 제공하는 서비스 목록
     *
     * 라라벨의 지연 로딩을 위해 제공되는 서비스들을 명시합니다.
     *
     * @return array
     */
    public function provides()
    {
        return ['jiny.social', 'jiny.oauth'];
    }
}