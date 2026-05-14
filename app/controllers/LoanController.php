<?php

require_once "../app/models/Loan.php";
require_once "../app/models/Borrower.php";
require_once "../app/models/Account.php";
require_once "../app/models/Guarantor.php";

session_start();

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
    // LOAN LIST
    // =========================
    public function index() {

        $loans = $this->loan->getAll();

        require "../app/views/loans/index.php";
    }

    // =========================
    // CREATE LOAN VIEW
    // =========================
    public function create() {

    $borrowerModel = new Borrower();
    $accountModel = new Account();
    $guarantorModel = new Guarantor();

    $borrowers = $borrowerModel->getAll();
    $accounts = $accountModel->getAll();
    $guarantors = $guarantorModel->getAll();

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

        // compute total loan
        $total = $amount + ($amount * ($interest / 100));

        // save loan
        $this->loan->create([
            "borrower_id" => $borrower_id,
                    "guarantor_id" => $guarantor_id ?: null,

            "amount" => $amount,
            "interest" => $interest,
            "total" => $total
        ]);

        $loan_id = $this->loan->getLastId();

        // multi account funding
        $account_ids = $_POST['account_id'];
        $account_amounts = $_POST['account_amount'];

        $accountModel = new Account();

        $total_funding = array_sum($account_amounts);

        // validation
        if ($total_funding != $amount) {
            die("Error: Funding must equal loan amount.");
        }

        foreach ($account_ids as $index => $account_id) {

            $deduct_amount = $account_amounts[$index];

            // save to loan_accounts (NO direct conn usage)
            $accountModel->saveLoanAccount(
                $loan_id,
                $account_id,
                $deduct_amount
            );

            // deduct balance
            $accountModel->deductBalance(
                $account_id,
                $deduct_amount
            );
        }

        header("Location: /LoanManagement/public/index.php?url=loan/index");
        exit;
    }
}