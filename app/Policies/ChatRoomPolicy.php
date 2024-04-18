<?php

namespace App\Policies;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChatRoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ChatRoom $chatRoom): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ChatRoom $chatRoom): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ChatRoom $chatRoom): bool
    {
        return ($user->id === $chatRoom->admin_user_id || $user->id === $chatRoom->member_user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ChatRoom $chatRoom): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ChatRoom $chatRoom): bool
    {
        //
    }
}
