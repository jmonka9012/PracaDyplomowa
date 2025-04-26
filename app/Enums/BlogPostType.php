<?php

namespace App\Enums;

enum BlogPostType: string 
{
    case GUIDE = 'Poradnik';
    case TRENDS = 'Trendy';
    case MARKETING = 'Marketing';
    case TECHNOLOGY = 'Technologia';
    case NONE = 'Brak';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}