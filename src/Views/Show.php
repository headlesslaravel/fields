<?php

namespace HeadlessLaravel\Fields\Views;

use HeadlessLaravel\Fields\Groups\Content;
use Inertia\Inertia;
use Inertia\Response;

class Show extends View
{
    public array $fields = [];

    public mixed $data = [];

    public function render(): Response
    {
        return Inertia::render('Defaults/Show', [
            'title' => $this->title,
            'fields' => Content::make($this->fields, $this->data),
            'routes' => $this->routes,
        ])->with($this->with);
    }
}