<?php

namespace Framework;

use Framework\Utils\Config;

class DBConnector
{

    private array $dbConfig;
    private \mysqli $connection;

    public function __construct()
    {
        $this->dbConfig = Config::get('databaseConfig');
        //$this->connect();
    }

    protected function runQuery($query)
    {
    }

    protected function connect()
    {
        $this->connection = new \mysqli("localhost", "user", "password", "database");

        if ($this->connection->connect_errno) {
            throw new \Exception("Failure at connecting to database", 1);
        }
    }

    protected function beggin()
    {
    }

    protected function commit()
    {
    }
}
