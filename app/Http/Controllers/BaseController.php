<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    public function handle($view, $return, $errors = [], $data = [], $callback = null)
    {
        foreach ($return as $k => $r) {
            if (! (is_array($r) && isset($r['status'], $r['response']))) {
                continue;
            }

            if (isset($r['status'])) {
                if (isset($errors[$r['status']['code']])) {
                    if (gettype($errors[$r['status']['code']]) != 'object') {
                        $return['errors'][$k] = ['code' => $r['status']['code'], 'error' => $errors[$r['status']['code']]];
                    } else {
                        return $errors[$r['status']['code']]();
                    }
                }

                if (! isset($return['errors'][$k])) {
                    $return['errors'][$k] = ['code' => $r['status']['code']];
                }
            }

            $return[$k] = isset($r['response']) ? $r['response'] : $r;
        }

        if (isset($data)) {
            $return = array_merge($return, $data);
        }

        return response()->view($view, ['data' => $return]);
    }
}
