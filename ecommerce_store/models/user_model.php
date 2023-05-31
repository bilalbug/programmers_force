<?php
require_once 'C:\xampp\htdocs\programmers_force\ecommerce_store\connect_db.php';
class User
{
  private $userID;
  private $username;
  private $email;
  private $password;
  private $firstName;
  private $lastName;
  private $address;
  private $phoneNumber;
  private $connect;

  public function __construct($username, $email, $password, $firstName, $lastName, $address, $phoneNumber)
  {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->address = $address;
    $this->phoneNumber = $phoneNumber;
    $this->connect = new PgConnection("localhost", "ecommerce_store", "postgres", "1166");
    $this->connect->connect();
  }

  public function save()
  {
    $username = $this->username;
    $email = $this->email;
    $password = $this->password;
    $firstName = $this->firstName;
    $lastName = $this->lastName;
    $address = $this->address;
    $phoneNumber = $this->phoneNumber;

    $query = "INSERT INTO users (username, email, password, firstname, lastname, address, phonenumber) 
              VALUES ($1, $2, $3, $4, $5, $6, $7)";
    $params = [$username, $email, $password, $firstName, $lastName, $address, $phoneNumber];

    // Execute the query
    $this->connect->query($query, $params);
  }


  public static function getUserByID($userID)
  {
    $db = pg_connect("host=localhost dbname=ecommerce_store user=postgres password=1166");
    $query = "SELECT * FROM users WHERE user_id = $1";
    $result = pg_query_params($db, $query, [$userID]);

    if (!$result) {
      echo "Query execution failed!";
      return null;
    }

    $row = pg_fetch_assoc($result);

    if ($row) {
      $user = new User($row['username'], $row['email'], $row['password'], $row['first_name'], $row['last_name'], $row['address'], $row['phone_number']);
      $user->setUserID($row['user_id']);
      return $user;
    }

    return null;
  }

  public function getAllUsers()
  {
    $query = "SELECT * FROM users";
    $result = $this->connect->query($query);

    if (!$result) {
      echo "Query execution failed!";
      return [];
    }

    $users = [];

    while ($row = pg_fetch_assoc($result)) {
      $user = new User($row['username'], $row['email'], $row['password'], $row['firstname'], $row['lastname'], $row['address'], $row['phonenumber']);
      $user->setUserID($row['userid']);
      $users[] = $user;
    }
    return $users;
  }

  public function update()
  {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE users SET username = ?, email = ?, password = ?, first_name = ?, last_name = ?, address = ?, phone_number = ? WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->username, $this->email, $this->password, $this->firstName, $this->lastName, $this->address, $this->phoneNumber, $this->userID]);
  }

  public function delete()
  {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->userID]);
  }

  // Getters and setters
  public function getUserID()
  {
    return $this->userID;
  }

  public function setUserID($userID)
  {
    $this->userID = $userID;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function setAddress($address)
  {
    $this->address = $address;
  }

  public function getPhoneNumber()
  {
    return $this->phoneNumber;
  }

  public function setPhoneNumber($phoneNumber)
  {
    $this->phoneNumber = $phoneNumber;
  }
}
