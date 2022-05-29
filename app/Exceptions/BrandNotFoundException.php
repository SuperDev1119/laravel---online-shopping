<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandNotFoundException extends ModelNotFoundException {
  public $slug;
}
