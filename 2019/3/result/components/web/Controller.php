<?php

namespace app\components\web;

/**
 * Class Controller
 * @package components\web
 */
abstract class Controller
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/%s/%s.php';
    private const LAYOUTS_PATH = __DIR__ . '/../../views/layouts/%s.php';

    /** @var string  */
    protected $layout = 'index';
    /** @var string  */
    protected $templateDir = 'index';

    /**
     * @param string $url
     * @param int $code
     */
    public function redirect(string $url, int $code = 301)
    {
        header(sprintf('Location: %s', $url),true, $code);

        exit;
    }

    /**
     * Собирает шаблон
     *
     * @param string $view
     * @param array $params
     */
    public function render(string $view, array $params = [])
    {
        ob_start();
        extract($params);

        try {
            include sprintf(self::TEMPLATE_PATH, $this->templateDir, $view);
        } catch (\Exception $e) {
            ob_clean();
            echo 'No layout';
            exit;
        }

        $content = ob_get_contents();
        ob_end_clean();

        try {
            include sprintf(self::LAYOUTS_PATH, $this->layout);
        } catch (\Exception $e) {
            ob_clean();
            echo 'No template';
            exit;
        }
    }
}
