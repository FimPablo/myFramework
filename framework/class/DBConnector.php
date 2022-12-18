<?php

namespace Framework;

use Framework\Utils\Config;

class DBConnector
{

    private array $dbConfig;
    private \mysqli $connection;

    private $resultSet;

    public function __construct()
    {
        $this->dbConfig = Config::get('databaseConfig');
        $this->connect();
    }

    protected function runQuery($query)
    {
        if (!$this->resultSet = $this->connection->query($query)) {
            throw new \Error($this->connection->error."|||{$query}|||", 1);
        }

        $responseArray = [];
        if($this->resultSet === true)
        {
            return true;
        }
        $this->resultSet->data_seek(0);
        while ($row = $this->resultSet->fetch_assoc()) {
            $responseArray[] = $row;
        }

        return $responseArray;
    }

    protected function connect()
    {
        $this->connection = new \mysqli($this->dbConfig['serverIp'], $this->dbConfig['serverLogin'], $this->dbConfig['serverPassword'], $this->dbConfig['databaseName']);

        if ($this->connection->connect_errno) {
            throw new \Exception("Failure at connecting to database", 1);
        }
    }
}
