<?php
namespace app\components;

/**
 * Class App
 * @package app\components
 */
class App
{
    private const PATH_TO_SETTINGS = __DIR__ . '/../config/app.php';
    /** @var null|array */
    private static $settings = null;

    /**
     * @param string $param
     * @param mixed $default
     * @return mixed
     */
    public static function getSetting(string $param, $default = null)
    {
        if (self::$settings === null) {
            self::$settings = include self::PATH_TO_SETTINGS;
        }

        return self::$settings[$param] ?? $default;
    }
}