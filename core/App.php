<?php

class App {

    protected $controller = "LoanController";
    protected $method = "index";

    public function __construct() {

        $url = $this->parseUrl();

        // ---------------- CONTROLLER FIX ----------------
        if (isset($url[0])) {

            $controllerName = ucfirst($url[0]) . "Controller";
            $controllerFile = "../app/controllers/" . $controllerName . ".php";

            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once "../app/controllers/" . $this->controller . ".php";

        $this->controller = new $this->controller;

        // ---------------- METHOD ----------------
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $params);
    }

    public function parseUrl() {

        if (isset($_GET['url']) && !empty($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }

        return [];
    }
}