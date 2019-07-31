<?php

use yii\db\Migration;

/**
 * Class m190726_192724_create_weather
 */
class m190726_192724_create_weather extends Migration
{
    /** @var string */
    private $table = '{{%weather}}';
    /** @var string */
    private $index = 'i-weather-date';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'date' => $this->date()->unique(),
            'uv_index' => $this->string(),
            'magnetic_field' => $this->string(),
        ]);

        $this->createIndex(
            $this->index,
            $this->table,
            'date',
            true
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
