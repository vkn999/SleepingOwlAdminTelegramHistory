<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\FormButton;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Section;

class UnknownData extends Section implements Initializable
{

    public function initialize()
    {
        $this->addToNavigation(100, function () {
            return \App\UnknownData::count();
        });
    }


    public function getTitle()
    {
        return trans('Неизвестные');
    }


    public function getUpdateUrl($id)
    {
        return route('admin.unknown.save', [$id]);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = \AdminForm::form()->setElements([

        ]);

        $form->getButtons()->replaceButtons(['save' => (new SaveAndClose())->setText('Сохранить')]);

        return $form;
    }

}
