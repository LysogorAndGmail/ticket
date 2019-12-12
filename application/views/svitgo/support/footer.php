<?
$sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}

$sysuser_group = DB::select()->from('groups')->where('id','=',$sesuser['group_id'])->execute()->current(); ?>
<div class="print_ticket_block" id="print_ticket_block"></div>
<footer class="footer bottom_block_sell sell_info" style="display: none;">
        <div class="container">
        <div class="row row-sm-height  text-center">
        <div class="col-sm-5 col-sm-height col-middle m-t-20  ">
      
      
      
      
        <!--Sale panel-->
        <!-- Large modal -->
            <button type="button" class="btn btn-primary btn-lg bat_sell_modall novalcheck" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-print"></i>&nbsp;<?=__("Sell")?></button>
            <!-- Small modal -->
            <button type="button" class="btn btn-success btn-lg bat_reserv_modall novalcheck" data-toggle="modal" data-target=".bs-example-modal-sm"><?=__("To book")?></button>
      
        <!--End Booking btm panel--> 
        </div>        
        <div class="col-sm-7 text-left  col-sm-height col-middle text-center m-t-15 p-b-10">
        
        <div class="col-md-6"><span class="text-white"><?=__("One way")?></span>&nbsp; <span class="text-white bold al">0</span>&nbsp; <span class="top_val  al_bascet_valute text-white"></span></div> 
        <div class="col-md-6"><span class="text-white"><?=__("Return way")?></span>&nbsp; <span class="text-white bold return_al">0</span>&nbsp; <span class="top_val  al_bascet_valute text-white"></span></div>
        
        <div class="col-md-12">
            <h3 class="all-caps light text-white"><?=__("Together to pay")?> <span class="al_bascet bold">0</span>&nbsp;<span class="top_val  al_bascet_valute"></span></h3>
        </div>
        
        </div>
        </div>
        
        </div>
        
        
        
    </footer> 
    
  
    
 <!-- jQuery (потрібно для JavaScript плагінів Bootstrap) -->
 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content tab-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <br />
        </div>
        <div class="modal-body">
        <div class="row form-row">
        <div class="col-md-12">
        <div class="col-md-12 m-b-20">
        <h3 class=""><span><?=__('Together to pay')?>:</span> <span class="al_bascet bold" style="margin: 0 !important; color:black;"></span> <span class="top_val"></span></h3>
        </div>
        <div class="col-md-12 col-sm-12">
        <? if($sysuser_group['show_tik_vedomost'] == 1){?>
        <div class="checkbox check-warning">
        <input id="checkbox5" class="add_vedomost" type="checkbox" value="1">
        <label for="checkbox5"><?=__("Add to Payroll");?></label>
        </div>
        <?}?>
        </div>
        <div class="col-md-12 col-sm-12">
        <button id="sell_tik" type="button" class="btn btn-primary" ><?=__("Pay in cash")?></button>
        <button type="button" class="btn  btn-primary" data-dismiss="modal"><?=__("Terminal")?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Cancel")?></button>
        </div>
        </div>
        </div>
        </div>
     
        </div>
  </div>
</div>    

      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-content tab-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <br />
                    </div>
                    <div class="modal-body">
                    <div class="row form-row">
                    <div class="col-md-12">
                    <div class="col-md-12">
                    <h3><?=__('Attention! Booking will be deleted: 24 hours before bus')?></h3>
                    <br />
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
            
 <script type="text/javascript">
$("#order_tik").click(function(){    
    
    //startAn(1);
    //alert( $(this).parents('.tab-content_').find('.people').html());
    //exit;
    var Rice = $('.radio_rice:checked').val();
    var Rice_rerurn = $('.radio_rice_return:checked').val();
    
    var tik_arrays = [];
   
    var Du = '';
    Du = 2;
    
    $('.people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    var array_inputs = [];
    //var Ty = 1;
    $('.people .one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
        //if(Ty != 1){
            array_inputs.push(onePeo);
        //}
        //Ty++;
    });
    
     var al_plase = [];
    $('.admin_choise .selected_plase').each(function(){
        al_plase.push($(this).text());
    })
    var al_prise = [];
    $('.dis_price_inf').each(function(){
        al_prise.push($(this).text());
    })
    var al_dis = [];
    $('.people .one_people .discount').each(function(){
        al_dis.push($(this).val());
    })
    
    
    if(al_dis[0] === null){
        //alert('null');
        var al_dis = [];
        $('.people .one_people .discount_hid').each(function(){
            al_dis.push($(this).val());
        })
    }
    
    //alert(al_dis);
    //exit;

    
    var Fer = $('.ferryman').val();
    var Bus = $('.buses').val();
    var Cur_price = al_prise;
    var All_summ = $('.al').text();
    var Valute = $('.al_bascet_valute').text();
    var Rout = $('.route_name_main').val();
    var From = $('.from_sel').val();
    var To = $('.to_sel').val();
    var RouteDate = $('#datepicker_sell').val();
    var RouteDate_newDay = $('.date_from_schema').val();
    var RouteDate_end = $('.date_from_schema_end').val();
    ///////////////
    var Print = '';
    // только прямой
    if(array_inputs.length != 0){    
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,rice:Rice,vedomost:0,route_date_newday:RouteDate_newDay,route_date_end:RouteDate_end},    
            success: function(data) {
                
                //alert(data);
                //exit;
              
                var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
            },
            error:function(){
                alert('ошибка #order_tik');
            }
        });
        
      }  
      
    //alert(tik_arrays);
    //exit;  
      
    $(this).parents('.tab-content_').find('.return_people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    
    var return_inputs = [];
    //var Tyy = 1;
    $(this).parents('.tab-content_').find('.return_people .one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()];
        return_inputs.push(onePeo);
    });
    
    if(return_inputs.length != 0){    
    
        var return_plase = [];
            $('.return_admin_choise .selected_plase').each(function(){
            return_plase.push($(this).text());
            })
            var return_price = [];
            $('.return_dis_price').each(function(){
            return_price.push($(this).text());
            })
            var return_dis = [];
            $('.return_people .one_people .discount_hid').each(function(){
            return_dis.push($(this).val());
            })
            
        
            if(return_dis[0] === null){
                //alert('null');
                var return_dis = [];
                $('.return_people .one_people .discount').each(function(){
                    return_dis.push($(this).val());
                })
            }
            
            
            var return_Fer = $('.ferryman').val();
            var return_Bus = $('.buses').val();
            var return_Cur_price = return_price;
            var return_All_summ = $('.return_al').text();
            var return_Valute = $('.al_val').text();
            //var Valute = $('.al_val').text();
            
            var return_Rout = $('.return_route_name_main').val();
            var return_From = $('.return_from_sel').val();
            var return_To = $('.return_to_sel').val();
            var return_RouteDate = $('#return_datepicker_sell').val();
            
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async:false,
                data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:return_plase,inputs:return_inputs,price:return_price,valute:return_Valute,buses_id:return_Bus,ferryman_id:return_Fer,route_date:return_RouteDate,lang:$("#cur_lan").val(),du:2,sesuser:$('.sesuser').val(),discount:return_dis,rice:Rice_rerurn,vedomost:0},
                success: function(data) {
                 
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        tik_arrays.push(Tiks[ss]);
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik return');
                }
            });
    }
     
    

       $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_one_order_reserv",
        async: false,
        data: {tik_arrays:tik_arrays,lang:$("#cur_lan").val(),valute:$('.al_bascet_valute').text(),full_price:$('.bottom_block_sell .al_bascet').html()},
        success: function(data) {
            //Print.push(data);
       
        },
        error:function(){
            alert('ajax_sell_tikets_one_order');
        }
    });
    
    modal_info_open('<h1><?=__("You Booked Ticket")?></h1>');
    modal_info_close('/tiket/sell');
      
}) 
 
 
 
$("#sell_tik").click(function(){

    
    var vedomost = 0;
    
    var Add_vedomost = $('.add_vedomost:checked').val();
    //alert(Add_vedomost);
    if(Add_vedomost == 1){
        vedomost = 1;
    }
    //exit;
    
    var Print = '';
    var tik_arrays = [];
    var tik_arrays_open = [];
    $('.people').find('.pad_top').each(function(){
       $(this).remove(); 
    });
    var array_inputs = [];
    //var Ty = 1;
    $('.people .one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
        //if(Ty != 1){
            array_inputs.push(onePeo);
        //}
        //Ty++;
    });
    
    
    
    var Rice = $('.radio_rice:checked').val();
    
    var Rice_rerurn = $('.radio_rice_return:checked').val();
    //alert(Rice);
    
    //exit;
    var Opret = $('.open_on:checked').val();
    
    if(array_inputs.length != 0 && Opret == 'on'){
        
        var al_plase = [];
        $('.people .one_people').each(function(){
            al_plase.push(0);
        })
        alert(al_plase+'open');
        exit;
        var al_prise = [];
        $('.people').find('.dis_price_inf').each(function(){
        al_prise.push($(this).text());
        })
        var al_dis = [];
        $('.people .one_people .discount_hid').each(function(){
        al_dis.push($(this).val());
        })
        
        if(al_dis[0] === null){
            //alert('null');
            var al_dis = [];
            $('.people .one_people .discount').each(function(){
                al_dis.push($(this).val());
            })
        }
        
        
        
        //var Fer = $('.ferrymans_open').val();
        //var Bus = $('.buses').val();
        var Cur_price = al_prise;
        var All_summ = $('.al').text();
        //var Valute = $('.al_val').text();
        var Valute = $('.sell_vall').val();
        var Rout = $('.route_name_main').val();
        var From = $('.from_sel').val();
        var To = $('.to_sel').val();
        var RouteDate = '';
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets_open",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,route_date:RouteDate,lang:$("#cur_lan").val(),sesuser:$('.sesuser').val(),discount:al_dis,rice:Rice},
            success: function(data) {
                //alert(data);
                //exit;
                //Print += data;
                //tik_arrays.push(data);
                //$('.print_ticket_block').html(Print);
                //alert('Open create!');
                
                //location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
                var Tiks = data.split(',');
                for(var ss=0; ss<Tiks.length; ss++){
                    if(Tiks[ss].length != 0){
                        tik_arrays_open.push(Tiks[ss]);
                    }
                }
            },
            error:function(){
                alert('ошибка save open прямой');
            }
        });
        
    }else{
        
        
        
        if(array_inputs.length != 0){
            
        //     alert(array_inputs+'прямой');
        //exit;
        
            var Du = '';
            Du = 1;    
            var al_plase = [];
            $('.admin_choise .selected_plase').each(function(){
                al_plase.push($(this).text());
            })
            var al_prise = [];
            $('.dis_price_inf').each(function(){
                al_prise.push($(this).text());
            })
            var al_dis = [];
            $('.people .one_people .main_discount_id').each(function(){
                al_dis.push($(this).val());
            })
            
            //alert(al_dis);
            //exit;
        
            
            var Fer = $('.ferryman').val();
            var Bus = $('.buses').val();
            var Cur_price = al_prise;
            var All_summ = $('.al').text();
            var Valute = $('.sell_vall').val();
            var Rout = $('.route_name_main').val();
            var From = $('.from_sel').val();
            var To = $('.to_sel').val();
            var RouteDate = $('#datepicker_sell').val();
            var RouteDate_newDay = $('.date_from_schema').val();
            var RouteDate_end = $('.date_from_schema_end').val();
            
            
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async: false,
                data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,rice:Rice,vedomost:vedomost,route_date_newday:RouteDate_newDay,route_date_end:RouteDate_end},
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
                        if(Tiks[ss].length != 0){
                            tik_arrays.push(Tiks[ss]);
                        }
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik прямой');
                }
            });
            //alert(tik_arrays);
            //exit;
            //printDiv();from_sel
        }
    }
    
    
    //alert('end');
    //exit;
    
    var return_inputs = [];
    //var Tyy = 1;
    $('.return_people .one_people').each(function(){
        //if(Tyy != 1){
            var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()];
            return_inputs.push(onePeo);
        //}
        //Tyy++;
    });
    
    var Opret_return = $('.open_on_return:checked').val();
    
    if(return_inputs.length != 0 && Opret_return == 'on'){
        //alert('ретурт опен');
        var al_plase = [];
        $('.return_people .one_people').each(function(){
            al_plase.push(0);
        })
       var return_price = [];
       $('.return_people').find('.dis_price_inf').each(function(){
        return_price.push($(this).text());
       })
       //alert(return_price);
       //exit;
       var return_dis = [];
       $('.return_people .one_people .main_discount_id').each(function(){
        return_dis.push($(this).val());
       })
       
       
        //var Fer = $('.ferrymans_open').val();
        //var Bus = $('.buses').val();
        var Cur_price = al_prise;
        var All_summ = $('.al').text();
        //var Valute = $('.al_val').text();
        var Valute = $('.sell_vall').val();
        var return_Rout = $('.return_route_name_main').val();
        var return_From = $('.return_from_sel').val();
        var return_To = $('.return_to_sel').val();
        var RouteDate = '';
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets_open",
            async: false,
            data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:al_plase,inputs:return_inputs,price:return_price,valute:Valute,route_date:RouteDate,lang:$("#cur_lan").val(),sesuser:$('.sesuser').val(),discount:return_dis,rice:Rice_rerurn},
            success: function(data) {
                //alert(data);
                //exit;
                //Print += data;
                //tik_arrays.push(data);
                //$('.print_ticket_block').html(Print);
                //alert('Open create!');
                
                //location="/tiket/sell";
                //setTimeout(Mywin_print(),1000);
                //printDiv('print_ticket_block');
                //;
                var Tiks = data.split(',');
                for(var ss=0; ss<Tiks.length; ss++){
                    if(Tiks[ss].length != 0){
                    tik_arrays_open.push(Tiks[ss]);
                    }
                }
            },
            error:function(){
                alert('ошибка save open');
            }
        });
    }else{
        if(return_inputs.length != 0){
            //alert('ретурт');
            var return_plase = [];
            $('.return_admin_choise .selected_plase').each(function(){
            return_plase.push($(this).text());
            })
            var return_price = [];
            $('.return_dis_price').each(function(){
            return_price.push($(this).text());
            })
            var return_dis = [];
            $('.return_people .one_people .main_discount_id').each(function(){
            return_dis.push($(this).val());
            })
            
            
            alert(return_plase);
            exit;
            
            
            var return_Fer = $('.ferryman').val();
            var return_Bus = $('.buses').val();
            var return_Cur_price = return_price;
            var return_All_summ = $('.return_al').text();
            var return_Valute = $('.sell_vall').val();
            //var Valute = $('.al_val').text();
            
            var return_Rout = $('.return_route_name_main').val();
            var return_From = $('.return_from_sel').val();
            var return_To = $('.return_to_sel').val();
            var return_RouteDate = $('#return_datepicker_sell').val();
            
            var RouteDate_newDay_return = $('.date_from_schema_return').val();
            var RouteDate_end_return = $('.date_from_schema_end_return').val();
            
            
            
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_sell_tikets",
                async:false,
                data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:return_plase,inputs:return_inputs,price:return_price,valute:return_Valute,buses_id:return_Bus,ferryman_id:return_Fer,route_date:return_RouteDate,lang:$("#cur_lan").val(),du:1,sesuser:$('.sesuser').val(),discount:return_dis,rice:Rice_rerurn,vedomost:vedomost,route_date_newday:RouteDate_newDay_return,route_date_end:RouteDate_end_return},
                success: function(data) {
                    ///tik_arrays.push(data);
                    //alert(data);
                    //exit;
                    //Print += data;
                    //
                    var Tiks = data.split(',');
                    for(var ss=0; ss<Tiks.length; ss++){
                        if(Tiks[ss].length != 0){
                            tik_arrays.push(Tiks[ss]);
                        }
                    }
                },
                error:function(){
                    alert('ошибка #sell_tik return');
                }
            });
            //
        }
    }
    
    
    
    
    alert(tik_arrays);
    exit;
    
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
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val(),valute:$('.al_bascet_valute').text(),full_price:$('.bottom_block_sell .al_bascet').html()},
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
    setTimeout(printDiv(),1000);
    location="/tiket/sell";
    //alert(return_inputs);
    //exit;
})



</script>             
            
    <!-- Підключення мінімізованої збірки всіх плагінів jQuery. Можна підключати додаткові плагіни, якщо потрібно -->
    <script src="<?=Kohana::$base_url;?>assets/js/bootstrap.min.js"></script>
    <!-- <script src="<?=Kohana::$base_url;?>assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>-->
    <!-- <script type="text/javascript" src="<?=Kohana::$base_url;?>assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>-->
    
    
    