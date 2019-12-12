<?php defined('SYSPATH') or die('No direct script access.');

class Model_DiscountMod extends Model {
    
    public function get_disc_name($id,$lang) {
        $res = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        return $res;
    }
    
    public function get_all(){
        $res = DB::select()->from('tickerdiscount')->order_by('weight','ASC')->execute()->as_array();
        return $res;
    }
    
    public function get_all_discount($lang){
        $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            execute()->as_array();
            $new = array();
            foreach($res as $dis){
                $new[$dis['main_id']] = $dis['main_id'];
            }
            $info =  array();
            foreach($new as $ne){
                $info[] = DB::select()->from('tickerdiscount')->
                join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')->where('tickerdiscount.main_id','=',$ne)->and_where('tickerdiscount_i18n.culture','=',$lang)->execute()->current();
            }
            //print_r($res);
            //die;
            return $info;
    }
    
    public function get_all_discount_ferryman($id,$lang,$sys_id){
        
       
       //print_r($sys_id);
       
       $all_discounts = DB::select('dis_id')->from('system_users_discounts')->where('sys_id','=',$sys_id)->execute()->as_array();
         $simple_dis = array();
         foreach($all_discounts as $ad){
             array_push($simple_dis,$ad['dis_id']);
         }
         
         if(!empty($simple_dis)){
             $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            //where('ferryman_id','=',$id)->
            and_where('see_sell','=',1)->
            and_where('hidden','=',0)->
            and_where('ticker_discount_id','in',$simple_dis)->
            order_by('weight','DESC')->
            execute()->as_array();
         }else{
            //$res = array();
            echo 'No discounts';
            //die;
         }
         
        
            
            ///die;
            $order = 1;
            
            if(!empty($res)){
                $new = array();
                foreach($res as $dis){
                    $new[$dis['main_id']] = $dis['main_id'];
                }
                $info = array();
                foreach($new as $ne){
                    $info[] = DB::select()->from('tickerdiscount')->
                    join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')->where('tickerdiscount.main_id','=',$ne)->and_where('tickerdiscount_i18n.culture','=',$lang)->execute()->current();
                }
                
                $order = Model::factory('TiketMod')->order_array_desc($info,'weight');
            }
            
            //print_r($res);
            //die;
            return $order;
    }
    
    public function get_all_discount_ferryman_fixet($route_name_id,$id,$lang,$prior,$open){
        
        
        $sesuser = Session::instance()->get('ses_user');
        
        if($open == 1){
            $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            //where('ferryman_id','=',$id)->
            and_where('see_sell','=',1)->
            and_where('hidden','=',0)->
            and_where('open','=',1)->
            order_by('weight','DESC')->
            execute()->as_array();
        }else{
            $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            where('ferryman_id','=',$id)->
            and_where('see_sell','=',1)->
            and_where('hidden','=',0)->
            and_where('open','=',0)->
            order_by('weight','DESC')->
            execute()->as_array();
        }
        
            
         
         
         
         
            
            $res_new = array();  
            foreach($res as $res_fix){
                $all_rou = explode(',',$res_fix['routes']);
                foreach($all_rou as $rr){
                    if($rr == $route_name_id){
                        $res_new[] = $res_fix; 
                    }
                }
            }  
            
            
            $res = $res_new;
            
            
            $order = 1;
            
            if(!empty($res)){
                $new = array();
                foreach($res as $dis){
                    $new[$dis['main_id']] = $dis['main_id'];
                }
                
                //print_r($new);
                //ie;
                ///*
                $new_prior = array();
                foreach($new as $n){
                    $chek_prior = DB::select()->from('system_users_priorety_discounts')->
                    where('main_id','=',$n)->
                    and_where('sysuser_id','=',$sesuser[0]['id'])->
                    //and_where('priory','=',$prior)->
                    execute()->current();
                    if($chek_prior['priory'] == $prior){
                        $new_prior[] = $n;
                    }
                }
                
                $new = $new_prior;
                //*/
                if(!empty($new)){
                $info = array();
                foreach($new as $ne){
                    $info[] = DB::select()->from('tickerdiscount')->
                    join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')->where('tickerdiscount.main_id','=',$ne)->and_where('tickerdiscount_i18n.culture','=',$lang)->execute()->current();
                }
                
                $order = Model::factory('TiketMod')->order_array_desc($info,'weight');
                }
            }
            
            //print_r($res);
            //die;
            return $order;
    }
    
    public function get_all_discount_ferryman_hidden($id,$lang,$sys_id){
        $all_discounts = DB::select('dis_id')->from('system_users_discounts')->where('sys_id','=',$sys_id)->execute()->as_array();
         
         //print_r($all_discounts);
         //die;
         
         $simple_dis = array();
         foreach($all_discounts as $ad){
             array_push($simple_dis,$ad['dis_id']);
         }
         
          if(!empty($simple_dis)){
         
         
         $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            //where('ferryman_id','=',$id)->
            and_where('see_sell','=',1)->
            and_where('hidden','=',1)->
            and_where('ticker_discount_id','in',$simple_dis)->
            order_by('weight','DESC')->
            execute()->as_array();
          }else{
            echo 'No discounts';
            //die;
          }  
            $order = 1;
            
            if(!empty($res)){
            
                $new = array();
                foreach($res as $dis){
                    $new[$dis['main_id']] = $dis['main_id'];
                }
                $info =  array();
                foreach($new as $ne){
                    $info[] = DB::select()->from('tickerdiscount')->
                    join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')->where('tickerdiscount.main_id','=',$ne)->and_where('tickerdiscount_i18n.culture','=',$lang)->execute()->current();
                }
                $order = array();
                if(!empty($info)){
                    $order = Model::factory('TiketMod')->order_array_desc($info,'weight');
                }
            
            }
            //print_r($res);
            //die;
            return $order;
    }

} // End Metki
