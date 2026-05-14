<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /LoanManagement/public/index.php?url=auth/login");
    exit;
}

require_once "../app/models/Account.php";

class AccountController {

    private $account;

    public function __construct() {
        $this->account = new Account();
    }

    // ----------------------------
    // ACCOUNT LIST
    // ----------------------------
    public function index() {

        $accounts = $this->account->getAll();

        require "../app/views/accounts/index.php";
    }

    // ----------------------------
    // CREATE VIEW
    // ----------------------------
    public function create() {

        require "../app/views/accounts/create.php";
    }

    // ----------------------------
    // STORE ACCOUNT
    // ----------------------------
    public function store() {

        $this->account->create([
            "account_name" => $_POST['account_name'],
            "balance" => $_POST['balance'],
            "description" => $_POST['description']
        ]);

        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }

    // ----------------------------
    // TRANSFER FORM VIEW
    // ----------------------------
    public function transferForm() {

        $accounts = $this->account->getAll();

        require "../app/views/accounts/transfer.php";
    }

    // ----------------------------
    // TRANSFER PROCESS
    // ----------------------------
    public function transferStore() {

        $from = $_POST['from_account'] ?? null;
        $to = $_POST['to_account'] ?? null;
        $amount = $_POST['amount'] ?? null;

        // VALIDATION
        if (!$from || !$to || !$amount) {
            die("Missing transfer data");
        }

        if ($from == $to) {
            die("Cannot transfer to same account");
        }

        // EXECUTE TRANSFER
        $this->account->transfer($from, $to, $amount);

        // REDIRECT BACK
        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }
}