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

    public function index() {

        $accounts = $this->account->getAll();

        require "../app/views/accounts/index.php";
    }

    public function create() {
        require "../app/views/accounts/create.php";
    }

    public function store() {

        $this->account->create([
            "account_name" => $_POST['account_name'],
            "balance" => $_POST['balance'],
            "description" => $_POST['description']
        ]);

        header("Location: /LoanManagement/public/index.php?url=account/index");
        exit;
    }
}