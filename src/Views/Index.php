<?php

namespace HeadlessLaravel\Fields\Views;

use HeadlessLaravel\Fields\Groups\Content;
use HeadlessLaravel\Fields\Groups\Form;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class Index extends View
{
    public array $filters = [];

    public static function new(string $key = null): static
    {
        $self = (new self());

        if(!is_null($key)) {
            $self->title(Str::title($key));
            $self->route('create', "$key.create");
            $self->route('show', "$key.show");
        }

        return $self;
    }

    public function render(): Response
    {
        return Inertia::render('Defaults/Index', [
            'title' => $this->title,
            'fields' => Content::make($this->fields, $this->data),
            'filters' => Form::make($this->filters, Request::all()),
            'routes' => $this->routes,
        ])->with($this->with);
    }

    public function filters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }
}