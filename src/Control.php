<?php

namespace RabbitCMS\Forms;

abstract class Control
{
    protected $name;

    /**
     * @var Form
     */
    protected $form;

    public function __construct(string $name)
    {

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
}