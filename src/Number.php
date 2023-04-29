<?php

namespace LaravelFields;

class Number extends Field
{
    public function rendering(): void
    {
        $this->when('create', function () {
            $this->prop('type', 'number');
        })->when('edit', function() {
            $this->prop('type', 'number');
        });
    }
}
