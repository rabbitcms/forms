<?php
declare(strict_types=1);

namespace RabbitCMS\Forms\Controls;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use RabbitCMS\Forms\Control;

/**
 * Class Select.
 */
class Select extends Control
{
    protected $multiple = false;

    /**
     * Select constructor.
     *
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options = [])
    {
        parent::__construct($name, $options);

        if (array_key_exists('multiple', $options['attributes'] ?? [])) {
            $this->multiple = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function render($value): Htmlable
    {
        $prefix = $this->form->getName();
        if ($prefix) {
            $name = $prefix . '[' . $this->getName() . ']';
        } else {
            $name = $this->getName();
        }

        if ($this->multiple) {
            $name .= '[]';
        }

        $attributes = '';
        foreach ($this->attributes as $key => $val) {
            $attributes .= $key . '="' . $val . '" ';
        }
        $classes = implode(' ', $this->classes);

        return new HtmlString(
            <<<HTML
<select class="form-control {$classes}" {$attributes} 
  name="{$name}">{$this->renderItems($this->options['items'], $value)}</select>
HTML
        );
    }

    /**
     * @param array  $items
     * @param string $current
     *
     * @return Htmlable
     */
    protected function renderItems(array $items, $current): Htmlable
    {
        $options = '';
        foreach ($items as $value => $text) {
            $selected = (($this->multiple && \in_array($value, (array)$current)) || (string)$value === $current)
                ? 'selected' : '';
            $text = e($text);
            $options .= <<<HTML
<option value="{$value}" {$selected}>{$text}</option>
HTML;
        }

        return new HtmlString($options);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->options['items'] ?? [];
    }
}
