<?php
declare(strict_types=1);

abstract class BaseModel extends DebugHelper
{
    protected MySQLi $db;

    public function __construct()
    {
        $host     = gethostbyname('mariadb') !== 'mariadb' ? 'mariadb' : 'localhost';
        $user     = 'public';
        $password = 'public';
        $database = 'pizzaservice';

        $this->db = new MySQLi($host, $user, $password, $database);

        if ($this->db->connect_error) {
            throw new Exception('Datenbankverbindung fehlgeschlagen: ' . $this->db->connect_error);
        }

        $this->db->set_charset('utf8mb4');
    }

    public function __destruct()
    {
        if (isset($this->db) && $this->db instanceof MySQLi) {
            $this->db->close();
        }
    }
}
