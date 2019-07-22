<?php

namespace app\components\db;

use Exception;
use PDO;

/**
 * Class DB
 * @package components\db
 */
class DB
{
    /** @var DB */
    private static $instance;
    /** @var PDO */
    private $pdo;

    /**
     * DB constructor.
     */
    private function __construct()
    {
        $config = include __DIR__ . '/../../config/db.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['name']};charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], $opt);
        } catch (Exception $e) {
            echo 'No db connect';
            die();
        }
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $this->pdo = null;
    }

    /**
     * @return DB
     */
    public static function getInstance(): DB
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool|false|\PDOStatement
     * @throws Exception
     */
    public function query(string $query, array $params = [])
    {
        if (empty($params)) {
            return $this->pdo->query($query);
        }

        $params = $this->prepareParams($params);

        $sth = $this->pdo->prepare($query);

        foreach ($params as $param => &$value) {
            $sth->bindParam($param, $value);
        }

        $execute = $sth->execute();

        if ($execute === false) {
            throw new Exception(implode("\n", $sth->errorInfo()));
        }


        return $sth;
    }

    /**
     * Подставляет две точки в параметры
     *
     * @param array $params
     * @return array
     */
    private function prepareParams(array $params): array
    {
        $res = [];

        foreach ($params as $param => $value) {
            $res[':' . $param] = $value;
        }

        return $res;
    }
}
