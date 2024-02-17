<?php

namespace HeadlessLaravel\Fields\Groups;

class Items extends FieldGroup
{
    public static string $mode = 'index';

    public static function make(array $fields, $data): mixed
    {
        return self::new()
            ->mode(self::$mode)
            ->data($data)
            ->fields($fields)
            ->render();
    }
}
