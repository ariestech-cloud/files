<?php
class Flasher {
    public static function set($action,$message,$type){
        $_SESSION["flash"] = [
            "action" =>$action,
            "message" =>$message,
            "type" => $type
            ];
    }
    public static function flash(){
        if (isset($_SESSION["flash"])) {
            echo '<div class="alert alert-'.$_SESSION["flash"]["type"].' alert-dismissible fade show" role="alert">
  <strong>'.$_SESSION["flash"]["action"].'.</strong> '.$_SESSION["flash"]["message"].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        unset($_SESSION["flash"]);
        }
    }
    public static function form_error($name){
        if (isset($_SESSION["Form_validation"][$name])) {
            return $_SESSION["Form_validation"][$name]["valid"];
        }
    }
    public static function form_message($name,$before = "",$after = ""){
        if (isset($_SESSION["Form_validation"][$name])) {
            $message = $_SESSION["Form_validation"][$name]["message"];
            $m = "";
            foreach ($message as $mess){
                $m .= $mess.",";
            }
            unset($_SESSION["Form_validation"][$name]);
            return $before.$m.$after;
        }
    }
    public static function form_value($name){
        if (isset($_SESSION["Form_validation"][$name])) {
            return $_SESSION["Form_validation"][$name]["value"];
        }
    }
    
}