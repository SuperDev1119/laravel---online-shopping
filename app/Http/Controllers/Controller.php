<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as RootController;

abstract class Controller extends RootController
{
    use ValidatesRequests;
}
