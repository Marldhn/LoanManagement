<?php

session_start();

require_once "../app/models/User.php";

class ProfileController {

    public function index() {

        if (!isset($_SESSION['user'])) {
            header("Location: /LoanManagement/public/index.php?url=auth/login");
            exit;
        }

        $user = $_SESSION['user'];

        require "../app/views/profile/index.php";
    }
}