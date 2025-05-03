<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizerInformation extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone_number',
        'tax_number',
        'address_country',
        'address_zip_code',
        'address_city',
        'address_street',
        'bank_account_number',
        'account_status'
    ];

    protected $casts = [
        'account_status' => 'string',
    ];
    public const ACCOUNT_STATUSES = [
        'pending' => 'Pending',
        'verified' => 'Verified',
        'awaiting clarification' => 'Awaiting Clarification'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddress(): string
    {
        return implode(', ', array_filter([
            $this->address_street,
            $this->address_city,
            $this->address_zip_code,
            $this->address_country
        ]));
    }
}
