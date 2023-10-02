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

        $ports = [
            'mysql' => '3306',
            'pgsql' => '5432',
            'mssql' => '1433',
            'sqlite' => null,
        ];

        $port = $ports[$driver];

        $connection = null;

        $connection = match($driver) {
            'mysql'   => new PDO("mysql:host={$host};port={$port};dbname={$database}", $user, $pwd),
            'pgsql'   => new PDO("pgsql:dbname={$database}; user={$user}; password={$pwd}; host={$host}; port={$port}"),
            'mssql'   => new PDO("sqlsrv:host={$host}:{$port};dbname={$database}", $user, $pwd),
            'sqlite'  => new PDO("sqlite:{$database}"),
            default => throw new PDOException('This package does not yet implements the required driver')
        };

        if ($driver == 'sqlite') {
            $connection->query('PRAGMA foreign_keys = ON');
        }

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}