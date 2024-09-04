<?php
class Model extends Aries{
    public function scanedir($dir){
        $f = [];
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                $f[] = $object;
                }
            }
        }
        return $f;
    }
    public function check_item($p,$i){
        if (is_dir($p.$i)) {
            return '<span class="badge text-bg-primary">
                <i class="fas fa-folder"></i>
                </span>';
        }else {
            return $this->file_icon($i);
        }
    }
    public function file_icon($i){
        $files = [
            "php" => '<span class="badge text-bg-primary ">
                <i class="fab fa-php"></i>
                </span>',
            "word" => '<span class="badge text-bg-primary">
                <i class="fas fa-file-word"></i>
                </span>',
            "excel" => '<span class="badge text-bg-primary">
                <i class="fab fa-file-excel"></i>
                </span>',
            "pptx" => '<span class="badge text-bg-primary">
                <i class="fab fa-file-powerpoint"></i>
                </span>',
            "pdf" => '<span class="badge text-bg-primary ">
                <i class="fas fa-file-pdf"></i>
                </span>',
            "html" => '<span class="badge text-bg-primary">
                <i class="fab fa-html5"></i>
                </span>',
            "css" => '<span class="badge text-bg-primary">
                <i class="fab fa-css3-alt"></i>
                </span>',
            "js" => '<span class="badge text-bg-primary">
                <i class="fab fa-js"></i>
                </span>',
            "music" => '<span class="badge text-bg-primary">
                <i class="fas fa-file-audio"></i>
                </span>',
            "video" => '<span class="badge text-bg-primary">
                <i class="fas fa-file-video"></i>
                </span>',
            "image" => '<span class="badge text-bg-primary">
                <i class="fas fa-file-image"></i>
                </span>',
            "zip" => '<span class="badge text-bg-primary">
                <i class="fas fa-file-archive"></i>
                </span>',
            "default" => '<span class="badge text-bg-primary">
                <i class="fas fa-file"></i>
                </span>'
            ];
            
        $music = ["mp3"];
        $image = ["jpg","jpeg","png","gif","tiff"
            ];
        $video = ["mp4","mkv"];
        $word = ["doc",'docx'];
        $excel = ["xls",'xlsx'];
        $f = pathinfo($i,PATHINFO_EXTENSION);
        $f = strtolower($f);
        switch ($f) {
            case in_array($f,$music):
                $f = "music";
                break;
            case in_array($f,$video):
                $f = "video";
                break;
            case in_array($f,$image):
                $f = "image";
                break;
                case in_array($f,$word):
                $f = "word";
                break;
            case in_array($f,$excel):
                $f = "excel";
                break;
            case array_key_exists($f,$files):
                $f = $f;
                break;
            default:
                $f = "default";
                break;
        }
        return $files[$f];
    }
    public function new_item($data,$path){
        $item = $data["item"];
        $type = $data["type_item"];
        $dir = $data["path"];
        
        if (empty($item)) {
                Flasher::set("Adding item failed","Required name item","danger");
                $this->redirect("Home/Index/".$path);
            }
        if ($type == "file") {
            if (is_file($dir.$item)) {
                Flasher::set("Adding item failed","File already exists","danger");
                $this->redirect("Home/Index/".$path);
            }else{
                file_put_contents($dir.$item,"");
                Flasher::set("Save changes","New files added","success");
                $this->redirect("Home/Index/".$path);
            }
        }
        if ($type == "folder") {
            if (is_dir($dir.$item)) {
                Flasher::set("Adding item failed","Folder already exists","danger");
                $this->redirect("Home/Index/".$path);
            }else {
                $old = umask(0);
                mkdir($dir.$item,0777);
                umask($old);
                Flasher::set("Save changes","New folder added","success");
                $this->redirect("Home/Index/".$path);
            }
        }
        
    }
    public function rename_item($data,$dir){
        $from = $data["from"];
        $path = $data["path"];
        $item = $data["item"];
        
        if (empty($item)) {
                Flasher::set("Rename item failed","Required name item","danger");
                $this->redirect("Home/Index/".$dir);
        }
        if($from == $item){
            $this->redirect("Home/Index/".$dir);
        }
        if (rename($path.$from,$path.$item)) {
            Flasher::set("Rename item success","Rename item successfuly","success");
                $this->redirect("Home/Index/".$dir);
        }
    }
    public function del_item($data,$dir){
        $path = $data["path"];
        $item = $data["item"];
        if (is_dir($path.$item)) {
            
                $this->rrmdir($path.$item."/");
                Flasher::set("Delete item success","Delete item successfuly","success");
                $this->redirect("Home/Index/".$dir);
            
        }
        if (is_file($path.$item)) {
            if (unlink($path.$item)) {
                Flasher::set("Delete item success","Delete item successfuly","success");
                $this->redirect("Home/Index/".$dir);
            }
        }
    }
    public function copy_item($data){
        $path = $data["path"];
        $item = $data["item"];
        $to = $data["to"];
        $dir = urlencode(base64_encode($to));
        if ($this->acopy($path,$item,$to)) {
            Flasher::set("Copy item success","Copy item successfuly","success");
            $this->redirect("Home/Index/".$dir);
        }
    }
    public function copy_checked($data){
        $path = $data["path"];
        $items = explode(",",$data["items"]);
        $to = $data["to"];
        $dir = urlencode(base64_encode($to));
        foreach ($items as $item){
            
            $this->acopy($path,$item,$to);
        }
        
        
            Flasher::set("Copy item success","Copy item successfuly","success");
            $this->redirect("Home/Index/".$dir);
        
    }
    
    public function move($data){
        $path = $data["path"];
        $item = $data["item"];
        $to = $data["to"];
        $dir = urlencode(base64_encode($to));
        $this->acopy($path,$item,$to);
        if (is_dir($path.$item)) {
                $this->rrmdir($path.$item."/");
        }
        if (is_file($path.$item)) {
            unlink($path.$item);
        }
        Flasher::set("Move item success","Move item successfuly","success");
        $this->redirect("Home/Index/".$dir);
        
    }
    public function move_checked($data){
        $path = $data["path"];
        $items = explode(",",$data["items"]);
        $to = $data["to"];
        $dir = urlencode(base64_encode($to));
        
        foreach ($items as $item){
        $this->acopy($path,$item,$to);
        if (is_dir($path.$item)) {
                $this->rrmdir($path.$item."/");
        }
        if (is_file($path.$item)) {
            unlink($path.$item);
        }
        }
        Flasher::set("Move item success","Move item successfuly","success");
        $this->redirect("Home/Index/".$dir);
        
    }
    public function del_checked($data,$dir){
        $path = $data["path"];
        $items = $data["items"];
        $items = explode(",",$items);
        foreach ($items as $item){
            
            if (is_dir($path.$item)) {
            
                $this->rrmdir($path.$item."/");
                
            
            }
            if (is_file($path.$item)) {
                unlink($path.$item);
                
            
            }
            
        }
        
        Flasher::set("Delete item success","Delete item successfuly","success");
        $this->redirect("Home/Index/".$dir);
    }
        public function acopy($path,$item,$to){
        if (is_dir($path.$item)) {
            $this->copydir($path,$item,$to);
            return true;
        } else {
        if (file_exists($to.$item)) {
            $r = "copy_of_";
            $r = $r.$item;
            copy($path.$item,$to.$r);
            return true;
        }else {
            copy($path.$item,$to.$item);
            return true;
        }
        }
        
        
    }
    public function upload($data,$dir){
        $path = $data["path"];
        $files = $_FILES["files"];
        foreach ($files["name"] as $key=>$value){
            if ($files["error"][$key] > 0) {
                Flasher::set("Upload file failed","Upload file error","danger");
        $this->redirect("Home/Index/".$dir);
            }
            if ($files["size"][$key] > 1024*1024*1024) {
                Flasher::set("Upload file failed","File size is too large","danger");
                $this->redirect("Home/Index/".$dir);
            }
            $tmp = $files["tmp_name"][$key];
            move_uploaded_file($tmp,$path.$value);
            Flasher::set("Upload file success","Upload file successfuly","success");
                $this->redirect("Home/Index/".$dir);
        }
        
    }
    public function unzip($data,$dir){
        $path = $data["path"];
        $item = $data["item"];
        $zip = new ZipArchive;
$res = $zip->open($path.$item);
if ($res === TRUE) {
  $zip->extractTo($path);
  $zip->close();
  Flasher::set("Unzip file success","Unzip file successfuly","success");
$this->redirect("Home/Index/".$dir);
} else {
  Flasher::set("Unzip file failed","Unzip file error","danger");
$this->redirect("Home/Index/".$dir);
}
    }
    public function zip($path){
$zip = new ZipArchive();
$filename = "./test112.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}
    $zip->addEmptyDir("arspay");

$zip->close();
    }
    public function createZip($zipArchive, $folder)
{
    if (is_dir($folder)) {
        if ($f = opendir($folder)) {
            while (($file = readdir($f)) !== false) {
                if (is_file($folder . $file)) {
                    if ($file != '' && $file != '.' && $file != '..') {
                        $zipArchive->addFile($folder.$file);
                    }
                } else {
                    if (is_dir($folder . $file)) {
                        if ($file != '' && $file != '.' && $file != '..') {
                            $zipArchive->addEmptyDir($file);
                            $folder = $folder . $file . '/';
                            $this->createZip($zipArchive, $folder);
                        }
                    }
                }
            }
            closedir($f);
        } else {
            exit("Unable to open directory " . $folder);
        }
    } else {
        exit($folder . " is not a directory.");
    }
}
    public function copydir($path_from,$item,$path_to) {
        $dir = $item;
        if (is_dir($path_to.$item)) {
            $dir = "copy_of_".$item;
        }
        mkdir($path_to.$dir);
     $objects = scandir($path_from.$item);

     foreach ($objects as $object) {

       if ($object != "." && $object != "..") {

         if (filetype($path_from.$item."/".$object) == "dir") $this->copydir($path_from.$item."/",$object,$path_to.$dir."/"); else copy($path_from.$item."/".$object,$path_to.$dir."/".$object);

       }

     }
    }
    public function rrmdir($dir) {

   if (is_dir($dir)) {

     $objects = scandir($dir);

     foreach ($objects as $object) {

       if ($object != "." && $object != "..") {

         if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);

       }

     }

     reset($objects);

     rmdir($dir);

   }

 }
}
