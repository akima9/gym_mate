<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function updateLastLogin(User $user)
    {
        User::where('id', $user->id)
            ->update([
                'last_login' => now(),
            ]);
    }
}
