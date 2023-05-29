<?php

class CategoryController {
  public function createCategory($name, $description) {
    $category = new Category($name, $description);
    $category->save();
    echo"created successfully!";;
  }

  public function updateCategory($categoryID, $name, $description) {
    $category = Category::getCategoryByID($categoryID);
    if ($category) {
      $category->setName($name);
      $category->setDescription($description);
      $category->update();
      return $category;
    } else {
      echo"failed";
    }
  }

  public function deleteCategory($categoryID) {
    $category = Category::getCategoryByID($categoryID);
    if ($category) {
      $category->delete();
      echo"deleted succesfully!";
    } else {
      echo"failed";
    }
  }

  public function getAllCategories() {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM categories";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $categories = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $category = new Category($row['name'], $row['description']);
      $category->setCategoryID($row['category_id']);
      $categories[] = $category;
    }
    return $categories;
  }

  public function getCategoryByID($categoryID) {
    $category = Category::getCategoryByID($categoryID);
    if ($category) {
      return $category;
    } else {
      echo"failed";
    }
  }
}
?>
