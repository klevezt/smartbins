<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 
	// Access: The php files 
	// Purpose: Connect to the server	
	
class DB{

private $servername;
private $username;
private $password;
private $dbname;
private $charset;

    protected static $_instance = null;

    // Well by itself it's a first class singleton, keeping its own instance
    public static function instance()
    {
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
	
    // But... for the database connection, you just create it every time anew!
    public function getConnection()
    {
		$this->servername = "/zstorage/home/ece00888/mysql/run/mysql.sock";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "garbage_managment";
		$this->charset = "utf8mb4";

		$pdo_options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
		  
		try {
			$dsn = "mysql:unix_socket=".$this->servername.";dbname=".$this->dbname;
			$pdo = new PDO($dsn, $this->username, $this->password,$pdo_options);
			return $pdo;

		} catch (PDOException $e) {
		    echo "failed:" .$e->getMessage();
		}
    }	
}

$db = DB::instance();
$conn = $db->getConnection();
?>