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

<div class="p-t-70 col-md-12"></div>
<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="default_valute" value="<? if(isset($sesuser[0]['default_valute'])){ echo $sesuser[0]['default_valute'];}?>" />
<div class="alert alert-info reserv_info" style="margin-top: 25px; margin-bottom: 0px; margin-left: 15px; margin-right: 15px; display: none; width: 100%; height: 100%;">
    <button class="close" onclick="$(this).parent().hide()" ></button>Info:&nbsp;<span></span>. 
</div>
<div class="container container-fixed-lg">
    
      <? if($sesuser[0]['parent_sysuser'] == 1){?>
    <?=__("You can not sell tickets"); //die;?>
    <?}else{?>
    
    <? if($sesuser[0]['parent_sysuser'] == 72){?>
        <a href="http://nikolo.vpcommunication.cz" target="_blank"><?=__("Tickets sale and booking system")?></a>
    <?}?>

    <div>    		
      
      
      <h2 class="semi-bold"><?=__("Video instructions")?></h2>
    
 
     <div class="col-md-6"><a href="https://www.youtube.com/watch?v=U6vfSA_8Bu0" target="new"><?=__("Sale of tickets")?></a></div>
 
    
    
</div>	       


<?}?>
</div>



<script type="text/javascript">

function Validation() {
  var PeopCou = $('.al').html();
  if(PeopCou != 0){
    $('.tiles-body').show();
  }else{
    $('.tiles-body').hide();
  }
  var ii = 0;
  $('.one_people').each(function(){
    ii++;
  })
  if(ii != 0){
    $('#bat_sell_modall').show();
  }else{
    $('#bat_sell_modall').hide();
  }
  //alert("прошло 3 сек")

}

setInterval(Validation, 1000);


$('.on_open_return').change(function(){
    $('#datepicker_sell_to').val('');
})



$('.ajax_but').click(function(){
    
    
    $('.ajax_blok').html("");
    $(".ajax_load").show();
    var Parent = $(this).parents('#inbox-wrapper');
    var From = Parent.find('.from').val();
    var To = Parent.find('.to').val();
    var return_From = Parent.find('.return_from').val();
    var return_To = Parent.find('.return_to').val();
    
    var OpenOn = $('.on_open:checked').val();
    var OpenOn_Return = 0;
    OpenOn_Return = $('.on_open_return:checked').val();
    if(OpenOn_Return == 1){
    OpenOn_Return = 1;
    }else{
    OpenOn_Return = 0;
    }
    
    
    var on_return = $('.on_return:checked').val();
    if(on_return == 1){
    Return = 1;
    }
    
    
    var Return = 0;
    var on_return = $('.on_return:checked').val();
    if(on_return == 1){
    Return = 1;
    }
    
    if($('.from').val().length == 0 || $('.to').val().length == 0 || $('#datepicker_sell').val().length == 0){
        modal_info_open('Validation error');
        exit;
    }
    //alert('ok');
    //exit;
    //alert(Add_vedomost);
    if(OpenOn == 1){ //опен
        $.ajax({
        type: "POST",
        url: "/sysuser/ajax_search_route_open",
        data: {from:From,to:To,return_from:return_From,return_to:return_To,date:$('#datepicker_sell').val(),date_return:$('#datepicker_sell_to').val(),lang:"<?=$lang;?>",return_ch:Return,return_open:OpenOn_Return},
        success: function(data) {
        //alert(data);
        $('.ajax_blok').html(data);
        },
        error:function(){
        alert('ошибка ajax_but open');
        }
        });
    
    }else{ // не опен
        $.ajax({
        type: "POST",
        url: "/sysuser/ajax_search_route",
        data: {from:From,to:To,return_from:return_From,return_to:return_To,date:$('#datepicker_sell').val(),date_return:$('#datepicker_sell_to').val(),lang:"<?=$lang;?>",return_ch:Return,return_open:OpenOn_Return},
        success: function(data) {
            //alert(data);
            $('.ajax_blok').html(data);
        },
        error:function(){
            alert('ошибка ajax_but priamoy');
        }
        });
    }
    
    
    setTimeout(HideAnimm,500);
})



function HideAnimm(){
    $(".ajax_load").hide();
}

$("#sell_tik").click(function(){    
    
    
    var tik_arrays_open = [];
    
    var tik_arrays = [];
    
    var Open = $('.on_open:checked').val();
    
    var MainParent = $(this).parents('.page-content');
    
    if(Open == 1){ //open
    
    var CountOpen = 0;
    MainParent.find('.one_row_routes .all_people .one_people').each(function(){
    CountOpen++;
    })
    if(CountOpen != 0){
    
    
    MainParent.find('.one_row_routes .all_people .one_people').find('.pad_top').each(function(){
    $(this).remove(); 
    })
    
    
    var al_prise = [];
    MainParent.find('.one_row_routes .all_people').find('.dis_price').each(function(){
    al_prise.push($(this).text());
    })
    
    var al_dis = [];
    MainParent.find('.one_row_routes .all_people .one_people').each(function(){
    al_dis.push(1);
    })
    
    var array_inputs_open = [];
    MainParent.find('.one_row_routes .all_people .one_people').each(function(){
    var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
    array_inputs_open.push(onePeo);
    })
    
    var MainInfo = MainParent.find('.one_row_routes .info_for_sell');
    
    //var Valute = $('.al_val').text();
    var Valute = $('.default_valute').val();
    var Rout = MainInfo.find('.route_name_id').val();
    var From = MainInfo.find('.from_id').val();
    var To = MainInfo.find('.to_id').val();
    var RouteDate = '';
    $.ajax({
    type: "POST",
    url: "/tiket/ajax_sell_tikets_open",
    async: false,
    data: {route_name_id:Rout,from:From,to:To,plases:CountOpen,inputs:array_inputs_open,price:al_prise,valute:Valute,route_date:RouteDate,lang:$("#cur_lan").val(),sesuser:$('.sesuser').val(),discount:al_dis,rice:1},
    success: function(data) {
    var Tiks = data.split(',');
    for(var ss=0; ss<Tiks.length; ss++){
    tik_arrays_open.push(Tiks[ss]);
    }
    },
    error:function(){
    alert('ошибка save open прямой');
    }
    });
    }
    
    
    var CountOpen_return = 0;
    MainParent.find('.return_row_route .all_people .one_people').each(function(){
    CountOpen_return++;
    })
    
    if(CountOpen_return != 0){
    MainParent.find('.return_row_route .all_people .one_people').find('.pad_top').each(function(){
    $(this).remove(); 
    })
    var array_inputs_open_return = [];
    MainParent.find('.return_row_route .all_people .one_people').each(function(){
    var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
    array_inputs_open_return.push(onePeo);
    })
    
    var MainInfo_return = MainParent.find('.return_row_route .info_for_sell');

    }
  
    }else{

    var vedomost = 0;
    
    var Print = '';
    
    
    $('.one_row_routes').find('.first_people').find('.all_people').find('.pad_top').each(function(){
        $(this).remove(); 
    });
    var array_inputs = [];
    //var Ty = 1;
    $('.one_row_routes').find('.first_people').find('.all_people').find('.one_people').each(function(){
    var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()]
    //if(Ty != 1){
    array_inputs.push(onePeo);
    //}
    //Ty++;
    });

    if(array_inputs.length != 0){
        //alert('прямой');
        //exit;
        var Du = '';
        Du = 1;    
        var al_plase = [];
        $('.one_row_routes').find('.first_people').find('.one_scem').find('.selected_plase').each(function(){
            al_plase.push($(this).text());
        })
        
        
        var al_prise = [];
        $('.one_row_routes').find('.first_people').find('.all_people').find('.one_people').find('.dis_price').each(function(){
            al_prise.push($(this).text());
        })
        
        
        var al_dis = [];
        $('.one_row_routes').find('.first_people').find('.all_people').find('.one_people').find('.discount').each(function(){
        al_dis.push($(this).val());
        })
      //alert(al_dis);
       // exit;
        var Fer = $('.one_row_routes').find('.first_people').find('.ferryman').val();
        var Bus = $('.one_row_routes').find('.first_people').find('.buses').val();
        var Cur_price = al_prise;
        var All_summ = $('.al').text();
        var Valute = $('.default_valute').val();
        var Rout = $('.one_row_routes').find('.first_people').find('.route_name_id').val();
        var From = $('.one_row_routes').find('.first_people').find('.from_salon').val();
        var To = $('.one_row_routes').find('.first_people').find('.to_salon').val();
        var RouteDate = $('#datepicker_sell').val();
        var RouteDate_newDay = $('.date_from_schema').val();
        
        //alert(RouteDate_newDay);
        //exit;
        
        var RouteDate_end = '';
        
        ///*
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets",
            async: false,
            data: {route_name_id:Rout,from:From,to:To,plases:al_plase,inputs:array_inputs,price:Cur_price,valute:Valute,buses_id:Bus,ferryman_id:Fer,route_date:RouteDate,lang:$("#cur_lan").val(),du:Du,sesuser:$('.sesuser').val(),discount:al_dis,rice:1,vedomost:vedomost,route_date_newday:RouteDate_newDay,route_date_end:RouteDate_end},
            success: function(data) {
                //alert(data);
                //exit;
                var Tiks = data.split(',');
                for(var ss=0; ss<Tiks.length; ss++){
                    tik_arrays.push(Tiks[ss]);
                }
            },
            error:function(){
            alert('ошибка #sell_tik прямой');
            }
        });
        
        
       // exit;
        //*/
    }else{
        modal_info_open('<?=__('Select seat')?>');
    }
    
    
    $('.return_people').find('.pad_top').each(function(){
        $(this).remove(); 
    });
    
    var return_inputs = [];
    //var Tyy = 1;
    $('.return_people .one_people').each(function(){
        var onePeo = [$(this).find('.soname').val(),$(this).find('.name').val(),$(this).find('.date').val(),$(this).find('.tel').val(),$(this).find('.discount').val()];
        return_inputs.push(onePeo);
    });
    
    //alert(array_inputs);
    //exit;
    if(return_inputs.length != 0){
        //alert('ретурт');
        var return_plase = [];
        $('.return_people').find('.return_schema_new').find('.selected_plase').each(function(){
        return_plase.push($(this).text());
        })   
        
        var return_price = [];
        $('.return_people').find('.return_dis_price').each(function(){
        return_price.push($(this).text());
        })
        
        var return_dis = [];
        $('.return_people').find('.one_people .discount').each(function(){
        return_dis.push($(this).val());
        })
        
        var return_Fer = $('.return_people').find('.ferryman').val();
        
        var return_Bus = $('.return_people').find('.buses').val();
        var return_Cur_price = return_price;
        var return_All_summ = $('.al').text();
        var return_Valute = $('.default_valute').val();
        //var Valute = $('.al_val').text();
        
        var return_Rout = $('.return_people').find('.route_name_id').val();
        var return_From = $('.return_people').find('.from_salon').val();
        var return_To = $('.return_people').find('.to_salon').val();
        var return_RouteDate = $('#datepicker_sell_to').val();
        
        
        
        
        $.ajax({
            type: "POST",
            url: "/tiket/ajax_sell_tikets",
            async:false,
            data: {route_name_id:return_Rout,from:return_From,to:return_To,plases:return_plase,inputs:return_inputs,price:return_Cur_price,valute:return_Valute,buses_id:return_Bus,ferryman_id:return_Fer,route_date:return_RouteDate,lang:$("#cur_lan").val(),du:1,sesuser:$('.sesuser').val(),discount:return_dis,rice:1,vedomost:vedomost},
            success: function(data) {
                
                //alert(data);
                //exit;
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
    } // end ne open
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_new_print",
        async: false,
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val()},
        success: function(data) {
            Print += data;
        },
        error:function(){
            alert('ошибка ajax_sell_tikets_new_print');
        }
    });
    
    //alert(Print);
    //exit;
    
    /// обьекдинение билетов в заказ 
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_one_order",
        async: false,
        data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val(),valute:$('.default_valute').val(),full_price:$('.al').html()},
        success: function(data) {
            //alert(data);
            //exit;
            //location="/"+data;
        },
        error:function(){
            alert('ajax_sell_tikets_one_order');
        }
    });
    
    $('.print_ticket_block').html(Print);
    setTimeout(printDiv(),1000);
    location="/";
    
})


$("#order_tik").click(function(){
    
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
   
    var Tiks = data.split(',');
    for(var ss=0; ss<Tiks.length; ss++){
    tik_arrays.push(Tiks[ss]);
    }
    },
    error:function(){
    alert('ошибка #sell_tik прямой');
    }
    });
   
    }
    
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
    
    $.ajax({
    type: "POST",
    url: "/tiket/ajax_sell_tikets_new_print",
    async: false,
    data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val()},
    success: function(data) {

    Print += data;
    
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
   
    },
    error:function(){
    alert('ajax_sell_tikets_one_order');
    }
    });
    
    $('.print_ticket_block').html(Print);
    //printDiv();
    //location="/sysuser/search_route";
    //alert(return_inputs);
    //exit;
})

$('.on_return').change(function(){
    $(this).next('input').toggle();
    $('.ret_jou').toggle();
    if($('#datepicker_sell_to').val().length > 0){
    $('#datepicker_sell_to').val('');
    }
    $('.return_block').toggle();
    $('.return_from').val($('.to').val());
    $('.return_to').val($('.from').val());
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

function printDiv() {
    var printContents = document.getElementById('print_ticket_block').innerHTML;
    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    
    window.print();
    
    document.body.innerHTML = originalContents;
}

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
    $('.reserv_info').html('<?=__("Valute change!")?>');
    $('.reserv_info').show();
    
    },
    error:function(code, opt, err){
    alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
    }
    });
    }
    //setTimeout(location="/tiket/sell",5000);
})

</script>