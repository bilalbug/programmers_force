<?php

class PaymentController
{
  public function createPayment($requestData)
  {
    $orderID = $requestData['orderID'];
    $paymentMethod = $requestData['paymentMethod'];
    $amount = $requestData['amount'];
    $paymentDate = $requestData['paymentDate'];

    $payment = new Payment($orderID, $paymentMethod, $amount, $paymentDate);
    $payment->save();
    return $payment;
  }

  public function updatePayment($paymentID, $requestData)
  {
    $payment = Payment::getPaymentByID($paymentID);
    if ($payment) {
      $orderID = $requestData['orderID'];
      $paymentMethod = $requestData['paymentMethod'];
      $amount = $requestData['amount'];
      $paymentDate = $requestData['paymentDate'];

      $payment->setOrderID($orderID);
      $payment->setPaymentMethod($paymentMethod);
      $payment->setAmount($amount);
      $payment->setPaymentDate($paymentDate);
      $payment->update();
      echo "Payment Updated Successfyully!";
    } else {
      echo "Opertation Failed!";
    }
  }

  public function deletePayment($paymentID)
  {
    $payment = Payment::getPaymentByID($paymentID);
    if ($payment) {
      $payment->delete();
      echo "Payment delted Successfyully!";
    } else {
      echo "Opertation Failed!";
    }
  }

  public function getPaymentByID($paymentID)
  {
    return Payment::getPaymentByID($paymentID);
  }

  public function getAllPayments()
  {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM payments";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $payments = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $payment = new Payment($row['orderID'], $row['paymentMethod'], $row['amount'], $row['paymentDate']);
      $payment->setPaymentID($row['payment_id']);
      $payments[] = $payment;
    }
    return $payments;
  }
}
