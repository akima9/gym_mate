<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'age',
        'gym_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'send_user_id', 'id');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'receive_user_id', 'id');
    }
    
    public function chatRoomAdminUsers()
    {
        return $this->hasMany(ChatRoom::class, 'admin_user_id', 'id');
    }
    
    public function chatRoomMemberUsers()
    {
        return $this->hasMany(ChatRoom::class, 'member_user_id', 'id');
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }
}
