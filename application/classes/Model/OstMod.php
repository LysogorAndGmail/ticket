<?php defined('SYSPATH') or die('No direct script access.');

class Model_OstMod extends Model {
    
    public function get_all_osts($lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('culture','=',$lang)->order_by('name_i18n')->execute()->as_array();
        return $res;
    }
    
    public function get_ajax_ost($ost_name) {
            $ost_name = trim($ost_name);
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('name_i18n','LIKE',"%".$ost_name."%")->and_where('culture','=','ru')->order_by('name_i18n')->limit(30)->execute()->as_array();
        
        return $res;
    }
    public function get_ajax_ost_id($ost_id,$culture) {
            $res = DB::select()->from('routecity_i18n')->where('route_city_id','=',$ost_id)->and_where('culture','=',$culture)->execute()->current();
        if(!empty($res)) {
            return 1;
        }else {
            return 0;
        }
        
    }
    public function get_ajax_ost_route($ost_id) {
            $res = DB::select()->from('route')->where('route_city_id','=',$ost_id)->execute()->as_array();
        return count($res);
        
    }
    
    public function get_ost($ost_id,$lang) {
        $res = DB::select()->from('routecity')->join('routecity_i18n')->on('routecity.route_city_id','=','routecity_i18n.route_city_id')->where('routecity.route_city_id','=',$ost_id)->and_where('culture','=',$lang)->execute()->current();
        //print_r($res);
        return $res;
        
    }
    
    public function get_all_ost_id($ost_id,$lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('routecity.route_city_id','LIKE','%'.$ost_id.'%')->and_where('routecity_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
        
    }
    
    public function get_all_ost_city($ost_city,$lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('routecity_i18n.city_i18n','LIKE','%'.$ost_city.'%')->and_where('routecity_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
        
    }
    
    public function get_all_ost_name($ost_name,$lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('routecity_i18n.name_i18n','LIKE','%'.$ost_name.'%')->and_where('routecity_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
        
    }
    
    public function get_all_ost_vill($ost_name,$lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('routecity_i18n.village','LIKE','%'.$ost_name.'%')->and_where('routecity_i18n.culture','=',$lang)->execute()->as_array();
        return $res;
        
    }
    
    public function chek_csv_ost($ost_city,$ost_name,$ost_village) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('culture','=','RU')->and_where('name_i18n','=',$ost_name)->and_where('city_i18n','=',$ost_city)->and_where('village','=',$ost_village)->execute()->current();
        //print_r($res);
        //die;
        if(!empty($res)){
            return 1;   
        }else {
            return 0;
        }
        
    }
    
    public function chek_csv_ost_all($ost_city,$ost_name) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('culture','=','ru')->and_where('name_i18n','=',$ost_name)->and_where('city_i18n','=',$ost_city)->execute()->current();
            return $res;
        
    }
    
    public function get_ferryman($id) {
        $res = DB::select()->from('ferryman')->where('ferryman_id','=',$id)->execute()->current();
            return $res;
    }
    
    public function get_all_simple() {
            $res = DB::select('route_city_id')->from('routecity')->order_by('route_city_id')->execute()->as_array();
        return $res;
    }
    
    
} // End Metki
