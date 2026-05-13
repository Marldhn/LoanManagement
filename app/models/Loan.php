<?php
require_once "../core/Model.php";

class Loan extends Model {

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM loans ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO loans (borrower_name, amount, interest, total)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['borrower_name'],
            $data['amount'],
            $data['interest'],
            $data['total']
        ]);
    }
}