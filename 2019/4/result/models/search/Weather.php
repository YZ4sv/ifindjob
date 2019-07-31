<?php
namespace app\models\search;

use app\models\Weather as BaseModel;
use yii\data\ActiveDataProvider;

/**
 * Class Weather
 * @package app\models\search
 */
class Weather extends BaseModel
{
    const DAYS_ON_WEEK = 7;

    /**
     * @return ActiveDataProvider
     */
    public function search(): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getBaseQuery(),
            'sort' => [
                'defaultOrder' => ['date' => SORT_ASC],
            ],
            'pagination' => false,
        ]);

        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    private function getBaseQuery()
    {
        return BaseModel::find()
            ->with(['data'])
            ->where(['>=', 'date', date('Y-m-d')])
            ->limit(self::DAYS_ON_WEEK);
    }
}