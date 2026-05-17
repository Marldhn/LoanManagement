<?php

require_once "../core/Model.php";

class Payment extends Model {

    // GET ALL PAYMENTS BY LOAN
    public function getByLoan($loan_id) {

        $stmt = $this->conn->prepare("
            SELECT 
                payments.*,
                accounts.account_name
            FROM payments
            LEFT JOIN accounts 
                ON payments.account_id = accounts.id
            WHERE payments.loan_id = ?
            ORDER BY payments.created_at DESC
        ");

        $stmt->execute([$loan_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}