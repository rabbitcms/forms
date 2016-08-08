<?php

namespace RabbitCMS\Forms;

use Iterator;

class Form implements Iterator
{
    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';

    const ENCTYPE_URLENCODED = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTIPART  = 'multipart/form-data';

    protected $action;

    protected $method;

    protected $encType;

    protected $controls = [];

    /**
     * Form constructor.
     *
     * @param string $action
     * @param string $method
     * @param string $encType
     */
    public function __construct(string $action = '', string $method = self::METHOD_POST, string $encType = 'application/x-www-form-urlencoded')
    {
        $this->action = $action;
        $this->method = $method;
        $this->encType = $encType;
    }

    /**
     * Get form action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Set form action.
     *
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * Get form encoding type.
     *
     * @return string
     */
    public function getEncType(): string
    {
        return $this->encType;
    }

    /**
     * Set form encoding type.
     *
     * @param string $encType
     */
    public function setEncType(string $encType)
    {
        $this->encType = $encType;
    }

    /**
     * Set form method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get form method.
     *
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
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
}