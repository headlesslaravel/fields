<?php

namespace HeadlessLaravel\Fields\Abstract;

use InvalidArgumentException;

abstract class Fields
{
    public array $formIgnore = [];
    public array $displayIgnore = [];
    public array $indexIgnore = [];
    public array $showIgnore = [];
    public array $createIgnore = [];
    public array $updateIgnore = [];

    public abstract function fields(): array;

    public function getFields(string $mode): array
    {
        $fields = $this->fields();

        $ignoreKeys = match($mode) {
            'index' => $this->indexIgnore,
            'show' => $this->showIgnore,
            'create' => $this->createIgnore,
            'update' => $this->updateIgnore,
            default => throw new InvalidArgumentException("Invalid mode: $mode")
        };

        return array_filter($fields, function($field) use ($ignoreKeys) {
            return !in_array($field->key, $ignoreKeys);
        });
    }

}