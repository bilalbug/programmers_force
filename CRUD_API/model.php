<?php

class User
{
    private $id;
    private $name;
    private $email;

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function Display()
    {
        return array($this->id, $this->name, $this->email);
    }
}
