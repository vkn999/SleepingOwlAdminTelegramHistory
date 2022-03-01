<?php

namespace Modules\Card\Admin\Policies;

use App\User;

use Modules\Card\Admin\Sections\Cards as Section;
use Modules\Card\Models\Card as Model;

use Illuminate\Auth\Access\HandlesAuthorization;

class CardsSectionModelPolicy
{

  use HandlesAuthorization;

  public function before(User $user, $ability, Section $section, Model $item = null)
  {
    // if ($user->isAdmin()) {
    //   return true;
    // }
  }


  public function display(User $user, Section $section, Model $item) {
    if ($user->isAdmin() || $user->isModerator()) {
      return true;
    }
    return false;
  }

  public function create(User $user, Section $section, Model $item) {
    if ($user->isAdmin() || $user->isModerator()) {
      return true;
    }
    return false;
  }

  public function edit(User $user, Section $section, Model $item) {
    if ($user->isAdmin() || $user->isModerator()) {
      return ($item->id < 8 || $item->id > 10) && $item->id !== 12;
    }
    return false;
  }

  public function delete(User $user, Section $section, Model $item) {
    // if ($user->isAdmin()) {
    //   return ($item->id < 8 || $item->id > 10) && $item->id !== 12;
    // }
    return false;
  }

  public function restore(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function destroy(User $user, Section $section, Model $item) {
    // if ($user->isAdmin()) {
    //   return false;
    // }
    return false;
  }

}
