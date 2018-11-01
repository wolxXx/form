<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Select
 *
 * @package AdamWathan\Form\Elements
 */
class Select extends FormControl
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $selected;


    /**
     * Select constructor.
     *
     * @param string $name
     * @param array  $options
     */
    public function __construct($name, $options = [])
    {
        parent::__construct($name);
        $this->setOptions($options);
    }


    /**
     * @param array $options
     *
     * @return $this
     */
    protected function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }


    /**
     * @param array $options
     *
     * @return $this
     */
    public function options($options)
    {
        return $this->setOptions($options);
    }


    /**
     * @inheritdoc
     */
    public function render()
    {
        return implode([
            sprintf('<select%s>', $this->renderAttributes()),
            $this->renderOptions(),
            '</select>',
        ]);
    }


    /**
     * @return string
     */
    protected function renderOptions()
    {
        list($values, $labels) = $this->splitKeysAndValues($this->options);
        $tags = array_map(function ($value, $label) {
            if (is_array($label)) {
                return $this->renderOptGroup($value, $label);
            }

            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode($tags);
    }


    /**
     * @param string $label
     * @param array  $options
     *
     * @return string
     */
    protected function renderOptGroup($label, $options)
    {
        list($values, $labels) = $this->splitKeysAndValues($options);
        $options = array_map(function ($value, $label) {
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode([
            sprintf('<optgroup label="%s">', $label),
            implode($options),
            '</optgroup>',
        ]);
    }


    /**
     * @param string $value
     * @param string $label
     *
     * @return string
     */
    protected function renderOption($value, $label)
    {
        return vsprintf('<option value="%s"%s>%s</option>', [
            $this->escape($value),
            $this->isSelected($value) ? ' selected' : '',
            $this->escape($label),
        ]);
    }


    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isSelected($value)
    {
        return in_array($value, (array) $this->selected);
    }


    /**
     * @param string $value
     * @param string $label
     *
     * @return $this
     */
    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }


    /**
     * @param string $value
     *
     * @return $this
     */
    public function defaultValue($value)
    {
        if (isset($this->selected)) {
            return $this;
        }

        return $this->select($value);
    }


    /**
     * @param string $option
     *
     * @return $this
     */
    public function select($option)
    {
        $this->selected = $option;

        return $this;
    }


    /**
     * @return $this
     */
    public function multiple()
    {
        $name = $this->attributes['name'];
        if (substr($name, -2) != '[]') {
            $name .= '[]';
        }

        return $this
            ->setName($name)
            ->setAttribute('multiple', 'multiple')
            ;
    }
}
