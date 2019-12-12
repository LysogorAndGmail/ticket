<?
class File {
    
    public function __construct()
    {
        define('PATH',$_SERVER['DOCUMENT_ROOT']);
    } 
    
    public static function new_folder($folder_name) {
       
       $res = mkdir(PATH."/".$folder_name, 0777);
       
       if($res === true) {
        return true;
       }else {
        return false;
       }
    }
    
    public static function new_file($folder,$file_name,$content) {
       
       $fp = fopen(PATH."/".$folder."/".$file_name, "w+");
       fwrite($fp, $content);
       fclose($fp);
       if($fp === true) {
        return true;
       }else {
        return false;
       }
    }
    
    public static function read_file($folder,$file_name){
        $fp = fopen(PATH."/".$folder."/".$file_name, "rb");
        $contents = stream_get_contents($fp);
        fclose($fp);
        echo $contents;
    }
    
    public static function find_file($folder,$file_name){
   	
        $filelist = array();
        if ($handle = opendir(PATH."/".$folder)) {
        while ($entry = readdir($handle)) {
            if (strpos($entry, $file_name) === 0) {
                $filelist[] = $entry;
            }
        }
        closedir($handle);
        }
        print_r($filelist);
        die;
    }
    
}

