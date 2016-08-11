<?php

namespace RabbitCMS\Forms;

use JsonSerializable;
use ReflectionClass;

/**
 * Class Control.
 */
abstract class Control implements JsonSerializable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var array|string[]
     */
    protected $classes = [];

    /**
     * @var string
     */
    protected $rule;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var array;
     */
    protected $options = [];

    /**
     * Control constructor.
     *
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, array $options = [])
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    /**
     * Set control options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (array_key_exists('name', $options)) {
            $this->addClasses($options['name']);
        }

        if (array_key_exists('classes', $options)) {
            $this->addClasses(...(array)$options['classes']);
        }

        if (array_key_exists('rule', $options)) {
            $this->setRule($options['rule']);
        }

        if (array_key_exists('value', $options)) {
            $this->setValue($options['value']);
        }
    }

    /**
     * Add classes to control.
     *
     * @param \string[] ...$classes
     */
    public function addClasses(string ...$classes)
    {
        $this->classes = array_unique(array_merge($this->classes, $classes));
    }

    /**
     * Make control.
     *
     * @param string $name
     * @param array  $options
     *
     * @return Control
     */
    public static function make($name, array $options = []):self
    {
        $class = new ReflectionClass($options['class'] ?? static::class);

        /* @var static $instance */
        $instance = $class->newInstanceWithoutConstructor();
        $instance->setName($name);
        $instance->setOptions($options);

        return $instance;
    }

    /**
     * Get control form.
     *
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * Set control form.
     *
     * @param Form|null $form
     */
    public function setForm(Form $form = null)
    {
        $this->form = $form;
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get validation rule.
     *
     * @return string|null
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set validation rule.
     *
     * @param string|null $rule
     */
    public function setRule(string $rule = null)
    {
        $this->rule = $rule;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return array_merge(
            $this->options,
            [
                'name'    => $this->name,
                'rule'    => $this->rule,
                'classes' => $this->classes,
                'value'   => $this->value,
            ]
        );
    }
}
