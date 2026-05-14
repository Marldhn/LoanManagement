<?php
require_once "../app/models/Loan.php";

class LoanController {

    private $loan;

    public function __construct() {
        $this->loan = new Loan();
    }

    public function index() {
        $loans = $this->loan->getAll();
        require "../app/views/loans/index.php";
    }

    public function create() {
        require "../app/views/loans/create.php";
    }

    public function store() {

        $amount = $_POST['amount'];
        $interest = $_POST['interest'];

        $total = $amount + ($amount * $interest / 100);

        $this->loan->create([
            "borrower_name" => $_POST['borrower_name'],
            "amount" => $amount,
            "interest" => $interest,
            "total" => $total
        ]);

        header("Location: ../loan/index");
    }
}