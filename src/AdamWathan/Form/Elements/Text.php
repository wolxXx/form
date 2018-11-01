<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Text
 *
 * @package AdamWathan\Form\Elements
 */
class Text extends Input
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'text',
    ];


    /**
     * @param string $placeholder
     *
     * @return $this
     */
    public function placeholder($placeholder)
    {
        return $this->setAttribute('placeholder', $placeholder);
    }


    /**
     * @param string $value
     *
     * @return $this
     */
    public function defaultValue($value)
    {
        if (false === $this->hasValue()) {
            $this->setValue($value);
        }

        return $this;
    }


    /**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}
