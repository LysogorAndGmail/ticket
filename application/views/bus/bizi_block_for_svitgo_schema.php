<div class="main_parr">

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

 $group_see_tik = DB::select()->from('groups')->where('id','=',$sesuser['group_id'])->execute()->current(); //print_r($group_see_tik);

//echo $ses_valute;
//die;

?>

<!-- start Return ticket-->       

    <? $tik = DB::select()->from('ticket')
    ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
    ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
    //->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
    ->where('ticket_id','=',$id)
    ->execute()->current();?>
 

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-8">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__('Information about ticket')?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            
                    <div class="" style="text-align: left;">
        </div>
        <?if($tik){?>
       
          <div class="row form-row">
            <div class="col-md-12">


          




<div class="col-md-5 no-padding tik_info">
    <? $status = '';
    $sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
    
    $create_rep = DB::select()->from('ticketreport')
                ->where('ticket_id','=',$tik['ticket_id'])
                ->order_by('report_id','DESC')
                ->execute()->current();
    
    switch($create_rep['status']){
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
    
    <? if($group_see_tik['tik_see_id'] == 1){?><p><?=__("Ticket number")?>:</p><?}?>
    <? if($group_see_tik['tik_see_client'] == 1){?><p><?=__("Passenger")?>:</p><?}?>
    <? if($group_see_tik['tik_see_phone'] == 1){?><? $phone = Model::factory('TiketMod')->showphone($tik['client_id'],$sesuser[0]['id']); if($phone == 1){?><p><?=__("Phone")?>:</p><?}}?>
    <? if($group_see_tik['tik_see_sysuser'] == 1){?><p><?=__("Agent")?>:</p><?}?>
    <? if($group_see_tik['tik_see_directions'] == 1){?><p><?=__("Route direction")?>:</p><?}?>
</div>
<div class="col-md-5 no-padding tik_info_chen">
  
    <? if($group_see_tik['tik_see_id'] == 1){?><p><?=$tik['maska'];?></p><?}?>
    <? if($group_see_tik['tik_see_client'] == 1){?><p><?=$tik['name'].' '.$tik['soname'];?></p><?}?>
    <? if($group_see_tik['tik_see_phone'] == 1){?><p><? $phone = Model::factory('TiketMod')->showphone($tik['client_id'],$sesuser[0]['id']); if($phone == 1){ echo $tik['tel'];}?></p><?}?>
    <? if($group_see_tik['tik_see_sysuser'] == 1){?><p><?=$sususer['login'];?></p><?}?>
    <? if($group_see_tik['tik_see_directions'] == 1){?><p><? $ost_from = Model::factory('OstMod')->get_ost($tik['route_city_from_id'],$lang); $ost_to = Model::factory('OstMod')->get_ost($tik['route_city_to_id'],$lang); echo $ost_from['city_i18n'].' '.$ost_from['name_i18n'].' '.$ost_to['city_i18n'].' '.$ost_to['name_i18n'];?></p><?}?>
</div>


<input type="hidden" name="tik_id" class="search_tik" value="<?=$tik['ticket_id'];?>" />

<div class="col-md-12 no-padding but_den">
    <button type="button" class="btn btn-danger btn-cons" onclick="tiketAnul('<?=$tik['ticket_id'];?>',$(this).parents('.main_parr').find('.nul_clear').text())"><?=__('Cancel Ticket')?></button>
    <!--<button type="button" class="btn btn-warning btn-cons" onclick="tiketAnul('<?=$tik['ticket_id'];?>','<?=$tik['route_price_discount'];?>',$(this).parents('.main_parr').find('.nul_clear').text())"><?=__('Cancel Ticket %')?></button>-->
</div>
<div class="row">
<div class="col-md-12 section grey m-t-20">
   

<div class="col-md-6 ">
<h5 class="bold">
<?
 

 if($group_see_tik['tik_see_price'] == 1){
if(!empty($tik['route_price_discount'])){
$rou_dat = strtotime($tik['route_date'].' '.$tik['route_time']);
$sel_dat = strtotime('now');
$proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$tik['ferryman_id']); ?>
</h5>


    <h4 class="pr_mod bold"><?=__('Price')?></h4>
    <h5 class="new_val"><?=$tik['route_price_discount'].' '.$tik['valute'];?> </h5>
</div>



<div class="col-md-6 ">
    <h4 class="pr_mod bold"><?=__('Total')?></h4>
  
  <h5 class="bold text-danger">
  
    <?if($tik['ticket_type_id'] == 2){
    echo '';
}else{
    
    $create_rep = DB::select()->from('ticketreport')
                ->where('ticket_id','=',$tik['ticket_id'])
                ->order_by('report_id','DESC')
                ->execute()->current();
    
    $time_sell = strtotime($create_rep['create_report']);
    $now = strtotime(date('Y-m-d H:i:s'));
    $pas = $now - $time_sell;
    $v_min = round($pas/60,0);
    //echo $v_min;
    if($v_min < 30){ ?>
        <span class="new_val_big"><?='-'.$tik['route_price_discount'].' '.$tik['valute'];?> </span>
        <span class="nul_clear"><?=$tik['route_price_discount']?></span>
    <? }else{
        $pro_price = $tik['route_price_discount']/100 * $proc;
        $tik['route_price_discount'] -= $pro_price; ?>
        <span class="new_val_big"><?='-'.$tik['route_price_discount'].' '.$tik['valute'];?> </span>
        <span class="nul_clear"><?=$tik['route_price_discount']?></span>
   <? } }?>
   
   </h5>
   
</div>
</div>
</div>
<?}}?>


                <div class="col-md-12 m-t-20">
                
                    <div class="row-fluid">
                
                    <input type="checkbox" class="radioo" />
                    <label><?=__('Change the date of the departure')?></label>
           
                    </div>
                  
                    
                </div>
                
                
                
                <? if($tik['ticket_type_id'] == 2){?>
                    <div class="col-md-12">
                    <div class="sell_reserv">
                        <input type="hidden" value="<?=$tik['ticket_id'];?>" />
                        <button class="btn btn-success sel_res_button"><?=__('Sell the booked ticket')?></button>
                    </div>
                    </div>
                    <?}?>
              <div class="col-md-8 transfer_block" style="display: none; min-height: 400px;">
                <div class="form-group col-md-12" style="position: relative;">
                    <label><? echo __('Date');?></label>
                    <div class="clone_block"></div>
                    <!--<input name="desc_i18n" type="text" class="datepicker_sell_modal filds-ost-desc form-control route_date_modal"   value="" />
                    <input name="desc_i18n" type="text" class="datepicker_sell filds-ost-desc form-control route_date_modal"   value="" />
                    <input name="desc_i18n" type="text" class="return_datepicker_sell_clone filds-ost-desc form-control return_route_date inp clone_test"   value="<?=__("Date Depart")?>" /> -->
                    
			        <input type='text' id='datepicker_sell2' value='' class="return_datepicker_sell_clone filds-ost-desc form-control route_date_bizi_block inp clone_test" name='tes1'>
                    
                    
                    
                    <input type="hidden" class="rou_name" value="<?=$tik['route_name_id']?>" />
                    <input type="hidden" class="from_sel_mod" value="<?=$tik['route_city_from_id']?>" />
                    <input type="hidden" class="to_sel_mod" value="<?=$tik['route_city_to_id']?>" />
                    <input type="hidden" class="tik_sel_mod" value="<?=$tik['ticket_id']?>" />
                </div>
                <div class="salon_modal"></div>
             <?php /*?>   <label><?=__('Price')?>:</label><?php */?>
                <input type="text" value="<?=$tik['price']?>" class="tik_pri_modal form-control" style="display: none;" />
                <button class="tran_tik btn btn-complete btn-cons btn-salat"><?=__('Change the ticket')?></button>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
     
        <?}?>
  
            
            
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>






   

<div class="row form-row" style="display: none;">
    <div class="col-md-12 print_ticket_block" id="print_ticket_block">
        <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="24" height="24" style="margin: auto; display: block;" />
    </div>
</div>

          <!-- end return ticket-->
<script type="text/javascript">

$('#datepicker_sell2').focus(function(){
    setTimeout(getDateModal,500);
})

function getDateModal(){
     //if($('#tes1').val().length == 8){
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
           
         //alert(Artex);  
           
         var arr = Artex.split(',');
        $('.date').each(function(){
            var Htmll = $(this);
            var Full = $(this).data('day_full');
            for(var st = 0; st<=arr.length; st++){
                if(arr[st] == Full){
                    Htmll.addClass('activ_day');
                }
            }
        })
    //}
    
    //$('.animation_ajax').hide();
}  




$('.return_datepicker_sell_clone').blur(function(){
    //alert();
    //exit;
    
    $('.salon_modal').html('');
    $('.info_bizi_salon').remove();
    
    //$('#boxCal').hide();
    
    
})




function Show_bizi_salon(){
    $('#ui-datepicker-div').hide();
        var RouteNameID = $('.rou_name').val();
        var SchemaHTml = '';
        var From = $('.from_sel_mod').val();
        var To = $('.to_sel_mod').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_modal_transfer",
            data: {route_name_id:RouteNameID,date:$('.return_datepicker_sell_clone').val(),from:From,to:To},
            async: false,
            success: function(data) {
                SchemaHTml = data
            },
            error:function(code, opt, err){
                alert("Состояние : ajax_see_schema_svitgo_modal_transfer");
            }
        });
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:$('.return_datepicker_sell_clone').val(),from:From,to:To,lang:'<?=I18n::lang();?>',rice:1},
            async: false,
            success: function(data) {
                Top = data;
            },
                error:function(code, opt, err){
                alert("Состояние : ajax_see_route_arive");
            }
        });
        var newTop = Top.split(',');
        var INFO = $('<div class="info_bizi_salon"><p>Bus - '+newTop[0]+'</p><p>Time from - '+newTop[1]+'</p><p>Time to - '+newTop[2]+'</p></div>');
        //INFO.insertBefore('.salon_modal');
        $('.salon_modal').html(SchemaHTml);
        $('.cheng_open').removeClass('disabled');
        
        $('.return_datepicker_sell_clone').click();
}




/*
function start_clone(){
    //$('.clone_test').show();
    var Clon = $('.clone_test').clone();
    Clon.insertAfter($('.clone_block'));
    alert('ok');
    
}


start_clone();
*/

$('.tran_tik').click(function(){
    var Par = $(this).parents('.transfer_block');
    var Tik = Par.find('.tik_sel_mod').val();
    var Date = Par.find('.return_datepicker_sell_clone').val();
    var NewPri = Par.find('.tik_pri_modal').val();
    var Plase = Par.find('.selected_plase').text();
    
    var Ferryman = Par.find('.ferryman').val();
    var Bus = Par.find('.buses').val();
    
    //alert('ok');
    //exit;
    
    if(Plase.length == 0){
        modal_info_open('<h3 class="text-center"><?=__("Select the date")?></h3>');
        exit;
    }
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_transfer",
        data: {tik_id:Tik,date:Date,price:NewPri,plase:Plase,sesuser:$('.sesuser').val(),fer:Ferryman,bus:Bus},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            modal_info_open('<h3><?=__("Your ticket moved on date")?> <span class="bold text-complete">'+Date+'</span></h3><p><?=__("Place in the bus")?> '+Plase+'</p>');
            modal_info_close('/tiket/sell');
        },
        error:function(){
            alert('ошибка tran_tik');
        }
    });  
})

$('.butt_call').click(function(){
    alert('sdfg');
    var SchemaHTml = '';
    $.ajax({
        type: "POST",
        url: "/errors/ajax_get_bizi_call",
        data: {id:1},
        async: false,
        success: function(data) {
            SchemaHTml = data
            $('.print_ticket_block').html(SchemaHTml);
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
})

$('.radioo').change(function(){
    $(this).parents('.form-row').find('.transfer_block').toggle();
    $(this).parents('.form-row').find('.returnet_block').toggle();
})

//$('.route_date_modal').focus(function(){
//    getDateModal();
    //exit;
//})





function tiketAnul(Tik,price){    
    
    //alert(price);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_null",
        data: {tiket_id:Tik,sesuser:$('.sesuser').val(),return_price:price},
        success: function(data) {
            //modal_info_open('<h1><?=__("Ticket Anulle %")?></h1>');
            //modal_info_close('/tiket/sell');
        },
        error:function(){
            alert('ошибка tiketAnul');
        }
    });
    
    var Print = '';
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_null_tiket_print",
        async: false,
        data: {tik:Tik,lang:$("#cur_lan").val()},
        success: function(data) {
            Print += data;
        },
        error:function(){
            alert('ошибка ajax_null_tiket_print');
        }
    });
    
    $('#print_ticket_block').html(Print);       
    
    printDiv();
    
    location="/tiket/sell";
    
}

function tiketAnul_proc(Tik,price,proc_price){
    //var price = proc_price;
        //price = Math.round(price); 
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_null",
        data: {tiket_id:Tik,sesuser:$('.sesuser').val(),return_price:proc_price},
        success: function(data) {
            modal_info_open('<h1><?=__("Ticket Anulle %")?></h1>');
            modal_info_close('/tiket/sell');
        },
        error:function(){
            alert('ошибка Ticket Anulle %');
        }
    });
}



$('.sel_res_button').click(function(){ // покупка после резервации
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_reserv",
        data: {id:$('.search_tik').val(),sesuser:$('.sesuser').val()},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
        },
        error:function(code, opt, err){
            alert("sel_res_button");
        }
    });
    var Print = '';
    var tik_arrays = [];
    tik_arrays.push($('.search_tik').val());
    var tik_arrays_open = [];
    $.ajax({
    type: "POST",
    url: "/tiket/ajax_sell_tikets_new_print_reserv",
    async: false,
    data: {tik_arrays:tik_arrays,tik_arrays_open:tik_arrays_open,lang:$("#cur_lan").val()},
    success: function(data) {
    Print += data;
    },
    error:function(){
    alert('ошибка #sell_tik прямой');
    }
    });
    $('.print_ticket_block').html(Print);
    $('.print_ticket_block').html(Print);
    printDiv();
    location="/tiket/sell";
    exit;
})




function printDiv() {
var printContents = document.getElementById('print_ticket_block').innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
}


$(document).ready(function(){
    $("#time_end").datepicker({
        <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
        minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        //showOtherMonths: true,
        selectOtherMonths: true
    });
/////////////
})

$("#datepicker_sell2").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
      onSelect: function (dateText, inst) {
        Show_bizi_salon();
    }, // end selected date
})

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
$('.route_date_bizi_block').focus(function(){
    getDate();
})
</script>   
</div>              