<?php

namespace AdamWathan\Form\OldInput;

use Illuminate\Session\Store as Session;

/**
 * Class IlluminateOldInputProvider
 *
 * @package AdamWathan\Form\OldInput
 */
class IlluminateOldInputProvider implements OldInputInterface
{
    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function hasOldInput()
    {
        return ($this->session->get('_old_input')) ? true : false ;
    }

    public function getOldInput($key)
    {
        return $this->session->getOldInput($this->transformKey($key));
    }

    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}
