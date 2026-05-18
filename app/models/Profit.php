<?php

require_once "../core/Model.php";

class Profit extends Model {

    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM profits ORDER BY id DESC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO profits (source, amount, type, reference_id)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['source'],
            $data['amount'],
            $data['type'],
            $data['reference_id']
        ]);
    }

    public function getTotal() {

        $stmt = $this->conn->prepare("
            SELECT COALESCE(SUM(amount),0) as total FROM profits
        ");

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getMonthlyTotal() {

    $stmt = $this->conn->prepare("
        SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
               SUM(amount) as total
        FROM profits
        GROUP BY month
        ORDER BY month ASC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}