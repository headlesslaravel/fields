<?php

namespace HeadlessLaravel\Fields;

class Textarea extends Field
{
    public $components = [
        'index' => 'text',
        'show' => 'text',
        'create' => 'textarea-input',
        'edit' => 'textarea-input',
    ];
}
