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
     * @var string
     */
    protected $name = '';

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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

    public function getValues(array $values, array $old = [])
    {
        $result = $old;

        foreach ($this->controls as $control) {
            $name = $control->getName();
            if (array_key_exists($name, $values)) {
                $result[$name] = $control->getValue($values[$name], $old[$name] ?? '');
            }
        }

        return $result;
    }
}
