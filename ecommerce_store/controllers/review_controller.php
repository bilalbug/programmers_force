<?php

class ReviewController {
  public function createReview($productID, $userID, $rating, $comment) {
    $review = new Review($productID, $userID, $rating, $comment);
    $review->save();
    return $review;
  }

  public function updateReview($reviewID, $productID, $userID, $rating, $comment) {
    $review = Review::getReviewByID($reviewID);
    if ($review) {
      $review->setProductID($productID);
      $review->setUserID($userID);
      $review->setRating($rating);
      $review->setComment($comment);
      $review->update();
      echo"updated successfully!";
    } else {
      echo"Opertation Failed!";
    }
  }

  public function deleteReview($reviewID) {
    $review = Review::getReviewByID($reviewID);
    if ($review) {
      $review->delete();
      echo"Deleted successfully!";
    } else {
      echo"Opertation Failed!";
    }
  }

  public function getReviewByID($reviewID) {
    $review = Review::getReviewByID($reviewID);
    return $review;
  }

  public function getAllReviews() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM reviews";
    $stmt = $db->query($query);
    $reviews = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $review = new Review($row['product_id'], $row['user_id'], $row['rating'], $row['comment']);
      $review->setReviewID($row['review_id']);
      $reviews[] = $review;
    }
    return $reviews;
  }
}
?>
