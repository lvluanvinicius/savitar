<?php

namespace App\Traits;

use App\Messages\ApiMessages;
use App\Messages\AppMessages;

Trait LoadMessages
{
    use ApiMessages, AppMessages;

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @param [type] $key
     * @return void
     */
    private function _get($value, $key) {
        return $this->$value[$key];
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @param [type] $key
     * @return string
     */
    protected function getMessage($value, $key) {
        return $this->_get($value, $key);
    }

}
