<?php

namespace LaravelFields;

use Illuminate\Support\Str;

class Count extends Field
{
    public static function make($label, $key = null): Field
    {
        if(is_null($key)) {
            $key = Str::snake($label) . '_count';
        }

        return parent::make($label, $key);
    }
}
