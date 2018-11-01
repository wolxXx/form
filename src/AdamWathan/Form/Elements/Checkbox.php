<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Checkbox
 *
 * @package AdamWathan\Form\Elements
 */
class Checkbox extends Input
{
    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'checkbox',
    ];

    /**
     * @var bool
     */
    protected $checked;

    /**
     * @var int | mixed
     */
    protected $oldValue;


    /**
     * Checkbox constructor.
     *
     * @param string $name
     * @param int    $value
     */
    public function __construct($name, $value = 1)
    {
        parent::__construct($name);
        $this->setValue($value);
    }


    /**
     * @param bool $state
     *
     * @return $this
     */
    public function defaultCheckedState($state)
    {
        $state ? $this->defaultToChecked() : $this->defaultToUnchecked();

        return $this;
    }


    /**
     * @return $this
     */
    public function defaultToChecked()
    {
        if (!isset($this->checked) && is_null($this->oldValue)) {
            $this->check();
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function check()
    {
        $this->unsetOldValue();
        $this->setChecked(true);

        return $this;
    }


    /**
     * @return $this
     */
    public function unsetOldValue()
    {
        return $this->setOldValue(null);
    }


    /**
     * @param int | mixed $oldValue
     *
     * @return $this
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;

        return $this;
    }


    /**
     * @param bool $checked
     *
     * @return $this
     */
    protected function setChecked($checked = true)
    {
        $this->checked = $checked;
        $this->removeAttribute('checked');
        if ($checked) {
            $this->setAttribute('checked', 'checked');
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function defaultToUnchecked()
    {
        if (!isset($this->checked) && is_null($this->oldValue)) {
            $this->uncheck();
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function uncheck()
    {
        $this->unsetOldValue();
        $this->setChecked(false);

        return $this;
    }


    /**
     * @return string
     */
    public function render()
    {
        $this->checkBinding();

        return parent::render();
    }


    /**
     * @return $this
     */
    protected function checkBinding()
    {
        $currentValue = (string) $this->getAttribute('value');
        $oldValue = $this->oldValue;
        $oldValue = is_array($oldValue) ? $oldValue : [$oldValue];
        $oldValue = array_map('strval', $oldValue);
        if (in_array($currentValue, $oldValue)) {
            return $this->check();
        }

        return $this;
    }
}
