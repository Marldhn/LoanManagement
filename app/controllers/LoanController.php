<?php

require_once __DIR__ . "/../models/Loan.php";
require_once __DIR__ . "/../models/Borrower.php";
require_once __DIR__ . "/../models/Account.php";
require_once __DIR__ . "/../models/Guarantor.php";

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

        $loans = $this->loan->getAll();

        require "../app/views/loans/index.php";
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
$days = $_POST['days'];

// AUTO COMPUTE DUE DATE
$due_date = date('Y-m-d', strtotime($borrowed_date . " + $days days"));

        $total = $amount + ($amount * ($interest / 100));

        // SAVE LOAN
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

        // MULTI ACCOUNT FUNDING
        $account_ids = $_POST['account_id'] ?? [];
        $account_amounts = $_POST['account_amount'] ?? [];

        $accountModel = new Account();

        $total_funding = array_sum($account_amounts);

        if ($total_funding != $amount) {
            die("Error: Funding must equal loan amount.");
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
    public function delete($id) {

        $this->loan->delete($id);

        header("Location: /LoanManagement/public/index.php?url=loan/index");
        exit;
    }
}