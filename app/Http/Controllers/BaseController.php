<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }
}
