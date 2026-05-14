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


    
    public function getById($id) {

    $stmt = $this->conn->prepare("
        SELECT * FROM guarantors WHERE id = ?
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function update($data) {

    $stmt = $this->conn->prepare("
        UPDATE guarantors
        SET fullname = ?, contact = ?, address = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $data['fullname'],
        $data['contact'],
        $data['address'],
        $data['id']
    ]);
}


public function delete($id) {

    $stmt = $this->conn->prepare("
        DELETE FROM guarantors WHERE id = ?
    ");

    return $stmt->execute([$id]);
}
}