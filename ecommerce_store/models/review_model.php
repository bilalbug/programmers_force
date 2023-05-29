<?php

class Review {
  private $reviewID;
  private $productID;
  private $userID;
  private $rating;
  private $comment;

  public function __construct($productID, $userID, $rating, $comment) {
    $this->productID = $productID;
    $this->userID = $userID;
    $this->rating = $rating;
    $this->comment = $comment;
  }

  public function save() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->productID, $this->userID, $this->rating, $this->comment]);
  }

  public static function getReviewByID($reviewID) {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM reviews WHERE review_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$reviewID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $review = new Review($row['product_id'], $row['user_id'], $row['rating'], $row['comment']);
      $review->setReviewID($row['review_id']);
      return $review;
    } else {
      return null;
    }
  }

  public function update() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "UPDATE reviews SET product_id = ?, user_id = ?, rating = ?, comment = ? WHERE review_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->productID, $this->userID, $this->rating, $this->comment, $this->reviewID]);
  }

  public function delete() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "DELETE FROM reviews WHERE review_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->reviewID]);
  }

  // Getters and setters
  public function getReviewID() {
    return $this->reviewID;
  }

  public function setReviewID($reviewID) {
    $this->reviewID = $reviewID;
  }

  public function getProductID() {
    return $this->productID;
  }

  public function setProductID($productID) {
    $this->productID = $productID;
  }

  public function getUserID() {
    return $this->userID;
  }

  public function setUserID($userID) {
    $this->userID = $userID;
  }

  public function getRating() {
    return $this->rating;
  }

  public function setRating($rating) {
    $this->rating = $rating;
  }

  public function getComment() {
    return $this->comment;
  }

  public function setComment($comment) {
    $this->comment = $comment;
  }
}
?>
