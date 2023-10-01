<?php

namespace LJCGrowup\SimpleORM;

use \Exception;
use \PDO;
use \PDOException;

final class Connection
{
    private function __construct(){}

    public static function getConnection(string $filenameConnection)
    {
        if (file_exists($filenameConnection)) {
            $db = parse_ini_file($filenameConnection);
        } else {
            throw new Exception('Connection file not found');
        }

        $driver   = $db['driver'] ?? null;
        $host     = $db['host'] ?? null;
        $port     = $db['port'] ?? null;
        $database = $db['database'] ?? null;
        $user     = $db['user'] ?? null;
        $pwd      = $db['password'] ?? null;

        $connection = null;

        switch ($driver) {
            case 'mysql':
                $port = $port ?? '3306';
                $connection = new PDO("mysql:host={$host};port={$port};dbname={$database}", $user, $pwd);
                break;
            case 'pgsql':
                $port = $port ?? '5432';
                $connection = new PDO("pgsql:dbname={$database}; user={$user}; password={$pwd}; host={$host}; port={$port}");
                break;
            case 'sqlite':
                $connection = new PDO("sqlite:{$database}");
                $connection->query('PRAGMA foreign_keys = ON');
                break;
            case 'mssql':
                $conn = new PDO("dblib:host={$host}:{$port};dbname={$database}", $user, $pwd);
                break;
            default:
                throw new PDOException('This package does not yet implements the required driver');
        }

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}