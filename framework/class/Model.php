<?php

namespace Framework;

class Model
{
    private array $queryStructure = [];
    protected string $table;

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

    protected function get(string $fields = '*')
    {
        $buildedQuery = "SELECT {$fields} FROM {$this->table}";

        if (isset($this->queryStructure['where'])) {
            $buildedQuery .= " WHERE ";

            foreach ($this->queryStructure['where'] as $k => $conditions) {
                if ($k > 0) {
                    $buildedQuery .= " AND ";
                }
                $buildedQuery .= "{$conditions[0]} {$conditions[1]} {$conditions[2]}";
            }
        }

        return $this->run($buildedQuery);
    }

    protected function set(array $fieldsAndValues)
    {
        $buildedQuery = "UPDATE {$this->table} SET ";

        if (isset($this->queryStructure['where'])) {
            $buildedQuery .= " WHERE ";

            foreach ($this->queryStructure['where'] as $k => $conditions) {
                if ($k > 0) {
                    $buildedQuery .= " AND ";
                }
                $buildedQuery .= "{$conditions[0]} {$conditions[1]} {$conditions[2]}";
            }
        }

        return $this->run($buildedQuery);
    }

    private function run(string $query)
    {
        return $query;
    }
}
