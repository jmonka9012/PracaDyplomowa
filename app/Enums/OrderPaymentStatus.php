<?php

namespace App\Enums;

enum OrderPaymentStatus
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case PAID = 'paid';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Zamówienie czeka na opłate',
            self::CANCELLED => 'Zamówienie anulowane',
            self::PAID => 'Zamówienie opłacone',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
