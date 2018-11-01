<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Label
 *
 * @package AdamWathan\Form\Elements
 */
class Label extends Element
{
    /**
     * @var \AdamWathan\Form\Elements\Element
     */
    protected $element;

    /**
     * @var bool
     */
    protected $labelBefore;

    /**
     * @var string
     */
    protected $label;


    /**
     * Label constructor.
     *
     * @param string $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }


    /**
     * @inheritdoc
     */
    public function render()
    {
        $tags = [sprintf('<label%s>', $this->renderAttributes())];
        if ($this->labelBefore) {
            $tags[] = $this->label;
        }
        $tags[] = $this->renderElement();
        if (!$this->labelBefore) {
            $tags[] = $this->label;
        }
        $tags[] = '</label>';

        return implode($tags);
    }


    /**
     * @return string
     */
    protected function renderElement()
    {
        if (!$this->element) {
            return '';
        }

        return $this->element->render();
    }


    /**
     * @param string $name
     *
     * @return $this
     */
    public function forId($name)
    {
        return $this->setAttribute('for', $name);
    }


    /**
     * @param Element $element
     *
     * @return $this
     */
    public function before(Element $element)
    {
        $this->element     = $element;
        $this->labelBefore = true;

        return $this;
    }


    /**
     * @param Element $element
     *
     * @return $this
     */
    public function after(Element $element)
    {
        $this->element     = $element;
        $this->labelBefore = false;

        return $this;
    }


    /**
     * @return Element
     */
    public function getControl()
    {
        return $this->element;
    }
}
