<?php
class Aries {
    public $db;
    public $config;
    public $lib;
    public function __construct(){
        $this->db = new Database;
        $this->config = new config;
        
    }
    public function view($view,$data = []){
        require_once("../app/views/".$view.".php");
    }
    public function base_url($url = ""){
        $base = $this->config->base_url;
        $url = $base.$url;
        return $url;
    }
    public function model($model){
        require_once("../app/models/".$model.".php");
        return new $model;
    }
    public function library($lib,$data = ""){
        require_once("../app/library/".$lib.".php");
        if (empty($data)) {
           $this->lib = new $lib;
        }else{
           $this->lib = new $lib($data);
        }
    }
    public function session($name,$data){
        $_SESSION[$name] = $data;
    }
    public function redirect($url,$type = true){
        if ($type) {
            $url = $this->base_url($url);
        }
        
        echo '<script>window.location.href = "'.$url.'"</script>';
        exit;
    }
}
