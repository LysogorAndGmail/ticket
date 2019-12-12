<?php defined('SYSPATH') or die('No direct script access.');

class Model_TiketMod extends Model {
    
    public function block_all($bus_id,$ferry_id){
        $res = DB::select()->from('routeblockedbuses')
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->execute()->as_array();
        return $res;
    }
    
        public function sell_plase($route_id,$date,$bus_id,$ferry_id,$city_from,$city_to) {
          
          $city_weight_from = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_from)->and_where('route_type_id','=',1)->execute()->current();
          $sell_from = $city_weight_from['weight'];
          
          $city_weight_to = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_to)->and_where('route_type_id','=',1)->execute()->current();
          $sell_to = $city_weight_to['weight'];

            //если не пересекает сутку
            
            
            $res = DB::select()->from('ticket')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_date','=',$date)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('ticket_type_id','=',1)
            ->execute()->as_array();
            
            
            //echo $date;
            
            //echo '<pre>';
            //print_r($res);
            //echo '</pre>';    
            //die;
            
            $all_plase = array();
            foreach ($res as $fg){
                $city_info_from = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_from_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_from = $city_info_from['weight'];
                $city_info_to = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_to_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_to = $city_info_to['weight'];
                
                $vv['value'] = $fg['value'];
                
                if(($sell_from < $tiket_from && $sell_to <= $tiket_from) || ($sell_from >= $tiket_to && $sell_to > $tiket_to)){
                        
                }else{
                    $all_plase[] = $vv;
                }
            }
            
        return $all_plase;
    }
    
    
    public function sell_plase_api($route_id,$date,$bus_id,$ferry_id,$city_from,$city_to) {
          
          $city_weight_from = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_from)->and_where('route_type_id','=',1)->execute()->current();
          $sell_from = $city_weight_from['weight'];
          
          $city_weight_to = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_to)->and_where('route_type_id','=',1)->execute()->current();
          $sell_to = $city_weight_to['weight'];

            //если не пересекает сутку
            
            $d = new DateTime($date);
            $d->modify("+1 day");
            $date2 = $d->format("Y-m-d");
            
            
            $d = new DateTime($date);
            $d->modify("-1 day");
            $date3 = $d->format("Y-m-d");
            
            
            $res = DB::select()->from('ticket')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_date','in',array($date,$date2,$date3))
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('ticket_type_id','in',array(1,2))
            ->execute()->as_array();
            
            
            //echo $date;
            
            //echo '<pre>';
            //print_r($res);
            //echo '</pre>';
            //die;
            
            $all_plase = array();
            foreach ($res as $fg){
                $city_info_from = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_from_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_from = $city_info_from['weight'];
                $city_info_to = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_to_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_to = $city_info_to['weight'];
                
                $vv['value'] = $fg['value'];
                
                if(($sell_from < $tiket_from && $sell_to <= $tiket_from) || ($sell_from >= $tiket_to && $sell_to > $tiket_to)){
                        
                }else{
                    $all_plase[] = $vv;
                }
            }
            
        return $all_plase;
    }
    
    public function reserv_plase($route_id,$date,$bus_id,$ferry_id,$city_from,$city_to) {
          
          $city_weight_from = DB::select('weight')->from('route')->where('route_id','=',$route_id)->and_where('route_city_id','=',$city_from)->and_where('route_type_id','=',1)->execute()->current();
          $city_weight_from = $city_weight_from['weight'];
          
          $city_weight_to = DB::select('weight')->from('route')->where('route_id','=',$route_id)->and_where('route_city_id','=',$city_to)->and_where('route_type_id','=',1)->execute()->current();
          $city_weight_to = $city_weight_to['weight'];
          
          $all_city_route = DB::select()->from('route')->join('routeweek')->on('route.r_id','=','routeweek.r_id')->where('route.route_id','=',$route_id)->and_where('route.route_type_id','=',1)->and_where('routeweek.week_id','=',0)->execute()->as_array();
          $day = 0;
          foreach($all_city_route as $rr){
                if($rr['days'] == 1 || $rr['a_days'] == 1){
                    $day = 1;
                }
          }

            //если не пересекает сутку
            $res = DB::select()->from('ticket')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_date','=',$date)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('ticket_type_id','=',2)
            ->execute()->as_array();
            
           
            
            
            $all_plase = array();
            foreach ($res as $fg){
                $city_info_from = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_from_id'])->and_where('route_type_id','=',1)->execute()->current();
                $vv['weight_from'] = $city_info_from['weight'];
                $city_info_to = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_to_id'])->and_where('route_type_id','=',1)->execute()->current();
                $vv['weight_to'] = $city_info_to['weight'];
                
                $vv['value'] = $fg['value'];
                
                //if($vv['weight_from'] >= $city_weight_from && $vv['weight_to'] >= $city_weight_from) {
                //    if($vv['weight_from'] < $city_weight_to && $vv['weight_to'] < $city_weight_to)
                    $all_plase[] = $vv;
                //}
            }
            // print_r($all_plase);
            //die;
        return $all_plase;
    }
    
    public function null_plase($route_id,$date,$bus_id,$ferry_id,$city_from,$city_to) {
          
          $city_weight_from = DB::select('weight')->from('route')->where('route_id','=',$route_id)->and_where('route_city_id','=',$city_from)->and_where('route_type_id','=',1)->execute()->current();
          $city_weight_from = $city_weight_from['weight'];
          
          $city_weight_to = DB::select('weight')->from('route')->where('route_id','=',$route_id)->and_where('route_city_id','=',$city_to)->and_where('route_type_id','=',1)->execute()->current();
          $city_weight_to = $city_weight_to['weight'];
          
          $all_city_route = DB::select()->from('route')->join('routeweek')->on('route.r_id','=','routeweek.r_id')->where('route.route_id','=',$route_id)->and_where('route.route_type_id','=',1)->and_where('routeweek.week_id','=',0)->execute()->as_array();
          $day = 0;
          foreach($all_city_route as $rr){
                if($rr['days'] == 1 || $rr['a_days'] == 1){
                    $day = 1;
                }
          }

            //если не пересекает сутку
            $res = DB::select()->from('ticket')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_date','=',$date)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('ticket_type_id','=',3)
            ->execute()->as_array();
            
           
            
            
            $all_plase = array();
            foreach ($res as $fg){
                $city_info_from = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_from_id'])->and_where('route_type_id','=',1)->execute()->current();
                $vv['weight_from'] = $city_info_from['weight'];
                $city_info_to = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_to_id'])->and_where('route_type_id','=',1)->execute()->current();
                $vv['weight_to'] = $city_info_to['weight'];
                
                $vv['value'] = $fg['value'];
                
                //if($vv['weight_from'] >= $city_weight_from && $vv['weight_to'] >= $city_weight_from) {
                //    if($vv['weight_from'] < $city_weight_to && $vv['weight_to'] < $city_weight_to)
                    $all_plase[] = $vv;
                //}
            }
            // print_r($all_plase);
            //die;
        return $all_plase;
    }
    
    public function block_plase($route_id,$bus_id,$ferry_id,$city_from,$city_to,$date) {
          
            //если не пересекает сутку
            //echo $route_id;
            //die;
            
            $res = DB::select('value')->from('routeblocked')
            ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
            ->where('routeblocked.route_name_id','=',$route_id)
            ->and_where('route_city_id','=',$city_from)
            ->and_where('route_city_to_id','=',$city_to)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('block_date','=',$date)
            //->limit(1)
            ->execute()->as_array();
            
            //////////// sell
            
            $city_weight_from = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_from)->and_where('route_type_id','=',1)->execute()->current();
          $sell_from = $city_weight_from['weight'];
          
          $city_weight_to = DB::select('weight')->from('route')->where('route_name_id','=',$route_id)->and_where('route_city_id','=',$city_to)->and_where('route_type_id','=',1)->execute()->current();
          $sell_to = $city_weight_to['weight'];

            //если не пересекает сутку
            $res = DB::select('routeblocked.route_name_id','route_city_id','route_city_to_id','value','name')->from('routeblocked')
            ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
            ->where('routeblocked.route_name_id','=',$route_id)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('block_date','=',$date)
            //->limit(1)
            ->execute()->as_array();
            
            
            //print_r($res);
            //die;
            
            //echo '<pre>';
            //print_r($res);
            //echo '</pre>';


            $all_plase = array();
            foreach ($res as $fg){
                $city_info_from = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_from = $city_info_from['weight'];
                $city_info_to = DB::select('weight')->from('route')->where('route_name_id','=',$fg['route_name_id'])->and_where('route_city_id','=',$fg['route_city_to_id'])->and_where('route_type_id','=',1)->execute()->current();
                $tiket_to = $city_info_to['weight'];
                
                $vv['value'] = $fg['value'];
                
                if(($sell_from < $tiket_from && $sell_to <= $tiket_from) || ($sell_from >= $tiket_to && $sell_to > $tiket_to)){
                        
                }else{
                    $all_plase[] = $vv;
                }
            }
            
        
            
            //////////// end sell
            //echo '<pre>';
            //print_r($all_plase);
            //echo '</pre>';
            //die;
            
          return $all_plase;
        //return $res;
    }
    
    public function block_plase_one($plase,$route_id,$bus_id,$ferry_id,$city_from,$city_to) {
          
            //если не пересекает сутку
            //echo $route_id;
            //die;
            
            $res = DB::select()->from('routeblocked')
            ->join('routeblockedbuses')->on('routeblocked.route_blocked_id','=','routeblockedbuses.route_blocked_id')
            ->where('routeblocked.route_name_id','=',$route_id)
            ->and_where('route_city_id','=',$city_from)
            ->and_where('route_city_to_id','=',$city_to)
            ->and_where('ferryman_id','=',$ferry_id)
            ->and_where('buses_id','=',$bus_id)
            ->and_where('value','=',$plase)
            ->execute()->current();
            
            
            //echo '<pre>';
            //print_r($res);
            //echo '</pre>';
            //die;
          
        return $res;
    }
    
    public function get_fer_proc($rou_dat,$sel_dat,$fer_id){
        //echo $rou_dat;
        $chen = $rou_dat - $sel_dat;
        $val = round($chen/3600);
        $al_ferry_proc = DB::select()->from('ticket_null')->where('ferryman_id','=',$fer_id)->order_by('hours')->execute()->as_array();
        $main_proc = 0;
        
        if(!empty($al_ferry_proc)){
            $hour_start = 0;
            foreach($al_ferry_proc as $al_proc){
                if(($hour_start <= $val) && ($val <=$al_proc['hours']) ){
                    $main_proc = $al_proc['procents'];
                    break;
                }
            }
        }
        
        //echo $val.'<br />';
        
        //echo '<pre>';
        //print_r($al_ferry_proc);
        //echo '</pre>';
        //die;
        return $main_proc;
    }
    
    public function dataciper($lang){
        
        switch($lang){
        case "ru":
            echo 'monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авгу", "Сент", "Окт", "Ноя", "Дек" ],
            monthNames:[ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
            //gotoCurrent: true,
            dayNamesMin: [ "Вос" , "Пон", "Вто", "Сре", "Чет", "Пят", "Суб",  ],';
        break; 
        case "uk":
            echo 'monthNamesShort: [ "Січ", "Лют", "Бер", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру" ],
            monthNames:[ "Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень" ],
            //gotoCurrent: true,
            dayNamesMin: [ "Нд" , "Пн", "Вт", "Ср", "Чт", "Пт", "Сб",  ],';
        break;  
		
		   case "cs":
            echo 'monthNamesShort: [ "Січ", "Лют", "Бер", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру" ],
            monthNames:[ "Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec" ],
            ///gotoCurrent: true,
            dayNamesMin: [ "Ne" , "Po", "Ut", "St", "Čt", "Pa", "So",  ],';
        break;   
        }
        
    }
    
    function mb_ucfirst($str, $enc = 'utf-8') { 
        return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
    
    public function order_array($array,$sort_by) {
        switch($sort_by) {
            case 'valute':
            foreach($array as $arr) {
                $new['valute'][] = $arr['valute'];
            }
            array_multisort($new['valute'], constant('SORT_ASC'), $array);
            break;
        }
        return $array;
    }
    public function order_array_desc($array,$sort_by) {
        switch($sort_by) {
            case 'weight':
            foreach($array as $arr) {
                $new['weight'][] = $arr['weight'];
            }
            array_multisort($new['weight'], constant('SORT_DESC'), $array);
            break;
        }
        return $array;
    }
    
    public function blacklist(){
        $all = DB::select()->from('system_users_blacklist')->execute()->as_array();
        $string = '';
        foreach($all as $a){
            $string .= "|| $(this).val() == '".$a['tel']."'";
        }
        echo $string;
    }
    
    
    public function showphone($client_id,$sesuser_id){
        $sysus_full = DB::select()->from('system_users')->where('id','=',$sesuser_id)->execute()->current();
        $group = DB::select()->from('groups')->where('id','=',$sysus_full['group_id'])->execute()->current();
        if($group['see_clients_phone'] == 1){
            $check = 1;
        }else{

            $data = array();
            $al_tik = DB::select(array('client_id','id'),'name','soname','count_trip','tel','ticket_people.date','old_tickets')->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')->where('user_id','=',$sesuser_id)->execute()->as_array();
            $new = array();
            foreach($al_tik as $tik){
                $new[$tik['name'].$tik['soname']] = $tik;
            }
            $al_create = DB::select()->from('ticket_people')->where('sysuser_create_id','=',$sesuser_id)->execute()->as_array();
            $new2 = array();
            foreach($al_create as $old_tik){
                $new2[$old_tik['name'].$old_tik['soname']] = $old_tik;
            }
            $newnew = $new2 + $new;
            $check = 0;
            foreach($newnew as $n){
                if($n['id'] == $client_id){
                    $check = 1;
                }
            }
        }
        return $check;
    }
    
     public function showphone_for_tel($client_id,$sesuser_id){
            $sysus_full = DB::select()->from('system_users')->where('id','=',$sesuser_id)->execute()->current();
            $data = array();
            $al_tik = DB::select(array('client_id','id'),'name','soname','count_trip','tel','ticket_people.date','old_tickets')->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')->where('user_id','=',$sesuser_id)->execute()->as_array();
            $new = array();
            foreach($al_tik as $tik){
                $new[$tik['name'].$tik['soname']] = $tik;
            }
            $al_create = DB::select()->from('ticket_people')->where('sysuser_create_id','=',$sesuser_id)->execute()->as_array();
            $new2 = array();
            foreach($al_create as $old_tik){
                $new2[$old_tik['name'].$old_tik['soname']] = $old_tik;
            }
            $newnew = $new2 + $new;
            $check = 0;
            foreach($newnew as $n){
                if($n['id'] == $client_id){
                    $check = 1;
                }
            }
        return $check;
    }
    
    public function get_info_ved3($route_name_id,$date,$type,$valute){
        $info = DB::select()->from('vedomost3')->where('route_name_id','=',$route_name_id)->and_where('date','=',$date)->and_where('type','=',$type)->and_where('valute','=',$valute)->execute()->current();  
        return $info;
    }
    
    
    public function get_date_to($date,$route,$time_from,$time_to,$from,$to){
        //if($_POST) {
            //print_r($_POST);
                $n_d = $date;
                $n_d_full = $date.' 00:00:01';
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }     
                     
                $rice = 1;
                //echo $day_week;
                //die;     
                     
                     
                $city_from = DB::select()->from('route')->where('route_name_id','=',$route)->and_where('route_city_id','=',$from)->execute()->current();
                $city_to = DB::select()->from('route')->where('route_name_id','=',$route)->and_where('route_city_id','=',$to)->execute()->current();
                //////////new dey
               
                $all_ost = DB::select('r_id','weight')->from('route')->where('route_name_id','=',$route)->and_where('weight','BETWEEN',array($city_from['weight'],$city_to['weight']))->order_by('weight','ASC')->execute()->as_array();
                //echo count($all_ost);
                
                $new = array();
                
                foreach($all_ost as $ost){
                    $arive = DB::select('hours','a_hours')->from('routeweek')->where('route_name_id','=',$route)->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
                    $ost['pribitie'] = $arive['a_hours'];
                    $ost['otpravka'] = $arive['hours'];
                    $ost['pribitie_secund'] = strtotime( '2014-01-01 '.$arive['a_hours'].':00');
                    $ost['otpravka_secund'] = strtotime( '2014-01-01 '.$arive['hours'].':00');
                    //$arive_to = DB::select('a_hours')->from('routeweek')->where('route_name_id','=',1590)->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',0)->and_where('rice','=',1)->execute()->current();
                    if(!empty($ost['pribitie']) || !empty($ost['otpravka'])){
                        $new[] = $ost;
                    }
                    
                }
                
                
                
               //$date_chek_from = strtotime($n_d.$time_from['hours']);
               //$date_chek_to = strtotime($n_d.$time_to['a_hours']);
               $da_end = date('d/m/Y',strtotime($n_d_full));
               $da_end_next = date('d/m/Y',strtotime($n_d_full));
                
                $start = 0;
                $day = 0;
                
                //echo '<pre>';
                //print_r($new);
                //echo '</pre>';
                //die;
                
                for($i = 0; $i<count($new); $i++){
                    $start = $new[$i]['pribitie_secund'];
                    if(isset($new[$i+1]['pribitie_secund'])){
                        $start_next = $new[$i+1]['pribitie_secund'];
                        if($start > $start_next){
                            //echo $n['weight'];
                            $day += 1; 
                        }
                    }
                    
                    //echo $new[$i]['pribitie'].'<br />';
                    //echo $new[$i]['pribitie_secund'].'<br />';
                    //echo $new[$i]['weight'].'<br />';
                }
                
               if($day != 0){
                    $da_end_next = date('d/m/Y',strtotime($n_d. ' + '.$day.' day')); 
               }
               
               
               //if($date_chek_to < $date_chek_from){
                   
               //}
               //echo $day_week;
              ///*
              //echo '<pre>';
              //print_r($da_end_next);
              //echo '</pre>';
              //*/
              //die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              //$data = array();
              //$data['new_all'] = $new_all;
              //$data['info'] = $main_info;
              //$data['from'] = $_POST['from'];
              //$data['to'] = $_POST['to'];
              //$farryman_name = DB::select()->from('ferryman')->where('ferryman_id','=',$main_info['ferryman_id'])->execute()->current();
              echo $da_end_next;
          //  die;
         //}
    }
    
    
    public function order_array_all($array,$sort_by,$asc) {
        if(!empty($array)){
             foreach($array as $arr) {
            $new[$sort_by][] = $arr[$sort_by];
            }
            array_multisort($new[$sort_by], constant($asc), $array);
        }
       
        return $array;
    }
    
    public function old_disp($svitgo_route,$from,$to,$date){
        $soap = new SoapClient("http://onlineregabus.cz/soap.wsdl"); 
        $status = $soap->soap_login('soap-api', 111111); 
        $route = new stdClass();
    
        //$svitgo_from = 883;
        //$svitgo_to = 888;
        
        // = 888;
        // = 883;
        //$old_route = '';
        
        $reg_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$svitgo_route)->execute()->current();
        
        $reg_ost_from = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$from)->execute()->current();
        
        $reg_ost_to = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)->execute()->current();
        
        $diffrent = array();
        
        if(!empty($reg_route) && !empty($reg_ost_from) && !empty($reg_ost_to)){
            
        
        
        $route->route_id = $reg_route['reg_route_id'];
        $route->from_id = $reg_ost_from['reg_ost_id'];//23;
        $route->to_id = $reg_ost_to['reg_ost_id'];//31;
        $route->date = $date;
        
        
        
        $r = $soap->soap_route($route); 
        $all_old_free = array();
        $all_old_free = $r[0]->free_seat;
            //
        /*
        echo '<pre>';
        print_r($svitgo_route);
        print_r($from);
        print_r($to);
        print_r($date);
        echo '</pre>';
        
        echo '<pre>';
        print_r($reg_route['reg_route_id']);
        print_r($reg_ost_from['reg_ost_id']);
        print_r($reg_ost_to['reg_ost_id']);
        echo '</pre>';
        */
        $plase = 63;
        $schema_arr = array();
        for($i = 1;$i<=$plase;$i++){
            $schema_arr[] = $i;
        }
        
        if(!empty($schema_arr) && !empty($all_old_free)){
            $diffrent = array_diff($schema_arr,$all_old_free);
        }
        
        
        //$bizi_plase = array();
        //foreach($schema_arr as $allnew){
        //    foreach($all_old_free as $oldnew){
        //        if($allnew != $oldnew){
        //            $bizi_plase[] = $allnew;
        //        }
        //    }
        //}
        
        //die;
        //echo '<pre>';
        //print_r($all_old_free);
        //echo '</pre>';
        //die;
        }
        return $diffrent;
        //echo '<pre>';
        //print_r($diffrent);
        //echo '</pre>';
        //die;
        
        
        //print_r();
    }
    
    function get_order($tik_id){
        $all_orders = DB::select()->from('join_ticket')->execute()->as_array();
        $order = '';
        foreach($all_orders as $one){
            $tiks = explode(',',$one['tikets']);
            foreach($tiks as $tik){
                if($tik == $tik_id){
                    $order = $one['id']; 
                }
            }
        }
        return $order;
    }
    
    public function get_ost($ost_id,$lang) {
            $res = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->where('routecity.route_city_id','=',$ost_id)->and_where('routecity_i18n.culture','=',$lang)->execute()->current();
        return $res;
        
    }
    
    public function search_all_route_new($from,$to,$date_new,$day_week,$rice,$lang) {
        
        $all_routes = array();
        
        $all_parents = array();
        
       
        
        $all_simple = array();
        
        $al_from = array();
        
        foreach($from as $f) {
            $res = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id','routename.is_public','routename.parent','routename.start_from','routename.start_from')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$f['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_from[] = $res;    
        }
        
         
        
        $al_to = array();
        foreach($to as $t) {
            $res_to = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$t['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_to[] = $res_to;
            
        } 
        
        /*
        echo '<pre>';
        print_r($from);
        echo '</pre>';
        echo '<pre>';
        print_r($to);
        echo '</pre>';
        die; 
         */       
        foreach($al_from as $a_f) {
            foreach($a_f as $f_last) {
                foreach($al_to as $a_t) {
                    foreach($a_t as $t_last) {
                        if($f_last['route_name_id'] == $t_last['route_name_id'] && $f_last['types'] == $t_last['types'] && $f_last['weight'] < $t_last['weight']){
                            ///*
                            
                            
                            
                            //*/  
                            $ch_rice = $this->chek_rice($f_last['route_name_id'],$date_new);
                            if(!empty($ch_rice)){
                                $ne[0] = $ch_rice;
                                $ne[1] = $f_last;
                                $ne[2] = $t_last;
                                $all_routes[$f_last['route_name_id']] = $ne;
                            }
                            
                            ////
                            //$ch_parr = $day = DB::select()->from('RouteName')->where('route_name_id','=',$f_last['route_name_id'])->and_where('RouteFerrymanWeek.date','=',$date_new)->and_where('RouteFerrymanWeek.route_type_id','=',$f_last['route_type_id'])->and_where('RouteFerrymanWeek.rice','=',1)->execute()->current();
                            //if(!empty($f_last['parent'])){
                            ///    $all_parents[] = array($f_last,$t_last);
                            //}
                            ////
                            $day = DB::select('date','ferryman_id','buses_id','rice','route_name_id')->distinct(true)->from('routeferrymanweek')->where('route_name_id','=',$f_last['route_name_id'])->and_where('routeferrymanweek.date','=',$date_new)
                            ->and_where('routeferrymanweek.route_type_id','=',$f_last['types'])
                            ->and_where('routeferrymanweek.rice','=',$rice)->execute()->current();
                            
                            
                            ///*
                           
                            $date_st = strtotime($date_new.' 00:00:00');
                            $date_start_from = strtotime($f_last['start_from'].' 00:00:00');
                            
                            
                            
                            if($f_last['route_name_id']){
                                //$simple_test[] = $f_last['route_name_id'];
                            //    echo '<pre>';
                            //print_r($f_last['route_name_id']);
                            //echo '</pre>';
                            //die;
                                if(!empty($day)){

                                    $time_from = DB::select('time','hours')->distinct(true)->from('routeweek')->where('r_id','=',$f_last['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
                                    $time_to = DB::select('a_time','a_hours')->distinct(true)->from('routeweek')->where('r_id','=',$t_last['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
 
                                    if(!empty($time_from['time']) && !empty($time_to['a_time'])){
                                        
                                   
                                     
                                     
                                        $re['from'] = $f_last;
                                        $ost_from_name = Model::factory('OstMod')->get_ost($f_last['route_city_id'],$lang);
                                        $ost_to_name = Model::factory('OstMod')->get_ost($t_last['route_city_id'],$lang);
                                        $re['from']['city_name_from'] = $ost_from_name['city_i18n'];
                                        $re['from']['stop_name_from'] = $ost_from_name['name_i18n'];
                                        $re['from']['time'] = $time_from['time'];
                                        $re['from']['hours'] = $time_from['hours'];
                                        $re['from']['date'] = $day['date'];
                                        $re['from']['ferryman_id'] = $day['ferryman_id'];
                                        $ferr = DB::select()->from('ferryman')->where('ferryman_id','=',$day['ferryman_id'])->execute()->current();
                                        $re['from']['buses_id'] = $day['buses_id'];
                                        $re['from']['platform'] =  DB::select('value')->from('platform')->where('route_name_id','=',$f_last['route_name_id'])->and_where('ost_id','=',$f_last['route_city_id'])->and_where('day_week','=',$day_week)->execute()->current();
                                        $re['to'] = $t_last;
                                        $re['to']['city_name_to'] = $ost_to_name['city_i18n'];
                                        $re['to']['stop_name_to'] = $ost_to_name['name_i18n'];
                                        $re['to']['a_time'] = $time_to['a_time'];
                                        $re['to']['a_hours'] = $time_to['a_hours'];
                                        $d_f = strtotime($day['date'].' '.$time_from['time']);
                                        $d_t = strtotime($day['date'].' '.$time_to['a_time']);
                                        
                                        
                                        
                                        $re['to']['end_date'] = $day['date'];
                                        $re['otpravka_sort'] =  $time_from['hours'];
                                        $re['to']['platform'] =  DB::select('value')->from('platform')->where('route_name_id','=',$t_last['route_name_id'])->and_where('ost_id','=',$t_last['route_city_id'])->and_where('day_week','=',$day_week)->execute()->current();
                                        $re['alien'] = 0;
                                        $re['rice'] = $rice;
                                        $re['day_week'] = $day_week;
                                        $re['ferryman_name'] = $ferr['name'];
                                        $re['route_name'] = DB::select('name')->from('routename')->where('route_name_id','=',$t_last['route_name_id'])->execute()->current();
                                        $chak_day = $this->check_day($t_last['route_name_id'],$day_week,$f_last,$t_last,$day['date'],$rice);
                                        if($chak_day === 1){
                                            $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*24);
                                        }
                                        if($chak_day === 2){
                                            $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*48);
                                        }
                                        
                                        
                                        
                                        $bizi = $this->block_plase($t_last['route_name_id'],$day['date'],$day['buses_id'],$day['ferryman_id'],$f_last['route_city_id'],$t_last['route_city_id']);// 
                                        
                                        $sell_array = $this->sell_plase($t_last['route_name_id'],$day['date'],$day['buses_id'],$day['ferryman_id'],$f_last['route_city_id'],$t_last['route_city_id']);
                                        
                                        $sell = array();
                                        foreach($sell_array as $tes=>$vall){
                                            $sell[] = $vall['value'];   
                                        }
                                                                    //$bizi = count(Model::factory('TiketMod')->block_plase($arr['from']['route_name_id'],$arr['from']['date'],$arr['from']['buses_id'],$arr['from']['ferryman_id'],$arr['from']['route_city_id'],$arr['to']['route_city_id']));//       
                                        $bus = DB::select()->from('buses')->where('buses_id','=',$day['buses_id'])->execute()->current();
                                        
                                        $bus_schema = DB::select()->from('bscheme')->where('schema_name','=',$bus['schema_name'])->execute()->as_array();
                                        
                                        //$free_plases = count($bus_schema) - count($bizi);
                                        
                                        $bus_schema_name = $bus['schema_name'];
                                        
                                        ///
                                        $al_plase = DB::query(Database::SELECT, "SELECT * FROM bscheme WHERE schema_name LIKE '$bus_schema_name'")->execute()->as_array();
                                        $cou_plases = 0;
                                        $all_free_plases = array();
                                        foreach($al_plase as $pl){
                                            if(is_numeric($pl['value']) === true){
                                                $cou_plases++;
                                                $all_free_plases[] = $pl['value'];
                                            }
                                        }
                                       
                                       $all_free_plases = array_reverse($all_free_plases); 
                                        
                                       $re['all_free_plases'] = array_diff($all_free_plases,$sell); 
                                        
                                       $re['free_plases'] = $cou_plases - count($sell);//count(DB::select()->from('BScheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
                                       
                                       $re['route_price'] = DB::select('price','valute')->from('routeprice')->where('route_city_from_id','=',$f_last['route_city_id'])->and_where('route_city_to_id','=',$t_last['route_city_id'])->and_where('route_name_id','=',$f_last['route_name_id'])->execute()->as_array();

                                       //$re['ferryman_discounts'] = DB::select('tickerdiscount.ticker_discount_id','value','name_i18n','name_simple_i18n')->from('tickerdiscount')->join('tickerdiscount_i18n')->on('tickerdiscount.ticker_discount_id','=','tickerdiscount_i18n.ticker_discount_id')->where('ferryman_id','=',$day['ferryman_id'])->and_where('culture','=','ru')->execute()->as_array();
                                       
                                      
                                       $all_simple[] = $re;
                                       
                                       //print_r($all_simple);
                                      
                                 
                                       
                                    }
                                }
                            } 
                        }    
                    }
                } 
            }
        } 
        
                                       
        
        //////////////////////////////////
        //echo '<pre>';
        //           print_r($all_simple);
        //           echo '</pre>';
        //            die;
        
        $al_ro = array();
        foreach($all_routes as $ar=>$ro){
            foreach($ro[0] as $rice){
                $day = DB::select('date','ferryman_id','buses_id','rice')->distinct(true)->from('routeferrymanweek')
                    ->where('route_name_id','=',$ar)->and_where('routeferrymanweek.date','=',$date_new)
                    ->and_where('routeferrymanweek.route_type_id','=',$ro[1]['types'])
                    ->and_where('routeferrymanweek.rice','=',$rice)
                    ->execute()->current();              
                //echo '<pre>';
                //print_r($ro);
                //echo '</pre>';
                //die;
                if(!empty($day)){
                    $time_from = DB::select('time','hours')->distinct(true)->from('routeweek')->where('r_id','=',$ro[1]['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
                    $time_to = DB::select('a_time','a_hours')->distinct(true)->from('routeweek')->where('r_id','=',$ro[2]['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
                    
                    if(!empty($time_from['time']) && !empty($time_to['a_time'])){
                    $re['from'] = $ro[1];
                    $re['from']['time'] = $time_from['time'];
                    $re['from']['hours'] = $time_from['hours'];
                    $re['from']['date'] = $day['date'];
                    $re['from']['ferryman_id'] = $day['ferryman_id'];
                    $re['from']['buses_id'] = $day['buses_id'];
                    $re['to'] = $ro[2];
                    $re['to']['a_time'] = $time_to['a_time'];
                    $re['to']['a_hours'] = $time_to['a_hours'];
                    $d_f = strtotime($day['date'].' '.$time_from['time']);
                    $d_t = strtotime($day['date'].' '.$time_to['a_time']);
                    $re['to']['end_date'] = $day['date'];
                    $re['otpravka_sort'] =  $time_from['hours'];
                    $re['alien'] = 0;
                    $chak_day = $this->check_day($ro[2]['route_name_id'],$day_week,$ro[1],$ro[2],$day['date'],$rice);
                    if($chak_day === 1){
                    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*24);
                    }
                    if($chak_day === 2){
                    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*48);
                    }
                    
                    //$bizi = count(Model::factory('Tiket')->block_plase($ro[2]['route_id'],$day['date'],$day['buses_id'],$day['ferryman_id'],$ro[1]['route_city_id'],$ro[2]['route_city_id']));// 
                    
                    $re['free_plases'] = array();//count(DB::select()->from('bscheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
                    
                    $re['route_price'] = DB::select('price','value')->from('routeprice')->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')->where('route_city_from_id','=',$ro[1]['route_city_id'])->and_where('route_city_to_id','=',$ro[2]['route_city_id'])->and_where('route_name_id','=',$ro[1]['route_id'])->execute()->current();
                    
                    $re['ferryman_discounts'] = DB::select('tickerdiscount.ticker_discount_id','value','name_i18n','name_simple_i18n')->from('tickerdiscount')->join('tickerdiscount_i18n')->on('tickerdiscount.ticker_discount_id','=','tickerdiscount_i18n.ticker_discount_id')->where('ferryman_id','=',$day['ferryman_id'])->and_where('culture','=','ru')->execute()->as_array();
                    
                    $al_ro[] = $re;
                    }
                } 
            }
        }
        //////////////////////////////////
        //echo '<pre>';
        //print_r($all_simple);
        //echo '</pre>';
        //die;
        //////////////////////////////////
        
        $al_par = array();
        foreach($all_parents as $par){
                //$date_new 
                $day_search = strtotime($date_new.' 00:00:00'); 
                $str_from = strtotime($par[0]['start_from'].' 00:00:00');
                if($day_search >= $str_from){
                    $one = DB::select('r_id','route.route_name_id','route.weight','route.route_type_id','route.route_city_id','route.route_id','routename.is_public','routename.parent','routename.start_from')->distinct(true)->from('route')
                    ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
                    where('route.route_city_id','=',$par[0]['route_city_id'])->
                    and_where('routename.route_name_id','=',$par[0]['parent'])->
                    execute()->current();
                    $thu = DB::select('r_id','route.route_name_id','route.weight','route.route_type_id','route.route_city_id','route.route_id','routename.is_public','routename.parent','routename.start_from')->distinct(true)->from('route')
                    ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
                    where('route.route_city_id','=',$par[1]['route_city_id'])->
                    and_where('routename.route_name_id','=',$par[0]['parent'])->
                    execute()->current();
                    $al_par[$par[0]['parent']] = array($one,$thu);
                }
                //echo '<pre>';
                //print_r($day_search);
               
        }
        $clean_par = array();
        foreach($al_par as $ar=>$ro){
                $day = DB::select('date','ferryman_id','buses_id','rice')->distinct(true)->from('routeferrymanweek')->where('route_name_id','=',$ar)->and_where('routeferrymanweek.date','=',$date_new)->and_where('routeferrymanweek.route_type_id','=',$ro[0]['route_type_id'])->execute()->current();              
                    //echo '<pre>';
                    //print_r($);
                    //echo '</pre>';
                    //die;
                if(!empty($day)){
                    $time_from = DB::select('time','hours')->distinct(true)->from('routeweek')->where('r_id','=',$ro[0]['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',1)->execute()->current();
                    $time_to = DB::select('a_time','a_hours')->distinct(true)->from('routeweek')->where('r_id','=',$ro[1]['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',1)->execute()->current();
                    
                    if(!empty($time_from['time']) && !empty($time_to['a_time'])){
                    $re['from'] = $ro[0];
                    $re['from']['time'] = $time_from['time'];
                    $re['from']['hours'] = $time_from['hours'];
                    $re['from']['date'] = $day['date'];
                    $re['from']['ferryman_id'] = $day['ferryman_id'];
                    $re['from']['buses_id'] = $day['buses_id'];
                    $re['to'] = $ro[1];
                    $re['to']['a_time'] = $time_to['a_time'];
                    $re['to']['a_hours'] = $time_to['a_hours'];
                    $d_f = strtotime($day['date'].' '.$time_from['time']);
                    $d_t = strtotime($day['date'].' '.$time_to['a_time']);
                    $re['to']['end_date'] = $day['date'];
                    $re['otpravka_sort'] =  $time_from['hours'];
                    $re['alien'] = 0;
                    $chak_day = $this->check_day($ro[1]['route_name_id'],$day_week,$ro[0],$ro[1],$day['date'],1);
                    if($chak_day === 1){
                    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*24);
                    }
                    if($chak_day === 2){
                    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*48);
                    }
                    
                    //$bizi = count(Model::factory('Tiket')->block_plase($ro[1]['route_id'],$day['date'],$day['buses_id'],$day['ferryman_id'],$ro[0]['route_city_id'],$ro[1]['route_city_id']));// 
                    
                    $re['free_plases'] = array();//count(DB::select()->from('bscheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
                    
                    $re['route_price'] = DB::select('price','value')->from('routeprice')->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')->where('route_city_from_id','=',$ro[0]['route_city_id'])->and_where('route_city_to_id','=',$ro[1]['route_city_id'])->and_where('route_id','=',$ro[0]['route_id'])->execute()->current();
                    
                    $re['ferryman_discounts'] = DB::select('tickerdiscount.ticker_discount_id','value','name_i18n','name_simple_i18n')->from('tickerdiscount')->join('tickerdiscount_i18n')->on('tickerdiscount.ticker_discount_id','=','tickerdiscount_i18n.ticker_discount_id')->where('ferryman_id','=',$day['ferryman_id'])->and_where('culture','=','ru')->execute()->as_array();
                    
                    $clean_par[] = $re;
                    }
                } 
        }
        
        //echo '<pre>';
        //print_r($all_routes);
        //echo '</pre>';
        //echo '<pre>';
        //print_r($clean_par);
        //echo '</pre>';
        //die;
        //////////////////////////////////
        for ($x = 0; $x < count($clean_par); $x++)
        {
            array_push($all_simple, $clean_par[$x]);
        }
        
        for ($x = 0; $x < count($al_ro); $x++)
        {
            array_push($all_simple, $al_ro[$x]);
        }        

        return $all_simple;
    }
    
    
    public function search_all_route_new_open($from,$to) {
        
        $all_routes = array();
        
        $all_parents = array();
        
       
        
        $all_simple = array();
        
        $al_from = array();
        
        foreach($from as $f) {
            $res = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id','routename.is_public','routename.parent','routename.start_from','routename.start_from')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$f['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_from[] = $res;    
        }
        
         
        
        $al_to = array();
        foreach($to as $t) {
            $res_to = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$t['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_to[] = $res_to;
            
        } 
        
        /*
        echo '<pre>';
        print_r($from);
        echo '</pre>';
        echo '<pre>';
        print_r($to);
        echo '</pre>';
        die; 
         */       
        foreach($al_from as $a_f) {
            foreach($a_f as $f_last) {
                foreach($al_to as $a_t) {
                    foreach($a_t as $t_last) {
                        if($f_last['route_name_id'] == $t_last['route_name_id'] && $f_last['types'] == $t_last['types'] && $f_last['weight'] < $t_last['weight']){
                            ///*
                            
                            
                            
                            if($f_last['route_name_id']){
                                //$simple_test[] = $f_last['route_name_id'];
                           
                                
                                        $re['from'] = $f_last;
                                        $re['from']['time'] = '';//$time_from['time'];
                                        $re['from']['hours'] = '';//$time_from['hours'];
                                        $re['from']['date'] = '';//$day['date'];
                                        $re['from']['ferryman_id'] = '';//$day['ferryman_id'];
                                        $re['from']['buses_id'] = '';//$day['buses_id'];
                                        $re['from']['platform'] =  '';//DB::select()->from('platform')->where('route_name_id','=',$f_last['route_name_id'])->and_where('ost_id','=',$f_last['route_city_id'])->and_where('day_week','=',$day_week)->execute()->current();
                                        $re['to'] = $t_last;
                                        $re['to']['a_time'] = '';//$time_to['a_time'];
                                        $re['to']['a_hours'] = '';//$time_to['a_hours'];
                                        //$d_f = strtotime($day['date'].' '.$time_from['time']);
                                        //$d_t = strtotime($day['date'].' '.$time_to['a_time']);
                                        
                             
                                        
                                        $re['to']['end_date'] = '';//$day['date'];
                                        $re['otpravka_sort'] =  '';//$time_from['hours'];
                                        $re['to']['platform'] =  '';//DB::select()->from('platform')->where('route_name_id','=',$t_last['route_name_id'])->and_where('ost_id','=',$t_last['route_city_id'])->and_where('day_week','=',$day_week)->execute()->current();
                                        $re['alien'] = 0;
                                        $re['day_week'] = '';//$day_week;
                                        $re['route_name'] = DB::select('name')->from('routename')->where('route_name_id','=',$t_last['route_name_id'])->execute()->current();
                                        //$chak_day = $this->check_day($t_last['route_name_id'],$day_week,$f_last,$t_last,$day['date'],1);
                                        //if($chak_day === 1){
                                        //    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*24);
                                        //}
                                        //if($chak_day === 2){
                                        //    $re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*48);
                                        //}
                                        
                                        
                                        
                                       //$bizi = count(Model::factory('Tiket')->block_plase($t_last['route_id'],$day['date'],$day['buses_id'],$day['ferryman_id'],$f_last['route_city_id'],$t_last['route_city_id']));// 
                                        
                                        
                                        
                                       $re['free_plases'] = '';//count(DB::select()->from('BScheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
                                       
                                       $re['route_price'] = DB::select('price','valute')->from('routeprice')->where('route_city_from_id','=',$f_last['route_city_id'])->and_where('route_city_to_id','=',$t_last['route_city_id'])->and_where('route_name_id','=',$f_last['route_name_id'])->execute()->current();

                                       $re['ferryman_discounts'] = '';//DB::select('tickerdiscount.ticker_discount_id','value','name_i18n','name_simple_i18n')->from('tickerdiscount')->join('tickerdiscount_i18n')->on('tickerdiscount.ticker_discount_id','=','tickerdiscount_i18n.ticker_discount_id')->where('ferryman_id','=',$day['ferryman_id'])->and_where('culture','=','ru')->execute()->as_array();
                                       
                                      
                                       $all_simple[] = $re;
                                      
                                 
                                       
                                    
                               
                            } 
                        }    
                    }
                } 
            }
        } 
        
                                       
        
        //////////////////////////////////
        //echo '<pre>';
        //           print_r($all_simple);
        //           echo '</pre>';
        //            die;
        
       
        //print_r($all_simple);
        //echo '</pre>';
        //die;
        //////////////////////////////////
      

        return $all_simple;
    }
    
    
    function chek_rice($route_name_id,$date){
        $new = array();
        $ch = DB::select('rice')->from('routeferrymanweek')->where('route_name_id','=',$route_name_id)->and_where('date','=',$date)->execute()->as_array();
        foreach($ch as $c){
            if($c['rice'] != 1){
                $new[] = $c['rice'];
            }
        }
        return $new;
    }
    
    public function check_day($route_name_id,$week_id,$city_from,$city_to,$date,$rice){
        
        $res = DB::select('route.route_city_id','route.weight','a_time','time')->from('route')->join('routeweek')->on('route.r_id','=','routeweek.r_id')->where('week_id','=',$week_id)->and_where('route.route_name_id','=',$route_name_id)->and_where('routeweek.rice','=',$rice)->order_by('route.r_id','ASC')->execute()->as_array();
        $cec = 0;
        foreach($res as $r){
            if(($r['weight'] <= $city_to['weight']) &&($r['weight'] >= $city_from['weight']) ){
                   $ne[] = $r;    
            }
            
        }
        if(!empty($ne)){
            foreach($ne as $n){
                if(!empty($n['time']) || !empty($n['a_time'])){
                    $bn[] = $n;
                }                
            }

            for($i=0;$i<count($bn);$i++){
                if(isset($bn[$i+1]['a_time'])){
                    $from = strtotime($date.' '.$bn[$i]['time']);
                    $to = strtotime($date.' '.$bn[$i]['a_time']);
                    $to_next = strtotime($date.' '.$bn[$i+1]['a_time']);
                    if($to_next < $from || $to > $from ){
                        switch($cec){
                            case 0:
                            $cec = 1;
                            break;
                            case 1:
                            $cec = 2;
                            break;
                        }
                         
                    }
                
                }
                            
            }
        }
        //echo $city_to['weight'];
        //$last = $bn[count($bn)-1];
        //if($last['time'] == '00:00:00'){
        //    $cec -= 1;
        //} 
        return $cec;
    }
    
      public function sysuser_block_plase($sys_user_id,$route_id,$bus_id) {
          
            //если не пересекает сутку
            //echo $route_id;
            //die;
            $all_plase = array();
            
            $res = DB::select()->from('sysuser_blocked_plases')
                ->where('sysuser_id','=',$sys_user_id)
                ->and_where('route_id','=',$route_id)
                ->and_where('bus_id','=',$bus_id)
                ->execute()->current();
            
            //////////// sell
            if(!empty($res['plases'])){
                $plases = explode(',',$res['plases']);
                
                $all_plase = $plases;
            }
            //print_r($res);
            
           
            
          return $all_plase;
        //return $res;
    }
    
    public function chek_price_model($route_id,$from,$to,$ses_valute,$fer_id){
        
        
        
        
        $return = array();
        
        $sesuser = Session::instance()->get('ses_user');
        
        
        //echo $route_id.'<br />'.$from.'<br />'.$to.'<br />'.$ses_valute.'<br />'.$fer_id.'<br />'.$sesuser[0]['group_id'].'<br />';
        
        
        $price_group = DB::select()->from('routeprice_groups')
        ->where('group_id','=',$sesuser[0]['group_id'])
        ->and_where('route_name_id','=',$route_id)
        ->and_where('route_city_from_id','=',trim($from))
        ->and_where('route_city_to_id','=',trim($to))
        ->and_where('valute','=',$ses_valute)
        ->and_where('ferryman_id','=',$fer_id)
        ->execute()->current();
        
        
        
        if(!empty($price_group)){
            $return = array($price_group['price'],$price_group['valute']);
        }else{
        
            $price_ch = DB::select()->from('routeprice')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_city_from_id','=',$from)
            ->and_where('route_city_to_id','=',$to)
            ->and_where('valute','LIKE',$ses_valute)
            ->execute()->current();
            
            /*
            echo '<pre>';
            
            print_r($price_ch);
            echo '<br />';
            
            print_r($route_id);
            echo '<br />';
            print_r($from);
            echo '<br />';
            print_r($to);
            echo '<br />';
            print_r($ses_valute);
            echo '</pre>';
            die;
            //*/
            if(empty($price_ch)){
                $price_ch = DB::select()->from('routeprice')
                ->where('route_name_id','=',$route_id)
                ->and_where('route_city_from_id','=',$from)
                ->and_where('route_city_to_id','=',$to)
                ->execute()->current();
            }
            $valute = $price_ch['valute'];    
            $price = $price_ch['price'];
            if(!empty($price)){ 
                $new_price = Googlecon::con($valute,$ses_valute,$price);
                $valute = $new_price[1];
                $price = $new_price[0];
                $return = array($price,$valute);
            }else{ 
                echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2053")."!<h4>";
                die;
            }
        
        }
        return $return;
    }
    
    public function chek_price_model_api($route_id,$from,$to,$ses_valute){
        
        $return = array();
        
        
            $price_ch = DB::select()->from('routeprice')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_city_from_id','=',$from)
            ->and_where('route_city_to_id','=',$to)
            ->and_where('valute','=',$ses_valute)
            ->execute()->current();
            if(empty($price_ch)){
                $price_ch = DB::select()->from('routeprice')
                ->where('route_name_id','=',$route_id)
                ->and_where('route_city_from_id','=',$from)
                ->and_where('route_city_to_id','=',$to)
                ->execute()->current();
            }
            $valute = $price_ch['valute'];    
            $price = $price_ch['price'];
            if(!empty($price)){ 
                if($valute == 'uk'){
                    $valute = 'UAH';
                }
                if($valute == 'cs'){
                    $valute = 'CZK';
                }
                $new_price = Googlecon::con($valute,$ses_valute,$price);
                $valute = $new_price[1];
                $price = $new_price[0];
                $return = array($price,$valute);
            }else{ 
                echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2053")."!<h4>";
                die;
            }
        
    
        return $return;
    }
    
    public function chek_price_model_open($route_id,$from,$to,$ses_valute){
        
        
        
        
        $return = array();
        
        $sesuser = Session::instance()->get('ses_user');
        
        
        //echo $route_id.'<br />'.$from.'<br />'.$to.'<br />'.$ses_valute.'<br />'.$fer_id.'<br />'.$sesuser[0]['group_id'].'<br />';
        
            $price_ch = DB::select()->from('routeprice')
            ->where('route_name_id','=',$route_id)
            ->and_where('route_city_from_id','=',$from)
            ->and_where('route_city_to_id','=',$to)
            ->and_where('valute','LIKE',$ses_valute)
            ->execute()->current();
            
            ///*
            //echo '<pre>';
            //print_r($price_ch);
            //echo '</pre>';

            //die;
            //*/
            if(empty($price_ch)){
                $price_ch = DB::select()->from('routeprice')
                ->where('route_name_id','=',$route_id)
                ->and_where('route_city_from_id','=',$from)
                ->and_where('route_city_to_id','=',$to)
                ->execute()->current();
            }
            $valute = $price_ch['valute'];    
            $price = $price_ch['price'];
            if(!empty($price)){ 
                $new_price = Googlecon::con($valute,$ses_valute,$price);
                $valute = $new_price[1];
                $price = $new_price[0];
                $return = array($price,$valute);
            }else{ 
                echo "<h4>".__("Contact your administrator. no price OPEN")."<h4>";
                die;
            }
        return $return;
    }
    
    public function find_routes_minus_date_model($route,$from_city,$to_city,$route_date){
        //$route_name_id = 689;
        //$from_city = 884;
        //$to_city = 929;
        //$route_date = '2015-09-25';
        
        $d = new DateTime($route_date);
        $d->modify("+1 day");
        $route_date =  $d->format("Y-m-d");
        
        $d = new DateTime($route_date);
        $d->modify("-1 day");
        $date_day_min =  $d->format("Y-m-d");        
        
        
       
        
        $all_route_have_ost = DB::select('route_name_id')->from('route')->where('route_name_id','=',$route)->order_by('route_name_id','ASC')->execute()->as_array();
        $new_all_routes = array();
        foreach($all_route_have_ost as $all_route){
            $new_all_routes[$all_route['route_name_id']] = $all_route;
        }
        
        
        
        $chek = array();
        foreach($new_all_routes as $all_new){
            $chek_from = DB::select()->from('route')->where('route_city_id','=',$from_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            $chek_to = DB::select()->from('route')->where('route_city_id','=',$to_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            if(!empty($chek_from) && !empty($chek_to) && $chek_from['weight'] < $chek_to['weight']){
                
                
                
                $all_new['dates']['minus'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$date_day_min)->execute()->current();
                $day_week = date("w",strtotime($date_day_min));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['minus'][1] = $day_week;
                $all_new['dates']['curr'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$route_date)->execute()->current();
                $day_week = date("w",strtotime($route_date));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['curr'][1] = $day_week;
                $all_new['min_date_for'] = $date_day_min;
                $all_new['all_osts'] = DB::select('r_id','weight','route_city_id')->from('route')->where('route_name_id','=',$all_new['route_name_id'])->order_by('weight','ASC')->execute()->as_array();
                //if(!empty($all_new['dates']['minus'][0]) || !empty($all_new['dates']['curr'][0])){
                    $chek[] = $all_new;
                //}
                
            }
            
        }
       
        //die;
       //print_r($chek);
       // die;
        // echo $chek[0]['dates']['minus'][1];
        ///*
        $new_dates_ost = array();
        foreach($chek as $new_chek){
            $min_ost_min = array();
            //if(!empty($new_chek['dates']['minus'][0])){
                for($i=0;$i<count($new_chek['all_osts']);$i++){
                    
                    $min_ost = DB::select('r_id','a_time','time')->from('routeweek')->where('route_name_id','=',$new_chek['route_name_id'])->and_where('r_id','=',$new_chek['all_osts'][$i]['r_id'])->and_where('week_id','=',$new_chek['dates']['minus'][1])->execute()->current();
                    if(!empty($min_ost)){
                    //echo '<pre>';
                    //print_r($min_ost);
                    //echo '</pre>';
                    //die;
                    $from = strtotime($date_day_min.' '.$min_ost['time']);
                    $to = strtotime($date_day_min.' '.$min_ost['a_time']);
                    
                    
                    
                    

                    array_push($min_ost,$new_chek['all_osts'][$i]['route_city_id']);
                    //array_push($min_ost,$new_chek['dates']['minus'][0]['date']);
                    array_push($min_ost,$from);
                    array_push($min_ost,$to);
                    //if(isset($new_chek['all_osts'][$i+1]['a_time'])){
                    //    $to_next = strtotime($new_chek['dates']['minus'][0]['date'].' '.$new_chek['all_osts'][$i+1]['a_time']);
                    //    array_push($min_ost,$to_next);
                    //}
                    $min_ost_min[$new_chek['route_name_id']][] = $min_ost;
                    
                    }
                    //$i++;
                }
                $new_dates_ost[] = $min_ost_min;
            //}
            
            
        }
        // echo '<pre>';
        //print_r($new_dates_ost);
        //echo '</pre>';
        //die;
        
       
        $new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                    if(!empty($rpotes[$i]['a_time']) || !empty($rpotes[$i]['time'])){
                        $rpotes[$i][1] = $dates;
                        if(
                        isset($rpotes[$i+1]['a_time']) && !empty($rpotes[$i+1]['a_time']) && isset($rpotes[$i+1]['time']) && !empty($rpotes[$i+1]['time']) && 
                        isset($rpotes[$i]['a_time']) && !empty($rpotes[$i]['a_time']) && isset($rpotes[$i]['time']) && !empty($rpotes[$i]['time'])
                        ){
                            $to_next = strtotime($rpotes[$i][1].' '.$rpotes[$i+1]['a_time']);
                            array_push($rpotes[$i],$to_next);
                            if($rpotes[$i][3] < $rpotes[$i][2] && !empty($rpotes[$i]['a_time'])){
                                $d = new DateTime($rpotes[$i][1]);
                                $d->modify("+1 day");
                                $date = $d->format("Y-m-d");
                                $dates = $date;
                            }
                        }
                        $new_rpotes = $rpotes[$i];
                        $new_dates_ost_new[$route][] = $new_rpotes;
                        //echo $rpotes[$i][1];
                        //if($rpotes[$i][0] == $from_city && $rpotes[$i][1] == $route_date){
                            $new_rpotes = $rpotes;
                            for($ii=0;$ii<count($new_rpotes);$ii++){
                                if($new_rpotes[$ii][0] == $to_city){
                                    $d = new DateTime($dates);
                                    $d->modify("+1 day");
                                    $date = $d->format("Y-m-d");
                                    $new_rpotes[$ii][1] = $date;
                                    $toto = $new_rpotes[$ii];
                                }
                            }
                            if($rpotes[$i][0] == $from_city){
                                $ost_finish[] = $rpotes[$i];//array($route,$rpotes[$i],$toto,$date_day_min);
                            }
                            
                        //}
                        
                    }
                }
            }            
        }
        
        //echo '<pre>';
        //print_r($ost_finish);
        //echo '</pre>';
        //die;
        
        return $ost_finish;
        
       
    }
    
        public function find_routes_minus_date_model_sell($route,$from_city,$to_city,$route_date){
        //$route_name_id = 689;
        //$from_city = 884;
        //$to_city = 929;
        //$route_date = '2015-09-25';
        
        $d = new DateTime($route_date);
        $d->modify("-1 day");
        $date_day_min =  $d->format("Y-m-d");        
        
        
       
        
        $all_route_have_ost = DB::select('route_name_id')->from('route')->where('route_name_id','=',$route)->order_by('route_name_id','ASC')->execute()->as_array();
        $new_all_routes = array();
        foreach($all_route_have_ost as $all_route){
            $new_all_routes[$all_route['route_name_id']] = $all_route;
        }
        
       
        
        $chek = array();
        foreach($new_all_routes as $all_new){
            $chek_from = DB::select()->from('route')->where('route_city_id','=',$from_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            $chek_to = DB::select()->from('route')->where('route_city_id','=',$to_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            if(!empty($chek_from) && !empty($chek_to) && $chek_from['weight'] < $chek_to['weight']){
                
                $all_new['dates']['minus'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$date_day_min)->execute()->current();
                $day_week = date("w",strtotime($date_day_min));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['minus'][1] = $day_week;
                $all_new['dates']['curr'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$route_date)->execute()->current();
                $day_week = date("w",strtotime($route_date));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['curr'][1] = $day_week;
                $all_new['min_date_for'] = $date_day_min;
                $all_new['all_osts'] = DB::select('r_id','weight','route_city_id')->from('route')->where('route_name_id','=',$all_new['route_name_id'])->order_by('weight','ASC')->execute()->as_array();
                //if(!empty($all_new['dates']['minus'][0]) || !empty($all_new['dates']['curr'][0])){
                    $chek[] = $all_new;
                //}
                
            }
            
        }
       
        
        
        //die;
      // print_r($chek);
      // die;
        // echo $chek[0]['dates']['minus'][1];
        ///*
        $new_dates_ost = array();
        foreach($chek as $new_chek){
            $min_ost_min = array();
            //if(!empty($new_chek['dates']['minus'][0])){
                for($i=0;$i<count($new_chek['all_osts']);$i++){
                    
                    $min_ost = DB::select('r_id','a_time','time')->from('routeweek')->where('route_name_id','=',$new_chek['route_name_id'])->and_where('r_id','=',$new_chek['all_osts'][$i]['r_id'])->and_where('week_id','=',$new_chek['dates']['minus'][1])->execute()->current();
                    if(!empty($min_ost)){
                        
                   
                    //echo '<pre>';
                    //print_r($min_ost);
                    //echo '</pre>';
                    //die;
                    $from = strtotime($date_day_min.' '.$min_ost['time']);
                    $to = strtotime($date_day_min.' '.$min_ost['a_time']);
                    
                    
                    
                    

                    array_push($min_ost,$new_chek['all_osts'][$i]['route_city_id']);
                    //array_push($min_ost,$new_chek['dates']['minus'][0]['date']);
                    array_push($min_ost,$from);
                    array_push($min_ost,$to);
                    //if(isset($new_chek['all_osts'][$i+1]['a_time'])){
                    //    $to_next = strtotime($new_chek['dates']['minus'][0]['date'].' '.$new_chek['all_osts'][$i+1]['a_time']);
                    //    array_push($min_ost,$to_next);
                    //}
                    $min_ost_min[$new_chek['route_name_id']][] = $min_ost;
                    
                     }
                    //$i++;
                }
                $new_dates_ost[] = $min_ost_min;
            //}
            
            
        } 
        //    echo 'ok';
        //die;
        //echo '<pre>';
        //print_r($new_dates_ost);
        //echo '</pre>';
        //die;
        
       
        $new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                    if(isset($rpotes[$i]['a_time']) && isset($rpotes[$i]['time'])  && !empty($rpotes[$i]['a_time']) || !empty($rpotes[$i]['time'])){
                        $rpotes[$i][1] = $dates;
                        if(
                        isset($rpotes[$i+1]['a_time']) && !empty($rpotes[$i+1]['a_time']) && isset($rpotes[$i+1]['time']) && !empty($rpotes[$i+1]['time']) && 
                        isset($rpotes[$i]['a_time']) && !empty($rpotes[$i]['a_time']) && isset($rpotes[$i]['time']) && !empty($rpotes[$i]['time'])
                        ){
                            $to_next = strtotime($rpotes[$i][1].' '.$rpotes[$i+1]['a_time']);
                            array_push($rpotes[$i],$to_next);
                            if($rpotes[$i][3] < $rpotes[$i][2] && !empty($rpotes[$i]['a_time'])){
                                $d = new DateTime($rpotes[$i][1]);
                                $d->modify("+1 day");
                                $date = $d->format("Y-m-d");
                                $dates = $date;
                            }
                        }
                        $new_rpotes = $rpotes[$i];
                        $new_dates_ost_new[$route][] = $new_rpotes;
                        //echo $rpotes[$i][1];
                        //die;
                        //if($rpotes[$i][0] == $from_city && $rpotes[$i][1] == $route_date){
                            $new_rpotes = $rpotes;
                            $toto = '';
                            for($ii=0;$ii<count($new_rpotes);$ii++){
                                if($new_rpotes[$ii][0] == $to_city){
                                    $d = new DateTime($dates);
                                    $d->modify("+1 day");
                                    $date = $d->format("Y-m-d");
                                    $new_rpotes[$ii][1] = $date;
                                    $toto = $new_rpotes[$ii];
                                }
                            }
                            if($rpotes[$i][0] == $from_city){
                                $ost_finish[] = $rpotes[$i];//array($route,$rpotes[$i],$toto,$date_day_min);
                            }
                            
                        //}
                        
                    }
                }
            }            
        }
        
        //echo '<pre>';
        //print_r($ost_finish);
        //echo '</pre>';
        //die;
        
        return $ost_finish;
        
       
    }
    
    public function search_api_meny_osts($from,$to,$route_date,$day_week,$lang,$rice){
        //$route_name_id = 689;     
        
           
        $all_minus = $this->find_routes_minus_date($from,$to,$route_date);
        
        
            
        $d = new DateTime($route_date);
        $d->modify("+1 day");
        $route_date = $d->format("Y-m-d");
                
        $all_current = $this->find_routes_curr_date($from,$to,$route_date);
        
        //die;
        //echo '<pre>';
        //    print_r($route_date);
        //    echo '</pre>';
        //    die;
        
        foreach($all_current as $all_cur){
            array_push($all_minus,$all_cur);
        }
        $all_simple = array();
        
        
        
        
        foreach($all_minus as $all){
            
            
            if(isset($all[3])){
                $day = DB::select('date','ferryman_id','buses_id','rice','route_name_id')->distinct(true)->from('routeferrymanweek')->where('route_name_id','=',$all[0])->and_where('routeferrymanweek.date','=',$all[3])
                            ->and_where('routeferrymanweek.route_type_id','=',1)
                            ->and_where('routeferrymanweek.rice','=',$rice)->execute()->current();
            }else{
                $day = DB::select('date','ferryman_id','buses_id','rice','route_name_id')->distinct(true)->from('routeferrymanweek')->where('route_name_id','=',$all[0])->and_where('routeferrymanweek.date','=',$all[1][1])
                            ->and_where('routeferrymanweek.route_type_id','=',1)
                            ->and_where('routeferrymanweek.rice','=',$rice)->execute()->current();
            }
            if(isset($all[2]) && !empty($all[2])){
                $re['from'] = $all[1];
                $re['from']['route_name_id'] = $all[0];
                $weight = DB::select()->from('route')->where('r_id','=',$all[1]['r_id'])->execute()->current();
                $re['from']['weight'] = $weight['weight'];
                if(isset($all[1][0])){
                    $ost_from_name = Model::factory('OstMod')->get_ost($all[1][0],$lang);
                }else{
                    $ost_from_name['city_i18n'] = '';
                    $ost_from_name['name_i18n'] = '';
                }
                if(isset($all[2][0])){
                    $ost_to_name = Model::factory('OstMod')->get_ost($all[2][0],$lang);
                }else{
                    $ost_to_name['city_i18n'] = '';
                    $ost_to_name['name_i18n'] = '';
                    
                }
                
                $re['from']['city_name_from'] = $ost_from_name['city_i18n'];
                $re['from']['stop_name_from'] = $ost_from_name['name_i18n'];
                $re['from']['time'] = $all[1]['a_time'];
                $re['from']['hours'] = $all[1]['time'];
                $re['from']['date'] = $all[1][1];
                $re['from']['ferryman_id'] = $day['ferryman_id'];
                $ferr = DB::select()->from('ferryman')->where('ferryman_id','=',$day['ferryman_id'])->execute()->current();
                $re['from']['buses_id'] = $day['buses_id'];
                $re['from']['platform'] =  DB::select('value')->from('platform')->where('route_name_id','=',$all[0])->and_where('ost_id','=',$all[1][0])->and_where('day_week','=',$day_week)->execute()->current();
                $re['to'] = $all[2];
                if(isset($all[2]['r_id'])){
                    $weight2 = DB::select()->from('route')->where('r_id','=',$all[2]['r_id'])->execute()->current();
                }else{
                    $weight2['weight'] = 'not found: r_id';
                }
                
                $re['to']['weight'] = $weight2['weight'];
                $re['to']['route_name_id'] = $all[0];
                $re['to']['city_name_to'] = $ost_to_name['city_i18n'];
                $re['to']['stop_name_to'] = $ost_to_name['name_i18n'];
                $re['to']['a_time'] = $all[2]['a_time'];
                $re['to']['a_hours'] = $all[2]['time'];
                $re['to']['end_date'] = $all[2][1];
                $re['sorting_by_arrive'] =  $all[1][3];
                $re['to']['platform'] =  DB::select('value')->from('platform')->where('route_name_id','=',$all[0])->and_where('ost_id','=',$all[2][0])->and_where('day_week','=',$day_week)->execute()->current();
                $re['alien'] = 0;
                $re['flight'] = $rice;
                $re['day_week'] = $day_week;
                $re['ferryman_name'] = $ferr['name'];
                $re['route_name'] = DB::select('name')->from('routename')->where('route_name_id','=',$all[0])->execute()->current();
                //$re['to']['end_date'] = date('Y-m-d',strtotime($day['date'])+3600*48);
                
                $bizi = Model::factory('TiketMod')->block_plase($all[0],$day['date'],$day['buses_id'],$day['ferryman_id'],$all[1][0],$all[2][0]);// 
                $sell_array = Model::factory('TiketMod')->sell_plase_api($all[0],$all[1][1],$day['buses_id'],$day['ferryman_id'],$all[1][0],$all[2][0]);
                
                //print_r($sell_array);
                
                $sell = array();
                foreach($sell_array as $tes=>$vall){
                    $sell[] = $vall['value'];   
                }                            //$bizi = count(Model::factory('TiketMod')->block_plase($arr['from']['route_name_id'],$arr['from']['date'],$arr['from']['buses_id'],$arr['from']['ferryman_id'],$arr['from']['route_city_id'],$arr['to']['route_city_id']));//       
                $bus = DB::select()->from('buses')->where('buses_id','=',$day['buses_id'])->execute()->current();
                $bus_schema = DB::select()->from('bscheme')->where('schema_name','=',$bus['schema_name'])->execute()->as_array();
                $bus_schema_name = $bus['schema_name'];
                $al_plase = DB::query(Database::SELECT, "SELECT * FROM bscheme WHERE schema_name LIKE '$bus_schema_name'")->execute()->as_array();
                $cou_plases = 0;
                $all_free_plases = array();
                foreach($al_plase as $pl){
                    if(is_numeric($pl['value']) === true){
                        $cou_plases++;
                        $all_free_plases[] = $pl['value'];
                    }
                }
               $all_free_plases = array_reverse($all_free_plases); 
               $re['all_free_plases'] = array_diff($all_free_plases,$sell); 
               $re['free_plases'] = $cou_plases - count($sell);//count(DB::select()->from('BScheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
               $re['route_price'] = DB::select('price','valute')->from('routeprice')->where('route_city_from_id','=',$all[1][0])->and_where('route_city_to_id','=',$all[2][0])->and_where('route_name_id','=',$all[0])->execute()->as_array();
               unset($re['from'][1]);
               unset($re['from'][2]);
               unset($re['from'][3]);
               unset($re['to'][1]);
               unset($re['to'][2]);
               unset($re['to'][3]);
               $all_simple[] = $re;
           }
        }   
        //echo $route_date;
        //echo '<pre>';  
        //print_r($all_simple);  
        //echo '</pre>';
       //die;
        return $all_simple;
    }
    
    function find_routes_minus_date($from_city,$to_city,$route_date){
        //$route_name_id = 689;
        //$from_city = 884;
        //$to_city = 929;
        //$route_date = '2015-09-25';
        
        
        $d = new DateTime($route_date);
        $d->modify("-1 day");
        $date_day_min =  $d->format("Y-m-d");
        
        $d = new DateTime($route_date);
        $d->modify("+1 day");
        $date_day_plus =  $d->format("Y-m-d");
        
        
        
       
        
        $all_route_have_ost = DB::select('route_name_id')->from('route')->where('route_city_id','in',array($from_city,$to_city))->order_by('route_name_id','ASC')->execute()->as_array();
        $new_all_routes = array();
        foreach($all_route_have_ost as $all_route){
            $new_all_routes[$all_route['route_name_id']] = $all_route;
        }
        
        $chek = array();
        foreach($new_all_routes as $all_new){
            $chek_from = DB::select()->from('route')->where('route_city_id','=',$from_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            $chek_to = DB::select()->from('route')->where('route_city_id','=',$to_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            if(!empty($chek_from) && !empty($chek_to) && $chek_from['weight'] < $chek_to['weight']){
                $all_new['dates']['minus'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$date_day_min)->execute()->current();
                $day_week = date("w",strtotime($date_day_min));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['minus'][1] = $day_week;
                $all_new['dates']['curr'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$route_date)->execute()->current();
                $day_week = date("w",strtotime($route_date));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['curr'][1] = $day_week;
                $all_new['min_date_for'] = $date_day_min;
                $all_new['all_osts'] = DB::select('r_id','weight','route_city_id')->from('route')->where('route_name_id','=',$all_new['route_name_id'])->order_by('weight','ASC')->execute()->as_array();
                if(!empty($all_new['dates']['minus'][0]) || !empty($all_new['dates']['curr'][0])){
                    $chek[] = $all_new;
                }
                
            }
            
        }
        
        
       
        
       
        // echo $chek[0]['dates']['minus'][1];
        ///*
        $new_dates_ost = array();
        
        $min_ost_min = array();
        
        foreach($chek as $new_chek){

            if(!empty($new_chek['dates']['minus'][0])){
                
                
                for($i=0;$i<count($new_chek['all_osts']);$i++){
                    $min_ost = DB::select('r_id','a_time','time')->from('routeweek')->where('route_name_id','=',$new_chek['route_name_id'])->and_where('r_id','=',$new_chek['all_osts'][$i]['r_id'])->and_where('week_id','=',$new_chek['dates']['minus'][1])->execute()->current();
                    
                    if(isset($min_ost) && !empty($min_ost)){
                        
                   
                    
                    $from = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['time']);
                    $to = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['a_time']);
                    
                    
                    
                    //print_r($new_chek['all_osts'][$i+1]);
                    //die;

                    array_push($min_ost,$new_chek['all_osts'][$i]['route_city_id']);
                    array_push($min_ost,$new_chek['dates']['minus'][0]['date']);
                    array_push($min_ost,$from);
                    array_push($min_ost,$to);
                    //if(isset($new_chek['all_osts'][$i+1]['a_time'])){
                    //    $to_next = strtotime($new_chek['dates']['minus'][0]['date'].' '.$new_chek['all_osts'][$i+1]['a_time']);
                    //    array_push($min_ost,$to_next);
                  //  print_r($new_chek['route_name_id']);
                //die;
                
                    //}
                    $min_ost_min[$new_chek['route_name_id']][] = $min_ost;
                    //die;
                    }
                    //$i++;
                }
                
                $new_dates_ost[] = $min_ost_min; 
                
               
            }
            
            
        }
       //  print_r($min_ost_min);
       //             die;
        
        $new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                    if(!empty($rpotes[$i]['a_time']) && !empty($rpotes[$i]['time'])){
                        $rpotes[$i][1] = $dates;
                        if(isset($rpotes[$i+1]['a_time']) && !empty($rpotes[$i+1]['a_time'])){
                            $to_next = strtotime($rpotes[$i][1].' '.$rpotes[$i+1]['a_time']);
                            array_push($rpotes[$i],$to_next);
                            if($rpotes[$i][4] < $rpotes[$i][3]){
                                $d = new DateTime($rpotes[$i][1]);
                                $d->modify("+1 day");
                                $date = $d->format("Y-m-d");
                                $dates = $date;
                            }
                        }
                        $new_rpotes = $rpotes[$i];
                        $new_dates_ost_new[$route][] = $new_rpotes;
                        //echo $rpotes[$i][1];
                        if($rpotes[$i][0] == $from_city && $rpotes[$i][1] == $route_date){
                            $new_rpotes = $rpotes;
                            for($ii=0;$ii<count($new_rpotes);$ii++){
                                $toto = '';
                                if($new_rpotes[$ii][0] == $to_city){
                                    $d = new DateTime($new_rpotes[$ii][1]);
                                    $d->modify("+1 day");
                                    $date = $d->format("Y-m-d");
                                    $new_rpotes[$ii][1] = $date;
                                    $toto = $new_rpotes[$ii];
                                }
                            }
                            $ost_finish[$route] = array($route,$rpotes[$i],$toto,$date_day_min);
                        }
                        
                    }
                }
            }            
        }
       
        return $ost_finish;
        
       
    }
    
    function find_routes_curr_date($from_city,$to_city,$route_date){
        //$route_name_id = 689;
        //$from_city = 884;
        //$to_city = 929;
        //$route_date = '2015-09-25';
        
        
        
        
        $d = new DateTime($route_date);
        $d->modify("-1 day");
        $date_day_min =  $d->format("Y-m-d");
        
        $d = new DateTime($route_date);
        $d->modify("+1 day");
        $date_day_plus =  $d->format("Y-m-d");
        
        $route_date =  $date_day_min;
        //echo $route_date;
        //die;
       
        
        $all_route_have_ost = DB::select('route_name_id')->from('route')->where('route_city_id','in',array($from_city,$to_city))->order_by('route_name_id','ASC')->execute()->as_array();
        $new_all_routes = array();
        foreach($all_route_have_ost as $all_route){
            $new_all_routes[$all_route['route_name_id']] = $all_route;
        }
        
        $chek = array();
        foreach($new_all_routes as $all_new){
            $chek_from = DB::select()->from('route')->where('route_city_id','=',$from_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            $chek_to = DB::select()->from('route')->where('route_city_id','=',$to_city)->and_where('route_name_id','=',$all_new['route_name_id'])->execute()->current();
            if(!empty($chek_from) && !empty($chek_to) && $chek_from['weight'] < $chek_to['weight']){
                $all_new['dates']['minus'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$date_day_min)->execute()->current();
                $day_week = date("w",strtotime($date_day_min));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['minus'][1] = $day_week;
                $all_new['dates']['curr'][0] = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$all_new['route_name_id'])->and_where('date','=',$route_date)->execute()->current();
                $day_week = date("w",strtotime($route_date));
                switch($day_week){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }
                $all_new['dates']['curr'][1] = $day_week;
                $all_new['all_osts'] = DB::select('r_id','weight','route_city_id')->from('route')->where('route_name_id','=',$all_new['route_name_id'])->order_by('weight','ASC')->execute()->as_array();
                if(!empty($all_new['dates']['minus'][0]) || !empty($all_new['dates']['curr'][0])){
                    $chek[] = $all_new;
                }
                
            }
            
        }
        
        ///*
        $new_dates_ost = array();
        foreach($chek as $new_chek){
            $min_ost_min = array();
            if(!empty($new_chek['dates']['minus'][0])){
                for($i=0;$i<count($new_chek['all_osts']);$i++){
                    $min_ost = DB::select('r_id','a_time','time')->from('routeweek')->where('route_name_id','=',$new_chek['route_name_id'])->and_where('r_id','=',$new_chek['all_osts'][$i]['r_id'])->and_where('week_id','=',$new_chek['dates']['minus'][1])->execute()->current();
                    if(isset($min_ost) && !empty($min_ost)){
                        $from = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['time']);
                        $to = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['a_time']);
                        
                        
                        
                        //print_r($new_chek['all_osts'][$i+1]);
                        //die;
    
                        array_push($min_ost,$new_chek['all_osts'][$i]['route_city_id']);
                        array_push($min_ost,$new_chek['dates']['minus'][0]['date']);
                        array_push($min_ost,$from);
                        array_push($min_ost,$to);
                        //if(isset($new_chek['all_osts'][$i+1]['a_time'])){
                        //    $to_next = strtotime($new_chek['dates']['minus'][0]['date'].' '.$new_chek['all_osts'][$i+1]['a_time']);
                        //    array_push($min_ost,$to_next);
                        //}
                        $min_ost_min[$new_chek['route_name_id']][] = $min_ost;
                        
                        
                        //$i++;
                    }
                    $new_dates_ost[] = $min_ost_min;
                }
            }
            
            
        }
        
        
        //$new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                    if(isset($rpotes[$i]['a_time']) && isset($rpotes[$i]['time']) &&  !empty($rpotes[$i]['a_time']) && !empty($rpotes[$i]['time'])){
                        
                        $rpotes[$i][1] = $dates;
                        if(isset($rpotes[$i+1]['a_time']) && !empty($rpotes[$i+1]['a_time'])){
                            $to_next = strtotime($rpotes[$i][1].' '.$rpotes[$i+1]['a_time']);
                            array_push($rpotes[$i],$to_next);
                            if($rpotes[$i][4] < $rpotes[$i][3]){
                                $d = new DateTime($rpotes[$i][1]);
                                $d->modify("+1 day");
                                $date = $d->format("Y-m-d");
                                $dates = $date;
                            }
                        }

                        $new_rpotes = $rpotes[$i];
                        //$new_dates_ost_new[$route][] = $new_rpotes;
                        //echo $rpotes[$i][1];
                        
                        if(isset($rpotes[$i][0]) && $rpotes[$i][0] == $from_city && $rpotes[$i][1] == $route_date){
                            $new_rpotes = $rpotes;
                            $toto = '';
                            for($ii=0;$ii<count($new_rpotes);$ii++){
                                if($new_rpotes[$ii][0] == $to_city){
                                    $d = new DateTime($new_rpotes[$ii][1]);
                                    $d->modify("+1 day");
                                    $date = $d->format("Y-m-d");
                                    $new_rpotes[$ii][1] = $date;
                                    $toto = $new_rpotes[$ii];
                                }
                            }
                            $ost_finish[$route] = array($route,$rpotes[$i],$toto);
                             
                        }  
                                   
                    }
                }
            }            
        }
        
        
        //echo '<pre>';
        //print_r($ost_finish);
        //echo '</pre>';
        //die;
        return $ost_finish;
        
       
    }
    
    public function get_all_routes_from_osts($from_osts,$to_osts) {
        
        
        $all_routes = array();
        
        $all_parents = array();
        
       
        
        $all_simple = array();
        
        $al_from = array();
        
        foreach($from_osts as $f) {
            $res = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id','routename.is_public','routename.parent','routename.start_from','routename.start_from')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$f['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_from[] = $res;    
        }
        
         
        //die;
        $al_to = array();
        foreach($to_osts as $t) {
            $res_to = DB::select('r_id','route.route_name_id','route.weight','routename.types','route.route_city_id','route.route_id')->distinct(true)->from('route')
            ->join('routename')->on('route.route_name_id','=','routename.route_name_id')->
            where('route.route_city_id','=',$t['route_city_id'])->
            //and_where('RouteName.is_public','!=',0)->
            execute()->as_array();
            $al_to[] = $res_to;
            
        } 
        
        /*
        echo '<pre>';
        print_r($from);
        echo '</pre>';
        echo '<pre>';
        print_r($to);
        echo '</pre>';
        die; 
         */       
         
         
        $all_simple = array(); 
        foreach($al_from as $a_f) {
            foreach($a_f as $f_last) {
                foreach($al_to as $a_t) {
                    foreach($a_t as $t_last) {
                        if($f_last['route_name_id'] == $t_last['route_name_id'] && $f_last['types'] == $t_last['types'] && $f_last['weight'] < $t_last['weight']){
                            //echo '<pre>';
                            //print_r($t_last);
                            //echo '</pre>';
                            //die;
                            $all_simple[$f_last['route_name_id'].$f_last['weight'].$t_last['weight']] = array($f_last['route_city_id'],$t_last['route_city_id']);
                        }    
                    }
                } 
            }
        } 
        
                                       


        return $all_simple;
    }
    
    
     public function get_date_for_api_soap($date,$route,$from){
        //if($_POST) {
            //print_r($_POST);
                $n_d = $date;
                $n_d_full = $date.' 00:00:01';
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }     
                     
                $rice = 1;
               
                     
                $city_from = DB::select()->from('route')->where('route_name_id','=',$route)->order_by('weight','ASC')->execute()->current();
                $city_to = DB::select()->from('route')->where('route_name_id','=',$route)->and_where('route_city_id','=',$from)->execute()->current();
                //////////new dey
               
                $all_ost = DB::select('r_id','weight')->from('route')->where('route_name_id','=',$route)->and_where('weight','BETWEEN',array($city_from['weight'],$city_to['weight']))->order_by('weight','ASC')->execute()->as_array();
                //echo count($all_ost);
                
                $new = array();
                
                foreach($all_ost as $ost){
                    $arive = DB::select('hours','a_hours')->from('routeweek')->where('route_name_id','=',$route)->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice)->execute()->current();
                    $ost['pribitie'] = $arive['a_hours'];
                    $ost['otpravka'] = $arive['hours'];
                    $ost['pribitie_secund'] = strtotime( '2014-01-01 '.$arive['a_hours'].':00');
                    $ost['otpravka_secund'] = strtotime( '2014-01-01 '.$arive['hours'].':00');
                    //$arive_to = DB::select('a_hours')->from('routeweek')->where('route_name_id','=',1590)->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',0)->and_where('rice','=',1)->execute()->current();
                    if(!empty($ost['pribitie']) || !empty($ost['otpravka'])){
                        $new[] = $ost;
                    }
                    
                }
                
                
           
               $da_end = date('d/m/Y',strtotime($n_d_full));
               $da_end_next = $n_d_full;
                
                $start = 0;
                $day = 0;
              
                
                for($i = 0; $i<count($new); $i++){
                    $start = $new[$i]['pribitie_secund'];
                    if(isset($new[$i+1]['pribitie_secund'])){
                        $start_next = $new[$i+1]['pribitie_secund'];
                        if($start > $start_next){
                            //echo $n['weight'];
                            $day += 1; 
                        }
                    }
                 
                }
                
            
              return $day;
        
    }

} // End Metki
