<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use App\Models\Event;
use App\Models\Subject;
use App\Models\Grade;

/**
 * Class Olimpiads
 *
 * @property \App\Models\Olimpiad $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Olimpiads extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = "Олим. по предметам";

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = \AdminDisplay::datatables();

        $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                \AdminColumn::text('id', '#')->setWidth('10px'),
                \AdminColumn::relatedLink('event.name', 'Олимпиада'),
                \AdminColumn::relatedLink('subject.name', 'Предмет'),
                \AdminColumn::relatedLink('grade.name', 'Тип'),
                \AdminColumn::text('grades_numbers', 'Класы')
            )->setColumnFilters([
                null,
                \AdminColumnFilter::select(new Event, 'Олимпиада')->setDisplay('name')->setPlaceholder('Выберите олимпиаду')->setColumnName('event_id'),
            ])->setPlacement('panel.heading');

        return $display->paginate(25);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $tabs = \AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) {
            $tabs = [];
            $tabs = [
                \AdminDisplay::tab(\AdminForm::elements([
                    \AdminFormElement::select('event_id', 'Олимпиада')
                        ->setModelForOptions(Event::class)
                        ->setDisplay('name')->required(),
                    \AdminFormElement::select('subject_id', 'Предмет')
                        ->setModelForOptions(Subject::class)
                        ->setDisplay('name')->required(),
                    \AdminFormElement::select('grade_id', 'Тип')
                        ->setModelForOptions(Grade::class)
                        ->setDisplay('name')->required(),
                    \AdminFormElement::multiselect('grades_numbers', 'Класы')
                        ->setOptions([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11])
                        ->setDisplay('name')->required(),

                        
                    \AdminFormElement::text('subject_short_note', 'Сокращение для класов. (1-5), (1,3,5), (10)'),
                    \AdminFormElement::number('cost_old', 'Старая цена')->setDefaultValue(3)->required(),
                    \AdminFormElement::number('cost', 'Новая цена')->required(),
                    \AdminFormElement::number('teacher_fee', 'Плата учителя')->required(),
                    \AdminFormElement::number('students_count_default', 'Количество студентов по умолчанию')->required(),
                    \AdminFormElement::text('free_for_students_count_to', 'Бесплатная для N учеников (если поле постое то платная)'),
                    \AdminFormElement::textarea('subject_note', 'Описание')
                ]))->setLabel('Основная информация'),
                \AdminDisplay::tab(\AdminForm::elements([
                    \AdminFormElement::file('tasks', 'Задание')->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'files/tasks'; // public/files
                    }),
                    // \AdminFormElement::number('answer1', 'Ответ на 1й вопрос')->required(),
                    // \AdminFormElement::number('answer2', 'Ответ на 2й вопрос')->required(),
                    // \AdminFormElement::number('answer3', 'Ответ на 3й вопрос')->required(),
                    // \AdminFormElement::number('answer4', 'Ответ на 4й вопрос')->required(),
                    // \AdminFormElement::number('answer5', 'Ответ на 5й вопрос')->required(),
                    // \AdminFormElement::number('answer6', 'Ответ на 6й вопрос')->required(),
                    // \AdminFormElement::number('answer7', 'Ответ на 7й вопрос')->required(),
                    // \AdminFormElement::number('answer8', 'Ответ на 8й вопрос')->required(),
                    // \AdminFormElement::number('answer9', 'Ответ на 9й вопрос')->required(),
                    // \AdminFormElement::number('answer10', 'Ответ на 10й вопрос')->required(),
                ]))->setLabel('Задание и ответы')
            ];
            return $tabs;
        });


        $form = \AdminForm::panel()
            ->setElements([$tabs]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        $form = \AdminForm::panel()->addBody([
            
            \AdminFormElement::select('event_id', 'Олимпиада')
                ->setModelForOptions(Event::class)
                ->setDisplay('name')->required(),
            \AdminFormElement::select('subject_id', 'Предмет')
                ->setModelForOptions(Subject::class)
                ->setDisplay('name')->required(),
            \AdminFormElement::select('grade_id', 'Тип')
                ->setModelForOptions(Grade::class)
                ->setDisplay('name')->required(),
            \AdminFormElement::multiselect('grades_numbers', 'Класы')
                ->setOptions(Grade::GRADES_NUMBERS)
                ->setDisplay('name')->required(),

            \AdminFormElement::file('tasks', 'Задание')->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                return 'files/tasks'; // public/files
            }),

            \AdminFormElement::text('subject_short_note', 'Сокращение для класов. (1-5), (1,3,5), (10)'),
            \AdminFormElement::text('free_for_students_count_to', 'Бесплатная для N учеников (если поле постое то платная)'),
            \AdminFormElement::textarea('subject_note', 'Описание')
        ]);

        return $form;
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
