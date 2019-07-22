<?php

namespace app\models;

use app\components\db\DB;
use app\components\db\Model;

/**
 * Class Link
 * @package app\models
 */
class Link extends Model
{
    const LINK_LENGTH = 4096;

    /** @var string */
    public $link;
    /** @var string */
    public $uid;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'links';
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function save(): bool
    {
        $db = DB::getInstance();
        $this->uid = uniqid();
        $query = sprintf("INSERT INTO %s SET uid = :uid,  link = :link", self::tableName());

        $res = $db->query($query, [
            'uid' => $this->uid,
            'link' => $this->link,
        ]);

        return (bool)$res;
    }

    /**
     * @param array $params
     * @return Link|null
     * @throws \Exception
     */
    public static function one(array $params): ?Link
    {
        $sth = parent::one($params);
        $raw = $sth->fetch();

        if (empty($raw)) {
            return null;
        }

        $model = new static();
        $model->uid = $raw['uid'] ?? null;
        $model->link = $raw['link'] ?? null;

        return $model;
    }
}
