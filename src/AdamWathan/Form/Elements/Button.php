<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Button
 *
 * @package AdamWathan\Form\Elements
 */
class Button extends FormControl
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'button',
    ];

    /**
     * @var mixed
     */
    protected $value;


    /**
     * Button constructor.
     *
     * @param mixed         $value
     * @param string | null $name
     */
    public function __construct($value, $name = null)
    {
        parent::__construct($name);
        $this->value($value);
    }


    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }


    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<button%s>%s</button>', $this->renderAttributes(), $this->value);
    }
}
