<?php
namespace Modules\Backup\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use AdminNavigation;

class BackupAdminServiceProvider extends ServiceProvider
{

  protected $sections = [
  ];


  public function boot(\SleepingOwl\Admin\Admin $admin) {
    parent::boot($admin);
    $this->registerRoutes();
    $this->registerNavigation();
  }


  private function registerRoutes() {
    $this->app['router']->group([
      'prefix' => config('sleeping_owl.url_prefix'),
      'namespace' => 'Modules\Backup\Controllers',
      'middleware' => config('sleeping_owl.middleware')],

      function ($router) {
        $router->get('/backup', [
          'as' => 'admin.backup',
          'uses' => 'BackupController@getListFile'
        ]);
        $router->post('/backup', 'BackupController@createBackUp');
        $router->get('/backup/{id}', 'BackupController@downloadBackUp');
        $router->get('/backup/{id}/delete', 'BackupController@deleteBackUp');
    });
  }


  private function registerNavigation() {
    app()->booted(function() {
      $page = AdminNavigation::getPages();
      $addBackup = [
        'title' => 'BackUp',
        'icon'  => 'fas fa-save',
        'url'   => route('admin.backup'),
        'priority' => 10000,
        'accessLogic' => function () {
          return auth()->user()->isAdmin();
        },
      ];

      if ($page->findById('settings')) {
        $page->findById('settings')->addPage($addBackup);
      } else {
        AdminNavigation::setFromArray([$addBackup]);
      }
    });
  }

}
