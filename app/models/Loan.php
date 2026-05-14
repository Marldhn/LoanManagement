<?php

require_once "../core/Model.php";

class Loan extends Model {

    // =========================
    // GET ALL LOANS
    // =========================
    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT 
                loans.*,
                borrowers.fullname AS borrower_name,

                COALESCE(
                    GROUP_CONCAT(
                        CONCAT(
                            accounts.account_name,
                            ' (₱',
                            loan_accounts.amount,
                            ')'
                        )
                        SEPARATOR ', '
                    ),
                    ''
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

    // =========================
    // CREATE LOAN
    // =========================
   public function create($data) {

    $stmt = $this->conn->prepare("
        INSERT INTO loans
        (
            borrower_id,
            guarantor_id,
            borrowed_date,
            due_date,
            amount,
            interest,
            total
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $data['borrower_id'],
        $data['guarantor_id'],
        $data['borrowed_date'],
        $data['due_date'],
        $data['amount'],
        $data['interest'],
        $data['total']
    ]);
}
    // =========================
    // GET SINGLE LOAN
    // =========================
    public function getById($id) {

        $stmt = $this->conn->prepare("
            SELECT * FROM loans WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================
    // UPDATE LOAN
    // =========================
    public function update($data) {

        $stmt = $this->conn->prepare("
            UPDATE loans
            SET borrower_id = ?,
                guarantor_id = ?,
                amount = ?,
                interest = ?,
                total = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['borrower_id'],
            $data['guarantor_id'],
            $data['amount'],
            $data['interest'],
            $data['total'],
            $data['id']
        ]);
    }

    // =========================
    // DELETE LOAN
    // =========================
    public function delete($id) {

        $stmt = $this->conn->prepare("
            DELETE FROM loans WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // =========================
    // LAST INSERT ID
    // =========================
    public function getLastId() {
        return $this->conn->lastInsertId();
    }



    
}