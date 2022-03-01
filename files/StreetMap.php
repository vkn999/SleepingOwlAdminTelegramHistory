<?php

namespace App\Admin\Form;

use SleepingOwl\Admin\Form\Element\NamedFormElement;

class StreetMap extends NamedFormElement
{

  public function render() {
    return view('admin.element.streetmap', $this->toArray())->render();
  }
}
