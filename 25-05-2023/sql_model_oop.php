<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Model Creation with SQL</title>
</head>

<body>
    <h1>DataBase Connection</h1>
    <form method="POST" action="sql_model.php">
        Host:<input type="text" name="host"><br>
        Port:<input type="number" name="port"><br>
        DB Name:<input type="text" name="dbname"><br>
        User:<input type="text" name="user"><br>
        Password:<input type="password" name="password"><br>
        <button type="submit" name="connect">Connect DB</button><br>
    </form>

    <form method="POST" action="sql_model.php">
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
    private $user;
    private $password;
    private $conn;

    public function __construct($host, $port, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->conn = $this->connect();
    }

    private function connect()
    {
        $conn = pg_connect("host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password}");
        if (!$conn) {
            echo "Failed to connect to PostgreSQL: " . pg_last_error();
            exit;
        }

        return $conn;
    }

    public function executeQuery($query)
    {
        $result = pg_query($this->conn, $query);
        if (!$result) {
            echo "Query execution failed: " . pg_last_error();
            exit;
        } else {
            echo "Query executed Successfully!";
        }
        pg_close($this->conn);
    }
}

session_start();

$host = $_SESSION['host'] ?? '';
$port = $_SESSION['port'] ?? '';
$dbname = $_SESSION['dbname'] ?? '';
$user = $_SESSION['user'] ?? '';
$password = $_SESSION['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connect'])) {
    $host = $_SESSION['host'] = $_POST["host"];
    $port = $_SESSION['port'] = $_POST["port"];
    $dbname = $_SESSION['dbname'] = $_POST["dbname"];
    $user = $_SESSION['user'] = $_POST["user"];
    $password = $_SESSION['password'] = $_POST["password"];
    $db = new Database($host, $port, $dbname, $user, $password);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['execute'])) {
    $query = $_POST["query"];
    $db = new Database($host, $port, $dbname, $user, $password);
    $db->executeQuery($query);
}

?>