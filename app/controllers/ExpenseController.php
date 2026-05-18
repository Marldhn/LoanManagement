<?php

require_once "../app/models/Expense.php";
require_once "../app/models/Account.php";

class ExpenseController {

    private $expense;
    private $account;

    public function __construct() {
        $this->expense = new Expense();
        $this->account = new Account();
    }

    // LIST
    public function index() {
        $expenses = $this->expense->getAll();
        $accounts = $this->account->getAll();

        require "../app/views/expenses/index.php";
    }

    // STORE
    public function store() {

        $account_id = $_POST['account_id'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $description = $_POST['description'] ?? '';

        if (!$account_id || !$amount) {
            die("Invalid input");
        }

        // 1. save expense
        $this->expense->create([
            "account_id" => $account_id,
            "amount" => $amount,
            "description" => $description
        ]);

        // 2. deduct from account
        $this->account->deductBalance($account_id, $amount);

        header("Location: /LoanManagement/public/index.php?url=expense/index");
        exit;
    }
}