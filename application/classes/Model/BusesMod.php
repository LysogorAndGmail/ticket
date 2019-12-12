<?php defined('SYSPATH') or die('No direct script access.');

class Model_BusesMod extends Model {
    
    public function get_bus($id,$lang) {
        $res = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function search_bus_id($id,$lang) {
        $res = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','LIKE',"%".$id."%")->and_where('buses_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
    }
    
    public function search_bus_name($name,$lang) {
        $res = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses_i18n.name_i18n','LIKE',"%".$name."%")->and_where('buses_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
    }
        
    public function get_all($lang) {
        $res = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
    }
    
     public function get_bagaj($id,$lang) {
        $res = DB::select()->from('bagaj')->join('bagaj_i18n')->on('bagaj.id','=','bagaj_i18n.bagaj_id')->and_where('bagaj.id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_blocket_nikolo($route_name_id,$from,$to,$route_date){
        
        $nikol_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$route_name_id)->execute()->current();
        if(empty($nikol_route)){
            //echo 'empty nikolo route';
            //die;
        }
        
        $nikolo_from_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$from)
        ->and_where('join_route','=',$nikol_route['reg_route_id'])
        ->execute()->current();
        if(empty($nikolo_from_ost)){
            //echo 'empty $nikolo_from_ost';
            //die;
        }
        $nikolo_to_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)
        ->and_where('join_route','=',$nikol_route['reg_route_id'])
        ->execute()->current();
        if(empty($nikolo_to_ost)){
            //echo 'empty $nikolo_to_ost';
            //die;
        }
        
        //echo $nikol_route['reg_route_id'].' '.$nikolo_from_ost['reg_ost_id'].' '.$nikolo_to_ost['reg_ost_id'];
        $chek_date = Model::factory('TiketMod')->get_date_for_api_soap($route_date,$route_name_id,$from);
        if($chek_date == 1){
            $d = new DateTime($route_date);
            $d->modify("-1 day");
            $route_date = $d->format("Y-m-d");
        }
        $all_free = array();
        $route = new stdClass();
        $route->route_id = $nikol_route['reg_route_id'];
        $route->from_id = $nikolo_from_ost['reg_ost_id'];
        $route->to_id = $nikolo_to_ost['reg_ost_id'];
        $route->date = $route_date;
        $regabus = new Regabus();
        $all = $regabus->get_route($route);
        if(!empty($all[0]->free_seat)){
            $all_free = $all[0]->free_seat;
        }
        //echo '<pre>';
        //print_r();
        //echo '</pre>';
        return $all_free;
        //die;
        
    }
    
    public function chek_newblocket_plase($route,$date,$bus,$ferryman){
         $all = DB::select()->from('newblocket_plase')
                ->where('route_name_id','=',$route)
                ->and_where('date','=',$date)
                ->and_where('buses','=',$bus)
                ->and_where('ferryman','=',$ferryman)
                ->execute()->as_array();
         
         $all_blocket = array();
         foreach($all as $one){
            $new_arr = explode(',',$one['plases']);
            foreach($new_arr as $new){
                array_push($all_blocket, $new);
            }
            
         }   
         
        return $all_blocket;    
        //echo '<pre>';
        //print_r($all_blocket);
        //echo '</pre>';   
        //die;   
                
    }

} // End Metki
