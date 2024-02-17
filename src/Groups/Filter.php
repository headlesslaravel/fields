<?php

namespace HeadlessLaravel\Fields\Groups;

use Illuminate\Support\Facades\Request;

class Filter extends FieldGroup
{
    public static string $mode = 'update';

    public static function make(array $fields, $data = null): mixed
    {
        $data = $data ?? Request::all();

        // TODO: filter out data that is not in the fields array

        $fields = array_map(function ($field) {
            return is_string($field) ? call_user_func(new $field) : $field;
        }, $fields);

        return static::new()
            ->mode('update')
            ->data($data)
            ->fields($fields)
            ->render();
    }
}
