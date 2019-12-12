<?
$lang = 'RU';
?>
<div class="content">    
       <div class="grid simple ">
            <table class="table table-hover table-condensed" id="example">
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
                     foreach($all_auto as $t){
                        $city_from = Model::factory('OstMod')->get_ost($t['city_from'],$lang);
                        $city_to = Model::factory('OstMod')->get_ost($t['city_to'],$lang);
                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$t['ferryman_id'])->execute()->current();
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['user_create'])->execute()->current();
                        if($t['user_create'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['user_create'] == '198'){
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
                                    $chek_open_prev = DB::select()->from('ticketreport')->where('ticket_id','=',$t['tiket_id'])->and_where('status','=',5)->execute()->current();
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
                                $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['tiket_id'])->and_where('status','=',1)->execute()->current();
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
                            <td><?=$t['tiket_id'];?></td>
                            <td><?=$status;?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($t['anule']));?></td>
                            <td><?=$sususer['login'];?></td>
                            <td><span title="<?=$t['route_name_id'];?>"><? $rou_name = Model::factory('RouteMod')->get_route_route_id($t['route_name_id'],$lang,1); if(isset($rou_name[0]['name'])){ echo $rou_name[0]['name'];}?></span></td>
                            <td><?=$fermann_id['name'];?></td>
                            <td><? if(!empty($t['route_date'])){ echo date("d.m.Y",strtotime($t['route_date']));}?></td>
                            <td><?=$city_from['city_i18n']." - ".$city_to['city_i18n'];?></td>
                            <td><?//=$t['name'].' '.$t['soname'];?></td>
                            <td><?=$t['discount'];?></td>
                            <td><?  echo $t['price'];?></td>
                        </tr>
                         <?}?>
                         
                </tbody>
            </table>
           
            <? $order_array = array(); if(!empty($al_val_price)){ $order_array = Model::factory('TiketMod')->order_array($al_val_price,'valute');} $sort_valute = array(); foreach($al_val_price as $vals){ $sort_valute[$vals['valute']][] = $vals; } //echo '<pre>'; print_r($sort_valute); echo '</pre>'; die;?>
            
        
    </div>
    

<? include_once('js/mytables_i18n.php');?>

	
 <div class="clearfix"></div>
  </div>