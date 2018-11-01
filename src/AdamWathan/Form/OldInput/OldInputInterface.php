<?php

namespace AdamWathan\Form\OldInput;

/**
 * Interface OldInputInterface
 *
 * @package AdamWathan\Form\OldInput
 */
interface OldInputInterface
{
    /**
     * @return bool
     */
    public function hasOldInput();


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getOldInput($key);
}
