<?php

namespace LaravelFields;

class Section extends Field
{
    public $component = 'section';

    public function rendering(): void
    {
        $this->meta('fullWidth', true);
    }

    public function renderValue($value): mixed
    {
        return $this->label;
    }
}
