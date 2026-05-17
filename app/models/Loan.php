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
            ) AS account_names,

            COALESCE(p.total_penalty, 0) AS total_penalty

        FROM loans

        LEFT JOIN borrowers 
            ON loans.borrower_id = borrowers.id

        LEFT JOIN loan_accounts 
            ON loans.id = loan_accounts.loan_id

        LEFT JOIN accounts 
            ON loan_accounts.account_id = accounts.id

        LEFT JOIN (
            SELECT loan_id, SUM(amount) AS total_penalty
            FROM penalties
            GROUP BY loan_id
        ) p ON loans.id = p.loan_id

        WHERE loans.is_deleted = 0

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

    require_once __DIR__ . "/Account.php";
    $accountModel = new Account();

    // 1. get funding records
    $stmt = $this->conn->prepare("
        SELECT account_id, amount 
        FROM loan_accounts 
        WHERE loan_id = ?
    ");
    $stmt->execute([$id]);
    $fundings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. restore balances
    foreach ($fundings as $f) {
        $accountModel->addBalance($f['account_id'], $f['amount']);
    }

    // 3. mark loan as deleted (SOFT DELETE)
    $stmt = $this->conn->prepare("
        UPDATE loans 
        SET is_deleted = 1 
        WHERE id = ?
    ");

    return $stmt->execute([$id]);
}


public function forcedelete($id) {

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

public function getAllAll() {

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

    
}