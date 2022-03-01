<?php
namespace Modules\Card\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Card\Models\Card;
use Modules\Card\Observers\CardObserver;

class CardServiceProvider extends ServiceProvider
{



  public function boot()
  {
    Card::observe(CardObserver::class);
  }


  public function register()
  {
    // dd('Card provider reg');
  }
}
