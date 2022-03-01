<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

use App\User;
use App\Role;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

//use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\Cancel;


class Users extends Section implements Initializable
{
  public function initialize() {
    $this->addToNavigation()
      ->setPriority(1000);
  }

    protected $checkAccess = true;
    protected $alias = 'users';

    public function getIcon() {
        return 'fas fa-users';
    }
    public function getTitle() {
        return 'Пользователи';
    }
    public function getEditTitle() {
        return 'Редактирование пользователя';
    }

    public function onDisplay() {

      $display = AdminDisplay::datatables()
        ->with(['roles'])
        ->setHtmlAttribute('class', 'table-primary table-hover th-center');

      $display->setColumns([
        AdminColumn::text('id', '#')
          ->setWidth('60px')
          ->setHtmlAttribute('class', 'text-center'),
        AdminColumn::link('name', 'Имя', 'username')
          ->setWidth('230px'),
        AdminColumn::text('email', 'Email'),
        AdminColumn::text('roles.description', 'Права')
          ->setWidth('160px')
          ->setOrderable(function($query, $direction) {
            $query->orderBy('role_id', $direction);
          })
          ->setSearchable(false),
        AdminColumn::boolean('active', 'Вход'),
        AdminColumn::datetime('created_at', 'Создан / Изменен', 'updated_at')
          ->setWidth('160px')
          ->setOrderable(function($query, $direction) {
            $query->orderBy('updated_at', $direction);
          })
          ->setSearchable(false),
      ]);

      return $display;
    }


    public function onEdit($id) {
      $form = AdminForm::panel()->addBody([
        AdminFormElement::columns()->addColumn([
          AdminFormElement::text('id', '#')->setReadonly(1),
          AdminFormElement::text('name', 'Имя'),
          AdminFormElement::text('username', 'Логин')->required()->unique(),
          AdminFormElement::text('email', 'Почта')->required()->unique(),
          AdminFormElement::checkbox('active', 'Включен'),
        ], 6)->addColumn([
          AdminFormElement::textarea('info', 'Информация'),
          AdminFormElement::select('role_id', 'Права', Role::class)->setDisplay('description')->required()->setSortable(false),
        ]),
        AdminFormElement::password('newpassword', 'Пароль')->allowEmptyValue(),
      ]);

      $form->getButtons()->setButtons([
        // 'save'  => new Save(),
        'save_and_close'  => new SaveAndClose(),
        'cancel'  => (new Cancel()),
      ]);

      return $form;
    }

    public function onCreate() {
      return $this->onEdit(null);
    }

}
