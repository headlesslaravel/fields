<?php

namespace LaravelFields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class Fields
{
    protected array $fields = [];

    protected mixed $data = null;

    protected string $mode = 'form';

    public static function new(): self
    {
        return new self();
    }

    public static function for($mode): self
    {
        return static::new()->mode($mode);
    }

    public function mode($mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function make(array $fields, $data = null): mixed
    {
        return $this
            ->data($data)
            ->fields($fields)
            ->render();
    }

    public static function form(array $fields, $data = null): mixed
    {
        return static::new()
            ->mode('create')
            ->data($data)
            ->fields($fields)
            ->render();
    }

    public static function display(array $fields, $data = null): mixed
    {
        return static::new()
            ->mode('show')
            ->data($data)
            ->fields($fields)
            ->render();
    }

    public static function filter(array $filters, $data = null): mixed
    {
        $data = $data ?? Request::all();

        $filters = array_map(function ($filter) {
            return is_string($filter) ? call_user_func(new $filter): $filter;
        }, $filters);

        return static::new()
            ->mode('create')
            ->data($data)
            ->fields($filters)
            ->render();
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
            $field->setMode($this->mode);
            $field->detectComponent();

            if (isset($field->default)) {
                $field->value($field->default);
            }

            $field->rendering();
            if($field->skip) continue;
            $fields[] = $field->toArray();
        }

        return $fields;
    }

    protected function mapModel(): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            /** @var Field $field */

            if(isset($field->meta['fields'])) {
                if($output = $this->renderNestedField($field, $this->data)) {
                    $fields[] = $output;
                }
            } else {
                if($output = $this->renderField($field, $this->data)) {
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
                if($output = $this->renderField($field, $row)) {
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
        $field->setMode($this->mode);
        $field->setData($data);
        $field->value(data_get($data, $field->key));
        $field->detectComponent();
        $field->rendering();

        if($field->skip) {
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
