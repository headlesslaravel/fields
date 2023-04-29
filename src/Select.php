<?php

namespace HeadlessLaravel\Fields;

class Select extends Field
{
    public $components = [
        'index' => 'select-display',
        'show' => 'select-display',
        'create' => 'select-input',
        'edit' => 'select-input',
    ];

    public function placeholder(string $placeholder): Select
    {
        $this->meta('placeholder', $placeholder);

        return $this;
    }

    public function options(array $options): Select
    {
        $this->meta('options', $options);

        return $this;
    }
}
