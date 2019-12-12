<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tiket extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {  
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $ses_user = $this->ses_user;
        $data = array();
        //print_r($ses_user);
        //die;
        if($ses_user['group_id'] == 1){
            $data['tikets'] = DB::select()->from('ticket')
            ->join('ticket_people','LEFT')->on('ticket.client_id','=','ticket_people.id')
            ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
            ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
            ->where(DB::expr('Date(create_report)'),'=',date('Y-m-d'))
            ->order_by('create_report','ASC')
            ->execute()->as_array();
        }else{
            $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses_user[0]['id']);
            
            if(count($children_arr_a) == 1){ // нет детей видет только свои билеты
            
                $data['tikets'] = DB::select()->from('ticketreport')
                ->join('ticket')->on('ticketreport.ticket_id','=','ticket.ticket_id')
                ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                ->where(DB::expr('Date(create_report)'),'=',date('Y-m-d'))
                ->and_where('sys_user','=',$ses_user[0]['id'])
                ->order_by('ticketreport.create_report','ASC')
                ->execute()->as_array();

            
            }else{
                
                //print_r($data['tikets']);
                
                $data['tikets'] = DB::select()->from('ticket')
                ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
                ->where(DB::expr('Date(create_report)'),'=',date('Y-m-d'))
                ->and_where('sys_user','in',$children_arr_a)
                ->order_by('ticketreport.create_report','ASC')
                ->execute()->as_array();
            }
            
            $have_see = $data['tikets'];
            $hav_chek = array();
            foreach($have_see as $see){
                $chek_rou = DB::select()->from('system_users_see_cassa')
                ->where('user_id','=',$ses_user[0]['id'])
                ->and_where('route_name_id','=',$see['route_name_id'])
                ->execute()->current();
                if(!empty($chek_rou)){
                    $hav_chek[] = $see;
                }
            }
            
            $data['tikets'] = $hav_chek;
            
            $data['tikets'] = Model::factory('TiketMod')->order_array_all($data['tikets'],'create_report','SORT_DESC');   
            
            
        }
         // payment

        if($_GET){
            $limit = 1000;
            $get = $_GET;
            array_pop($get);
            $strWhere = array();
            foreach ($get as $pararam => $value){
                if(trim($value)!='') {
                    
                    if($pararam == 'ticket_id' || $pararam == 'ferryman_id' || $pararam == 'route_name_id' || $pararam == 'create_report' || $pararam == 'route_date'){
                        //print_r($_GET);
                        //die;
                        if($pararam == 'create_report' && !empty($_GET['create_report_to'])){
                            $date = array_reverse(explode('/', $value));
                            $value = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
                            $date_to = array_reverse(explode('/', $_GET['create_report_to']));
                            $value2 = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0]));
                            $strWhere[] = 'Date(create_report) BETWEEN \''.$value.'\' AND \''.$value2 .'\'';
                        }
                        
                        if($pararam == 'route_date' && !empty($_GET['route_date_to'])){
                            $date = array_reverse(explode('/', $value));
                            $value = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
                            $date_to = array_reverse(explode('/', $_GET['route_date_to']));
                            $value2 = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0]));
                            $strWhere[] = 'route_date BETWEEN \''.$value.'\' AND \''.$value2 .'\'';
                        }
                        
                        if($pararam == 'ticket_id'){
                            $strWhere[] = 'ticket.ticket_id = '.$value.'';
                        }
                        if($pararam == 'ferryman_id'){
                            $strWhere[] = 'ticket.ferryman_id = '.$value.'';
                        }
                        if($pararam == 'route_name_id'){
                            $route = DB::select()->from('routename')->where('name','=',$value)->execute()->as_array();
                            //$strWhere[] = 'ticket.route_name_id = '.$route[0]['route_name_id'].'';
                            //$strWhere[] = 'ticket.route_name_id = '.$route[1]['route_name_id'].'';
                            $strWhere[] = 'ticket.route_name_id BETWEEN \''.$route[0]['route_name_id'].'\' AND \''.$route[1]['route_name_id'] .'\'';
                            
                            $route_reverse = DB::select()->from('route_reverse')->where('main_id','=',$value)->or_where('reverse_id','=',$value)->execute()->current();
                            $reverse = $value;
                            if($route_reverse['reverse_id'] == $value){
                                $reverse = $route_reverse['main_id'];
                            }
                            //$strWhere[] = 'ticket.route_name_id = '.$reverse;//.' AND ticket.route_name_id = '.$value;
                        }
                        
                    }else{
                        if($pararam != 'create_report_to'){
                            $strWhere[] = ''.$pararam.' = '.$value.'';
                        }
                        
                        
                    }
                    
                }
            }
            
            if(count($children_arr_a) == 1){
            $strWhere[] = 'ticketreport.sys_user = '.$ses_user[0]['id'].'';
            }
            
            if(!empty($strWhere)){
                $SQL="SELECT 
                ticket.maska,
                ticket.ticket_id,
                ticket.route_city_from_id,
                ticket.route_city_to_id,
                ticket.route_name_id,
                ticket.route_price_discount,
                ticket.route_date,
                ticket.return_price,
                ticket.discount_id,
                ticket.user_id,
                ticket.ferryman_id,
                ticketreport.status,
                ticketreport.create_report,
                ticketreport.sys_user,
                ticket_valute.valute,
                ticket_people.name,
                ticket_people.soname,
                ticket.client_id
                 FROM `ticket` 
                LEFT JOIN `ticketreport` ON ticket.ticket_id = ticketreport.ticket_id
                LEFT JOIN `ticket_valute` ON ticket.ticket_id = ticket_valute.tiket_id
                LEFT JOIN `ticket_people` ON ticket.client_id = ticket_people.id
                  WHERE ".join(' AND ',$strWhere)." ORDER BY ticketreport.create_report ASC limit $limit";
                //echo $SQL;
                //die;
            }else{
                $SQL="SELECT 
                ticket.maska,
                ticket.ticket_id,
                ticket.route_city_from_id,
                ticket.route_city_to_id,
                ticket.route_name_id,
                ticket.route_price_discount,
                ticket.return_price,
                ticket.discount_id,
                ticket.user_id,
                ticket.ferryman_id,
                ticketreport.status,
                ticketreport.create_report,
                ticketreport.sys_user,
                ticket_valute.valute,
                ticket_people.name,
                ticket_people.soname,
                ticket.client_id
                 FROM `ticket` 
                LEFT JOIN `ticketreport` ON ticket.ticket_id = ticketreport.ticket_id
                LEFT JOIN `ticket_valute` ON ticket.ticket_id = ticket_valute.tiket_id
                LEFT JOIN `ticket_people` ON ticket.client_id = ticket_people.id
                WHERE ticketreport.sys_user = ".$ses_user[0]['id']."
                ORDER BY ticketreport.create_report ASC
                 limit $limit";
            }
            

            //$SQL="SELECT * FROM `` ".$strWhere." ";
            //mysql_query($sql); 
            $all = DB::query(Database::SELECT, $SQL)->execute()->as_array();
            
            //echo '<pre>';
            //print_r($children_arr_a);
            //echo '</pre>';
            //die;
            //$tes = '';
            
            if(count($children_arr_a) == 1){ // нет детей
                $new = array();
                foreach($all as $al){
                    if($al['sys_user'] == $ses_user[0]['id']){
                        $new[] = $al;
                    }
                }
            }else { // родитель группы
                $new = array();
                foreach($all as $al){
                        foreach($children_arr_a as $one_child){
                            if($al['sys_user'] == $one_child){
                            $new[] = $al;
                        }
                    }
                }
            }
            
            
            
            
        
        
        $new_new = Model::factory('TiketMod')->order_array_all($new,'create_report','SORT_DESC');   
         
        //echo '<pre>';
        //print_r($new_new);
        //echo '</pre>';
        //die;
            $data['tikets'] = $new_new;
            //print_r($data['all_stud']);        
        }
        
        $new_r = array();
        $data['lang'] = $lang;
        if($ses_user['group_id'] == 1){
            $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
            $new_r = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->order_by('routename.route_name_id','DESC')->execute()->as_array();
            
        }else{
            $data['sysusers'] = DB::select()->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            $all_user = DB::select()->from('system_users_routes')->join('routename')->on('system_users_routes.route_name_id','=','routename.route_name_id')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            foreach($all_user as $r){
                $al_rpior = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$ses_user[0]['id'])->and_where('route','=',$r['route_name_id'])->execute()->current();
                if(!empty($al_rpior)){
                    $new_r[] = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$r['route_name_id'])
                        ->order_by('routename.route_name_id','DESC')->execute()->current();
                }
            }
        
        }

        $data['routes'] = $new_r;
        $this->template->content_admin = View::factory('tiket/index',$data);
	}
    
    public function action_sell() {  
        $this->chek_permition(); 
        $this->anule_reserv();
        //$this->ajax_date();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $data = array();
        $data['lang'] = $lang;
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();
        $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
        $ses_user = $this->ses_user;
        if($ses_user['group_id'] == 1){
            $data['routes'] = DB::select()->from('routename')
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
        }else {
            //$data['routes'] = DB::select()->from('system_users_routes')->join('routename')->on('system_users_routes.route_name_id','=','routename.route_name_id')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            //$all_rou = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            //$new_r = array();
            /*
            foreach($all_rou as $r){
                $al_rpior = DB::select()->from('route_reverse')->where('main_id','=',$r['route_name_id'])->or_where('reverse_id','=',$r['route_name_id'])->execute()->current();
                if(!empty($al_rpior)){
                    $al_rpior = DB::select()->from('system_users_priorety')->where('route','=',$r['route_name_id'])->or_where('slave_route','=',$r['route_name_id'])->execute()->current();
                    if($al_rpior['route'] == $r['route_name_id']){
                        $new_r[] = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$r['route_name_id'])
                        ->order_by('routename.route_name_id','DESC')->execute()->current();
                    }else{
                        $new_r[] = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$al_rpior['slave_route'])
                        ->order_by('routename.route_name_id','DESC')->execute()->current();
                    }
                    
                }
            }
            */
            $new_r = array();
            $all_user = DB::select()->from('system_users_routes')->join('routename')->on('system_users_routes.route_name_id','=','routename.route_name_id')->where('sysuser_id','=',$ses_user[0]['id'])->order_by('routename.weight','ASC')->execute()->as_array();
            foreach($all_user as $r){
                $al_rpior = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$ses_user[0]['id'])->and_where('route','=',$r['route_name_id'])->execute()->current();
                if(!empty($al_rpior)){
                   $route = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$r['route_name_id'])
                        ->execute()->current();
                   $route['weight'] = $al_rpior['weight'];
                        $new_r[] = $route;
                        
                        
                        
                }
            }
            $new_r_rverse = array();
            foreach($new_r as $n_r){
                $al_rpior_rr = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$ses_user[0]['id'])->and_where('route','=',$n_r['route_name_id'])->execute()->current();
                $new_r_rverse[] = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$al_rpior_rr['slave_route'])
                        ->execute()->current();
            }
             
            //echo '<pre>';
            //print_r($new_r);
            //echo '</pre>';
            //die;
            //echo count($new_r).'<br />';
            /*
            $n_r_rev = array();
            foreach($new_r as $ne){
                if(!empty($ne['reverse_id'])){
                    $n_r_rev[] = $ne;
                }
                
            }
            $nene = array();
            foreach($new_r as $nn=>$val){
                foreach($n_r_rev as $rev){
                    if($rev['reverse_id'] != $val['route_name_id']){
                        $nene[$nn] = $val;
                    }
                    
                }
                
            }
            
            $ne_prior = array();
            foreach($new_r as $al_r){
                $al_rpior = DB::select()->from('system_users_priorety')->where('route','=',$al_r['route_name_id'])->or_where('slave_route','=',$al_r['route_name_id'])->execute()->current();
                if(!empty($al_rpior)){
                    if($al_rpior['route'] != $al_r['route_name_id']){
                        $al_r = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        ->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$al_rpior['route'])
                        ->order_by('routename.route_name_id','DESC')->execute()->current();
                    }
                    $ne_prior[] = $al_r;
                }else{
                    $ne_prior[] = $al_r;
                }
            }
            */
            //echo count($nene);
            //print_r($n_r);
            //die;
            if(empty($new_r_rverse)){
                $this->redirect('/errors/info_reverse');
            }
            
            
            $all_route_sort = Model::factory('TiketMod')->order_array_all($new_r,'weight','SORT_ASC');
            
            //echo '<pre>';
            //print_r($all_route_sort);
            //echo '</pre>';
            
            //echo '<pre>';
            //print_r($new_r);
            //echo '</pre>';
            
            //die;
            
            $new_r = $all_route_sort;
            
            $data['routes'] = $new_r;
            $data['routes_reverse'] = $new_r_rverse;
            /*
            
            
            echo '<pre>';
            print_r($new_r_rverse);
            echo '</pre>';
            */
            //die;

        }
        
        $this->template->content_admin = View::factory('tiket/sell',$data);
	}
    
    public function action_sell_light() {  
        
        $this->template = View::factory('template_ticket_sell_light');
        
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $data = array();
        $data['lang'] = $lang;
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();
        $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
        $ses_user = $this->ses_user;
        if($ses_user['group_id'] == 1){
            $data['routes'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            //->and_where('is_public','=',1)
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
        }else {
            $data['routes'] = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        }
        
        
        
        $this->template->top_head_admin = View::factory('top_head_disp');
        $this->template->header_admin = View::factory('header_disp');
        $this->template->content_admin = View::factory('tiket/sell_light',$data);
        $this->template->left_sidebar_admin = '';
        $this->template->chat = '';
        $this->template->footer = '';
        
        /////
        
	}
    
    public function action_ajax_get_route_ost(){
        if($_POST){
            $ses_user = $this->ses_user;
            
            $route = DB::select('route_city_id')->from('route')
            //->join('routecity_i18n')->on('Route.route_city_id','=','routecity_i18n.route_city_id')
            ->where('route_name_id','=',$_POST['route_name_id'])
            ->order_by('weight')
            //->and_where('culture','=',$_POST['lang'])
            ->execute()->as_array();
            
            $prior_city = DB::select()->from('system_users_priorety')->where('route','=',$_POST['route_name_id'])->and_where('sysuser_id','=',$ses_user[0]['id'])->execute()->current();
            
            $new_ar = array();
            foreach($route as $r){
                
                $ost_name = DB::select('route_city_id','name_i18n','city_i18n')->from('routecity_i18n')->where('route_city_id','=',$r['route_city_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                //$new_ar[] = $ost_name;
                if($prior_city['main_city_id'] == $ost_name['route_city_id']){
                    echo "<option selected='selected' value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>"; 
                }else{
                    echo "<option value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>"; 
                }
                 
                              
            }
            
            //print_r($new_ar);
            die;
        }
    }
    
    public function action_ajax_get_route_ost_last(){
        if($_POST){

            $ses_user = $this->ses_user;
            $prior_city = DB::select()->from('system_users_priorety')->where('route','=',$_POST['route_name_id'])->and_where('sysuser_id','=',$ses_user[0]['id'])->execute()->current();
            $prior_weight = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$prior_city['main_city_id'])->execute()->current();
            //print_r($prior_weight);
            //die;
            $route = DB::select('route_city_id')->from('route')
            ->where('route_name_id','=',$_POST['route_name_id'])
            ->and_where('weight','>',$prior_weight['weight'])
            ->order_by('weight')
            ->execute()->as_array();
            
            $new_ar = array();
            foreach($route as $r){
                
                $ost_name = DB::select('route_city_id','name_i18n','city_i18n')->from('routecity_i18n')->where('route_city_id','=',$r['route_city_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                //$new_ar[] = $ost_name; 
                echo "<option value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>";               
            }
            
            //print_r($new_ar);
            die;
        }
    }
    
    public function action_ajax_get_route_ost_weight(){
        if($_POST){
            
            $weight = DB::select('weight')->from('route')
            //->join('routecity_i18n')->on('Route.route_city_id','=','routecity_i18n.route_city_id')
            ->where('route_name_id','=',$_POST['route_name_id'])
            ->and_where('route_city_id','=',$_POST['ost'])
            ->execute()->current();
            //print_r($weight);
            //die;
            $route = DB::select('route_city_id')->from('route')
            //->join('routecity_i18n')->on('Route.route_city_id','=','routecity_i18n.route_city_id')
            ->where('route_name_id','=',$_POST['route_name_id'])
            ->and_where('weight','>',$weight['weight'])
            ->order_by('weight')
            ->execute()->as_array();
            $new_ar = array();
            foreach($route as $r){
                $ost_name = DB::select('route_city_id','name_i18n','city_i18n')->from('routecity_i18n')->where('route_city_id','=',$r['route_city_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                //$new_ar[] = $ost_name; 
                echo "<option value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>";               
            }
            
            //print_r($new_ar);
            die;
        }
    }
    
    public function action_ajax_fer_dates_all(){
        if($_POST){
            $date = date("Y-m-d"); //BETWEEN "2008.11.01"  AND  "2009.10.12"
            $next_date = strtotime ( '+2 month' , strtotime ( $date ) ) ;
            $n_d = date('Y-m-d',$next_date);
            $all_days = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','BETWEEN',array($date,$n_d))->and_where('rice','=',1)->execute()->as_array();
            //print_r($all_days);
            //die;
            foreach($all_days as $d){
                if($_POST['day'] == $d['date']){
                echo $d['date'];
                die;
                }
            }
        }
    }
    
    function ajax_date(){
        
            $date = date("Y-m-d"); //BETWEEN "2008.11.01"  AND  "2009.10.12"
            $next_date = strtotime ( '+3 month' , strtotime ( $date ) ) ;
            $n_d = date('Y-m-d',$next_date);
            //$all = DB::select()->from('RouteFerrymanWeek')->execute()->as_array();
            $all_curr = DB::select()->from('routeferrymanweek')->where('date','BETWEEN',array($date,$n_d))->execute()->as_array();
            $all_days_new = DB::select()->from('routeferrymanweek')->where('date','<',$date)->execute()->as_array();
            $all_days_big = DB::select()->from('routeferrymanweek')->where('date','>',$n_d)->execute()->as_array();
            DB::delete('routeferrymanweek')->where('date','<',$date)->execute();
            DB::delete('routeferrymanweek')->where('date','>',$n_d)->execute();
            //echo "bigg - : " . count($all_days_big)."<br />";
            //echo "dell - : " . count($all_days_new)."<br />";
            //echo "stay - : " . count($all_curr);
            //print_r($all_days);
            //die; 
    }
    
    public function action_ajax_cron_type(){
        if($_POST){
            $all_types = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            //foreach($all_types as $type){
                
            //}
            echo $all_types['type'];
            die;
        }  
    }
    
    public function action_ajax_sell_tikets(){
        if($_POST){
            
           
            
            $data = array();           
            $date = array_reverse(explode('/', $_POST['route_date']));
            $route_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            
            
            if(!empty($_POST['route_date_end'])){
                $date_end = array_reverse(explode('/', $_POST['route_date_end']));
                $route_date_end = date('Y-m-d', mktime(0, 0, 0, $date_end[1], $date_end[2], $date_end[0]));
            }else{
                $route_date_end = '';
            }
            
            $route_date_newday = $_POST['route_date_newday'];
            $new_inputs = $_POST['inputs'];
            $week_id = date( "w", strtotime($route_date.' 00:00:01'));
            
             
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            //d///*
            
           
            
            switch($week_id){
                    case 0:
                    $week_id = 6;
                    break;
                    case 1:
                    $week_id = 0;
                    break;
                    case 2:
                    $week_id = 1;
                    break;
                    case 3:
                    $week_id = 2;
                    break;
                    case 4:
                    $week_id = 3;
                    break;
                    case 5:
                    $week_id = 4;
                    break;
                    case 6:
                    $week_id = 5;
                    break;
                }      
            
            
            
            
            
            $rou_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
            $rou_from = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$rou_from['r_id'])->and_where('week_id','=',$week_id)->and_where('rice','=',$_POST['rice'])->execute()->current();
            $rou_to = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['to'])->execute()->current();
            $rou_to = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$rou_to['r_id'])->and_where('week_id','=',$week_id)->and_where('rice','=',$_POST['rice'])->execute()->current();
            
            
            
            $tik_ids = '';
            
            
            
            
            //*/
            
           
             /*
           echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die;
            */
            
            
            for($i=0;$i<count($_POST['plases']);$i++){
                
                
                
                
                
                $cleent_id = 0;
                //$chek_peo = DB::select()->from('ticket_people')->where('soname','=',$new_inputs[$i][0])->and_where('name','=',$new_inputs[$i][1])->execute()->current();
                
               
                ///*
                //if(empty($chek_peo)){
                    $cl_id = DB::insert('ticket_people',array(
                    //'tiket_id',
                    'soname',
                    'name',
                    'date',
                    'tel',
                    //'tel2',
                    'count_trip'
                    ))->values(array(
                    //$tik_id[0],
                    $new_inputs[$i][0],
                    $new_inputs[$i][1],
                    $new_inputs[$i][2],
                    $new_inputs[$i][3],
                    //$new_inputs[$i][5],
                    1
                    ))->execute();
                    
                    $cleent_id = $cl_id[0];
                //}else{
               //     $cleent_id = $chek_peo['id'];
               //     DB::update('ticket_people')->set(array(
               //     'count_trip'=>$chek_peo['count_trip']+1,
               //     ))->where('id','=',$cleent_id)->execute();
               // }
                
                
                // echo '<pre>';
                //print_r($_POST);
                //echo '</pre>';
                //die; 
                
                 
                
                $price_array = Model::factory('TiketMod')->chek_price_model($_POST['route_name_id'],$_POST['from'],$_POST['to'],$_POST['valute'],$_POST['ferryman_id']);
                
                $price = $price_array[0];
                $valute = $price_array[1];
                
                
                $maska = 0;
                        
                       
                      
                        
                $sys_user_info = DB::select()->from('system_users')->where('id','=',$_POST['sesuser'])->execute()->current();
                $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$sys_user_info['parent_sysuser'])->execute()->as_array();
                if(!empty($children_arr)){
                    foreach($children_arr as $ch){
                        $children_arr_a[] = $ch['id'];
                    }
                }
                array_push($children_arr_a,$_POST['sesuser']);
                
                $all_ticks_parents = DB::select('ticket_id','maska')->from('ticket')->where('user_id','in',$children_arr_a)->order_by('maska','DESC')->limit(1)->execute()->current();
                
                $maska = $all_ticks_parents['maska'] + 1;
                
              
                
               
                //die;
                $tik_id = DB::insert('ticket',array(
                    'maska',
                    'route_name_id',
                    'client_id',
                    'ticket_type_id',
                    'buses_id',
                    'value',
                    'ferryman_id',
                    'user_id',
                    'date',
                    'price',
                    'route_city_from_id',
                    'route_city_to_id',
                    'route_date',
                    'route_date_end',
                    'route_time',
                    'route_timeto',
                    'route_price',
                    'route_price_discount',
                    'discount_id',
                    'date_sale',
                    'inet',
                    'vedomost'
                ))->values(array(
                    $maska,
                    $_POST['route_name_id'],
                    $cleent_id,
                    $_POST['du'],
                    $_POST['buses_id'],
                    trim($_POST['plases'][$i]),
                    $_POST['ferryman_id'],
                    $_POST['sesuser'],
                    date('Y-m-d H:i:s'),
                    round($price,2),
                    $_POST['from'],
                    $_POST['to'],
                    $route_date_newday,
                    $route_date_end,
                    $rou_from['time'],
                    $rou_to['a_time'],
                    $_POST['price'][$i],
                    $_POST['price'][$i],
                    $_POST['discount'][$i],
                    date('Y-m-d H:i:s'),
                    0,
                    $_POST['vedomost']
                ))->execute();                
                
                
                DB::insert('ticket_valute',array(
                    'tiket_id',
                    'valute',
                ))->values(array(
                    $tik_id[0],
                    $_POST['valute'],
                ))->execute();
                
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $tik_id[0],
                    $_POST['du'],
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();

                //echo $tik_id[0];
                $tik_ids .= $tik_id[0].',';
                
                //echo 'do soap';
                //echo '<pre>';
                //print_r($new_inputs);
                //echo '</pre>';
                //die;
                /////////////// nikolo tikets
                ///*
                /*
                $nikol_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$_POST['route_name_id'])->execute()->current();
                $nikolo_from_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$_POST['from'])->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                $nikolo_to_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$_POST['to'])->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                
                $route = new stdClass();
                $route->route_id = $nikol_route['reg_route_id'];
                $route->from_id = $nikolo_from_ost['reg_ost_id'];
                $route->to_id = $nikolo_to_ost['reg_ost_id'];
                $route->date = $route_date;
                $regabus = new Regabus();
                $all = $regabus->get_route($route);
                
                
                //print_r($all);
                
                //echo '<pre>';
                //print_r($all);
                //echo '</pre>';
                //die;
                
                
                //////////// продажа
                $sale = new stdClass();
                $sale->route_id = $nikol_route['reg_route_id'];
                $sale->date = $route_date;
                $sale->time = $all[0]->time_from;
                $sale->from_id = $nikolo_from_ost['reg_ost_id'];
                $sale->to_id = $nikolo_to_ost['reg_ost_id'];
                $sale->ferryman_id = $all[0]->ferryman_id;
                $sale->buses_id = $all[0]->buses_id;
                $sale->rice = $all[0]->rice;
                $sale->seat = trim($_POST['plases'][$i]);
                $sale->discount_id = 0;
                
                $client = new stdClass();

                $client->name = $new_inputs[$i][0];
                $client->surname = $new_inputs[$i][1];
                $client->tel = $new_inputs[$i][3];
                $client->birth_date= $new_inputs[$i][2];
                
                $ticket_id = $regabus->sell_regabus($sale, $client);
                $ticket_id = $regabus->sell($sale, $client);
                 
               ////////////////////////////// 
                
                
               */ 
                
            }
            echo $tik_ids;
            die;
        }  
    }
    
    public function action_ajax_sell_tikets_test(){
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            
            $data = array();           
            $date = array_reverse(explode('/', $_POST['route_date']));
            $route_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            $new_inputs = array_chunk($_POST['inputs'], 6);
            $week_id = date( "w", strtotime($route_date.' 00:00:01'));
            $rou_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
            $rou_from = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$rou_from['r_id'])->and_where('week_id','=',$week_id)->execute()->current();
            $rou_to = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['to'])->execute()->current();
            $rou_to = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$rou_to['r_id'])->and_where('week_id','=',$week_id)->execute()->current();
            
            $tik_id = '';
            
            for($i=0;$i<count($new_inputs);$i++){
                
                $cleent_id = 0;
                $chek_peo = DB::select()->from('ticket_people')->where('soname','=',$new_inputs[$i][0])->and_where('name','=',$new_inputs[$i][1])->execute()->current();
                
                $tik_id = $_POST['bil_id'];
                //$data['lang'] = $_POST['lang'];
                
                //if($this->chekfile($_POST['ferryman_id']) === true){
                //    echo View::factory('/tiket/ticket_ferryman/'.$_POST['ferryman_id'],$data);
                //}else{
                //    echo View::factory('/tiket/print_ticket',$data);
                //}
                
                //echo $data['id'];
                
            }
            
            echo $tik_id;
            
            
            die;
        }  
    }
    
    function chekfile($file){
        $filename = 'application/views/tiket/ticket_ferryman/'.$file.'.php';
        if (file_exists($filename)) {
            return true;
        } else {
            return false;
        }
    }
    
      public function action_ajax_sell_tikets_open(){
        if($_POST){
            
            
            
            $ses_user = $this->ses_user;
            
            
            
            $data = array();
                        
            //$date = array_reverse(explode('/', $_POST['route_date']));
            //$route_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            $new_inputs = $_POST['inputs'];
            
            //$week_id = date( "w", strtotime($route_date.' 00:00:01'));
            //die;
            //$rou_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
            //$rou_from = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$rou_from['r_id'])->and_where('week_id','=',$week_id)->execute()->current();
            
            //$rou_to = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['to'])->execute()->current();
            
            $buses_fer = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
           
            $tiks = '';
           
            for($i=0;$i<count($new_inputs);$i++){
                
            
                
                $cleent_id = 0;
                $chek_peo = DB::select()->from('ticket_people')->where('soname','=',$new_inputs[$i][0])->and_where('name','=',$new_inputs[$i][1])->execute()->current();

                if(empty($chek_peo)){
                    $cl_id = DB::insert('ticket_people',array(
                    'soname',
                    'name',
                    'date',
                    'tel',
                    //'tel2',
                    'count_trip'
                    ))->values(array(
                    $new_inputs[$i][0],
                    $new_inputs[$i][1],
                    $new_inputs[$i][2],
                    $new_inputs[$i][3],
                    //$new_inputs[$i][4],
                    1
                    ))->execute();
                    $cleent_id = $cl_id[0];
                }else{
                    $cleent_id = $chek_peo['id'];
                    
                    DB::update('ticket_people')->set(array(
                    'count_trip'=>$chek_peo['count_trip']+1,
                    ))->where('id','=',$cleent_id)->execute();
                }
                
                
                $full_price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->and_where('valute','=',$_POST['valute'])->execute()->current();
                
                if(empty($full_price)){
                    $full_price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
                }
     
                $valute = $full_price['valute'];    
                $price_full = $full_price['price'];
                
                 if(!empty($price_full)){ 
                        if($valute == 'ua'){
                            $valute = 'UAH';
                        }
                        if($valute == 'cs'){
                            $valute = 'CZK';
                        }
                        $new_price = Googlecon::con($valute,$_POST['valute'],$price_full);
                        $valute = $new_price[1];
                        $price_full = $new_price[0];
                    }
                
              
                $maska = 0;
                        
                        
                $sys_user_info = DB::select()->from('system_users')->where('id','=',$ses_user[0]['id'])->execute()->current();
                $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$sys_user_info['parent_sysuser'])->execute()->as_array();
                if(!empty($children_arr)){
                    foreach($children_arr as $ch){
                        $children_arr_a[] = $ch['id'];
                    }
                }
                array_push($children_arr_a,$ses_user[0]['id']);
                
                $all_ticks_parents = DB::select('ticket_id','maska')->from('ticket')->where('user_id','in',$children_arr_a)->order_by('maska','DESC')->limit(1)->execute()->current();
                
                $maska = $all_ticks_parents['maska'] + 1;
              
              
                
                $tik_id = DB::insert('ticket',array(
                    'maska',
                    'route_name_id',
                    'client_id',
                    'ticket_type_id',
                    'user_id',
                    'date',
                    'price',
                    'route_city_from_id',
                    'route_city_to_id',
                    'route_price',
                    'route_price_discount',
                    'discount_id',
                    'date_sale',
                    'inet'
                ))->values(array(
                    $maska,
                    $_POST['route_name_id'],
                    $cleent_id,
                    5,
                    $ses_user[0]['id'],
                    date('Y-m-d H:i:s'),
                    round($price_full,2),
                    $_POST['from'],
                    $_POST['to'],
                    $_POST['price'][$i],
                    $_POST['price'][$i],
                    $_POST['discount'][$i],
                    date('Y-m-d H:i:s'),
                    0
                ))->execute();
                
            //     echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
                
                DB::insert('ticket_valute',array(
                    'tiket_id',
                    'valute',
                ))->values(array(
                    $tik_id[0],
                    $_POST['valute'],
                ))->execute();
                
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $tik_id[0],
                    5,
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();
                
                
           //        echo '<pre>';
           //print_r($_POST);
           //echo '</pre>';
           //die;
                
                
                //$data['id'] = $tik_id[0];
                //$data['lang'] = $_POST['lang'];
                //echo View::factory('/tiket/print_ticket_open',$data);
                $tiks .= $tik_id[0].',';
                
                
            }
            echo $tiks;
            die;
        }  
    }
    
     public function action_ajax_tiket_null(){
        if($_POST){
                //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
                DB::update('ticket')->set(array(
                'ticket_type_id'=>3,
                'user_id'=>$_POST['sesuser'],
                'return_price'=>$_POST['return_price'],    
                ))->where('ticket_id','=',$_POST['tiket_id'])->execute();
                
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $_POST['tiket_id'],
                    3,
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();
                
                
         
            $reg_tic = DB::select()->from('regabus_join_ticks')->where('svitgo_tik','=',$_POST['tiket_id'])->execute()->current();
            if(!empty($reg_tic['rega_tik'])){
                $soap = new SoapClient("http://onlineregabus.cz/soap.wsdl"); 
                $status = $soap->soap_login('svitgo', 12345678); 
                //$route = new stdClass();
                $soap->soap_annule(trim($reg_tic['rega_tik']));  
            }
            //foreach($all_types as $type){
                
            //}
            //echo $all_types['type'];
            die;
        }  
    }
    
    public function action_ajax_blocket_null(){
        if($_POST){
                //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
                DB::delete('routeblockedbuses')->where('route_blocked_buses','=',$_POST['id'])->execute();

            //$all_types = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            //foreach($all_types as $type){
                
            //}
            //echo $all_types['type'];
            die;
        }  
    }
    
    
    public function action_ajax_blocket_get_name(){
        if($_POST){
            $res = DB::select()->from('routeblocked')
            ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
            ->where('routeblocked.route_name_id','=',$_POST['route_name_id'])
            ->and_where('route_city_id','=',$_POST['from'])
            ->and_where('route_city_to_id','=',$_POST['to'])
            ->and_where('value','=',$_POST['plase'])
            ->execute()->current();
            //print_r($_POST);
            echo $res['name'];
                //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
                //DB::delete('routeblockedbuses')->where('route_blocked_buses','=',$_POST['id'])->execute();

            //$all_types = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            //foreach($all_types as $type){
                
            //}
            //echo $all_types['type'];
            die;
        }  
    }
    
    
    
     public function action_ajax_tiket_transfer(){
        if($_POST){
            
                //echo '<pre>';
                //print_r($_POST);
                //echo '</pre>';
                //die;
            
               $date = array_reverse(explode('/', $_POST['date']));
               $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
               
               DB::update('ticket')->set(array(
                    'value'=>$_POST['plase'],
                    'route_date'=>$tran_date,
                    'route_price'=>$_POST['price'],
                    'route_price_discount'=>$_POST['price'],
                    'date'=>date('Y-m-d H:i:s'),
                    'ferryman_id'=>$_POST['fer'],
                    'buses_id'=>$_POST['bus']
               ))->where('ticket_id','=',$_POST['tik_id'])->execute();
               
               //$chek = DB::select()->from('ticketreport')->where('ticket_id','=',$_POST['tik_id'])->and_where('status','=',4)->execute()->current();
               //if(empty($chek)){    
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $_POST['tik_id'],
                    4,
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();
               //}
                
               //print_r($rep); 
                //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
            //$all_types = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            //foreach($all_types as $type){
                
            //}
            //echo $all_types['type'];
            die;
        }  
    }
    
    public function action_ajax_chenge_open(){
        if($_POST){
               
               //print_r($_POST);
               //die;
               
               $date = array_reverse(explode('/', $_POST['date']));
               $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
               
               
               $tik_id = DB::select()->from('ticket')->where('ticket_id','=',$_POST['tik_id'])->execute()->current();
               
               //die
               
               
               $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$tik_id['route_name_id'])->and_where('date','=',$tran_date)->execute()->current();
               
              
               
               DB::update('ticket')->set(array(
                    'ticket_type_id'=>1,
                    'value'=>$_POST['plase'],
                    'ferryman_id'=>$main_info['ferryman_id'],
                    'buses_id'=>$main_info['buses_id'],
                    'route_date'=>$tran_date,
                    'date'=>date('Y-m-d H:i:s')
               ))->where('ticket_id','=',$_POST['tik_id'])->execute();
               
               //$chek = DB::select()->from('ticketreport')->where('ticket_id','=',$_POST['tik_id'])->and_where('status','=',4)->execute()->current();
               //if(empty($chek)){    
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $_POST['tik_id'],
                    1,
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();
               //}
                
               //print_r($rep); 
                //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
            //$all_types = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            //foreach($all_types as $type){
                
            //}
            //echo $all_types['type'];
            die;
        }  
    }
    
    
    public function action_ajax_clear_bus(){
        if($_POST){
            $data = array();
            $data['info'] = $_POST;
            echo View::factory('bus/svitgo_schema_clear',$data);
            die;
        }
    }
    
    
    public function action_ajax_discount_block(){
        if($_POST){
            $data = array();
            echo View::factory('tiket/discount_block',$data);
            die;
        }  
    }
    
    public function action_ajax_blocket_plases(){
        if($_POST){
            
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die;
            $date = array_reverse(explode('/', $_POST['date']));
            $date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            
            $block = DB::insert('routeblocked',array(
                    'route_name_id',
                    'name',
                    'created',
                    'user_uid'                    
                ))->values(array(
                    $_POST['route_name_id'],
                    $_POST['title'],
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser'],
                ))->execute();
            if($_POST['choise'] == 'day'){
                foreach($_POST['plases'] as $plase){
                    DB::insert('routeblockedbuses',array(
                        'route_blocked_id',
                        'buses_id',
                        'ferryman_id',
                        'value',
                        'route_city_id',
                        'route_city_to_id',
                        'block_date'
                    ))->values(array(
                        $block[0],
                        $_POST['buses_id'],
                        $_POST['ferryman_id'],
                        $plase,
                        $_POST['from'],
                        $_POST['to'],
                        $date
                    ))->execute();
                    }
            }else{
                $all_dates = DB::select('date')->distinct(true)->from('routeferrymanweek')
                    ->where('route_name_id','=',$_POST['route_name_id'])
                    ->and_where('ferryman_id','=',$_POST['ferryman_id'])
                    ->and_where('buses_id','=',$_POST['buses_id'])
                    ->and_where('date','>=',date('Y-m-d'))
                    ->execute()->as_array();
                foreach($all_dates as $dat){
                    foreach($_POST['plases'] as $plase){
                    DB::insert('routeblockedbuses',array(
                        'route_blocked_id',
                        'buses_id',
                        'ferryman_id',
                        'value',
                        'route_city_id',
                        'route_city_to_id',
                        'block_date'
                    ))->values(array(
                        $block[0],
                        $_POST['buses_id'],
                        $_POST['ferryman_id'],
                        $plase,
                        $_POST['from'],
                        $_POST['to'],
                        $dat
                    ))->execute();
                    }
                }
                echo '<pre>';
                print_r($all_dates);
                echo '</pre>';
                die;
            }
        }
    }
    
    public function action_ajax_newblocket_plases(){
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            
            if($_POST['day_week'] != 'day'){
             $date = ''; 
            }else{
            $date = array_reverse(explode('/', $_POST['date']));
            $date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            }
            $plases = implode(',',$_POST['plases']);
            
            
            
            $block = DB::insert('newblocket_plase',array(
                    'route_name_id',
                    'blocket_type',
                    'plases',
                    'date',
                    'ferryman',
                    'sesuser',
                    'buses',
                    'week_id'                    
                ))->values(array(
                    $_POST['route'],
                    $_POST['day_week'],
                    $plases,
                    $date,
                    $_POST['ferryman'],
                    $_POST['sesuser'],
                    $_POST['buses'],
                    $_POST['week_id']
                ))->execute();
                
             $block = DB::insert('newblocket_plase_history',array(
                    'route_name_id',
                    'plases',
                    'ferryman',
                    'sysuser_id',
                    'buses_id',
                    'ip',
                    'du'                    
                ))->values(array(
                    $_POST['route'],
                    $plases,
                    $_POST['ferryman'],
                    $_POST['sesuser'],
                    $_POST['buses'],
                    $_SERVER['REMOTE_ADDR'],
                    'create'
                ))->execute();   
                   
                echo 'ok';
                die;
        }
    }
    
    public function action_ajax_blocket_plases_clear(){
        if($_POST){
            $date = array_reverse(explode('/', $_POST['date']));
            $date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            if($_POST['choise'] == 'day'){
            foreach($_POST['plases'] as $plase){
                $res = DB::select()->from('routeblocked')
                ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
                ->where('routeblocked.route_name_id','=',$_POST['route_name_id'])
                ->and_where('route_city_id','=',$_POST['from'])
                ->and_where('route_city_to_id','=',$_POST['to'])
                ->and_where('value','=',$plase)
                ->and_where('block_date','=',$date)
                ->execute()->current();
                DB::delete('routeblockedbuses')->where('route_blocked_buses','=',$res['route_blocked_buses'])->execute();
            }
            }else{
                foreach($_POST['plases'] as $plase){
                $res = DB::select()->from('routeblocked')
                ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
                ->where('routeblocked.route_name_id','=',$_POST['route_name_id'])
                    ->and_where('route_city_id','=',$_POST['from'])
                    ->and_where('route_city_to_id','=',$_POST['to'])
                    ->and_where('block_date','>=',$date)
                    ->and_where('value','=',$plase)
                    ->execute()->as_array();
                foreach($res as $r){
                    DB::delete('routeblockedbuses')->where('route_blocked_buses','=',$r['route_blocked_buses'])->execute();
                }
                    
                    //print_r($res);
                    //die;
                }
            }
        }
    }
    
    public function action_vedomost() {  
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
         $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        } 
        $data = array();
        $search_date = date('d/m/Y');
        $search_date_to = date('d/m/Y');
        /*
        $tickets = array();
        
        
        $tickets = DB::select()->from('ticket')
            ->where(DB::expr('Date(date)'),'=',date('Y-m-d'))
            ->and_where('ticket_type_id','=',1)
            //->or_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array();
            
        $tickets_ = DB::select()->from('ticket')
            ->where(DB::expr('Date(date)'),'=',date('Y-m-d'))
            ->and_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array();
            
        $tickets__ = DB::select()->from('ticket')
            ->where(DB::expr('Date(date)'),'=',date('Y-m-d'))
            ->and_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array();
            
        foreach($tickets_ as $tik_){
            array_push($tickets,$tik_);
        }
        
        foreach($tickets__ as $tik__){
            array_push($tickets,$tik__);
        }
          */  
        //echo '<pre>';
        //print_r($tickets);
        //echo '</pre>';  
        if(empty($tik)){
            $ticketss =  array();
            $tickets = DB::select(array('date','route_date'),'route_name_id','buses_id','ferryman_id')->from('routeferrymanweek')->where('date','=',Date('Y-m-d'))->execute()->as_array(); 
            foreach($tickets as $tik_chek){
                $all_user = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
                foreach($all_user as $as){
                    if($as['route_name_id'] == $tik_chek['route_name_id']){
                        $ticketss[] = $tik_chek;
                    }
                }
                
            }
            //echo '<pre>';
            //print_r($tickets);
            //echo '</pre>';
            //die;
            $tickets = $ticketss;
            
            foreach($tickets as $t){
                $tik[$t['route_date'].$t['route_name_id']][] = $t;
            }
            
        }
        if(isset($_GET['date']) && !empty($_GET['date']) && ($_GET['date_to']) && !empty($_GET['date_to']) && empty($_GET['route_name_id'])){
            $search_date = $_GET['date'];
            $search_date_to = $_GET['date_to'];
           
            $date = array_reverse(explode('/', $search_date));
        $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
        
        $date_to = array_reverse(explode('/', $search_date_to));
        $tran_date_to = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0])); 
            
            /*
            if($pararam == 'route_name_id'){
                            $strWhere[] = 'ticket.route_name_id = '.$value.'';
                            $route_reverse = DB::select()->from('route_reverse')->where('main_id','=',$value)->or_where('reverse_id','=',$value)->execute()->current();
                            $reverse = $value;
                            if($route_reverse['reverse_id'] == $value){
                                $reverse = $route_reverse['main_id'];
                            }
                            //$strWhere[] = 'ticket.route_name_id = '.$reverse;//.' AND ticket.route_name_id = '.$value;
                        }    
                        */ 
                        
            //$data['routes_new'] = $new_r;
        
        
            $tickets = DB::select()->from('ticket')
            ->where('route_date','BETWEEN',array($tran_date,$tran_date_to))
            ->and_where('ticket_type_id','=',1)
            ->or_where('ticket_type_id','=',2)
            ->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array();            
                               
            
        }
        if(isset($_GET['date']) && !empty($_GET['date']) && ($_GET['date_to']) && !empty($_GET['date_to']) && !empty($_GET['route_name_id'])){
            
            $search_date = $_GET['date'];
            $search_date_to = $_GET['date_to'];
            
            $date = array_reverse(explode('/', $search_date));
            $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
        
            $date_to = array_reverse(explode('/', $search_date_to));
            $tran_date_to = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0]));
            //$data['routes_new'] = $new_r;
            $route_reverse = DB::select()->from('route_reverse')->where('main_id','=',$_GET['route_name_id'])->or_where('reverse_id','=',$_GET['route_name_id'])->execute()->current();
            $main_route = $route_reverse['main_id'];
            $reverse = $route_reverse['reverse_id'];
            //if($route_reverse['reverse_id'] == $_GET['route_name_id']){
            //    $reverse = $route_reverse['main_id'];
            //}
            
            $tickets = DB::select()->from('ticket')
            ->where('route_date','BETWEEN',array($tran_date,$tran_date_to))
            ->and_where('ticket_type_id','in',array(1,2))
            ->and_where('route_name_id','=',$main_route)
            //->or_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array(); 
            
            
            $tickets2 = DB::select()->from('ticket')
            ->where('route_date','BETWEEN',array($tran_date,$tran_date_to))
            ->and_where('ticket_type_id','in',array(1,2))
            ->and_where('route_name_id','=',$reverse)
            //->or_where('ticket_type_id','=',2)
            //->or_where('ticket_type_id','=',4)
            ->order_by('route_date','ASC')
            ->execute()->as_array(); 
            
       //     $tickets += $tickets2; 
            
         
        foreach($tickets2 as $tik2){
            array_push($tickets,$tik2);
        }    
        
        
        }
        $date = array_reverse(explode('/', $search_date));
        $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
        
        $date_to = array_reverse(explode('/', $search_date_to));
        $tran_date_to = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0]));
        
        $data['lang'] = $lang;
        
        
        
        $new_r = array();
            $all_user = DB::select()->from('system_users_routes')->join('routename')->on('system_users_routes.route_name_id','=','routename.route_name_id')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            foreach($all_user as $r){
                $al_rpior = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$ses_user[0]['id'])->and_where('route','=',$r['route_name_id'])->execute()->current();
                if(!empty($al_rpior)){
                    $new_r[] = DB::select()->from('routename')
                        ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                        ->and_where('culture','=',$lang)
                        //->and_where('is_public','=',1)
                        ->and_where('routename.route_name_id','=',$r['route_name_id'])
                        ->order_by('routename.route_name_id','DESC')->execute()->current();
                }
            }
        
        $data['routes_new'] = $new_r;
        
        
        
        $tik = array();
        foreach($tickets as $t){
            $tik[$t['route_date'].$t['route_name_id']][] = $t;
        }
        
        
        //$array_sort = Model::factory('TiketMod')->order_array_all($tik,$sort_by);        
        
        $data['routes'] = $tik;
        $this->template->content_admin = View::factory('tiket/vedomost',$data);
	}
    
    public function action_vedomost_route() {  
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $id = $_GET['id'];
        $route_date = $_GET['date'];
        $data = array();
        $data['lang'] = $lang;
        $rout = DB::select()->from('routeferrymanweek')
        ->where('route_name_id','=',$id)
        ->and_where('date','=',$route_date)
        ->execute()->current();
        $data['route'] = $rout;
        //print_r($data['tikets']);
        $this->template->content_admin = View::factory('tiket/vedomost_route',$data);
	}
    
    public function action_vedomost_route_2() {  
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $id = $_GET['id'];
        $route_date = $_GET['date'];
        $data = array();
        $data['lang'] = $lang;
        $rout = DB::select()->from('routeferrymanweek')
        ->where('route_name_id','=',$id)
        ->and_where('date','=',$route_date)
        ->execute()->current();
        $data['route'] = $rout;
        //print_r($data['tikets']);
        $this->template->content_admin = View::factory('tiket/vedomost_route_2',$data);
	}
    
    public function action_vedomost_route_3() {  
        $this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $id = $_GET['id'];
        $route_date = $_GET['date'];
        $data = array();
        $data['lang'] = $lang;
        $rout = DB::select()->from('routeferrymanweek')
        ->where('route_name_id','=',$id)
        ->and_where('date','=',$route_date)
        ->execute()->current();
        $data['route'] = $rout;
        //print_r($data['tikets']);
        $this->template->content_admin = View::factory('tiket/vedomost_route_3',$data);
	}
    
    public function action_create_ajax_csv() {   
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        
        if($_POST){
            $server = $_SERVER['DOCUMENT_ROOT'];
           
            //preg_match_all('!<p(.*?)>(.*?)</p>!si', $_POST['html'], $tabb);
            
            
            
            //$user_name = trim($tabb[2][0]);
            preg_match_all('!<tr class="need">(.*?)</tr>!si', $_POST['html'], $tr);
            //echo '<pre>';
            //print_r($tr);
            //echo '</pre>';
            //die;
            $str = '';
            
            $str .= $_POST['sys'].";\r\n";
            $str .= 'Seats;Client;Route;Ticket;Price;'."\r\n";
            foreach($tr[1] as $v){
                $new = array();
                preg_match_all('!<td(.*?)>(.*?)</td>!si', $v, $new);
                //print_r($new);
                //die;
                
                
                if(isset($new[2][5])){
                    $str .= $new[2][1].';'.$new[2][2].';'.$new[2][3].';'.$new[2][4].';'.$new[2][5].";\r\n";
                }else{
                    $str .= $new[2][0].';'.$new[2][1].";\r\n";
                }
                //$str .= $new[2][0].';'.$new[2][1].";\r\n";
                
            }
            ///*
            //print_r($str);
            //die;
            //$str_codirovka = iconv ('utf-8', 'windows-1251', $str);
            $str_codirovka = Model::factory('TiketMod')->mb_ucfirst($str);
            //die;
            file_put_contents($server.'/vedomost/csv_file.csv', $str_codirovka);
            //*/
            //
            //$this->template->content_admin = View::factory('tiket/vedomost_route_2',$data);
            die;
        }
        
	}
    
    
        public function action_ajax_get_cl_id(){
        if($_POST){
            echo "<script>
            $('.on_peo').click(function(){
                var Parr = $(this).parents('.one_people');
                Parr.find('.cl_id').val($(this).find('.p6').text());
                Parr.find('.soname').val($(this).find('.p1').text());
                Parr.find('.name').val($(this).find('.p2').text());
                if($(this).find('.p3').text() == '**********'){
                    Parr.find('.tel').attr('disabled',true);
                }
                Parr.find('.tel').val($(this).find('.p3').text());
                Parr.find('.date').val($(this).find('.p4').text());
                Parr.find('.tel2').val($(this).find('.p5').text());
                Parr.find('.ajax_people_id_block').html('');
                Parr.find('.edit_cleent').show();
                Parr.find('.edit_name').val($(this).find('.p2').text());
                Parr.find('.edit_soname').val($(this).find('.p1').text());
                Parr.find('.edit_phone').val($(this).find('.p3').text());
                Parr.find('.edit_phone2').val($(this).find('.p5').text());
                Parr.find('.edit_date').val($(this).find('.p4').text());
                Parr.find('.cleent_id').val($(this).find('.p6').text());
                Parr.find('.date').focus();
                Parr.find('.tel').attr('disabled',true);
                Parr.find('.cl_id').attr('disabled',true);
                Parr.find('.soname').attr('disabled',true);
                Parr.find('.name').attr('disabled',true);
                Parr.find('.date').attr('disabled',true);
                var peodis = $(this).find('.p7');
                var peodis_name = $(this).find('.p8').text();
                if(peodis.text().length != 0){
                    Parr.find('.discount_hid').find('option').each(function(){
                        if($(this).val() == peodis.text()){
                            $(this).attr('selected','selected');
                            //alert($(this).val());
                            Parr.find('.discount_hid').select();
                            Parr.find('.info_discounts').text(Parr.find('.discount_hid option:selected').text());
                            Parr.find('.info_discounts_5_10').text(peodis_name);
                            Parr.find('.dis_5_of_10').show();
                            
                        }
                    })
                }
                Parr.find('.date').blur();
                
                
            })

            $('body').click(function(e) {
                //$('.popup').css('display','none');
                $('.ajax_people_block').html('');
            });
            </script>"; 
            $ses_user = $this->ses_user;
            if(strlen($_POST['id']) >= 1){
            $people = DB::select()->from('ticket_people')->where('id','like',"%".$_POST['id']."%")->execute()->as_array();
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            /*
            if(!empty($people)){
                echo '<ul>';
                foreach($people as $p){
                    echo '<li class="on_peo"><span class="p1">'.$p['tel'].'</span> <span class="p2">'.$p['name'].'</span> <span class="p3">'.$p['soname'].'</span> <span class="p4">'.$p['date'].'</span> <span class="p5">'.$p['tel2'].'</span></li>';
                }
                echo '</ul>';
            }
            */
            //die;
                if(!empty($people)){
                    //$new_peo = array();
                    //foreach($people as $p){
                    //    $new_peo[$p['soname'].$p['name']] = $p;
                    //}
                    
                    
                    ///*
                    
                    //*/
                    echo '<ul>';
                    foreach($people as $pp){
                        $people_dis = '';
                        $people_dis_name = '';
                        if($pp['count_trip'] == 4 || $pp['count_trip'] == 9){
                            if($pp['count_trip'] == 4){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('5_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                            if($pp['count_trip'] == 9){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('10_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                        }
                        $chek_client_sesuser = Model::factory('TiketMod')->showphone_for_tel($pp['id'],$ses_user[0]['id']);
                        if($chek_client_sesuser != 1){
                            $pp['tel'] = '**********';
                        }
                        echo '<li class="on_peo"><span class="p6">'.$pp['id'].'</span> <span class="p1">'.$pp['soname'].'</span> <span class="p2">'.$pp['name'].'</span> <span class="p3">'.$pp['tel'].'</span> <span class="p4">'.$pp['date'].'</span> <span class="p5">'.$pp['tel2'].'</span><span style="display:none;" class="p7">'.$people_dis.'</span><span style="display:none;" class="p8">'.$people_dis_name.'</span></li>';
                    }
                    echo '</ul>';
                }
                }
            die;
        }
    }
    
    public function action_ajax_get_people(){
        if($_POST){
            echo "<script>
            $('.on_peo').click(function(){
                var Parr = $(this).parents('.one_people');
                Parr.find('.cl_id').val($(this).find('.p6').text());
                Parr.find('.soname').val($(this).find('.p1').text());
                Parr.find('.name').val($(this).find('.p2').text());
                if($(this).find('.p3').text() == '**********'){
                    Parr.find('.tel').attr('disabled',true);
                }
                Parr.find('.tel').val($(this).find('.p3').text());
                Parr.find('.date').val($(this).find('.p4').text());
                Parr.find('.date').focus();
                Parr.find('.tel2').val($(this).find('.p5').text());
                Parr.find('.ajax_people_block').html('');
                Parr.find('.edit_cleent').show();
                Parr.find('.edit_name').val($(this).find('.p2').text());
                Parr.find('.edit_soname').val($(this).find('.p1').text());
                Parr.find('.edit_phone').val($(this).find('.p3').text());
                Parr.find('.edit_phone2').val($(this).find('.p5').text());
                Parr.find('.edit_date').val($(this).find('.p4').text());
                Parr.find('.cleent_id').val($(this).find('.p6').text());
                Parr.find('.tel').attr('disabled',true);
                Parr.find('.cl_id').attr('disabled',true);
                Parr.find('.soname').attr('disabled',true);
                Parr.find('.name').attr('disabled',true);
                Parr.find('.date').attr('disabled',true);
                var peodis = $(this).find('.p7');
                var peodis_name = $(this).find('.p8').text();
                Parr.find('.tel').focus();
                if(peodis.text().length != 0){
                    //var CurrDis = Parr.find('.discount_hid').val();
                    //alert(CurrDis);
                    ///alert($(this).find('.p9').text());
                    //if($(this).find('.p9').text() == 1 && CurrDis == 3){}else{ 
                        Parr.find('.discount_hid').find('option').each(function(){
                            if($(this).val() == peodis.text()){
                                $(this).attr('selected','selected');
                                //alert($(this).val());
                                Parr.find('.discount_hid').select();
                                Parr.find('.info_discounts').text(Parr.find('.discount_hid option:selected').text());
                                Parr.find('.info_discounts_5_10').text(peodis_name);
                                Parr.find('.info_discounts_5_10_val').val($(this).val());
                                Parr.find('.dis_5_of_10').show();
                                
                            }
                        })
                    //}
                }
                
                //setTimeout('alert(1)', 1000);

                Parr.find('.date').blur();
                //alert('blur');
                
            })
            $('body').click(function(e) {
                //$('.popup').css('display','none');
                $('.ajax_people_block').html('');
            });
            //$('.popup').click(function(e) {
            //    e.stopImmediatePropagation();
            //});
            function NagaliKlavishui(e) {
                var kodKlavishi;
                if (e) {
                    kodKlavishi = e.which;
                }
                else if (window.event) {
                    kodKlavishi = window.event.keyCode;
                }
                if(kodKlavishi == 9){
                    //alert(kodKlavishi);
                    $('.ajax_people_block').html('');
                }
            }
            document.onkeydown = NagaliKlavishui;
            </script>"; 
            $ses_user = $this->ses_user;
            if(strlen($_POST['tel']) >= 2){
                
            //$people = DB::select()->from('ticket_people')->where('soname','like',"%".$_POST['tel']."%")->limit(5)->execute()->as_array();
            
            $parent_sysuser = $ses_user[0]['parent_sysuser'];
            if($parent_sysuser == 1){
                $parent_sysuser = $ses_user[0]['id'];
            }
            
            $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$parent_sysuser)->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses_user[0]['id']);
            
            $people = DB::select()->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                ->where('user_id','in',$children_arr_a)
                ->and_where('soname','like',"%".$_POST['tel']."%")
            ->limit(5)->execute()->as_array();
            
            
            $new_people = array();
            foreach($people as $p){
                $new_people[$p['id']] = $p;
            }
            
            $people = $new_people;
            //echo '<pre>';
            //print_r($people);
            //echo '</pre>';
            //die;
            //$children_arr_a //нет детей
            
            //foreach($people)
            
            
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            /*
            if(!empty($people)){
                echo '<ul>';
                foreach($people as $p){
                    echo '<li class="on_peo"><span class="p1">'.$p['tel'].'</span> <span class="p2">'.$p['name'].'</span> <span class="p3">'.$p['soname'].'</span> <span class="p4">'.$p['date'].'</span> <span class="p5">'.$p['tel2'].'</span></li>';
                }
                echo '</ul>';
            }
            */
            //die;
                if(!empty($people)){
                    //$new_peo = array();
                    //foreach($people as $p){
                    //    $new_peo[$p['soname'].$p['name']] = $p;
                    //}
                    
                    
                    ///*
                    
                    //*/
                    echo '<ul>';
                    foreach($people as $pp){
                        $people_dis = '';
                        $people_dis_name = '';
                        if($pp['count_trip'] == 4 || $pp['count_trip'] == 9){
                            if($pp['count_trip'] == 4){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('5_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                            if($pp['count_trip'] == 9){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('10_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                        }
                        
                        //if($ses_user[0]['parent_sysuser'] == 1 && )
                        
                        $chek_client_sesuser = Model::factory('TiketMod')->showphone_for_tel($pp['id'],$ses_user[0]['id']);
                        if($chek_client_sesuser != 1){
                            $pp['tel'] = '**********';
                        }
                        echo '<li class="on_peo"><span class="p6">'.$pp['id'].'</span> <span class="p1">'.$pp['soname'].'</span> <span class="p2">'.$pp['name'].'</span> <span class="p3">'.$pp['tel'].'</span> <span class="p4">'.$pp['date'].'</span> <span class="p5">'.$pp['tel2'].'</span><span style="display:none;" class="p7">'.$people_dis.'</span><span style="display:none;" class="p8">'.$people_dis_name.'</span></li>';
                    }
                    echo '</ul>';
                }
            }
            die;
        }
    }
    
    public function action_ajax_get_people_no_ferryman(){
        if($_POST){
            echo "<script>
            $('.on_peo').click(function(){
                var Parr = $(this).parents('.one_people');
                Parr.find('.cl_id').val($(this).find('.p6').text());
                Parr.find('.soname').val($(this).find('.p1').text());
                Parr.find('.name').val($(this).find('.p2').text());
                if($(this).find('.p3').text() == '**********'){
                    Parr.find('.tel').attr('disabled',true);
                }
                Parr.find('.tel').val($(this).find('.p3').text());
                Parr.find('.date').val($(this).find('.p4').text());
                Parr.find('.date').focus();
                Parr.find('.tel2').val($(this).find('.p5').text());
                Parr.find('.ajax_people_block').html('');
                Parr.find('.edit_cleent').show();
                Parr.find('.edit_name').val($(this).find('.p2').text());
                Parr.find('.edit_soname').val($(this).find('.p1').text());
                Parr.find('.edit_phone').val($(this).find('.p3').text());
                Parr.find('.edit_phone2').val($(this).find('.p5').text());
                Parr.find('.edit_date').val($(this).find('.p4').text());
                Parr.find('.cleent_id').val($(this).find('.p6').text());
                var peodis = $(this).find('.p7');
                var peodis_name = $(this).find('.p8').text();
                if(peodis.text().length != 0){
                    Parr.find('.discount_hid').find('option').each(function(){
                        if($(this).val() == peodis.text()){
                            $(this).attr('selected','selected');
                            //alert($(this).val());
                            Parr.find('.discount_hid').select();
                            Parr.find('.info_discounts').text(Parr.find('.discount_hid option:selected').text());
                            Parr.find('.info_discounts_5_10').text(peodis_name);
                            Parr.find('.dis_5_of_10').show();
                            
                        }
                    })
                }
                Parr.find('.date').blur();
                
            })
            </script>"; 
            $ses_user = $this->ses_user;
            //$ses_user = 23;
            if(strlen($_POST['tel']) >= 2){
            $people = DB::select()->from('ticket_people')->where('soname','like',"%".$_POST['tel']."%")->limit(5)->execute()->as_array();
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            /*
            if(!empty($people)){
                echo '<ul>';
                foreach($people as $p){
                    echo '<li class="on_peo"><span class="p1">'.$p['tel'].'</span> <span class="p2">'.$p['name'].'</span> <span class="p3">'.$p['soname'].'</span> <span class="p4">'.$p['date'].'</span> <span class="p5">'.$p['tel2'].'</span></li>';
                }
                echo '</ul>';
            }
            */
            //die;
                if(!empty($people)){
                    //$new_peo = array();
                    //foreach($people as $p){
                    //    $new_peo[$p['soname'].$p['name']] = $p;
                    //}
                    
                    
                    ///*
                    
                    //*/
                    echo '<ul>';
                    foreach($people as $pp){
                        $people_dis = '';
                        $people_dis_name = '';
                        if($pp['count_trip'] == 4 || $pp['count_trip'] == 9){
                            if($pp['count_trip'] == 4){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('5_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                            if($pp['count_trip'] == 9){
                                $pe_dis = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('10_tik','=',1)->execute()->current();
                                if(!empty($pe_dis)){
                                    $people_dis = $pe_dis['main_id'];
                                    $pe_dis_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$pe_dis['main_id'])->and_where('culture','=',$lang)->execute()->current();
                                    $people_dis_name = $pe_dis_name['name_i18n'];
                                }
                            }
                        }
                        $chek_client_sesuser = Model::factory('TiketMod')->showphone_for_tel($pp['id'],$ses_user[0]['id']);
                        if($chek_client_sesuser != 1){
                            $pp['tel'] = '**********';
                        }
                        echo '<li class="on_peo"><span class="p6">'.$pp['id'].'</span> <span class="p1">'.$pp['soname'].'</span> <span class="p2">'.$pp['name'].'</span> <span class="p3">'.$pp['tel'].'</span> <span class="p4">'.$pp['date'].'</span> <span class="p5">'.$pp['tel2'].'</span><span style="display:none;" class="p7">'.$people_dis.'</span><span style="display:none;" class="p8">'.$people_dis_name.'</span></li>';
                    }
                    echo '</ul>';
                }
            }
            die;
        }
    }
    
     public function action_ajax_get_one_people(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['plase'] = $_POST['plase'];
            
            $data['valute'] = $_POST['valute'];
            $price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
            $data['price'] = $price['price'];
            $data['route_name_id'] = $_POST['route_name_id'];
            $data['ferryman_id'] = $_POST['ferryman_id'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            //print_r($data);
            //die;
            echo View::factory('tiket/get_one_people_for_sell',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_open(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['plase'] = $_POST['plase'];
            $data['valute'] = $_POST['valute'];
            $data['route_name_id'] = $_POST['route_name_id'];
            //print_r($_POST);
            
            $ferryman = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
//die;
            //print_r($ferryman);
            //die;
            //$price_array = Model::factory('TiketMod')->chek_price_model($_POST['route_name_id'],$_POST['from'],$_POST['to'],$_POST['valute'],$ferryman['ferryman_id']);
            
            $price_array = Model::factory('TiketMod')->chek_price_model_open($_POST['route_name_id'],$_POST['from'],$_POST['to'],$_POST['valute']);
            $data['price'] = $price_array[0];
            $data['valute'] = $price_array[1];
            
            
           
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($ferryman['ferryman_id'],$lang,$ses_user[0]['id']);
           
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($ferryman['ferryman_id'],$lang,$ses_user[0]['id']);
            //print_r($data['all_discount']);
            // print_r($ferryman);
            //die;
            echo View::factory('tiket/get_one_people_for_sell_open',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_open_return(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['plase'] = $_POST['plase'];
            $data['valute'] = $_POST['valute'];
            //print_r($_POST);
            //die;
            $ferryman = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            
            //$countrys = DB::select()->from('country')->where('valute','=',$data['valute'])->execute()->current();
//die;
            $price_array = Model::factory('TiketMod')->chek_price_model_open($_POST['route_name_id'],$_POST['from'],$_POST['to'],$_POST['valute']);
            $data['price'] = $price_array[0];
            $data['valute'] = $price_array[1];
            //$data['all_discount_hidden'] = array();
            //print_r($data['all_discount_hidden']);
            //die;
            $data['route_name_id'] = $_POST['route_name_id'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($ferryman['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($ferryman['ferryman_id'],$lang,$ses_user[0]['id']);
            echo View::factory('tiket/get_one_people_for_sell_open_return',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_no(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            //die;
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            
            $data['plase'] = $_POST['plase'];
            
            $data['valute'] = $_POST['valute'];
            //$price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
            $data['price'] = $_POST['price'];
            
            
            
            
            $data['route_name_id'] = $_POST['route_name_id'];
            
            
            
            
            //$data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman_fixet($_POST['route_name_id'],$_POST['ferryman_id'],$lang,$_POST['prior'],$_POST['open']);
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            //echo '<pre>';
            //print_r($data['all_discount']);
            //echo '</pre>';
            
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            
            //echo '<pre>';
            //print_r($data['all_discount_hidden']);
            //echo '</pre>';
            //if($data['all_discount'] == 1 || $data['all_discount_hidden'] == 1){
            //    echo 'No carrier discounts!';
            //    die;
            //}
            //print_r($data);
            $data['ferryman_id'] = $_POST['ferryman_id'];
            echo View::factory('tiket/get_one_people_for_sell',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_return(){
        if($_POST){
            $ses_user = $this->ses_user;
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['id'] = $_POST['id'];
            $data['plase'] = $_POST['plase'];
            $data['price'] = $_POST['price'];
            $data['valute'] = $_POST['valute'];
            $data['tel'] = $_POST['tel'];
            $data['name'] = $_POST['name'];
            $data['soname'] = $_POST['soname'];
            $data['date'] = $_POST['date'];
            $data['price_new'] = 100;
            $data['route_name_id'] = $_POST['route_name_id'];
            $data['ferryman_id'] = $_POST['ferryman_id'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            //echo $data['price_new'];
            echo View::factory('tiket/get_one_people_for_sell_return',$data);
            die;
        }
    }
    
    
    public function action_ajax_get_one_people_return_search_route_no(){
        if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['plase'] = $_POST['plase'];
            
            $data['valute'] = $_POST['valute'];
            //$price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
            $data['price'] = $_POST['price'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang);
            //if($data['all_discount'] == 1 || $data['all_discount_hidden'] == 1){
            //    echo 'No carrier discounts!';
            //    die;
            //}
            echo View::factory('tiket/get_one_people_for_sell',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_return_search_route(){
        if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['id'] = $_POST['id'];
            $data['plase'] = $_POST['plase'];
            $data['price'] = $_POST['price'];
            $data['valute'] = $_POST['valute'];
            $data['tel'] = $_POST['tel'];
            $data['name'] = $_POST['name'];
            $data['soname'] = $_POST['soname'];
            $data['date'] = $_POST['date'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang);
            echo View::factory('tiket/get_one_people_for_search_route_return',$data);
            die;
        }
    }
    
    public function action_ajax_get_route_reverse(){
        if($_POST){
            $ses_user = $this->ses_user;
            
            $rev_slave = DB::select()->from('route_reverse')->where('main_id','=',$_POST['route_main_id'])->or_where('reverse_id','=',$_POST['route_main_id'])->execute()->current();
            if($rev_slave['main_id'] == $_POST['route_main_id']){
                $slave_route = $rev_slave['reverse_id'];
            }else{
                $slave_route = $rev_slave['main_id'];
            }
            $slave_pri = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$ses_user[0]['id'])->and_where('slave_route','=',$slave_route)->execute()->current();
            $route_name =  DB::select()->from('routename')->where('route_name_id','=',$slave_pri['slave_route'])->execute()->current();
            $str = $slave_pri['slave_route'].','.$route_name['name'].','.$slave_pri['slave_city_id'];
            
            echo $str;
            //print_r($slave_pri);
            //echo '</pre>';
            die;
        }
    }
    
    public function action_ajax_get_ost_slave(){
        if($_POST){
            $all_ost = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight')->execute()->as_array();
            foreach($all_ost as $o){
                $ost_name = DB::select('route_city_id','name_i18n','city_i18n')->from('routecity_i18n')->where('route_city_id','=',$o['route_city_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                //$new_ar[] = $ost_name; 
                if($ost_name['route_city_id'] == $_POST['slave_city']){
                    echo "<option selected='selected' value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>"; 
                }else{
                    echo "<option value='".$ost_name['route_city_id']."'>".$ost_name['city_i18n']." ".$ost_name['name_i18n']."</option>";         
                }
                      
            }
            //echo '<pre>';
            //print_r($all_ost);
            //echo '</pre>';
            die;
        }
    }
    public function action_ajax_search_tik(){
        if($_POST){
                
                
                $lang = Session::instance()->get('leng');
                if(!$lang) {
                    $lang = 'EN';
                } 
                
                $sesuser = Session::instance()->get('ses_user');
                
                I18n::lang($lang);
                
                
                echo "<script>
                $('.on_tik').click(function(){
                    var ID = $(this).find('.t24').text();
                    var FerrymanID = $(this).find('.t3').text();
                    $('.search_tik').val(ID);
                    $('.search_tik_hid').val($(this).find('.t1').text());
                    $('.search_tik_route').val($(this).find('.t2').text());
                    $('.search_tik_route_hid').val($(this).find('.t12').text());
                    $('.search_tik_date').val($(this).find('.t4').text());
                    $('.search_tik_client').val($(this).find('.t5').text());
                    $('.search_tik_price').val($(this).find('.t6').text());
                    $('.search_tik_price_null').val($(this).find('.t14').text());
                    $('.search_tik_status').val($(this).find('.t7').text());
                    $('.search_tik_from').val($(this).find('.t8').text());
                    $('.search_tik_to').val($(this).find('.t9').text());
                    $('.search_tik_fer').val($(this).find('.t10').text());
                    $('.search_tik_fer_name').val($(this).find('.t11').text());
                    $('.search_tik_from_hid').val($(this).find('.t22').text());
                    $('.search_tik_to_hid').val($(this).find('.t23').text());
                    $('.ajax_search_block').html('');
                    if($(this).find('.t7').text() == 'sell' || $(this).find('.t7').text() == 'transfer'){
                        $('.tiket_null').show();
                        $('.tiket_null_proc').show();
                        $('.transfer_tik').show();
                    }
                    if($(this).find('.t7').text() == 'reserv'){
                        $('.tiket_null').show();
                        $('.tiket_null_proc').show();
                        $('.transfer_tik').show();
                        $('.sel_res_button').show();
                    }
                    if($(this).find('.t7').text() == 'open'){
                        $('.tiket_null').show();
                        $('.tiket_null_proc').show();
                        $('.cheng_open').show();                        
                    }
                    $('.print_button').show();  
                    //var Perrr = '';
                    //var Perrr = '';
                  $('.search_salon').html('<p>&nbsp;</p><p>".__('Time after sale').": '+$(this).find('.t15').text()+' / ".__('Day')." '+$(this).find('.t20').text()+'</p><p>".__('Percentage').": '+$(this).find('.t16').text()+'</p><p>".__('Discount').": '+$(this).find('.t21').text()+'</p><p>".__('Date of creating').": '+$(this).find('.t18').text()+'</p>');
                  tickit_history($(this).find('.t1').text());  
                })
                </script>"; 
                
                if(strlen($_POST['tik_id']) >= 1){
                
                $children_sysusers = DB::select()->from('system_users')->where('parent_sysuser','=',$sesuser[0]['id'])->execute()->as_array();
                
               
                
                $all_cild = array();
                
                array_push($all_cild,$sesuser[0]['id']);
               
                foreach($children_sysusers as $chil){
                //    echo '<pre>';
                //print_r($chil);
                ////echo '</pre>';
                //die;
                    array_push($all_cild,$chil['id']);
                }
                
                
                
                $people = DB::select()->from('ticket')->where('maska','like',"%".$_POST['tik_id']."%")->and_where('user_id','in',$all_cild)->execute()->as_array();

                $orders = array();
                
                foreach($people as $tik_c){
                    $all_user = DB::select()->from('system_users_routes')->where('sysuser_id','=',$sesuser[0]['id'])->execute()->as_array();
                    foreach($all_user as $rou){
                        if($rou['route_name_id'] == $tik_c['route_name_id']){
                            $orders[] = $tik_c;
                        }
                    }
                    
                }
                
                $people = $orders;
                
                
                if(!empty($people)){
                    echo '<ul>';
                    foreach($people as $p){
                        $tik_people = DB::select()->from('ticket_people')->where('id','=',$p['client_id'])->execute()->current();
                        $fer_name = DB::select()->from('ferryman')->where('ferryman_id','=',$p['ferryman_id'])->execute()->current();
                        $route_name = DB::select()->from('routename')->where('route_name_id','=',$p['route_name_id'])->execute()->current();
                        $tik_report = DB::select()->from('ticketreport')->where('ticket_id','=',$p['ticket_id'])->order_by('report_id','DESC')->execute()->current();
                        $tik_valute = DB::select()->from('ticket_valute')->where('tiket_id','=',$p['ticket_id'])->execute()->current();
                        
                        $from_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$p['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
                        $to_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$p['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();
                        
                        $status = '';
                        
                        /////////////////
                        $nul_price = '';
                        
                        $nul_price_clear = $p['route_price_discount'];
                        
                        $full_price = $p['route_price_discount'];
                        
                        $v_day = '';
                        
                        $pas = '';
                        
                        $v_min = '';
                        
                        $tik_bay = '';
                        
                        $v_day_new = '';
                        
                        $now_time = date('Y-m-d H:i:s');
                        
                        if(!empty($p['route_price_discount'])){
                            $rou_dat = strtotime($p['route_date'].' '.$p['route_time']);
                            $sel_dat = strtotime('now');
                            $proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$p['ferryman_id']);
                            $nul_price = $p['route_price_discount'].' '.$tik_valute['valute'];
                            $nul_price_clear = $p['route_price_discount'];
                            $tik_bay = $tik_report['create_report'];
                            if($p['ticket_type_id'] == 2){
                                $nul_price = '';
                            }else{
                                $time_sell = strtotime($tik_report['create_report']);
                                $now = strtotime(date('Y-m-d H:i:s'));
                                $pas = $now - $time_sell;
                                $v_min = round($pas/60,0);
                                $v_hou = round($v_min/60,0);
                                $v_day_new = round($v_hou/24,0);
                                if($v_min < 30){ 
                                    $proc = 0;
                                    $nul_price = '-'.$p['route_price_discount'].' '.$tik_valute['valute'];
                                    $nul_price_clear = $p['route_price_discount'];
                                }else{
                                    $pro_price = $p['route_price_discount']/100 * $proc;
                                    $p['route_price_discount'] -= $pro_price;
                                    $nul_price = '-'.$p['route_price_discount'].' '.$tik_valute['valute'];
                                    $nul_price_clear = $p['route_price_discount'];
                                } 
                            }
                        }
                        
                        ////////////////
                        
                        switch($tik_report['status']){
                            case'1':
                            $status = 'sell';
                            break;
                            case'2':
                            $status = 'reserv';
                            break;
                            case'3':
                            $status = 'return';
                            break;
                            case'4':
                            $status = 'transfer';
                            break;
                            case'5':
                            $status = 'open';
                            break; 
                        }
                        $discoun_name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$p['discount_id'])->and_where('culture','=',$lang)->execute()->current();
                        echo '<li class="on_tik">
                            <span >'.$p['maska'].'</span>
                            <span class="t1" style="display:none;">'.$p['ticket_id'].'</span>
                            <span class="t2" style="display:none;">'.$route_name['name'].'</span>
                            <span class="t3" style="display:none;">'.$p['ferryman_id'].'</span>
                            <span class="t4" style="display:none;">'.Date('d/m/Y',strtotime($p['route_date'])).'</span>
                            <span class="t5" style="display:none;">'.$tik_people['name']." ".$tik_people['soname'].'</span>
                            <span class="t6" style="display:none;">'.$full_price.'</span>
                            <span class="t7" style="display:none;">'.$status.'</span>
                            <span class="t8" style="display:none;">'.$from_name['name_i18n'].' '.$from_name['city_i18n'].'</span>
                            <span class="t9" style="display:none;">'.$to_name['name_i18n'].' '.$to_name['city_i18n'].'</span>
                            <span class="t10" style="display:none;">'.$p['ferryman_id'].'</span>
                            <span class="t11" style="display:none;">'.$fer_name['name'].'</span>
                            <span class="t12" style="display:none;">'.$p['route_name_id'].'</span>
                            <span class="t13" style="display:none;">'.$nul_price.'</span>
                            <span class="t14" style="display:none;">'.$nul_price_clear.'</span>
                            <span class="t15" style="display:none;">'.$v_min.'</span>
                            <span class="t16" style="display:none;">'.$proc.'</span>
                            <span class="t17" style="display:none;">'.$v_day.'</span>
                            <span class="t18" style="display:none;">'.date('d.m.Y H:i:s',strtotime($tik_bay)).'</span>
                            <span class="t19" style="display:none;">'.date('d.m.Y H:i:s',strtotime($now_time)).'</span>
                            <span class="t20" style="display:none;">'.$v_day_new.'</span>
                            <span class="t21" style="display:none;">'.$discoun_name['name_i18n'].'</span>
                            <span class="t22" style="display:none;">'.$p['route_city_from_id'].'</span>
                            <span class="t23" style="display:none;">'.$p['route_city_to_id'].'</span>
                            <span class="t24" style="display:none;">'.$p['maska'].'</span>
                        </li>';
                    }
                    echo '</ul>';
                }
                }
                die;
        }
    }
    
    public function action_ajax_get_all_ferrymans(){
        if($_POST){
            //echo $_POST['route_name_id'];
            $data = array();
            $all_fers = DB::select('ferryman_id')->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->as_array();
            $new_f = array();
            foreach($all_fers as $f){
                $name = DB::select()->from('ferryman')->where('ferryman_id','=',$f['ferryman_id'])->execute()->current();
                $new_f[$f['ferryman_id']] = $name['name'];
            }
            $data['new_f'] = $new_f;
            $data['route_name_id'] = $_POST['route_name_id'];
            echo View::factory('tiket/get_ferrymans_sell_open',$data);
            //echo '<pre>';
            //print_r($data);
            //echo '</pre>';
            die;
        }
    }
    
    public function action_ajax_open_select(){
        if($_POST){
            //echo $_POST['route_name_id'];
            $data = array();
            $all_fers = DB::select('ferryman_id')->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->as_array();
            $new_f = array();
            foreach($all_fers as $f){
                $name = DB::select()->from('ferryman')->where('ferryman_id','=',$f['ferryman_id'])->execute()->current();
                $new_f[$f['ferryman_id']] = $name['name'];
            }
            $data['new_f'] = $new_f;
            $data['route_name_id'] = $_POST['route_name_id'];
            echo View::factory('tiket/for_open_select',$data);
            //echo '<pre>';
            //print_r($data);
            //echo '</pre>';
            die;
        }
    }
    
    public function action_ajax_open_select_return(){
        if($_POST){
            
            ///echo $_POST['route_name_id'];
            
            $sesuser = Session::instance()->get('ses_user');
            
            $ses_valute = $sesuser[0]['default_valute'];
            
            
            
            $data = array();
            $all_fers = DB::select('ferryman_id')->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->as_array();
            $new_f = array();
            foreach($all_fers as $f){
                $name = DB::select()->from('ferryman')->where('ferryman_id','=',$f['ferryman_id'])->execute()->current();
                $new_f[$f['ferryman_id']] = $name['name'];
            }
            
            
            
            
            $data['new_f'] = $new_f;
            $data['route_name_id'] = $_POST['route_name_id'];
            
            $price_ch = DB::select()->from('routeprice')
            //->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')
                ->where('route_name_id','=',$_POST['route_name_id'])
                ->and_where('route_city_from_id','=',$_POST['from'])
                ->and_where('route_city_to_id','=',$_POST['to'])
                ->and_where('valute','=',$_POST['valute'])
                ->execute()->current();
                
            
    
            if(empty($price_ch)){
                $price_ch = DB::select()->from('routeprice')
                    ->where('route_name_id','=',$_POST['route_name_id'])
                    ->and_where('route_city_from_id','=',$_POST['from'])
                ->and_where('route_city_to_id','=',$_POST['to'])
                    ->execute()->current();
            }
            
            $valute = $price_ch['valute'];    
            $price = $price_ch['price'];
            
            if(!empty($price)){ 
                if($valute == 'ua'){
                    $valute = 'UAH';
                }
                if($valute == 'cs'){
                    $valute = 'CZK';
                }
              
            /*
            echo '<pre>';
            print_r($valute);
            echo '</pre>';
            
            echo '<pre>';
            print_r($ses_valute);
            echo '</pre>';
            
            echo '<pre>';
            print_r($price);
            echo '</pre>';
            
            die;
            */
                
                $new_price = Googlecon::con($valute,$ses_valute,$price);
                $valute = $new_price[1];
                $price = $new_price[0];
            }
            
            $data['price'] = $price;
            if(empty($data['price'])){
                $data['price'] = 0;
            }
            
            echo View::factory('tiket/for_open_select_return',$data);
            
            die;
        }
    }
    
    public function action_ajax_sell_chenge_valute(){
        if($_POST){
            //echo ['route_name_id'];
            $sesuser = Session::instance()->get('ses_user');
            $sesuser[0]['default_valute'] = $_POST['valute'];
            Session::instance()->delete('ses_user');
            Session::instance()->set('ses_user',$sesuser);
            $sesuser = Session::instance()->get('ses_user');
            //echo '<pre>';
            //print_r($sesuser);
            //echo '</pre>';
            die;
        }
    }
    
    
    public function action_ajax_sell_reserv(){
        if($_POST){
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            //echo ['route_name_id'];
            DB::update('ticket')->set(array(
                    'ticket_type_id'=>1,
                    'date'=>date('Y-m-d H:i:s')
               ))->where('ticket_id','=',$_POST['id'])->execute();
               
               //$chek = DB::select()->from('ticketreport')->where('ticket_id','=',$_POST['tik_id'])->and_where('status','=',4)->execute()->current();
               //if(empty($chek)){    
                DB::insert('ticketreport',array(
                    'ticket_id',
                    'status',
                    'create_report',
                    'sys_user'
                ))->values(array(
                    $_POST['id'],
                    1,
                    date('Y-m-d H:i:s'),
                    $_POST['sesuser']
                ))->execute();
            
            die;
        }
    }
    
    public function action_ajax_sell_tikets_new_print(){
        if($_POST){
            
            
            $ses = $this->ses_user;
            $parent_group = DB::select()->from('groups')->where('id','=',$ses[0]['group_id'])->execute()->current();
            //echo '<pre>';
            //print_r($parent_group);
            //echo '</pre>';
            //die;
            $data = array();
            $html = '';
            if($parent_group['parent'] != 1){
                
                if(!empty($_POST['tik_arrays'])){
                    $tikets = $_POST['tik_arrays'];
                    $tik_full = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','in',$tikets)->order_by('ferryman_id','ASC')->execute()->as_array();
    
                    foreach($tik_full as $tt){
                    $tik_f[$tt['client_id']][] = $tt;
                    }
                    
                    
                    //$last_user = '';
                    $data['lang'] = $_POST['lang'];
                    
                    foreach($tik_f as $t){
                        if(count($t) > 1){
                            
                            
                            
                            $data['id'] = $t[0]['ticket_id'];
                            $data['id2'] = $t[1]['ticket_id'];
                            $html .= View::factory('tiket/ticket_ferryman/'.$parent_group['parent'].'/return',$data);
                            //echo 
                        }else{
                            //echo 'one'."<br />";
                            $data['id'] = $t[0]['ticket_id'];
                            $html .= View::factory('tiket/ticket_ferryman/'.$parent_group['parent'].'/priamoy',$data);
                        }
                    }
                }
                if(!empty($_POST['tik_arrays_open'])){
                    $tikets_open = $_POST['tik_arrays_open'];
                    $tik_full_open = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','in',$tikets_open)->order_by('ferryman_id','ASC')->execute()->as_array();
    
                    //foreach($tik_full_open as $tt_open){
                    //$tik_f_open[$tt_open['client_id']][] = $tt_open;
                    //}
                    //print_r($tik_full_open);
                    //die;
                    //$last_user = '';
                    $data = array();
                    $data['lang'] = $_POST['lang'];
                    //$html_open = '';
                    foreach($tik_full_open as $t){
                        //print_r($t);
                        //die;
                        //if(count($t) > 1){
                            //echo 'return'."<br />";
                        //    $data['id'] = $t[0]['ticket_id'];
                        //    $data['id2'] = $t[1]['ticket_id'];
                        //    $html .= View::factory('/tiket/ticket_ferryman/'.$parent_group['parent'].'/return',$data);
                            //echo 
                        //}else{
                            //echo 'one'."<br />";
                            $data['id'] = $t['ticket_id'];
                            $html .= View::factory('tiket/ticket_ferryman/'.$parent_group['parent'].'/open',$data);
                        //}
                    }
                }
                
            }else{
                echo 'Вы не можете продавать билеты. Пожалуйста зайдите в систему под другим пользователем!';
            }
            
            
            
            
            echo $html;
            //print_r($tik_f);
            //echo '</pre>';
            
            
            die;
        }
    }
    
    public function action_ajax_sell_tikets_new_print_reserv(){
        if($_POST){
            
            
            $ses = $this->ses_user;
            $parent_group = DB::select()->from('groups')->where('id','=',$ses['group_id'])->execute()->current();
            //echo '<pre>';
            //print_r($parent_group);
            //echo '</pre>';
            $data = array();
            $html = '';
            if($parent_group['parent'] != 1){
                
                if(!empty($_POST['tik_arrays'])){
                    $tikets = $_POST['tik_arrays'];
                    $tik_full = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','in',$tikets)->order_by('ferryman_id','ASC')->execute()->as_array();
    
                    foreach($tik_full as $tt){
                    $tik_f[$tt['client_id']][] = $tt;
                    }
                    
                    
                    //$last_user = '';
                    $data['lang'] = $_POST['lang'];
                    
                    foreach($tik_f as $t){
                        if(count($t) > 1){
                            //echo 'return'."<br />";
                            $data['id'] = $t[0]['ticket_id'];
                            $data['id2'] = $t[1]['ticket_id'];
                            $html .= View::factory('/tiket/ticket_ferryman/'.$parent_group['parent'].'/return',$data);
                            //echo 
                        }else{
                            //echo 'one'."<br />";
                            $data['id'] = $t[0]['ticket_id'];
                            $html .= View::factory('/tiket/ticket_ferryman/'.$parent_group['parent'].'/priamoy',$data);
                        }
                    }
                }
                
                
            }else{
                echo 'Вы не можете продавать билеты. Пожалуйста зайдите в систему под другим пользователем!';
            }
            
            
            
            
            echo $html;
            //print_r($tik_f);
            //echo '</pre>';
            
            
            die;
        }
    }
    
    public function action_ajax_null_tiket_print(){
        if($_POST){
            $ses = $this->ses_user;
            $parent_group = DB::select()->from('groups')->where('id','=',$ses['group_id'])->execute()->current();
            $data = array();
            $html = '';
            if($parent_group['parent'] != 1){
                
                if(!empty($_POST['tik'])){
                    $tiket = $_POST['tik'];
                    $tik_full = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','=',$tiket)->order_by('ferryman_id','ASC')->execute()->as_array();
    
                    $data['lang'] = $_POST['lang'];
                    
                    $data['id'] = $tiket;
                    $html .= View::factory('/tiket/ticket_ferryman/'.$parent_group['parent'].'/null',$data);

                }  
            }else{
                echo 'Вы не можете продавать билеты. Пожалуйста зайдите в систему под другим пользователем!';
            } 
            echo $html;
            die;
        }
    }
    
    
    function order_tiks_client($array) {
       
            foreach($array as $arr) {
                $new['client_id'][] = $arr['client_id'];
            }
            array_multisort($new['client_id'], constant('SORT_ASC'), $array);
            
        return $array;
    }
    
    public function action_search_tiks(){
        $data = array();
        $ses = $this->ses_user;
        if(isset($ses[0]['id'])){
            $data['user_id'] = $ses[0]['id'];
            $data['sesuser'] = $ses;
        }else{
            $data['user_id'] = 0;
            $data['sesuser'] = $ses;
        }
        
        $this->template->content_admin = View::factory('tiket/search_ticks',$data);
    }
    
    function anule_reserv(){
        $ses = $this->ses_user;
        $group_id = $ses['group_id'];
        $group = DB::select()->from('groups')->where('id','=',$group_id)->execute()->current();
        $parent_group = DB::select()->from('groups')->where('id','=',$group['parent'])->execute()->current();
        //print_r();
        $data = array();
        if(!empty($parent_group['reserv_anule'])){
            $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$ses[0]['id'])->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses[0]['id']);
            $tikets = DB::select()->from('ticket')
            ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
            ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
            ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
            ->and_where('sys_user','in',$children_arr_a)
            ->order_by('ticketreport.create_report','DESC')
            ->execute()->as_array();
            $new_tik = array();
            //echo Date('H:i:s'); 
            foreach($tikets as $tik){
                $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$tik['ticket_id'])->and_where('status','=',1)->execute()->current();
                if($tik['status'] == 2 && empty($chek_sell)){
                    $hours = strtotime($tik['route_date'].' '.$tik['route_time']);
                    $now = $hours - strtotime('now');
                    $now = round($now/60,0);
                    if($now < $parent_group['reserv_anule']){
                        
                        DB::insert('ticket_auto_anule',array(
                            'tiket_id',
                            'status',
                            'user_create',
                            'route_name_id',
                            'route_date',
                            'ferryman_id',
                            'city_from',
                            'city_to',
                            'client',
                            'discount',
                            'price',
                            'anule',
                        ))->values(array(
                            $tik['ticket_id'],
                            $tik['status'],
                            $tik['user_id'],
                            $tik['route_name_id'],
                            $tik['route_date'],
                            $tik['ferryman_id'],
                            $tik['route_city_from_id'],
                            $tik['route_city_to_id'],
                            $tik['client_id'],
                            $tik['discount_id'],
                            $tik['price'],
                            date('Y-m-d H:i:s'),
                        ))->execute();
                        
                        DB::delete('ticket')->where('ticket_id','=',$tik['ticket_id'])->execute();
                        DB::delete('ticketreport')->where('ticket_id','=',$tik['ticket_id'])->execute();
                        //DB::delete('ticket_people')->where('ticket_id','=',$tik['ticket_id'])->execute();
                        DB::delete('ticket_valute')->where('tiket_id','=',$tik['ticket_id'])->execute();
                    }
                    //$new_tik[] = array($tik['ticket_id'],$tik['status'],$tik['route_date'],$hours,$now);
                }
                
            }
            
            //die;
        }
        $tikets2 = DB::select()->from('ticket')
            //->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
            //->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
            ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
            ->and_where('ticketreport.status','=',2)
            ->execute()->as_array();
        foreach($tikets2 as $tik2){
            $chek_sell2 = DB::select()->from('ticketreport')->where('ticket_id','=',$tik2['ticket_id'])->and_where('status','=',1)->execute()->current();
                if($tik2['status'] == 2 && empty($chek_sell2)){
                    //echo '<pre>';
                    //print_r($tik2);
                    //echo '</pre>';
                    $hours = strtotime($tik2['route_date'].' '.$tik2['route_time']);
                    $now = $hours - strtotime('now');
                    $now = round($now/60,0);
                    $ferryman = DB::select()->from('ferryman')->where('ferryman_id','=',$tik2['ferryman_id'])->execute()->current();
                    if(!empty($ferryman['reserv_anule']) && $now < $ferryman['reserv_anule']){
                        
                        DB::insert('ticket_auto_anule',array(
                            'tiket_id',
                            'status',
                            'user_create',
                            'route_name_id',
                            'route_date',
                            'ferryman_id',
                            'city_from',
                            'city_to',
                            'client',
                            'discount',
                            'price',
                            'anule',
                        ))->values(array(
                            $tik2['ticket_id'],
                            $tik2['status'],
                            $tik2['user_id'],
                            $tik2['route_name_id'],
                            $tik2['route_date'],
                            $tik2['ferryman_id'],
                            $tik2['route_city_from_id'],
                            $tik2['route_city_to_id'],
                            $tik2['client_id'],
                            $tik2['discount_id'],
                            $tik2['price'],
                            date('Y-m-d H:i:s'),
                        ))->execute();
                        
                        DB::delete('ticket')->where('ticket_id','=',$tik2['ticket_id'])->execute();
                        DB::delete('ticketreport')->where('ticket_id','=',$tik2['ticket_id'])->execute();
                        //DB::delete('ticket_people')->where('ticket_id','=',$tik['ticket_id'])->execute();
                        DB::delete('ticket_valute')->where('tiket_id','=',$tik2['ticket_id'])->execute();
                    }
                }
        }
            
        //}
        //echo 'ok';
    }
    
    
    	public function action_auto_tik_anule() {  
        //$this->chek_permition(); 
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $ses_user = $this->ses_user;
        $data = array();
        //print_r($ses_user);
        //die;
        $data['tikets'] = DB::select()->from('ticket_auto_anule')
        ->order_by('anule','DESC')
        ->execute()->as_array();        
        $this->template->content_admin = View::factory('tiket/tiket_auto_anule',$data);
	}
    
     public function action_ajax_print_ticket_kassa(){
        if($_POST){
            $data = array();
            $data['tikets'] = DB::select()->from('ticketreport')
            ->join('ticket')->on('ticketreport.ticket_id','=','ticket.ticket_id')
            ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
            ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
            ->where('ticket.ticket_id','in',$_POST['array'])
            ->order_by('ticketreport.create_report','DESC')
            ->execute()->as_array();
            $data['lang'] = $_POST['lang'];
            //print_r($_POST);
            echo View::factory('tiket/print_ticket_kassa',$data);
            die;
        }
    }
    
    public function action_ajax_create_csv_kassa(){
        if($_POST){
            //
            
            $server = $_SERVER['DOCUMENT_ROOT'];
            //$server = 'http://disp.svitgo.com';
            //preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $_POST['html'], $tr);
            
            $str = '';
            $str .= '№;ORDER;STATUS;CREATE;USERS;ROUTE;FERRYMAN;ROUTE DATE;CITIES;CLIENT;DISCOUNT;PRICE'."\r\n";
            foreach($_POST['html'] as $v){
            //echo '<pre>';
            //print_r($v);
            //echo '</pre>';
            //die;
                $new = array();
                preg_match_all('!<td(.*?)>(.*?)</td>!si', $v, $new);
                    $str .= strip_tags($new[2][0]).';'.strip_tags($new[2][1]).';'.strip_tags($new[2][2]).';'.strip_tags($new[2][3]).';'.strip_tags($new[2][4]).';'.strip_tags($new[2][5]).';'.strip_tags($new[2][6]).';'.strip_tags($new[2][7]).';'.strip_tags($new[2][8]).';'.strip_tags($new[2][9]).';'.strip_tags($new[2][10]).';'.strip_tags($new[2][11]).";\r\n";
                
            }
            
            $str_codirovka = Model::factory('TiketMod')->mb_ucfirst($str,'utf-8');
            //$str_codirovka = iconv ('utf-8', 'windows-1251', $str_codirovka);
            //echo $str_codirovka;
            //echo $str;
            
            //die;
            //die;
            file_put_contents($server.'/vedomost/csv_file.csv', $str_codirovka);
            //*/
            //
            //$this->template->content_admin = View::factory('tiket/vedomost_route_2',$data);
            die;
        }
    }
    
    public function action_test_iconv(){
       
            //
            
            
            //$server = 'http://disp.svitgo.com';
            //preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $_POST['html'], $tr);
            
            $str = '';
            $str .= '№;CТАТУС;СОЗДАТЬ;ПОЛЬЗОВАТЕЛИ;МАРШРУТ;ПЕРЕВОЗЧИК;ДАТА МАРШРУТА;ГОРОДА;КЛИЕНТ;СКИДКА;ЦЕНА;'."\r\n";
            
            $str = '';
            $str .= '№;CТАТУС;СОЗДАТЬ;ПОЛЬЗОВАТЕЛИ;МАРШРУТ;ПЕРЕВОЗЧИК;ДАТА МАРШРУТА;ГОРОДА;КЛИЕНТ;СКИДКА;ЦЕНА;'."\r\n";
            
            $data = array(1,2);
            
            foreach($data as $v){
            //echo '<pre>';
            //print_r($v);
            //echo '</pre>';
            //die;
                //$new = array();
                //preg_match_all('!<td(.*?)>(.*?)</td>!si', $v, $new);
                    $str .= '№;CТАТУС;СОЗДАТЬ;ПОЛЬЗОВАТЕЛИ;МАРШРУТ;ПЕРЕВОЗЧИК;ДАТА МАРШРУТА;ГОРОДА;КЛИЕНТ;СКИДКА;ЦЕНА;'."\r\n";
                
            }
            
            
            $str = iconv ('utf-8', 'windows-1251', $str);
            //echo $str_codirovka;
            echo $str;
            
            //die;
            //die;
            //file_put_contents($server.'/vedomost/csv_file.csv', $str_codirovka);
            //*/
            //
            //$this->template->content_admin = View::factory('tiket/vedomost_route_2',$data);
            die;
       
    }
    
    public function action_ajax_save_vedomost_3(){
        if($_POST){
            /*
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            */
            DB::insert('vedomost3',array(
                'route_name_id',
                'date',
                'type',
                'valute',
                'price',
            ))->values(array(
                $_POST['route_name_id'],
                $_POST['date'],
                $_POST['type'],
                $_POST['valute'],
                $_POST['price'],
            ))->execute();
            die;
        }
    }
    
    public function action_ajax_dell_ved_3(){
        if($_POST){
           
            DB::delete('vedomost3')->where('ved_id','=',$_POST['id'])->execute();
            die;
        }
    }
    
    public function action_create_ajax_csv_ved_3() {   
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        
        if($_POST){
            
            // /*
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
           // */
            //die;print_r($str);
            //die;
            $server = $_SERVER['DOCUMENT_ROOT'];
           
            //preg_match_all('!<p(.*?)>(.*?)</p>!si', $_POST['html'], $tabb);
            
            
            
            //$user_name = trim($tabb[2][0]);
            preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $_POST['html'], $tr);
            
            array_pop($tr[0]);
            array_pop($tr[0]);
            
            $str = '';
            
            //$str .= $_POST['sys'].";\r\n";
            $str .= $_POST['name'].';'.$_POST['date'].';'.$_POST['bus'].';'.$_POST['nomer']."\r\n";
            foreach($tr[0] as $v){
                
                
                    $new = array();
                    preg_match_all('!<td(.*?)>(.*?)</td>!si', $v, $new);
                    
                    $one_row = '';
                    foreach($new[2] as $td){
                        $td = strip_tags($td);
                        $td = str_replace('X', "", $td);
                        $td = trim($td);
                        //echo '<pre>';
                        //print_r($td);
                        //echo '</pre>';
                        $one_row .= $td.';';
                        //die;
                    }
                
                //print_r($one_row);
                //die;
            
            //die;
                
                //if(isset($new[2])){
                   $str .= $one_row.";\r\n";
                //}
                //$str .= $new[2][0].';'.$new[2][1].";\r\n";
                
            }
            ///*
            
            //$str_codirovka = iconv ('utf-8', 'windows-1251', $str);
            $str_codirovka = Model::factory('TiketMod')->mb_ucfirst($str);
            //die;
            file_put_contents($server.'/vedomost/csv_file.csv', $str_codirovka);
            //*/
            //
            //$this->template->content_admin = View::factory('tiket/vedomost_route_2',$data);
            die;
        }
        
	}
    
     public function action_invoices(){
        $data = array();
    
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        $ses_user = $this->ses_user;
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();
            $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses_user[0]['id']);
            
            
        // print_r($children_arr_a);   
            
        $data['tikets'] = array();
        
        $data['main_addres'] = $ses_user[0]['adress'];
        
        $data['slave_addres'] = '';
        
        $data['procent'] = '';

        if($_GET){
            $limit = 1000;
            $get = $_GET;
            array_pop($get);
            $strWhere = array();
            foreach ($get as $pararam => $value){
                if(trim($value)!='') {
                    
                    
                        //print_r($pararam);
                        //die;
                        
                        if($pararam == 'from'){
                            $date = array_reverse(explode('/', $value));
                            $value = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
                            $date_to = array_reverse(explode('/', $_GET['to']));
                            $value2 = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0]));
                            $strWhere[] = 'route_date BETWEEN \''.$value.'\' AND \''.$value2 .'\'';
                        }
                    
                }
            }
            
            //die;
            //if(count($children_arr_a) == 1){
            $strWhere[] = 'ticketreport.sys_user = '.$_GET['disp'].'';
            //}
            //echo '<pre>';
            //print_r($strWhere);
            //echo '</pre>';
            if(!empty($strWhere)){
                $SQL="SELECT 
                ticket.ticket_id,
                ticket.route_city_from_id,
                ticket.route_city_to_id,
                ticket.route_name_id,
                ticket.price,
                ticket.route_date,
                ticket.return_price,
                ticket.discount_id,
                ticket.user_id,
                ticket.ferryman_id,
                ticketreport.status,
                ticketreport.create_report,
                ticketreport.sys_user,
                ticket_valute.valute,
                ticket_people.name,
                ticket_people.soname,
                ticket.client_id
                 FROM `ticket` 
                LEFT JOIN `ticketreport` ON ticket.ticket_id = ticketreport.ticket_id
                LEFT JOIN `ticket_valute` ON ticket.ticket_id = ticket_valute.tiket_id
                LEFT JOIN `ticket_people` ON ticket.client_id = ticket_people.id
                  WHERE ".join(' AND ',$strWhere)." limit $limit";
                //echo $SQL;
                //die;
            }else{
                $SQL="SELECT 
                ticket.ticket_id,
                ticket.route_city_from_id,
                ticket.route_city_to_id,
                ticket.route_name_id,
                ticket.price,
                ticket.return_price,
                ticket.discount_id,
                ticket.user_id,
                ticket.ferryman_id,
                ticketreport.status,
                ticketreport.create_report,
                ticketreport.sys_user,
                ticket_valute.valute,
                ticket_people.name,
                ticket_people.soname,
                ticket.client_id
                 FROM `ticket` 
                LEFT JOIN `ticketreport` ON ticket.ticket_id = ticketreport.ticket_id
                LEFT JOIN `ticket_valute` ON ticket.ticket_id = ticket_valute.tiket_id
                LEFT JOIN `ticket_people` ON ticket.client_id = ticket_people.id
                 limit $limit";
            }
            

            //$SQL="SELECT * FROM `` ".$strWhere." ";
            //mysql_query($sql); 
            $all = DB::query(Database::SELECT, $SQL)->execute()->as_array();
            
           //echo '<pre>';
           // print_r($all);
           // echo '</pre>';
            //$tes = '';
            $new = array();
            foreach($all as $al){
            //    if($tes != $al){
                    $new[] = $al;
            //    }
            //    $tes = $al;
            }
            $data['tikets'] = $new;
            $slave = DB::select()->from('system_users')->where('id','=',$_GET['disp'])->execute()->current();
            $data['slave_addres'] = $slave['adress'];
            $data['procent'] = $slave['procent'];
            //print_r($data['all_stud']);        
        }
        //print_r($_POST);
        $this->template->content_admin = View::factory('tiket/invoices',$data);
        //die;
    }
    
    
    
    public function action_ajax_print_vedomost_route() {   
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
        
        if($_POST){
            
            // /*
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
           // */
            //die;print_r($str);
            //die;
            $id = $_POST['route_name_id'];
            $route_date = $_POST['date'];
            $data = array();
            $data['lang'] = $lang;
            $rout = DB::select()->from('routeferrymanweek')
            ->where('route_name_id','=',$id)
            ->and_where('date','=',$route_date)
            ->execute()->current();
            $data['route'] = $rout;
            $data['date'] = $route_date; 
            echo View::factory('tiket/print_vedomost_route',$data);
            die;
        }
        
	}
    
    public function action_ajax_sell_tikets_one_order() {   
        if($_POST){
            //print_r($_POST);
            //die;
            
            $ses = $this->ses_user;
            $parent_group = DB::select()->from('groups')->where('id','=',$ses['group_id'])->execute()->current();
            
            $tik_arrays = '';
            if(!empty($_POST['tik_arrays'])){
                $_POST['tik_arrays'] = array_diff($_POST['tik_arrays'], array(''));
                $tik_arrays = implode(",", $_POST['tik_arrays']);
            }
            $tik_arrays_open = '';
            if(!empty($_POST['tik_arrays_open'])){
                $_POST['tik_arrays_open'] = array_diff($_POST['tik_arrays_open'], array(''));
                $tik_arrays_open = implode(",", $_POST['tik_arrays_open']);
            }
            $all_tiks = $tik_arrays.','.$tik_arrays_open;
            
            
            
            $join_tik = DB::insert('join_ticket',array(
                'tikets',
                'status',
                'date',
                'valute',
                'lang',
                'full_price',
                'pincod',
                'sysuser_id'
            ))->values(array(
                $all_tiks,
                1,
                date('Y-m-d H:i:s'),
                $_POST['valute'],
                $_POST['lang'],
                $_POST['full_price'],
                $this->random_pass(10),
                $ses[0]['id']
            ))->execute();
            
            
            
            $all_tik_for_pdf = explode(',',$all_tiks);
            $html = '';
            
            
            
            
            if(!empty($all_tik_for_pdf)){
                $tikets = $all_tik_for_pdf;
                $tik_full = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','in',$tikets)->order_by('ferryman_id','ASC')->execute()->as_array();

                foreach($tik_full as $tt){
                $tik_f[$tt['client_id']][] = $tt;
                }
                
              
                //$last_user = '';
                $data['lang'] = $_POST['lang'];
                
                foreach($tik_f as $t){
                    if(count($t) > 1){
                        
            
                        //echo 'return'."<br />";
                        $data['id'] = $t[0]['ticket_id'];
                        $data['id2'] = $t[1]['ticket_id'];
                        $html .= View::factory('tiket/ticket_ferryman/'.$parent_group['parent'].'/return',$data);
                        
           
                        //echo 
                    }else{
                        //echo 'one'."<br />";
                        $data['id'] = $t[0]['ticket_id'];
                        $html .= View::factory('tiket/ticket_ferryman/'.$parent_group['parent'].'/priamoy',$data);
                    }
                }
            }
            
            /*
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die;
             echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die;

            $name = $join_tik[0];
    
            $PDF = Model::factory('Pdf');
            
            $start_path = $PDF->chek_dir_date();
            
            $pdf_link = $PDF->save_pdf($name,$start_path,$html);
            
            echo $pdf_link;
            */
            
            //echo $html;
            
            die;
        }
        
	}
    
    public function action_search_orders(){
        $data = array();
        $ses = $this->ses_user;
        $data['client'] = '';
        if(isset($ses[0]['id'])){
            $data['user_id'] = $ses[0]['id'];
            $data['sesuser'] = $ses;
            $data['orders'] = DB::select()->from('join_ticket')->where(DB::expr('Date(date)'),'=',date('Y-m-d'))->where('sysuser_id','=',$ses[0]['id'])->execute()->as_array();
        }else{
            $data['orders'] = DB::select()->from('join_ticket')->where(DB::expr('Date(date)'),'=',date('Y-m-d'))->execute()->as_array();
        }
        
        
    
        //$data['orders'] = $orders;
         
        if($_POST){
            
            $tiks = DB::select()->from('ticket')->where('client_id','=',$_POST['client_id'])->execute()->as_array();
            
            $orders = DB::select()->from('join_ticket')->execute()->as_array();
            $orders_array = array();
            foreach($orders as $order){
                $tikss = explode(',',$order['tikets']);
                foreach($tikss as $tik){
                    foreach($tiks as $cl_tik){
                        if($cl_tik['ticket_id'] == $tik){
                            //if($order['sysuser_id'] == $ses[0]['id']){
                                $orders_array[] = $order;
                            //}
                        }
                    }
                }
            }
            $data['client'] = $_POST['name'];
            $data['orders'] = $orders_array;
            //die;
            
           
        }
        if($_GET){
            
           if(!empty($_GET['date']) && !empty($_GET['date_to'])){
               $date = array_reverse(explode('/', $_GET['date']));
               $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
                
               $date_to = array_reverse(explode('/', $_GET['date_to']));
               $tran_date_to = date('Y-m-d', mktime(0, 0, 0, $date_to[1], $date_to[2], $date_to[0])); 
               if(isset($ses[0]['id'])){
               $data['orders'] = DB::select()->from('join_ticket')->where('date','BETWEEN',array($tran_date,$tran_date_to))->and_where('sysuser_id','=',$ses[0]['id'])->execute()->as_array();
               }else{
                    $data['orders'] = DB::select()->from('join_ticket')->where('date','BETWEEN',array($tran_date,$tran_date_to))->execute()->as_array();
               }
           }
           
        }
        $this->template->content_admin = View::factory('tiket/search_orders',$data);
    }
    
    public function action_search_orders_clients(){         
        if($_POST){
            
            $data['orders'] = DB::select()->from('join_ticket')->where('date','BETWEEN',array($tran_date,$tran_date_to))->execute()->as_array();
            print_r($_POST);
            
            //die;
            
           $this->template->content_admin = View::factory('tiket/search_orders',$data);
        }
        
        
    }
    
    public function action_ajax_search_order(){
        if($_POST){
                
            $ses = $this->ses_user;    
                echo "<script>
            $('.on_tik').click(function(){
                var HTM = $(this).find('div').html();
                $('.ajax_search_block').html(HTM);
                if($(this).data('st') == 0){
                    //$('.ret_order').show();
                    $('.sell_order').show();
                }
                if($(this).data('st') == 1){
                    $('.ret_order').show();
                    //$('.sell_order').show();
                }
            })

            $('body').click(function(e) {
                //$('.popup').css('display','none');
                //$('.ajax_search_block').html('');
            });
            </script>"; 
                
                
                
                $lang = Session::instance()->get('leng');
                if(!$lang) {
                    $lang = 'EN';
                } 
                
                
                I18n::lang($lang);

                if(isset($ses[0]['id'])){    
                $orders = DB::select()->from('join_ticket')->where('id','like',"%".$_POST['order_id']."%")->and_where('sysuser_id','=',$ses[0]['id'])->execute()->as_array();
                }else{
                $orders = DB::select()->from('join_ticket')->where('id','like',"%".$_POST['order_id']."%")->execute()->as_array();    
                }
                //echo '<pre>';
                //print_r($orders);
                //echo '</pre>';
                //die;
                
                if(!empty($orders)){
                    echo '<ul>';
                    foreach($orders as $o){
                        
                        
                        $tik_array = explode(',',$o['tikets']);
                        $tiks = DB::select()->from('ticket')
                        ->join('ticket_people','LEFT')->on('ticket.client_id','=','ticket_people.id')
                        ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                        ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
                        ->where('ticket.ticket_id','in',$tik_array)
                        //->order_by('create_report','DESC')
                        ->execute()->as_array();
                        
                        
                        $data['tikets'] = $tiks;
                        //print_r($tiks);
                        echo '<li class="on_tik" data-st="'.$o['status'].'" ><div style="display:none;">'.View::factory('tiket/ajax_tiks_order',$data).'</div>'.$o['id'].'</li>';
                        
                    }
                    echo '</ul>';
                }
                die;
        }
    }
    
    public function action_ajax_return_order() {   
        if($_POST){
            
            /////////////////////////
              //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
                $all_tik_ = DB::select()->from('join_ticket')->where('id','=',$_POST['order_id'])->execute()->current();
                
                $all_tik = explode(',',$all_tik_['tikets']);
                
                $all_tik = array_diff($all_tik, array(''));
                
                
                foreach($all_tik as $tik){
                        
                    $tik_full = DB::select()->from('ticket')->where('ticket_id','=',$tik)->execute()->current();
                
                    DB::update('ticket')->set(array(
                    'ticket_type_id'=>3,
                    //'user_id'=>$_POST['sesuser'],
                    'return_price'=>$tik_full['route_price_discount'],    
                    ))->where('ticket_id','=',$tik_full['ticket_id'])->execute();
                    
                    DB::insert('ticketreport',array(
                        'ticket_id',
                        'status',
                        'create_report',
                        'sys_user'
                    ))->values(array(
                        $tik_full['ticket_id'],
                        3,
                        date('Y-m-d H:i:s'),
                        $tik_full['user_id']
                    ))->execute();
                    
                 //  print_r($tik_full);
                //    die; 
             
                $reg_tic = DB::select()->from('regabus_join_ticks')->where('svitgo_tik','=',$tik_full['ticket_id'])->execute()->current();
                if(!empty($reg_tic['rega_tik'])){
                    $soap = new SoapClient("http://onlineregabus.cz/soap.wsdl"); 
                    $status = $soap->soap_login('svitgo', 12345678); 
                    //$route = new stdClass();
                    $soap->soap_annule(trim($reg_tic['rega_tik']));  
                }
            //foreach($all_types as $type){
            }
            //}
            DB::update('join_ticket')->set(array(
            'status'=>2,
            //'user_id'=>$_POST['sesuser'],
            //'return_price'=>$tik_full['route_price_discount'],    
            ))->where('id','=',$_POST['order_id'])->execute();
            //echo $all_types['type'];
            die;
            
            
            //////////////////////////
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            ///*
        }
        
	}
    
    
    public function action_ajax_sell_order() {   
        if($_POST){
            
            /////////////////////////
              //DB::delete('ticket')->where('ticket_id','=',$_POST['tiket_id'])->execute()
                
                $all_tik_ = DB::select()->from('join_ticket')->where('id','=',$_POST['order_id'])->execute()->current();
                
                $all_tik = explode(',',$all_tik_['tikets']);
                
                $all_tik = array_diff($all_tik, array(''));
                
                $ses = $this->ses_user;
                
                foreach($all_tik as $tik){
                        
                    $tik_full = DB::select()->from('ticket')->where('ticket_id','=',$tik)->execute()->current();
                
                    DB::update('ticket')->set(array(
                    'ticket_type_id'=>1,
                    //'user_id'=>$_POST['sesuser'],
                    'return_price'=>$tik_full['route_price_discount'],    
                    ))->where('ticket_id','=',$tik_full['ticket_id'])->execute();
                    
                    DB::insert('ticketreport',array(
                        'ticket_id',
                        'status',
                        'create_report',
                        'sys_user'
                    ))->values(array(
                        $tik_full['ticket_id'],
                        1,
                        date('Y-m-d H:i:s'),
                        $ses[0]['id']
                    ))->execute();
                    
                 //  print_r($tik_full);
                //    die; 
             
            //foreach($all_types as $type){
            }
            //}
            DB::update('join_ticket')->set(array(
            'status'=>1,
            //'user_id'=>$_POST['sesuser'],
            //'return_price'=>$tik_full['route_price_discount'],    
            ))->where('id','=',$_POST['order_id'])->execute();
            //echo $all_types['type'];
            
            echo $all_tik_['tikets'];
            
            die;
            
            
            //////////////////////////
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            ///*
        }
        
	}
    
    function random_pass($length){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
    
    
    public function action_ajax_sell_tikets_one_order_reserv() {   
        if($_POST){
            //echo '<pre>';
            //print_r($_POST['tik_arrays']);
            //echo '</pre>';
            //die;
            ///*
            $ses = $this->ses_user;
            
            
            $tik_arrays = '';
            if(!empty($_POST['tik_arrays'])){
                $_POST['tik_arrays'] = array_diff($_POST['tik_arrays'], array(''));
                $tik_arrays = implode(",", $_POST['tik_arrays']);
            }
            
            $all_tiks = $tik_arrays;
            
            //*/
            //die;print_r($str);
            //die;
            DB::insert('join_ticket',array(
                'tikets',
                'status',
                'date',
                'valute',
                'lang',
                'full_price',
                'pincod',
                'sysuser_id'
            ))->values(array(
                $all_tiks,
                0,
                date('Y-m-d H:i:s'),
                $_POST['valute'],
                $_POST['lang'],
                $_POST['full_price'],
                $this->random_pass(10),
                $ses[0]['id']
            ))->execute();
        }
        
	}
    
    
    public function action_ajax_svitgo_schema_click_bizi() {   
        if($_POST){
            
            $tik_id = $_POST['id'];
            $data = array();
            $data['id'] = $tik_id;
            //echo 'ok';
            //die;
            echo View::factory('bus/bizi_block_for_svitgo_schema',$data);
            die;
        } 
	}   
    
    public function action_ajax_get_ticket_history() {   
        if($_POST){
            $tik_id = $_POST['id'];
            $data = array();
            $data['id'] = $tik_id;
            echo View::factory('tiket/ticket_history/list',$data);
            die;
        } 
	}  
    
    
    
} // End Admin
