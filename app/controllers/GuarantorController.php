<?php
require_once "../app/models/Guarantor.php";

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /LoanManagement/public/index.php?url=auth/login");
    exit;
}

class GuarantorController {

    private $guarantor;

    public function __construct() {
        $this->guarantor = new Guarantor();
    }

    public function index() {

        $guarantors = $this->guarantor->getAll();

        require "../app/views/guarantors/index.php";
    }

    public function create() {
        require "../app/views/guarantors/create.php";
    }

    public function store() {

        $this->guarantor->create([
            "fullname" => $_POST['fullname'],
            "contact" => $_POST['contact'],
            "address" => $_POST['address']
        ]);

        header("Location: /LoanManagement/public/index.php?url=guarantor/index");
        exit;
    }
}