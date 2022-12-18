<?php

namespace Framework;

use Framework\FormatQueryValues;

class QueryBuilder
{
    public static function buildSelectQuery(string $table, array $queryStructure)
    {
        $query = "SELECT ";

        foreach ($queryStructure['fieldsAndNicknames'] as $k => $fieldAndNickname) {
            if ($k > 0) {
                $query .= ",";
            }

            $query .= $fieldAndNickname[0]->name . " AS {$fieldAndNickname[1]}";
        }

        if (count($queryStructure['fieldsAndNicknames']) < 1) {
            $query .= " * ";
        }

        $query .= " FROM {$table} ";

        if (isset($queryStructure['innerJoin'])) {
            $query .= self::buildInnerJoinClause($queryStructure);
        }

        if (isset($queryStructure['where'])) {
            $query .= self::buildWhereClause($queryStructure);
        }

        if (isset($queryStructure['limit'])) {
            $query .= self::buildLimitClause($queryStructure);
        }

        if (isset($queryStructure['offset'])) {
            $query .= self::buildOffsetClause($queryStructure);
        }

        return $query;
    }

    public static function buildUpdateQuery(string $table, array $queryStructure)
    {
        $query = "UPDATE {$table} SET ";

        foreach ($queryStructure['updateFieldsAndValues'] as $k => $FieldAndValue) {

            if (gettype($FieldAndValue) != 'array') {
                throw new \Exception("Empty field and values", 1);
            }

            $field = $FieldAndValue[0];
            $value = $FieldAndValue[1];

            if ($k > 0) {
                $query .= ",";
            }

            $query .= " {$field->name} = " . FormatQueryValues::format($value);
        }

        $query .= self::buildWhereClause($queryStructure);

        return $query;
    }

    public static function buildDeleteQuery(string $table, array $queryStructure)
    {
        $query = "DELETE FROM {$table} ";
        $query .= self::buildWhereClause($queryStructure);

        return $query;
    }

    public static function buildInsertQuery(string $table, array $fieldsAndValues)
    {
        $fieldList = "";
        $valueList = "";

        foreach ($fieldsAndValues as $k=> $FieldAndValue) {
            if(! $FieldAndValue->value){
                continue;
            }
            

            $fieldList .= " {$FieldAndValue->name}";
            $valueList .= " ".FormatQueryValues::format($FieldAndValue->value);

            if($k < count($fieldsAndValues)-1){
                $fieldList .= ",";
                $valueList .= ",";
            }
        }

        return "INSERT INTO {$table} ({$fieldList}) VALUES ($valueList)";
    }

    private function buildInnerJoinClause(array $queryStructure)
    {
        foreach ($queryStructure['innerJoin'] as $k => $join) {

            $clause = " INNER JOIN {$join['table']} ON ";

            foreach ($join['relations'] as $key => $relation) {
                if (gettype($relation) != 'array') {
                    throw new \Exception("Bad realtion", 1);
                }
                if (gettype($relation[0]) != 'object' || gettype($relation[0]) != 'object') {
                    throw new \Exception("Relation between not columns", 1);
                }

                $clause .= "{$relation[0]->name} {$relation[1]} {$relation[2]->name} ";
            }
        }

        return $clause;
    }

    private function buildWhereClause(array $queryStructure)
    {
        $clause = " WHERE ";

        foreach ($queryStructure['where'] as $k => $condition) {
            if ($k > 0) {
                $clause .= " AND ";
            }
            $clause .= "{$condition[0]->name} {$condition[1]} {$condition[2]} ";
        }

        return $clause;
    }

    private function buildOffsetClause(array $queryStructure)
    {
        return " offset {$queryStructure['offset']} ";
    }

    private function buildLimitClause(array $queryStructure)
    {
        return " LIMIT {$queryStructure['limit']} ";
    }
}
