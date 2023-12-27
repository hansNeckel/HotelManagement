<?php
require __DIR__ . '/../../config.php';

class Database
{
    private $conn;

    public function getConnection()
    {
        global $conex;
        $this->conn = $conex;

        return $this->conn;
    }
}

?>
