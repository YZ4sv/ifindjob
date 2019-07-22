<?php
namespace app\controllers;

use app\components\App;
use app\components\web\Controller;
use app\components\web\request\Post;
use app\models\Link;

/**
 * Class IndexController
 * @package controllers
 */
class IndexController extends Controller
{
    /**
     * Главная страница
     */
    public function actionIndex()
    {
        $link = $this->createLink();

        $this->render('index', [
            'link' => $link,
        ]);
    }

    /**
     * Создание ссылки, если такая есть, конечно
     */
    private function createLink(): ?string
    {
        $link = Post::get('link');

        if (empty($link)) {
            return null;
        }

        $model = new Link();
        $model->link = $link;

        if ($model->save()) {
            return implode('/', [
                App::getSetting('domain'),
                $model->uid
            ]);
        }

        throw new \Exception('Can\'t save link', 500);
    }

    /**
     * Переадресация на исходный урл
     *
     * @param array $params
     * @throws \Exception
     */
    public function actionRedirect($params)
    {
        $model = Link::one([
            'uid' => $params['alias'],
        ]);

        if (empty($model)) {
            throw new \Exception('No link', 404);
        }

        $this->redirect($model->link);
    }
}
