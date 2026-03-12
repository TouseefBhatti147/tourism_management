<?php
class Database {
    private static $pdo = null;
    
    // --- Connection Details from your file ---
    private static $host = 'localhost';
    private static $dbname = 'rdlpk_db1';
    private static $username = 'root';
    private static $password = '';
    private static $charset = 'utf8mb4';

    // Private constructor so it can't be instantiated directly
    private function __construct() {}

    /**
     * Gets the single instance of the PDO connection.
     * @return PDO
     * @throws \PDOException if connection fails
     */
    public static function getConnection() {
        // Only connect if we haven't already
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            // The 'try...catch' is now inside this function
            try {
                self::$pdo = new PDO($dsn, self::$username, self::$password, $options);
            } catch (\PDOException $e) {
                // If connection fails, re-throw the exception
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        
        // Return the existing or new connection
        return self::$pdo;
    }
}
?>
