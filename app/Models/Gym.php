<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'gym_id', 'id');
    }
}
