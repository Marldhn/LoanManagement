<?php

require_once "../app/models/Profit.php";

class ProfitController {

    private $profit;

    public function __construct() {
        $this->profit = new Profit();
    }

    public function index() {

        $profits = $this->profit->getAll();
        $totalProfit = $this->profit->getTotal();

        require "../app/views/profits/index.php";
    }

    public function store() {

        $this->profit->create([
            "source" => $_POST['source'],
            "amount" => $_POST['amount'],
            "type" => "MANUAL",
            "reference_id" => null
        ]);

        header("Location: /LoanManagement/public/index.php?url=profit/index");
        exit;
    }
}