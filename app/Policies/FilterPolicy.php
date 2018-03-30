<?php

namespace Corp\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Corp\User;
use Corp\Filter;

class FilterPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user) {
        return $user->canDo('ADD_FILTERS');
    }

    public function edit(User $user) {
        return $user->canDo('UPDATE_FILTERS');
    }

    public function destroy(User $user, Filter $filter) {
        return $user->canDo('DELETE_FILTERS');
    }
}
