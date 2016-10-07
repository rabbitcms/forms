<?php

namespace RabbitCMS\Forms;

use Illuminate\Contracts\Support\Htmlable;
use JsonSerializable;
use ReflectionClass;

/**
 * Class Control.
 */
abstract class Control implements JsonSerializable
{
    /**
     * Element name.
     *
     * @var string
     */
    protected $name;

    /**
     * Element default value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Element classes.
     *
     * @var array|string[]
     */
    protected $classes = [];

    /**
     * Element validation rule.
     *
     * @var string
     */
    protected $rule;

    /**
     * Element validation messages.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Element label name.
     *
     * @var string
     */
    protected $label;

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
     * Add classes to control.
     *
     * @param \string[] ...$classes
     */
    public function addClasses(string ...$classes)
    {
        $this->classes = array_unique(array_merge($this->classes, $classes));
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
     * @param ControlCollection|null $form
     */
    public function setForm(ControlCollection $form = null)
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
     * @param mixed $new
     * @param mixed $old
     *
     * @return mixed
     */
    public function getValue($new, $old)
    {
        return $new;
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
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set control options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (array_key_exists('name', $options)) {
            $this->setName($options['name']);
        }

        if (array_key_exists('classes', $options)) {
            $this->addClasses(...(array)$options['classes']);
        }

        if (array_key_exists('rule', $options)) {
            $this->setRule($options['rule']);
        }

        /*if (array_key_exists('value', $options)) {
            $this->setValue($options['value']);
        }*/

        if (array_key_exists('messages', $options)) {
            $this->setMessages($options['messages']);
        }

        if (array_key_exists('label', $options)) {
            $this->setLabel($options['label']);
        }

        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return array_merge(
            $this->options,
            [
                'class'    => static::class,
                'name'     => $this->name,
                'rule'     => $this->rule,
                'classes'  => $this->classes,
                'value'    => $this->value,
                'label'    => $this->label,
                'messages' => $this->messages,
            ]
        );
    }

    /**
     * @param mixed $value
     *
     * @return Htmlable
     */
    abstract public function render($value) :Htmlable;
}
