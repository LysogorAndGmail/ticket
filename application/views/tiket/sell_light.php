<style>
#ui-datepicker-div {
top:670px !important;
top:400px !important;
left:650px!important;
z-index: 99999;
}
.ui-datepicker-group {
    width: 30% !important;
    float: left;
    margin: 10px 15px;
}
</style>
<? $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}
?>
<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<div>    		
    <div class="" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white --> 
                            <div class="padding_center">
                                <div class="col-md-10">
                                    <div class="row" style="min-height: 700px;">
                                        <ul class="" >
                                            <a href="/tiket/sell" id="btn-back"><i class="icon-custom-left"></i></a>
                                            <button class="btm-edit btn btn-success one_wey">One wey</button>
                                            <button class="btm-edit btn btn-success return_way">Return way</button>
                                        </ul>
                                        <br />
                                        <div class="tab-content_">
                                            <div class="animation_ajax" style="display:none; position: absolute; z-index:99999999 !important; text-align: center; width: 100%;">
                                                <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="100" height="100" />
                                            </div>
                                            <div class="one_wey_block">
                                                <div class="form-group col-md-2">
                                                    <label><?=__("Route")?></label>
                                                    <select name="route_name_id" class="form-control route_name_main">
                                                        <option></option>
                                                        <? foreach($routes as $r){?>
                                                        <option value="<?=$r['route_name_id'];?>"><?=$r['route_name_id'];?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label><?=__("From")?></label>
                                                    <select name="ost_from" class="form-control from_sel">    
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label><?=__("To")?></label>
                                                    <select name="ost_to" class="form-control to_sel">
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2" style="position: relative;">
                                                    <label><? echo __('Date');?></label>
                                                    <input name="desc_i18n" id="datepicker_sell" type="text" class="filds-ost-desc form-control route_date"   value="" />
                                                </div>        
                                            </div>
                                            <div class="return_wey_block" style="display: none;">
                                                <div class="form-group col-md-2">
                                                    <label><?=__("Route")?></label>
                                                    <select name="route_name_id" class="form-control return_route_name_main">
                                                        <option></option>
                                                        <? foreach($routes as $r){?>
                                                        <option value="<?=$r['route_name_id'];?>"><?=$r['route_name_id'];?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label><?=__("From")?></label>
                                                    <select name="ost_from" class="form-control return_from_sel">    
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label><?=__("To")?></label>
                                                    <select name="ost_to" class="form-control return_to_sel">
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2" style="position: relative;">
                                                    <label><? echo __('Date');?></label>
                                                    <input name="desc_i18n" id="return_datepicker_sell" type="text" class="filds-ost-desc form-control return_route_date"   value="" />
                                                </div>   
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="salon col-md-3"></div>
                                                <div class="return_salon col-md-3" style="display: none;"></div>
                                                <div class="col-md-9">
                                                    <div class="people">
                                                    <span class="peo_after">&nbsp;</span>
                                                    </div>
                                                    <div class="return_people" style="display: none;">
                                                    <span class="return_peo_after">&nbsp;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">   
                                            <div class="row form-row" style="display: none;" >
                                                <div class="col-md-12 print_ticket_block" id="print_ticket_block">
                                                    <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="100" height="100" style="margin: auto; display: block;" />
                                                </div>
                                            </div>
                                            <!--<button type="submit" class="btm-edit btn btn-success btn-cons" onclick="printDiv()"><?=__("Print")?></button>-->
                                            <button id="sell_tik" type="submit" class="btm-edit btn btn-success btn-cons"><?=__("Sell")?></button>
                                            <button id="order_tik" type="submit" class="btm-edit btn btn-salat btn-cons"><?=__("Order")?></button>
                                            <button type="submit" data-toggle="modal" data-target="#myModalBlock" class="btm-edit btn btn-default btn-cons"><?=__("Blocket")?></button>
                                            
                                            <div class="modal fade" id="myModalBlock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content tab-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <br>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="row form-row">
                                                        <div class="col-md-12">
                                                          <div class="col-md-12 returnet_block">
                                                              <div class="col-md-6">
                                                                  <label>Blocket Title</label>
                                                                  <input type="text" class="block_title" />
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <label>Choise</label>
                                                                  <p>Day:<input type="radio" name="blocho" class="block_choise" value="day" checked="checked" /></p>
                                                                  <p>All:<input type="radio" name="blocho" class="block_choise" value="all" /></p>
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      <button id="block_tik" type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Save")?></button>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            <button type="submit" id="block_clear" class="btm-edit btn btn-default btn-cons"><?=__("Снятие блокированых мест")?></button>
                                            <button type="submit" data-toggle="modal" data-target="#ClearBus" class="btm-edit btn btn-default btn-cons clearBus"><?=__("Салон без куплиных билетов")?></button>
                                            
                                            <div class="modal fade" id="ClearBus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content tab-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <br>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="row form-row">
                                                        <div class="col-md-12">
                                                          <p>Название:<input type="text" class="block_title_clear" /></p>
                                                          <div class="col-md-6 clearBlockBus">
                                                              
                                                          </div>
                                                          <div class="col-md-2">
                                                                  <label>Choise</label>
                                                                  <p>Day:<input type="radio" name="blochoo" class="block_choise_bez" value="day" checked="checked" /></p>
                                                                  <p>All:<input type="radio" name="blochoo" class="block_choise_bez" value="all" /></p>
                                                              </div>
                                                          <div class="col-md-4">
                                                            <h4><?=__("Plases:")?></h4>
                                                            <div class="admin_plases_clear"></div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      <button id="block_tik_bez_tikets" type="button" class="btn btn-primary"><?=__("Save")?></button>
                                                      <button type="submit" id="block_tik_clear_bez_tiket" class="btm-edit btn btn-default btn-cons"><?=__("Снятие блокированых мест")?></button>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
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
            alert('ошибка записи step_3');
        }
    });
})



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
    //alert('fgfh');
})

$('.return_way').click(function(){
    $('.one_wey_block').hide();
    $('.return_wey_block').show();
    $('.return_salon').show();
    $('.salon').hide();
    $('.people').hide();
    $('.return_people').show();
})

$('#block_tik_bez_tikets').click(function(){
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var BlocketTitle = $('.block_title_clear').val();
    var al_plase = [];
    $('.admin_choise_clear .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var Choise = $('.block_choise_bez:checked').val();
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
                alert('ошибка записи step_3');
            }
        });
});

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
                    data: {route_name_id:Rout,date:RouteDate,from:From,to:To},
                    async: false,
                    success: function(data) {
                        //alert(data);
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
                alert('ошибка записи step_3');
            }
        });
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
                alert('ошибка записи #block_tik_clear_bez_tiket');
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
                    data: {route_name_id:Rout,date:RouteDate,from:From,to:To},
                    async: false,
                    success: function(data) {
                        //alert(data);
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
                alert('ошибка записи #block_clear');
            }
        });
});

$("#sell_tik,#order_tik").click(function(){
    
    var Du = '';
    if($(this).attr('id') == 'sell_tik'){
        Du = 1;
    }else {
        Du = 2;
    }
    var array_inputs = [];
    $(this).parent().prev().find('.people').find('input').each(function(){
        array_inputs.push($(this).val());
    });
    var al_plase = [];
    $('.admin_choise .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var al_prise = [];
    $('.dis_price').each(function(){
        al_prise.push($(this).text());
    })
    var al_dis = [];
    $('.one_people .discount').each(function(){
        al_dis.push($(this).val());
    })
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Cur_price = al_prise;
    var All_summ = $('.al').text();
    var Valute = $('.al_val').text();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    /////////////// return 
    var return_inputs = [];
    $(this).parent().prev().find('.return_people').find('input').each(function(){
        return_inputs.push($(this).val());
    });
    
    var return_plase = [];
    $('.return_admin_choise .selected_plase').each(function(){
        return_plase.push($(this).text());
    })
    
    var return_price = [];
    $('.return_dis_price').each(function(){
        return_price.push($(this).text());
    })
    var return_dis = [];
    $('.one_people .return_discount').each(function(){
        return_dis.push($(this).val());
    })
    var return_Fer = $('.ferryman').val();
    var return_Bus = $('.buses').val();
    var return_Cur_price = return_price;
    var return_All_summ = $('.return_al').text();
    //var return_Valute = $('.al_val').text();
    var return_Rout = $('.return_route_name_main').val();
    var return_From = $('.return_from_sel').val();
    var return_To = $('.return_to_sel').val();
    var return_RouteDate = $('#return_datepicker_sell').val()
    ///////////////
    //alert(Valute);
    //exit;
    if(return_plase.length >= 1){
        //alert("ретурн");
        ///*
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets_return",
            async:false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,
                   return_route_name_id:return_Rout,return_from:return_From,return_to:return_To,return_plase:return_plase,return_inputs:return_inputs,
                   return_price:return_Cur_price,return_valute:Valute,return_buses_id:return_Bus,return_ferryman_id:return_Fer,return_route_date:return_RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),return_discount:return_dis
                    },
            success: function(data) {
                //alert(data);
                $('.print_ticket_block').html(data);
                printDiv();
                location="/tiket/sell";
            },
            error:function(){
                alert('ошибка записи step_3');
            }
        });
        //*/
    }else{
        /// только прямой
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis},
            success: function(data) {
                //alert(data);
                
                $('.print_ticket_block').html(data);
                //alert('ok');
                printDiv();
                location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
            },
            error:function(){
                alert('ошибка записи step_3');
            }
        });
        
        
    
        }
})

$(function() {
    $( "#dialog" ).dialog({autoOpen: false,});
});
$('.route_name_main').change(function(){
    //alert($(this).val());
    //exit;
    $('.animation_ajax').show();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        success: function(data) {
            $('.from_sel').html(data);
            $('.to_sel').html(data);
            $('.return_from_sel').html(data);
            $('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('ошибка записи step_3');
        }
    });
    
    $('.return_route_name_main').val($(this).val());
    $('.animation_ajax').hide();
    
})

$('.from_sel').change(function(){
    //alert($(this).val());
    //exit;
    $('.animation_ajax').show();
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
            alert('ошибка записи step_3');
        }
    });
    //alert($(this).html());
    //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
    $('.return_to_sel').val($(this).val());
    $('.animation_ajax').hide();
})

$('.to_sel').change(function(){
    //alert($(this).val());
    //alert($(this).html());
    //var ret_op = '<option value="'+$(this).val()+'">fghfgh</option>';
    $('.return_from_sel').val($(this).val());
})

$('.route_date').focus(function(){
     $('.animation_ajax').show();
    setTimeout(getDate,10);
    
})
$('.return_route_date').focus(function(){
    
    setTimeout(return_getDate,10);
    
})

$("#return_datepicker_sell").datepicker({
    monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авгу", "Сент", "Окт", "Ноя", "Дек" ],
    monthNames:[ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
    gotoCurrent: true,
    dayNamesMin: [ "Вос" , "Пон", "Вто", "Сре", "Чет", "Пят", "Суб",  ],
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.return_route_name_main').val();
        var SchemaHTml = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_return",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To},
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
        $('.return_salon').html(SchemaHTml);
    },
    });    

function getDate(){
     //$('.animation_ajax').show();
     var RouteNameID = $('.route_name_main').val();
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
        //exit;
        $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {day:Full,route_name_id:RouteNameID},
            //async: false,
            success: function(data) {
                
                if(data == Full){
                    //alert(HTMLL);
                    HTMLL.addClass('ui-state-active');
                }
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
            
       });
    })
    
    $('.animation_ajax').hide();
}

function return_getDate(){
     var RouteNameID = $('.return_route_name_main').val();
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
        //exit;
        $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {day:Full,route_name_id:RouteNameID},
            //async: false,
            success: function(data) {
                
                if(data == Full){
                    //alert(HTMLL);
                    HTMLL.addClass('ui-state-active');
                }
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
       });  
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


</script>













