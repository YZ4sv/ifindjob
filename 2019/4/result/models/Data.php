<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%data}}".
 *
 * @property int $id
 * @property int $weather_id
 * @property int $times_of_day
 * @property int $min_temperature
 * @property int $max_temperature
 * @property string $precipitation
 * @property int $pressure
 * @property int $humidity
 * @property double $wind
 * @property string $wind_direction
 * @property string $feels_like
 *
 * @property string timeOfDayLabel
 */
class Data extends \yii\db\ActiveRecord
{
    const MORNING = 1;
    const DAY = 2;
    const EVENING = 3;
    const NIGHT = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weather_id', 'times_of_day'], 'required'],
            [['weather_id', 'times_of_day', 'min_temperature', 'max_temperature', 'pressure', 'humidity'], 'integer'],
            [['wind'], 'number'],
            [['wind_direction', 'feels_like', 'precipitation'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weather_id' => 'Weather ID',
            'times_of_day' => 'Время суток',
            'min_temperature' => 'Минимальная',
            'max_temperature' => 'Максимальная',
            'precipitation' => 'Погода',
            'pressure' => 'Давление',
            'humidity' => 'Влажность',
            'wind' => 'Скоротьо ветра',
            'wind_direction' => 'Направление ветра',
            'feels_like' => 'Ощущается как',
        ];
    }

    /**
     * @return string
     */
    public function getTimeOfDayLabel(): string
    {
        switch ($this->times_of_day) {
            case self::MORNING:
                return  'Утро';
            case self::DAY:
                return  'День';
            case self::EVENING:
                return  'Вечер';
            case self::NIGHT:
                return  'Ночь';
        }

        return '-';
    }
}
