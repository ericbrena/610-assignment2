<?php

class RequestHandler {
    public function logout() {
        $_SESSION[self::$sessionId] = false;
    }
}