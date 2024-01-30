<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'send_user_id', 'receive_user_id'];

    public function sendUser()
    {
        return $this->belongsTo(User::class, 'send_user_id');
    }
    
    public function receiveUser()
    {
        return $this->belongsTo(User::class, 'receive_user_id');
    }
}
