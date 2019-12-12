<?php defined('SYSPATH') or die('No direct script access.');

class Model_PostMod extends Model {
    
    public function get_post($id,$lang) {
        $res = DB::select()->from('svitgoarticle')->join('svitgoarticle_i18n')->on('svitgoarticle.article_id','=','svitgoarticle_i18n.article_id')->where('svitgoarticle.article_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_page($id,$lang) {
        $res = DB::select()->from('pages')->join('pages_i18n')->on('pages.page_id','=','pages_i18n.page_id')->and_where('pages.page_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_all_posts($lang) {
        $res = DB::select()->from('svitgoarticle')->join('svitgoarticle_i18n')->on('svitgoarticle.article_id','=','svitgoarticle_i18n.article_id')->where('culture','=',$lang)->execute()->as_array();
        return $res;
    }
    
    public function get_all_pages($lang) {
        $res = DB::select()->from('pages')->join('pages_i18n')->on('pages.page_id','=','pages_i18n.page_id')->where('culture','=',$lang)->execute()->as_array();
        return $res;
    }
    
    public function get_all_menu() {
        $res = DB::select()->from('svitgomenu')->execute()->as_array();
        return $res;
    }
    
    public function get_menu_list($menu_id,$lang) {
        $res = DB::select()->from('svitgomenu_list')->join('svitgomenu_list_i18n')->on('svitgomenu_list.list_id','=','svitgomenu_list_i18n.list_id')->where('svitgomenu_list.menu_id','=',$menu_id)->where('culture','=',$lang)->execute()->as_array();
        return $res;
    }

} // End Metki
