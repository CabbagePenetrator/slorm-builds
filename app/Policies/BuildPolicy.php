<?php

namespace App\Policies;

use App\Models\Build;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuildPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Build $build)
    {
        return $user->id === $build->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Build $build)
    {
        return $user->id === $build->user_id;
    }
}
