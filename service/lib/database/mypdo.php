<?php
final class myPDO
{
    private $pdo = null;
    private $statement = null;

    public function __construct($hostname, $username, $password, $database = "", $port = "3306") {

        try{
            if ($database)
                $this->pdo = new PDO("mysql:host=".$hostname.";port=".$port.";dbname=".$database, $username, $password, array(PDO::ATTR_PERSISTENT => true));
            else
                $this->pdo = new PDO("mysql:host=".$hostname.";port=".$port, $username, $password, array(PDO::ATTR_PERSISTENT => true));

        }catch(PDOException $e){
            print_r($e);
            trigger_error('Error: Could not make a database link');
            exit();
        }

        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET utf8");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->pdo->exec("SET SQL_MODE = ''");

    }

    public function prepare($sql){
        $this->statement = $this->pdo->prepare($sql);
    }

    public function bindParam($parameter, $variable, $data_type = PDO::PARAM_STR, $length = 0){
        if ($length)
            $this->statement->bindParam($parameter, $variable, $data_type, $length);
        else
            $this->statement->bindParam($parameter, $variable, $data_type);
    }

    public function execute(){
        $result = false;
        try{
            if ($this->statement && $this->statement->execute()){
                $data = array();
                while($row = $this->statement->fetch(PDO::FETCH_ASSOC)){
                    $data[] = $row;
                }
                $result = new stdClass();
                $result->row = ( isset($data[0]) ? $data[0] : array() );
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            }
        }catch(PDOException $e){
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
            exit();
        }
        if ($result){
            return $result;
        }else{
            return $this->null_object();
        }
    }

    public function onlyExecute(){
        $result = false;
        try{
            if ($this->statement && $this->statement->execute()){
                $result = new stdClass();
                $result->row = array();
                $result->rows = array();
                $result->num_rows = $this->statement->rowCount();
            }
        }catch(PDOException $e){
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
            exit();
        }
        if ($result){
            return $result;
        }else{
            return $this->null_object();
        }
    }

    public function query($sql, $params = array()) {
        $this->statement = $this->pdo->prepare($sql);
        $result = false;

        try{
            if ($this->statement && $this->statement->execute($params)){
                $data = array();
                while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)){
                    $data[] = $row;
                }
                $result = new stdClass();
                $result->row = ( isset($data[0]) ? $data[0] : array() );
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            }
        }catch(PDOException $e){
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
            exit();
        }

        if ($result){
            return $result;
        }else{
            return $this->null_object();
        }

    }

    public function getLastError()
    {
        return $this->statement->errorInfo();
    }

    public function sqlDebug()
    {
        echo '<pre>';
        $this->statement->debugDumpParams();
        echo '</pre>';
    }

    // From http://www.php.net/manual/de/function.mysql-real-escape-string.php#98506
    public function escape($value) {
        // Maybe we should use quote for this.
        $search=array("\\","\0","\n","\r","\x1a","'",'"');
        $replace=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
        return str_replace($search,$replace,$value);
    }

    public function countAffected() {
        if ($this->statement)
            return $this->statement->rowCount();
        else
            return 0;
    }

    public function getLastId() {
        return $this->pdo->lastInsertId();
    }

    public function null_object(){
        $result = new stdClass(); // to handle older opencart actions
        $result->row = array(); // to handle older opencart actions
        $result->rows = array(); // to handle older opencart actions
        $result->num_rows = 0; // to handle older opencart actions
        return $result; // should be false
    }

    public function __destruct() {
        $this->pdo = null;
    }
}
