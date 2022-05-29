<?php

namespace App\Models;

use Log;

abstract class ModelFromGoogle
{
    protected static $fields = [];

    public static function afterSave() {}

    public function __construct($values = [])
    {
        foreach (static::$fields as $field_name) {
            if (array_key_exists($field_name, $values)) {
                $this->{$field_name} = $values[$field_name];
            }
        }
    }

    public static function find($idenfitier)
    {
        $class_name = get_called_class();
        Log::info("${class_name}::find($idenfitier)");

        return @static::all()[$idenfitier];
    }

    public static function all($flatten = false)
    {
        $class_name = get_called_class();
        Log::info("${class_name}::all()");

        $has_a_custom_function_to_save_tuples = isset(static::$fn_to_save_tuple) && method_exists($class_name, static::$fn_to_save_tuple);
        $tuples_as_array = DataFromGoogle::csv(env(static::ENV_NAME_FOR_URL));

        $tuples = [];
        foreach ($tuples_as_array as $tuple) {
            try {
                $instance = new $class_name($tuple);
            } catch (\Exception $e) {
                continue;
            }

            if (true === $flatten) {
                $tuples[] = $instance;
            } elseif (isset(static::$tuple_key)) {
                $tuples[$tuple[static::$tuple_key]] = $instance;
            } elseif ($has_a_custom_function_to_save_tuples) {
                $fn = static::$fn_to_save_tuple;
                static::$fn($tuples, $tuple);
            } else {
                $tuples[] = $instance;
            }
        }

        return $tuples;
    }
}
