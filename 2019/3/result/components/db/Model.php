<?php
namespace app\components\db;

use app\components\db\DB;

/**
 * Class Model
 * @package app\components\db
 */
abstract class Model
{
    /**
     * Возвращает название таблицы
     *
     * @return string
     */
    abstract public static function tableName(): string;

    /**
     * @param array $params
     * @return bool|false|\PDOStatement
     * @throws \Exception
     */
    public static function one(array $params)
    {
        $db = DB::getInstance();

        return $db->query(static::buildFindQuery($params), $params);
    }

    /**
     * Составление запроса
     *
     * @param array $params
     * @return string
     */
    private static function buildFindQuery(array $params = [])
    {
        $query = sprintf("SELECT * FROM %s", static::tableName());

        if (empty($params)) {
            return $query;
        }

        $where = [];

        foreach ($params as $param => $value) {
            $where[$param] = $param . ' = ' . ':' . $param;
        }

        $query = implode(' ', [
            $query,
            'WHERE',
            implode('AND', $where)
        ]);

        return $query;
    }
}