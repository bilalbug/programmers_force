<?php

class Product {
  private $productID;
  private $name;
  private $price;
  private $categoryID;

  public function __construct($name, $price, $categoryID) {
    $this->name = $name;
    $this->price = $price;
    $this->categoryID = $categoryID;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO products (name, price, category_id) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->name, $this->price, $this->categoryID]);
  }

  public static function getProductByID($productID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$productID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $product = new Product($row['name'], $row['price'], $row['category_id']);
      $product->setProductID($row['product_id']);
      return $product;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE products SET name = ?, price = ?, category_id = ? WHERE product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->name, $this->price, $this->categoryID, $this->productID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM products WHERE product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->productID]);
  }

  // Getters and setters
  public function getProductID() {
    return $this->productID;
  }

  public function setProductID($productID) {
    $this->productID = $productID;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setPrice($price) {
    $this->price = $price;
  }

  public function getCategoryID() {
    return $this->categoryID;
  }

  public function setCategoryID($categoryID) {
    $this->categoryID = $categoryID;
  }
}
?>
