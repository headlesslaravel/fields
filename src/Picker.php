<?php

namespace HeadlessLaravel\Fields;

class Picker extends Field
{
    public $components = [
        'index' => 'text',
        'show' => 'text',
        'create' => 'picker-input',
        'edit' => 'picker-input',
    ];

    public function route(string $route): Picker
    {
        $this->meta('url', route($route));

        return $this;
    }

    public function url(string $url): Picker
    {
        $this->meta('url', $url);

        return $this;
    }
}
