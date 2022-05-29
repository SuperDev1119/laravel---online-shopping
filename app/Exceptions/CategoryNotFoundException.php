<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryNotFoundException extends ModelNotFoundException {
  public $slug;
  public $brand;
}
