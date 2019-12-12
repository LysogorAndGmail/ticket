<? class Regabus {
    
    
    public static $REG = '';
    
    public function __construct(){
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');
	}
    
    public static function conect() {
        $login = 'blokace';
        $pass = 111111;
        $soap = new SoapClient("http://online.nikolo.cz/soap.wsdl");// соединение
        $status = $soap->soap_login($login, $pass); //$status = $soap->soap_logout(); // выйти из сесии
        if($status == 1){
            Regabus::$REG = $soap;
            return true;
        }else{
            return false;
        }
    }
    
    public static function get_info(){
        $info = Regabus::$REG->soap_info();
        echo '<pre>';
        print_r($info);
        echo '</pre>';
        die;
    }
    
    public static function get_route($route_search){
        $contect = Regabus::conect();
        if($contect === false){
            die('avtirization falied');
        }
        $route = Regabus::$REG->soap_route($route_search);
        if($route[0]->status == '-2'){
            $conect_other = Regabus::connect_other();
            if($conect_other === false){
                die('avtirization2 falied');
            }
            $route = Regabus::$REG->soap_route($route_search);
        }
        return $route;
        die;
    }
    
    public static function sell($sale, $client){
        
        $route = Regabus::$REG->soap_sale($sale, $client);
        return $route;
        die;
    }
    
    public static function sell_regabus($sale, $client){
        $conect_other = Regabus::connect_other();
        $route = Regabus::$REG->soap_sale($sale, $client);
        return $route;
        die;
    }
    
    public static function all_regabus_osts(){
        $info = Regabus::$REG->soap_info();
        return $info->citys;
    }
    
    public static function all_regabus_routes(){
        $info = Regabus::$REG->soap_info();
        $routes = $info->routes;
        $al_ro = array();
        foreach($routes as $rout){
            $arr_one = explode(' | ',$rout);
            $al_ro[] = array($arr_one[0],$arr_one[1]);
        }
        return $al_ro;
    }
    
    public static function connect_other(){
        $login = 'soap-api';
        $pass = 111111;
        $soap = new SoapClient("http://onlineregabus.cz/soap.wsdl");// соединение
        $status = $soap->soap_login($login, $pass); //$status = $soap->soap_logout(); // выйти из сесии
        if($status == 1){
            Regabus::$REG = $soap;
            return true;
        }else{
            return false;
        }
    }
    
    public static function anule_nikolo($tik_id){
        $res = '';
        Regabus::conect();
        $res = Regabus::$REG->soap_annule($tik_id);
        return $res;
    }
    
    public static function anule_rega($tik_id){
        $res = '';
        Regabus::connect_other();
        $res = Regabus::$REG->soap_annule($tik_id);
        return $res;
    }
    
    
}

