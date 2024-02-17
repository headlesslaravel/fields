<?php

namespace HeadlessLaravel\Fields\Views;

use HeadlessLaravel\Fields\Groups\Form;
use Inertia\Inertia;
use Inertia\Response;

class Edit extends View
{
    public function render(): Response
    {
        return Inertia::render('Defaults/Edit', [
            'title' => $this->title,
            'fields' => Form::make($this->fields, $this->data),
            'routes' => $this->routes,
        ])->with($this->with);
    }
}