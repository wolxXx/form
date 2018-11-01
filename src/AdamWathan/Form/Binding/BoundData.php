<?php

namespace AdamWathan\Form\Binding;

/**
 * Class BoundData
 *
 * @package AdamWathan\Form\Binding
 */
class BoundData
{
    /**
     * @var array
     */
    protected $data;


    /**
     * BoundData constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * @param string       $name
     * @param mixed | null $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return $this->dotGet($this->transformKey($name), $default);
    }


    /**
     * @param $dotKey
     * @param $default
     *
     * @return mixed
     */
    protected function dotGet($dotKey, $default)
    {
        $keyParts = explode('.', $dotKey);

        return $this->dataGet($this->data, $keyParts, $default);
    }


    /**
     * @param object | array $target
     * @param array          $keyParts
     * @param mixed          $default
     *
     * @return mixed
     */
    protected function dataGet($target, $keyParts, $default)
    {
        if (count($keyParts) == 0) {
            return $target;
        }
        if (is_array($target)) {
            return $this->arrayGet($target, $keyParts, $default);
        }
        if (is_object($target)) {
            return $this->objectGet($target, $keyParts, $default);
        }

        return $default;
    }


    /**
     * @param object | array $target
     * @param array          $keyParts
     * @param mixed          $default
     *
     * @return mixed
     */
    protected function arrayGet($target, $keyParts, $default)
    {
        $key = array_shift($keyParts);
        if (!isset($target[$key])) {
            return $default;
        }

        return $this->dataGet($target[$key], $keyParts, $default);
    }


    /**
     * @param object | array $target
     * @param array          $keyParts
     * @param mixed          $default
     *
     * @return mixed
     */
    protected function objectGet($target, $keyParts, $default)
    {
        $key = array_shift($keyParts);
        if (!(property_exists($target, $key) || method_exists($target, '__get'))) {
            return $default;
        }

        return $this->dataGet($target->{$key}, $keyParts, $default);
    }


    /**
     * @param string $key
     *
     * @return string
     */
    protected function transformKey($key)
    {
        return str_replace(['[]', '[', ']'], ['', '.', ''], $key);
    }


    /**
     * @return array
     */
    public function data()
    {
        return $this->data;
    }
}
