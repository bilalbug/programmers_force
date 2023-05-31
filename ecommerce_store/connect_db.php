<?php
class PgConnection
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $connection;
    
    public function __construct($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }
    
    public function connect()
    {
        $this->connection = pg_connect("host=$this->host dbname=$this->dbname user=$this->user password=$this->password");
        
        if (!$this->connection) {
            throw new Exception("Connection failed!");
        }else{
            echo 'connection established successfully';
        }
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
    public function query($query, $params = [])
    {
        $result = pg_query_params($this->connection, $query, $params);
        if($result){
            echo 'data added successfully in database';
        }
        else{
            throw new Exception("Query execution failed!");
        }
        
        return $result;
    }
}


?>