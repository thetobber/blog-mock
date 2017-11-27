<?php
namespace Application;

class Database
{
    private static $instance;

    private function __construct()
    {
    }

    /**
     * Retrieves or instantiates an instance of the PDO class.
     * 
     * @return PDO 
     * @throws PDOException upon a database error.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=localhost;dbname=blockmock;charset=utf8', 'root', ''
                );
            }
            catch (PDOException $exception) {
                header('HTTP/1.1 500 Internal Server Error', true);
                die('Could not connect to the database.');
            }
        }

        return self::$pdo;
    }
}
