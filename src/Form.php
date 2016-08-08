<?php

namespace RabbitCMS\Forms;

class Form extends ControlCollection
{
    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';

    const ENCTYPE_URLENCODED = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTIPART  = 'multipart/form-data';

    protected $action;

    protected $method;

    protected $encType;

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
}
