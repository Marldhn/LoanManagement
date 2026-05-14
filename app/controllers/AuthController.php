<?php
require_once "../app/models/User.php";

class AuthController {

    private $user;

    public function __construct() {
        session_start();
        $this->user = new User();
    }

    public function login() {
        require "../app/views/auth/login.php";
    }

    public function authenticate() {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->user->login($email, $password);

        if ($user) {

            $_SESSION['user'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: /LoanManagement/public/index.php?url=loan/index");
            exit;

        } else {
            echo "Invalid login credentials";
        }
    }

    public function logout() {

        session_start();
        session_destroy();

        header("Location: /LoanManagement/public/index.php?url=auth/login");
        exit;
    }
}