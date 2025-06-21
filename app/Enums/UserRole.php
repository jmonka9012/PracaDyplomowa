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
            self::ADMIN => 'Administrator',
            self::MODERATOR => 'Moderator',
            self::REDACTOR => 'Redaktor',
            self::BLOG_AUTHOR => 'Autor',
            self::ORGANIZER => 'Organizator',
            self::VERIFIED_USER => 'Użytkownik',
            self::UNVERIFIED_USER => 'Użytkownik bez weryfikacji',
            self::GUEST => 'Gość',
        };
    }
}