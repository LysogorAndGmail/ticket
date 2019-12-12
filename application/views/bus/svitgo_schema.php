<style>
.newtip {
    position: absolute;
    display: block;
    left: 30px;
    width: 300px;
    z-index:9999999;
    font-size: 11px !important;
    text-align: left !important;
    top:-77px;
}
.newtip .tooltip-arrow {
    top:91px;
    left: -5px;
    margin-top: -5px;
    border-width: 5px 5px 5px 0px;
    border-right-color: #000;
}
.bus_cres {
    position: relative;
}
</style>
<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang);

                
$sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
    $ses_valute = $sesuser[0]['default_valute'];
}else{
    $user_id = 0;
    $ses_valute = 'EUR';
}
        
    
    $id = $info['buses_id'];
    
    //$price = 50;
    
    
    $ferryman_id = $info['ferryman_id'];
    $route_id = $info['route_name_id'];
    $fro = $from;
    $to = $to;
    
    $route_date = $info['date'];
    
    $chek_date_model = Model::factory('TiketMod')->find_routes_minus_date_model($route_id,$from,$to,$route_date);
    
    if(isset($chek_date_model[0][1]) && !empty($chek_date_model[0][1])){
        $route_date = $chek_date_model[0][1];
    }
    
    
    //print_r($info);
    //die;
    //echo $route_date;
    
    
    
    $all_discount = Model::factory('DiscountMod')->get_all_discount($lang);
    
    $price_array = Model::factory('TiketMod')->chek_price_model($route_id,$from,$to,$ses_valute,$ferryman_id);
    
    //print_r($price_array);
    //die;
    
    
    $price = $price_array[0];
    $valute = $price_array[1];
    //print_r($all_discount);
    //die;
    
    //$countrys = DB::select()->from('country')->where('valute','=',$ses_valute)->execute()->current();
    
    
    
 
    
            $bus_name = DB::select()->from('buses_i18n')->where('buses_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
            $bus = DB::select()->from('buses')->where('buses_id','=',$id)->execute()->current();
            $all_schema = DB::select()->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
            //
            
            $all_schema_plases = array();
            foreach($all_schema as $al_sh){
                if(is_numeric($al_sh['value'])){
                    $all_schema_plases[] = $al_sh['value'];
                }
                
            }
            
            
            if(empty($all_schema)){
                echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2054")."!<h4>";
            }
            
            $schema_arr = array();
            foreach($all_schema as $all){
                $schema_arr[$all['schema_name']][$all['dx']][$all['dy']] = $all;
            }
            
            
            
            //$block_plase_array = Model::factory('TiketMod')->block_all($id,$ferryman_id); 
            
            //sell
            $sell_array = Model::factory('TiketMod')->sell_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            
            
            // end sell
            //reserv
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            
            //echo '<pre>';
            //print_r($reserv_array);
            //echo '</pre>';
            //die;
            
            
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            } 
           
            $new_block_plase = Model::factory('TiketMod')->block_plase($route_id,$id,$ferryman_id,$fro,$to,$route_date);
            
            
            
            $sysuser_block_plase = Model::factory('TiketMod')->sysuser_block_plase($user_id,$route_id,$id);
            
            
            foreach($sysuser_block_plase as $sys_biz){
                
                array_push($new_block_plase,array('value'=>$sys_biz));
            }
            
            
            
            $old_disp_bizi = Model::factory('TiketMod')->old_disp($route_id,$fro,$to,$route_date); 
            
            foreach($old_disp_bizi as $old_biz){
                
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            //if($ferryman_id != 68){
                $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($route_id,$fro,$to,$route_date);
            //}else{
            //    $all_blocked_plase = array();
            //}
            //print_r($all_blocked_plase);
            $all_newblocked_plase = Model::factory('BusesMod')->chek_newblocket_plase($route_id,$route_date,$id,$ferryman_id);
            foreach($all_newblocked_plase as $old_biz){
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            //if(!empty($all_blocked_plase)){
                
               
                if($ferryman_id != 68){ // если не чеп 
                    $all_bizi_nikolo = array_diff($all_schema_plases,$all_blocked_plase);
                }else{
                    $all_bizi_nikolo = array();
                    //$all_newblocked_plase = Model::factory('BusesMod')->chek_newblocket_plase($route_id,$route_date,$id,$ferryman_id);
                    //foreach($all_newblocked_plase as $old_biz){
                    //    array_push($new_block_plase,array('value'=>$old_biz));
                    //}
                    //$all_bizi_nikolo = array_diff($all_schema_plases,$all_blocked_plase);
                }
                $all_bizi_nikolo = array_diff($all_bizi_nikolo,$sell);
                $all_bizi_nikolo = array_diff($all_bizi_nikolo,$reserv);
            //}else{
           //     
           // }
            
            
            if(empty($price)){
                echo __("Contact your administrator.").__("No price.");
                die;
            }

 ?> 

<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="ferryman" value="<?=$ferryman_id;?>" />
<input type="hidden" class="buses" value="<?=$id;?>" />
<input type="hidden" class="date_from_schema" value="<?=$route_date;?>" />
<input type="hidden" class="date_from_schema_end" value="" />
<div class="border-bus left ner_1 bus">
    <button class="btn btn-default back_salon" style="display: none;"  onclick="$(this).next('div').show(),$(this).hide(),$('.main_parr').remove(),$('.people_info_title').show()"><?=__("Back")?></button> 
    <div class="but_bizi_hide">
        <? $group_see_tik = DB::select()->from('groups')->where('id','=',$sesuser['group_id'])->execute()->current(); //print_r($group_see_tik);?>
        <? foreach($schema_arr as $name=>$aa){ ?>
        <div class="one_scem fir_schema">
            <!--<h4>&nbsp;<?//=$bus_name['name_i18n'];?></h4>-->
            <? foreach($aa as $x=>$ax){?>
            <div class="one_row row">
                <? foreach($ax as $y=>$ay){ ?>
                    <div class="bus_cres new_cre_1 place occ" style="">
                    <?php if($ay['value']=='WC' || $ay['value']=='st' || $ay['value']=='pr' || $ay['value'] == ''){?>
                        <div  class="bscheme-none place empty "><?php echo $ay['value'];?></div>
                        <?php } else {?>
                        <div <? foreach($sell as $bil){ if($ay['value']  == $bil){ ?> data-toggle="modal" data-target="#myModal<?=$ay['value'];?>" <?}} ?> 
                             <? foreach($reserv as $res){ if($ay['value']  == $res){ ?> data-toggle="modal" data-target="#myModal<?=$ay['value'];?>" <?}} ?>
                            
                            data-placement="right"
                            
                           <? foreach($sell as $bil){ if($ay['value']  == $bil){ 
                            
                             $tiks = DB::select()->from('ticket')
                                        ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                        ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                        ->where('route_name_id','=',$route_id)
                                        ->and_where('route_date','=',$route_date)
                                        ->and_where('ferryman_id','=',$ferryman_id)
                                        //->and_where('route_city_from_id','=',$fro)
                                        //->and_where('route_city_to_id','=',$to)
                                        ->and_where('ticket_type_id','=',1)
                                        ->and_where('buses_id','=',$id)
                                        ->and_where('value','=',$ay['value'])
                                        ->execute()->as_array();
                                        
                                        //if($tik['user_id'] == 0){
                                        //    $sususer['login'] = 'SuperAdmin';
                                        // }
                                        
                              // print_r($tiks);         
                                        
                             ?> data-title=" <?
                                        foreach($tiks as $tik){
                                        
                                        $sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
                            ?>          
                            <p><?=__('Status');?>: - <?=__('Sold')?></p>  
                            <? if($group_see_tik['tik_see_id'] == 1){?><p><?=__('Ticket');?>: - <?=$tik['maska']; }?></p>
                            <p><? $ost_from = Model::factory('OstMod')->get_ost($tik['route_city_from_id'],$lang); $ost_to = Model::factory('OstMod')->get_ost($tik['route_city_to_id'],$lang);  echo __('From');?> &#10 <? echo $ost_from['city_i18n'].' '.$ost_from['name_i18n']; ?> </p> <p> <? echo __('To');?> &#10 <? echo $ost_to['city_i18n'].' '.$ost_to['name_i18n'];?> </p>
                            <? if($group_see_tik['tik_see_sysuser'] == 1){?> <p><?=__('Agent');?>: - <?=$sususer['login']; }?> </p> <? if($group_see_tik['tik_see_client'] == 1){?> 
                            <p><?=__('Passenger');?>: - <?=$tik['name'].' '.$tik['soname']; } ?> </p>
                            <p><?=__('Phone');?>: - <?=$tik['tel']; ?> </p>
                             <? if($group_see_tik['tik_see_date'] == 1){?>
                            <p><?=__('Date of departure');?>:  <?=date('d/m/Y',strtotime($tik['route_date'])); }?> </p> <? if($group_see_tik['tik_see_price'] == 1){?> 
                            <p> <?=__('Price');?>: <?
                                          if(!empty($tik['route_price_discount'])){
                                            echo $tik['route_price_discount'].' '.$tik['valute'];
                                          } }
                                          ?> </p>
                                         
                             " data-tikID="<?=$tik['ticket_id'];?>" <? }                        
                              } } ?>
                             
                             <? foreach($reserv as $bil){ if($ay['value']  == $bil){ 
                            
                             $tiks = DB::select()->from('ticket')
                                        ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                                        ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                        ->where('route_name_id','=',$route_id)
                                        ->and_where('route_date','=',$route_date)
                                        ->and_where('ferryman_id','=',$ferryman_id)
                                        //->and_where('route_city_from_id','=',$fro)
                                        //->and_where('route_city_to_id','=',$to)
                                        ->and_where('ticket_type_id','=',2)
                                        ->and_where('buses_id','=',$id)
                                        ->and_where('value','=',$ay['value'])
                                        ->execute()->as_array();
                                        
                                        //if($tik['user_id'] == 0){
                                        //    $sususer['login'] = 'SuperAdmin';
                                        // }
                             ?> data-title=" <?
                                        foreach($tiks as $tik){
                                        //echo '<pre>';
                                        //print_r($tiks);
                                        //echo '</pre>';
                                        $sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
                            ?>
                            <p><?=__('Status');?>: - <?=__('Reserved')?></p>            
                            <? if($group_see_tik['tik_see_id'] == 1){?><p><?=__('Ticket');?>: - <?=$tik['maska']; }?></p>
                            <p><? $ost_from = Model::factory('OstMod')->get_ost($tik['route_city_from_id'],$lang); $ost_to = Model::factory('OstMod')->get_ost($tik['route_city_to_id'],$lang);  echo __('From');?>: &#10 <? echo $ost_from['city_i18n'].' '.$ost_from['name_i18n']; ?> </p> <p> <? echo __('To');?>: &#10 <? echo $ost_to['city_i18n'].' '.$ost_to['name_i18n'];?> </p>
                            <? if($group_see_tik['tik_see_sysuser'] == 1){?> <p><?=__('Seller');?>: - <?=$sususer['login']; }?> </p>
                            <? if($group_see_tik['tik_see_client'] == 1){?> <p><?=__('Client');?>: - <?=$tik['name'].' '.$tik['soname']; } ?> </p>
                            <p><?=__('Tel');?>: - <?=$tik['tel']; ?> </p>
                            <? if($group_see_tik['tik_see_date'] == 1){?><p><?=__('Route Date');?>: <?=date('d/m/Y',strtotime($tik['route_date'])); }?> </p>
                             <? if($group_see_tik['tik_see_price'] == 1){?> 
                            <p> <?=__('Price');?>: <?
                                          if(!empty($tik['route_price_discount'])){
                                            echo $tik['route_price_discount'].' '.$tik['valute'];
                                          } }
                                          ?> </p>
                            <? }                        
                             ?>" data-tikID="<?=$tik['ticket_id'];?>" <? } } ?>
                             
                             <? foreach($new_block_plase as $blo){ if($ay['value']  == $blo['value']){
                                $new_block_plase_name = Model::factory('TiketMod')->block_plase_one($ay['value'],$route_id,$id,$ferryman_id,$fro,$to);
                                ?> title="<? echo $new_block_plase_name['name'];?>" <?}} ?>
    
                            class="bscheme choise mytip 
                                <? if(!empty($bloc_reg)){foreach($bloc_reg as $re_se){ if($ay['value']  == $re_se){ echo " bizi ";}} }?> 
                                <? foreach($sell as $bil){ if($ay['value']  == $bil){ echo " bizi sell ";}} ?>
                                <? foreach($new_block_plase as $blo){ if($ay['value']  == $blo['value']){ echo " blocket bizi ";}} ?>
                                <?// foreach($null as $nul){ if($ay['value']  == $nul){ echo "null";}} ?>  
                                <? foreach($all_bizi_nikolo as $biz_nik){ if($ay['value'] == $biz_nik){ echo " blocket ";}} ?>
                                <?// foreach($block_plase_array as $all=>$all_vall){ if($ay['value']  == $all_vall['value']){ echo "bizi";}} ?> 
                                <? foreach($reserv as $res){ if($ay['value']  == $res){ echo " bizi reserv";}} ?>
                                " ><?php echo $ay['value']?></div> 

                        <?php } ?>
                    </div>
                <?}?>
            </div>
            <div class="clearfix"></div>
            <?}?>
            <div class="clearfix"></div>
            <br />
            <button onclick="$(this).next().toggle()" class="btn btn-default"><?=__('Show information')?></button>
            <div class="sell_info_bus_new col-md-12 no-padding bus-show-info" style=" display:none">  
                <?  $all_tikk = DB::select()
                                    ->from('ticket')
                                    ->join('ticket_people')
                                    ->on('ticket.client_id','=','ticket_people.id')
                                    ->join('ticket_valute')
                                    ->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                                    ->where('route_name_id','=',$route_id)
                                    ->and_where('route_date','=',$route_date)
                                    ->and_where('ferryman_id','=',$ferryman_id)
                                    ->execute()->as_array();
                                    
                                    //echo '<pre>';
                                    //print_r($all_tikk);
                                    //echo '</pre>';
                                    
                                    ?>
                <table class="table table-hover table-condensed" id="example">
                    <tr>
                        <th>№</th>
                        <th>ID</th>
                        <th><?=__('Seats')?></th>
                        <th><?=__('Status')?></th>
                        <th><?=__('Seller')?></th>
                        <th><?=__('Client')?></th>
                        <th><?=__('Phone')?></th>
                        <th><?=__('Price')?></th>
                        <th><?=__('From')?></th>
                        <th><?=__('To')?></th>
                    </tr>
                    <? $iii = 1; foreach($all_tikk as $at){
                     $status = '';
                     
                            switch($at['ticket_type_id']){
                                case'1':
                                $status = 'Sold';
                                break;
                                case'2':
                                $status = 'Reserved';
                                break;
                                case'3':
                                $status = 'Returned';
                                break;
                                case'4':
                                $status = 'Transfer';
                                break;
                                case'5':
                                $status = 'Open';
                                break;
                            }
                        ?>
                    <tr>
                        <td><?=$iii;?></td>
                        <td><?=$at['maska'];?></td>
                        <td><?=$at['value'];?></td>
                        <td><?=__(''.$status.'');?></td>
                        <td><? $sysuser = DB::select()->from('system_users')->where('id','=',$at['user_id'])->execute()->current(); echo $sysuser['login'];?></td>
                        <td><?=$at['name'].' '.$at['soname'];?></td>
                        <td><?=$at['tel'];?></td>
                        <td><?=$at['route_price_discount'].' '.$at['valute'];?></td>
                        <td><? $ost_from = Model::factory('OstMod')->get_ost($at['route_city_from_id'],$lang); echo $ost_from['city_i18n'].' '.$ost_from['name_i18n'];?></td>
                        <td><? $ost_to = Model::factory('OstMod')->get_ost($at['route_city_to_id'],$lang); echo $ost_to['city_i18n'].' '.$ost_to['name_i18n'];?></td>
                    </tr>
                    <? $iii++;}?>
                </table>
            </div>
            <br />
        </div>
        <? } ?>
    </div>
    <div class="bus-info-right left" style="display: none;">  
        <span class="choise-bus-tittle"><h6><? echo __('Your Seat');?></h6></span>
        <div class="dis_all">
            <div class="admin_plases"></div>
            <span class="cur_pri r-bus-price" style="display:none;"><?=$price;?></span><span class="Ch_cr" style="display:none;"><?=$price;?></span><span class="DiID" style="display:none;"></span> 
            <div class="clearfix"></div>
        </div>
        <div class="r-bus-cart-btm"></div>
    </div>
    <div class="row" style="display: none;">
        <div class="pay-bus-s">
            <div class="medium-6 columns">
                <div class="medium-6 columns">
                    <div class="cart b-cart-design">
                        <? echo __('Total');?>: <span class="al">0</span> <span class="al_val"><? echo $valute;?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>               
<script type="text/javascript">


$('.reserv').click(function(){
    
    var cou_people_select = 0;
    $('.people .one_people').each(function(){
        cou_people_select++;
    })
    
    //alert('y');
    //exit;
    if(cou_people_select == 0){
        
    //alert(cou_people_select);
    //exit;
    
    $(this).parents('.but_bizi_hide').hide();
    
    $('.back_salon').show();
    
    //$('#ui-datepicker-div').remove();
    
    $('.people_info_title').hide();
    
    var ID = $(this).data('tikid');
    var HTmm = '';
 //alert(ID);
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_svitgo_schema_click_bizi",
        data: {id:ID},
        //async: true,
        success: function(data) {
           
            HTmm = data;
            $(HTmm).insertBefore('.peo_after');
        },
        error:function(code, opt, err){
            alert("Состояние ajax_svitgo_schema_click_bizi");
        }
    }); 
    
    }else{
        modal_info_open('<h1><?=__("Removing select seats")?></h1>');
    }
      
    
   
})

$('.bizi_').click(function(){
    
    var cou_people_select = 0;
    $('.people .one_people').each(function(){
        cou_people_select++;
    })
    
    //alert('y');
    //exit;
    if(cou_people_select == 0){
        
    //alert(cou_people_select);
    //exit;
    
    $(this).parents('.but_bizi_hide').hide();
    
    $('.back_salon').show();
    
    //$('#ui-datepicker-div').remove();
    
    $('.people_info_title').hide();
    
    var ID = $(this).data('tikid');
    var HTmm = '';

    $.ajax({
        type: "POST",
        url: "/tiket/ajax_svitgo_schema_click_bizi",
        data: {id:ID},
        //async: true,
        success: function(data) {
            //HTmm = data;
            $(HTmm).insertBefore('.peo_after');
        },
        error:function(code, opt, err){
            alert("Состояние ajax_svitgo_schema_click_bizi");
        }
    }); 
    
    }else{
        modal_info_open('<h1><?=__("Removing select seats")?></h1>');
    }
      
    
   
})

$('.sell').click(function(){
    
    var cou_people_select = 0;
    $('.people .one_people').each(function(){
        cou_people_select++;
    })
    
    //alert('y');
    //exit;
    if(cou_people_select == 0){
        
    //alert(cou_people_select);
    //exit;
    
    $(this).parents('.but_bizi_hide').hide();
    
    $('.back_salon').show();
    
    //$('#ui-datepicker-div').remove();
    
    $('.people_info_title').hide();
    
    var ID = $(this).data('tikid');
    var HTmm = '';
    //alert(ID);
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_svitgo_schema_click_bizi",
        data: {id:ID},
        //async: true,
        success: function(data) {
            
            //alert(data);
            HTmm = data;
            $(HTmm).insertBefore('.peo_after');
        },
        error:function(code, opt, err){
            alert("Состояние ajax_svitgo_schema_click_bizi");
        }
    }); 
    
    }else{
        modal_info_open('<h1><?=__("Removing select seats")?></h1>');
    }
      
    
   
})








$('.new_cre_1').click(function(){
    $('.newtip').each(function(){
        $(this).remove();
    })
    //$('.new_cre_1').click();
    //$('.people').click();
    $('.modal-body .col-md-12').focus();
    //alert('ok');
})


$('.new_cre_1').hover(function(){
    var Title = $(this).find('.mytip').data('title');
    if(Title !== undefined){
        var NewTip = $('<div class="tip newtip tooltip-inner"><div class="tooltip-arrow"></div>'+Title+'</div>');
        NewTip.insertBefore($(this).find('.mytip'));
    }
},function(){
    $('.newtip').each(function(){
        $(this).remove();
    })
})
//*/

$('.sel_res_button').click(function(){ // покупка после резервации
    //alert();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_reserv",
        data: {id:$(this).prev('input').val(),sesuser:$('.sesuser').val()},
        async: false,
        success: function(data) {
            //alert(data);
            //Block_name = data;
            //location="/tiket/sell";
        },
        error:function(code, opt, err){
            alert("sel_res_button");
        }
    });
    
    var Print = '';
    
    var tik_arrays = [];
    
    tik_arrays.push($(this).prev('input').val());
    
    var tik_arrays_open = [];
     
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_new_print_reserv",
        async: false,
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val()},
        success: function(data) {
            //Print.push(data);
            //alert(data);
            //exit;
            Print += data;
            //$('.print_ticket_block').html(Print);
            //alert('ok');
            //location="/errors/test";
            //setTimeout(Mywin_print(),1000);
            //printDiv('print_ticket_block');
            //;
        },
        error:function(){
            alert('ошибка #sell_tik прямой');
        }
    });
    
    $('.print_ticket_block').html(Print);
    printDiv();
    location="/tiket/sell";
    //alert(return_inputs);
    //exit;
    
    
})

$('.blocket_').click(function(){
    //var MaxSel =  1;
    //alert('hello');
    //exit;
    if($(this).parent().find('.selected_plase').html() == null){
        $(this).parent().find('.bscheme').addClass('selected_plase'); 
        
        var Par = $(this).parent();
        //var NewPrice = Prise + parseFloat($('.al').text());
        //$('.al').text(NewPrice.toFixed(2));
        var PlaseVal = $(this).text();
        var Block_name = '';
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_blocket_get_name",
                data: {plase:PlaseVal,route_name_id:$('.route_name_main').val(),from:$('.from_sel').val(),to:$('.to_sel').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    Block_name = data;
                },
                error:function(code, opt, err){
                    alert("Состояние blocket");
                }
            });
        $('<div class="one_people col-md-12"><div class="form-group col-md-1"><label><?=__("№")?></label><span class="plase">'+PlaseVal+'</span></div><div class="form-group col-md-2"><label><?=__("Name")?></label><span>'+Block_name+'</span></div></div>').insertAfter('.peo_after');
        var plase_sel = Par.html();
        $('<div class="admin_choise">'+plase_sel+'</div>').insertAfter('.admin_plases');
        $('.tik_pri_modal').show();
        
        CURPRICEDISC();
        
    }else { 
        
        $(this).parent().find('.bscheme').removeClass('selected_plase');
        $('.tik_pri_modal').hide();
        var Curr = parseFloat($(this).text());
        $(this).parents('.border-bus').next('.bus-info-right').find('.bscheme').each(function(){
            if(parseFloat($(this).text()) == Curr){
                $(this).parents('.one_ch').remove();
                  $(this).remove();
                
            }
        });
        
        //var allPri = parseFloat($('.al').text());
        //var Prise = parseFloat('<?=$price?>');
        //var NewPri = allPri - Prise;
        //$('.al').text(NewPri.toFixed(2));
        var Tex = $(this).text();
        
        //alert(Tex);
         $('.admin_choise div').each(function(){
         if($(this).text() == Tex){
                $(this).parent().remove();
          } 
        });
        
        $('.one_people span').each(function(){
           if($(this).text() == Tex){
                $(this).parents('.one_people').remove();
           } 
        });
        CURPRICEDISC();
    }
    
})


$('.radioo').change(function(){
    $(this).parents('.form-row').find('.transfer_block').toggle();
    $(this).parents('.form-row').find('.returnet_block').toggle();
})





/*
function blocketAnul(ID){
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_blocket_null",
        data: {id:ID},
        success: function(data) {
            //alert(data);
            location="/tiket/sell";
        },
        error:function(){
            alert('ошибка записи step_3');
        }
    });
}
*/

$('.tran_tik').click(function(){
    var Par = $(this).parents('.transfer_block');
    var Tik = Par.find('.tik_sel_mod').val();
    var Date = Par.find('.datepicker_sell').val();
    var NewPri = $(this).prev('.tik_pri_modal').val();
    var Plase = Par.find(".salon_modal").find('.selected_plase').html();
    //alert(Plase);
    //exit;
    if(Par.find('.datepicker_sell').val().length == 0){
        Par.find(".salon_modal").html('<h3><?=__("Choose date!")?></h3>');
        exit;
    }
    if(Par.find(".salon_modal").find('.selected_plase').html().length == 0){
        Par.find(".salon_modal").html('<h3><?=__("Choose seat!")?></h3>');
        exit;
    }
    
    
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_transfer",
        data: {tik_id:Tik,date:Date,price:NewPri,plase:Plase,sesuser:$('.sesuser').val()},
        async: false,
        success: function(data) {
            //alert(data);
            location="/tiket/sell";
            //if(data == Full){
            
             //   HTMLL.addClass('ui-state-active');
            //}
        },
        error:function(){
            //modal_info_open('<h1><?=__("Choose date and seat!")?></h1>');
            Par.find(".salon_modal").html('<h1><?=__("Choose date and seat!")?></h1>');
        }
    });  
})
    //var FG = 0;
    //$('.cur_pri').each(function(){
    //    FG += parseFloat($(this).text());
    //})
    //var NNN = parseFloat($('.al').text());
    //$('.al').text(FG.toFixed(2));
    
    function DellTable(ht,par,pri){
        par.each(function(){
            if($(this).html() == ht){
                $(this).removeClass('selected_plase');
            }
        })
    }
    
$('.choise').click(function(){
    //var MaxSel =  1;
   
    $('.ajax_load').show();
    
   
    if($(this).parent().find('.bizi').html() == null && $(this).parent().find('.blocket').html() == null) {
    if($(this).parent().find('.selected_plase').html() == null){
        
        var chek_no_valid = [];
       $('.noValid').each(function(){
            chek_no_valid.push(1);
       })
       if(chek_no_valid.length != 0){
            setTimeout(HideAnimm,100);
            modal_info_open("<h3><?=__('Attention')?>!</h3><h5><?=__('Before selecting the next passenger, you must complete the previous passenger data.')?></h5>");
            return false;
       }
        
        $(this).parent().find('.bscheme').addClass('selected_plase'); 
        
        var Par = $(this).parent();
        var Prise = parseFloat('<?=$price?>');
        Prise = Math.round(Prise);
        
        //var NewPrice = Prise + parseFloat($('.al').text());
        //$('.al').text(NewPrice.toFixed(2));
        var DayPeop = $('.day_peop').html();
        var MonPeop = $('.mon_peop').html();
        var YerPeop = $('.yer_peop').html();
        
        var PlaseVal = $(this).text();
        var DiscountBlock = $('.dis_block').html();
        
        //alert('<? echo $valute;?>');
        //exit;
        ///////////////////////////
        //$('<div class="one_people col-md-12 no-padding"><div class="form-group col-md-1 no-padding"><label><?=__("№")?></label><span class="plase">'+PlaseVal+'</span><span class="dis_price" style="display:none;">'+Prise+'</span></div><div class="form-group col-md-2 no-padding"><label><?=__("Phone")?></label><input type="text" class="tel form-control ajax_tel" /><span class="ajax_people_block"></span></div><div class="form-group col-md-2 no-padding"><label><?=__("First Name")?></label><input type="text" class="name form-control" /></div><div class="form-group col-md-2 no-padding"><label><?=__("Last Name")?></label><input type="text" class="soname form-control" /></div><div class="col-md-2 no-padding"><label><?=__("Date")?></label><div class="col-md-my">'+DayPeop+'</div><div class="col-md-my">'+MonPeop+'</div><div class="col-md-my_big">'+YerPeop+'</div></div><div class="form-group col-md-2 no-padding"><label><?=__("Phone 2")?></label><input type="text" class="tel2 form-control" /></div><div class="form-group col-md-1 no-padding">'+DiscountBlock+'</div></div>').insertAfter('.peo_after');
        var HTmm = '';
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_one_people_no",
                data: {plase:PlaseVal,price:Prise,ferryman_id:$('.ferryman').val(),valute:'<? echo $valute;?>',route_name_id:'<?=$route_id;?>',prior:0,open:0},
                async: false,
                success: function(data) {
                    //alert(data);
                    HTmm = data;
                    $(HTmm).insertBefore('.peo_after');
                },
                error:function(code, opt, err){
                    alert("Состояние choise 2");
                }
            });  
            
         $('.custom_date').blur(function(){
            //alert('blur');
            var Par = $(this).parents('.one_people');
            
            var FiarstData = '';
            
            $.ajax({
                type: "POST",
                url: "/discounts/ajax_get_discount_age",
                data: {burn:$(this).val(),ferryman_id:$('.ferryman').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    
                    var ress = '';
                    
                    if(data.length > 0){
                        //alert('>');
                            Par.find('option').each(function(){
                            if($(this).val() == data){
                                $(this).attr('selected','selected');
                                //alert($(this).val());
                                Par.find('.discount_hid').select();
                                
                                var vall = $(this).val();
                                /////
                                var Proc = 0;
                                $.ajax({
                                    type: "POST",
                                    url: "/discounts/ajax_get_discount",
                                    data: {dis_id:$(this).val(),lang:$("#cur_lan").val()},
                                    async: false,
                                    success: function(data) {
                                        
                                        var newdate = data.split('#');
                                        //exit;
                                        Proc = parseFloat(newdate[0]);
                                        Par.find('.info_discounts').text(newdate[1]);
                                        Par.find('.main_discount_id').val(vall);
                                        
                                    },
                                    error:function(code, opt, err){
                                        alert("Состояние custom_date length");
                                    }
                                });                
                                
                                //alert(Par.find('.discount_hid option:selected').text());
                               // 
                                
                                //var PRI = parseFloat($('.al').text());
                                var PRiDIS = Prise/100*Proc;
                                var NewPriceDIS = Prise - PRiDIS;
                                
                                $('.people .plase').each(function(){
                                    if($(this).text() == PlaseVal){
                                        $(this).next('.dis_price').text(NewPriceDIS.toFixed(2));
                                        $(this).parents('.one_people').find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
                                    }
                                })
                                //$('.al').text(NewPriceDIS.toFixed(2));
                                //alert(NewPriceDIS);
                                CURPRICEDISC();
                                //exit;
                                /////
                            }
                        })
                    }//else{
                        //alert('her');
                    //}
                    //exit;
                    
                },
                error:function(code, opt, err){
                    alert("Состояние : custom_date ошибка");
                }
            });
            
            
            
            
            var bl_5_10 = Par.find('.dis_5_of_10').css('display');
            //alert(bl_5_10);
            
            var TestDis = Par.find('.discount_hid').val();
            
            if('<?=$sesuser[0]['parent_sysuser']?>' == 23 && bl_5_10 == 'block' && TestDis == 7){
                Par.find('.dis_5_of_10').hide();
            }
            //alert(TestDis);
            
         })
         
         
        ////////////////////////
        
        $('.cos_li').click(function(){
            $(this).parents('.par_sell').find('.discount').html($(this).data('dissellect'));
            //CURPRICEDISC();
            alert('li click');
            //$('.discount').change();
        })
        
        $('.ajax_tel').keyup(function(){
            var Blo = $(this);
            //Blo.next('.ajax_loadd').show(1000);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_people",
                data: {tel:$(this).val(),ferryman_id:$('.ferryman').val()},
                //async: ,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_block').html(data);
                    
                    
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_tel");
                }
            });
            //Blo.next('.ajax_loadd').hide(10000);
        })
        
        var plase_sel = Par.html();
        $('<div class="admin_choise">'+plase_sel+'</div>').insertAfter('.admin_plases');
        $('.tik_pri_modal').show();
        
        
        $('.ajax_cl_id').keyup(function(){
        //alert('oj');
        var Blo = $(this);
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_get_cl_id",
            data: {id:$(this).val(),ferryman_id:$('.ferryman').val()},
            //async: false,
            success: function(data) {
                //alert(data);
                //Proc = parseFloat(data);
                Blo.next('.ajax_people_id_block').html(data);
            },
            error:function(code, opt, err){
                alert("Состояние ajax_cl_id");
            }
        });
    })
    
        
        CURPRICEDISC();
        
    }else { 
        
        $(this).parent().find('.bscheme').removeClass('selected_plase');
        $('.tik_pri_modal').hide();
        var Curr = parseFloat($(this).text());
        $(this).parents('.border-bus').next('.bus-info-right').find('.bscheme').each(function(){
            if(parseFloat($(this).text()) == Curr){
                $(this).parents('.one_ch').remove();
                  $(this).remove();
                
            }
        });
        
        //var allPri = parseFloat($('.al').text());
        //var Prise = parseFloat('<?=$price?>');
        //var NewPri = allPri - Prise;
        //$('.al').text(NewPri.toFixed(2));
        var Tex = $(this).text();
        
        //alert(Tex);
         $('.admin_choise div').each(function(){
         if($(this).text() == Tex){
                $(this).parent().remove();
          } 
        });
        
        $('.people .one_people span').each(function(){
           if($(this).text() == Tex){
                $(this).parents('.one_people').remove();
           } 
        });
        CURPRICEDISC();
    }
    }
     setTimeout(HideAnimm,100);
})


function CURPRICEDISC(){
    $('.al').text(0);
    var Start = 0;
    $('.people .dis_price_inf').each(function(){
        Start += parseFloat($(this).text());
    })
    //alert(Start);
    $('.al').text(Math.round(Start))
    $('.top_val').text('<?=$valute;?>');
    al_busket();
}   

$('.route_date_modal').focus(function(){
    getDateModal();
    //exit;
})
/*
$(".datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {
        $(this).parents().find('.ui-datepicker').hide();
        var RouteNameID = $(this).next('.rou_name').val();
        
        var SchemaHTml = '';
        var From = $(this).parent().find('.from_sel_mod').val();
        var To =  $(this).parent().find('.to_sel_mod').val();
        //alert(From);
        //exit;
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_modal_transfer",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To},
            async: false,
            success: function(data) {
                //alert(data);
                ///writeCall(data);
                SchemaHTml = data
            },
            error:function(code, opt, err){
                alert("Состояние : datepicker_sell");
            }
       });
        $(this).parent().next('.salon_modal').html(SchemaHTml);
    },
    });   
*/    
    
function getDateModal(){
     var RouteNameID = $('.route_name_main').val();
     var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {route_name_id:RouteNameID},
            async: false,
            success: function(data) {
                
                Artex = data;
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
            
       });
       
       var arr = Artex.split(',');
    $('.ui-datepicker-group a').each(function(){
        var textT = $(this).text();
        if(textT.length == 1){
            textT = '0'+textT;
        }
        var HTMLL = $(this);
        var mons = $(this).parent().data('month');
            mons += 1;
            mons = '0'+mons;
        if(mons == '010'){
            mons = '10';
        }
        if(mons == '011'){
            mons = '11';
        }
        if(mons == '012'){
            mons = '12';
        } 
        var earT = $(this).parent().data('year');
        var Full = earT+'-'+mons+'-'+textT;
        //alert(Full);
        //alert(arr[0]);
        //exit;
        for(var st = 0; st<=arr.length; st++){
            if(arr[st] == Full){
                HTMLL.addClass('ui-state-active');
            }
        }
        //alert(Full);
        //exit;
    })
    
    //$('.animation_ajax').hide();
}
function HideAnimm(){
    $(".ajax_load").hide();
}
</script>



<?
function ezDate($d) { 
        $ts = time() - strtotime(str_replace("-","/",$d)); 
        
        if($ts>31536000) $val = round($ts/31536000,0).' year'; 
        else if($ts>2419200) $val = round($ts/2419200,0).' month'; 
        else if($ts>604800) $val = round($ts/604800,0).' week'; 
        else if($ts>86400) $val = round($ts/86400,0).' day'; 
        else if($ts>3600) $val = round($ts/3600,0).' hour'; 
        else if($ts>60) $val = round($ts/60,0).' minute'; 
        else $val = $ts.' second'; 
        
        if($val>1) $val .= 's'; 
        return $val; 
    } 

?>