<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

use \AdminDisplay;
use \AdminSection;
use \AdminColumn;
use \AdminForm;
use \AdminFormElement;
use ModelConfiguration;

/**
 * Class Options
 *
 * @property \App\Options $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Options extends Section implements Initializable
{

    protected $model = '\App\Options';

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Параметры';

    /**
     * @var string
     */
    protected $alias = 'options';

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation(
            500, function(){
                return \App\Options::count();
        });

        $this->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        return AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('title', 'Name'),
                AdminColumn::text('value', 'Value')
            )
            ->setOrder([1, 'ASC'])
            ->paginate(20)
        ;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Name')->required(),
        ]);
    }

    public function onCreate(){
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Name')
        ]);
    }

    /**
     * @return FormInterface
     */
    /*public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }*/


}
