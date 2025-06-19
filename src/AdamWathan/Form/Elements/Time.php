<?php

namespace AdamWathan\Form\Elements;

/**
 * Class DateTimeLocal
 *
 * @package AdamWathan\Form\Elements
 */
class Time extends Text
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'time',
    ];


    /**
     * @inheritdoc
     */
    public function defaultValue($value)
    {
        if (false === $this->hasValue()) {
            if ($value instanceof \DateTime) {
                $value = $value->format('H:i');
            }
            $this->setValue($value);
        }

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function value($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('H:i');
        }

        return parent::value($value);
    }
}
