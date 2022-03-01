<?php

namespace App\Admin\Policies;

use App\Admin\Sections\Users;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersSectionModelPolicy
{

  use HandlesAuthorization;

  public function before(User $user, $ability, Users $section, User $item = null)
  {
    // if ($user->isAdmin()) {
    //   return true;
    // }
  }


  public function display(User $user, Users $section, User $item) {
    if ($user->isAdmin() || $user->isModerator() || $user->isManager()) {
      return true;
    }
    return false;
  }

  public function create(User $user, Users $section, User $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function edit(User $user, Users $section, User $item) {
    if ($user->id == $item->id) {
      return true;
    }
    if ($user->isAdmin() && $item->id !== 18 && $item->id !== 16 && $item->id > 1) {
      return true;
    }
    return false;
  }

  public function delete(User $user, Users $section, User $item) {
    // if ($user->isAdmin()) {
    //   return $item->id > 1;
    // }
    return false;
  }

  public function restore(User $user, Users $section, User $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  // public function destroy(User $user, Users $section, User $item) {
  //   if ($user->isAdmin()) {
  //     return true;
  //   }
  //   return false;
  // }

}
