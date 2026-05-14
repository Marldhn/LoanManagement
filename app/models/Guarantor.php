<?php
require_once "../core/Model.php";

class Guarantor extends Model {

    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM guarantors ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO guarantors (fullname, contact, address)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['fullname'],
            $data['contact'],
            $data['address']
        ]);
    }
}