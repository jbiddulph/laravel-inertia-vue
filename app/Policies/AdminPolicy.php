<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    public function delete(User $user)
    {
        return $user->email === 'john.mbiddulph@gmail.com';
    }
}
