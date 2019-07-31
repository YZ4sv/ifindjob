<?php

use app\models\Weather;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Data;

/**
 * @var Weather $model
 */

$dataProvider = new ActiveDataProvider();
$dataProvider->setModels($model->data);
$dataProvider->setTotalCount(count($model->data));
?>

<h2><?= $model->date ?></h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [
            'attribute' => 'times_of_day',
            'content' => function (Data $model) {
                return $model->timeOfDayLabel;
            },
        ],
        'min_temperature',
        'max_temperature',
        'precipitation',
        'pressure',
        'humidity',
        'wind',
        'wind_direction',
        'feels_like',
    ],
]) ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'uv_index',
        'magnetic_field',
    ],
]) ?>
