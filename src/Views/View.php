<?php

namespace HeadlessLaravel\Fields\Views;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class View implements Responsable
{
    public string $title = '';

    public array $routes = [];

    public array $fields = [];

    public mixed $data = [];

    public mixed $with = [];

    public static function new(string $key = null): static
    {
        $self = (new static());

        return $self;
    }

    public function render(): Response
    {
        return Inertia::render('Defaults/Index', [
            'title' => $this->title,
            'routes' => $this->routes,
        ]);
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function route(string $key, string $route): static
    {
        $this->routes[$key] = $route;

        return $this;
    }

    public function fields(array $fields, $data = []): static
    {
        $this->fields = $fields;

        $this->data = $data;

        return $this;
    }

    public function with($key, $value = null): static
    {
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $this->with[$k] = $v;
            }
        } else {
            $this->with[$key] = $value;
        }

        return $this;
    }

    public function toResponse($request): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        return $this->render()->toResponse($request);
    }
}