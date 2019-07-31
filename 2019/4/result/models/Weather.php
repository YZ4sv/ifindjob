<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%weather}}".
 *
 * @property int $id
 * @property string $date
 * @property string $uv_index
 * @property string $magnetic_field
 *
 * @property Data[] $data
 */
class Weather extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%weather}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['uv_index', 'magnetic_field'], 'string', 'max' => 255],
            [['date'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'uv_index' => 'УФ индекс',
            'magnetic_field' => 'Магнитное поле',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getData()
    {
        return $this->hasMany(Data::class, ['weather_id' => 'id']);
    }

    /**
     * @param $condition
     * @return Weather
     */
    public static function findOneOrCreate($condition): Weather
    {
        $model = static::find()
            ->where($condition)
            ->one();

        if (empty($model)) {
            return new static($condition);
        }

        return $model;
    }
}
