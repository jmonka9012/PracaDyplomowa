<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'name',
        'topic',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function totalSupportTickets()
        {
            return self::count();
        }

}
