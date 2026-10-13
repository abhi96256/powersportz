<?php
class Database
{   
    ////$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
    private $host = "10.10.10.28";
    private $db_name = "powersport";
    private $username = "powersport";
    private $password = "Dgt569khd";
    public $conn; 
    
    /* private $host = "spice-db.cpersmswui52.eu-west-1.rds.amazonaws.com";
    private $db_name = "mojovoice";
    private $username = "mojo_voice";
    private $password = "mojo@123";
    public $conn; */
    

     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>