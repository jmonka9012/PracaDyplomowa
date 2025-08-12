<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the ticket
 * @property string $company_name Is the ticket for a seat
 * @property mixed $user Holds information about the user associated with the account
 * @property string $tax_number Holds the tax number of the company
 * @property string $phone_number Holds the phone number of the company
 * @property string $bank_account_number Holds the bank account number of the company
 * @property \App\Enums\OrganizerAccountStatus $account_status Enum for the status of the account : Pending, Denied, Verified
 * @property mixed $standingTicket Holds information about the seat
 * 
 * @property string $address_country Holds the country the company is registered in
 * @property string $address_city Holds the city the company is registered in
 * @property string $address_street Holds the exact street the company is in
 * @property string $address_zip_code Holds the zip code of the company
 */

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
            'address' => trim($this->address_country . ', ' . $this->address_city . ', ' . $this->address_street . ' ' . $this->address_zip_code),
            'bank_account_number' => $this->bank_account_number,
            'account_status' => $this->account_status
        ];
    }
}