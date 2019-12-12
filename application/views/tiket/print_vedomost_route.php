<style>
.vedomost {
    background-color: gray !important;
}
</style>
<div class="content" style=" width:100%">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="">            
                                <div class="" style="min-height: 850px;">
                                    <div>
                                    <style>
                                    .table td,.table th {
                                        border: 1px solid black !important;
                                        font-size: 10px !important;
                                        padding: 1px !important;
                                        margin: 1px !important;
                                        vertical-align: central !important;
                                        text-align: center !important;
                                    }
                                    
                                    </style>
                                    <? 
                                    $all_cassa = 0;
                                    $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['route_name_id'])->and_where('culture','=',$lang)->execute()->current(); ?>
                                    <h5><?=$route_name['name'];?> <?=$route_name['name_i18n'];?> <?=date('d.m.Y',strtotime($date));?></h5>
                               
                                    <? $buses = DB::select()->from('buses')->where('buses_id','=',$route['buses_id'])->execute()->current();
                                    //die;
                                    $all_plases = DB::select('value')->from('bscheme')->where('schema_name','=',$buses['schema_name'])->order_by('value','DESC')->execute()->as_array();
                                    
                                    if(empty($route['buses_id'])){
                                        echo "Bus no find!";
                                        die;
                                    }
                                    
                                    if(empty($all_plases)){
                                        echo "Bus - ".$route['buses_id']."<br />"." Schema ".$buses['schema_name']." no find!";
                                        die;
                                    }
                                    
                                    //echo '<pre>';
                                    //print_r($all_plases);
                                    //echo '</pre>';
                                    
                                    $al_tik_date_from = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_from_id')
                                                    ->and_where('ticket_type_id','=',1)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();
                                                    
                                                    
                                    $al_tik_date_from_reverse = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_from_id')
                                                    ->and_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();                
                                    
                                    
                                     foreach($al_tik_date_from_reverse as $r){
                                        array_push($al_tik_date_from,$r);
                                     }
                                    
                                    //die;
              
                                    $new_tik_from = array();
                                    foreach($al_tik_date_from as $tik_from){
                                        $new_tik_from[$tik_from['route_city_from_id']][] = $tik_from;
                                    }
                                    $new_from = array();                                    
                                    foreach($new_tik_from as $t=>$cou){
                                        $new_from[$t] = count($cou);
                                    }                
                                    
                                    $al_tik_date_to = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_to_id')
                                                    ->and_where('ticket_type_id','=',1)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();
                                                    
                                    $al_tik_date_to_reserv = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_to_id')
                                                    ->and_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();
                                     
                                     
                                    
                                    //echo '<pre>';
                                    //print_r($al_tik_date_to);
                                    //echo '</pre>';
                                                   
                                    foreach($al_tik_date_to_reserv as $r){
                                        array_push($al_tik_date_to,$r);
                                     }
                                                                                                        
                                    $new_tik_to = array();
                                    foreach($al_tik_date_to as $tik_to){
                                        $new_tik_to[$tik_to['route_city_to_id']][] = $tik_to;
                                    }
                                    $new_to = array();
                                    foreach($new_tik_to as $t=>$cou){
                                        $new_to[$t] = count($cou);
                                    } 
                                    
                                    
                                    $new_plase = array();
                                    foreach($all_plases as $plases){
                                        if(is_numeric($plases['value'])){
                                            $new_plase[] = $plases['value'];
                                        }
                                    }
                                    
                                    
                                    
                                    
                                    asort($new_plase);
                                    
                                    if(count($new_plase) > 35){
                                        $new_plase = array_chunk($new_plase, 35);
                                        ?>
                                        <div class="col-md-12 " style="">
                                            <table class="table " id="example" style=" font-size:10px">
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Route")?></th>
                                                        <th><?=__("Ticket")?></th>
                                                        <th><?=__("Status")?></th>
                                                        <th><?=__("Discounts")?></th>
                                                        <th><?=__("Price")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?    for($i = 0; $i<count($new_plase[0]); $i++){
                                                    $tik = DB::select()->from('ticket')->distinct(true)
                                                    ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                                    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('value','=',$new_plase[0][$i])
                                                    ->and_where('ticket_type_id','=',1)
                                                    ->order_by('ticket.ticket_id')
                                                    ->execute()->as_array();
                                                    
                                                    $tik_reserv = DB::select()->from('ticket')->distinct(true)
                                                    ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                                    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('value','=',$new_plase[0][$i])
                                                    ->and_where('ticket_type_id','=',2)
                                                    ->order_by('ticket.ticket_id')
                                                    ->execute()->as_array();
                                                    
                                                     foreach($tik_reserv as $r){
                                                        array_push($tik,$r);
                                                     }
                                                    
                                                    //echo '<pre>';
                                                    //print_r($tik);
                                                    //echo '</pre>';
                                                    
                                                    
                                                    //echo '<pre>';
                                                    //print_r($tik);
                                                    //echo '</pre>';
                                                    
                                                    // echo '<pre>';
                                                    //print_r($tik_reserv);
                                                    //echo '</pre>';
                                                    //die;
                                                    
                                                    if(!empty($tik)){
                                                        
                                                    
                                                    foreach($tik as $one_t){
                                                        
                                                    $stat = $tik_reserv = DB::select()->from('ticketreport')->distinct(true)->where('ticket_id','=',$one_t['ticket_id'])->order_by('report_id','DESC')
                                                    ->execute()->current(); 
                                                    
                                                    switch($stat['status']){
                                                      case'1':
                            $status = ''.__("Sold");
                            break;
                            case'2':
                            $status = ''.__("Reserved");
                            break;
                            case'3':
                            $status = ''.__("Returned");
                            break;
                            case'4':
                            $status = ''.__("Transfer");
                            break;
                            case'5':
                            $status = ''.__("Open");;
                            break;
                                                    }    
                                                      //  print_r($one_t);
                                                    
                                                ?>
                                                    <tr class="<? if($one_t['vedomost'] == 1){ echo 'vedomost';}?>">
                                                        <td style="width: 30px;"><?=$new_plase[0][$i];?></td>
                                                        <td><?=$one_t['soname'].' '.$one_t['name'];?></td>
                                                        <td><? 
                                                        $city_from = Model::factory('OstMod')->get_ost($one_t['route_city_from_id'],$lang);
                                                        $city_to = Model::factory('OstMod')->get_ost($one_t['route_city_to_id'],$lang);
                                                        $cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        $cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        
                                                        echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        
                                                        ?></td>
                                                        <td><?=$one_t['ticket_id'];?></td>
                                                        <td><?=$status;?></td>
                                                        <td><?$discont = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$one_t['discount_id'])->and_where('culture','=',$lang)->execute()->current(); echo $discont['name_simple_i18n'];?></td>
                                                        <td><? if($stat['status'] != 2){ echo $one_t['route_price_discount'].' '.$one_t['valute'];}?></td>
                                                    </tr>
                                                    
                                                    
                                                    <? if($stat['status'] != 2){
                                                        $all_cassa += $one_t['route_price_discount'];
                                                    }
                                                                } //end foreach
                                                    }else{ ?>
                                                        <tr>
                                                        
                                                        <td style="width: 30px;"><?=$new_plase[0][$i];?></td>
                                                        <td><?//=$tik['soname'].' '.$tik['name'];?></td>
                                                        <td><? 
                                                        //$cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        //$cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        
                                                        //echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        
                                                        ?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['route_price_discount'].' '.$tik['valute'];?></td>
                                                    </tr>
                                                   <? }
                                                    }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        
                                                  <div class="col-md-12 " style="">
                                            <table class="table " id="example" style=" font-size:10px">
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Route")?></th>
                                                        <th><?=__("Ticket")?></th>
                                                        <th><?=__("Status")?></th>
                                                        <th><?=__("Discounts")?></th>
                                                        <th><?=__("Price")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?     for($i = 0; $i<count($new_plase[1]); $i++){
                                                $tik = DB::select()->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                                    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                                    //->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('value','=',$new_plase[1][$i])
                                                    ->and_where('ticket_type_id','=',1)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();
                                                    
                                                    
                                                    $tik_reserv = DB::select()->from('ticket')->distinct(true)
                                                    ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                                    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('value','=',$new_plase[1][$i])
                                                    ->and_where('ticket_type_id','=',2)
                                                    ->order_by('ticket.ticket_id')
                                                    ->execute()->as_array();
                                                    
                                                     foreach($tik_reserv as $r){
                                                        array_push($tik,$r);
                                                     }
                                                    //print_r($tik);
                                                    
                                                    if(!empty($tik)){
                                                        
                                                    
                                                    foreach($tik as $one_t){
                                                        
                                                    $stat = $tik_reserv = DB::select()->from('ticketreport')->distinct(true)->where('ticket_id','=',$one_t['ticket_id'])->order_by('report_id','DESC')
                                                    ->execute()->current(); 
                                                    
                                                     switch($stat['status']){
                                                       case'1':
                            $status = ''.__("Sold");
                            break;
                            case'2':
                            $status = ''.__("Reserved");
                            break;
                            case'3':
                            $status = ''.__("Returned");
                            break;
                            case'4':
                            $status = ''.__("Transfer");
                            break;
                            case'5':
                            $status = ''.__("Open");;
                            break;
                                                    }   
                                                        
                                                ?>
                                                    <tr class="<? if($one_t['vedomost'] == 1){ echo 'vedomost';}?>">
                                                        <td style="width: 30px;"><?=$new_plase[1][$i];?></td>
                                                        <td><?=$one_t['soname'].' '.$one_t['name'];?></td>
                                                        <td><?
                                                        $city_from = Model::factory('OstMod')->get_ost($one_t['route_city_from_id'],$lang);
                                                        $city_to = Model::factory('OstMod')->get_ost($one_t['route_city_to_id'],$lang);
                                                        $cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        $cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        ?></td>
                                                        <td><?=$one_t['ticket_id'];?></td>
                                                        
                                                        <td><?=$status;?></td>
                                                        <td><?$discont = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$one_t['discount_id'])->and_where('culture','=',$lang)->execute()->current(); echo $discont['name_i18n'];?></td>
                                                        <td><? if($stat['status'] != 2){ echo $one_t['route_price_discount'].' '.$one_t['valute'];}?></td>
                                                    </tr>
                                                    <?
                                                        if($stat['status'] != 2){
                                                            $all_cassa += $one_t['route_price_discount'];
                                                        }
                                                    }
                                                    }else{ ?>
                                                        <tr>
                                                        <td style="width: 30px;"><?=$new_plase[1][$i];?></td>
                                                        <td><?//=$tik['soname'].' '.$tik['name'];?></td>
                                                        <td><? 
                                                        //$cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        //$cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        
                                                        //echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        
                                                        ?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['route_price_discount'].' '.$tik['valute'];?></td>
                                                    </tr>
                                                   <? }
                                                    }?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    <?}else{?>
                                        <div class="col-md-12">
                                    <table class="table " id="example">
                                        <thead>
                                            <tr>
                                                <th><?=__("Sel")?></th>
                                                <th><?=__("Pls")?></th>
                                                <th><?=__("Name")?></th>
                                                <th><?=__("Route")?></th>
                                                <th><?=__("Ticket")?></th>
                                                <th><?=__("Status")?></th>
                                                <th><?=__("Discounts")?></th>
                                                <th><?=__("Price")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?    for($i = 0; $i<count($new_plase); $i++){
                                        $tik = DB::select()->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                            ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                            //->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
                                            ->where('route_name_id','=',$route['route_name_id'])
                                            ->and_where('route_date','=',$route['date'])
                                            ->and_where('value','=',$new_plase[$i])
                                            ->and_where('ticket_type_id','=',1)
                                            //->or_where('ticket_type_id','=',2)
                                            //->or_where('ticket_type_id','=',4)
                                            ->execute()->as_array();
                                            
                                        $tik_reserv = DB::select()->from('ticket')->distinct(true)
                                                    ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                                    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('value','=',$new_plase[0][$i])
                                                    ->and_where('ticket_type_id','=',2)
                                                    ->order_by('ticket.ticket_id')
                                                    ->execute()->as_array();
                                                    
                                                     foreach($tik_reserv as $r){
                                                        array_push($tik,$r);
                                                     }
                                            //print_r($city_from); 
                                             if(!empty($tik)){
                                                        
                                                    
                                                    foreach($tik as $one_t){
                                                        
                                                    $stat = $tik_reserv = DB::select()->from('ticketreport')->distinct(true)->where('ticket_id','=',$one_t['ticket_id'])->order_by('report_id','DESC')
                                                    ->execute()->current(); 
                                                    
                                                     switch($stat['status']){
                                                       case'1':
                            $status = ''.__("Sold");
                            break;
                            case'2':
                            $status = ''.__("Reserved");
                            break;
                            case'3':
                            $status = ''.__("Returned");
                            break;
                            case'4':
                            $status = ''.__("Transfer");
                            break;
                            case'5':
                            $status = ''.__("Open");;
                            break;
                                                    }       
                                                        
                                                        
                                                ?>
                                                    <tr class="<? if($one_t['vedomost'] == 1){ echo 'vedomost';}?>">
                                                        <td style="width: 30px;"><input type="checkbox" name="chec" /></td>
                                                        <td style="width: 30px;"><?=$new_plase[$i];?></td>
                                                        <td><?=$one_t['soname'].' '.$one_t['name'];?></td>
                                                        <td><?
                                                        $city_from = Model::factory('OstMod')->get_ost($one_t['route_city_from_id'],$lang);
                                                        $city_to = Model::factory('OstMod')->get_ost($one_t['route_city_to_id'],$lang);
                                                        $cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        $cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        ?></td>
                                                        <td><?=$one_t['ticket_id'];?></td>
                                                        <td><?=$status;?></td>
                                                        <td><?$discont = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$one_t['discount_id'])->and_where('culture','=',$lang)->execute()->current(); echo $discont['name_i18n'];?></td>
                                                        <td><? if($stat['status'] != 2){ echo $one_t['route_price_discount'].' '.$one_t['valute'];}?></td>
                                                    </tr>
                                                    <?
                                                    if($stat['status'] != 2){
                                                            $all_cassa += $one_t['route_price_discount'];
                                                        }
                                                    }
                                                    }else{ ?>
                                                        <tr>
                                                        <td style="width: 30px !important;"><input type="checkbox" name="chec" /></td>
                                                        <td style="width: 30px;"><?=$new_plase[$i];?></td>
                                                        <td><?//=$tik['soname'].' '.$tik['name'];?></td>
                                                        <td><? 
                                                        //$cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                        //$cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                        
                                                        //echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);
                                                        
                                                        ?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['ticket_id'];?></td>
                                                        <td><?//=$tik['route_price_discount'].' '.$tik['valute'];?></td>
                                                    </tr>
                                                   <? }
                                                    }?>
                                        </tbody>
                                    </table>
                                        </div>
                                    <?}?>
                                    <div class="clearfix"></div>
                                    <p>&nbsp;</p>
                                    <hr />
                                  <div class="bottom-panle">
                               
                                  
                                     
    
    <div class="col-md-4" style="font-size:9px; float:left" >
                                        <div class="money-seller-cash"><p><?=__('Departure City');?>:</p></div>
                                        <? foreach($new_from as $fr=>$cou){
                                            $city_from_fr = Model::factory('OstMod')->get_ost($fr,$lang);
                                            ?>
                                            <span><?=$city_from_fr['city_i18n'].' - '.$cou;?></span>,
                                        <?}?>
                                        </div>
                                       
                                       
                                       
                                       
                                       
                                        <div class="col-md-4"  style="font-size:9px;float:left" >
                                        <div class="money-seller-cash"><p><?=__('Arrival City');?>:</p> </div>
                                        <? foreach($new_to as $tt=>$cou){
                                            $city_to_fr = Model::factory('OstMod')->get_ost($tt,$lang);
                                            ?>
                                            <span><?=$city_to_fr['city_i18n'].' - '.$cou;?></span>,
                                        <?}?>
                                        </div>
                                        
                                        
                                        
                                         <div class="col-md-4"  style="font-size:9px; float:left" >
                                         
                                         
                                        <div class="money-seller-cash"><?=__("Total")?>:</div>
                                    
                                   
                                   <p><?=$all_cassa;;?></p>
                                    </div>
                                  
                                  <div class="" style="clear:both"></div>
                     
                                
                                  
                                  </div>
                     
                                
                                
                                
                                
                                
                                
                                    <!--
                                    <div class="col-md-12">
                                    <label><?=__(":");?></label> 
                                        <input type="text" name="number_bus" id="number_bus" value="" class="form text" size="2"><input type="button" value="Р С—Р С•Р С‘РЎРѓР С”" class="search" style="display: none;"/>
                                    </div>
                                    -->
                                   
                                    
                                    
                                    
                                <hr />
                                
                                </div>
                        </div>	
                    </div>
                </div>
            </div>	
        </div>
<div class="clearfix"></div>
</div>