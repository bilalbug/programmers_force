<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP library

// MongoDB configuration
$host = 'localhost'; // MongoDB host
$port = 27017; // MongoDB port
$dbname = 'mystore'; // MongoDB database name

// Create a new MongoDB client
$client = new MongoDB\Client("mongodb://{$host}:{$port}");

// Select the MongoDB database
$database = $client->selectDatabase($dbname);

// Collection names
$collectionName1 = 'collection1';
$collectionName2 = 'collection2';

// Select the collections
$collection1 = $database->selectCollection($collectionName1);
$collection2 = $database->selectCollection($collectionName2);

// You can now perform operations on the selected collections

?>
