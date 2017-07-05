<?php
declare(strict_types=1);

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
     * Element group.
     *
     * @var string
     */
    protected $group;

    /**
     * Element classes.
     *
     * @var array|string[]
     */
    protected $classes = [];

    /**
     * Element attributes.
     *
     * @var array
     */
    protected $attributes = [];

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
     * @param array $options
     *
     * @return Control
     *
     * @throws \ReflectionException
     */
    public static function make($name, array $options = []): self
    {
        $class = new ReflectionClass($options['class'] ?? static::class);

        /* @var static $instance */
        $instance = $class->newInstanceWithoutConstructor();
        $instance->setName($name);
        $instance->setOptions($options);

        return $instance;
    }

    /**
     * @param string[] ...$classes
     *
     * @return Control
     */
    public function addClasses(string ...$classes): self
    {
        $this->classes = array_unique(array_merge($this->classes, $classes));

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return Control
     */
    public function addAttributes(array $attributes): self
    {
        $this->attributes = array_unique(array_merge($this->attributes, $attributes));

        return $this;
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
     *
     * @return Control
     */
    public function setForm(ControlCollection $form = null): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @param string $group
     *
     * @return Control
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
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
     *
     * @return Control
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return Control
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
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
     * @param string|array|null $rule
     *
     * @return Control
     */
    public function setRule($rule = null): self
    {
        $this->rule = $rule;

        return $this;
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
     *
     * @return Control
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
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
     *
     * @return Control
     */
    public function setMessages(array $messages): self
    {
        $this->messages = $messages;

        return $this;
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
     *
     * @return Control
     */
    public function setOptions(array $options): Control
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

        if (array_key_exists('value', $options)) {
            $this->setValue($options['value']);
        }

        if (array_key_exists('messages', $options)) {
            $this->setMessages($options['messages']);
        }

        if (array_key_exists('label', $options)) {
            $this->setLabel($options['label']);
        }

        if (array_key_exists('attributes', $options)) {
            $this->addAttributes((array)$options['attributes']);
        }

        if (array_key_exists('group', $options)) {
            $this->setGroup($options['group']);
        } else {
            $this->setGroup('*');
        }

        $this->options = $options;

        return $this;
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
                'messages' => $this->messages
            ]
        );
    }

    /**
     * @param mixed $value
     *
     * @return Htmlable
     */
    abstract public function render($value): Htmlable;
}
