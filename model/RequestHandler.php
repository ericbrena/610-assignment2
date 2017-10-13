<?php

require_once("ConstNames.php");

class RequestHandler {
    public function requestRegisterPage() {
        return substr($_SERVER['REQUEST_URI'], 0, 10) === ConstNames::registerURL;
    }

    public function controlRequest($id) {
        return isset($_REQUEST[$id]);
    }

    public function getPostRequest($id) {
        return $_POST[$id];
    }
}