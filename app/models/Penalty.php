<?php

require_once "../core/Model.php";

class Penalty extends Model {

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO penalties
            (loan_id, borrower_id, amount, reason)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['loan_id'],
            $data['borrower_id'],
            $data['amount'],
            $data['reason']
        ]);
    }

    public function getByLoanId($loan_id) {

        $stmt = $this->conn->prepare("
            SELECT * FROM penalties WHERE loan_id = ?
        ");

        $stmt->execute([$loan_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}