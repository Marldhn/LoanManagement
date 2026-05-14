<?php
require_once "../app/models/Borrower.php";

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /LoanManagement/public/index.php?url=auth/login");
    exit;
}

class BorrowerController {

    private $borrower;

    public function __construct() {
        $this->borrower = new Borrower();
    }

    public function index() {

        $borrowers = $this->borrower->getAll();

        require "../app/views/borrowers/index.php";
    }

    public function create() {
        require "../app/views/borrowers/create.php";
    }

    public function store() {

        $this->borrower->create([
            "fullname" => $_POST['fullname'],
            "contact" => $_POST['contact'],
            "address" => $_POST['address']
        ]);

        header("Location: /LoanManagement/public/index.php?url=borrower/index");
        exit;
    }
}