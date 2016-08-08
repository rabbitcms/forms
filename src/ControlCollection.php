<?php

namespace RabbitCMS\Forms;

use Countable;
use Iterator;
use JsonSerializable;

/**
 * Class ControlCollection.
 */
class ControlCollection implements Iterator, Countable, JsonSerializable
{
    /**
     * @var array|Control[]
     */
    protected $controls = [];

    /**
     * Add controls to form.
     *
     * @param Control[] ...$controls
     */
    public function addControl(Control ...$controls)
    {
        foreach ($controls as $control) {
            $control->setForm($this);
            $this->controls[] = $control;
        }
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        next($this->controls);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->controls);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->current() !== null;
    }

    /**
     * {@inheritdoc}
     * @return Control
     */
    public function current()
    {
        return current($this->controls) ?: null;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->controls);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->controls);
    }

    /**
     * {@inheritdoc}
     * @return array|Control[]
     */
    public function jsonSerialize()
    {
        return $this->controls;
    }

    /**
     * Get all controls as array.
     *
     * @return array|Control[]
     */
    public function all()
    {
        return $this->controls;
    }
}
