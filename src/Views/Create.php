<?php

namespace HeadlessLaravel\Fields\Views;

use HeadlessLaravel\Fields\Groups\Form;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class Create extends View
{
    public string $title = '';

    public array $routes = [];

    public array $fields = [];

    public static function new(string $key = null): static
    {
        $self = (new self());

        if(!is_null($key)) {
            $self->title(Str::title($key));
            $self->route('cancel', "$key.index");
            $self->route('store', "$key.store");
        }

        return $self;
    }

    public function render(): Response
    {
        return Inertia::render('Defaults/Create', [
            'title' => $this->title,
            'fields' => Form::make($this->fields),
            'routes' => $this->routes,
        ])->with($this->with);
    }
}