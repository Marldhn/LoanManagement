<?php
require_once "../core/Model.php";

class User extends Model {

    public function login($email, $password) {

        $stmt = $this->conn->prepare("
            SELECT * FROM users WHERE email = ?
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }


    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role']
        ]);
    }
    
 public function findByEmail($email) {

        $stmt = $this->conn->prepare("
            SELECT * FROM users WHERE email = ?
        ");

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}