<?php
require_once "../core/Model.php";

class Account extends Model {

    // ----------------------------
    // GET ALL ACCOUNTS
    // ----------------------------
    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM accounts ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------
    // CREATE ACCOUNT
    // ----------------------------
    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO accounts
            (account_name, balance, description, account_number)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['account_name'],
            $data['balance'],
            $data['description'],
            $data['account_number']
        ]);
    }

    // ----------------------------
    // SAVE LOAN ACCOUNT
    // ----------------------------
    public function saveLoanAccount($loan_id, $account_id, $amount) {

        $stmt = $this->conn->prepare("
            INSERT INTO loan_accounts
            (loan_id, account_id, amount)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $loan_id,
            $account_id,
            $amount
        ]);
    }

    // ----------------------------
    // DEDUCT BALANCE
    // ----------------------------
    public function deductBalance($id, $amount) {

        $stmt = $this->conn->prepare("
            UPDATE accounts
            SET balance = balance - ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $amount,
            $id
        ]);
    }

    // ----------------------------
    // TRANSFER MONEY
    // ----------------------------
    public function transfer($from_id, $to_id, $amount) {

        // deduct from sender
        $stmt1 = $this->conn->prepare("
            UPDATE accounts
            SET balance = balance - ?
            WHERE id = ?
        ");
        $stmt1->execute([$amount, $from_id]);

        // add to receiver
        $stmt2 = $this->conn->prepare("
            UPDATE accounts
            SET balance = balance + ?
            WHERE id = ?
        ");
        $stmt2->execute([$amount, $to_id]);
    }


       public function getById($id) {

    $stmt = $this->conn->prepare("
        SELECT * FROM accounts WHERE id = ?
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function update($data) {

    $stmt = $this->conn->prepare("
        UPDATE accounts
        SET account_name = ?, balance = ?, description = ?, account_number = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $data['account_name'],
        $data['balance'],
        $data['description'],
        $data['account_number'],
        $data['id']
    ]);
}


public function delete($id) {

    // 1. get all loan funding records for this account
    $stmt = $this->conn->prepare("
        SELECT loan_id, amount 
        FROM loan_accounts 
        WHERE account_id = ?
    ");
    $stmt->execute([$id]);
    $fundings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. rollback balances (if needed logic)
    foreach ($fundings as $f) {
        $this->addBalance($id, $f['amount']);
    }

    // 3. delete loan_accounts records first
    $stmt = $this->conn->prepare("
        DELETE FROM loan_accounts WHERE account_id = ?
    ");
    $stmt->execute([$id]);

    // 4. delete account
    $stmt = $this->conn->prepare("
        DELETE FROM accounts WHERE id = ?
    ");

    return $stmt->execute([$id]);
}


public function addBalance($id, $amount) {

    $stmt = $this->conn->prepare("
        UPDATE accounts
        SET balance = balance + ?
        WHERE id = ?
    ");

    return $stmt->execute([$amount, $id]);
}


public function getLedger($account_id) {

    $stmt = $this->conn->prepare("

        SELECT 
            'PAYMENT' AS type,
            loan_id,
            amount,
            created_at
        FROM payments
        WHERE account_id = ?

        UNION ALL

        SELECT 
            'FUNDING' AS type,
            loan_id,
            amount,
            created_at
        FROM loan_accounts
        WHERE account_id = ?

        UNION ALL

        SELECT 
            'PROFIT' AS type,
            NULL AS loan_id,
            amount,
            created_at
        FROM profits
        WHERE reference_id = ?

        ORDER BY created_at DESC

    ");

    $stmt->execute([
        $account_id,
        $account_id,
        $account_id
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}