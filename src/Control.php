<?php

namespace RabbitCMS\Forms;

abstract class Control
{
    protected $name;

    protected $value;

    /**
     * @var Form
     */
    protected $form;

    public function __construct(string $name, string $value = '')
    {
        $this->name = $name;
        $this->value = $value;
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
}
