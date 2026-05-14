<?php
require_once "../core/Model.php";

class Loan extends Model {

   public function getAll() {

    $stmt = $this->conn->prepare("
        SELECT
            loans.*,

            borrowers.fullname AS borrower_name,

            GROUP_CONCAT(
                CONCAT(
                    accounts.account_name,
                    ' (₱',
                    loan_accounts.amount,
                    ')'
                )
                SEPARATOR ', '
            ) AS account_names

        FROM loans

        LEFT JOIN borrowers
            ON loans.borrower_id = borrowers.id

        LEFT JOIN loan_accounts
            ON loans.id = loan_accounts.loan_id

        LEFT JOIN accounts
            ON loan_accounts.account_id = accounts.id

        GROUP BY loans.id

        ORDER BY loans.id DESC
    ");

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO loans
            (borrower_id, amount, interest, total)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['borrower_id'],
            $data['amount'],
            $data['interest'],
            $data['total']
        ]);
    }

    public function getLastId() {
        return $this->conn->lastInsertId();
    }
}