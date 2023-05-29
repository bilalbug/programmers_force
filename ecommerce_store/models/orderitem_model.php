<?php

class OrderItem {
  private $orderItemID;
  private $orderID;
  private $productID;
  private $quantity;
  private $price;

  public function __construct($orderID, $productID, $quantity, $price) {
    $this->orderID = $orderID;
    $this->productID = $productID;
    $this->quantity = $quantity;
    $this->price = $price;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderID, $this->productID, $this->quantity, $this->price]);
  }

  public static function getOrderItemByID($orderItemID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM order_items WHERE order_item_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$orderItemID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $orderItem = new OrderItem($row['order_id'], $row['product_id'], $row['quantity'], $row['price']);
      $orderItem->setOrderItemID($row['order_item_id']);
      return $orderItem;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE order_items SET order_id = ?, product_id = ?, quantity = ?, price = ? WHERE order_item_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderID, $this->productID, $this->quantity, $this->price, $this->orderItemID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM order_items WHERE order_item_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderItemID]);
  }

  // Getters and setters
  public function getOrderItemID() {
    return $this->orderItemID;
  }

  public function setOrderItemID($orderItemID) {
    $this->orderItemID = $orderItemID;
  }

  public function getOrderID() {
    return $this->orderID;
  }

  public function setOrderID($orderID) {
    $this->orderID = $orderID;
  }

  public function getProductID() {
    return $this->productID;
  }

  public function setProductID($productID) {
    $this->productID = $productID;
  }

  public function getQuantity() {
    return $this->quantity;
  }

  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setPrice($price) {
    $this->price = $price;
  }
}
?>