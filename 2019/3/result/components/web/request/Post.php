<?php

namespace app\components\web\request;

/**
 * Class Post
 * @package components\web\request
 */
class Post extends Request
{
    /**
     * @param string $param
     * @param null|mixed $defaultValue
     * @return mixed|null
     */
    public static function get(string $param, $defaultValue = null)
    {
        if (isset($_POST[$param])) {
            return $_POST[$param];
        }

        return $defaultValue;
    }
}
