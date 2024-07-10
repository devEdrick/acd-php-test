<?php

namespace App\Helpers;

use PDO;

class Database
{
    private static $pdo;

    /**
     * Establishes a PDO database connection based on configuration.
     *
     * @return PDO The PDO instance representing the database connection.
     * @throws \PDOException If connection to the database fails.
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            // Load database configuration
            $databaseConfig = require_once __DIR__ . '/../../config/database.php';

            // Get the default database connection configuration
            $defaultConnection = $databaseConfig['connections'][$databaseConfig['default']];

            $host = $defaultConnection['host'];
            $db = $defaultConnection['database'];
            $user = $defaultConnection['username'];
            $pass = $defaultConnection['password'];
            $port = $defaultConnection['port'];
            $charset = $defaultConnection['charset'];

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }

    /**
     * Executes a SQL query with optional parameters.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters to bind to the query.
     * @return PDOStatement The PDOStatement object representing the result of the query.
     */
    public static function executeQuery(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Retrieves the ID of the last inserted row.
     *
     * @return string The ID of the last inserted row.
     */
    public static function getLastInsertedId(): string
    {
        return self::getConnection()->lastInsertId();
    }
}
