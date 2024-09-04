<?php 
class Auth extends Aries{
    public function Index(){
        
        $data["title"] = "Ariestech | Filemanager";
        $this->model("Auth_model")->is_login(false);;
        
        $this->view("tmp/header",$data);
        $this->view("auth/login");
        $this->view("tmp/footer");
    }
    public function login(){
        $this->model("Auth_model")->is_login(false);
        $this->library("Form_validation");
        $this->lib->set_rule("username","Username",["trim","required","min_length"=>3,"in_db"=>"user|username"]);
        $this->lib->set_rule("password","Password",["trim","required","min_length"=>8]);
        if ($this->lib->run() == false) {
            $this->redirect("Auth");
        }
            $username = $this->lib->get_value("username");
            $this->db->get_where("user",["username"=>$username]);
            $data = $this->db->row();
            
            $this->lib->set_rule("password","Password",["password_verify"=>$data["password"]]);
            if ($this->lib->run() == false) {
                $this->redirect("Auth");
            }
            $user = ["username"=>$username];
            
            $this->session("user",$user);
            
            $this->redirect("Home");
    }
   public function Logout(){
        unset($_SESSION);
        session_destroy();
        $this->redirect("Auth");
    }
}