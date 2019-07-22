<?php

namespace app\components\web\request;

/**
 * Class Request
 * @package components\web\request
 */
abstract class Request
{
    /**
     * @param string $param
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public abstract static function get(string $param, $defaultValue = null);
}
