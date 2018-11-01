<?php

namespace AdamWathan\Form\Elements;

/**
 * Class TextArea
 *
 * @package AdamWathan\Form\Elements
 */
class TextArea extends FormControl
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'rows' => 10,
        'cols' => 50,
    ];

    /**
     * @var string
     */
    protected $value;


    /**
     * @inheritdoc
     */
    public function render()
    {
        return implode([
            sprintf('<textarea%s>', $this->renderAttributes()),
            $this->escape($this->value),
            '</textarea>',
        ]);
    }


    /**
     * @param int $rows
     *
     * @return $this
     */
    public function rows($rows)
    {
        return $this->setAttribute('rows', $rows);
    }


    /**
     * @param int $cols
     *
     * @return $this
     */
    public function cols($cols)
    {
        return $this->setAttribute('cols', $cols);
    }


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
            $this->value($value);
        }

        return $this;
    }


    /**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->value);
    }


    /**
     * @param string $value
     *
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }
}
