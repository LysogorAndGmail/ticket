<? $sesuser = Session::instance()->get('ses_user'); //print_r($sesuser); ?>

<style>
.grid.simple .grid-body tbody > tr:hover > td {
    background: none !important;
}

.grid.simple .grid-body tbody > tr.sell > td {
    background-color: yellowgreen;
}
.grid.simple .grid-body tbody > tr.return  > td {
    background-color: pink;
}
#ui-datepicker-div {
    width: 280px !important;
}
</style>
<script type="text/javascript" src="<?=Kohana::$base_url?>js/shortcut.js"></script>
<script type="text/javascript">
shortcut.add("alt+s", function() {
        alert("alt+s");
    });
</script>
<div class="content">  
	<div class="row" id="inbox-wrapper">
    
    <div class="col-md-12">
    
         <div class=""><h2 class=" inline"><?=__("Cash")?></h2></div>
            
            
            <div class=""><h4 class="inline"><?=__("You can check your daily payments and all history payments")?></h4></div>
    
    </div>
    
    </div>

</div>
<div class="content">    
       <div class="grid simple">
            <table class="table table-hover table-condensed" border="1">
                <thead>
                    <tr>
                        <th><?=__("№")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Create")?></th>
                        <th><?=__("Users")?></th>
                        <th><?=__("Route")?></th>
                        <th><?=__("Ferryman")?></th>
                        <th><?=__("Route date")?></th>
                        <th><?=__("Cities")?></th>
                        <th><?=__("Client")?></th>
                        <th><?=__("Discount")?></th>
                        <th><?=__("Price")?></th>
                    </tr>
                </thead>
                <tbody>
                    <? $all_count = 0;            
                     $al_val_price = array();
                     foreach($tikets as $t){
                        $city_from = Model::factory('OstMod')->get_ost($t['route_city_from_id'],$lang);
                        $city_to = Model::factory('OstMod')->get_ost($t['route_city_to_id'],$lang);
                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$t['ferryman_id'])->execute()->current();
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['sys_user'])->execute()->current();
                        if($t['user_id'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['user_id'] == '198'){
                            $sususer['login'] = 'inet';
                        }
                        switch($t['status']){
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
                        
                        //if (array_key_exists($t['valute'], $al_val_price)) {
                            /*
                            if($status == 'sell' || $status == 'reserv' || $status == 'open'){
                                $all_count = $al_val_price[$t['valute']];
                                //echo $cou_val;
                                $al_val_price[$t['valute']] = $all_count+$t['price'];
                            }
                            if($status == 'return'){
                                $all_count = $al_val_price[$t['valute']];
                                //echo $cou_val;
                                $al_val_price[$t['valute']] = $all_count-$t['price'];
                            }
                            */
                        //}
                        ///*
                        //else{
                            if($status == 'sell' || $status == 'open'){
                                //$all_count = $t['price'];
                                if($status == 'sell'){
                                    $chek_open_prev = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',5)->execute()->current();
                                    if(empty($chek_open_prev)){
                                        $al_val_price[] = array('valute'=>$t['valute'],"+",$t['price']);
                                    }else{
                                        $t['price'] = '';
                                        $t['valute'] = '';
                                    }
                                }else{
                                    $al_val_price[] = array('valute'=>$t['valute'],"+",$t['price']);
                                }
                                
                                
                            }
                            if($status == 'return'){
                                //echo $cou_val;
                                $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                if(!empty($chek_sell)){
                                    if($t['price'] != $t['return_price']){
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['price'] - $t['return_price']);
                                    }else{
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['price']);
                                    }
                                    
                                }    
                            }
                        
                        //}
                        //*/
                        //echo '<pre>';
                        //print_r($all_count);
                        //echo '</pre>';
                        //die;
                         
                        ?>
                        <tr class="<?=$status;?>">
                            <td class="id"><?=$t['ticket_id'];?></td>
                            <td><?=$status;?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($t['create_report']));?></td>
                            <td><?=$sususer['login'];?></td>
                            <td><span title="<?=$t['route_name_id'];?>"><? $rou_name = Model::factory('RouteMod')->get_route_route_id($t['route_name_id'],$lang,1); if(isset($rou_name[0]['name'])){ echo $rou_name[0]['name'];}?></span></td>
                            <td><?=$fermann_id['name'];?></td>
                            <td><? if(!empty($t['route_date'])){ echo date("d.m.Y",strtotime($t['route_date']));}?></td>
                            <td><?=$city_from['city_i18n']." - ".$city_to['city_i18n'];?></td>
                            <td><?=$t['name'].' '.$t['soname'];?></td>
                            <td><?=$t['discount_id'];?></td>
                            <td><? if($t['status'] == 3){ 
                                //$rou_dat = strtotime($t['route_date'].' '.$t['route_time']);
                                //$sel_dat = strtotime($t['create_report']);
                                //$proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$t['ferryman_id']);
                                //echo $proc;
                                //$pro_price = $t['price']/100 * $proc;
                                    $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                    if(!empty($chek_sell)){
                                        if($t['price'] != $t['return_price']){
                                            $t['price'] = $t['price'] - $t['return_price']; 
                                            echo "-";
                                        }else{
                                            $t['price'] = $t['price']; 
                                            echo "-";
                                        }
                                        
                                    }else{
                                        $t['price'] = '';
                                        $t['valute'] = '';
                                    }
                                }
                                if($t['status'] == 4 || $t['status'] == 2){
                                    $t['price'] = '';
                                    $t['valute'] = '';
                                }
                                 echo $t['price'].' '.$t['valute'];?></td>
                        </tr>
                         <?}?>
                         
                </tbody>
            </table>
           
            <? $order_array = array(); if(!empty($al_val_price)){ $order_array = Model::factory('TiketMod')->order_array($al_val_price,'valute');} $sort_valute = array(); foreach($al_val_price as $vals){ $sort_valute[$vals['valute']][] = $vals; } //echo '<pre>'; print_r($sort_valute); echo '</pre>'; die;?>
            
        
    </div>
    
    
    <div class="content">
    
    
    <div id="inbox-wrapper_" class="row user-cash-block">
       <div class="col-md-6">
       
       
       <div class="name-seller-cash"><?=$sesuser[0]['login'];?>&nbsp;&nbsp;<font color="#000000"><?=$sesuser[0]['procent'];?> %:</font></div>
      
       <div class="all_cou"><?  $i=1; foreach($sort_valute as $valll=>$prii){ 
                        $new_price = 0;
                        foreach($prii as $p){
                            $pos = strripos($p[0], "-");
                             if ($pos === false) {
                                $new_price += $p[1]; 
                             }else {
                              $new_price -= $p[1]; 
                              }
                        }
                        $proc_price = $new_price/100 * $sesuser[0]['procent'];
                        //$al_pri_sum = $new_price - $proc_price;
                        echo $proc_price ." ". $valll."<br />";
                    }  ?></span></div>
       
       
       </div>
       
       <div class="col-md-6" style=" text-align:right">
        <div class="money-seller-cash"><?=__('Full amount');?>: </div>
         <div class="all_cou"><?  $i=1; foreach($sort_valute as $valll=>$prii){ 
                        $new_price = 0;
                        foreach($prii as $p){
                            $pos = strripos($p[0], "-");
                             if ($pos === false) {
                                $new_price += $p[1]; 
                             }else {
                              $new_price -= $p[1]; 
                              }
                        }
                        echo $new_price ." ". $valll."<br />";
                    }  ?></span></div>
          
       
       </div>
       
 </div>
    
    
    </div>
    

	
 <div class="clearfix"></div>
 
  </div>
