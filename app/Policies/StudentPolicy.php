<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }
}
