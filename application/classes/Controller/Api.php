<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

     public function before() {
        //$this->delete_reserv_tiket();
     } 
     
     function delete_reserv_tiket(){
        $tikets2 = DB::select()->from('ticket')
            ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
            ->where('ticketreport.status','=',2)
            ->and_where('ticket.api','=',1)
            ->execute()->as_array();
            
        //echo '<pre>';
        print_r($tikets2);
        echo '</pre>';    
            
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
     }
     
     public function action_sell_ticket(){
        if($_GET){
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                //http://disp.svitgo.com/api/sell_ticket?key=0210946574f0f4f6c32d1474fc0da483&route_name_id=1591&from=935&to=883&route_date=26/04/15&buses_id=120&ferryman_id=3&seat=44&rice=1&discount=32&name=Andrey&surname=Lysogor&userbd=1984-06-29&tel=80666538696&sell_or_order=1&format=array&culture=ru&valute=EUR
                if(isset($_GET['route_date']) 
                    && isset($_GET['surname']) 
                    && isset($_GET['name']) 
                    && isset($_GET['userbd']) 
                    && isset($_GET['tel']) 
                    && isset($_GET['route_name_id'])
                    && isset($_GET['from']) 
                    && isset($_GET['to']) 
                    && isset($_GET['sell_or_order']) 
                    && isset($_GET['rice']) 
                    && isset($_GET['buses_id'])
                    && isset($_GET['ferryman_id']) 
                    && isset($_GET['seat'])
                    && isset($_GET['discount'])
                    && isset($_GET['valute'])
                    ){
                    $key = $this->chek_key($_GET['key']);

                    $data = array();           
                    $date = array_reverse(explode('/', $_GET['route_date']));
                    $route_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
                    //$new_inputs = $_POST['inputs'];
                    $soname = $_GET['surname'];
                    $name = $_GET['name'];
                    $userdata = $_GET['userbd'];
                    $tel = $_GET['tel'];
                    
                    $route_name_id = $_GET['route_name_id'];
                    $from = $_GET['from'];
                    $to = $_GET['to'];
                    $sysuser = $key['sysuser_id'];
                    $sel_or_order = $_GET['sell_or_order'];
                    $rice = $_GET['rice'];
                    $buses_id = $_GET['buses_id'];
                    $ferryman_id = $_GET['ferryman_id'];
                    $plases = $_GET['seat'];
                    $discount = $_GET['discount'];
                    
                    $valute = $_GET['valute']; 
                    
                    
                    
                    $chekk_tik_sell_new = DB::select()->from('ticket')
                        ->where('buses_id','=',$buses_id)
                        ->and_where('ferryman_id','=',$ferryman_id)
                        ->and_where('route_date','=',$route_date)
                        ->and_where('value','=',$plases)
                        ->and_where('ticket_type_id','!=',3)
                        ->execute()->current();
                        
                    
                    $nikol_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$route_name_id)->execute()->current();
                    $nikolo_from_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$from)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                    $nikolo_to_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                   
                    
                
                    
                    
                    $chek_date = Model::factory('TiketMod')->get_date_for_api_soap($route_date,$route_name_id,$from);

                    $all_free = array();
                    $route = new stdClass();
                    $route->route_id = $nikol_route['reg_route_id'];
                    $route->from_id = $nikolo_from_ost['reg_ost_id'];
                    $route->to_id = $nikolo_to_ost['reg_ost_id'];
                    $route->date = $route_date;
                    $regabus = new Regabus();
                    $all = $regabus->get_route($route);
                    
                    if($chek_date == 1){
                        $d = new DateTime($route_date);
                        $d->modify("-1 day");
                        $route_date = $d->format("Y-m-d");
                        echo $route_date;
                        $route = new stdClass();
                        $route->route_id = $nikol_route['reg_route_id'];
                        $route->from_id = $nikolo_from_ost['reg_ost_id'];
                        $route->to_id = $nikolo_to_ost['reg_ost_id'];
                        $route->date = $route_date;
                        $regabus = new Regabus();
                        $all = $regabus->get_route($route);
                    //    $all = $regabus->get_route($route_date);
                    }
                    //if($all[0]->free_seat)
                    $chek_set = 0;
                    foreach($all[0]->free_seat as $seats_one){
                        if($seats_one == $plases){
                            $chek_set = 1;
                        }
                    }
                    
                    if($chek_set == 0){
                        echo 3000;
                        die;
                    }
                    //echo '<pre>';
                    //print_r();
                    //echo '</pre>';
                    //die;
                    
                        
                        
                    if(empty($chekk_tik_sell_new)){
                        
                        
                        // если такаго билета нет 
                        
                        
                        
                        
                        
                        
                        
                        
                        $week_id = date( "w", strtotime($route_date.' 00:00:01')); 
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
                        
                        
                        
                        
                        //$new_ar = array(array('route_city_id'=>$from,'type'=>array(array('type_id'=>1))));
                
                        //$new_ar_to = array(array('route_city_id'=>$to,'type'=>array(array('type_id'=>1))));
                        
                        $all_routes = $this->search_api($from,$to,$route_date,$week_id,'en',$rice,1,$_GET['key']);
                        if(!empty($all_routes)){
                            //print_r($all_routes);
                            //die;
                            
                            $rou_from = DB::select()->from('route')->where('route_name_id','=',$route_name_id)->and_where('route_city_id','=',$from)->execute()->current();
                            $rou_from = DB::select()->from('routeweek')->where('route_name_id','=',$route_name_id)->and_where('r_id','=',$rou_from['r_id'])->and_where('week_id','=',$week_id)->and_where('rice','=',$rice)->execute()->current();
                            $rou_to = DB::select()->from('route')->where('route_name_id','=',$route_name_id)->and_where('route_city_id','=',$to)->execute()->current();
                            $rou_to = DB::select()->from('routeweek')->where('route_name_id','=',$route_name_id)->and_where('r_id','=',$rou_to['r_id'])->and_where('week_id','=',$week_id)->and_where('rice','=',$rice)->execute()->current();
                            
                            $tik_ids = '';
                                
                                $cleent_id = 0;
                                //$chek_peo = DB::select()->from('ticket_people')->where('soname','=',$soname)->and_where('name','=',$name)->execute()->current();
                                
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
                                    $soname,
                                    $name,
                                    $userdata,
                                    $tel,
                                    //$new_inputs[$i][5],
                                    1
                                    ))->execute();
                                    $cleent_id = $cl_id[0];
                                //}else{
                                //    $cleent_id = $chek_peo['id'];
                                //    DB::update('ticket_people')->set(array(
                                //    'count_trip'=>$chek_peo['count_trip']+1,
                                //    ))->where('id','=',$cleent_id)->execute();
                                //}
                                
                                $price_array = Model::factory('TiketMod')->chek_price_model_api($route_name_id,$from,$to,$valute,$ferryman_id);
                                $price = $price_array[0];
                                $valute = $price_array[1];
                                
                                if($discount != 0){
                                    $dis = DB::select()->from('tickerdiscount')->where('main_id','=',$discount)->execute()->current();
                                
                                    $dis_proc = $dis['value'];
                                
                                    $price_pr = $price/100*$dis_proc;  
                                    $price = $price - $price_pr;
                                    
                                }
                                                      
                                
                                $from_date_full = $route_date.' '.$rou_from['time'];
                                //echo $from_date_full;
                                //die;
                                
                                $rou_date_from = strtotime($from_date_full);
                                $noww = strtotime('now');
                                
                                if($noww > $rou_date_from){
                                    echo 'Departure - 0';
                                    die;
                                }
                                
                                $maska = 0;
                                
                                
                                $sys_user_info = DB::select()->from('system_users')->where('id','=',$sysuser)->execute()->current();
                                $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$sys_user_info['parent_sysuser'])->execute()->as_array();
                                if(!empty($children_arr)){
                                    foreach($children_arr as $ch){
                                        $children_arr_a[] = $ch['id'];
                                    }
                                }
                                array_push($children_arr_a,$sysuser);
                                
                                $all_ticks_parents = DB::select('ticket_id','maska')->from('ticket')->where('user_id','in',$children_arr_a)->order_by('maska','DESC')->limit(1)->execute()->current();
                                
                                $maska = $all_ticks_parents['maska'] + 1;
                                
                                //echo '<pre>';
                                //print_r($maska);
                                //echo '</pre>';
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
                                    $route_name_id,
                                    $cleent_id,
                                    $sel_or_order,
                                    $buses_id,
                                    $plases,
                                    $ferryman_id,
                                    $sysuser,
                                    date('Y-m-d H:i:s'),
                                    round($price,2),
                                    $from,
                                    $to,
                                    $route_date,
                                    $rou_from['time'],
                                    $rou_to['a_time'],
                                    $price,
                                    $price,
                                    $discount,
                                    date('Y-m-d H:i:s'),
                                    0,
                                    1
                                ))->execute();                
                                
                                DB::insert('ticket_valute',array(
                                    'tiket_id',
                                    'valute',
                                ))->values(array(
                                    $tik_id[0],
                                    $valute,
                                ))->execute();
                                
                                DB::insert('ticketreport',array(
                                    'ticket_id',
                                    'status',
                                    'create_report',
                                    'sys_user'
                                ))->values(array(
                                    $tik_id[0],
                                    $sel_or_order,
                                    date('Y-m-d H:i:s'),
                                    $sysuser
                                ))->execute();
                                
                                $tik_ids = $tik_id[0];
                                
                                $all_tiks = $tik_ids.',';
                    
                    
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
                                    $sel_or_order,
                                    date('Y-m-d H:i:s'),
                                    $valute,
                                    $_GET['culture'],
                                    $price,
                                    $this->random_pass(10),
                                    $sysuser
                                ))->execute();
                                
                                
                                //*/ 
                                $chekk_tik_sell = DB::select(
                                'maska',
                                'ticket.ticket_id',
                                'route_name_id',
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
                                'route_time',
                                'route_timeto',
                                'route_price_discount',
                                'discount_id',
                                'valute'
                                )->from('ticket')->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')->where('ticket.ticket_id','=',$tik_ids)->execute()->current();
                                
                               
                                
                                
                                $nikol_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$route_name_id)->execute()->current();
                                $nikolo_from_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$from)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                                $nikolo_to_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
                               
                                
                            
                                
                                
                                $chek_date = Model::factory('TiketMod')->get_date_for_api_soap($route_date,$route_name_id,$from);
        
                                $all_free = array();
                                $route = new stdClass();
                                $route->route_id = $nikol_route['reg_route_id'];
                                $route->from_id = $nikolo_from_ost['reg_ost_id'];
                                $route->to_id = $nikolo_to_ost['reg_ost_id'];
                                $route->date = $route_date;
                                $regabus = new Regabus();
                                $all = $regabus->get_route($route);
                                
                                if($chek_date == 1){
                                    $d = new DateTime($route_date);
                                    $d->modify("-1 day");
                                    $route_date = $d->format("Y-m-d");
                                    echo $route_date;
                                    $route = new stdClass();
                                    $route->route_id = $nikol_route['reg_route_id'];
                                    $route->from_id = $nikolo_from_ost['reg_ost_id'];
                                    $route->to_id = $nikolo_to_ost['reg_ost_id'];
                                    $route->date = $route_date;
                                    $regabus = new Regabus();
                                    $all = $regabus->get_route($route);
                                //    $all = $regabus->get_route($route_date);
                                }
                                
                               
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
                                $sale->seat = $plases;
                                $sale->discount_id = 0;
                                
                                
                                
                                $client = new stdClass();
                                $client->name = $name;
                                $client->surname = $soname;
                                $client->tel = $tel;
                                $client->birth_date= '1980-10-21';
                                
                                
                                $ticket_id = $regabus->sell($sale, $client); 

                               
                                 $join_tik = DB::insert('regabus_join_ticks',array(
                                    'svitgo_tik',
                                    'rega_tik',
                                    'rega_route',
                                    'rega_from',
                                    'rega_to',
                                    'rega_date'
                                ))->values(array(
                                    $tik_id[0],
                                    $ticket_id,
                                    $nikol_route['reg_route_id'],
                                    $nikolo_from_ost['reg_ost_id'],
                                    $nikolo_to_ost['reg_ost_id'],
                                    $route_date
                                ))->execute();
                                
                                
                                $this->get_format($_GET['format'],$chekk_tik_sell);
                            }else{
                                echo 1006;                            
                            }
                        }else{
                            echo 1002;
                        }
                    
                    }else{
                        echo 1001;
                    }
                    
                    
            }else{
                echo 1000;
            } 
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
    
    public function action_null_ticket(){
        if($_GET){
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                ///api/null_ticket?key=705790e6b263a8091a6e3debb1ff1d8c&ticket_id=240
                if(isset($_GET['ticket_id'])){
                    $key = $this->chek_key($_GET['key']);
                    $sysuser = $key['sysuser_id'];
                    
                    $chekk_tik_sell = DB::select()->from('ticket')->where('ticket_id','=',$_GET['ticket_id'])->and_where('user_id','=',$sysuser)->execute()->current();
                    
                    if(!empty($chekk_tik_sell)){
                        
                        
                    if($chekk_tik_sell['ticket_type_id'] == 3){
                        echo 1005;
                        die;
                    }
                    
                    
                    $tik_full = DB::select()->from('ticket')->where('ticket_id','=',$_GET['ticket_id'])->execute()->current();
                    $rou_dat = strtotime($tik_full['route_date'].' '.$tik_full['route_time']);
                    $sel_dat = strtotime('now');
                    $proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$tik_full['ferryman_id']);
                    
                    
                    $time_sell = strtotime($tik_full['date_sale']);
                    $now = strtotime(date('Y-m-d H:i:s'));
                    $pas = $now - $time_sell;
                    $v_min = round($pas/60,0);
                    
                    if($chekk_tik_sell['ticket_type_id'] == 1){
                    
                        if($v_min > 30){
                            $price_null = $tik_full['route_price_discount'] - $tik_full['route_price_discount']/100 * $proc;
                        }else{
                            $price_null = $tik_full['route_price_discount'];
                        }
                    
                    }else{
                        $price_null = '';
                    }
                    
                    DB::update('ticket')->set(array(
                    'ticket_type_id'=>3,
                    'user_id'=>$sysuser,
                    'return_price'=>$price_null,    
                    ))->where('ticket_id','=',$_GET['ticket_id'])->execute();
                    
                    DB::insert('ticketreport',array(
                        'ticket_id',
                        'status',
                        'create_report',
                        'sys_user'
                    ))->values(array(
                        $_GET['ticket_id'],
                        3,
                        date('Y-m-d H:i:s'),
                        $sysuser
                    ))->execute();
                    
                    //$join_tik = DB::select()->from('regabus_join_ticks')->where('svitgo_tik','=',$_GET['ticket_id'])->execute()->current();
                    //$reg_tik = intval($join_tik['rega_tik']);
                    $this->anul_soap($_GET['ticket_id']);
                
                    echo 'ticket null (ok)';
                }else{
                    echo 1004;
                }
                }else{
                    echo 1001;
                }
            }else{
                echo 1000;
            }  
        }
    }
    
    
    public function action_ferryman_proc(){
        if($_GET){
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                //http://disp.svitgo.com/api/ferryman_proc?key=d4fdd5c1568b9b6255a5fc655d340cb3&ticket_id=696&format=array
                if(isset($_GET['ticket_id'])){
                    $tik_full = DB::select()->from('ticket')->where('ticket_id','=',$_GET['ticket_id'])->execute()->current();
                    $rou_dat = strtotime($tik_full['route_date'].' '.$tik_full['route_time']);
                    $sel_dat = strtotime('now');
                    $proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$tik_full['ferryman_id']);                    
                    $time_sell = strtotime($tik_full['date_sale']);
                    $now = strtotime(date('Y-m-d H:i:s'));
                    $pas = $now - $time_sell;
                    $v_min = round($pas/60,0);
                    
                    if($v_min < 30){
                        $price_null = $tik_full['route_price_discount'];
                        $proc = 0;
                    }else{
                        $price_null = $tik_full['route_price_discount'] - $tik_full['route_price_discount']/100 * $proc;
                    }
                    
                    //echo $v_min;
                    //if($proc == 0){
                    //    $proc = 100;
                    //}
                    //$price_null = $tik_full['route_price_discount'] - $tik_full['route_price_discount']/100 * $proc;
                    $arrs = array('full_price'=>$tik_full['route_price_discount'],'discount_price'=>$price_null,'percentage'=>$proc);
                    $this->get_format($_GET['format'],$arrs);
                }else{
                    echo 1001;
                }
            }else{
                echo 1000;
            }  
        }
    }
    
    public function action_sale_booking(){
        if($_GET){
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                ///api/null_ticket?key=705790e6b263a8091a6e3debb1ff1d8c&ticket_id=240
                if(isset($_GET['ticket_id'])){
                    $key = $this->chek_key($_GET['key']);
                    $sysuser = $key['sysuser_id'];
                    
                    $chekk_tik_sell = DB::select()->from('ticket')->where('ticket_id','=',$_GET['ticket_id'])->and_where('user_id','=',$sysuser)->execute()->current();
                    
                    if(!empty($chekk_tik_sell)){
                        if($chekk_tik_sell['ticket_type_id'] != 2){
                            echo 1003;
                        }else{
                            DB::update('ticket')->set(array(
                            'ticket_type_id'=>1,
                            'user_id'=>$sysuser,
                            //'return_price'=>$_POST['return_price'],    
                            ))->where('ticket_id','=',$_GET['ticket_id'])->execute();
                            
                            DB::insert('ticketreport',array(
                                'ticket_id',
                                'status',
                                'create_report',
                                'sys_user'
                            ))->values(array(
                                $_GET['ticket_id'],
                                1,
                                date('Y-m-d H:i:s'),
                                $sysuser
                            ))->execute();
                        
                            echo 'ticket sale (ok)';
                        }
                }else{
                    echo 1004;
                }
                }else{
                    echo 1001;
                }
            }else{
                echo 1000;
            }  
        }
    }
    
    
    
    
    public function action_search(){  
        if($_GET) { 
            ///api/search?key=705790e6b263a8091a6e3debb1ff1d8c&format=array&from=все%20остановки,%20Прага&to=все%20остановки,%20Снятын&search_date=26/04/15&return=0&culture=ru
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                if(isset($_GET['culture'])
                && isset($_GET['from'])
                && isset($_GET['to'])
                && isset($_GET['return'])
                && isset($_GET['search_date'])
                && isset($_GET['format'])
                //&& isset($_GET['rice']) 
                ){
                $lang = $_GET['culture'];
               if(!$lang) {
                        $lang = 'EN';
                }
                
                $data = array();
            
            $from = $_GET['from'];
            $to = $_GET['to'];
            $rice = 1;
            $return_from = '';
            $return_to = '';
            
            $lang = array($_GET['culture']);
            //echo $to;
            
            $city = 1;
            $city_to = 1;
                       
            
            //die;
            
            $new_ar = array(array('route_city_id'=>$from,'type'=>array(array('type_id'=>1))));
            
            $new_ar_to = array(array('route_city_id'=>$to,'type'=>array(array('type_id'=>1))));
            
            

            $date = array_reverse(explode('/', $_GET['search_date']));
            $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            
            
            
            
            //print_r($date);
           
            
            $n_d_full = $tran_date.' 00:00:01';
            
            $n_d_full_check = strtotime($tran_date.' 00:00:01');
            $n_d_full_check_now = strtotime('now');
            
            if($n_d_full_check_now > $n_d_full_check){
                echo 'departure - 0';die;
            }
            
            
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

            $sysuser = DB::select()->from('api_keys')->where('key','=',$_GET['key'])->execute()->current();
          
            $sysuser_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$sysuser['sysuser_id'])->execute()->as_array();
            
            
            $all_routes = $this->search_api($from,$to,$tran_date,$day_week,$lang[0],$rice,$sysuser['see_plase'],$_GET['key']);
            //echo '<pre>';
            //print_r($all_routes);
            //echo '</pre>';
            //die;
            $new_all = array();
            if(!empty($all_routes)){
                foreach($all_routes as $al){
                    foreach($sysuser_routes as $routes){
                        if($al['from']['route_name_id'] == $routes['route_name_id']){
                            $new_all[] = $al;
                        }
                    }
                }
            }            
            
            $all_routes = $new_all;
            
            foreach($all_routes as $arr) {
                $new['sorting_by_arrive'][] = $arr['sorting_by_arrive'];
            }
            if(!empty($new)){
                array_multisort($new['sorting_by_arrive'], constant('SORT_ASC'), $all_routes);
            }
            $all_routes_return = array();
            if($_GET['return'] != 0){
                $return_from = $_GET['to'];
                $return_to = $_GET['from'];    
            if(!empty($_GET['search_date'])){
                
              
            $date_return = array_reverse(explode('/', $_GET['return']));
            $tran_date_return = date('Y-m-d', mktime(0, 0, 0, $date_return[1], $date_return[2], $date_return[0]));

            $n_d_full_return = $tran_date_return.' 00:00:01';
                $day_return = date('w',strtotime($n_d_full_return));    
                switch($day_return){
                    case 0:
                    $day_week_return = 6;
                    break;
                    case 1:
                    $day_week_return = 0;
                    break;
                    case 2:
                    $day_week_return = 1;
                    break;
                    case 3:
                    $day_week_return = 2;
                    break;
                    case 4:
                    $day_week_return = 3;
                    break;
                    case 5:
                    $day_week_return = 4;
                    break;
                    case 6:
                    $day_week_return = 5;
                    break;
                } 

            //$all_routes_return = Model::factory('TiketMod')->search_all_route_new($new_ar_to,$new_ar,$tran_date_return,$day_week_return,$rice,$lang[0]);
            $all_routes_return = $this->search_api($to,$from,$tran_date_return,$day_week_return,$lang[0],$rice,1,$_GET['key']);
            
            foreach($all_routes_return as $arr) {
                $neww['sorting_by_arrive'][] = $arr['sorting_by_arrive'];
            }
            if(!empty($neww['sorting_by_arrive'])){
                array_multisort($neww['sorting_by_arrive'], constant('SORT_ASC'), $all_routes_return);
                
                $all_routes[count($all_routes)] = array('return'=>$all_routes_return);
            }
            }
            }
             $res = $this->get_format($_GET['format'],$all_routes);   
                }else{
                    echo 1001;
                }
                
            }else{
                echo 1000;
            }
        }
    }
    
    
    public function action_search_all_citys(){  
        if($_GET) { 
            ///api/search?key=705790e6b263a8091a6e3debb1ff1d8c&format=array&from=все%20остановки,%20Прага&to=все%20остановки,%20Снятын&search_date=26/04/15&return=0&culture=ru
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                if(isset($_GET['culture'])
                && isset($_GET['from'])
                && isset($_GET['to'])
                && isset($_GET['return'])
                && isset($_GET['search_date'])
                && isset($_GET['format'])
                //&& isset($_GET['rice']) 
                ){
                $lang = $_GET['culture'];
               if(!$lang) {
                        $lang = 'EN';
                }
                
                $data = array();
            
            $from = $_GET['from'];
            $to = $_GET['to'];
            $rice = 1;
            $return_from = '';
            $return_to = '';
            
            $lang = array($_GET['culture']);
            //echo $to;
            
            $city = 1;
            $city_to = 1;
                       
            
            //die;
            
            //$new_ar = array(array('route_city_id'=>$from,'type'=>array(array('type_id'=>1))));
            
            //$new_ar_to = array(array('route_city_id'=>$to,'type'=>array(array('type_id'=>1))));
            
            switch($lang[0]){
                case 'ru': 
                
                $cg = strpos($from,'все');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                
                $cg_to = strpos($to,'все');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
              
                break;
                case 'uk':
                $cg = strpos($from,'Всі');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Всі');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'en':
                $cg = strpos($from,'All');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'All');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'cs':
                $cg = strpos($from,'Všechny');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Všechny');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
            }
            
           
            
            $new_ar = array();
            if($city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$new_from[0]."%")->and_where('culture','=',$lang[0])->execute()->as_array();
                
              
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$new_from[0]."%")->and_where('name_i18n','LIKE',"%".$new_from[1]."%")->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_from[1])->and_where('name_i18n','LIKE',"%".$new_from[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar[] = $rr;
            }
            
            
            
           
            
            
            $new_ar_to = array();
            if($city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE','%'.$new_to[0].'%')->and_where('culture','=',$lang[0])->execute()->as_array();
            //   print_r($new_to[1]);
            //die;
                
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$new_to[0]."%")->and_where('name_i18n','LIKE',"%".$new_to[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_to[1])->and_where('name_i18n','LIKE',"%".$new_to[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar_to[] = $rr;
            }
            
            
            /// обратка
            if(!empty($return_to) && !empty($return_from)){
            
            $return_city = 1;
            $return_city_to = 1;
            
            switch($lang[0]){
                case 'ru': 
                
                $cg = strpos($return_from,'все');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                
                $cg_to = strpos($return_to,'все');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
              
                break;
                case 'uk':
                $cg = strpos($return_from,'Всі');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Всі');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'en':
                $cg = strpos($return_from,'All');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'All');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'cs':
                $cg = strpos($return_from,'Všechny');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Všechny');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
            }
            
            
            $return_new_ar = array();
            if($return_city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$return_new_from[1]."%")->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$return_new_from[1]."%")->and_where('name_i18n','LIKE',"%".$return_new_from[1]."%")->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_from[1])->and_where('name_i18n','LIKE',"%".$return_new_from[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar[] = $rr;
            }
            
            
            $return_new_ar_to = array();
            if($return_city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$return_new_to[1]."%")->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','LIKE',"%".$return_new_to[1]."%")->and_where('name_i18n','LIKE',"%".$return_new_to[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_to[1])->and_where('name_i18n','LIKE',"%".$return_new_to[1]."%")->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar_to[] = $rr;
            }
            
            }
            
           

            $date = array_reverse(explode('/', $_GET['search_date']));
            $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            
            
            
            
            //print_r($date);
           
            
            $n_d_full = $tran_date.' 00:00:01';
            
            $n_d_full_check = strtotime($tran_date.' 00:00:01');
            $n_d_full_check_now = strtotime('now');
            
            if($n_d_full_check_now > $n_d_full_check){
            //    echo 'departure - 0';die;
            }
            
            
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
                $sysuser = DB::select()->from('api_keys')->where('key','=',$_GET['key'])->execute()->current();
            // echo '<pre>';   
           //  print_r($new_ar_to);
           //  echo '</pre>';


            //echo '<pre>';
            //print_r($new_ar);
            //echo '</pre>';
            //echo '<pre>';
            //print_r($new_ar_to);
            //echo '</pre>';
            //die;
            // $all_routes = Model::factory('TiketMod')->search_all_route_new($new_ar,$new_ar_to,$tran_date,$day_week,$rice,$lang[0]);
              $all_osts_routes = Model::factory('TiketMod')->get_all_routes_from_osts($new_ar,$new_ar_to);
                
            // echo '<pre>';
            //print_r($all_osts_routes);
            //cho '</pre>';
             
                $all_routes = array();
                foreach($all_osts_routes as $al_r_ost){
           
                    $al_route = $this->search_api($al_r_ost[0],$al_r_ost[1],$tran_date,$day_week,$lang[0],1,$sysuser['see_plase'],$_GET['key']);
                    //die;
                    if(!empty($al_route)){
                        $all_routes[] = $al_route;
                    }
                    
                }
                
                
            
                
            
             //     
              //  echo $all_routes[0]['from']['route_city_id'];
            $all_routes_new = array();
             foreach($all_routes as $meny){
                foreach($meny as $all){
                    $all_routes_new[$all['from']['route_name_id'].$all['from'][0].$all['to'][0].$all['from']['a_time'].$all['to']['a_time']] = $all;
                    //$all_routes_new[] = $all;
                }
             }
             
            
             
             
             $all_routes = $all_routes_new;
             
            
          
            $sysuser_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$sysuser['sysuser_id'])->execute()->as_array();

            $new_all = array();
            if(!empty($all_routes)){
                foreach($all_routes as $al){
                    foreach($sysuser_routes as $routes){
                        if($al['from']['route_name_id'] == $routes['route_name_id']){
                            $new_all[] = $al;
                        }
                    }
                }
            }            
            
             
            
            $all_routes = $new_all;    
                
            //echo '<pre>';
            //print_r($all_routes);
            //echo '</pre>';
            //die;
             //echo '<pre>';
             //print_r($all_routes);
             //echo '</pre>';
             //die;  
            
            
            foreach($all_routes as $arr) {
                $new['sorting_by_arrive'][] = $arr['sorting_by_arrive'];
            }
            if(!empty($new)){
                array_multisort($new['sorting_by_arrive'], constant('SORT_ASC'), $all_routes);
            }
           
            
            $all_routes_return = array();
            if($_GET['return'] != 0){
                    $return_from = $_GET['to'];
                    $return_to = $_GET['from'];    
                if(!empty($_GET['search_date'])){
                        
                      
                    $date_return = array_reverse(explode('/', $_GET['return']));
                    $tran_date_return = date('Y-m-d', mktime(0, 0, 0, $date_return[1], $date_return[2], $date_return[0]));
        
                    $n_d_full_return = $tran_date_return.' 00:00:01';
                        $day_return = date('w',strtotime($n_d_full_return));    
                        switch($day_return){
                            case 0:
                            $day_week_return = 6;
                            break;
                            case 1:
                            $day_week_return = 0;
                            break;
                            case 2:
                            $day_week_return = 1;
                            break;
                            case 3:
                            $day_week_return = 2;
                            break;
                            case 4:
                            $day_week_return = 3;
                            break;
                            case 5:
                            $day_week_return = 4;
                            break;
                            case 6:
                            $day_week_return = 5;
                            break;
                        } 
        
                    //$all_routes_return = Model::factory('TiketMod')->search_all_route_new($new_ar_to,$new_ar,$tran_date_return,$day_week_return,$rice,$lang[0]);
                    $all_routes_return = $this->search_api($to,$from,$tran_date_return,$day_week_return,$lang[0],$rice,1,$_GET['key']);
                    //print_r($all_routes);
                    foreach($all_routes_return as $arr) {
                        $neww['sorting_by_arrive'][] = $arr['sorting_by_arrive'];
                    }
                    if(!empty($neww['sorting_by_arrive'])){
                        array_multisort($neww['sorting_by_arrive'], constant('SORT_ASC'), $all_routes_return);
                        
                        $all_routes[count($all_routes)] = array('return'=>$all_routes_return);
                    }
                }
            }
            
            
            
            
             $res = $this->get_format($_GET['format'],$all_routes); 
            //echo '<pre>';   
            //print_r($all_routes);
            //echo '</pre>';
            //die;  
                }else{
                    echo 1001;
                }
                
            }else{
                echo 1000;
            }
        }
    }
    
    
    
    
    public function action_all_discounts() {  
        ///api/all_discounts?key=0210946574f0f4f6c32d1474fc0da483&format=array&culture=ru
        
        /// chek
        
        if($_GET) { 
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                if(isset($_GET['format'])) {
                    $key = $this->chek_key($_GET['key']);
                    $sysuser = $key['sysuser_id'];
                    $group = $key['group_id'];
                    
                    $all_sys_dis = DB::select('dis_id')->from('system_users_discounts')->where('sys_id','=',$sysuser)->execute()->as_array();
                    $all = array();
                    foreach($all_sys_dis as $al){
                        $all[] = $al['dis_id'];
                    }
                    
                    $format_arrey = DB::select('main_id','value','name_i18n')->from('tickerdiscount')
                    ->join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')
                    
                    ->where('tickerdiscount.ticker_discount_id','in',$all)
                    ->and_where('culture','=',$_GET['culture'])
                    ->execute()->as_array();
    
                    $res = $this->get_format($_GET['format'],$format_arrey);
                }else{
                    echo 1001;
                }
            }else {
                echo 1000;
            }
        }
    }
    
     public function action_all_stations() {  
        ///api/all_stations?key=705790e6b263a8091a6e3debb1ff1d8c&format=array&culture=ru
        
        /// chek
        
        if($_GET) { 
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                if(isset($_GET['format']) && isset($_GET['culture'])) {
                    $format_arrey = DB::select()->from('routecity')
                    ->join('routecity_i18n')->on('routecity.route_city_id','=','routecity_i18n.route_city_id')
                    ->join('ost_types')->on('routecity.route_city_id','=','ost_types.route_city_id')
                    ->where('culture','=',$_GET['culture'])->execute()->as_array();
                    $res = $this->get_format($_GET['format'],$format_arrey);
                }else {
                    echo 1001;
                }

            }else{
                echo 1000;
            }
        }
    }
    
     public function action_all_route_stations() {  
        ///api/all_route_stations?key=0210946574f0f4f6c32d1474fc0da483&route_name_id=1590&format=array&culture=ru
        
        /// chek
        
        if($_GET) { 
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                    if(isset($_GET['format']) && isset($_GET['culture']) && isset($_GET['route_name_id'])) {
                        $format_arrey = DB::select('route.route_city_id','name_i18n','city_i18n','route.weight','route.r_id','address')->from('route')
                        ->join('routecity')->on('route.route_city_id','=','routecity.route_city_id')
                        ->join('routecity_i18n')->on('routecity.route_city_id','=','routecity_i18n.route_city_id')
                        ->join('ost_types')->on('routecity.route_city_id','=','ost_types.route_city_id')
                        ->where('route_name_id','=',$_GET['route_name_id'])
                        ->order_by('route.weight')
                        ->and_where('culture','=',$_GET['culture'])->execute()->as_array();
                        
                        
                        $new_format = array();
                        foreach($format_arrey as $al_ost){
                            $al_ost['stops_time'] = DB::select('week_id','hours')->from('routeweek')->where('r_id','=',$al_ost['r_id'])->order_by('week_id','ASC')->execute()->as_array();
                            $new_format[] = $al_ost;
                        }
                        
                        $format_arrey = $new_format;
                        
                        $res = $this->get_format($_GET['format'],$format_arrey);
                    }else{
                        echo 1001;
                    }
                }else {
                    echo 1000;
                }
                //?route_from=1618&route_to=2&search_date=08%2F03%2F2013&search_time=12%3A21&far=1
                //$data = array();
                //$data['all_results'] = Model::factory('Rout')->search_main($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far'],0);
                //$data['all_results_one'] = Model::factory('rout')->search_main_one($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far']);
                //echo json_encode($data);
        }
    }
    
    public function action_all_routes() {
        ///api/all_routes?key=705790e6b263a8091a6e3debb1ff1d8c&format=array&culture=ru
        
        /// chek
        if($_GET) { 
            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
               if(isset($_GET['culture']) && isset($_GET['format'])){
                    $key = $this->chek_key($_GET['key']);
                    $sysuser = $key['sysuser_id'];
                    $al_sys = DB::select('route_name_id')->from('system_users_routes')
                    ->where('sysuser_id','=',$sysuser)
                    ->execute()->as_array();
                     
                    
                    $res = DB::select('routename.route_name_id','name','name_i18n')->from('routename')
                    ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                    ->where('routename.route_name_id','in',$al_sys)
                    ->and_where('culture','=',$_GET['culture'])
                    ->execute()->as_array();
                    
                    $res = $this->get_format($_GET['format'],$res);
                }else{
                    echo 1001;
                }
            }else{
                echo 1000;
            }
        } 
    }
    
    public function action_get_all_route_dates() {  
        if($_GET) { 
            // /api/get_all_route_dates?key=705790e6b263a8091a6e3debb1ff1d8c&route_name_id=1590&format=array
            
            /// chek

            if(isset($_GET['key']) && is_array($this->chek_key($_GET['key'])) === true) {
                if(isset($_GET['route_name_id']) && isset($_GET['format'])){
                    $res = DB::select('date')->from('routeferrymanweek')
                    ->where('routeferrymanweek.route_name_id','=',$_GET['route_name_id'])->
                    order_by('date','ASC')->execute()->as_array();
                    $this->get_format($_GET['format'],$res);
                }else{
                    echo 1001;
                }
            }else {
                echo 1000;
            }
            //?route_from=1618&route_to=2&search_date=08%2F03%2F2013&search_time=12%3A21&far=1
            //$data = array();
            //$data['all_results'] = Model::factory('Rout')->search_main($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far'],0);
            //$data['all_results_one'] = Model::factory('rout')->search_main_one($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far']);
            //echo json_encode($data);
            
        }
    }
    
     public function action_first()
    {  
        if($_GET) { 
            $str = '705790e6b263a8091a6e3debb1ff1d8c';
            if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true && isset($_GET['culture'])) {
                $res = DB::select()->from('RouteCity')
                ->join('RouteCity_i18n')->on('RouteCity.route_city_id','=','RouteCity_i18n.route_city_id')
                ->where('culture','=',$_GET['culture'])->execute()->as_array();
                //echo json_encode($res);
                $new_obj = array(count($res),'test');
                print_r($new_obj);
            }else {
                echo 'error';
            }
            //?route_from=1618&route_to=2&search_date=08%2F03%2F2013&search_time=12%3A21&far=1
            //$data = array();
            //$data['all_results'] = Model::factory('Rout')->search_main($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far'],0);
            //$data['all_results_one'] = Model::factory('rout')->search_main_one($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far']);
            //echo json_encode($data);
            
        }
    }
    
    public function chek_key($key){
        
        $key_chek = DB::select()->from('api_keys')->where('key','=',$key)->execute()->current();
        if(!empty($key_chek)){
            $new_cou = $key_chek['count_query'] + 1;
            DB::update('api_keys')->set(array(
            'count_query'=>$new_cou,
            ))->where('id','=',$key_chek['id'])->execute();
            return $key_chek;
        }else{
            return false;
        }
    }
    
    public function action_api()
    {  
        $res = file_get_contents('http://svitgo.com/api/get_info?route_from=1618&route_to=2&search_date=08%2F03%2F2013&search_time=01%3A21&far=1');
        print_r($res);
        die;
    }
    public function action_autocomp() {
        
    $param =  'Кие';
    
    $limit = 18;
    
    $res = DB::query(Database::SELECT, "SELECT * FROM citys JOIN RouteCity_i18n ON citys.city_name LIKE RouteCity_i18n.city_i18n WHERE city_name LIKE '%$param%' AND RouteCity_i18n.culture = 'ru' LIMIT $limit")->execute()->as_array();

    if(!empty($res)) {
        echo "<script>$('.auto_one').hover(function(){
                $(this).css('background-color','#f3c50f');
                $(this).find('.auto_title').css('color', '#000');
                $(this).find('.auto_desc').css('color', '#000');
            },function(){
                $(this).css('background-color','#005399');
                $(this).find('.auto_title').css('color', '#f2f2f2');
                $(this).find('.auto_desc').css('color', '#bfddf8');
            });
            $('.auto_one').click(function(){
                var Left_id = $(this).children('.city_id_left').val();
                var Left_name = $(this).children('.city_name_left').val();
                $('.route_input_from').val(Left_name);
                $('.route_from').val(Left_id);
                $('#suggestions').fadeOut();
                
            });
            </script>";
     /*    echo '<div class="title_city_window"><p>Выбирите отсановку, город , почтовый индекс</p></div>';
		echo '<div class="up_suggestions">';
        
	foreach($res as $city_name) {
        
        echo '<div class="auto_one" id="auto_main">';
        echo '<p>'.$city_name['city_i18n'].'</p>';
        echo '<div class="auto_img"><img src="'.Kohana::$base_url.'images/trein_icon.png" alt="" /></div><input type="hidden" class="city_id_left" value="'.$city_name['route_city_id'].'"><input type="hidden" class="city_name_left" value="'.$city_name['name_i18n'].'">';
        echo '<div class="auto_info"><p class="auto_title">'.$city_name['route_city_id'].' '.$city_name['name_i18n'].' - '.$city_name['desc_i18n'].'</p><p class="auto_desc">Поезд | '.$city_name['address'].' <span style="color:red;">'.$city_name['code'].'</span></p></div><div class="clearfix"></div></div>';
	}*/
    foreach($res as $re) {
        $city[$re['city_i18n']][] = $re;
    }
    echo '<pre>';    
    print_r($city);
    echo '</pre>';
    foreach($city as $cit=>$all_ost) {
        echo '<p>'.$cit.'</p>';
        echo '<ol>';
        foreach($all_ost as $oss) {
            echo '<li>'.$oss['name_i18n'].'</li>';
        }
        echo '</ol>';
    }
    
	die;

    }
    }
    
   	public function action_loc_() {
        if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true && isset($_GET['culture'])) {  
		$lang = $_GET['culture'];
		$table = array();
		$parts = explode('-', $lang);
		do {
			$path = implode(APPPATH, $parts);
			if ($files = Kohana::find_file('i18n', $path, NULL, TRUE)){
				$t = array();
				foreach ($files as $file){
					$t = array_merge($t, Kohana::load($file));
				}
				$table += $t;
			}
			array_pop($parts);
		}
		while ($parts);
        $loc = array(count($table),$table);
        echo '<pre>';
        print_r($loc);
        echo '</pre>';
        }else {
            echo 'error URL';
        }
	} 
    
    public function action_loc() {
        $res = DB::select('key')->from('mobile_loc')
                //->join('mobile_loc_i18n')->on('mobile_loc_i18n.key','=','mobile_loc.key')
                ->execute()->as_array();
        foreach($res as $re){
            $bes['key'] = $re['key'];
            $bes['all'] = DB::select()->from('mobile_loc_i18n')
                ->where('key','=',$re['key'])
                ->execute()->as_array();
            $h[] = $bes;
        }
        foreach($h as $ses){
            $vf = array();
            for($i=0;$i<count($ses['all']);$i++){
                $new = array();
                $new = array($ses['all'][$i]['culture'] => $ses['all'][$i]['name']); 
                array_push($vf,$new);  
            }
            //$ses[0] = $ses['key'];
            $ses['all'] = $vf;
            //$df[$her['all']['culture']] = $her['all']['name'];
            $pp[] = $ses;
        }
        //echo '<pre>';
        //print_r($pp);
        //echo '</pre>';
        echo json_encode($pp);
        
	} 
    
    public function action_all_schedule()
    {  
        if($_GET) { 
            ///api/all_schedule?key=705790e6b263a8091a6e3debb1ff1d8c&format=xml&culture=ru
            $str = '705790e6b263a8091a6e3debb1ff1d8c';
            if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true && isset($_GET['culture'])) {
                $res = DB::select('RouteName.route_id','RouteName.name','RouteName.route_name_id','RouteName_i18n.name_i18n',array('RouteName.types','route_type_id'))->from('RouteName')->distinct(true)
                ->join('RouteName_i18n')->on('RouteName.route_name_id','=','RouteName_i18n.route_name_id')
                ->and_where('RouteName_i18n.culture','=',$_GET['culture'])
                //->limit(1)
                ->execute()->as_array();
                $new = array();
                foreach($res as $re){
                     $osr =  DB::select('route_city_id','route_type_id')->from('Route')->where('route_name_id','=',$re['route_name_id'])->execute()->as_array();
                     $os_al = '';
                     foreach($osr as $os){
                        $os_al .= $os['route_city_id'].'|';
                    }
                    //$re['city_ids'] = $os_al;
                    array_push($re,$os_al);
                    $new[] = $re;
                    
                }
                foreach($new as $nf){
                    $bf[] = $nf;
                }
                //echo json_encode($bf);
                //echo '<pre>';
                //print_r($new);
                //echo '</pre>';
                $format_arrey  = $bf;
                $this->get_format($_GET['format'],$format_arrey);
                
            }else {
                echo 'error';
            }
            //?route_from=1618&route_to=2&search_date=08%2F03%2F2013&search_time=12%3A21&far=1
            //$data = array();
            //$data['all_results'] = Model::factory('Rout')->search_main($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far'],0);
            //$data['all_results_one'] = Model::factory('rout')->search_main_one($_GET['route_from'],$_GET['route_to'],$_GET['search_date'],$_GET['search_time'],$_GET['far']);
            //echo json_encode($data);
            
        }
    }
    
    
    
    public function action_xml(){
    $dom = new domDocument("1.0", "utf-8"); // Создаём XML-документ версии 1.0 с кодировкой utf-8
    $root = $dom->createElement("users"); // Создаём корневой элемент
    $dom->appendChild($root);
    $logins = array("User1", "User2", "User3"); // Логины пользователей
    //$passwords = array("Pass1", "Pass2", "Pass3"); // Пароли пользователей
    //for ($i = 0; $i < count($logins); $i++) {
    //$id = $i + 1; // id-пользователя
    $user = $dom->createElement("user"); // Создаём узел "user"
    $user->setAttribute("id", 47); // Устанавливаем атрибут "id" у узла "user"
    $login = $dom->createElement("login", '$logins[$i]'); // Создаём узел "login" с текстом внутри
    //$password = $dom->createElement("password", $passwords[$i]); // Создаём узел "password" с текстом внутри
    $user->appendChild($login); // Добавляем в узел "user" узел "login"
    //$user->appendChild($password);// Добавляем в узел "user" узел "password"
    $root->appendChild($user); // Добавляем в корневой узел "users" узел "user"
    //}
    //print_r($dom);
    //echo '<pre>';
    echo $dom->saveXML();
    //echo '</pre>';
    //$dom->save("users.xml"); // Сохраняем полученный XML-документ в файл
    die;
    }
    
    function get_format($format,$array){
        switch($format){
            case'json':
            echo json_encode($array);
            break;
            case'xml':
            $xml = new Xml();
            $xml_res = $xml->creete_xml($array);
            echo $xml_res;
            die;
            break;
            case'array':
            echo '<pre>';
            print_r($array);
            echo '</pre>';
            break;
            default:
            echo json_encode($array);
            die;
        }
    }

    
    
     public function action_get_route_ost() {
        ///api/get_route_ost?key=705790e6b263a8091a6e3debb1ff1d8c&route=1591&culture=ru&format=array
        if($_GET) { 
            if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true) {
                $res = DB::select()->from('route')
                ->join('routecity_i18n')->on('route.route_city_id','=','routecity_i18n.route_city_id')
                ->where('route_name_id','=',$_GET['route'])
                ->and_where('culture','=',$_GET['culture'])
                ->order_by('weight')->execute()->as_array();
                if(isset($_GET['format'])){
                    $res = $this->get_format($_GET['format'],$res);
                }else {
                    print_r($format_arrey);
                    die;
                }
            }
        } 
    }
    
    public function action_php() {
        phpinfo();
        die;
    }
    
    public function action_get_route_dates(){
        ///api/get_route_dates?key=705790e6b263a8091a6e3debb1ff1d8c&route=1591&format=array
        if($_GET){
            if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true) {
                $res = DB::select()->from('routeferrymanweek')
                ->where('route_name_id','=',$_GET['route'])
                ->order_by('date')
                ->execute()->as_array();
                if(isset($_GET['format'])){
                    $res = $this->get_format($_GET['format'],$res);
                }else {
                    print_r($format_arrey);
                    die;
                }
            }
            
            
        }
    }
    
    public function action_get_route_price(){
        ///api/get_route_price?key=705790e6b263a8091a6e3debb1ff1d8c&route=1591&city_from=935&city_to=1290&valute=EUR&culture=ru&format=array
        if($_GET){
            if(isset($_GET['key']) && $this->chek_key($_GET['key']) === true) {
                $res = DB::select()->from('routeprice')
                ->where('route_name_id','=',$_GET['route'])
                ->and_where('route_city_from_id','=',$_GET['city_from'])
                ->and_where('route_city_to_id','=',$_GET['city_to'])
                ->and_where('valute','=',$_GET['valute'])
                ->execute()->as_array();
                if(isset($_GET['format'])){
                    $res = $this->get_format($_GET['format'],$res);
                }else {
                    print_r($format_arrey);
                    die;
                }
            }
            
            
        }
    }
    
    
    public function action_test(){ 
         
         $now_sec = strtotime('now');
        $last_sec = strtotime('+3 month');
        //$last_sec = strtotime($last_day['date']);
        
        $raznitca = $last_sec - $now_sec;
        
        //$raznitca = $plus - $now_sec; //86400
        
        $newnew = round($raznitca/(3600*24));
        
        $dat_array = array();
        $NewDate = date('Y-m-d');
        for($i=1;$i<=$newnew;$i++){
            $NewDate = Date('Y-m-d',strtotime('+1 day', strtotime($NewDate)));
            $dat_array[] = array($NewDate,date('w',strtotime($NewDate)));            
        }
        //$newnew
        $all_cron = DB::select()->from('cron')->execute()->as_array();
        
        
        foreach($all_cron as $cr){
          //  $route_cron = DB::select()->from('cron')->where('route_name_id','=',$cr['route_name_id'])->and_where('ferryman_id','=',$cr['ferryman_id'])->execute()->current();
        
        //echo '<pre>';
        //print_r($route_cron);
        //echo '</pre>';
        //die;
            $all_date_need = explode(',',$cr['type']);
            
            foreach($dat_array as $dates){
                foreach($all_date_need as $need){
                    if($dates[1] == $need){
                        //echo '<pre>';
                        //print_r($dates);
                        //echo '</pre>';
                        $chek = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$cr['route_name_id'])->and_where('ferryman_id','=',$cr['ferryman_id'])->and_where('date','=',$dates[0])->execute()->current();
                        if(empty($chek)){
                            DB::insert('routeferrymanweek',array(
                                'route_name_id',
                                'ferryman_id',
                                'date',
                                'rice',
                                'buses_id',
                                'route_type_id'
                            ))->values(array(
                                $cr['route_name_id'],
                                $cr['ferryman_id'],
                                $dates[0],
                                1,
                                $cr['bus_id'],
                                1
                            ))->execute();
                        }
                    }
                }
            }
        }
        
       $this->redirect('/');
    }
    
    public function action_ajax_refresh_cron(){
        if($_POST){
            DB::delete('cron')->where('route_name_id','=',$_POST['step_id'])->and_where('ferryman_id','=',$_POST['fer_id'])->and_where('bus_id','=',$_POST['bus_id'])->execute();
            
            DB::insert('cron',array(
                'route_name_id',
                'ferryman_id',
                'bus_id',
                'type'
            ))->values(array(
                $_POST['step_id'],
                $_POST['fer_id'],
                $_POST['bus_id'],
                implode(',',$_POST['type'])
            ))->execute();
            //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        //die;
        }
        
    }
    
    public function action_del_cron_dates(){
        if($_GET){
            DB::delete('cron')->where('route_name_id','=',$_GET['route_name_id'])->and_where('ferryman_id','=',$_GET['fer_id'])->and_where('bus_id','=',$_GET['bus_id'])->execute();
            
        $this->redirect('/route/edit_route3?route_name_id='.$_GET['route_name_id']);
            //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        //die;
        }
        
    }
    
    
    public function action_ajax_show_cron_dates(){
        if($_POST){
            $route_cron = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ferryman_id','=',$_POST['id'])->and_where('bus_id','=',$_POST['bus_id'])->execute()->current();
        
        echo $route_cron['type'];
        //echo '<pre>';
        //print_r($route_cron);
        //echo '</pre>';
        //die;
        }
        
    }
    
    public function action_test_pdf(){ 
        
        $data = array();
        $html = '';
                

        $tikets = array(61);
        $tik_full = DB::select('ticket_id','client_id','ferryman_id')->from('ticket')->where('ticket_id','in',$tikets)->order_by('ferryman_id','ASC')->execute()->as_array();

        //$last_user = '';
        $data['lang'] = 'ru';
        
        $data['id'] = 61;
         
         
        for($i = 1; $i<=20; $i++){         
        $html .= View::factory('tiket/ticket_ferryman/13/priamoy',$data);
        }
        $name = '999';

        $PDF = Model::factory('Pdf');
        
        $start_path = $PDF->chek_dir_date();
        
        $pdf_link = $PDF->save_pdf($name,$start_path,$html);
        
        echo $pdf_link;
        
         die;
    
    }
    
    public function action_test_nikolo_soap(){
        
        $route_name_id = $_GET['route'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $route_date = $_GET['date'];
        
        
        $nikol_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$route_name_id)->execute()->current();
        $nikolo_from_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$from)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
        $nikolo_to_ost = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)->and_where('join_route','=',$nikol_route['reg_route_id'])->execute()->current();
        
        echo '<pre>';
        print_r($nikol_route);
        print_r($nikolo_from_ost);
        print_r($nikolo_to_ost);
        echo '</pre>';
        
        echo $route_date;
        
        $chek_date = Model::factory('TiketMod')->get_date_for_api_soap($route_date,$route_name_id,$from);
        //print_r($chek_date);
        //die;
        
        
        $all_free = array();
        $route = new stdClass();
        $route->route_id = $nikol_route['reg_route_id'];
        $route->from_id = $nikolo_from_ost['reg_ost_id'];
        $route->to_id = $nikolo_to_ost['reg_ost_id'];
        $route->date = $route_date;
        $regabus = new Regabus();
        $all = $regabus->get_route($route);
        
        if($chek_date == 1){
            $d = new DateTime($route_date);
            $d->modify("-1 day");
            $route_date = $d->format("Y-m-d");
            echo $route_date;
            $route = new stdClass();
            $route->route_id = $nikol_route['reg_route_id'];
            $route->from_id = $nikolo_from_ost['reg_ost_id'];
            $route->to_id = $nikolo_to_ost['reg_ost_id'];
            $route->date = $route_date;
            $regabus = new Regabus();
            $all = $regabus->get_route($route);
        //    $all = $regabus->get_route($route_date);
        }
        
        echo '<pre>';
        print_r($all);
        echo '</pre>';
        die;
        ///*
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
        $sale->seat = 15;
        $sale->discount_id = 0;
        
        
        
        $client = new stdClass();
        $client->name = 'Soap';
        $client->surname = 'Soap2';
        $client->tel = '12121212';
        $client->birth_date= '1980-10-21';
        
        
        $ticket_id = $regabus->sell($sale, $client); 

        
        //*/
        
        
        print_r($ticket_id);
        
        die;
    }
    
        public function action_test_nikolo_soap2(){
        
        $route_name_id = $_GET['route'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $route_date = $_GET['date'];
        
        
        
        
        $all_free = array();
        $route = new stdClass();
        $route->route_id = $route_name_id;
        $route->from_id = $from;
        $route->to_id = $to;
        $route->date = $route_date;
        $regabus = new Regabus();
        $all = $regabus->get_route($route);

        
        echo '<pre>';
        print_r($all);
        echo '</pre>';
        die;
        ///*
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
        $sale->seat = 15;
        $sale->discount_id = 0;
        
        
        
        $client = new stdClass();
        $client->name = 'Soap';
        $client->surname = 'Soap2';
        $client->tel = '12121212';
        $client->birth_date= '1980-10-21';
        
        
        $ticket_id = $regabus->sell($sale, $client); 

        
        //*/
        
        
        print_r($ticket_id);
        
        die;
    }
    
    function search_api($from,$to,$route_date,$day_week,$lang,$rice,$see_plase,$key){
        //$route_name_id = 689;     
        
        
           
        $all_minus = $this->find_routes_minus_date($from,$to,$route_date);
        
            
        $d = new DateTime($route_date);
        $d->modify("+1 day");
        $route_date = $d->format("Y-m-d");
                
        $all_current = $this->find_routes_curr_date($from,$to,$route_date);
        
        //echo '<pre>';
        //print_r($all_current);
        //echo '</pre>';
        
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
            
            $re['from'] = $all[1];
            $re['from']['route_name_id'] = $all[0];
            $weight = DB::select()->from('route')->where('r_id','=',$all[1]['r_id'])->execute()->current();
            $re['from']['weight'] = $weight['weight'];
            $ost_from_name = Model::factory('OstMod')->get_ost($all[1][0],$lang);
            $ost_to_name = Model::factory('OstMod')->get_ost($all[2][0],$lang);
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
            $weight2 = DB::select()->from('route')->where('r_id','=',$all[2]['r_id'])->execute()->current();
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
            
            //$bizi = Model::factory('TiketMod')->block_plase($all[0],$day['date'],$day['buses_id'],$day['ferryman_id'],$all[1][0],$all[2][0]);// 
            //$sell_array = Model::factory('TiketMod')->sell_plase_api($all[0],$all[1][1],$day['buses_id'],$day['ferryman_id'],$all[1][0],$all[2][0]);
            
            if($see_plase == 1){
                $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($all[0],$all[1][0],$all[2][0],$all[1][1]); //отключил 25
            }else{
                $all_blocked_plase = array();
            }
            
            //
            //print_r($sell_array);
            
            $sell = array();
            //foreach($sell_array as $tes=>$vall){
            //    $sell[] = $vall['value'];   
            //}                            //$bizi = count(Model::factory('TiketMod')->block_plase($arr['from']['route_name_id'],$arr['from']['date'],$arr['from']['buses_id'],$arr['from']['ferryman_id'],$arr['from']['route_city_id'],$arr['to']['route_city_id']));//       
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
           $re['all_free_plases'] = $all_blocked_plase;//array_diff($all_free_plases,$sell); 
           $re['free_plases'] = count($re['all_free_plases']);//count(DB::select()->from('BScheme')->where('buses_id','=',$day['buses_id'])->execute()->as_array()) - $bizi;
           
           
           $key_api = DB::select()->from('api_keys')->where('key','=',$key)->execute()->current();
           
           ///////////////////////
           $chek_group_price = Model::factory('GroupMod')->chek_group_price_api($key_api['group_id'],$all[0],$day['ferryman_id'],$all[1][0],$all[2][0],$all[1][1],1);
            //if(!empty($chek_group_price)){
            //    $re['route_price'] = $chek_group_price;
            //}else{
            $re['route_price'] = DB::select('price','valute')->from('routeprice')->where('route_city_from_id','=',$all[1][0])->and_where('route_city_to_id','=',$all[2][0])->and_where('route_name_id','=',$all[0])->execute()->as_array();
            //}
            
           //////////////
           
           unset($re['from'][1]);
           unset($re['from'][2]);
           unset($re['from'][3]);
           unset($re['to'][1]);
           unset($re['to'][2]);
           unset($re['to'][3]);
           $all_simple[] = $re;
        }   
        //echo $route_date;
        //echo '<pre>';  
        //print_r($all_simple);  
        //echo '</pre>';
        return $all_simple;
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
            
            
            //print_r($all_new);
            
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
                    if(!empty($min_ost) && is_array($min_ost)){
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
                    
                    }
                    //$i++;
                }
                $new_dates_ost[] = $min_ost_min;
            }
            
            
        }
        
        //echo '<pre>';
        //print_r($new_dates_ost);
        //echo '</pre>';
       
        $new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                    if((isset($rpotes[$i]['a_time']) && !empty($rpotes[$i]['a_time'])) || (isset($rpotes[$i]['time']) && !empty($rpotes[$i]['time']))){
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
                            //echo '<pre>';
                            //print_r($toto);
                            //echo '<pre>';
                            
                            
                            
                            
                            if(!empty($toto['a_time'])){
                                $ost_finish[$route] = array($route,$rpotes[$i],$toto);
                            }
                            
                        }
                        
                    }
                }
            }            
        }
        
        
        return $ost_finish;
        
       
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
        foreach($chek as $new_chek){
            $min_ost_min = array();
            if(!empty($new_chek['dates']['minus'][0])){
                for($i=0;$i<count($new_chek['all_osts']);$i++){
                    $min_ost = DB::select('r_id','a_time','time')->from('routeweek')->where('route_name_id','=',$new_chek['route_name_id'])->and_where('r_id','=',$new_chek['all_osts'][$i]['r_id'])->and_where('week_id','=',$new_chek['dates']['minus'][1])->execute()->current();
                    if(!empty($min_ost) && is_array($min_ost)){
                        
                    
                    $from = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['time']);
                    $to = strtotime($new_chek['dates']['minus'][0]['date'].' '.$min_ost['a_time']);
                    
                    
                    //echo '<pre>';
                    //var_dump($min_ost);
                    //echo '</pre>';
                    //die;
                    //if()
                    //if(is_array($min_ost)){
                        array_push($min_ost,$new_chek['all_osts'][$i]['route_city_id']);
                        array_push($min_ost,$new_chek['dates']['minus'][0]['date']);
                        array_push($min_ost,$from);
                        array_push($min_ost,$to);
                    //}
                    //if(isset($new_chek['all_osts'][$i+1]['a_time'])){
                    //    $to_next = strtotime($new_chek['dates']['minus'][0]['date'].' '.$new_chek['all_osts'][$i+1]['a_time']);
                    //    array_push($min_ost,$to_next);
                    //}
                    $min_ost_min[$new_chek['route_name_id']][] = $min_ost;
                    }
                    
                    //$i++;
                }
                $new_dates_ost[] = $min_ost_min;
            }
            
            
        }
       
        $new_dates_ost_new = array();
        $ost_finish = array();
        foreach($new_dates_ost as $new_chek){
            foreach($new_chek as $route=>$rpotes){
                $dates = $date_day_min;
                for($i=0;$i<count($rpotes);$i++){
                   if((isset($rpotes[$i]['a_time']) && !empty($rpotes[$i]['a_time'])) || (isset($rpotes[$i]['time']) && !empty($rpotes[$i]['time']))){
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
                            if(!empty($toto['a_time'])){
                                $ost_finish[$route] = array($route,$rpotes[$i],$toto,$date_day_min);
                            }
                        }
                        
                    }
                }
            }            
        }
        
        return $ost_finish;
        
       
    }
    
    
    public function action_test_new_model(){
        $route_name_id = 1653;
        $from = 897;
        $to = 884;
        $date = '2015-10-14';
        $chek_date_model = Model::factory('TiketMod')->find_routes_minus_date_model($route_name_id,$from,$to,$date);
        echo '<pre>';
        print_r($chek_date_model);
        echo '</pre>';
        die;
        die;
    }
    
    function anul_soap($tik_id){
       $join_tik = DB::select()->from('regabus_join_ticks')->where('svitgo_tik','=',$tik_id)->execute()->current();
        $route = new stdClass();
        $route->route_id = $join_tik['rega_route'];
        $route->from_id = $join_tik['rega_from'];
        $route->to_id = $join_tik['rega_to'];
        $route->date = $join_tik['rega_date'];
        $regabus = new Regabus();
        $all = $regabus->get_route($route);

        
        //print_r($conect);
        //die;
        
        $regabus = new Regabus();
        $reg_tik = trim($join_tik['rega_tik']);
        
        $res = $regabus->anule_rega($reg_tik);
        //$res = $regabus->anule_nikolo($join_tik['rega_tik']);
        print_r($res);
        //$regabus->anule($join_tik['rega_tik'],1);
        //$regabus = new Regabus();
        //$regabus->anule('1496283');
    }
    
    public function action_anul_soap_new(){
        $join_tik = DB::select()->from('regabus_join_ticks')->where('svitgo_tik','=',$_GET['id'])->execute()->current();
        $route = new stdClass();
        $route->route_id = $join_tik['rega_route'];
        $route->from_id = $join_tik['rega_from'];
        $route->to_id = $join_tik['rega_to'];
        $route->date = $join_tik['rega_date'];
        $regabus = new Regabus();
        $all = $regabus->get_route($route);

        
        //print_r($conect);
        //die;
        
        $regabus = new Regabus();
        $reg_tik = trim($join_tik['rega_tik']);
        
        $res = $regabus->anule_rega($reg_tik);
        //$res = $regabus->anule_nikolo($join_tik['rega_tik']);
        print_r($res);
        //$regabus->anule($join_tik['rega_tik'],1);
        //$regabus = new Regabus();
        //$regabus->anule('1496283');
    }
    
    public function action_get_free_plase(){
        
        $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($_GET['route_name_id'],$_GET['from'],$_GET['to'],$_GET['date']); //отключил
        $res = $this->get_format('json',$all_blocked_plase);
        return $res;
        //print_r($all_blocked_plase);
    }
    
    public function action_chek_kaznachey_status(){
        //$url = "http://torrnado.ru/viewtopic.php?t=154410";
        //$url = "http://torrnado.ru";
        $url = "https://svitgo.com/uk";
        $result = $this->getUrlContent($url);
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
    
    public function action_chek_kaznachey_status2(){
        //$url = "http://torrnado.ru/viewtopic.php?t=154410";
        //$url = "http://torrnado.ru";
        $url = "https://www.regabus.cz/api/kaznachey_status";
        $result = $this->getUrlContent($url);
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
    
    function getUrlContent($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'test' => 'hello disp.ua', ));
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo '<pre>';
        print_r($httpcode);
        echo '</pre>';
        return $data;//($httpcode>=200 && $httpcode<300) ? $data : false;
    }
    
    public function action_test_newblock_cron(){
        $now_sec = strtotime('now');
        $last_sec = strtotime('+3 month');
        
        $raznitca = $last_sec - $now_sec;
    
        $newnew = round($raznitca/(3600*24));
        
        $dat_array = array();
        $NewDate = date('Y-m-d');
        for($i=1;$i<=$newnew;$i++){
            $NewDate = Date('Y-m-d',strtotime('+1 day', strtotime($NewDate)));
            $dat_array[] = array($NewDate,date('w',strtotime($NewDate)));            
        }
        
        $now_day_week = date('w');
        $only_day = array();
        foreach($dat_array as $one_date){
            if($one_date[1] == $now_day_week){
                $only_day[] = $one_date;
            }
        }
        
        $all_new_cron_blocket = DB::select()->from('newblocket_plase')
        //->and_where('week_id','=',$now_day_week)
        ->and_where('blocket_type','=','week')->execute()->as_array();
        
        foreach($all_new_cron_blocket as $one_cron_block){
            foreach($dat_array as $only){
                $chek_block_last_date = DB::select()->from('newblocket_plase')->where('route_name_id','=',$one_cron_block['route_name_id'])
                ->and_where('blocket_type','=','day')
                ->and_where('ferryman','=',$one_cron_block['ferryman'])
                ->and_where('buses','=',$one_cron_block['buses'])
                ->and_where('week_id','=',$one_cron_block['week_id'])
                ->and_where('plases','=',$one_cron_block['plases'])
                ->order_by('date','DESC')
                ->execute()->current();
                if(strtotime($only[0]) > strtotime($chek_block_last_date['date']) && $one_cron_block['week_id'] == $only[1]){
                    DB::insert('newblocket_plase',array(
                        'route_name_id',
                        'blocket_type',
                        'plases',
                        'date',
                        'ferryman',
                        'sesuser',
                        'buses',
                        'week_id'                    
                    ))->values(array(
                        $one_cron_block['route_name_id'],
                        'day',
                        $one_cron_block['plases'],
                        $only[0],
                        $one_cron_block['ferryman'],
                        $one_cron_block['sesuser'],
                        $one_cron_block['buses'],
                        $one_cron_block['week_id']
                    ))->execute();
                }
            }
        }
        
             /*
                DB::insert('newblocket_plase',array(
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
                */
                
        $this->redirect('/buses/add_blocket_plase');        
        echo '<pre>';
        print_r($chek_block_last_date);
        echo '</pre>';
    }
    
    public function action_test_get_date(){
        $route_name_id = 1611;
        $all_days = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$route_name_id)->order_by('date','DESC')->limit(120)->execute()->as_array();
         echo '<pre>';
        print_r($all_days);
        echo '</pre>';
    }
    
    public function action_test_print(){
        $route_name_id = 1611;
        //$all_days = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$route_name_id)->order_by('date','DESC')->limit(120)->execute()->as_array();
        // echo '<pre>';
        //print_r($all_days);
        $data = array();
        echo View::factory('test/print',$data);
    }
    
    
} // End Page

























