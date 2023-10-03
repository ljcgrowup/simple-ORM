<?php

namespace LJCGrowup\SimpleORM;

abstract class Model
{
    protected ?string $table = null;
    protected ?string $idColumnName = null;

    public function __construct()
    {
        if (!$this->table) {
            $fullQualifiedName = get_class($this);
            $basenameClass = substr($fullQualifiedName, strrpos($fullQualifiedName, '\\')+1);
            $this->table = strtolower($basenameClass).'s';
        }
    }

    public function findById($id)
    {
        $sql = "select * from {$this->table} where " .
        ($this->idColumnName ?? "id") . " = :id";

        return $sql;
    }
}

