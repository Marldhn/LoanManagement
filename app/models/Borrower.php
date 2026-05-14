<?php
require_once "../core/Model.php";

class Borrower extends Model {

    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM borrowers ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO borrowers (fullname, contact, address)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['fullname'],
            $data['contact'],
            $data['address']
        ]);
    }
}