<?php defined('SYSPATH') or die('No direct script access.');

class Model_NewsMod extends Model {
    
    public function get_news($id,$lang) {
        $res = DB::select()->from('svitgonews')->join('svitgonews_i18n')->on('svitgonews.news_id','=','svitgonews_i18n.news_id')->where('svitgonews.news_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_news_cat($id,$lang) {
        $res = DB::select()->from('svitgo_news_cat')->join('svitgo_news_cat_i18n')->on('svitgo_news_cat.id','=','svitgo_news_cat_i18n.cat_id')->where('svitgo_news_cat.id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_all($lang){
        $res = DB::select()->from('svitgonews')->join('svitgonews_i18n')->on('svitgonews.news_id','=','svitgonews_i18n.news_id')->and_where('culture','=',$lang)->execute()->as_array();
        return $res;
    }
    
    public function get_all_cats_svitgo($lang){
        $res = DB::select()->from('svitgo_news_cat')->join('svitgo_news_cat_i18n')->on('svitgo_news_cat.id','=','svitgo_news_cat_i18n.cat_id')->and_where('culture','=',$lang)->execute()->as_array();
        return $res;
    }

} // End Metki
