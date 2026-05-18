<?php

require_once "../core/Model.php";

class Loan extends Model {

    // =========================
    // GET ALL LOANS
    // =========================
public function getAll($search = '', $status = '', $date = '') {

    $sql = "
        SELECT 
            loans.*,
            borrowers.fullname AS borrower_name,

            COALESCE(acc.account_names, '') AS account_names,
            COALESCE(p.total_penalty, 0) AS total_penalty,
            COALESCE(pay.total_paid, 0) AS total_paid,

            (loans.total + COALESCE(p.total_penalty, 0)) AS overall_total

        FROM loans

        LEFT JOIN borrowers 
            ON loans.borrower_id = borrowers.id

        LEFT JOIN (
            SELECT 
                la.loan_id,
                GROUP_CONCAT(
                    CONCAT(a.account_name, ' (₱', la.amount, ')')
                    SEPARATOR ', '
                ) AS account_names
            FROM loan_accounts la
            LEFT JOIN accounts a 
                ON la.account_id = a.id
            GROUP BY la.loan_id
        ) acc ON loans.id = acc.loan_id

        LEFT JOIN (
            SELECT loan_id, SUM(amount) AS total_paid
            FROM payments
            GROUP BY loan_id
        ) pay ON loans.id = pay.loan_id

        LEFT JOIN (
            SELECT loan_id, SUM(amount) AS total_penalty
            FROM penalties
            GROUP BY loan_id
        ) p ON loans.id = p.loan_id

        WHERE 1=1
    ";

    // SEARCH
    if (!empty($search)) {
        $sql .= "
            AND (
                borrowers.fullname LIKE :search
                OR acc.account_names LIKE :search
            )
        ";
    }

    // =========================
// STATUS FILTER (FIXED)
// =========================
if ($status !== '') {

    // NOT PAID = NO PAYMENT AT ALL
    if ($status === 'not_paid') {
        $sql .= " AND COALESCE(pay.total_paid,0) = 0";
    }

    // PAID = FULLY PAID LOAN
    if ($status === 'paid') {
        $sql .= " AND (loans.total + COALESCE(p.total_penalty,0)) <= COALESCE(pay.total_paid,0)";
    }

    // ACTIVE = PARTIALLY PAID
    if ($status === 'active') {
        $sql .= "
            AND COALESCE(pay.total_paid,0) > 0
            AND (loans.total + COALESCE(p.total_penalty,0)) > COALESCE(pay.total_paid,0)
        ";
    }

    // OVERDUE = NOT FULLY PAID AND PAST DUE DATE
    if ($status === 'overdue') {
        $sql .= "
            AND loans.due_date < CURDATE()
            AND (loans.total + COALESCE(p.total_penalty,0)) > COALESCE(pay.total_paid,0)
        ";
    }
}

    // DATE FILTER
    if (!empty($date)) {
        $sql .= " AND loans.borrowed_date = :date";
    }

    $sql .= " ORDER BY loans.id DESC";

    $stmt = $this->conn->prepare($sql);

    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%");
    }

    if (!empty($date)) {
        $stmt->bindValue(':date', $date);
    }

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
    ) AS account_names,

    COALESCE(p.total_penalty, 0) AS total_penalty,
    COALESCE(pay.total_paid, 0) AS total_paid

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

LEFT JOIN (
    SELECT loan_id, SUM(amount) AS total_paid
    FROM payments
    GROUP BY loan_id
) pay ON loans.id = pay.loan_id

WHERE loans.is_deleted = 0

GROUP BY loans.id
    ");

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function addPayment($loan_id, $amount, $notes, $account_id) {

    $stmt = $this->conn->prepare("
        INSERT INTO payments (loan_id, amount, notes, account_id, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");

    return $stmt->execute([
        $loan_id,
        $amount,
        $notes,
        $account_id
    ]);
}


public function getTotalPaid($loan_id) {

    $stmt = $this->conn->prepare("
        SELECT COALESCE(SUM(amount), 0) AS total_paid
        FROM payments
        WHERE loan_id = ?
    ");

    $stmt->execute([$loan_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['total_paid'];
}
    

public function getPayments($loan_id)
{
    $stmt = $this->conn->prepare("
        SELECT * FROM payments 
        WHERE loan_id = ?
        ORDER BY id DESC
    ");
    $stmt->execute([$loan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPenalties($loan_id)
{
    $stmt = $this->conn->prepare("
        SELECT * FROM penalties 
        WHERE loan_id = ?
        ORDER BY id DESC
    ");
    $stmt->execute([$loan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getLoanAccounts($loan_id)
{
    $stmt = $this->conn->prepare("
        SELECT 
            la.amount,
            a.account_name
        FROM loan_accounts la
        LEFT JOIN accounts a ON la.account_id = a.id
        WHERE la.loan_id = ?
    ");
    $stmt->execute([$loan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getLoanProfitView() {

    $stmt = $this->conn->prepare("
        SELECT 
            loans.id,
            loans.amount,
            COALESCE(loans.total,0) AS loan_total,
            borrowers.fullname AS borrower_name,

            COALESCE(pay.total_paid, 0) AS total_paid,
            COALESCE(p.total_penalty, 0) AS total_penalty,

            (COALESCE(loans.total,0) + COALESCE(p.total_penalty,0)) AS overall_total,

            -- EXPECTED PROFIT
            ((COALESCE(loans.total,0) + COALESCE(p.total_penalty,0)) - COALESCE(loans.amount,0)) AS expected_profit,

            -- REALIZED PROFIT
            (COALESCE(pay.total_paid,0) - COALESCE(loans.amount,0)) AS realized_profit,

            CASE
                WHEN COALESCE(pay.total_paid,0) >= (COALESCE(loans.total,0) + COALESCE(p.total_penalty,0)) THEN 'PAID'
                WHEN COALESCE(pay.total_paid,0) = 0 THEN 'NOT PAID'
                WHEN COALESCE(pay.total_paid,0) > 0 
                     AND COALESCE(pay.total_paid,0) < (COALESCE(loans.total,0) + COALESCE(p.total_penalty,0))
                     AND loans.due_date >= CURDATE() THEN 'ACTIVE'
                WHEN loans.due_date < CURDATE() 
                     AND COALESCE(pay.total_paid,0) < (COALESCE(loans.total,0) + COALESCE(p.total_penalty,0)) THEN 'OVERDUE'
                ELSE 'ACTIVE'
            END AS status

        FROM loans

        LEFT JOIN borrowers 
            ON loans.borrower_id = borrowers.id

        LEFT JOIN (
            SELECT loan_id, SUM(amount) AS total_paid
            FROM payments
            GROUP BY loan_id
        ) pay ON loans.id = pay.loan_id

        LEFT JOIN (
            SELECT loan_id, SUM(amount) AS total_penalty
            FROM penalties
            GROUP BY loan_id
        ) p ON loans.id = p.loan_id

        WHERE loans.is_deleted = 0
        ORDER BY loans.id DESC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}