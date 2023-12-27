<?php

require __DIR__ . '/database.php';

class Login {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function validateUser($username, $password) { //validar el usuario si existe
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        error_log(print_r($user, true));

        if ($user && $password === $user['password']) {
            return true;
        } else {
            return false;
        }
    }
}
