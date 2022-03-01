<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactoriesController extends Controller
{
  public function list()
  {
      return view('factories.list');
  }
}
