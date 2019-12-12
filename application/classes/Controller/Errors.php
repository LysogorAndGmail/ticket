<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Errors extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_access() {    
        $data = array();    
        $this->template->content_admin = View::factory('error/access',$data);
	}
    
    public function action_404() {    
        $data = array();    
        $this->template->content_admin = View::factory('error/404',$data);
	}
    
     public function action_sql() {    
        //$data = array();    
        //$this->template->content_admin = View::factory('error/404',$data);
        $start_time = microtime(true);


        $start =  microtime();
        $lang = 'ru';
        $res = DB::select()->from('routeferrymanweek')->execute()->as_array();
        echo '<pre>';
        print_r($res);
        echo '</pre>';
        //printf('%.5f sec', microtime()-$start);
        $query_time = microtime(true)-$start_time;
        echo "$query_time millseconds";
        die; 
	}
    
    public function action_design() {    
        $this->template = View::factory('template_ticket_sell_light');
		$data = array();    
		
        $this->template->content_admin = View::factory('support/'.$_GET['file'],$data);
		
		     
        $this->template->top_head_admin = View::factory('top_head_disp');
        $this->template->header_admin = View::factory('header_disp');
        
        $this->template->left_sidebar_admin = '';
        $this->template->chat = '';
        $this->template->footer = '';
	}
    
    public function action_test() {    
        //$this->template = View::factory('template_ticket_sell_light');
		$data = array();    
        $this->template->top_head_admin = View::factory('top_head_disp');
        $this->template->header_admin = View::factory('header_disp');
        $this->template->content_admin = View::factory('error/test',$data);
        $this->template->left_sidebar_admin = '';
        $this->template->chat = '';
        $this->template->footer = '';
	}
    
    public function action_info_reverse() {    
        //$this->template = View::factory('template_ticket_sell_light');
		$data = array();    
        $this->template->top_head_admin = View::factory('top_head_disp');
        $this->template->header_admin = View::factory('header_disp');
        $this->template->content_admin = View::factory('error/info_reverse',$data);
        $this->template->left_sidebar_admin = '';
        $this->template->chat = '';
        $this->template->footer = '';
	}
    
    public function action_test_call(){ 
        $data = array();   
        $data['id'] = 10;
        $this->template->content_admin = View::factory('error/bizi_block',$data);    
    }
    
    public function action_ajax_get_bizi_call(){
        if($_POST){
            $data = array();   
        $data['id'] = 10;
            echo View::factory('bus/bizi_block_for_svitgo_schema',$data);
            die;
        }
    }
    
     public function action_timess(){ 
        $data = array();   
        $old_id = 1630;
        $old_route = DB::select()->from('route')->where('route_name_id','=',$old_id)->order_by('weight')->execute()->as_array();
        
        $new_id = 1631;
        $new_route = DB::select()->from('route')->where('route_name_id','=',$new_id)->order_by('weight')->execute()->as_array();
        
        /*
        echo '<pre>';
        print_r($old_route);
        echo '</pre>';  
        
        echo '<pre>';
        print_r($new_route);
        echo '</pre>';  
        */
        $i = 0;
        foreach($old_route as $old){
            //echo '<pre>';
            
            
            $all_route_week = DB::select()->from('routeweek')->where('r_id','=',$old['r_id'])->order_by('week_id')->execute()->as_array();
            foreach($all_route_week as $old_wek){
                DB::insert('routeweek',array(
                    'week_id',
                    'name',
                    'r_id',
                    'country_id',
                    'country_to_id',
                    'hours',
                    'time',
                    'created',
                    'days',
                    'hidden',
                    'rice',
                    'route_id',
                    'route_name_id',
                    'a_hours',
                    'a_time'
                ))->values(array(
                    $old_wek['week_id'],
                    $old_wek['name'],
                    $new_route[$i]['r_id'],
                    $old_wek['country_id'],
                    $old_wek['country_to_id'],
                    $old_wek['hours'],
                    $old_wek['time'],
                    date('Y-m-d h:i:s'),
                    $old_wek['days'],
                    $old_wek['hidden'],
                    $old_wek['rice'],
                    $old_wek['route_id'],
                    $new_id,
                    $old_wek['a_hours'],
                    $old_wek['a_time']
                ))->execute();
            }
           // print_r($all_route_week);
            
           // print_r($new_route[$i]);
          //  echo '</pre>'; 
            $i++;
        }
        
        
        
        
        
        die;
    }
    
    public function action_test2(){
         
         $id = 3;
         
         $sys_id = 47;
         
         $all_discounts = DB::select('dis_id')->from('system_users_discounts')->where('sys_id','=',$sys_id)->execute()->as_array();
         $simple_dis = array();
         foreach($all_discounts as $ad){
             array_push($simple_dis,$ad['dis_id']);
         }
         $res = DB::select()->from('tickerdiscount')->
            //join('TickerDiscount_i18n')->on('TickerDiscount.ticker_discount_id','=','TickerDiscount_i18n.ticker_discount_id')
            //
            where('ferryman_id','=',$id)->
            and_where('see_sell','=',1)->
            and_where('hidden','=',0)->
            and_where('main_id','in',$simple_dis)->
            order_by('weight','DESC')->
            execute()->as_array();
           echo '<pre>';
           print_r($res);
           echo '</pre>'; 
           die;
    }
    
    
} // End Admin
