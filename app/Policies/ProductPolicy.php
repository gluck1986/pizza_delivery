<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;


    public function write(User $user): Response
    {
        return $user->adminAccess == 1
            ? Response::allow()
            : Response::deny('You have no access');
    }
}
