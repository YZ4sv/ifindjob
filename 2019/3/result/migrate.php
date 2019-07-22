<?php
include __DIR__ . '/vendor/autoload.php';

use app\components\db\DB;

$db = DB::getInstance();

$db->query(file_get_contents(__DIR__ . '/migrations/init.sql'));

echo 'Done.' . PHP_EOL;