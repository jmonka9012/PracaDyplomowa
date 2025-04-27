<?php

namespace App\Enums;

enum BlogPostType: string 
{
    case GUIDE = 'Poradnik';
    case TRENDS = 'Trendy';
    case MARKETING = 'Marketing';
    case TECHNOLOGY = 'Technologia';
    case BEHIND_THE_SCENES = 'Za Kulisami';
    case LIFESTYLE = 'Życiowe';
    case SUMMARY = 'Podsumowanie';
    case TOP10 = 'Top 10';

    case NONE = 'Brak';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}