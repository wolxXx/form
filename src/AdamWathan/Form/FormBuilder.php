<?php

namespace AdamWathan\Form;

use AdamWathan\Form\Binding\BoundData;
use AdamWathan\Form\Elements\Button;
use AdamWathan\Form\Elements\Checkbox;
use AdamWathan\Form\Elements\Date;
use AdamWathan\Form\Elements\DateTimeLocal;
use AdamWathan\Form\Elements\Email;
use AdamWathan\Form\Elements\File;
use AdamWathan\Form\Elements\FormOpen;
use AdamWathan\Form\Elements\Hidden;
use AdamWathan\Form\Elements\Label;
use AdamWathan\Form\Elements\Password;
use AdamWathan\Form\Elements\RadioButton;
use AdamWathan\Form\Elements\Select;
use AdamWathan\Form\Elements\Text;
use AdamWathan\Form\Elements\TextArea;
use AdamWathan\Form\ErrorStore\ErrorStoreInterface;
use AdamWathan\Form\OldInput\OldInputInterface;

/**
 * Class FormBuilder
 *
 * @package AdamWathan\Form
 */
class FormBuilder
{
    /**
     * @var OldInputInterface
     */
    protected $oldInput;

    /**
     * @var ErrorStoreInterface
     */
    protected $errorStore;

    /**
     * @var string
     */
    protected $csrfToken;

    /**
     * @var BoundData
     */
    protected $boundData;


    /**
     * @param \AdamWathan\Form\OldInput\OldInputInterface $oldInputProvider
     *
     * @return $this
     */
    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;

        return $this;
    }


    /**
     * @return \AdamWathan\Form\OldInput\OldInputInterface
     */
    public function getOldInputProvider()
    {
        return $this->oldInput;
    }


    /**
     * @param \AdamWathan\Form\ErrorStore\ErrorStoreInterface $errorStore
     *
     * @return $this
     */
    public function setErrorStore(ErrorStoreInterface $errorStore)
    {
        $this->errorStore = $errorStore;

        return $this;
    }


    /**
     * @return \AdamWathan\Form\ErrorStore\ErrorStoreInterface
     */
    public function getErrorStore()
    {
        return $this->errorStore;
    }


    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->csrfToken = $token;

        return $this;
    }


    /**
     * @return \AdamWathan\Form\Elements\FormOpen
     */
    public function open()
    {
        $open = new FormOpen();
        if ($this->hasToken()) {
            $open->token($this->csrfToken);
        }

        return $open;
    }


    /**
     * @return bool
     */
    protected function hasToken()
    {
        return isset($this->csrfToken);
    }


    /**
     * @return string
     */
    public function close()
    {
        $this->unbindData();

        return '</form>';
    }


    /**
     * @return $this
     */
    protected function unbindData()
    {
        $this->boundData = null;

        return $this;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Text
     */
    public function text($name)
    {
        $text = new Text($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        return $text;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Range
     */
    public function range($name)
    {
        $text = new \AdamWathan\Form\Elements\Range($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        return $text;
    }


    /**
     * @param string $name
     *
     * @return mixed | null
     */
    public function getValueFor($name)
    {
        if ($this->hasOldInput()) {
            return $this->getOldInput($name);
        }
        if ($this->hasBoundData()) {
            return $this->getBoundValue($name, null);
        }

        return null;
    }


    /**
     * @return bool
     */
    protected function hasOldInput()
    {
        if (!isset($this->oldInput)) {
            return false;
        }

        return $this->oldInput->hasOldInput();
    }


    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function getOldInput($name)
    {
        return $this->oldInput->getOldInput($name);
    }


    /**
     * @return bool
     */
    protected function hasBoundData()
    {
        return isset($this->boundData);
    }


    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function getBoundValue($name, $default)
    {
        return $this->boundData->get($name, $default);
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Date
     */
    public function date($name)
    {
        $date = new Date($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $date->value($value);
        }

        return $date;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\DateTimeLocal
     */
    public function dateTimeLocal($name)
    {
        $date = new DateTimeLocal($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $date->value($value);
        }

        return $date;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Email
     */
    public function email($name)
    {
        $email = new Email($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $email->value($value);
        }

        return $email;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\TextArea
     */
    public function textarea($name)
    {
        $textarea = new TextArea($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $textarea->value($value);
        }

        return $textarea;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Password
     */
    public function password($name)
    {
        return new Password($name);
    }


    /**
     * @param string $name
     * @param int    $value
     *
     * @return \AdamWathan\Form\Elements\Checkbox
     */
    public function checkbox($name, $value = 1)
    {
        return (new Checkbox($name, $value))
            ->setOldValue($this->getValueFor($name));
    }


    /**
     * @param string       $name
     * @param mixed | null $value
     *
     * @return \AdamWathan\Form\Elements\RadioButton
     */
    public function radio($name, $value = null)
    {
        return (new RadioButton($name, $value))
            ->setOldValue($this->getValueFor($name));
    }


    /**
     * @param string       $value
     * @param mixed | null $name
     *
     * @return \AdamWathan\Form\Elements\Button
     */
    public function button($value, $name = null)
    {
        return new Button($value, $name);
    }


    /**
     * @param string $value
     *
     * @return \AdamWathan\Form\Elements\Button
     */
    public function reset($value = 'Reset')
    {
        return (new Button($value))
            ->attribute('type', 'reset');
    }


    /**
     * @param string $value
     *
     * @return \AdamWathan\Form\Elements\Button
     */
    public function submit($value = 'Submit')
    {
        return (new Button($value))
            ->attribute('type', 'submit');
    }


    /**
     * @param string $label
     *
     * @return \AdamWathan\Form\Elements\Label
     */
    public function label($label)
    {
        return new Label($label);
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\File
     */
    public function file($name)
    {
        return new File($name);
    }


    /**
     * @return \AdamWathan\Form\Elements\Hidden
     */
    public function token()
    {
        $token = $this->hidden('_token');
        if (isset($this->csrfToken)) {
            $token->value($this->csrfToken);
        }

        return $token;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Hidden
     */
    public function hidden($name)
    {
        $hidden = new Hidden($name);
        if (!is_null($value = $this->getValueFor($name))) {
            $hidden->value($value);
        }

        return $hidden;
    }


    /**
     * @param string        $name
     * @param string | null $format
     *
     * @return null | string
     */
    public function getError($name, $format = null)
    {
        if (!isset($this->errorStore)) {
            return null;
        }
        if (!$this->hasError($name)) {
            return '';
        }
        $message = $this->errorStore->getError($name);
        if ($format) {
            $message = str_replace(':message', $message, $format);
        }

        return $message;
    }


    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasError($name)
    {
        if (!isset($this->errorStore)) {
            return false;
        }

        return $this->errorStore->hasError($name);
    }


    /**
     * @param array | mixed $data
     *
     * @return $this
     */
    public function bind($data)
    {
        $this->boundData = new BoundData($data);

        return $this;
    }


    /**
     * @param string $name
     *
     * @return \AdamWathan\Form\Elements\Select
     */
    public function selectMonth($name)
    {
        $options = [
            "1"  => "January",
            "2"  => "February",
            "3"  => "March",
            "4"  => "April",
            "5"  => "May",
            "6"  => "June",
            "7"  => "July",
            "8"  => "August",
            "9"  => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December",
        ];

        return $this->select($name, $options);
    }


    /**
     * @param string $name
     * @param array  $options
     *
     * @return \AdamWathan\Form\Elements\Select
     */
    public function select($name, $options = [])
    {
        return (new Select($name, $options))
            ->select($this->getValueFor($name));
    }
}
