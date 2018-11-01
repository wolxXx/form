<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Input
 *
 * @package AdamWathan\Form\Elements
 */
abstract class Input extends FormControl
{
    /**
     * @inheritdoc
     */
    public function render()
    {
        return sprintf('<input%s>', $this->renderAttributes());
    }


    /**
     * @inheritdoc
     */
    public function value($value)
    {
        $this->setValue($value);

        return $this;
    }


    /**
     * @param mixed $value
     *
     * @return $this
     */
    protected function setValue($value)
    {
        $this->setAttribute('value', $value);

        return $this;
    }
}
