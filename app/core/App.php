<?php
class App{
    protected $config;
    protected $controller;
    protected $method;
    protected $params = [];

    public function __construct(){
        $this->config = new config;
        
        $this->controller = $this->config->default_controller;
        $this->method = $this->config->default_method;
        
        $url = $this->parseURL();
        if (file_exists("../app/controllers/".$url[0].".php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once("../app/controllers/".$this->controller.".php");
        $this->controller = new $this->controller;
        if (isset($url[1])) {
            if (method_exists($this->controller,$url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
            
        }
        if (count($url) > 0) {
            $this->params = array_values($url);
        }
        
        call_user_func_array([$this->controller,$this->method],$this->params);
    }
    
    public function parseURL(){
        if (isset($_GET["url"])) {
            $url = $_GET["url"];
            $url = rtrim($url,"/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/",$url);
            return $url;
        }
	else{
	return [$this->controller,$this->method];
	}
    }
}
