<?php defined('SYSPATH') or die('No direct script access.');

class Model_FerrymanMod extends Model {
    
    public function get_ferryman($id) {
        $res = DB::select()->from('ferryman')->where('ferryman_id','=',$id)->execute()->current();
        return $res;
    }
    
    public function search_ferryman_id($id) {
        $res = DB::select()->from('ferryman')->where('ferryman_id','LIKE',"%".$id."%")->execute()->as_array();
        return $res;
    }
    
    public function search_ferryman_name($name) {
        $res = DB::select()->from('ferryman')->where('name','LIKE',"%".$name."%")->execute()->as_array();
        return $res;
    }
        
    public function get_all() {
        $res = DB::select()->from('ferryman')->execute()->as_array();
        return $res;
    }

} // End Metki
