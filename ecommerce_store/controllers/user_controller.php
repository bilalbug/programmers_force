<?php

class UserController
{
  public function createUser($username, $email, $password, $firstName, $lastName, $address, $phoneNumber)
  {
    $user = new User($username, $email, $password, $firstName, $lastName, $address, $phoneNumber);
    $user->save();
    return $user;
  }

  public function updateUser($userID, $username, $email, $password, $firstName, $lastName, $address, $phoneNumber)
  {
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

  public function deleteUser($userID)
  {
    $user = User::getUserByID($userID);
    if ($user) {
      $user->delete();
      echo "deleted Successfully!";
    } else {
      echo "Operation Failed!";
    }
  }

  public function getAllUsers()
  {
    $db = new DatabaseConnection(); // Replace this with your actual database connection code
    $userModel = new UserModel($db);
    $users = $userModel->getAllUsers();
  
    if (empty($users)) {
      echo "No users found.";
      return [];
    }
  
    // Process the users as needed
    // ...
  
    return $users;
  }

  public function getUserByID($userID)
  {
    return User::getUserByID($userID);
  }
}
