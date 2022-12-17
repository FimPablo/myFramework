<?php

namespace Framework;

use Framework\DBConnector;
use Framework\QueryBuilder;

class Model extends DBConnector
{
    private array $queryStructure = [];
    protected string $table;

    private string $query;

    public function __construct()
    {
        parent::__construct();
    }

    protected function defineColumn(string $name)
    {
        $this->{$name} = new Column($name, $this->table);

        return $this;
    }

    protected function where(array $condicions)
    {
        $this->queryStructure['where'] = $condicions;
        return $this;
    }

    protected function orderBy(string $ordenator)
    {
        $this->queryStructure['orderBy'] = $ordenator;
        return $this;
    }

    protected function take(int $limit)
    {
        $this->queryStructure['limit'] = $limit;
        return $this;
    }

    protected function before(int $offset)
    {
        $this->queryStructure['offset'] = $offset;
        return $this;
    }

    protected function with(Model $related, array $relations)
    {
        $this->queryStructure['innerJoin'][] = [
            "table" => $related->table,
            "relations" => $relations
        ];
        return $this;
    }

    protected function get(array $fieldsAndNicknames = [])
    {
        $this->queryStructure['fieldsAndNicknames'] = $fieldsAndNicknames;

        $this->query = QueryBuilder::buildSelectQuery($this->table, $this->queryStructure);

        return $this->run();
    }

    protected function set(array $fieldsAndValues)
    {
        $this->queryStructure['updateFieldsAndValues'] = $fieldsAndValues;

        $this->query = QueryBuilder::buildUpdateQuery($this->table, $this->queryStructure);

        return $this->run();
    }

    protected function delete()
    {
        $this->query = QueryBuilder::buildDeleteQuery($this->table, $this->queryStructure);

        return $this->run();
    }

    protected function new()
    {
        $fieldsAndValues = [];

        foreach ($this as $key => $v) {
            if(get_class($this->{$key}) != 'Framework\Column'){
                continue;
            }
            $fieldsAndValues[] = $this->{$key};
        }

        $this->query = QueryBuilder::buildInsertQuery($this->table, $fieldsAndValues);
        return $this->run();
    }

    private function run()
    {
        var_dump($this->query);
    }
}
