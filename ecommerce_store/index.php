<?php

// Include all the model and controller files
$baseDir = 'C:\xampp\htdocs\programmers_force\ecommerce_store';

require_once $baseDir . '\models\user_model.php';
require_once $baseDir . '\controllers\user_controller.php';
require_once $baseDir . '\models\category_model.php';
require_once $baseDir . '\controllers\category_controller.php';
require_once $baseDir . '\models\product_model.php';
require_once $baseDir . '\controllers\product_controller.php';
require_once $baseDir . '\models\review_model.php';
require_once $baseDir . '\controllers\review_controller.php';
require_once $baseDir . '\models\order_model.php';
require_once $baseDir . '\controllers\order_controller.php';
require_once $baseDir . '\models\orderitem_model.php';
require_once $baseDir . '\controllers\orderitem_controller.php';
require_once $baseDir . '\models\payment_model.php';
require_once $baseDir . '\controllers\payment_controller.php';

// Handle the request
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

// Define the base API URL
$baseUrl = '/api';

// Extract the endpoint and ID from the URL
$endpoint = rtrim(str_replace($baseUrl, '', $path), '/');
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Set the response content type
header('Content-Type: application/json');

// Initialize the response data
$responseData = null;
$responseCode = null;

// User CRUD operations
if ($endpoint === 'users') {
    $userController = new UserController();

    if ($method === 'GET') {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $responseData = $userController->getUserByID($id);
        } else {
            $responseData = $userController->getAllUsers();
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $responseData = $userController->createUser(
            $requestData['username'],
            $requestData['email'],
            $requestData['password'],
            $requestData['firstName'],
            $requestData['lastName'],
            $requestData['address'],
            $requestData['phoneNumber']
        );
        $responseCode = 201; // Created
    } elseif ($method === 'PUT') {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $responseData = $userController->updateUser(
                $id,
                $requestData['username'],
                $requestData['email'],
                $requestData['password'],
                $requestData['firstName'],
                $requestData['lastName'],
                $requestData['address'],
                $requestData['phoneNumber']
            );
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $responseData = $userController->deleteUser($id);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}

// Category CRUD operations
elseif ($endpoint === 'categories') {
    $categoryController = new CategoryController();

    if ($method === 'GET') {
        if ($id) {
            $responseData = $categoryController->getCategoryByID($id);
        } else {
            $responseData = $categoryController->getAllCategories();
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $name = $requestData['name'] ?? '';
        $description = $requestData['description'] ?? '';
        $responseData = $categoryController->createCategory($name, $description);
        $responseCode = 201; // Created
    } elseif ($method === 'PUT') {
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $name = $requestData['name'] ?? '';
            $description = $requestData['description'] ?? '';
            $responseData = $categoryController->updateCategory($id, $name, $description);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $responseData = $categoryController->deleteCategory($id);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}

// Product CRUD operations
elseif ($endpoint === 'products') {
    $productController = new ProductController();

    if ($method === 'GET') {
        if ($id) {
            $responseData = $productController->getProductByID($id);
        } else {
            $responseData = $productController->getAllProducts();
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $responseData = $productController->createProduct($requestData);
        $responseCode = 201; // Created
    } elseif ($method === 'PUT') {
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $responseData = $productController->updateProduct($id, $requestData);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $responseData = $productController->deleteProduct($id);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}

// Review CRUD operations
elseif ($endpoint === 'reviews') {
    $reviewController = new ReviewController();

    if ($method === 'GET') {
        if ($id) {
            $responseData = $reviewController->getReviewByID($id);
        } else {
            $responseData = $reviewController->getAllReviews();
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $productID = $requestData['product_id'];
        $userID = $requestData['user_id'];
        $rating = $requestData['rating'];
        $comment = $requestData['comment'];
        $responseData = $reviewController->createReview($productID, $userID, $rating, $comment);
        $responseCode = 201; // Created
    } elseif ($method === 'PUT') {
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $productID = $requestData['product_id'];
            $userID = $requestData['user_id'];
            $rating = $requestData['rating'];
            $comment = $requestData['comment'];
            $responseData = $reviewController->updateReview($id, $productID, $userID, $rating, $comment);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $responseData = $reviewController->deleteReview($id);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}
// Order CRUD operations
elseif ($endpoint === 'orders') {
    $orderController = new OrderController();

    if ($method === 'GET') {
        if ($id) {
            $responseData = $orderController->getOrderByID($id);
        } else {
            $responseData = $orderController->getAllOrders();
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $userID = $requestData['userID'];
        $productID = $requestData['productID'];
        $quantity = $requestData['quantity'];
        $totalPrice = $requestData['totalPrice'];
        $orderDate = $requestData['orderDate'];

        $orderController->createOrder($userID, $productID, $quantity, $totalPrice, $orderDate);
        $responseCode = 201; // Created
    } elseif ($method === 'PUT') {
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $userID = $requestData['userID'];
            $productID = $requestData['productID'];
            $quantity = $requestData['quantity'];
            $totalPrice = $requestData['totalPrice'];
            $orderDate = $requestData['orderDate'];

            $orderController->updateOrder($id, $userID, $productID, $quantity, $totalPrice, $orderDate);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $orderController->deleteOrder($id);
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}

// OrderItem CRUD operations
elseif ($endpoint === 'order-items') {
    $orderItemController = new OrderItemController();

    if ($method === 'GET') {
        if ($id) {
            $responseData = $orderItemController->getOrderItemByID($id);
            if ($responseData) {
                $responseCode = 200; // OK
            } else {
                $responseCode = 404; // Not Found
                $responseData = array('message' => 'Order item not found');
            }
        } else {
            $responseData = $orderItemController->getAllOrderItems();
            $responseCode = 200; // OK
        }
    } elseif ($method === 'POST') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        if (isset($requestData['orderID']) && isset($requestData['productID']) && isset($requestData['quantity']) && isset($requestData['price'])) {
            $responseData = $orderItemController->createOrderItem($requestData);
            $responseCode = 201; // Created
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Invalid request data');
        }
    } elseif ($method === 'PUT') {
        if ($id) {
            $requestData = json_decode(file_get_contents('php://input'), true);
            if (isset($requestData['orderID']) && isset($requestData['productID']) && isset($requestData['quantity']) && isset($requestData['price'])) {
                $responseData = $orderItemController->updateOrderItem($id, $requestData);
                if ($responseData) {
                    $responseCode = 200; // OK
                } else {
                    $responseCode = 404; // Not Found
                    $responseData = array('message' => 'Order item not found');
                }
            } else {
                $responseCode = 400; // Bad Request
                $responseData = array('message' => 'Invalid request data');
            }
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $responseData = $orderItemController->deleteOrderItem($id);
            if ($responseData) {
                $responseCode = 200; // OK
            } else {
                $responseCode = 404; // Not Found
                $responseData = array('message' => 'Order item not found');
            }
        } else {
            $responseCode = 400; // Bad Request
            $responseData = array('message' => 'Missing ID parameter');
        }
    }
}


// OrderItem CRUD operations
elseif ($endpoint === 'payments') {
    $paymentController = new PaymentController();

    // Create Payment API
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requestData = $_POST;
        $payment = $paymentController->createPayment($requestData);
        if ($payment) {
            echo json_encode(array('message' => 'Payment created successfully'));
        } else {
            echo json_encode(array('message' => 'Failed to create payment'));
        }
    }

    // Read Payment API
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Get payment by ID
        if (isset($_GET['paymentID'])) {
            $paymentID = $_GET['paymentID'];
            $payment = $paymentController->getPaymentByID($paymentID);
            if ($payment) {
                echo json_encode($payment);
            } else {
                echo json_encode(array('message' => 'Payment not found'));
            }
        }
        // Get all payments
        else {
            $payments = $paymentController->getAllPayments();
            echo json_encode($payments);
        }
    }

    // Update Payment API
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $putData);
        $paymentID = $putData['paymentID'];
        $requestData = array(
            'orderID' => $putData['orderID'],
            'paymentMethod' => $putData['paymentMethod'],
            'amount' => $putData['amount'],
            'paymentDate' => $putData['paymentDate']
        );
        $paymentController->updatePayment($paymentID, $requestData);
    }

    // Delete Payment API
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $deleteData);
        $paymentID = $deleteData['paymentID'];
        $paymentController->deletePayment($paymentID);
    }
}
