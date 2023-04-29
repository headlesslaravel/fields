<?php

namespace HeadlessLaravel\Fields;

class Text extends Field
{
    public function placeholder($placeholder): self
    {
        $this->prop('placeholder', $placeholder);

        return $this;
    }
}
