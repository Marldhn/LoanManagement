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
    // LIST
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
    // STORE
    // ----------------------------
    public function store() {

        $this->account->create([
            "account_name" => $_POST['account_name'],
            "balance" => $_POST['balance'],
            "description" => $_POST['description'],
            "account_number" => $_POST['account_number']
        ]);

        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }

    // ----------------------------
    // EDIT (FIXED)
    // ----------------------------
    public function edit($id) {

        $account = $this->account->getById($id);

        require "../app/views/accounts/edit.php";
    }

    // ----------------------------
    // UPDATE (FIXED)
    // ----------------------------
    public function update() {

        $this->account->update([
            "id" => $_POST['id'],
            "account_name" => $_POST['account_name'],
            "balance" => $_POST['balance'],
            "description" => $_POST['description'],
            "account_number" => $_POST['account_number']
        ]);

        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }

    // ----------------------------
    // DELETE (FIXED)
    // ----------------------------
    public function delete($id) {

    $this->account->delete($id);

    header("Location: /LoanManagement/public/index.php?url=account/index");
    exit;
}


public function forcedelete($id) {

    $this->account->delete($id);

    header("Location: /LoanManagement/public/index.php?url=account/index");
    exit;
}
    // ----------------------------
    // TRANSFER FORM
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

        if (!$from || !$to || !$amount) {
            die("Missing transfer data");
        }

        if ($from == $to) {
            die("Cannot transfer to same account");
        }

        // check balance
        $accounts = $this->account->getAll();

        $fromBalance = 0;

        foreach ($accounts as $acc) {
            if ($acc['id'] == $from) {
                $fromBalance = $acc['balance'];
                break;
            }
        }

        if ($amount > $fromBalance) {
            die("Insufficient balance. Available: " . $fromBalance);
        }

        $this->account->transfer($from, $to, $amount);

        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }


    // ✅ FIXED DETAILS (THIS IS THE IMPORTANT PART)
    public function details($id) {

        $account = $this->account->getById($id);

        if (!$account) {
            die("Account not found");
        }

        $ledger = $this->account->getLedger($id);

        require "../app/views/accounts/details.php";
    }
}