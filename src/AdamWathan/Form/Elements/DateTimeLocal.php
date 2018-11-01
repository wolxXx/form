<?php

namespace AdamWathan\Form\Elements;

/**
 * Class DateTimeLocal
 *
 * @package AdamWathan\Form\Elements
 */
class DateTimeLocal extends Text
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'datetime-local',
    ];


    /**
     * @inheritdoc
     */
    public function defaultValue($value)
    {
        if (false === $this->hasValue()) {
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d\TH:i');
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
            $value = $value->format('Y-m-d\TH:i');
        }

        return parent::value($value);
    }
}
