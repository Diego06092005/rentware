<?php
class Database {
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $database = "rentware";
    private static $conn;

    public static function getConnection() {
        self::$conn = null;
        try {
            self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$database);
            if (self::$conn->connect_error) {
                throw new Exception("Connection failed: " . self::$conn->connect_error);
            }
        } catch (Exception $e) {
            die("Error de conexión: " . $e->getMessage());
        }
        return self::$conn;
    }
    
}
?>
