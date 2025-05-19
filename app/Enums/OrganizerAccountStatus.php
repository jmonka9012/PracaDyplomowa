<?php

namespace App\Enums;

enum OrganizerAccountStatus :string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case DENIED = 'denied';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Konto w trakcie rozpatrywania',
            self::VERIFIED => 'Konto zweryfikowane',
            self::DENIED => 'Konto odrzucone/potrzeba sprostowania danych',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
