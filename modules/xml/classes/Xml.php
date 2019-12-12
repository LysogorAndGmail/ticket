<? require_once('Array2XML.php');

class Xml {

    public static function creete_xml($array) {
        header('Content-type: application/xml');
        $converter = new Array2XML();
        $xmlStr = $converter->convert($array);
        echo $xmlStr;
    }
}

