<?php

namespace HeadlessLaravel\Fields;

class File extends Field
{
    public $components = [
        'index' => 'text',
        'show' => 'text',
        'create' => 'file-input',
        'edit' => 'file-input',
    ];
}
