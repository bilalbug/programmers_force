<?php

class OrderController
{
  public function createOrder($userID, $productID, $quantity, $totalPrice, $orderDate)
  {
    $order = new Order($userID, $productID, $quantity, $totalPrice, $orderDate);
    $order->save();
    echo "created successfully!";
  }

  public function updateOrder($orderID, $userID, $productID, $quantity, $totalPrice, $orderDate)
  {
    $order = Order::getOrderByID($orderID);
    if ($order) {
      $order->setUserID($userID);
      $order->setProductID($productID);
      $order->setQuantity($quantity);
      $order->setTotalPrice($totalPrice);
      $order->setOrderDate($orderDate);
      $order->update();
      echo "updated successfully!";
    } else {
      echo "Failed!";
    }
  }

  public function deleteOrder($orderID)
  {
    $order = Order::getOrderByID($orderID);
    if ($order) {
      $order->delete();
      echo "Deleted successfully!";
    } else {
      echo "Operation Failed!";
    }
  }

  public function getOrderByID($orderID)
  {
    $order = Order::getOrderByID($orderID);
    if ($order) {
      return $order;
    } else {
      echo "Operation Failed!";
    }
  }

  public function getAllOrders()
  {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM orders";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $orders = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $order = new Order($row['user_id'], $row['product_id'], $row['quantity'], $row['total_price'], $row['order_date']);
      $order->setOrderID($row['order_id']);
      $orders[] = $order;
    }
    return $orders;
  }
}
