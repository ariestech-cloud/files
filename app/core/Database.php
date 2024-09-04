<?php
class Database{
    private $config;
    private $host;
    private $user;
    private $pass;
    private $db;
    
    private $dbh;
    private $stmt;
    
    public function __construct(){
        $this->config = new config;
        $this->host = $this->config->database["host"];
        $this->user = $this->config->database["user"];
        $this->pass = $this->config->database["password"];
        $this->db = $this->config->database["database"];
        $dsn = "mysql:host=".$this->host.";dbname=".$this->db;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
        try {
            $this->dbh = new PDO($dsn,$this->user,$this->pass,$option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    public function bind($param,$value,$type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    public function execute(){
        $this->stmt->execute();
    }
    public function row_array(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function row(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
        $this->execute();
        return $this->stmt->rowCount();
    }
    public function insert($table,$data){
        
        $f = "INSERT INTO `".$table."` ";
        
        $f = $f." VALUES (";
        foreach ($data as $key => $values){
            $f = $f.":".$key.",";
        }
        $f = rtrim($f,",");
        $f = $f.");";
        $this->query($f);
        foreach ($data as $key => $values){
            $this->bind($key,$values);
        }
        return $this->rowCount();
    }
    public function delete($table,$where,$type = null){
        $query = "DELETE FROM `".$table."` WHERE ";
        if (is_null($type)) {
            foreach ($where as $key => $value){
                $query = $query."`".$key."` = :".$key." &&";
            }
            $query = rtrim($query,"&&");
        }
        $this->query($query);
        foreach ($where as $key => $values){
            $this->bind($key,$values);
        }
        return $this->rowCount();
    }
    public function update($table,$data,$where,$type = null){
        
        $query = "UPDATE `".$table."` SET ";
        foreach ($data as $key =>$value){
            $query.=" `".$key."` = :".$key.",";
        }
        $query = rtrim($query,",");
        $query.= " WHERE ";
        if (is_null($type)) {
            foreach ($where as $key => $value){
                $query = $query."`".$key."` = :".$key." &&";
            }
            $query = rtrim($query,"&&");
        }
        
        $this->query($query);
        foreach ($data as $key => $values){
            $this->bind($key,$values);
        }
        foreach ($where as $key => $values){
            $this->bind($key,$values);
        }
        return $this->rowCount();
    }
    public function get ($table){
        $this->query("SELECT * FROM `$table`");
    }
    public function get_where($table,$where,$data = "*",$type = null){
        $query = "SELECT $data FROM `$table` WHERE ";
        if (is_null($type)) {
            foreach ($where as $key => $value){
                $query = $query."`".$key."` = :".$key." &&";
            }
            $query = rtrim($query,"&&");
        }
        $this->query($query);
        foreach ($where as $key => $values){
            $this->bind($key,$values);
        }
    }
}