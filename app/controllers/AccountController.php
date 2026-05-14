<?php
require_once "../app/models/Account.php";

class AccountController {

    private $account;

    public function __construct() {
        $this->account = new Account();
    }

    public function index() {
        $accounts = $this->account->getAll();
        require "../app/views/accounts/list.php";
    }

    public function create() {
        require "../app/views/accounts/create.php";
    }

    public function store() {

        $balance = $_POST['balance'];
        $description = $_POST['description'];

        $this->account->create([
            "account_name" => $_POST['account_name'],
            "balance" => $balance,
            "description" => $description
        ]);

        header("Location: ../account/index");
    }
}