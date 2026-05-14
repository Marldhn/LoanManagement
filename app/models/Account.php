<?php
require_once "../core/Model.php";

class Account extends Model {

    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM accounts ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO accounts
            (account_name, balance, description)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['account_name'],
            $data['balance'],
            $data['description']
        ]);
    }

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
}