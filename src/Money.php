<?php

namespace HeadlessLaravel\Fields;

class Money extends Field
{
    public function renderValue($value): mixed
    {
        return '$'.number_format($value, 2);
    }
}
