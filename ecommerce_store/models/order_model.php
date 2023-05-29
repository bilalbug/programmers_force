<?php

class Order {
  private $orderID;
  private $userID;
  private $productID;
  private $quantity;
  private $totalPrice;
  private $orderDate;

  public function __construct($userID, $productID, $quantity, $totalPrice, $orderDate) {
    $this->userID = $userID;
    $this->productID = $productID;
    $this->quantity = $quantity;
    $this->totalPrice = $totalPrice;
    $this->orderDate = $orderDate;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->userID, $this->productID, $this->quantity, $this->totalPrice, $this->orderDate]);
  }

  public static function getOrderByID($orderID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$orderID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $order = new Order($row['user_id'], $row['product_id'], $row['quantity'], $row['total_price'], $row['order_date']);
      $order->setOrderID($row['order_id']);
      return $order;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE orders SET user_id = ?, product_id = ?, quantity = ?, total_price = ?, order_date = ? WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->userID, $this->productID, $this->quantity, $this->totalPrice, $this->orderDate, $this->orderID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderID]);
  }

  // Getters and setters
  public function getOrderID() {
    return $this->orderID;
  }

  public function setOrderID($orderID) {
    $this->orderID = $orderID;
  }

  public function getUserID() {
    return $this->userID;
  }

  public function setUserID($userID) {
    $this->userID = $userID;
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

  public function getTotalPrice() {
    return $this->totalPrice;
  }

  public function setTotalPrice($totalPrice) {
    $this->totalPrice = $totalPrice;
  }

  public function getOrderDate() {
    return $this->orderDate;
  }

  public function setOrderDate($orderDate) {
    $this->orderDate = $orderDate;
  }
}

?>
