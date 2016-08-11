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
     * ControlCollection constructor.
     *
     * @param array $controls
     */
    public function __construct(array $controls = [])
    {
        foreach ($controls as $name => $control) {
            if (!$control instanceof Control) {
                $control = Control::make($name, $control);
            }
            $this->addControl($control);
        }
    }

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
     * Validation rules
     *
     * @return array
     */
    public function validationRules():array
    {
        $rules = [];

        foreach ($this as $control) {
            $rule = $control->getRule();
            if (!empty($rule)) {
                $rules[$control->getName()] = $control->getRule();
            }
        }
        return $rules;
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
