<?php

namespace LJCGrowup\SimpleORM;

use \Exception;
use \PDO;
use \PDOException;

use function PHPUnit\Framework\throwException;

final class Connection
{
    private static ?PDO $connection;

    private function __construct(){}

    public static function open(array $db)
    {
        if (!isset($db)) { 
            throw new Exception('Connection data is missing');
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

        self::$connection = match($driver) {
            'mysql'   => new PDO("mysql:host={$host};port={$port};dbname={$database}", $user, $pwd),
            'pgsql'   => new PDO("pgsql:dbname={$database}; user={$user}; password={$pwd}; host={$host}; port={$port}"),
            'mssql'   => new PDO("sqlsrv:host={$host}:{$port};dbname={$database}", $user, $pwd),
            'sqlite'  => new PDO("sqlite:{$database}"),
            default => throw new PDOException('This driver does not exist or this package does not yet implement the required driver')
        };

        if ($driver == 'sqlite') {
            self::$connection->query('PRAGMA foreign_keys = ON');
        }

        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$connection;
    }

    public static function getConnection()
    {
        self::hasOpenConnection();
        return self::$connection;
    }

    public static function beginTransaction()
    {
        self::hasOpenConnection();
        self::$connection->beginTransaction();
    }

    public static function commit()
    {
        self::hasOpenConnection();
        self::$connection->commit();
    }

    public static function rollback()
    {
        self::hasOpenConnection();
        self::$connection->rollback();
    }
    
    public static function close()
    {
        self::hasOpenConnection();
        unset(self::$connection);
    }
    
    private static function hasOpenConnection()
    {
        if (empty(self::$connection)) {
            throw new PDOException('There is no open connection');
        }   
    }
}