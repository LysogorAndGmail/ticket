<?php defined('SYSPATH') or die('No direct script access.');

class Model_GroupMod extends Model {
    
    public function get_all_groups() {
        $res = DB::select()->from('groups')->execute()->as_array();
        return $res;
    }
    
    public function chek_group_price_api($group,$route_name,$fer,$from,$to,$date,$return) {
        $res = DB::select('price','valute')->from('routeprice_groups')
        ->where('group_id','=',$group)
        ->and_where('route_name_id','=',$route_name)
        ->and_where('ferryman_id','=',$fer)
        ->and_where('route_city_from_id','=',$from)
        ->and_where('route_city_to_id','=',$to)
        //->and_where('valute','=',$valute)
        ->and_where(DB::expr('DATE(`date_from`)'),'<=',$date)
        ->and_where(DB::expr('DATE(`date_to`)'),'>=',$date)
        ->and_where('ret','=',$return)
        ->execute()->as_array();
        //print_r($res);
        return $res;
    }
    
    public function chek_group_price($group,$route_name,$fer,$from,$to,$valute,$date) {
        $res = DB::select()->from('routeprice_groups')
        //->where('group_id','=',$group)
        ->and_where('route_name_id','=',$route_name)
        //->and_where('ferryman_id','=',$fer)
        ->and_where('route_city_from_id','=',$from)
        ->and_where('route_city_to_id','=',$to)
        ->and_where('valute','=',$valute)
        ->and_where(DB::expr('DATE(`date_from`)'),'<=',$date)
        ->and_where(DB::expr('DATE(`date_to`)'),'>=',$date)
        ->execute()->current();
        //print_r($res);
        return $res;
    }

} // End Metki
