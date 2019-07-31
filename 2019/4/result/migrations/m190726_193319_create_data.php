<?php

use yii\db\Migration;

/**
 * Class m190726_193319_create_data
 */
class m190726_193319_create_data extends Migration
{
    /** @var string */
    private $table = 'data';
    /** @var string */
    private $index = 'i-data-weather_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'weather_id' => $this->integer()->notNull(),
            'times_of_day' => $this->tinyInteger()->unsigned()->notNull(),
            'min_temperature' => $this->tinyInteger(),
            'max_temperature' => $this->tinyInteger(),
            'precipitation' => $this->string(),
            'pressure' => $this->integer()->unsigned(),
            'humidity' => $this->smallInteger()->unsigned(),
            'wind' => $this->float()->unsigned(),
            'wind_direction' => $this->string(),
            'feels_like' => $this->string(),
        ]);

        $this->createIndex(
            $this->index,
            $this->table,
            'weather_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex($this->index, $this->table);

        $this->dropTable($this->table);
    }
}
