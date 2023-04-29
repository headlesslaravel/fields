<?php

namespace HeadlessLaravel\Fields;

use Illuminate\Support\Str;

class Field
{
    public $key;

    public $label;

    public $value;

    public $props = [];

    public $meta = ['visible' => true];

    public $default;

    public $component;

    public $mode;

    public $data;

    public bool $skip = false;

    public $components = [
        'index' => 'text',
        'show' => 'text',
        'create' => 'text-input',
        'edit' => 'text-input',
    ];

    public function fields(array $fields): Field
    {
        return $this->meta('fields',  $fields);
    }

    public function rendering(): void
    {
        //
    }

    public function hidden(): self
    {
        $this->meta('visible', false);

        return $this;
    }

    public function prop($key, $value): self
    {
        $this->props[$key] = $value;

        return $this;
    }

    public function skip(): Field
    {
        $this->skip = true;

        return $this;
    }

    public function when($mode, $callback): self
    {
        if(is_array($mode) && in_array($this->mode, $mode)) {
            $callback();
        } else if(is_string($mode) && $mode === $this->mode) {
            $callback();
        } else if($mode === true) {
            $callback();
        }

        return $this;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function detectComponent(): void
    {
        if($this->component) {
            return;
        }

        $this->component = $this->components[$this->mode] ?? 'Text';
    }

    public static function make($label, $key = null): Field
    {
        $self = new static();
        $self->key = $key ?? Str::snake($label);
        $self->label = $label;

        return $self;
    }

    public function props($prop): Field
    {
        $this->props = array_merge($this->props, $prop);

        return $this;
    }

    public function meta($key, $value): Field
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function component($component): Field
    {
        $this->component = $component;

        return $this;
    }

    public function value($value = null): self
    {
        $this->value = $this->renderValue($value);

        return $this;
    }

    public function setData($data = null): void
    {
        $this->data = $data;
    }

    public function renderValue($value): mixed
    {
        return $value;
    }

    public function default($default): Field
    {
        $this->default = $default;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'value' => $this->value,
            'component' => $this->component,
            'props' => $this->props,
            'meta' => $this->meta,
        ];
    }
}
