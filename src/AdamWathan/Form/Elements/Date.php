<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Date
 *
 * @package AdamWathan\Form\Elements
 */
class Date extends Text
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'date',
    ];


    /**
     * @inheritdoc
     */
    public function defaultValue($value)
    {
        if (false === $this->hasValue()) {
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d');
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
            $value = $value->format('Y-m-d');
        }

        return parent::value($value);
    }
}
