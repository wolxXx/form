<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Range
 *
 * @package AdamWathan\Form\Elements
 */
class Range extends Input
{
    /**
     * @var array
     */
    protected $attributes = [
        'min'  => 0,
        'max'  => 100,
        'step' => 10,
        'type' => 'range',
    ];


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
