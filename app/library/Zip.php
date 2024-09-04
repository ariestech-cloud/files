<?php
class Zip extends ZipArchive 
{
 public function addDir($location) 
 {
       $name = basename($location)
       $this->addEmptyDir($name);
       $this->addDirDo($location, $name);
 }
 private function addDirDo($location, $name) 
 {
    $name .= '/';
    $location .= '/';
    $dir = opendir ($location);
    while ($file = readdir($dir))
    {
        if ($file == '.' || $file == '..') continue;
        $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
        $this->$do($location . $file, $name . $file);
    }
 } 
}
