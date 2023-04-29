<?php

namespace LaravelFields;

class Repeat extends Field
{
    public $component = 'repeat';

    public function rendering(): void
    {
        $this->meta('fullWidth', true);
    }
}
