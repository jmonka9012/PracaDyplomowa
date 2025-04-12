<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case REDACTOR = 'redactor';
    case BLOG_AUTHOR = 'blog_author';
    case ORGANIZER = 'organizer';
    case VERIFIED_USER = 'verified_user';
    case UNVERIFIED_USER = 'unverified_user';
    case GUEST = 'guest';

    public function permissionLevel(): int
    {
        return match ($this) {
            self::ADMIN => 0,
            self::MODERATOR => 1,
            self::REDACTOR => 2,
            self::BLOG_AUTHOR => 3,
            self::ORGANIZER => 4,
            self::VERIFIED_USER => 6,
            self::UNVERIFIED_USER => 8,
            self::GUEST => 10,
        };
    }

    public function permissionLabel(): string
    {
        return match($this){
            self::ADMIN => 'admin',
            self::MODERATOR => 'moderator',
            self::REDACTOR => 'redactor',
            self::BLOG_AUTHOR => 'blog_author',
            self::ORGANIZER => 'organizer',
            self::VERIFIED_USER => 'verified_user',
            self::UNVERIFIED_USER => 'unverified_user',
            self::GUEST => 'guest',
        };
    }
}
//'admin', 'moderator', 'blog_author', 'organizer', 'verified user', 'unverified user', 'guest']