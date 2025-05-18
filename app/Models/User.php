<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Tickets\TicketArchived;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Blog\BlogAuthor;
use App\Models\Tickets\Ticket;
use App\Models\OrganizerInformation;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'email_verified_at',
    ];

    protected $casts = [
        'role' => UserRole::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketsArchived()
    {
        return $this->hasMany(TicketArchived::class);
    }
    public function author()
    {
        return $this->hasOne(BlogAuthor::class);
    }

    public function getPermissionLevel()
    {
        return UserRole::from($this->attributes['role'])->permissionLevel();
    }

    public function organizer()
    {
        return $this->hasOne(OrganizerInformation::class, 'user_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function scopeWithTicketCounts($query)
    {
        return $query->withCount([
            'tickets',
            'ticketsArchived',
            'supportTickets'
        ]);
    }

    public function supportTicketsCount()
    {
        return $this->support_tickets_count ?? $this->supportTickets()->count();
    }

    public function totalTicketsCount()
    {
        return ($this->tickets_count ?? $this->tickets()->count()) + 
            ($this->tickets_archived_count ?? $this->ticketsArchived()->count());
    }
}
