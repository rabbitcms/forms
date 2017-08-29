<?php
declare(strict_types=1);

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
     * @var array
     */
    protected $groups = [];

    /**
     * @var string
     */
    protected $name = '';

    /**
     * ControlCollection constructor.
     *
     * @param array $controls
     *
     * @throws \ReflectionException
     */
    public function __construct(array $controls = [])
    {
        $this->addGroup('*', 'Other', -1);

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
     *
     * @return ControlCollection
     */
    public function addControl(Control ...$controls): ControlCollection
    {
        foreach ($controls as $control) {
            $control->setForm($this);
            $this->controls[] = $control;
        }

        return $this;
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
     * @return ControlCollection
     */
    public function setName(string $name): ControlCollection
    {
        $this->name = $name;

        return $this;
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
    public function valid(): bool
    {
        return $this->current() !== null;
    }

    /**
     * {@inheritdoc}
     *
     * @return Control|null
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
    public function count(): int
    {
        return count($this->controls);
    }

    /**
     * {@inheritdoc}
     *
     * @return array|Control[]
     */
    public function jsonSerialize(): array
    {
        return $this->controls;
    }

    /**
     * Get all controls as array.
     *
     * @return array|Control[]
     */
    public function all(): array
    {
        return $this->controls;
    }

    /**
     * @param array $values
     * @param array $old
     *
     * @return array
     */
    public function getValues(array $values, array $old = []): array
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

    /**
     * @param string $name
     * @param string $label
     * @param int $priority
     *
     * @return ControlCollection
     */
    public function addGroup($name, $label, $priority = 0): ControlCollection
    {
        $this->groups[$name] = compact('label', 'priority');

        return $this;
    }

    /**
     * @return array[]
     */
    public function getGroups(): array
    {
        return collect($this->groups)
            ->sortByDesc('priority')
            ->toArray();
    }

    /**
     * @param string $group
     *
     * @return array
     */
    public function getGroupControls(string $group): array
    {
        return array_filter($this->controls, function (Control $control) use ($group) {
            return $control->getGroup() === $group;
        });
    }

    /**
     * @param $name
     * @param null $type
     *
     * @return mixed|null|Control
     */
    public function getControlByName($name, $type = null)
    {
        foreach ($this->controls as $control) {
            if ($type !== null) {
                if ($control instanceof $type && $control->getName() === $name) {
                    return $control;
                }
            } else {
                if ($control->getName() === $name) {
                    return $control;
                }
            }
        }

        return null;
    }
}
