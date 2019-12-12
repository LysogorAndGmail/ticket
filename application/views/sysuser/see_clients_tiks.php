

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Tickets archive")?> 
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">
            

            
            
            
            
            
            <div class="col-md-12">
            

                    <? $all_count = 0;            
                     $al_val_price = array();
                     foreach($tikets as $t){
                        $city_from = Model::factory('OstMod')->get_ost($t['route_city_from_id'],$lang);
                        $city_to = Model::factory('OstMod')->get_ost($t['route_city_to_id'],$lang);
                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$t['ferryman_id'])->execute()->current();
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['user_id'])->execute()->current();
                        if($t['user_id'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['user_id'] == '198'){
                            $sususer['login'] = 'inet';
                        }
                        switch($t['status']){
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
                            if($t['status'] == 1 || $t['status'] == 5){
                                //$all_count = $t['price'];
                                if($t['status'] == 1){
                                    $chek_open_prev = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',5)->execute()->current();
                                    if(empty($chek_open_prev)){
                                        $al_val_price[] = array('valute'=>$t['valute'],"+",$t['route_price_discount']);
                                    }else{
                                        $t['route_price_discount'] = '';
                                        $t['valute'] = '';
                                    }
                                }else{
                                    $al_val_price[] = array('valute'=>$t['valute'],"+",$t['route_price_discount']);
                                }
                                
                                
                            }
                            if($t['status'] == 3){
                                //echo $cou_val;
                                $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                if(!empty($chek_sell)){
                                    if($t['route_price_discount'] != $t['return_price']){
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['route_price_discount'] - $t['return_price']);
                                    }else{
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['route_price_discount']);
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
                        
                                    <div class="col-md-12 b-b b-grey">
    
 
                        <div class="row m-l-5 m-t-10">
                  <div class="col-md-6">
                          <div class="col-xs-1 no-padding ">
                            <div class="bg-primary p-t-30 p-b-35 color_<?=$t['status'];?> "></div>
                            <div class="bg-primary-light p-t-30 p-b-35"></div>
                            <div class="bg-primary-dark p-t-30 p-b-35"></div>
                          </div>
                          <div class="col-xs-10 bg-white  padding-10">
                            <p class="no-margin text-black bold text-uppercase fs-12"><?=__("Ticket number")?> ,<?=__("Status")?></p>
                            <p class="no-margin fs-12"><?=$t['ticket_id'];?>     <? $orderr = Model::factory('TiketMod')->get_order($t['ticket_id']);?>, <?=$status;?></p>
                            <p class="p-t-0 no-margin text-black bold text-uppercase fs-12"><?=__("Agent")?></p>
                            <p class="no-margin fs-12"><?=$sususer['login'];?></p>
                            <p class="p-t-0 no-margin text-black bold text-uppercase fs-12"><?=__("Date of creating")?></p>
                            <p class="no-margin fs-12"><?=date("d.m.Y H:i:s",strtotime($t['create_report']));?></p>
                          </div>
                        
                        </div>
                        
                        
                        
                        
                                          <div class="col-md-6">
                          <div class="col-xs-1 no-padding ">
                            <div class=" p-t-30 p-b-35 color_<?=$t['status'];?> "></div>
                            <div class="p-t-30 p-b-35"></div>
                            <div class="p-t-30 p-b-35"></div>
                          </div>
                          <div class="col-xs-10 bg-white  padding-10">
                            <p class="no-margin text-black bold text-uppercase fs-12"><?=__("Route")?>, <?=__("Cities")?>, <?=__("Carrier")?></p>
                            <p class="no-margin fs-12"><span title="<?=$t['route_name_id'];?>"><? $rou_name = Model::factory('RouteMod')->get_route_route_id($t['route_name_id'],$lang,1); if(isset($rou_name[0]['name'])){ echo $rou_name[0]['name'];}?></span>, <?=$city_from['city_i18n']." - ".$city_to['city_i18n'];?>, <?=$fermann_id['name'];?></p>
                            <p class="p-t-0 no-margin text-black bold text-uppercase fs-12"><?=__("Route date")?></p>
                            <p class="no-margin fs-12"><? if(!empty($t['route_date'])){ echo date("d.m.Y",strtotime($t['route_date']));}?></p>
                            <p class="p-t-0 no-margin text-black bold text-uppercase fs-12"><?=__("Price")?>, <?=__("Discount")?></p>
                            <p class="no-margin fs-12"><? if($t['status'] == 3){ 
                                //$rou_dat = strtotime($t['route_date'].' '.$t['route_time']);
                                //$sel_dat = strtotime($t['create_report']);
                                //$proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$t['ferryman_id']);
                                //echo $proc;
                                //$pro_price = $t['price']/100 * $proc;
                                    $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                    if(!empty($chek_sell)){
                                        if($t['route_price_discount'] != $t['return_price']){
                                            $t['route_price_discount'] = $t['route_price_discount'] - $t['return_price']; 
                                            echo "-";
                                        }else{
                                            $t['route_price_discount'] = $t['route_price_discount']; 
                                            echo "-";
                                        }
                                        
                                    }else{
                                        $t['price'] = '';
                                        $t['valute'] = '';
                                    }
                                }
                                if($t['status'] == 4 || $t['status'] == 2){
                                    $t['route_price_discount'] = '';
                                    $t['valute'] = '';
                                }
                                 echo $t['route_price_discount'].' '.$t['valute'];?>, <? $discont = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$t['discount_id'])->and_where('culture','=',$lang)->execute()->current(); echo $discont['name_simple_i18n'];?></p>
                          </div>
                        
                        </div>
                        
                        </div>
          
        
          
          
            </div>
                        
                         <?}?>
                         
    
            
            </div>

            
            
            </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>























 
<? include_once('js/mytables_i18n.php');?>