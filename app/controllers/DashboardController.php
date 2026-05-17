<?php

require_once "../core/Model.php";

class DashboardController extends Model {

    public function index() {

        // TOTAL BORROWERS
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM borrowers
        ");
        $stmt->execute();
        $totalBorrowers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // TOTAL ACCOUNTS
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM accounts
        ");
        $stmt->execute();
        $totalAccounts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // TOTAL LOANS
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total
            FROM loans
            WHERE is_deleted = 0
        ");
        $stmt->execute();
        $totalLoans = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // TOTAL LOAN AMOUNT
        $stmt = $this->conn->prepare("
            SELECT SUM(amount) as total
            FROM loans
            WHERE is_deleted = 0
        ");
        $stmt->execute();
        $totalAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // TOTAL ACCOUNT BALANCE
        $stmt = $this->conn->prepare("
            SELECT SUM(balance) as total
            FROM accounts
        ");
        $stmt->execute();
        $totalAccountBalance = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // TOTAL PROFIT (INTEREST ONLY)
        $stmt = $this->conn->prepare("
            SELECT SUM(total - amount) as profit
            FROM loans
            WHERE is_deleted = 0
        ");
        $stmt->execute();
        $profit = $stmt->fetch(PDO::FETCH_ASSOC)['profit'] ?? 0;

        // RECENT LOANS
        $stmt = $this->conn->prepare("
            SELECT loans.*, borrowers.fullname as borrower_name
            FROM loans
            LEFT JOIN borrowers
            ON loans.borrower_id = borrowers.id
            WHERE loans.is_deleted = 0
            ORDER BY loans.id DESC
            LIMIT 5
        ");

        $stmt->execute();

        $recentLoans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require "../app/views/dashboard/index.php";
    }
}