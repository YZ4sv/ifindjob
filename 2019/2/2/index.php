<?php
$host = 'localhost';
$db = 'test';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (Exception $e) {
    echo 'No db connect';
    die();
}

$step = 10000;
/** @var int[] $domains */
$domains = [];

for ($i = 0; true; $i++) {
    $offset = $step * $i;
    $stmt = $pdo->query("SELECT email FROM users LIMIT {$step} OFFSET {$offset}");
    $hasData = false;

    while ($row = $stmt->fetch()) {
        $hasData = true;

        $data = explode(',', $row['email']);

        foreach ($data as $item) {
            $emailData = explode('@', $item);
            $domain = $emailData[count($emailData) - 1];

            if (key_exists($domain, $domains)) {
                $domains[$domain]++;
            } else {
                $domains[$domain] = 1;
            }
        }
    }

    if (!$hasData) {
        break;
    }
}

foreach ($domains as $domain => $count) {
    echo "{$domain}: $count" . PHP_EOL;
}
