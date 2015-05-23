<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Illuminate\Support\Collection;
use Symposium\Http\Controllers\BaseController as ParentBaseController;

class BaseController extends ParentBaseController
{
    public function __construct()
    {
        // exit('program oauth');
        $this->beforeFilter(
            'auth'
        );
    }

    protected function quickJsonApiReturn($json, $type)
    {
        if (is_array($json) || is_a($json, Collection::class)) {
            foreach ($json as &$item) {
                $item['type'] = $type;
            }
        } else {
            $json['type'] = $type;
        }

        return [
            'data' => $json
        ];
    }
}
