<?
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "jamtrans_touradria");
Class DataBaseMysql {

    public $conn;

    function __construct(){
        //$this->conn = new mysqli("127.0.0.1", "jamtrans_cezar", "3WLRAFu;E_!F", "jamtrans_touradria"); 
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);   
        //$this->conn->set_charset('utf8mb4');
        if($this->conn->connect_error){
            echo "Error connect to mysql";die;
        } else $this->conn->query("SET NAMES 'UTF8'");
    }

    public function RunQuery($query_tag){
		ini_set('memory_limit', '8192M');
        $result = $this->conn->query($query_tag) or die("Error SQL query-> $query_tag  ". mysqli_error());
        return $result;
    }

    public function insert_id(){
        return $this->conn->insert_id;
    }

    public function TotalOfRows($table_name){
        $result = $this->RunQuery("Select * from $table_name");
        return $result->num_rows;
    }

    public function CloseMysql(){
        $this->conn->close();
    }

    public function real_escape_string($value) {
        return $this->conn->real_escape_string($value);
    }

}

?>
