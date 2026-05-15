<?php
require_once "../core/Model.php";

class Borrower extends Model {

    public function getAll() {

        $stmt = $this->conn->prepare("
            SELECT * FROM borrowers ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO borrowers (fullname, contact, address)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $data['fullname'],
            $data['contact'],
            $data['address']
        ]);
    }


    public function getById($id) {

    $stmt = $this->conn->prepare("
        SELECT * FROM borrowers WHERE id = ?
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function update($data) {

    $stmt = $this->conn->prepare("
        UPDATE borrowers
        SET fullname = ?, contact = ?, address = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $data['fullname'],
        $data['contact'],
        $data['address'],
        $data['id']
    ]);
}


public function delete($id) {

    $stmt = $this->conn->prepare("
        DELETE FROM borrowers WHERE id = ?
    ");

    return $stmt->execute([$id]);
}



public function getLoans($borrower_id) {

    $stmt = $this->conn->prepare("
      SELECT 
    loans.*,

    COALESCE(
        GROUP_CONCAT(
            CONCAT(
                accounts.account_name,
                ' (₱', loan_accounts.amount, ')'
            )
            SEPARATOR ', '
        ),
        ''
    ) AS account_names,

    COALESCE(p.total_penalty, 0) AS total_penalty

FROM loans

LEFT JOIN loan_accounts 
    ON loans.id = loan_accounts.loan_id

LEFT JOIN accounts 
    ON loan_accounts.account_id = accounts.id

LEFT JOIN (
    SELECT loan_id, SUM(amount) AS total_penalty
    FROM penalties
    GROUP BY loan_id
) p ON loans.id = p.loan_id

WHERE loans.borrower_id = ?

GROUP BY loans.id

ORDER BY loans.id DESC
    ");

    $stmt->execute([$borrower_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}