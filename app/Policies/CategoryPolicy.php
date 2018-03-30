<?php
namespace Corp\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Corp\User;
use Corp\Category;

class CategoryPolicy
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
        return $user->canDo('ADD_CATEGORIES');
    }

    public function edit(User $user) {
        return $user->canDo('UPDATE_CATEGORIES');
    }

    public function destroy(User $user, Category $category) {
        return $user->canDo('DELETE_CATEGORIES');
    }
}
