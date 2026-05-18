<?php

require_once "../app/models/Loan.php";
require_once "../app/models/Account.php";
require_once "../app/models/Borrower.php";
require_once "../app/models/Expense.php";
require_once "../app/models/Profit.php";

class DashboardController {

    public function index() {

        $loanModel = new Loan();
        $accountModel = new Account();
        $borrowerModel = new Borrower();
        $profitModel = new Profit();
        $expenseModel = new Expense();

        $profitMonthly = $profitModel->getMonthlyTotal();
$expenseMonthly = $expenseModel->getMonthlyTotal();


        // =========================
        // BASIC COUNTS
        // =========================
        $totalAccounts = count($accountModel->getAll());
        $totalBorrowers = count($borrowerModel->getAll());
        $allLoans = $loanModel->getAll();
        $totalLoans = count($allLoans);
        $totalExpenses = $expenseModel->getTotal();


        $loanMonthly = [];

foreach ($allLoans as $loan) {

    $month = date('Y-m', strtotime($loan['created_at']));

    if (!isset($loanMonthly[$month])) {
        $loanMonthly[$month] = [
            'released' => 0,
            'paid' => 0
        ];
    }

    $loanMonthly[$month]['released'] += $loan['amount'] ?? 0;
    $loanMonthly[$month]['paid'] += $loan['total_paid'] ?? 0;
}

$loanLabels = array_keys($loanMonthly);
$loanReleased = array_column($loanMonthly, 'released');
$loanPaid = array_column($loanMonthly, 'paid');

        // =========================
        // TOTAL ACCOUNT BALANCE
        // =========================
        $totalAccountBalance = 0;
        foreach ($accountModel->getAll() as $acc) {
            $totalAccountBalance += $acc['balance'];
        }

        // =========================
        // RECENT LOANS
        // =========================
        $recentLoans = $allLoans;

        // =========================
        // TOTAL LOAN AMOUNT (ALL LOANS)
        // =========================
        $totalAmount = 0;

        // ❌ OLD PROFIT (KEEPING VARIABLE BUT NOT USED ANYMORE)
        $profit = 0;

        // =========================
        // ACTIVE LOANS + ACTIVE PROFIT
        // =========================
        $totalActiveLoans = 0;
        $activeProfit = 0;

        // ✅ NEW: UPCOMING PROFIT
        $upcomingProfit = 0;

        foreach ($allLoans as $loan) {

            $total = $loan['total'] ?? 0;
            $penalty = $loan['total_penalty'] ?? 0;
            $paid = $loan['total_paid'] ?? 0;
            $amount = $loan['amount'] ?? 0;

            $overall = $total + $penalty;
            $remaining = $overall - $paid;

            // TOTAL LOAN AMOUNT
            $totalAmount += $amount;

            // OLD PROFIT (UNCHANGED)
            $profit += ($paid - $amount);

            // ACTIVE LOANS ONLY
            if ($remaining > 0) {
    $totalActiveLoans++;

    $activeProfit += ($paid - $amount);

    // ✅ ONLY PROFIT (interest + penalty)
    $upcomingProfit += ($total + $penalty) - $amount;
}
        }

        // =========================
        // LOAD VIEW
        // =========================
        require "../app/views/dashboard/index.php";
    }


    
}