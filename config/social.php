<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Social Authentication Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for social authentication providers and settings
    |
    */

    'providers' => [
        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
            'enabled' => env('GOOGLE_ENABLED', false),
        ],
        'facebook' => [
            'client_id' => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect' => env('FACEBOOK_REDIRECT_URI', '/auth/facebook/callback'),
            'enabled' => env('FACEBOOK_ENABLED', false),
        ],
        'twitter' => [
            'client_id' => env('TWITTER_CLIENT_ID'),
            'client_secret' => env('TWITTER_CLIENT_SECRET'),
            'redirect' => env('TWITTER_REDIRECT_URI', '/auth/twitter/callback'),
            'enabled' => env('TWITTER_ENABLED', false),
        ],
        'github' => [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect' => env('GITHUB_REDIRECT_URI', '/auth/github/callback'),
            'enabled' => env('GITHUB_ENABLED', false),
        ],
        'linkedin' => [
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'redirect' => env('LINKEDIN_REDIRECT_URI', '/auth/linkedin/callback'),
            'enabled' => env('LINKEDIN_ENABLED', false),
        ],
        'kakao' => [
            'client_id' => env('KAKAO_CLIENT_ID'),
            'client_secret' => env('KAKAO_CLIENT_SECRET'),
            'redirect' => env('KAKAO_REDIRECT_URI', '/auth/kakao/callback'),
            'enabled' => env('KAKAO_ENABLED', false),
        ],
        'naver' => [
            'client_id' => env('NAVER_CLIENT_ID'),
            'client_secret' => env('NAVER_CLIENT_SECRET'),
            'redirect' => env('NAVER_REDIRECT_URI', '/auth/naver/callback'),
            'enabled' => env('NAVER_ENABLED', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth Settings
    |--------------------------------------------------------------------------
    */
    'oauth' => [
        'token_lifetime' => env('OAUTH_TOKEN_LIFETIME', 3600), // 1 hour
        'refresh_token_lifetime' => env('OAUTH_REFRESH_TOKEN_LIFETIME', 2592000), // 30 days
        'auto_refresh' => env('OAUTH_AUTO_REFRESH', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Profile Settings
    |--------------------------------------------------------------------------
    */
    'profile' => [
        'auto_update' => env('SOCIAL_PROFILE_AUTO_UPDATE', true),
        'sync_avatar' => env('SOCIAL_SYNC_AVATAR', true),
        'allowed_fields' => [
            'name',
            'email',
            'twitter',
            'github',
            'youtube',
            'linkedin',
            'instagram',
            'link',
            'description',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Registration Settings
    |--------------------------------------------------------------------------
    */
    'registration' => [
        'auto_register' => env('SOCIAL_AUTO_REGISTER', true),
        'email_verification' => env('SOCIAL_EMAIL_VERIFICATION', false),
        'default_role' => env('SOCIAL_DEFAULT_ROLE', 'user'),
    ],
];