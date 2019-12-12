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
.main_plases_block .selected_plase {
    display: inline;
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
    
    //$price_array = Model::factory('TiketMod')->chek_price_model($route_id,$from,$to,$ses_valute,$ferryman_id);
    
    //print_r($price_array);
    //die;
    
    
    $price = '';//$price_array[0];
    $valute = '';//$price_array[1];
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
            
            
            //if(empty($all_schema)){
            //    echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2054")."!<h4>";
            //}
            
            $schema_arr = array();
            foreach($all_schema as $all){
                $schema_arr[$all['schema_name']][$all['dx']][$all['dy']] = $all;
            }
            
            
            
            //$block_plase_array = Model::factory('TiketMod')->block_all($id,$ferryman_id); 
            
            //sell
            //$sell_array = Model::factory('TiketMod')->sell_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $sell_array = array();
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            
            
            // end sell
            //reserv
            $reserv_array = array();
            //$reserv_array = Model::factory('TiketMod')->reserv_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            
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
                
                //array_push($new_block_plase,array('value'=>$sys_biz));
            }
            
            
            
            $old_disp_bizi = Model::factory('TiketMod')->old_disp($route_id,$fro,$to,$route_date); 
            
            foreach($old_disp_bizi as $old_biz){
                
                //array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            
            $week = date('w',strtotime($route_date));

            $all = DB::select()->from('newblocket_plase')
                ->where('route_name_id','=',$route_id)
                ->and_where('week_id','=',$week)
                ->and_where('buses','=',$id)
                ->and_where('blocket_type','=','week')
                ->and_where('ferryman','=',$ferryman_id)
                ->execute()->as_array();
                
            $all_blocket = array();
             foreach($all as $one){
                $new_arr = explode(',',$one['plases']);
                foreach($new_arr as $new){
                    array_push($all_blocket, $new);
                }
                
             }  
            
            foreach($all_blocket as $old_biz){
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            //print_r($new_block_plase);
            
            
            
            $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($route_id,$fro,$to,$route_date);
            
            //print_r($all_blocked_plase);
            
            $all_bizi_nikolo = array();
            //if(!empty($all_blocked_plase)){
                //$all_bizi_nikolo = array_diff($all_schema_plases,$all_blocked_plase);
                //$all_bizi_nikolo = array_diff($all_bizi_nikolo,$sell);
                //$all_bizi_nikolo = array_diff($all_bizi_nikolo,$reserv);
            //}else{
           //     $all_bizi_nikolo = array();
           // }
            
            
            //if(empty($price)){
            //    echo __("Contact your administrator.").__("No price.");
            //    die;
            //}
            
            
            
        $newdate = explode('-',$route_date);
        $n_d = $newdate[2].'/'.$newdate[1].'/'.$newdate[0]; 
 ?> 
<input type="hidden" class="date" value="<?=$n_d;?>" />
<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="ferryman" value="<?=$ferryman_id;?>" />
<input type="hidden" class="buses" value="<?=$id;?>" />
<input type="hidden" class="date_from_schema" value="<?=$route_date;?>" />
<input type="hidden" class="date_from_schema_end" value="" />
<div class="border-bus left ner_1 bus">
    <button class="chek_all_plase"><?=__('Select all')?></button>
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
                                         
                            <?    }                        
                             ?>" data-tikID="<?=$tik['ticket_id'];?>" <? } } ?>
                             
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




$('.radioo').change(function(){
    $(this).parents('.form-row').find('.transfer_block').toggle();
    $(this).parents('.form-row').find('.returnet_block').toggle();
})
    
function DellTable(ht,par,pri){
    par.each(function(){
        if($(this).html() == ht){
            $(this).removeClass('selected_plase');
        }
    })
}
    
$('.choise').click(function(){
    //var MaxSel =  1;
   
    if($(this).parent().find('.bizi').html() == null && $(this).parent().find('.blocket').html() == null) {
    if($(this).parent().find('.selected_plase').html() == null){
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
            
       
         
         
        ////////////////////////
       
        
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
    
        
        //CURPRICEDISC();
        
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
        //CURPRICEDISC();
    }
    }
    
})


function CURPRICEDISC(){
    $('.al').text(0);
    var Start = 0;
    $('.people .dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    $('.al').text(Math.round(Start))
    $('.top_val').text('<?=$valute;?>');
    al_busket();
}   

$('.route_date_modal').focus(function(){
    getDateModal();
    //exit;
})
$('.chek_all_plase').click(function(){
    $(this).parent('.bus').find('.choise').each(function(){
        $(this).click();
    })
})

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