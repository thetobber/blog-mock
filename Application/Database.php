<?php
namespace Application;

use PDO;

/**
 * Represents a container for a singleton connection to the database.
 */
class Database
{
    /**
     * The signle instance of PDO contained in this class.
     * 
     * @var PDO
     */
    private static $instance;

    /**
     * Constructor with a private access modifier to prevent instantiation.
     */
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
                    'mysql:host=localhost;dbname=blogmock;charset=utf8',
                    'blogmock_app',
                    'PQXQ25sSUNKy83H4',
                    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = 'Europe/Copenhagen'"]
                );
            }
            catch (PDOException $exception) {
                header('HTTP/1.1 500 Internal Server Error', true);
                die('Could not connect to the database.');
            }
        }

        return self::$instance;
    }
}
