<?php

namespace HeadlessLaravel\Fields;

class Link extends Field
{
    public $route;

    public $routeKey;

    public function route($route, $key)
    {
        $this->route = $route;
        $this->routeKey = $key;

        return $this;
    }

    public function rendering(): void
    {
        if (is_array($this->routeKey)) {
            // do something where the key is the param name and the value is the data_get from $all
        }

        $this->meta('href', route($this->route, data_get($this->data, $this->routeKey)));
    }
}
