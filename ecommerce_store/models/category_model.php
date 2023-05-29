<?php

class Category {
  private $categoryID;
  private $name;
  private $description;

  public function __construct($name, $description) {
    $this->name = $name;
    $this->description = $description;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->name, $this->description]);
  }

  public static function getCategoryByID($categoryID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM categories WHERE category_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$categoryID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $category = new Category($row['name'], $row['description']);
      $category->setCategoryID($row['category_id']);
      return $category;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE categories SET name = ?, description = ? WHERE category_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->name, $this->description, $this->categoryID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM categories WHERE category_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->categoryID]);
  }

  // Getters and setters
  public function getCategoryID() {
    return $this->categoryID;
  }

  public function setCategoryID($categoryID) {
    $this->categoryID = $categoryID;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
  }
}
?>
