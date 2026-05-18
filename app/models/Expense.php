<?php

require_once "../core/Model.php";

class Expense extends Model {

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT * FROM expenses ORDER BY id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO expenses (account_id, amount, description)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['account_id'],
            $data['amount'],
            $data['description']
        ]);
    }


    public function getTotal() {

    $stmt = $this->conn->prepare("
        SELECT COALESCE(SUM(amount),0) AS total
        FROM expenses
    ");

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
}