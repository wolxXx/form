<?php

namespace AdamWathan\Form\ErrorStore;

/**
 * Interface ErrorStoreInterface
 *
 * @package AdamWathan\Form\ErrorStore
 */
interface ErrorStoreInterface
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasError($key);


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getError($key);
}
