<?php
declare(strict_types=1);

namespace RabbitCMS\Forms\Controls;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use RabbitCMS\Forms\Control;
use RabbitCMS\Forms\ControlCollection;

class InputGroup extends Control
{
    public const POSITION_BEFORE = 'before';
    public const POSITION_AFTER = 'after';

    public const TYPE_ICON = 'icon';
    public const TYPE_BUTTON = 'button';

    /**
     * @var Control
     */
    private $control;

    /**
     * @var string
     */
    private $position = self::POSITION_BEFORE;
    /**
     * @var string
     */
    private $type = self::TYPE_ICON;

    private $icon = 'fa-envelope-o';

    /**
     * InputGroup constructor.
     *
     * @param Control $control
     * @param array   $options
     */
    public function __construct(Control $control, array $options = [])
    {
        parent::__construct('', $options);
        $this->control = $control;
    }

    /**
     * Set control options.
     *
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options): Control
    {
        if (array_key_exists('type', $options)) {
            $this->setType($options['type']);
        }

        if (array_key_exists('icon', $options)) {
            $this->setIcon($options['icon']);
        }

        if (array_key_exists('position', $options)) {
            $this->setPosition($options['position']);
        }

        return parent::setOptions($options);
    }

    /**
     * Set control form.
     *
     * @param ControlCollection|null $form
     *
     * @return static
     */
    public function setForm(ControlCollection $form = null): Control
    {
        $this->control->setForm($form);

        return parent::setForm($form);
    }

    /**
     * @param mixed $value
     *
     * @return Htmlable
     */
    public function render($value): Htmlable
    {
        $attributes = '';
        foreach ($this->attributes as $key => $val) {
            $attributes .= " {$key}=\"{$val}\"";
        }

        $classes = implode(' ', $this->classes);
        return new HtmlString(
            "<div class=\"input-group {$classes}\"{$attributes}>" .
            ($this->position === self::POSITION_BEFORE ? $this->renderAdditional() : '') .
            $this->control->render($value)->toHtml() .
            ($this->position === self::POSITION_AFTER ? $this->renderAdditional() : '') .
            '</div>'
        );
    }

    protected function renderAdditional(): string
    {
        switch ($this->type) {
            case self::TYPE_ICON:
                return "<span class=\"input-group-addon\"><i class=\"fa {$this->icon}\"></i></span>";
            case self::TYPE_BUTTON:
                return "<span class=\"input-group-btn\"><button class=\"btn default\" type = \"button\"><i class=\"fa {$this->icon}\"></i></button></span>";
        }
    }

    /**
     * @param string $position
     *
     * @return static
     */
    public function setPosition(string $position): InputGroup
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type): InputGroup
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return InputGroup
     */
    public function setIcon(string $icon): InputGroup
    {
        $this->icon = $icon;
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
        return $this->control->getValue($new, $old);
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->control->getDefaultValue();
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): Control
    {
        $this->control->setValue($value);

        return $this;
    }

    /**
     * Get validation rule.
     *
     * @return string|null
     */
    public function getRule()
    {
        return $this->control->getRule();
    }

    /**
     * Set validation rule.
     *
     * @param string|array|null $rule
     *
     * @return static
     */
    public function setRule($rule = null): Control
    {
        $this->control->setRule($rule);

        return $this;
    }
}