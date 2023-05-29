<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Model Creation with MongoDB</title>
</head>

<body>
    <h1>Database Connection</h1>
    <form method="POST" action="nosql_model_oop.php">
        Host: <input type="text" name="host"><br>
        Port: <input type="number" name="port"><br>
        DB Name: <input type="text" name="dbname"><br>
        <button type="submit" name="connect">Connect DB</button><br>
    </form>

    <form method="POST" action="nosql_model_oop.php">
        <h1>Queries</h1>
        <textarea name="query"></textarea><br>
        <button type="submit" name="execute">Execute Query</button>
    </form>
</body>

</html>

<?php

class Database
{
    private $host;
    private $port;
    private $dbname;
    private $conn;

    public function __construct($host, $port, $dbname)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->conn = $this->connect();
    }

    private function connect()
    {
        try {
            $conn = new MongoDB\Client("mongodb://{$this->host}:{$this->port}");
            return $conn->{$this->dbname};
        } catch (MongoDB\Driver\Exception\Exception $e) {
            echo "Failed to connect to MongoDB: " . $e->getMessage();
            exit;
        }
    }

    public function executeQuery($query)
    {
        try {
            $result = $this->conn->command(['eval' => $query]);
            echo "Query executed successfully!";
        } catch (MongoDB\Driver\Exception\Exception $e) {
            echo "Query execution failed: " . $e->getMessage();
            exit;
        }
    }
}

session_start();

$host = $_SESSION['host'] ?? '';
$port = $_SESSION['port'] ?? '';
$dbname = $_SESSION['dbname'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connect'])) {
    $host = $_SESSION['host'] = $_POST["host"];
    $port = $_SESSION['port'] = $_POST["port"];
    $dbname = $_SESSION['dbname'] = $_POST["dbname"];
    $db = new Database($host, $port, $dbname);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['execute'])) {
    $query = $_POST["query"];
    $db = new Database($host, $port, $dbname);
    $db->executeQuery($query);
}

?>
