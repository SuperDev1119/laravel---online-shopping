<?php

namespace App\Models;

class Column
{
    public $name;

    public $is_boolean = false;

    public function __construct($string)
    {
        $this->is_boolean = (false !== strpos($string, '?'));
        $this->name = $this->cleanName($string);
    }

    private function cleanName($name)
    {
        return str_replace(
            [' ', '?'],
            ['_', ''],
            strtolower($name)
        );
    }
}

abstract class DataFromGoogle
{
    private static function parseRow($columns, $row_as_array)
    {
        $result = [];

        foreach ($row_as_array as $index => $value) {
            $column = $columns[$index];

            if (true === $column->is_boolean) {
                $new_value = (bool) ('oui' === $value);
            } else {
                $new_value = trim($value);
                $new_value = ('' == $new_value) ? null : $new_value;
            }

            $result[$column->name] = $new_value;
        }

        return $result;
    }

    public static function csv($google_url)
    {
        if (false === ($handle = fopen($google_url, 'r'))) {
            throw new Exception('Couldt not read file', 1);
        }

        $columns = null;
        $values = [];

        for ($index = 0; ($row_as_array = fgetcsv($handle)) !== false; $index++) {
            if (0 === $index) {
                $columns = array_map(function ($cell_value) {
                    return new Column($cell_value);
                }, $row_as_array);
            } else {
                $values[] = self::parseRow($columns, $row_as_array);
            }
        }

        return $values;
    }
}
