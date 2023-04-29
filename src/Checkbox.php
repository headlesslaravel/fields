<?php

namespace LaravelFields;

class Checkbox extends Field
{
    public $components = [
        'index' => 'boolean-display',
        'show' => 'boolean-display',
        'create' => 'checkbox-input',
        'edit' => 'checkbox-input',
    ];

    public $default = false;
}
