<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Element
 *
 * @package AdamWathan\Form\Elements
 */
abstract class Element
{
    /**
     * @var array
     */
    protected $attributes = [];


    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }


    /**
     * @param string | string[] $attribute
     * @param mixed | null      $value
     *
     * @return $this
     */
    public function data($attribute, $value = null)
    {
        if (is_array($attribute)) {
            foreach ($attribute as $key => $val) {
                $this->setAttribute('data-' . $key, $val);
            }
        } else {
            $this->setAttribute('data-' . $attribute, $value);
        }

        return $this;
    }


    /**
     * @param string       $attribute
     * @param mixed | null $value
     *
     * @return $this
     */
    protected function setAttribute($attribute, $value = null)
    {
        if (true === is_null($value)) {
            return $this;
        }
        $this->attributes[$attribute] = $value;

        return $this;
    }


    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return $this
     */
    public function attribute($attribute, $value)
    {
        $this->setAttribute($attribute, $value);

        return $this;
    }


    /**
     * @param string $attribute
     *
     * @return $this
     */
    public function clear($attribute)
    {
        if (!isset($this->attributes[$attribute])) {
            return $this;
        }
        $this->removeAttribute($attribute);

        return $this;
    }


    /**
     * @param string $attribute
     *
     * @return $this
     */
    protected function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);

        return $this;
    }


    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass($class)
    {
        if (isset($this->attributes['class'])) {
            $class = $this->attributes['class'] . ' ' . $class;
        }
        $this->setAttribute('class', $class);

        return $this;
    }


    /**
     * @param string $class
     *
     * @return $this
     */
    public function removeClass($class)
    {
        if (false === isset($this->attributes['class'])) {
            return $this;
        }
        $class = trim(str_replace($class, '', $this->attributes['class']));
        if ($class == '') {
            $this->removeAttribute('class');

            return $this;
        }
        $this->setAttribute('class', $class);

        return $this;
    }


    /**
     * @param string $id
     *
     * @return $this
     */
    public function id($id)
    {
        $this->setId($id);

        return $this;
    }


    /**
     * @param string $id
     *
     * @return string
     */
    protected function setId($id)
    {
        return $this->setAttribute('id', $id);
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }


    /**
     * @return string
     */
    abstract public function render();


    /**
     * @param string                        $method
     * @param string | array | mixed | null $params
     *
     * @return $this
     */
    public function __call($method, $params)
    {
        $params = count($params) ? $params : [$method];
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }


    /**
     * @return string
     */
    protected function renderAttributes()
    {
        list($attributes, $values) = $this->splitKeysAndValues($this->attributes);

        return implode(array_map(function ($attribute, $value) {
            return sprintf(' %s="%s"', $attribute, $this->escape($value));
        }, $attributes, $values));
    }


    /**
     * @param array $array
     *
     * @return array
     */
    protected function splitKeysAndValues($array)
    {
        // Disgusting crap because people might have passed a collection
        $keys   = [];
        $values = [];
        foreach ($array as $key => $value) {
            $keys[]   = $key;
            $values[] = $value;
        }

        return [$keys, $values];
    }


    /**
     * @param string $value
     *
     * @return string
     */
    protected function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }


    /**
     * @param string                $attribute
     * @param string | null | mixed $value
     *
     * @return $this
     */
    protected function setBooleanAttribute($attribute, $value)
    {
        if ($value) {
            return $this->setAttribute($attribute, $attribute);
        }

        return $this->removeAttribute($attribute);
    }
}
