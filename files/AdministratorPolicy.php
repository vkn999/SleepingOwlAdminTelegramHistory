<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class AdministratorPolicy
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

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return void
     */
    public function before(User $user, $ability, Model $item) {}

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Model $item)
    {
        return $this->checkFunc($user, $item);
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function create(User $user, Model $item)
    {
        return $this->checkFunc($user, $item);
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, Model $item)
    {
        return $this->checkFunc($user, $item);
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, Model $item)
    {
        return $this->checkFunc($user, $item);
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function restore(User $user, Model $item)
    {
        return $this->checkFunc($user, $item);
    }

    private function checkFunc(User $user, Model $item)
    {
        return $user->hasRole('admin') ? true : false ;
    }
}
