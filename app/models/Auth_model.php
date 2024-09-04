<?php 
class Auth_model extends Aries{
    public function is_login($login = true){
        
        if ($login == true) {
            if (isset($_SESSION["user"])) {
                
                if ($this->userdata() == false) {
                $this->redirect("Auth");
                }else{
                    return $this->userdata();
                } 
            }else{
                $this->redirect("Auth");
            }
            
            
        }else{
            if (isset($_SESSION["user"])) {
                $this->redirect("Home");
            }
        }
    }
    public function userdata(){
        if (isset($_SESSION["user"])) {
            
            $username = $_SESSION["user"]["username"];
            $this->db->get_where("user",["username"=>$username]);
            return $this->db->row();
        }
    }
}