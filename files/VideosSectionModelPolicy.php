<?php

namespace Modules\Video\Admin\Policies;

use App\User;

use Modules\Video\Admin\Sections\Videos as Section;
use Modules\Video\Models\Video as Model;

use Illuminate\Auth\Access\HandlesAuthorization;

class VideosSectionModelPolicy
{

  use HandlesAuthorization;

  public function before(User $user, $ability, Section $section, Model $item = null)
  {
    // if ($user->isAdmin()) {
    //   return true;
    // }
  }


  public function display(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function create(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function edit(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function delete(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function restore(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

  public function destroy(User $user, Section $section, Model $item) {
    if ($user->isAdmin()) {
      return true;
    }
    return false;
  }

}
