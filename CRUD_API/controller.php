<?php

include_once 'model.php';

class UserController
{
    private $connection;

    public function __construct($host, $port, $database, $username, $password)
    {
        $this->connection = pg_connect("host=$host port=$port dbname=$database user=$username password=$password");
        if (!$this->connection) {
            die("Connection failed: " . pg_last_error());
        }
    }

    public function addUser($name, $email)
    {
        $id = uniqid(); // Generate a unique ID for the user
        $query = "INSERT INTO users (id, name, email) VALUES ('$id', '$name', '$email')";
        $result = pg_query($this->connection, $query);

        if ($result) {
            return new User($id, $name, $email);
        }
        else
            echo "Operation Failed";
    }

    public function getUser($id)
    {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result = pg_query($this->connection, $query);

        $row = pg_fetch_assoc($result);
        if ($row) {
            return new User($row['id'], $row['name'], $row['email']);
        }

        return null;
    }

    public function updateUser($id, $name, $email)
    {
        $query = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";
        $result = pg_query($this->connection, $query);

        if ($result) {
            return new User($id, $name, $email);
        }

        return null;
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = '$id'";
        $result = pg_query($this->connection, $query);

        if ($result && pg_affected_rows($result) > 0) {
            return new User($id, null, null);
        }

        return null;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = pg_query($this->connection, $query);

        $users = array();
        $i = 0;
        while ($row = pg_fetch_assoc($result)) {

            $users[$i] = $row;
            $i++;
        }

        return $users;
    }
    
}

