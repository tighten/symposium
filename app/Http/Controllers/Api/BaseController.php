<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Response;
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
        $response = [];
        if (is_array($json) || is_a($json, Collection::class)) {
            foreach ($json as $item) {
                $response[] = $this->jsonApiIfyObject($item, $type);
            }
        } else {
            $response = $this->jsonApiIfyObject($json, $type);
        }

        return response()->jsonApi([
            'data' => $response
        ]);
    }

    private function jsonApiIfyObject($object, $type)
    {
        $return = [
            'type' => $type,
            'id' => $object->id,
            'attributes' => $object->toArray()
        ];

        // Just to get our tests working.
        unset($return['attributes']['id']);
        unset($return['attributes']['user_id']);
        unset($return['attributes']['author_id']);
        unset($return['attributes']['talk_version_id']);

        return $return;
    }
}
