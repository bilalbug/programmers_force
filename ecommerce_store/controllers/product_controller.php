<?php
class ProductController
{
  public function createProduct($requestData)
  {
    $name = $requestData['name'] ?? '';
    $price = $requestData['price'] ?? 0;
    $categoryID = $requestData['category_id'] ?? 0;

    $product = new Product($name, $price, $categoryID);
    $product->save();
    return $product;
  }

  public function updateProduct($productID, $requestData)
  {
    $product = Product::getProductByID($productID);
    if ($product) {
      $name = $requestData['name'] ?? $product->getName();
      $price = $requestData['price'] ?? $product->getPrice();
      $categoryID = $requestData['category_id'] ?? $product->getCategoryID();

      $product->setName($name);
      $product->setPrice($price);
      $product->setCategoryID($categoryID);
      $product->update();
      echo "Product Updated Successfully!";
    } else {
      echo "Operation Failed";
    }
  }

  public function deleteProduct($productID)
  {
    $product = Product::getProductByID($productID);
    if ($product) {
      $product->delete();
      echo "Product Deleted Successfully!";
    } else {
      echo "Operation Failed";
    }
  }

  public function getAllProducts()
  {
    $db = new PDO('pgsql:host=localhost;dbname=ecommerce_store', 'postgres', '1166');
    $query = "SELECT * FROM products";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $product = new Product($row['name'], $row['price'], $row['category_id']);
      $product->setProductID($row['product_id']);
      $products[] = $product;
    }
    return $products;
  }

  public function getProductByID($productID)
  {
    $product = Product::getProductByID($productID);
    if ($product) {
      return $product;
    } else {
      echo "Operation Failed";
    }
  }
}
