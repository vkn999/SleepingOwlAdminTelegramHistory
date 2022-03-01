<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Setting;

class SettingsComposer
{
    public function compose(View $view)
    {
      $collection = Setting::get();
      $setting = $collection->mapWithKeys(function ($item) {
        return [$item['code'] => $item['value']];
      });
        $view -> with('setting', $setting);
    }
}
