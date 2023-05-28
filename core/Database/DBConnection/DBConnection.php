<?php

namespace Core\Database\DBConnection;

use PDO;
USE PDOException;
class DBConnection
{
    private static $dbConnectionInstance = null;

    private function __construct()
    {
    }

    public static function getDBConnectionInstance()
    {
        if (self::$dbConnectionInstance == null) {
            $DBConnectionInstance = new DBConnection();
            self::$dbConnectionInstance = $DBConnectionInstance->dbConnection();
        }

        return self::$dbConnectionInstance;
    }

    public function dbConnection()
    {
        $servername = DBHOST;
        $databse = DBNAME;
        $username = DBUSERNAME;
        $password = DBPASSWORD;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$databse", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}