<?php

namespace Jiny\Auth\Social;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Routing\Router;

class JinySocialServiceProvider extends ServiceProvider
{
    private $package = "jiny-social";

    public function boot()
    {
        // 미들웨어 등록
        $this->registerMiddleware();

        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/home.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // 설정파일 복사
        $this->publishes([
            __DIR__.'/../config/social.php' => config_path('social.php'),
        ], 'config');

        // 뷰 파일 복사
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/jiny-social'),
        ], 'views');

        // 어셋 파일 복사
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/jiny-social'),
        ], 'assets');
    }

    /**
     * 미들웨어 등록
     */
    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // 소셜 관련 미들웨어가 필요한 경우 여기에 등록
        // $router->aliasMiddleware('social.auth', \Jiny\Auth\Social\Http\Middleware\SocialAuthMiddleware::class);
    }

    public function register()
    {
        // 설정 파일 병합
        $this->mergeConfigFrom(__DIR__.'/../config/social.php', 'social');

        // 서비스 바인딩
        $this->app->singleton('jiny.social', function ($app) {
            return new \Jiny\Auth\Social\Services\SocialManager($app);
        });

        // OAuth 서비스 바인딩
        $this->app->singleton('jiny.oauth', function ($app) {
            return new \Jiny\Auth\Social\Services\OAuthService($app);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return ['jiny.social', 'jiny.oauth'];
    }
}