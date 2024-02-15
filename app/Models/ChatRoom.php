<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['admin_user_id', 'member_user_id'];

    public function chatAdminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
    
    public function chatMemberUser()
    {
        return $this->belongsTo(User::class, 'member_user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
