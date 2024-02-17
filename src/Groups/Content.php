<?php

namespace HeadlessLaravel\Fields\Groups;

class Content extends FieldGroup
{
    protected static string $mode = 'show';

    public static function make(array $fields, $data): mixed
    {
        return self::new()
            ->mode(self::$mode)
            ->data($data)
            ->fields($fields)
            ->render();
    }
}
