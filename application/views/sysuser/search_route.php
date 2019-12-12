<? $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}
$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }

 I18n::lang($lang);
?>
<style>
.ajax_search_block .on_tik {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: #fff;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}
.ajax_search_block {
    background-color: #fff;
    z-index:999999 !important;
    top:70px;
    background-color: #e5e5e5;
    
}

.ajax_search_block .on_tik:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}
.ajax_search_block ul {
    padding: 0;
    margin: 0;
    position: absolute;
    width: 509px;
    max-height: 300px;
    overflow: auto;
    box-shadow: 0 2px 4px grey;
}
</style>
<div class="content">  
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class=""><h2 class=" inline"><?=__("Search Route")?></h2></div>
        </div>
    </div>
</div>
<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="default_valute" value="<? if(isset($sesuser[0]['default_valute'])){ echo $sesuser[0]['default_valute'];}?>" />
<div class="alert alert-info reserv_info" style="margin-top: 25px; margin-bottom: 0px; margin-left: 15px; margin-right: 15px; display: none;">
    <button class="close" onclick="$(this).parent().hide()" ></button>Info:&nbsp;<span></span>. 
</div>
<div class="bg-top-filters">
    <div>    		
        <div id="inbox-wrapper">
            <div class="content">
                <div class="row">
                    <div class="">    
                        <div class="search-bar-disp"> 
                            <div class="col-md-12 no-padding" >
                                <div class="col-md-3  no-padding">
                                    <div class="form-group col-md-12 one_search" style="position: relative;">
                                        <label><?=__("From")?></label>
                                        <input name="date" type="text" class="filds-ost-desc form-control search_osts from" placeholder="<?=__("From")?>" />
                                        <input type="hidden" class="ajax_ost_id from" value="" />
                                        <div class="ajax "></div>
                                    </div>
                                    <div class="form-group col-md-12 one_search" style="position: relative;">
                                        <label><?=__("To")?></label>
                                        <input name="date" type="text" class="filds-ost-desc form-control search_osts to" placeholder="<?=__("To")?>" />
                                        <input type="hidden" class="ajax_ost_id to" value="" />
                                        <div class="ajax"></div>
                                    </div>
                                </div><!--search from-->
                                <div class="col-md-2  no-padding">
                                    <div class="form-group col-md-12" style="position: relative;">
                                        <label><?=__("Outbound  journey")?></label>
                                        <input name="date_from" id="datepicker_sell" type="text" class="filds-ost-desc form-control" placeholder="<?=__("Date")?>"  value="<?=Date("d/m/y");?>" />
                                    </div>
                                    <div class="form-group col-md-12" style="position: relative;">
                                        <label><?=__("Return journey")?></label>
                                        <input type="checkbox" class="on_return" style="float: left;" />
                                        <input name="date_to" style="display: none; float: left;" id="datepicker_sell_to" type="text" class="filds-ost-desc" placeholder="<?=__("")?>"  value="" />
                                    </div>
                                </div><!--date search-->
                                <div class="col-md-7 form-group">
                                    <label>&nbsp;</label>
                                    <button class="btm-edit btn btn-success ajax_but"><i class="icon-ok"></i> <?=__("Search")?></button>
                                </div><!--search btm-->
                            </div>
                        </div>
                    </div> <!--Bar search-->
                </div>
            </div><!--blue bg-->
               
            
            <div class="row form-row" style="display: none;" >
            <div class="col-md-12 print_ticket_block" id="print_ticket_block">
            <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="24" height="24" style="margin: auto; display: block;" />
            </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="ajax_blok"></div>
    </div> <!-- end new layaut -->


    <div class="search-bus-results-cart">
        <div class="row"><div class="">
            <div class="col-md-6"><div class="panel-search-buy-p"><h4><?=__("Amount for")?> <?=__("Outbound journey")?><span style="display: none;" class="ret_jou"> , <?=__("Return journey")?></span></h4></div></div>
            <div class="col-md-2"><div class="panel-search-buy-price">          <h3>  <span class="al">0</span> <?=$sesuser[0]['default_valute'];?></h3></div></div>
            <div class="col-md-4">
            <div class="col-md-6">
            <button type="submit" data-toggle="modal" data-target="#sell_modal" class="btm-edit btn btn-success btn-cons btn-large bat_sell_modall novalcheck" style="font-family: Open Sans; font-weight:600;  margin-left: 30px; margin-top: 18px;"><i class="fa fa-print"></i>&nbsp;<?=__("Sell ticket")?></button></div>
            <div class="modal fade" id="sell_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content tab-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <br />
                </div>
                <div class="modal-body">
                  <div class="row form-row">
                    <div class="col-md-12">
                      <div class="col-md-12">
                          <h3><?=__('Total Price')?>:<span class="al" style="margin: 0 !important; color:black;"></span> <span class="top_val"></span></h3>
                      </div>
                      <div class="col-md-12">
                        
                            <div class="checkbox check-warning">
                              <input id="checkbox5" class="add_vedomost" type="checkbox" value="1">
                              <label for="checkbox5"><?=__("Add to Payroll");?></label>
                            </div>
                        
                      </div>
                      <div class="col-md-12">
                          <button id="sell_tik" type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Confirm")?></button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Terminal")?></button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Cancel")?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Close")?></button>
                </div>
              </div>
            </div>
        </div>
            <div class="col-md-6">
            <button type="submit" data-toggle="modal" data-target="#order_modal" class="btm-edit btn btn-salat btn-cons btn-large bat_reserv_modall novalcheck" style="font-family: Open Sans;  margin-top: 18px;"><?=__("ssssssReservation")?></button>
            <div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content tab-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <br />
                </div>
                <div class="modal-body">
                  <div class="row form-row">
                    <div class="col-md-12">
                      <div class="col-md-12">
                          <h3><?=__('Total Price')?>:<span class="al" style="margin: 0 !important; color:black;"></span> <span class="top_val"></span></h3>
                      </div>
                      <div class="col-md-12">
                        
                            <div class="checkbox check-warning">
                              <input id="checkbox5" class="add_vedomost" type="checkbox" value="1">
                              <label for="checkbox5"><?=__("Add to payroll");?></label>
                            </div>
                        
                      </div>
                      <div class="col-md-12">
                          <button id="order_tik" type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Confirm")?></button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Terminal")?></button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><?=__("Cancel")?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Close")?></button>
                </div>
              </div>
            </div>
        </div>
            </div>
            </div>                   
            </div>
        </div>
    </div>
 

</div>	       
</div>	
</div>
<div class="clearfix"></div>
</div>
</div>

     
                   
              
                   
               
<script type="text/javascript">


$("#sell_tik").click(function(){
    
    
    //alert($(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.all_people').find('.one_people').html());
    //exit;
    
    var vedomost = 0;
    
    var Print = '';
    var tik_arrays = [];
    var tik_arrays_open = [];
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    var array_inputs = [];
    //var Ty = 1;
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
        //if(Ty != 1){
            array_inputs.push(onePeo);
        //}
        //Ty++;
    });
    

    
    
        if(array_inputs.length != 0){
            //alert('прямой');
            
            var Du = '';
            Du = 1;    
            var al_plase = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.admin_choise .selected_plase').each(function(){
                al_plase.push($(this).text());
            })
    
            var al_prise = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').find('.dis_price').each(function(){
                al_prise.push($(this).text());
            })
            
           
            
            var al_dis = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').find('.discount_hid').each(function(){
                al_dis.push($(this).val());
            })
            
            
           
            var Fer = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.ferryman').val();
            var Bus = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.buses').val();
            var Cur_price = al_prise;
            var All_summ = $('.al').text();
            var Valute = $('.default_valute').val();
            var Rout = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.route_name_id').val();
            var From = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.from_salon').val();
            var To = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.to_salon').val();
            var RouteDate = $('#datepicker_sell').val();
            
            //alert(From);
            //exit;
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async: false,
                data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,rice:1,vedomost:vedomost},
                success: function(data) {
                    alert(data);
                    exit;
                    //Print += data;
                    //tik_arrays.push(data);
                    //$('.print_ticket_block').html(Print);
                    //alert('ok');
                    //location="/tiket/sell";
                    //setTimeout(Mywin_print(),1000);
                    //printDiv('print_ticket_block');
                    //;
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik прямой');
                }
            });
            //alert(tik_arrays);
            //exit;
            //printDiv();
        }
    
    ///* return 
    
    //alert($(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').html());
    //exit;
    
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    
    var return_inputs = [];
    //var Tyy = 1;
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people .one_people').each(function(){
        //if(Tyy != 1){
            var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()];
            return_inputs.push(onePeo);
        //}
        //Tyy++;
    });
    
   

        if(return_inputs.length != 0){
            //alert('ретурт');
            var return_plase = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.admin_choise .selected_plase').each(function(){
            return_plase.push($(this).text());
            })
            
            
            
            var return_price = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.dis_price').each(function(){
            return_price.push($(this).text());
            })
            
            var return_dis = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.one_people .discount_hid').each(function(){
            return_dis.push($(this).val());
            })
            
            var return_Fer = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.ferryman').val();
            //alert(return_Fer);
            //exit;
            var return_Bus = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.buses').val();
            var return_Cur_price = return_price;
            var return_All_summ = $('.al').text();
            var return_Valute = $('.default_valute').val();
            //var Valute = $('.al_val').text();
            
            var return_Rout = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.route_name_id').val();
            var return_From = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.from_salon').val();
            var return_To = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.to_salon').val();
            var return_RouteDate = $('#datepicker_sell_to').val();
            
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async:false,
                data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:return_plase,inputs:return_inputs,price:return_price,valute:return_Valute,buses_id:return_Bus,ferryman_id:return_Fer,route_date:return_RouteDate,lang:$("#cur_lan").val(),du:1,sesuser:$('.sesuser').val(),discount:return_dis,rice:1,vedomost:vedomost},
                success: function(data) {
                    ///tik_arrays.push(data);
                    //alert(data);
                    //exit;
                    //Print += data;
                    //
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik return');
                }
            });
            //
        }
    
    //*/
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_new_print",
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
            alert('ошибка ajax_sell_tikets_new_print');
        }
    });
    
    /// обьекдинение билетов в заказ 
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_one_order",
        async: false,
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val(),valute:$('.default_valute').val(),full_price:$('.bottom_block_sell .al_bascet').html()},
        success: function(data) {
            //Print.push(data);
            alert(data);
            exit;
            //Print += data;
            //$('.print_ticket_block').html(Print);
            //alert('ok');
            //location="/errors/test";
            //setTimeout(Mywin_print(),1000);
            //printDiv('print_ticket_block');
            //;
        },
        error:function(){
            alert('ajax_sell_tikets_one_order');
        }
    });
    
    
    
    
    $('.print_ticket_block').html(Print);
    //printDiv();
    location="/sysuser/search_route";
    //alert(return_inputs);
    //exit;
})


$("#order_tik").click(function(){
    
    
    //alert($(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.all_people').find('.one_people').html());
    //exit;
    
    var vedomost = 0;
    
    var Print = '';
    var tik_arrays = [];
    var tik_arrays_open = [];
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    var array_inputs = [];
    //var Ty = 1;
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
        //if(Ty != 1){
            array_inputs.push(onePeo);
        //}
        //Ty++;
    });
    

    
    
        if(array_inputs.length != 0){
            //alert('прямой');
            
            var Du = '';
            Du = 2;    
            var al_plase = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.admin_choise .selected_plase').each(function(){
                al_plase.push($(this).text());
            })
    
            var al_prise = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').find('.dis_price').each(function(){
                al_prise.push($(this).text());
            })
            
           
            
            var al_dis = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.all_people').find('.one_people').find('.discount_hid').each(function(){
                al_dis.push($(this).val());
            })
            
            
           
            var Fer = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.ferryman').val();
            var Bus = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.buses').val();
            var Cur_price = al_prise;
            var All_summ = $('.al').text();
            var Valute = $('.default_valute').val();
            var Rout = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.route_name_id').val();
            var From = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.from_salon').val();
            var To = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.first_people').find('.to_salon').val();
            var RouteDate = $('#datepicker_sell').val();
            
            //alert(From);
            //exit;
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async: false,
                data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,rice:1,vedomost:vedomost},
                success: function(data) {
                    //alert(data);
                    //exit;
                    //Print += data;
                    //tik_arrays.push(data);
                    //$('.print_ticket_block').html(Print);
                    //alert('ok');
                    //location="/tiket/sell";
                    //setTimeout(Mywin_print(),1000);
                    //printDiv('print_ticket_block');
                    //;
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik прямой');
                }
            });
            //alert(tik_arrays);
            //exit;
            //printDiv();
        }
    
    ///* return 
    
    //alert($(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').html());
    //exit;
    
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    
    var return_inputs = [];
    //var Tyy = 1;
    $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people .one_people').each(function(){
        //if(Tyy != 1){
            var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()];
            return_inputs.push(onePeo);
        //}
        //Tyy++;
    });
    
   

        if(return_inputs.length != 0){
            //alert('ретурт');
            var return_plase = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.admin_choise .selected_plase').each(function(){
            return_plase.push($(this).text());
            })
            
            
            
            var return_price = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.dis_price').each(function(){
            return_price.push($(this).text());
            })
            
            var return_dis = [];
            $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.one_people .discount_hid').each(function(){
            return_dis.push($(this).val());
            })
            
            var return_Fer = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.ferryman').val();
            //alert(return_Fer);
            //exit;
            var return_Bus = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.buses').val();
            var return_Cur_price = return_price;
            var return_All_summ = $('.al').text();
            var return_Valute = $('.default_valute').val();
            //var Valute = $('.al_val').text();
            
            var return_Rout = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.route_name_id').val();
            var return_From = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.from_salon').val();
            var return_To = $(this).parents('.search-bus-results-cart').prev().find('.ajax_blok').find('.return_people').find('.to_salon').val();
            var return_RouteDate = $('#datepicker_sell_to').val();
            
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async:false,
                data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:return_plase,inputs:return_inputs,price:return_price,valute:return_Valute,buses_id:return_Bus,ferryman_id:return_Fer,route_date:return_RouteDate,lang:$("#cur_lan").val(),du:2,sesuser:$('.sesuser').val(),discount:return_dis,rice:1,vedomost:vedomost},
                success: function(data) {
                    ///tik_arrays.push(data);
                    //alert(data);
                    //exit;
                    //Print += data;
                    //
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik return');
                }
            });
            //
        }
    
    //*/
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_new_print",
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
            alert('ошибка ajax_sell_tikets_new_print');
        }
    });
    
    /// обьекдинение билетов в заказ 
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_one_order",
        async: false,
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val(),valute:$('.default_valute').val(),full_price:$('.bottom_block_sell .al_bascet').html()},
        success: function(data) {
            //Print.push(data);
            //alert(data);
            //exit;
            //Print += data;
            //$('.print_ticket_block').html(Print);
            //alert('ok');
            //location="/errors/test";
            //setTimeout(Mywin_print(),1000);
            //printDiv('print_ticket_block');
            //;
        },
        error:function(){
            alert('ajax_sell_tikets_one_order');
        }
    });
    
    
    
    
    $('.print_ticket_block').html(Print);
    //printDiv();
    location="/sysuser/search_route";
    //alert(return_inputs);
    //exit;
})








$('.on_return').change(function(){
    $(this).next('input').toggle();
    $('.ret_jou').toggle();
    if($('#datepicker_sell_to').val().length > 0){
        $('#datepicker_sell_to').val('');
    }
})

///*
$("#datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});
//*/

$("#datepicker_sell_to").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});


$('.search_osts').keyup(function(){
    var IMP = $(this).parent('.col-md-12');
    $.ajax({
        type: "POST",
        url: "/sysuser/auto_new_search_route",
        data: {val:$(this).val(),lang:"<?=$lang;?>"},
        success: function(data) {
            //if(data == 'ok'){
            //    location='/pay/see_bus_schema';
            //}
            //alert(data);
            IMP.find('.ajax').html(data);
        },
        error:function(){
            alert('ошибка bus_step');
        }
    });
})

$('.ajax_but').click(function(){
    
    //alert('ok');
    //exit;
    
    var Parent = $(this).parents('#inbox-wrapper');
    var From = Parent.find('.from').val();
    var To = Parent.find('.to').val();
    $.ajax({
        type: "POST",
        url: "/sysuser/ajax_search_route",
        data: {from:From,to:To,date:$('#datepicker_sell').val(),date_return:$('#datepicker_sell_to').val(),lang:"<?=$lang;?>"},
        success: function(data) {
            //alert(data);
            //exit;
            $('.ajax_blok').html(data);
        },
        error:function(){
            alert('ошибка ajax_but');
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
</script>