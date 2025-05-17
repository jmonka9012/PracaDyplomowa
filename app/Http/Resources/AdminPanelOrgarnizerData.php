<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminPanelOrgarnizerData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'phone_number' => $this->phone_number,
            'email' => $this->user->email,
            'tax_number' => $this->tax_number,
            'author_name' => trim($this->address_country . ', ' . $this->address_city . ', ' . $this->address_street . ' ' . $this->address_zip_code),
            'bank_account_number' => $this->bank_account_number,
            'account_status' => $this->account_status
        ];
    }
}