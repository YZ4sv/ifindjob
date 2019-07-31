<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Погода';
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
]) ?>