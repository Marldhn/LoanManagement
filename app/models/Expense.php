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
        SELECT COALESCE(SUM(amount),0) as total
        FROM expenses
    ");

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

    public function getMonthlyTotal() {

    $stmt = $this->conn->prepare("
        SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
               SUM(amount) as total
        FROM expenses
        GROUP BY month
        ORDER BY month ASC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

