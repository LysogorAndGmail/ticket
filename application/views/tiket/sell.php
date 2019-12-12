<? $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}
//echo '<br />';
/*
echo '<pre>';
print_r($lang);
echo '</pre>';8
*/
$sysuser_group = DB::select()->from('groups')->where('id','=',$sesuser['group_id'])->execute()->current();
$count_day_sell = $sysuser_group['count_day_sell'];
 if($sesuser[0]['parent_sysuser'] == 1){?>
    <?=__("You can not sell tickets"); //die;?>
    <?}else{?>
<style>
.ac_tabs {
    background-color: grey !important;
}
.noValid {
    border: 1px solid red !important;
}
.noValid_empty {
    border: 1px solid red !important;		
}
.novalcheck {
    display: none !important;
}
</style>
<div class="container container-fixed-lg">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group btn-group-justified" style="position: relative;">
                <div class="btn-group">
                    <button class="btn btn-info one_wey ac_tabs" type="button">
                        <br>
                        <span class="fs-11 font-montserrat text-uppercase "><?=__("One way")?></span>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-info return_way" type="button">
                        <br>
                        <span class="fs-11 font-montserrat text-uppercase "><?=__("Return way")?></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <!-- START PANEL one wey -->
            <div class="one_wey_block">
                <div class="panel-body" style="background-color:#f1f2f6">
                    <!--
                    <div class="col-sm-12 p-b-10"><div class="checkbox check-primary">
                        <input type="checkbox" id="checkbox3" value="1">
                        <label for="checkbox3"><?=__("You may choose one way ticket with an open date")?></label>
                        </div>
                    </div>  -->
                    <div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label><?=__("Currency")?></label>
                                <? $valutes = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$sesuser[0]['id'])->execute()->as_array();?>
                                <select class="sell_vall form-control inp" >
                                    <? foreach($valutes as $va){?>
                                        <option value="<?=$va['valute']?>" <? if(isset($sesuser[0]['default_valute'])){ if($sesuser[0]['default_valute'] == $va['valute']){ echo 'selected="selected"'; }}?>><?=$va['valute']?></option>
                                    <?}?>
                                </select>                 
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label><?=__("Route number")?></label>
                                <select name="route_name_id" class="form-control route_name_main"  >
                                    <option value="Id"></option>
                                    <? foreach($routes as $r){?>
                                    <option value="<?=$r['route_name_id'];?>"><?=$r['name'];?></option>
                                    <?}?>
                                </select>                   
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?=__("From whence")?></label>
                                <select name="ost_from" class="form-control from_sel" >
                                    <option value="Id"></option>
                                </select>                
                            </div>
                        </div>       
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?=__("Where")?></label>
                                <select name="ost_to" class="form-control to_sel"  >
                                    <option value="Id"></option> 
                                </select>                 
                            </div>
                        </div>          
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="input-group date col-sm-8" id="datepicker-component">
                                    <label><?=__("Date of departure")?></label>
                                    <input name="desc_i18n" id="datepicker_sell" disabled="disabled" type="text" class="datepicker_sell filds-ost-desc form-control route_date inp" placeholder=""  value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section col-sm-12  p-t-15 p-b-10">
                        <div class="col-sm-4">
                            <!-- -->
                            <div class="sell_rice" style="display: none;"></div>
                            <!-- -->
                        </div>
                        <div class="col-sm-3"><h5 class="text-complete"><span class="item-count animate-number semi-bold bus_sell_from"></span></h5></div>
                        <div class="col-sm-3"><h5 class="text-complete"><span  class="item-count animate-number semi-bold bus_sell_to"></span></h5></div>
                        <div class="col-sm-2">      <h5 class="fer_sell item-count animate-number bold"></h5>
                        
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END PANEL end one wey-->
            
            <!-- return way block -->
            <div class="return_wey_block" style="display: none;">
                <div class="panel-body" style="background-color:#f1f2f6">

                <!--
                <div class="col-md-1 col-sm-1 input-t-open text-center">
                <p class="text-black semi-bold"><?=__("Open")?></p>
                <input id="checkbox2ret" type="checkbox" class="open_on_return">
                <?php /*?>    <label for="checkbox2" class="input-t-open">Open</label><?php */?>
                </div>-->
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <label><?=__("Route number")?></label>
                        <select name="route_name_id" class="form-control return_route_name_main inp">
                            <option></option>
                            <? foreach($routes_reverse as $r){?>
                            <option value="<?=$r['route_name_id'];?>"><?=$r['name'];?></option>
                            <?}?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?=__("From whence")?></label>
                        <select name="ost_from" class="form-control return_from_sel inp"></select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?=__("Where")?></label>
                        <select name="ost_to" class="form-control return_to_sel inp"></select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label><?=__("Date of departure")?></label>
                        <input name="desc_i18n" id="return_datepicker_sell" type="text" class="filds-ost-desc form-control return_route_date inp"   value="<?=__("Date of departure")?>" />
                    </div>
                </div>
                <div class="section col-sm-12  p-t-15 p-b-10">
                        <div class="col-sm-4">
                            <!-- -->
                            <div class="sell_rice_return" style="display: none;"></div>
                            <!-- -->
                        </div>
                        <div class="col-sm-3"><h5 class="text-complete"><span class="item-count animate-number semi-bold return_bus_sell_from"></span></h5></div>
                        <div class="col-sm-3"><h5 class="text-complete"><span  class="item-count animate-number semi-bold return_bus_sell_to"></span></h5></div>
                        <div class="col-sm-2"><h5 class="return_fer_sell item-count animate-number semi-bold"></h5></div>
                        
                    </div>          
                </div>
            </div>
            <!-- end return wey block -->
            
        </div>
    </div>
    <br />
    <div class="container container-fixed-lg">
        <div class="row">
            <div class="col-md-12"></div>
            
            <!-- -->
        
            <div class="col-md-12 col-sm-12 one_par p-b-10" >
                <div class="salon col-md-3 col-sm-3" ></div>
                <div class="return_salon col-md-3 col-sm-3" style="display: none; padding: 0;  float: left; padding-top: 20px; padding-left: 20px;"></div>
                <div class="col-md-9 col-sm-9 no-padding m-b-10">
                   <!--One way-->
                    <div class="people">
                        <span class="peo_after">&nbsp;</span>
                    </div>
                    <!-- End One way-->
                    <!--return way-->
                    <div class="return_people" style="display: none;">
                        <span class="return_peo_after" style="display: none;">&nbsp;</span>
                    </div>
                    <!-- End return way-->
                </div>
            </div>
        </div>
    </div>
</div> <!-- end contener -->         
<?}?>  



<script type="text/javascript">
//one_wey
$("#datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    //showButtonPanel: true,
    onSelect: function (dateText, inst) {
        
        
        $('.salon').html('');
        $('.ajax_load').show();
        
        //$('.ajax_load').hide,1000);     
        //sleep(1000);
        
        $('.one_people').remove();
        $('.al').text('');
        $('.al_bascet').text('');
        $('.top_val').text('');
                
        
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.route_name_main').val();
        var SchemaHTml = '';
        var From = $('.from_sel').val();
        var To = $('.to_sel').val();
        
        //alert(To);
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                ///writeCall(data);
                SchemaHTml = data;
                
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_schema_svitgo /buses/ajax_see_schema_svitgo");
            },
       });
        
       var ricee = ''; 
        $.ajax({
            type: "POST",
            url: "/buses/ajax_get_sell_rice",
            data: {route_name_id:RouteNameID,date:dateText,from:From},
            async: false,
            success: function(data) {
                ricee = data
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_get_sell_rice");
            }
       });
       
       
       //alert(ricee); 
      $('.sell_rice').html(ricee);  
      //exit;  
        
       // $('.animation_ajax').hide();
      ///////////  arive
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:$("#cur_lan").val(),rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                Top = data;
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_route_arive");
            },
            complete: function(){
                //ajax_animation_stop();
                //$("body").css('display','block');
                //alert('ok');
            }
       });
       var newTop = Top.split(',');
       $('.bus_sell').text(newTop[0]);
       $('.bus_sell_from').text(newTop[1]);
       $('.bus_sell_to').text(newTop[2]);
       $('.fer_sell').text(newTop[3]);
       $('.platform_from').text(newTop[4]);
       $('.platform_to').text(newTop[5]);
       $('.free_plase').text(newTop[6]);
       $('.biz_plase').text(newTop[7]);
       
       
       //alert(newTop[10]);
     ///////////  depart 
        $('.fix_block').hide();
        
        /////////enter schema 
        
        if(newTop[1].length == 11 || newTop[2].length == 11){
            $('.salon').html("<? echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2055")."!<h4>";?>");
        }else {
            $('.salon').html(SchemaHTml);
            var Op = $('.open_on:checked').val();
            if(Op == 'on'){ 
                $('#open_tik').show();
            }else{
                $('.bat_sell_modall').show();
                $('#order_tik').show();
            }
            $('.bottom_block_sell').show();
        }  
        
        
        $('.date_from_schema_end').val(newTop[10]);
        
        
        $('.sell_rice').show(); 
        
        $('.open_on').attr('disabled',true);  
        
        
        //();
        setTimeout(HideAnimm,100);

    }, // end selected date
});

$("#return_datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 4,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    //showButtonPanel: true,
    onSelect: function (dateText, inst) {
        
        $('.ajax_load').show();
        
        
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.return_route_name_main').val();
        var SchemaHTml = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_return",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                ///writeCall(data);
                SchemaHTml = data
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });  
       
       
       var ricee = ''; 
        $.ajax({
            type: "POST",
            url: "/buses/ajax_get_sell_rice_return",
            data: {route_name_id:RouteNameID,date:dateText,from:From},
            async: false,
            success: function(data) {
                ricee = data
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });
       
       
       $('.sell_rice_return').html(ricee);        
       // alert(ricee);
       // exit;
        ///////////  arive
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:$("#cur_lan").val(),rice:1},
            async: false,
            success: function(data) {
                Top = data;
                //alert(data);
                //
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });
       var newTop = Top.split(',');
       $('.return_bus_sell').text(newTop[0]);
       $('.return_bus_sell_from').text(newTop[1]);
       $('.return_bus_sell_to').text(newTop[2]);
       $('.return_fer_sell').text(newTop[3]);
       $('.return_platform_from').text(newTop[4]);
       $('.return_platform_to').text(newTop[5]);
       $('.return_free_plase').text(newTop[6]);
       $('.return_biz_plase').text(newTop[7]);
       
       //if(newTop[1].length == 11 || newTop[2].length == 11){
       //     $('.return_salon').html("<? echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2055")."!<h4>";?>");
      //  }else {
            $('.return_salon').html(SchemaHTml);
       // }
      //  $('.date_from_schema_end').val(newTop[10]);
        $('.date_from_schema_end_return').val(newTop[10]);
        
        $('.sell_rice_return').show();    
     ///////////  depart 
       // $('.open_on_return').attr('disabled',true);
        
        
        setTimeout(HideAnimm,100);
    },
    });    





$('#block_tik_clear_bez_tiket').click(function(){
    var Choise = $('.block_choise_bez:checked').val();
    //alert(Choise);
    //exit;
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var al_plase = [];
    $('.admin_choise_clear .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    //alert(al_plase);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases_clear",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,date:RouteDate,choise:Choise},
            success: function(data) {
                //alert(data);
                
                //$('.print_ticket_block').html(data);
                //alert('ok');
                //printDiv();
                location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
            },
            error:function(){
                alert('write error #block_tik_clear_bez_tiket');
            }
        });
});


$('#block_tik_clear_bez_tiket_return').click(function(){
    var Fer = $('.return_salon .ferryman').val();
    var Bus = $('.return_salon .buses').val();
    var Rout = $('.return_salon .route_name_id').val();
    var From = $('.return_salon .from_salon').val();
    var To = $('.return_salon .to_salon').val();
    var RouteDate = $('#return_datepicker_sell').val();
    var BlocketTitle = $('#ClearBus_return .block_title_clear').val();
    var al_plase = [];
    $('#ClearBus_return .admin_choise_clear .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var Choise = $('#ClearBus_return .block_choise_bez:checked').val();
    //alert(al_plase);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases_clear",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,date:RouteDate,choise:Choise},
            success: function(data) {
                //alert(data);
                
                //$('.print_ticket_block').html(data);
                //alert('ok');
                //printDiv();
                location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
            },
            error:function(){
                alert('write error #block_tik_clear_bez_tiket');
            }
        });
});



$('#block_tik_bez_tikets').click(function(){
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var BlocketTitle = $('#ClearBus .block_title_clear').val();
    var al_plase = [];
    $('#ClearBus .admin_choise_clear .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var Choise = $('#ClearBus .block_choise_bez:checked').val();
    //alert(Choise);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,sesuser:$('.sesuser').val(),title:BlocketTitle,buses_id:Bus,ferryman_id:Fer,date:RouteDate,choise:Choise},
            success: function(data) {
                //alert(data);
                
                //$('.print_ticket_block').html(data);
                //alert('ok');
                //printDiv();
                location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
            },
            error:function(){
                alert('ошибка #block_tik_bez_tikets');
            }
        });
});

$('#block_tik_bez_tikets_return').click(function(){
     var Fer = $('.return_salon .ferryman').val();
    var Bus = $('.return_salon .buses').val();
    var Rout = $('.return_salon .route_name_id').val();
    var From = $('.return_salon .from_salon').val();
    var To = $('.return_salon .to_salon').val();
    var RouteDate = $('#return_datepicker_sell').val();
    var BlocketTitle = $('#ClearBus_return .block_title_clear').val();
    var al_plase = [];
    $('#ClearBus_return .admin_choise_clear .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var Choise = $('#ClearBus_return .block_choise_bez:checked').val();
    //alert(Choise);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,sesuser:$('.sesuser').val(),title:BlocketTitle,buses_id:Bus,ferryman_id:Fer,date:RouteDate,choise:Choise},
            success: function(data) {
                //alert(data);
                
                //$('.print_ticket_block').html(data);
                //alert('ok');
                //printDiv();
                location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
            },
            error:function(){
                alert('ошибка #block_tik_bez_tikets');
            }
        });
});

$('.clearBus').click(function(){
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_clear_bus",
        async: false,
        data: {route_name_id:Rout,from:From,to:To,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val()},
        success: function(data) {
            //alert(data);
            
            $('.clearBlockBus').html(data);
            //$('.people').html('<span class="peo_after">&nbsp;</span>');
            //alert('ok');
            //printDiv();
            //location="/tiket/sell";
            //setTimeout(Mywin_print(),1000);
            //printDiv('print_ticket_block');
            //;
        },
        error:function(){
            alert('ошибка записи clearBus');
        }
    });
})

$('.clearBus_return').click(function(){
    var Fer = $('.return_salon .ferryman').val();
    var Bus = $('.return_salon .buses').val();
    var Rout = $('.return_salon .route_name_id').val();
    var From = $('.return_salon .from_salon').val();
    var To = $('.return_salon .to_salon').val();
    var RouteDate = $('#return_datepicker_sell').val();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_clear_bus",
        async: false,
        data: {route_name_id:Rout,from:From,to:To,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val()},
        success: function(data) {
            //alert(data);
            
            $('.clearBlockBus_return').html(data);
            //$('.people').html('<span class="peo_after">&nbsp;</span>');
            //alert('ok');
            //printDiv();
            //location="/tiket/sell";
            //setTimeout(Mywin_print(),1000);
            //printDiv('print_ticket_block');
            //;
        },
        error:function(){
            alert('ошибка записи clearBus_return');
        }
    });
})

function ReturnTosell_chenge(){
    
    //alert($(this).html());
    //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
        
        //alert('on');
        
        $('.return_people').find('.one_people').each(function(){
            $(this).remove();
        });
        var HTmm = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        var route = $('.return_route_name_main').val();
        /*
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_one_people_open_return",
                data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val(),prior:1,open:1},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    HTmm = data;
                    $(HTmm).insertAfter('.return_peo_after');
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_get_one_people_open_return");
                }
            });
        */
        //$('#datepicker_open').focus();
        //$(this).focus();
         ////////////////////////////////////// 
    //      alert('pl');
   //exit;  
       
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_open_select_return",
                data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //HTmm = data;
                    $('.return_salon').html(data);
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_open_select_return");
                }
            });
        ///////////////////////////////////////
        //alert('ijkgh');
        
        //al_busket();
        
        
        //GetFerDat($(this).val());
        $('#open_tik').show();
        $('.bottom_block_sell').show();
        
        
        $('.ajax_tel').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_people",
                data: {tel:$(this).val(),fer:$('.ferryman').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_block').html(data);
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_tel");
                }
            });
        })
        
        
        $('.ajax_cl_id').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_cl_id",
                data: {id:$(this).val(),fer:$('.ferryman').val()},
                async: false,
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
        
        CURPRICEDISC_first();
    

}

$('.to_sel').change(function(){
    //alert($(this).val());
    //alert($(this).html());
    //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
    $('.ajax_load').show(); 
     //$('.ajax_load').show();
    
    var Op = $('.open_on:checked').val();
    
    if(Op == 'on'){ 
        
        
        $('.people .one_people').each(function(){
            $(this).remove();
        });
        var HTmm = '';
        var From = $('.from_sel').val();
        var To = $(this).val();
        var route = $('.route_name_main').val();
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_one_people_open",
                data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val(),prior:0,open:1},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    HTmm = data;
                    $(HTmm).insertAfter('.peo_after');
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_get_one_people_open");
                }
            });
        //////////////////////////////////////    
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_open_select",
                data: {route_name_id:route},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //HTmm = data;
                    $('.salon').html(data);
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_open_select");
                }
            });
        ///////////////////////////////////////
        //$('#datepicker_open').focus();
        //$(this).focus();
        //GetFerDat($(this).val());
        $('#open_tik').show();
        $('.bottom_block_sell').show();
        CURPRICEDISC_first();
        //$('.')
        
    
    }else{
     $('.people .one_people').remove();
     $('.al').text('');
     $('.al_bascet').text('');
     $('.top_val').text('');
        $('.bus_sell').text('');
    $('.bus_sell_from').text('');
    $('.bus_sell_to').text('');
    $('.salon').html("");
    $('#datepicker_sell').val("");
    $('.return_from_sel').val($(this).val());
    }
    
    setTimeout(HideAnimm,100);
})






$(".return_datepicker_sell_clone").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 4,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    //showButtonPanel: true,
    onSelect: function (dateText, inst) {
        
        $('.ajax_load').show();
        
        
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.return_route_name_main').val();
        var SchemaHTml = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_return",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                ///writeCall(data);
                SchemaHTml = data
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });  
       
       
       var ricee = ''; 
        $.ajax({
            type: "POST",
            url: "/buses/ajax_get_sell_rice_return",
            data: {route_name_id:RouteNameID,date:dateText,from:From},
            async: false,
            success: function(data) {
                ricee = data
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });
       
       
       $('.sell_rice_return').html(ricee);        
        
        ///////////  arive
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:$("#cur_lan").val(),rice:1},
            async: false,
            success: function(data) {
                Top = data;
                //
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
       });
       var newTop = Top.split(',');
       $('.return_bus_sell').text(newTop[0]);
       $('.return_bus_sell_from').text(newTop[1]);
       $('.return_bus_sell_to').text(newTop[2]);
       $('.return_fer_sell').text(newTop[3]);
       $('.return_platform_from').text(newTop[4]);
       $('.return_platform_to').text(newTop[5]);
       $('.return_free_plase').text(newTop[6]);
       $('.return_biz_plase').text(newTop[7]);
       
       if(newTop[1].length == 11 || newTop[2].length == 11){
            $('.return_salon').html("<? echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2055")."!<h4>";?>");
        }else {
            $('.return_salon').html(SchemaHTml);
        }
        
        
        $('.sell_rice_return').show();    
     ///////////  depart 
        $('.open_on_return').attr('disabled',true);
        
        
        setTimeout(HideAnimm,100);
    },
    });    

function Validation() {
  var PeopCou = [];
    $('.one_people').each(function(){
        PeopCou.push(1);
    });
    if(PeopCou.length != 0){
        //alert('Choice seat!');
        //exit;
        //$('.bottom_block_sell').show();
        $('.bat_sell_modall').removeClass('novalcheck');
        $('.bat_reserv_modall').removeClass('novalcheck');
    }
  
  //alert("прошло 3 сек")
  $('.valid').each(function(){
    $(this).removeClass('noValid');
    if($(this).val().length != 0){
        if($(this).hasClass('tel') && $(this).val().length <= 8){
            $(this).addClass('noValid');
            $('.bat_sell_modall').addClass('novalcheck');
            $('.bat_reserv_modall').addClass('novalcheck');
        }else{
            
                if($(this).hasClass('tel') && 
                    $(this).val() == '000000000000' 
                    <? Model::factory('TiketMod')->blacklist();?>
                ){
                    $(this).addClass('noValid');
                    $('.bat_sell_modall').addClass('novalcheck');
                    $('.bat_reserv_modall').addClass('novalcheck');
                }
            
            if($(this).val().length <= 1){
                $(this).addClass('noValid');
                $('.bat_sell_modall').addClass('novalcheck');
                $('.bat_reserv_modall').addClass('novalcheck');
            }
        }
        if($(this).hasClass('soname') && $(this).val().length <= 2){
            $(this).addClass('noValid');
            $('.bat_sell_modall').addClass('novalcheck');
            $('.bat_reserv_modall').addClass('novalcheck');
        }
        
    }else{
        $(this).addClass('noValid');
        $('.bat_sell_modall').addClass('novalcheck');
        $('.bat_reserv_modall').addClass('novalcheck');
        
    }
    
  })

}

setInterval(Validation, 1000);



$('.open_on_return').change(function(){
    $('#return_datepicker_sell').attr('disabled',true);
     ReturnTosell_chenge();
    
})
function startAn(HTML){
    var id = '#dialogg';
    var maskHeight = '100%';
    var maskWidth = '100%';
    $('#mask').css({'width':maskWidth,'height':maskHeight});
    //$('#mask').fadeIn(1000); 
    $('#mask').fadeTo("fast",0.5); 
    var winH = $(window).height();
    var winW = $(window).width();
    $(id).css('top',  350);
    $(id).css('left', 430);
    $(id).fadeIn(1000); 
    $(id).find('.contentt').html(HTML);
    
    //});
    $('.windoww .close').click(function (e) { 
        e.preventDefault();
        $('#mask, .windoww').hide();
        location="/tiket/sell";
    }); 
    $('#mask').click(function () {
        $(this).hide();
        $('.windoww').hide();
        location="/tiket/sell";
    }); 
}

$('#ord_tik').click(function(){
    if($(this).hasClass('novalcheck')){
        exit;
    }
})




$('.return_to_sel').change(function(){
    
    $('.ajax_load').show();
    //alert($(this).val());
    //alert($(this).html());
    //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
    $('.bottom_block_sell').show();
     
    
    var Op = $('.open_on_return:checked').val();
    
    if(Op == 'on'){ 
        
        //alert('on');
        $('.return_people').find('.one_people').each(function(){
            $(this).remove();
        });
        var HTmm = '';
        var From = $('.return_from_sel').val();
        var To = $(this).val();
        var route = $('.return_route_name_main').val();
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_one_people_open_return",
                data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val(),prior:1,open:1},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    HTmm = data;
                    $(HTmm).insertAfter('.return_peo_after');
                },
                error:function(code, opt, err){
                    
                    $('<p>error return_to_sel/ajax_get_one_people_open_return</p>').insertAfter('.return_peo_after');
                }
            });
        
        //$('#datepicker_open').focus();
        //$(this).focus();
         //////////////////////////////////////    
       
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_open_select_return",
                data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //HTmm = data;
                    $('.return_salon').html(data);
                },
                error:function(code, opt, err){
                    //alert("Состояние ajax_open_select_return");
                    $('.return_salon').html('<p>Chek ferryman and route discounts!</p>');
                }
            });
        ///////////////////////////////////////
        //alert('ijkgh');
        
        //al_busket();
        
        
        //GetFerDat($(this).val());
        $('#open_tik').show();
        $('.bottom_block_sell').show();
        
        
        $('.ajax_tel').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_people",
                data: {tel:$(this).val(),fer:$('.ferryman').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_block').html(data);
                },
                error:function(code, opt, err){
                    alert("Состояние ajax_tel");
                }
            });
        })
        
        
        $('.ajax_cl_id').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_cl_id",
                data: {id:$(this).val(),fer:$('.ferryman').val()},
                async: false,
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
        
    
    }else{
        //alert('of');
    $('.return_people').find('.one_people').remove();
     $('.return_al').text('');
     //$('.al_bascet').text('');
     $('.top_val').text('');
     $('.return_bus_sell').text('');
    $('.return_bus_sell_from').text('');
    $('.return_bus_sell_to').text('');
    $('.return_salon').html("");
    $('#datepicker_sell_return').val("");

    }
    
    setTimeout(HideAnimm,100);
})

$('.return_from_sel').change(function(){
    $('.ajax_load').show();
    $('.return_salon').html("");
    $('.return_people .one_people').remove();
    $('.return_to_sel').change();
    setTimeout(HideAnimm,100);
})




$('.return_route_name_main').change(function(){
     
     $('.ajax_load').show();
     
     $('.return_people').find('.one_people').remove();
        $('.return_al').text('');
        //$('.al_bascet').text('');
        $('.top_val').text('');
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async:false,
        success: function(data) {
            //$('.from_sel').html(data);
            $('.return_to_sel').html(data);
            $('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    var Op = $('.open_on_return:checked').val();
    
    if(Op == 'on'){    
        //
        //var curr_text = $('.to_sel option:selected').text();
        //alert($('.to_sel').val());
        //alert($('.return_from_sel').val());
        $('.return_from_sel option').each(function(){
            //alert($(this).val());
            if($(this).val() == $('.to_sel').val()){
                $(this).attr('selected',true);
            }
        })
        
        $('.return_to_sel option').each(function(){
            //alert($(this).val());
            if($(this).val() == $('.from_sel').val()){
                $(this).attr('selected',true);
                //$('.return_to_sel').change();
                //$('.return_to_sel').select();
            }
        })
        
        //alert('ok');
        //$('.return_to_sel').change();
        ReturnTosell_chenge();
        //$('.return_to_sel option').each(function(){
            //alert($(this).val());
         //   if($(this).attr('selected') === true){
         //       
        //        $(this).change();
                //$('.return_to_sel').select();
        //    }
        //})
        
        
    }
    setTimeout(HideAnimm,100);
    
})

$('.route_name_main').change(function(){ 
    
    $('.ajax_load').show();
    
    var ParBlo = $(this).parents('.sell_form');
    
    
    
     $('.people').find('.one_people').remove();
        $('.al').text('');
        //$('.al_bascet').text('');
        $('.top_val').text('');
    //ajax_animation_start();
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            $('.from_sel').html(data);
            //$('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost_last",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            //$('.from_sel').html(data);
            $('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    var Op = $('.open_on:checked').val();
    
    if(Op == 'on'){ 
        //$('.to_sel').change();
        
    }else{ // если не опен
    
    var aa_rev = '';
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_reverse",
        async: false,
        data: {route_main_id:$(this).val(),lang:$("#cur_lan").val()},
        success: function(data) {
            //$('.from_sel').html(data);
            //$('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
            aa_rev = data;
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    var NewArr = aa_rev.split(',');
    //alert(NewArr);
    //var htm = '<option value="'+NewArr[0]+'">'+NewArr[1]+'</option>';
    //$('.return_route_name_main').html(htm);
    var curr_text = $('.route_name_main option:selected').text();
    
    //var SelectNow = $(this).val();
    $('.return_route_name_main option').each(function(){
        if($(this).text() == curr_text){
            $(this).attr('selected',true);
        }
    })
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_ost_slave",
        async: false,
        data: {route_name_id:NewArr[0],slave_city:NewArr[2],lang:$("#cur_lan").val()},
        success: function(data) {
            //$('.from_sel').html(data);
            //$('.to_sel').html(data);
            $('.return_from_sel').html(data);
            $('.return_to_sel').html(data);
            //alert(data);
            //aa_rev = data;
        },
        error:function(){
            alert('ошибка записи route_name_main');
        }
    }); 
    
    //;
    //alert(ParBlo.find('.from_sel').val());
     $('.return_from_sel option').each(function(){
        if($(this).val() == $('.to_sel').val()){
            $(this).attr('selected',true);
     //       alert($(this).val());
        }
    })
    
     $('.return_to_sel option').each(function(){
        if($(this).val() == $('.from_sel').val()){
            $(this).attr('selected',true);
     //       alert($(this).val());
        }
    })
    
    //alert(NewArr[0]);
    
    $('.hasDatepicker').attr('disabled',false);
    
    }
    
    
    
   // ajax_animation_stop();
   setTimeout(HideAnimm,100);
    
})





$('.bat_sell_modall').click(function(){
    if($(this).hasClass('novalcheck')){
        return false;
    }
    //alert('ok');
})

$('.bat_reserv_modall').click(function(){
    if($(this).hasClass('novalcheck')){
        return false;
    }
    //alert('ok');
})


$('#layout-condensed-toggle').click();
//alert('ok');
//exit;

function CheckVall(){
    
    $('.tel').each(function(){
        $(this).removeClass('noValid_empty');
    })
    
    var PeopCou = [];
    $('.one_people').each(function(){
        PeopCou.push(1);
    });
    if(PeopCou.length == 0){
        alert('Choice seat!');
        //exit;
        
    }
    $('.valid').each(function(){
        if($(this).val().length == 0){
            $(this).addClass('noValid_empty');
        }else{
            $(this).removeClass('noValid_empty');
        }
    })
    $('.valid').each(function(){
        if($(this).val().length == 0){
            //alert('Fill all fields');
            //exit;
        }
    })
    $('.tel').each(function(){
        if(
        $(this).val() == '00000000' 
        <? Model::factory('TiketMod')->blacklist();?>
        ){
            $(this).addClass('noValid_empty');
            alert('error phone nomber');
            exit;
        }
    })
    $('.noValid').each(function(){
        alert('Fill all fields');
        exit;
    })
    //$('.bat_sell_modall').removeClass('novalcheck');
    
}















function printDiv() {
     var printContents = document.getElementById('print_ticket_block').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}


$('.one_wey').click(function(){
    $('.one_wey_block').show();
    $('.return_wey_block').hide();
    $('.return_salon').hide();
    $('.salon').show();
    $('.people').show();
    $('.return_people').hide();
    $('.return_way').removeClass('ac_tabs');
    $(this).addClass('ac_tabs');
    //alert('fgfh');
})

$('.return_way').click(function(){
    var chek_no_valid = [];
       $('.noValid').each(function(){
            chek_no_valid.push(1);
       })
       if(chek_no_valid.length != 0){
            modal_info_open("<h3><?=__('Registration of passenger for round trip')?></h3><h5><?=__('Before registration of passenger for “return” trip, please complete the registration of passenger for “out” trip.')?></h5>");
            return false;
       }
    $('.one_wey_block').hide();
    $('.return_wey_block').show();
    $('.return_salon').show();
    $('.salon').hide();
    $('.people').hide();
    $('.return_people').show();
    $('.one_wey').removeClass('ac_tabs');
    $(this).addClass('ac_tabs');
    //$('.one_wey').hide();
    
})



$('#block_tik').click(function(){
    //$('#datepicker_sell').focus();
    //exit;
    
    //alert($('.one_people').html());
    //exit;
    
    var Choise = $('.block_choise:checked').val();
    //alert(Choise);
    //exit;
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var BlocketTitle = $('.block_title').val();
    var al_plase = [];
    $('.admin_choise .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    //alert(al_plase);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,sesuser:$('.sesuser').val(),title:BlocketTitle,buses_id:Bus,ferryman_id:Fer,date:RouteDate,choise:Choise},
            success: function(data) {
                
                $('.salon').html("");
                $('.one_people').remove();
                
                SchemaHTml = '';
                $.ajax({
                    type: "POST",
                    url: "/buses/ajax_see_schema_svitgo",
                    data: {route_name_id:Rout,date:RouteDate,from:From,to:To,rice:1},
                    async: false,
                    success: function(data) {
                        //alert(data);
                        //exit;
                        ///writeCall(data);
                        SchemaHTml = data;
                        
                    },
                    error:function(code, opt, err){
                        alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
                    }
               });
                $('.salon').html(SchemaHTml);
            },
            error:function(){
                alert('ошибка #block_tik');
            }
        });
});

$('#block_clear').click(function(){
    var Choise = 'day';
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var al_plase = [];
    $('.admin_choise .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    //alert(al_plase);
    //exit;
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_blocket_plases_clear",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,date:RouteDate,choise:Choise},
            success: function(data) {
                
                $('.salon').html("");
                $('.one_people').remove();
                
                SchemaHTml = '';
                $.ajax({
                    type: "POST",
                    url: "/buses/ajax_see_schema_svitgo",
                    data: {route_name_id:Rout,date:RouteDate,from:From,to:To,rice:1},
                    async: false,
                    success: function(data) {
                        //alert(data);
                        ///writeCall(data);
                        SchemaHTml = data;
                        
                    },
                    error:function(code, opt, err){
                        alert("Status : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
                    }
               });
                $('.salon').html(SchemaHTml);
            },
            error:function(){
                alert('write error #block_clear');
            }
        });
});



$(function() {
    $( "#dialog" ).dialog({autoOpen: false,});
    
});


$('.from_sel').change(function(){
    
    $('.ajax_load').show();    
    
     var Op = $('.open_on:checked').val();
    
 //   if(Op != 'on'){ 
        $('.salon').html("");
        
        $('.one_people').remove();
        $('.al').text('');
        $('.al_bascet').text('');
        $('.top_val').text('');
        //alert($(this).val());
        //exit;
        //$('.animation_ajax').show();
        
        
        
        var RoutName = $('.route_name_main').val();
        $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost_weight",
        data: {route_name_id:RoutName,ost:$(this).val(),lang:$("#cur_lan").val()},
        success: function(data) {
        //$('.from_sel').html(data);
        $('.to_sel').html(data);
        //alert(data);
        },
        error:function(){
        alert('ошибка from_sel');
        }
        });
        //alert($(this).html());
        //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
        //$('.return_to_sel').val($(this).val());
        //$('.animation_ajax').hide();
  //  }
    $('.return_to_sel option').each(function(){
        if($(this).val() == $('.from_sel').val()){
            $(this).attr('selected',true);
            //alert('ok');
        }
    })
        
  setTimeout(HideAnimm,100);
  
})



function CURPRICEDISC_first(){
    $('.al').text(0);
    var Start = 0;
    $('.dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    $('.al').text(Math.round(Start))
    $('.top_val').text($('.sell_vall').val());
    al_busket();
}   




$('.route_date').focus(function(){
    //ajax_animation_start();
    //setTimeout(getDate,10);
    //var start = new Date();
    getDate();
    //var end = new Date();
    //alert('Скорость ' + (end.getTime()-start.getTime()) + ' мс');    
    
})
$('.return_route_date').focus(function(){
    //$('.animation_ajax').show();
    return_getDate();
    
})

function HideAnimm(){
    $(".ajax_load").hide();
}


    


function getDate(){
     var RouteNameID = $('.route_name_main').val();
     var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {route_name_id:RouteNameID,from:$('.from_sel').val()},
            async: false,
            success: function(data) {
                
                Artex = data;
                //alert(data);
                //exit; 
            },
            error:function(){
                alert('ошибка записи step_3');
            }
            
       });
      
       var arr = Artex.split(',');
       
       
       
    //var ii = 1;
    var iii = 0;
    $('.ui-datepicker-group a').each(function(){
        //if(iii <= <?=$count_day_sell;?>){
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
        for(var st = 0; st<=Artex.length; st++){
            if(arr[st] == Full){
                HTMLL.addClass('ui-state-active');
            }
        }
        //alert(Full);
        //exit;
        //}
        iii++;
    })
    
    
    
    $('.ui-datepicker-group a').each(function(){
        var HTMLL = $(this);
        if(!HTMLL.hasClass("ui-state-active")){
            HTMLL.parent().addClass('ui-datepicker-unselectable ui-state-disabled');
        }
    })
}

function return_getDate(){
     var RouteNameID = $('.return_route_name_main').val();
    
     var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {route_name_id:RouteNameID},
            async: false,
            success: function(data) {
                
                Artex = data;
                //
                
                //alert(arr[0]);
                //if(data == Full){
                    //alert(HTMLL);
                //    HTMLL.addClass('ui-state-active');
                //}
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
            
       });
       
       var arr = Artex.split(',');
       //alert(arr);
       //exit;
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
    
}
function writeCall(Types){
    if(Types == 0 || Types == 1 || Types == 2 || Types == 3 || Types == 4 || Types == 5 || Types == 6){
        $('.ui-datepicker-group').each(function(){
            $(this).find('tr').each(function(){
                $(this).find('td').each(function(i){
                    if(i == Types){
                        $(this).find('a').addClass('ui-state-active');
                    }
                })
            })
        })
    }
    if(Types == "all"){
        $('.ui-datepicker-group').each(function(){
            $(this).find('tr').each(function(){
                $(this).find('a').each(function(){
                    $(this).addClass('ui-state-active');
                })
            })
        })
    }
    if(Types == "odd"){
        $('.ui-datepicker-group').each(function(){
            $(this).find('tr').each(function(){
                $(this).find('a').each(function(){
                    if( $(this).text() % 2 ){
                        
                    }else{
                        $(this).addClass('ui-state-active');
                    }
                    //alert($(this).html());
                    //exit;
                })
            })
        })
    }
    if(Types == "even"){
        $('.ui-datepicker-group').each(function(){
            $(this).find('tr').each(function(){
                $(this).find('a').each(function(){
                    if( $(this).text() % 2 ){
                        $(this).addClass('ui-state-active');
                    }
                    //alert($(this).html());
                    //exit;
                })
            })
        })
    }
    
}


$(".datepicker_sell_modal").datepicker();    
/*
function Mywin_print(ner) {
        //alert(ner);
        //exit;
        //var NE = ner.parents().html();
        var WWight = (document.body.clientWidth - 1000)/2;
        var WinPrint = window.open('','','left='+WWight+',top=200,width=1000,height=700,toolbar=0,scrollbars=1,status=0');
        //var Css = '';
        WinPrint.document.write('<div id="print" class="contentpane">');
        WinPrint.document.write('<style type="text/css">table tr, td {outline:1px solid #d1d1d1;} .timetable_route_icon,.timetable_route_dm,.timetable_route_departure { text-align:center;}</style>');
        WinPrint.document.write(ner);
        // WinPrint.document.write(prtContent.html());
        WinPrint.document.write('</div>');
        WinPrint.print();
        WinPrint.remove();
        $('#myModal').remove();
}
*/



$('.sell_vall').change(function(){
    //alert();
    if($(this).val() != ''){
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_chenge_valute",
                data: {sesuser:$('.sesuser').val(),valute:$(this).val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    ///writeCall(data);
                    //SchemaHTml = data
                    //;
                    //$('.reserv_info').html('');
                    modal_info_open('<h3 class="text-center"><?=__("Currency had been changed")?></h3>');
                    modal_info_close('/tiket/sell');
                    
                },
                error:function(code, opt, err){
                    alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
                }
           });
    }
    //setTimeout(location="/tiket/sell",5000);
})

//$('.name').keyup(function(){
//    alert('fgj');
//})
/////calculator open_on_return

/////// calculator bottom_block_sell search_tik <button type="button" class="btn btn-danger btn-cons" onclick="tiketAnul('210','39.46')">Annule ticket</button>

</script>













