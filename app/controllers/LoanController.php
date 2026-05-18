<?php

require_once __DIR__ . "/../models/Loan.php";
require_once __DIR__ . "/../models/Borrower.php";
require_once __DIR__ . "/../models/Account.php";
require_once __DIR__ . "/../models/Guarantor.php";
require_once __DIR__ . "/../models/Penalty.php";
require_once __DIR__ . "/../models/Payment.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /LoanManagement/public/index.php?url=auth/login");
    exit;
}

class LoanController {

    private $loan;

    public function __construct() {
        $this->loan = new Loan();
    }

    // =========================
    // LIST LOANS
    // =========================
   public function index() {

    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? 'active'; 
    $date = $_GET['date'] ?? '';
    $loans = $this->loan->getAll($search, $status, $date);

    // 🔥 ADD THIS
    $accounts = (new Account())->getAll();

    require "../app/views/loans/index.php";
}

    public function all() {

    $loans = $this->loan->getAllAll();

    require "../app/views/loans/all.php";
}

    // =========================
    // CREATE VIEW
    // =========================
    public function create() {

        $borrowers = (new Borrower())->getAll();
        $accounts = (new Account())->getAll();
        $guarantors = (new Guarantor())->getAll();

        require "../app/views/loans/create.php";
    }

    // =========================
    // STORE LOAN
    // =========================
    public function store() {

    $borrower_id = $_POST['borrower_id'];
    $guarantor_id = $_POST['guarantor_id'] ?? null;

    $amount = $_POST['amount'];
    $interest = $_POST['interest'];
    $days = $_POST['days'];
    $borrowed_date = $_POST['borrowed_date'];

    // AUTO COMPUTE DUE DATE
    $due_date = date('Y-m-d', strtotime($borrowed_date . " + $days days"));

    // TOTAL LOAN WITH INTEREST
    $total = $amount + ($amount * ($interest / 100));

    // =========================
    // SAVE LOAN
    // =========================
    $this->loan->create([
        "borrower_id" => $borrower_id,
        "guarantor_id" => $guarantor_id ?: null,
        "borrowed_date" => $borrowed_date,
        "due_date" => $due_date,
        "amount" => $amount,
        "interest" => $interest,
        "total" => $total
    ]);

    $loan_id = $this->loan->getLastId();

    // =========================
    // MULTI ACCOUNT FUNDING
    // =========================
    $account_ids = $_POST['account_id'] ?? [];
    $account_amounts = $_POST['account_amount'] ?? [];

    $accountModel = new Account();

    $total_funding = array_sum($account_amounts);

    if ($total_funding != $amount) {

        $_SESSION['error'] = "Funding must equal loan amount.";

        require_once "../app/models/Borrower.php";
        require_once "../app/models/Guarantor.php";
        require_once "../app/models/Account.php";

        $borrowers = (new Borrower())->getAll();
        $guarantors = (new Guarantor())->getAll();
        $accounts = (new Account())->getAll();

        require "../app/views/loans/create.php";
        return;
    }

    foreach ($account_ids as $index => $account_id) {

        $deduct = $account_amounts[$index];

        $accountModel->saveLoanAccount(
            $loan_id,
            $account_id,
            $deduct
        );

        $accountModel->deductBalance(
            $account_id,
            $deduct
        );
    }

    // =========================
    // AUTO CREATE PROFIT RECORD
    // =========================
    require_once "../app/models/Profit.php";

    $profitModel = new Profit();

    // PROFIT = INTEREST ONLY
    $profitAmount = $total - $amount;

    $profitModel->create([
        "source" => "Loan Interest",
        "amount" => $profitAmount,
        "type" => "loan",
        "reference_id" => $loan_id
    ]);

    // =========================
    // REDIRECT
    // =========================
    header("Location: /LoanManagement/public/index.php?url=loan/index");
    exit;
}

    // =========================
    // EDIT VIEW
    // =========================
    public function edit($id) {

        $loan = $this->loan->getById($id);

        $borrowers = (new Borrower())->getAll();
        $accounts = (new Account())->getAll();
        $guarantors = (new Guarantor())->getAll();

        require "../app/views/loans/edit.php";
    }

    // =========================
    // UPDATE
    // =========================
    public function update() {

        $amount = $_POST['amount'];
        $interest = $_POST['interest'];

        $total = $amount + ($amount * ($interest / 100));

        $this->loan->update([
            "id" => $_POST['id'],
            "borrower_id" => $_POST['borrower_id'],
            "guarantor_id" => $_POST['guarantor_id'] ?? null,
            "borrowed_date" => $_POST['borrowed_date'],
            "due_date" => $_POST['due_date'],
            "amount" => $amount,
            "interest" => $interest,
            "total" => $total
        ]);

        header("Location: /LoanManagement/public/index.php?url=loan/index");
        exit;
    }

    // =========================
    // DELETE
    // =========================
    public function forcedelete($id) {

    $this->loan->forcedelete($id);

    header("Location: /LoanManagement/public/index.php?url=loan/all");
    exit;
}

    public function addPenalty() {

    $penalty = new Penalty();

    $loan_id = $_POST['loan_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];

    // GET borrower_id FROM LOAN
    $loan = $this->loan->getById($loan_id);
    $borrower_id = $loan['borrower_id'];

    // AUTO penalty logic
    if ($amount == "auto") {
        $amount = $loan['amount'] * 0.10;
    }

    $penalty->create([
        "loan_id" => $loan_id,
        "borrower_id" => $borrower_id,
        "amount" => $amount,
        "reason" => $reason
    ]);

    header("Location: /LoanManagement/public/index.php?url=loan/index");
    exit;
}


public function addPayment() {

    $loan_id = $_POST['loan_id'];
    $amount = $_POST['amount'];
    $notes = $_POST['notes'] ?? '';
    $account_id = $_POST['account_id'];

    // =========================
    // SAVE PAYMENT
    // =========================
    $this->loan->addPayment(
        $loan_id,
        $amount,
        $notes,
        $account_id
    );

    // =========================
    // UPDATE ACCOUNT BALANCE
    // =========================
    require_once "../app/models/Account.php";
    $account = new Account();

    if (!empty($account_id) && $amount > 0) {

        $account->addBalance(
            $account_id,
            $amount
        );
    }

    // =========================
    // AUTO SAVE PROFIT
    // =========================
    require_once "../app/models/Profit.php";

    $profitModel = new Profit();

    // GET LOAN
    $loan = $this->loan->getById($loan_id);

    // TOTAL PROFIT OF LOAN
    $expectedProfit = $loan['total'] - $loan['amount'];

    // TOTAL PAID
    $totalPaid = $this->loan->getTotalPaid($loan_id);

    // REAL PROFIT ONLY
    $realProfit = $totalPaid - $loan['amount'];

    // NEVER NEGATIVE
    if ($realProfit < 0) {
        $realProfit = 0;
    }

    // LIMIT TO EXPECTED PROFIT
    if ($realProfit > $expectedProfit) {
        $realProfit = $expectedProfit;
    }

    // SAVE ONLY IF HAS PROFIT
    if ($realProfit > 0) {

        $profitModel->create([
            "loan_id" => $loan_id,
            "account_id" => $account_id,
            "source" => "Loan Interest",
            "amount" => $realProfit,
            "type" => "loan",
            "notes" => $notes
        ]);
    }

    // =========================
    // REDIRECT
    // =========================
    header("Location: /LoanManagement/public/index.php?url=loan/details/$loan_id");
    exit;
}


public function details($id) {

    $loan = $this->loan->getById($id);

    $payments = $this->loan->getPayments($id);
    $penalties = $this->loan->getPenalties($id);
    $accounts = (new Account())->getAll(); // ✅ THIS IS REQUIRED

    require "../app/views/loans/details.php";
}


public function profit() {

    $loanModel = new Loan();

    // ALWAYS USE FULL CALCULATED DATA
    $profits = $loanModel->getLoanProfitView();

    // safety fallback (prevents undefined keys)
    foreach ($profits as &$p) {

        $p['paid'] = $p['total_paid'] ?? 0;
        $p['expected_profit'] = $p['expected_profit'] ?? 0;
        $p['realized_profit'] = $p['realized_profit'] ?? 0;
        $p['status'] = $p['status'] ?? 'ACTIVE';
    }

    require "../app/views/loans/profit.php";
}
}