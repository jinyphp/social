# Jiny Social Authentication Package

Social Authentication package for JinyPHP - OAuth, Social Login, and Social Media Integration.

## Features

- OAuth Provider Management
- Social Login (Google, Facebook, Twitter, etc.)
- User Social Profile Management
- Social Media Integration
- Admin Panel for Social Settings

## Installation

```bash
composer require jiny/social
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Jiny\Auth\Social\JinySocialServiceProvider"
```

## Usage

### Admin Routes
- `/admin/auth/user/social` - User social accounts management
- `/admin/auth/oauth-providers` - OAuth providers configuration

### User Routes
- `/auth/{provider}` - Social login
- `/auth/{provider}/callback` - Social login callback
- `/home/account/social` - User social profile management

## License

MIT License