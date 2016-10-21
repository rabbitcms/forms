<?php
namespace RabbitCMS\Forms\Controls;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use RabbitCMS\Forms\Control;

/**
 * Class Input.
 */
class Input extends Control
{
    const TYPE_TEXT     = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO    = 'radio';

    /**
     * Input type.
     *
     * @var string
     */
    protected $type = self::TYPE_TEXT;

    /**
     * @inheritdoc
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);

        if (array_key_exists('type', $options)) {
            $this->setType($options['type']);
        }
    }

    /**
     * Get input type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set input type.
     *
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

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
            '<input type="' . $this->getType() . '" class="form-control ' . implode(' ', $this->classes) . '" ' . $attributes . ' name="' . $name . '" value="' . e($value) . '" >'
        );
    }
}
