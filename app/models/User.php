<?php
require_once "../core/Model.php";

class User extends Model {

    public function login($email, $password) {

        $stmt = $this->conn->prepare("
            SELECT * FROM users 
            WHERE email = ? AND password = ?
        ");

        $stmt->execute([
            $email,
            md5($password)
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}