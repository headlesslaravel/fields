<?php

namespace HeadlessLaravel\Fields\Groups;

use HeadlessLaravel\Fields\Abstract\Fields;
use HeadlessLaravel\Fields\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FieldGroup
{
    protected array $fields = [];

    protected mixed $data = null;

    protected static string $mode = 'create';

    public static function new(): static
    {
        return new static();
    }

    public static function using(string $class, mixed $data = null): array
    {
        /** @var Fields $class */
        $class = new $class();

        return static::new()->make($class->getFields(self::$mode), $data);
    }

    public static function for($mode): self
    {
        return static::new()->mode($mode);
    }

    public function mode($mode): self
    {
        self::$mode = $mode;

        return $this;
    }

    public function fields(array $fields): self
    {
        $this->fields = array_merge($this->fields, $fields);

        return $this;
    }

    public function data(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function render(): mixed
    {
        if ($this->data instanceof Model || is_array($this->data)) {
            return $this->mapModel();
        } elseif ($this->data instanceof LengthAwarePaginator) {
            return $this->mapPaginator();
        } elseif ($this->data instanceof Collection) {
            return $this->mapCollection();
        } else {
            return $this->mapDefault();
        }
    }

    public function mapDefault(): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            /** @var Field $field */
            $field->setMode(self::$mode);
            $field->detectComponent();

            if (isset($field->default)) {
                $field->value($field->default);
            }

            $field->rendering();
            if ($field->skip) {
                continue;
            }
            $fields[] = $field->toArray();
        }

        return $fields;
    }

    protected function mapModel(): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            /** @var Field $field */
            if (isset($field->meta['fields'])) {
                if ($output = $this->renderNestedField($field, $this->data)) {
                    $fields[] = $output;
                }
            } else {
                if ($output = $this->renderField($field, $this->data)) {
                    $fields[] = $output;
                }
            }
        }

        return $fields;
    }

    protected function mapCollection(): Collection
    {
        return $this->data->map(function ($row) {
            $fields = [];

            foreach ($this->fields as $field) {
                /** @var Field $field */
                if ($output = $this->renderField($field, $row)) {
                    $fields[] = $output;
                }
            }

            return $fields;
        });
    }

    protected function mapPaginator()
    {
        $collection = $this->data->getCollection();

        $paginator = $this->data;

        $this->data = $collection;

        return $paginator->setCollection($this->mapCollection());
    }

    private function renderField(Field $field, $data): ?array
    {
        $field->setMode(self::$mode);
        $field->setData($data);
        $field->value(data_get($data, $field->key));
        $field->detectComponent();
        $field->rendering();

        if ($field->skip) {
            return null;
        }

        return $field->toArray();
    }

    private function renderNestedField(Field $field, $data): array
    {
        $fields = [];

        $dataSets = data_get($data, $field->key, []);

        //        TODO: make work with eloquent models
        // Panel::make()->fields(['name', 'email'])->data($user)
        //        if($dataSets instanceof Model) {
        //            $dataSets = $dataSets->toArray();
        //        }

        foreach ($dataSets as $index => $dataItem) {
            foreach ($field->meta['fields'] as $fieldTemplate) {
                $nestedField = clone $fieldTemplate;
                $field->rendering();
                if ($output = $this->renderField($nestedField, $dataItem)) {
                    $fields[$index][] = $output;
                }
            }
        }

        return $field->meta('rendered', $fields)->toArray();
    }

    // mine
    //    private function mapNestedFields(Field $field): array
    //    {
    //        $fields = [];
    //
    //        foreach($field->meta['fields'] as $nestedField) {
    //            $dataSets = data_get($this->data, $field->key);
    //            foreach($dataSets as $index => $data) {
    //                $nestedField->key = "$field->key.$index.$nestedField->key";
    //
    //                if($output = $this->renderField($nestedField, $this->data)) {
    //                    $fields[] = $output;
    //                }
    //            }
    //        }
    //
    //        return $fields;
    //    }
}
