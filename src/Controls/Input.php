<?php
namespace RabbitCMS\Forms\Controls;

use RabbitCMS\Forms\Control;

class Input extends Control
{
    const TYPE_TEXT     = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO    = 'radio';

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
}
