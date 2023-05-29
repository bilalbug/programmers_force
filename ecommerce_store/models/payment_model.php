<?php

class Payment {
  private $paymentID;
  private $orderID;
  private $paymentMethod;
  private $amount;
  private $paymentDate;

  public function __construct($orderID, $paymentMethod, $amount, $paymentDate) {
    $this->orderID = $orderID;
    $this->paymentMethod = $paymentMethod;
    $this->amount = $amount;
    $this->paymentDate = $paymentDate;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO payments (order_id, payment_method, amount, payment_date) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderID, $this->paymentMethod, $this->amount, $this->paymentDate]);
  }

  public static function getPaymentByID($paymentID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$paymentID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $payment = new Payment($row['order_id'], $row['payment_method'], $row['amount'], $row['payment_date']);
      $payment->setPaymentID($row['payment_id']);
      return $payment;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE payments SET order_id = ?, payment_method = ?, amount = ?, payment_date = ? WHERE payment_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->orderID, $this->paymentMethod, $this->amount, $this->paymentDate, $this->paymentID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->paymentID]);
  }

  // Getters and setters
  public function getPaymentID() {
    return $this->paymentID;
  }

  public function setPaymentID($paymentID) {
    $this->paymentID = $paymentID;
  }

  public function getOrderID() {
    return $this->orderID;
  }

  public function setOrderID($orderID) {
    $this->orderID = $orderID;
  }

  public function getPaymentMethod() {
    return $this->paymentMethod;
  }

  public function setPaymentMethod($paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  public function getAmount() {
    return $this->amount;
  }

  public function setAmount($amount) {
    $this->amount = $amount;
  }

  public function getPaymentDate() {
    return $this->paymentDate;
  }

  public function setPaymentDate($paymentDate) {
    $this->paymentDate = $paymentDate;
  }
}

?>
