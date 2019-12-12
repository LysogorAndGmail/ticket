<?php defined('SYSPATH') or die('No direct script access.');

class Model_RouteMod extends Model {
    
    public static function get_route_all_citys_esy($route_name_id) {
        $res = DB::select()->from('route')->where('route_name_id','=',$route_name_id)->execute()->as_array();   
        return $res;
    }
    
    public function get_route_id($name,$lang,$pub) {
         $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_id','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->and_where('is_public','=',$pub)->execute()->as_array();
         return $res;
    }
    
    public function get_route_route_id($name,$lang,$pub) {
         $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->and_where('is_public','=',$pub)->execute()->as_array();
         return $res;
    }
    
    public function get_route_id_one($name,$lang) {
         $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->execute()->current();
         return $res;
    }
    
    public function get_route_name_i18n($name,$lang,$pub) {
         $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('name_i18n','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->and_where('is_public','=',$pub)->execute()->as_array();
         return $res;
    }
    
    public function get_route_nom($name,$lang,$pub) {
         $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('name','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->and_where('is_public','=',$pub)->execute()->as_array();
         return $res;
    }
    
    public function get_city_time($r_id,$dey_week,$rice) {
    
        $res = DB::select()->from('routeweek')->where('r_id','=',$r_id)->and_where('week_id','=',$dey_week)->and_where('rice','=',$rice)->execute()->current();
        return $res;    
   }
   
   public function get_ost_name($id,$culture) {
    
        $res = DB::select()->from('routecity_i18n')->where('route_city_id','=',$id)->and_where('culture','=',$culture)->execute()->current();
        return $res;    
   }
   
   public function get_platform($route_name_id,$day_week,$ost_id,$ferryman) {
    
        $res = DB::select()->from('platform')
            ->where('route_name_id','=',$route_name_id)
            ->and_where('day_week','=',$day_week)
            ->and_where('ost_id','=',$ost_id)
            //->and_where('farryman_id','=',$ferryman)
            ->execute()->current();
        //print_r($res);
        
        return $res;    
   }
    

} // End Metki
