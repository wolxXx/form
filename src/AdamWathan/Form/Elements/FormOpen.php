<?php

namespace AdamWathan\Form\Elements;

/**
 * Class FormOpen
 *
 * @package AdamWathan\Form\Elements
 */
class FormOpen extends Element
{
    /**
     * @var array
     */
    protected $attributes = [
        'method' => 'POST',
        'action' => '',
    ];

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Hidden
     */
    protected $hiddenMethod;


    /**
     * @inheritdoc
     */
    public function render()
    {
        $tags = [sprintf('<form%s>', $this->renderAttributes())];
        if ($this->hasToken() && $this->attributes['method'] !== 'GET') {
            $tags[] = $this->token->render();
        }
        if ($this->hasHiddenMethod()) {
            $tags[] = $this->hiddenMethod->render();
        }

        return implode($tags);
    }


    /**
     * @return bool
     */
    protected function hasToken()
    {
        return isset($this->token);
    }


    /**
     * @return bool
     */
    protected function hasHiddenMethod()
    {
        return isset($this->hiddenMethod);
    }


    /**
     * @return $this
     */
    public function post()
    {
        $this->setMethod('POST');

        return $this;
    }


    public function setMethod($method)
    {
        $this->setAttribute('method', $method);

        return $this;
    }


    /**
     * @return $this
     */
    public function get()
    {
        $this->setMethod('GET');

        return $this;
    }


    /**
     * @return $this
     */
    public function put()
    {
        return $this->setHiddenMethod('PUT');
    }


    /**
     * @param string $method
     *
     * @return $this
     */
    protected function setHiddenMethod($method)
    {
        $this->setMethod('POST');
        $this->hiddenMethod = (new Hidden('_method'))->value($method);

        return $this;
    }


    /**
     * @return $this
     */
    public function patch()
    {
        return $this->setHiddenMethod('PATCH');
    }


    /**
     * @return $this
     */
    public function delete()
    {
        return $this->setHiddenMethod('DELETE');
    }


    /**
     * @param string $token
     *
     * @return $this
     */
    public function token($token)
    {
        $this->token = (new Hidden('_token'))
            ->value($token);

        return $this;
    }


    /**
     * @param string $action
     *
     * @return $this
     */
    public function action($action)
    {
        $this->setAttribute('action', $action);

        return $this;
    }


    /**
     * @return $this
     */
    public function multipart()
    {
        return $this->encodingType('multipart/form-data');
    }


    /**
     * @param string $type
     *
     * @return $this
     */
    public function encodingType($type)
    {
        $this->setAttribute('enctype', $type);

        return $this;
    }
}
