<?php

namespace LaravelFields;

class Panel extends Field
{
    public $component = 'panel';

    public function rendering(): void
    {
        $this->meta('fullWidth', true);
    }
}
