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

    // ----------------------------
    // GET CURRENT BALANCE
    // ----------------------------
    $accounts = $this->account->getAll();

    $fromBalance = 0;

    foreach ($accounts as $acc) {
        if ($acc['id'] == $from) {
            $fromBalance = $acc['balance'];
            break;
        }
    }

    // ----------------------------
    // CHECK IF ENOUGH BALANCE
    // ----------------------------
    if ($amount > $fromBalance) {
        die("Insufficient balance. Available: " . $fromBalance);
    }

    // ----------------------------
    // DO TRANSFER
    // ----------------------------
    $this->account->transfer($from, $to, $amount);

    header("Location: /LoanManagement/public/index.php?url=account/index");
    exit;
}
}