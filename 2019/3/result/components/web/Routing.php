<?php

namespace app\components\web;

/**
 * Class Routing
 * @package app\components\web
 */
class Routing
{
    /** @var string */
    private $controllerName = 'index';
    /** @var string */
    private $actionName = 'index';
    /** @var array */
    private $params = [];

    /**
     * Routing constructor.
     * Парсит сам роут
     */
    public function __construct()
    {
        if ($_SERVER['REQUEST_URI'] != '/') {
            $this->params['alias'] = trim($_SERVER['REQUEST_URI'], '/');
            $this->actionName = 'redirect';
        }
    }

    /**
     * Пытается найти нужный экшен
     */
    public function run()
    {
        $controllerClass = 'app\\controllers\\' . ucfirst($this->controllerName) . 'Controller';

        try {
            $controller = new $controllerClass();
            $action = 'action' . ucfirst($this->actionName);

            call_user_func([$controller, $action], $this->params);
        } catch (\Exception $e) {
            // когда-то тут будет нормальный разбор ошибок
            // (нет)

            echo 404;
            exit;
        }
    }
}