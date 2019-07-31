<?php

namespace app\controllers;

use app\models\search\Weather;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Weather();
        $dataProvider = $searchModel->search();
        $dataProvider->query->limit(1);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWeek()
    {
        $searchModel = new Weather();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
