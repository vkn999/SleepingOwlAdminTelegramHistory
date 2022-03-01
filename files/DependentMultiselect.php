<?php

namespace Falur\Laravel\SleepingOwlElements\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SleepingOwl\Admin\Form\Element\DependentSelect;

class DependentMultiselect extends DependentSelect
{
    /**
     * @var bool
     */
    protected $deleteRelatedItem = false;

    /**
     * @return bool
     */
    public function isDeleteRelatedItem()
    {
        return $this->deleteRelatedItem;
    }

    /**
     * @return $this
     */
    public function deleteRelatedItem()
    {
        $this->deleteRelatedItem = true;

        return $this;
    }

    public function toArray()
    {
        $attrs = parent::toArray();
        $attrs['name'] = $attrs['name'] . '[]';
        $attrs['attributes']['multiple'] = true;

        return $attrs;
    }

    /**
     * @return array
     */
    public function getValueFromModel()
    {
        $value = parent::getValueFromModel();

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $val;
            }
        }

        if ($value instanceof Collection && $value->count() > 0) {
            $value = $value->pluck($value->first()->getKeyName())->all();
        }

        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        return $value;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function save(\Illuminate\Http\Request $request)
    {
        if (is_null($this->getModelForOptions())) {
            parent::save($request);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function afterSave(\Illuminate\Http\Request $request)
    {
        if (is_null($this->getModelForOptions())) {
            return;
        }

        if ($this->isValueSkipped()) {
            return;
        }

        $attribute = $this->getModelAttributeKey();

        if (is_null($request->input($this->getPath()))) {
            $values = [];
        } else {
            $values = $this->getValueFromModel();
        }

        $relation = $this->getModel()->{$attribute}();

        if ($relation instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
            $this->syncBelongsToManyRelation($relation, $values);
        } elseif ($relation instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
            $this->deleteOldItemsFromHasManyRelation($relation, $values);
            $this->attachItemsToHasManyRelation($relation, $values);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation
     * @param array $values
     *
     * @return void
     */
    protected function syncBelongsToManyRelation(
        \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation,
        array $values
    ) {
        $relation->sync($values);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\HasMany $relation
     * @param array $values
     */
    protected function deleteOldItemsFromHasManyRelation(
        \Illuminate\Database\Eloquent\Relations\HasMany $relation,
        array $values
    ) {
        $items = $relation->get();

        foreach ($items as $item) {
            if (! in_array($item->getKey(), $values)) {
                if ($this->isDeleteRelatedItem()) {
                    $item->delete();
                } else {
                    $item->{$this->getForeignKeyNameFromRelation($relation)} = null;
                    $item->save();
                }
            }
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\HasMany $relation
     * @param array $values
     */
    protected function attachItemsToHasManyRelation(
        \Illuminate\Database\Eloquent\Relations\HasMany $relation,
        array $values
    ) {
        foreach ($values as $i => $value) {
            /** @var Model $model */
            $model = clone $this->getModelForOptions();
            $item = $model->find($value);

            if (is_null($item)) {
                $model->{$this->getDisplay()} = $value;
                $item = $model;
            }

            $relation->save($item);
        }
    }
}