<?php
class Home extends Aries {
    public function Index($dir = ""){
        
        if (empty($dir)) {
            $data["dir_path"] = $this->config->dir_path;
            $data["hash_dir"] = urlencode(base64_encode($this->config->dir_path));
        }else{
            $data["dir_path"] = urldecode(base64_decode($dir));
            $data["hash_dir"] = $dir;
        }
        
        
        $data["items"] = $this->model("Model")->scanedir($data["dir_path"]);
        $data["title"] = "Ariestech | Filemanager";
        $data["user"] = $this->model("Auth_model")->is_login();
        $this->view("tmp/header",$data);
        $this->view("tmp/navbar",$data);
        $this->view("home/index",$data);
        $this->view("tmp/footer",$data);
        if (isset($_POST["add"])) {
            $this->model("Model")->new_item($_POST,$dir);
            }
        if (isset($_POST["rename"])) {
            $this->model("Model")->rename_item($_POST,$dir);
            }
        if (isset($_POST["del"])) {
            $this->model("Model")->del_item($_POST,$dir);
            }
        if (isset($_POST["copy"])) {
            
            $this->model("Model")->copy_item($_POST,$dir);
            }
        if (isset($_POST["del_checked"])) {
            
            $this->model("Model")->del_checked($_POST,$dir);
            }
        if (isset($_POST["copy_checked"])) {
            
            $this->model("Model")->copy_checked($_POST);
            }
        if (isset($_POST["move"])) {
            
            $this->model("Model")->move($_POST);
            }
        if (isset($_POST["move_checked"])) {
            
            $this->model("Model")->move_checked($_POST);
            }
        if (isset($_POST["upload"])) {
            
            $this->model("Model")->upload($_POST,$dir);
            }
 if (isset($_POST["unzip"])) {
            
            $this->model("Model")->unzip($_POST,$dir);
            }
if (isset($_POST["download_checked"])) {

            $this->model("Model")->download_checked($_POST);
            }
    }
    public function Fileview($u){
        $u = urldecode(base64_decode($u));
        
        $hex = explode("/",$u);
        $data["filename"] = end($hex);
        $data["path"] = $u;
        $data["user"] = $this->model("Auth_model")->is_login();
        $i = count($hex)-1;
        unset($hex[$i]);
        
        $data["dir_path"] = implode("/",$hex);
        $d = urlencode(base64_encode($data["dir_path"]."/"));
        
        if (is_dir($u)) {
            Flasher::set("Forbiden","Access denied","warning");
            $this->redirect("Home/Index/".$d);
            
        }
        if (!is_file($u)) {
            Flasher::set("Forbiden","Access denied","warning");
            $this->redirect("Home/Index/".$d);
            
        }
        if (isset($_POST["back"])) {
            $this->redirect("Home/Index/".$d);
        }
        $data["code"] = htmlspecialchars(file_get_contents($u));
        $data["title"] = "Ariestech | Filemanager";
        
        $this->view("tmp/header",$data);
        $this->view("tmp/navbar",$data);
        $this->view("home/editfile",$data);
        $this->view("tmp/footer");
        
        if (isset($_POST["save"])) {
            file_put_contents($_POST["path"],htmlspecialchars_decode($_POST["text_file"]));
            $u = urlencode(base64_encode($u));
            Flasher::set("Save changes","File changed successfully","success");
            $this->redirect("Home/Fileview/".$u);
        }
        
    }
    public function Download($path){
        $path = urldecode(base64_decode($path));
        
    if (is_dir($path)) {
        
        $this->model("Model")->zip($path);
        $file = $path.".zip";
    } else {
        $file = $path;
    }
               // Set the Content-Type header to application/octet-stream
   header('Content-Type: application/octet-stream');

   // Set the Content-Disposition header to the filename of the downloaded file
   header('Content-Disposition: attachment; filename="'. basename($file).'"');

   // Read the contents of the file and output it to the browser.
   readfile($file);

    }
    public function Ajax($dir = ""){
        $data["dir_path"] = urldecode(base64_decode($dir));
        $data["items"] = $this->model("Model")->scanedir($data["dir_path"]);
        
        $this->view("home/ajax",$data);
    }
    public function Setting(){
        $data["title"] = "Ariestech | Filemanager";
        $data["user"] = $this->model("Auth_model")->is_login();
        $this->view("tmp/header",$data);
        $this->view("tmp/navbar",$data);
        $this->view("home/setting",$data);
        $this->view("tmp/footer");
    }
    public function Editprofile(){
        $data["title"] = "Ariestech | Filemanager";
        $data["user"] = $this->model("Auth_model")->is_login();
        $this->library("Form_validation");
        $this->lib->set_rule("username","Username",["trim","required","min_length"=>3]);
        $this->lib->set_rule("password","Password",["trim","required","min_length"=>8,"password_hash"]);
        if ($this->lib->run() == false) {
            $this->redirect("Home/Setting");
        }
        $input = ["username"=>$this->lib->get_value("username"),"password"=>$this->lib->get_value("password")];
        $where = ["id" =>$data["user"]["id"]];
        
        if ($this->db->update("user",$input,$where) < 1) {
            Flasher::set("Edit profile failed","Error","danger");
            $this->redirect("Home");
        }
        $user = ["username"=>$input["username"]];
        
        $this->session("user",$user);
            
        $this->redirect("Home");
        
    }
}
