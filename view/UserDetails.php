<?php

class UserDetails {
    public $name;
    public $password;

    public function construct(string $name, string $password) {
        $this->name = $name;
        $this->password = $password;
    }
}