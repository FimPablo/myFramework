<?php

namespace Framework;

use Framework\DBConnector;
use Framework\QueryBuilder;

class Model extends DBConnector
{
    private array $queryStructure = [];
    protected string $table;

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

        $resultArray = $this->runQuery(QueryBuilder::buildSelectQuery($this->table, $this->queryStructure));
        $returnArray = [];
        foreach ($resultArray as $k => $model) {
            foreach ($model as $key => $value) {
                if(!isset($this->{$key}))
                {
                    $this->{$key} = new Column($key, $this->table);
                }
                $this->{$key}->value = $value;
            }

            $returnArray[] = $this;
        }
        return $returnArray;
    }

    protected function set(array $fieldsAndValues)
    {
        $this->queryStructure['updateFieldsAndValues'] = $fieldsAndValues;

        return $this->runQuery(QueryBuilder::buildUpdateQuery($this->table, $this->queryStructure));
        
    }

    protected function delete()
    {
        return $this->runQuery(QueryBuilder::buildDeleteQuery($this->table, $this->queryStructure));
    }

    protected function new(array $fieldsAndValues = [])
    {
        $fieldsAndValues = [];

        foreach ($this as $key => $v) {
            if(gettype($this->{$key}) != 'object')
            {
                continue;
            }
            if(get_class($this->{$key}) != 'Framework\Column'){
                continue;
            }
            $fieldsAndValues[] = $this->{$key};
        }

        return  $this->runQuery(QueryBuilder::buildInsertQuery($this->table, $fieldsAndValues));
    }

    public function serialize()
    {
        $returnArray = [];
        foreach ($this as $key => $v) {
            if(gettype($this->{$key}) != 'object')
            {
                continue;
            }
            if(get_class($this->{$key}) != 'Framework\Column'){
                continue;
            }
            $returnArray[$key] = $this->{$key}->value;
        }
        return $returnArray;
    }
}
