<?php

namespace RabbitCMS\Forms\Controls;

use Illuminate\Contracts\Support\Htmlable;

/**
 * Class Password.
 */
class Password extends Input
{
    /**
     * @inheritdoc
     */
    protected $type = self::TYPE_PASSWORD;

    /**
     * @inheritdoc
     */
    public function render($value) :Htmlable
    {
        return parent::render('');
    }

    /**
     * @inheritdoc
     */
    public function getValue($new, $old)
    {
        return $new !== '' ? $new : $old;
    }
}
