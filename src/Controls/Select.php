<?php

namespace RabbitCMS\Forms\Controls;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use RabbitCMS\Forms\Control;

/**
 * Class Select.
 */
class Select extends Control
{
    /**
     * @inheritdoc
     */
    public function render($value) :Htmlable
    {
        $prefix = $this->form->getName();
        if ($prefix) {
            $name = $prefix . '[' . $this->getName() . ']';
        } else {
            $name = $this->getName();
        }

        $attributes = '';
        foreach ($this->attributes as $key => $val) {
            $attributes .= $key . '="' . $val . '" ';
        }

        return new HtmlString(
            '<select class="form-control ' . implode(' ', $this->classes) . '" ' . $attributes . ' name="' . $name . '">' . $this->renderItems($this->options['items'], $value) . '</select>'
        );
    }

    protected function renderItems(array $items, string $selected) :Htmlable
    {
        $options = '';
        foreach ($items as $value => $text) {
            $options .= '<option value="' . $value . '"' . ($value === $selected ? ' selected' : '') . '>' . e($text) . '</option>';
        }

        return new HtmlString($options);
    }
}
