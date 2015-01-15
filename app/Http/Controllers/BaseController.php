<?php namespace SaveMyProposals\Http\Controllers;

use SaveMyProposals\Http\Controllers\Controller;
use View;

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
