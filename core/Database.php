<?php

namespace app\core;

use PDO;

class Database
{

    public $pdo = NULL;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? "";
        $user = $config['user'] ?? "";
        $password = $config['password'] ?? "";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        ];

        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function prepare()
    {
    }
}
