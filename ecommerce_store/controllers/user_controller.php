<?php

class UserController {
  public function createUser($username, $email, $password, $firstName, $lastName, $address, $phoneNumber) {
    $user = new User($username, $email, $password, $firstName, $lastName, $address, $phoneNumber);
    $user->save();
    return $user;
  }

  public function updateUser($userID, $username, $email, $password, $firstName, $lastName, $address, $phoneNumber) {
    $user = User::getUserByID($userID);
    if ($user) {
      $user->setUsername($username);
      $user->setEmail($email);
      $user->setPassword($password);
      $user->setFirstName($firstName);
      $user->setLastName($lastName);
      $user->setAddress($address);
      $user->setPhoneNumber($phoneNumber);
      $user->update();
      return $user;
    } else {
      echo "Failed to update user!";
    }
  }

  public function deleteUser($userID) {
    $user = User::getUserByID($userID);
    if ($user) {
      $user->delete();
      echo "deleted Successfully!";
    } else {
      echo "Operation Failed!";
    }
  }

  public function getAllUsers() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM users";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $user = new User($row['username'], $row['email'], $row['password'], $row['first_name'], $row['last_name'], $row['address'], $row['phone_number']);
      $user->setUserID($row['user_id']);
      $users[] = $user;
    }
    return $users;
  }

  public function getUserByID($userID) {
    return User::getUserByID($userID);
  }
}

?>
