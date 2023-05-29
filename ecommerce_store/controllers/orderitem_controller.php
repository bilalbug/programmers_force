<?php

class OrderItemController {
  public function getOrderItemByID($orderItemID) {
    $orderItem = OrderItem::getOrderItemByID($orderItemID);
    if ($orderItem) {
      return $orderItem;
    } else {
      echo"Opertation Failed!";
      return null;
    }
  }

  public function getAllOrderItems() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM order_items";
    $stmt = $db->query($query);
    $orderItems = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $orderItem = new OrderItem($row['order_id'], $row['product_id'], $row['quantity'], $row['price']);
      $orderItem->setOrderItemID($row['order_item_id']);
      $orderItems[] = $orderItem;
    }
    return $orderItems;
  }

  public function createOrderItem($requestData) {
    $orderID = $requestData['orderID'];
    $productID = $requestData['productID'];
    $quantity = $requestData['quantity'];
    $price = $requestData['price'];
    $orderItem = new OrderItem($orderID, $productID, $quantity, $price);
    $orderItem->save();
    return $orderItem;
  }

  public function updateOrderItem($orderItemID, $requestData) {
    $orderItem = OrderItem::getOrderItemByID($orderItemID);
    if ($orderItem) {
      $orderID = $requestData['orderID'];
      $productID = $requestData['productID'];
      $quantity = $requestData['quantity'];
      $price = $requestData['price'];
      $orderItem->setOrderID($orderID);
      $orderItem->setProductID($productID);
      $orderItem->setQuantity($quantity);
      $orderItem->setPrice($price);
      $orderItem->update();
      return $orderItem;
    } else {
      echo"Opertation Failed!";
      return null;
    }
  }

  public function deleteOrderItem($orderItemID) {
    $orderItem = OrderItem::getOrderItemByID($orderItemID);
    if ($orderItem) {
      $orderItem->delete();
      return true;
    } else {
      echo"Opertation Failed!";
      return false;
    }
  }
}

?>
