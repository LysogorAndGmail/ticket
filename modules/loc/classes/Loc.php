<?
class Loc {

    public static function get_loc() {
        //define('IP',$_SERVER['REMOTE_ADDR']);
        //$ip = $_SERVER['REMOTE_ADDR'];
        //$link = 'http://ip-api.com/json/'.$ip;
        //$loc = file_get_contents($link);
        //$loc = new SimpleXMLElement($xml);
        //$country = $loc->ip->country;
        //$loc = json_decode($loc);
        //$country = $loc->countryCode;
        $country = '';
        if(empty($country)){
            $country = 'net';
        }
        return $country;
    }
}

