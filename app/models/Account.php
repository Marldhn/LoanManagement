<?php
require_once "../core/Model.php";

class Account extends Model {

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM accounts ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO accounts (account_name, balance, description)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['account_name'],
            $data['balance'],
            $data['description']
        ]);
    }
}