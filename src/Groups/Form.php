<?php

namespace HeadlessLaravel\Fields\Groups;

class Form extends FieldGroup
{
    protected static string $mode = 'create';

    public static function make(array $fields, $data = null): array
    {
        $mode = $data ? 'update' : 'create';

        return self::new()
            ->mode($mode)
            ->data($data)
            ->fields($fields)
            ->render();
    }
}
