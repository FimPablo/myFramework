<?php

namespace Framework;

class Model
{
    private array $queryStructure = [];
    protected string $table;

    private string $query;

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

    protected function get(string $fields = '*')
    {
        $this->queryStructure['action'] = 'select';
        $this->queryStructure['selectFields'] = $fields;

        $this->queryBuilder();

        return $this->run();
    }

    protected function set(array $fieldsAndValues)
    {
        $this->queryStructure['action'] = 'update';

        if (gettype($fieldsAndValues) != 'array') {
            throw new \Exception("Empty field and values", 1);
        }

        $this->queryStructure['updateFieldsAndValues'] = $fieldsAndValues;

        $this->queryBuilder();

        return $this->run();
    }

    protected function delete(){
        $this->queryStructure['action'] = 'delete';

        $this->queryBuilder();

        return $this->run();
    }

    private function queryBuilder()
    {
        $queryByAction= [
            "select" => "SELECT {$this->queryStructure['selectFields']} FROM {$this->table} ",
            "update" => "UPDATE {$this->table} SET ",
            "delete" => "DELETE FROM {$this->table} "
        ];

        $this->query = $queryByAction[$this->queryStructure['action']];

        if($this->queryStructure['action'] == 'update'){
            foreach ($this->queryStructure['updateFieldsAndValues'] as $k => $FieldAndValue) {

                if (gettype($FieldAndValue) != 'array') {
                    throw new \Exception("Empty field and values", 1);
                }
    
                $field = $FieldAndValue[0];
                $value = $FieldAndValue[1];
    
                if ($k > 0) {
                    $this->query .= ",";
                }
    
                $this->query .= " {$field} = " . $this->formatValues($value);
            }
        }

        if (isset($this->queryStructure['where'])) {
            $this->query .= " WHERE ";

            foreach ($this->queryStructure['where'] as $k => $conditions) {
                if ($k > 0) {
                    $this->query .= " AND ";
                }
                $this->query .= "{$conditions[0]} {$conditions[1]} {$conditions[2]}";
            }
        }

        if(isset($this->queryStructure['limit']))
        {
            $this->query .= " LIMIT {$this->queryStructure['limit']} ";
        }

        if(isset($this->queryStructure['offset']))
        {
            $this->query .= " offset {$this->queryStructure['offset']} ";
        }

        $this->queryStructure = [];
    }

    private function run()
    {
        return $this->query;
    }

    private function formatValues($value)
    {
        $formatTypes = [
            'string' => "formatString",
            'double' => "formatFloat"
        ];

        $valueType = gettype($value);

        if (!isset($formatTypes[$valueType])) {
            return $value;
        }

        $function = $formatTypes[$valueType];

        return $this->$function($value);
    }

    private function formatString(string $value)
    {
        return "'{$value}'";
    }

    private function formatFloat(float $value)
    {
        $integerAndDecimal = explode('.', (string)$value);

        return "{$integerAndDecimal[0]},{$integerAndDecimal[1]}";
    }
}
