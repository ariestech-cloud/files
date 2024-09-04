<?php
class Form_validation{
    private $data;
    private $db;
    private $val;
    private $message;
    private $alias;
    private $err;
    private $e;
    private $database;
    public function __construct($data = ""){
        $this->db = new Database;
        
        if (empty($data)) {
            $this->data = $_POST;
            $this->val = $_POST;
        }else{
            $this->data = $data;
            $this->val = $data;
        }
        $this->message = [
          "required" => "%i is required",
          "valid_email" => "%i dont match the email format",
          "valid_url" => "%i dont match the url format",
          "matches" => "%i dont match",
          "password_verify" => "%i dont match password verify",
          "max_length" => "%i max length ",
          "min_length" => "%i min length ",
          "in_db" => "%i not found in database"
        ];
    }
    public function set_rule($name,$alias,$rules = "",$message = []){
        
        $this->alias = $alias;
        $this->set_message($message);
        
        
        if (is_array($rules)) {
            if (in_array("trim",$rules)) {
            $this->dtrim($name);
            }elseif (isset($rules["trim"])) {
                $this->dtrim($name,$rules["trim"]);
            }
            
            if (in_array("required",$rules)) {
            $this->required($name);
            }
            if (isset($rules["matches"])) {
            $this->matches($name,$rules["matches"]);
            }
            if (isset($rules["in_db"])) {
            $this->in_db($name,$rules["in_db"]);
            }
            if (isset($rules["max_length"])) {
            $this->max_length($name,$rules["max_length"]);
            }
            if (isset($rules["min_length"])) {
            $this->min_length($name,$rules["min_length"]);
            }
            if (isset($rules["password_verify"])) {
            $this->is_password_verify($name,$rules["password_verify"]);
            }
            if (in_array("password_hash",$rules)) {
            $this->is_password_hash($name);
            }
            if (in_array("valid_email",$rules)) {
            $this->valid_email($name);
            }
            if (in_array("valid_url",$rules)) {
            $this->valid_url($name);
            }
            
        }
        if (in_array("is-invalid",$this->err[$name]["valid"])) {
            $this->err[$name]["valid"] = "is-invalid";
            return false;
        }else{
            $this->err[$name]["valid"] = "is-valid";
            return $this->get_value($name);
        }
        
        
    }
    private function in_db($name,$data){
        $data = explode("|",$data);
        $table = $data[0];
        $col = $data[1];
        $this->db->get_where($table,[$col=>$this->val[$name]]);
        
        if ($this->db->rowCount() < 1) {
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["in_db"]);
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    private function matches($name,$matches){
        if (isset($this->data[$matches])) {
            if ($this->val[$name] != $this->val[$matches]) {
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["matches"]);
            }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
        }else{
            if ($this->data[$name] != $matches) {
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["matches"]);
            
            }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
        }
        
    }
    private function is_password_verify($name,$matches){
            $pass = $this->val[$name];
            
            if (!password_verify($pass,$matches)) {
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"] = ["is-invalid"];
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["password_verify"]);
            }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"] = ["is-valid"];
            }
        
        
    }
    private function required($name){
        
        if (empty($this->val[$name])) {
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["required"]);
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    private function is_password_hash($name){
        $this->val[$name] = password_hash($this->val[$name], PASSWORD_DEFAULT);
    }
    private function dtrim($name,$word = ""){
        
        if (empty($word)) {
            $this->val[$name] = trim($this->val[$name]);
            
        }else{
            
            $this->val[$name] = trim($this->val[$name],$word);
        }
        
        
    }
    private function valid_email($name){
        if (!filter_var($this->val[$name], FILTER_VALIDATE_EMAIL)) {
          $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["valid_email"]);
          $this->e[] = false;
          $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    private function valid_url($name){
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->val[$name])) {
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["valid_url"]);
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    private function max_length($name,$max){
        if (strlen($this->val[$name]) > $max) {
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["max_length"]).$max;
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    private function min_length($name,$min){
        if (strlen($this->val[$name]) < $min) {
            $this->err[$name]["message"][] = str_replace("%i",$this->alias,$this->message["min_length"]).$min;
            $this->e[] = false;
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-invalid";
        }else{
            $this->err[$name]["value"] = $this->data[$name];
            $this->err[$name]["valid"][] = "is-valid";
        }
    }
    
    private function set_message($message){
        
        if (!empty($message)) {
     foreach ($message as $key => $value){
            $this->message[$key] = $value;
            }
        }
    }
    public function get_value($name = ""){
        
            if (empty($name)) {
            return $this->val;
        } else {
            return $this->val[$name];
        }
        
        
        
    }
    private function setsession(){

        $_SESSION["Form_validation"] = $this->get_error();
    }
    public function run(){
        
        if (is_null($this->e)) {
            return true;
        }else{
            
            $this->setsession();
            return false;
            
        }
    }
    public function get_error($name = ""){
        if (empty($name)) {
        return $this->err;
        } else {
        return $this->err[$name];
        }
        
        
    }
    public function form_reset(){
        unset($_SESSION["Form_validation"]);
    }
}
