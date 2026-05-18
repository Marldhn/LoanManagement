<?php

require_once "../app/models/Profit.php";
require_once "../app/models/Account.php";

class ProfitController {

    private $profit;
    private $account;

    public function __construct() {
        $this->profit = new Profit();
        $this->account = new Account();
    }

    // ======================
    // INDEX
    // ======================
    public function index() {

        $profits  = $this->profit->getAll();
        $accounts = $this->account->getAll();

        require "../app/views/profits/index.php";
    }

    // ======================
    // STORE PROFIT
    // ======================
    public function storeProfit() {

        $account_id = $_POST['account_id'] ?? null;
        $amount     = $_POST['amount'] ?? 0;
        $source     = $_POST['source'] ?? '';

        // VALIDATION
        if (!$account_id || !$amount || $amount <= 0) {
            die("Invalid input");
        }

        // ======================
        // SAVE PROFIT
        // ======================
        $this->profit->create([
            "source"       => $source,
            "amount"       => $amount,
            "type"         => "PROFIT",
            "reference_id" => $account_id
        ]);

        // ======================
        // UPDATE ACCOUNT BALANCE
        // ======================
        $this->account->addBalance($account_id, $amount);

        // ======================
        // REDIRECT
        // ======================
        header("Location: /LoanManagement/public/index.php?url=profit/index");
        exit;
    }
}