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

        $user = $this->user->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user'] = [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ];

            header("Location: /LoanManagement/public/index.php?url=loan/index");
            exit;
        }

        // ❌ INVALID LOGIN → back to login page with error
        header("Location: /LoanManagement/public/index.php?url=auth/login&error=1");
        exit;
    }

    public function logout() {

        session_start();
        session_destroy();

        header("Location: /LoanManagement/public/index.php?url=auth/login");
        exit;
    }

    public function register() {
        require "../app/views/auth/register.php";
    }

    public function storeRegister() {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'] ?? 'user';

        $this->user->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        header("Location: /LoanManagement/public/index.php?url=auth/login");
        exit;
    }
}