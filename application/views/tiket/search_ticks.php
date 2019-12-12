<?  $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
$user_id = $sesuser[0]['id'];
}else{
$user_id = 0;
}
?>
<style>
    #ser_bl_tik{
        top:40px;
    }
    #ser_bl_tik ul {
        width: 254px;
    }
</style>

<div class="padding_center">

 <input type="hidden" class="sesuser" value="<?=$user_id;?>" />
    <input type="hidden" class="default_valute" value="<? if(isset($sesuser[0]['default_valute'])){ echo $sesuser[0]['default_valute'];}?>" />
    <div class="alert alert-info reserv_info" style="margin-top: 25px; margin-bottom: 0px; margin-left: 15px; margin-right: 15px; display: none;">
        <button class="close" onclick="$(this).parent().hide()" ></button>Info:&nbsp;<span></span>. 
    </div>

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Find tickets")?>
                    </div>
                  </div>
                  <div class="panel-body">
                         <input type="hidden" class="sesuser" value="<?=$user_id;?>" />
    <input type="hidden" class="default_valute" value="<? if(isset($sesuser[0]['default_valute'])){ echo $sesuser[0]['default_valute'];}?>" />
    
    
    <div class="alert alert-info reserv_info" style="margin-top: 25px; margin-bottom: 0px; margin-left: 15px; margin-right: 15px; display: none;">
        <button class="close" onclick="$(this).parent().hide()" ></button>Info:&nbsp;<span></span>. 
    </div>
            <div class="row">
            
            <div class="col-md-12">
            
                <div class="form-group">
                        <label class="form-label"><?=__("Ticket number")?></label>
                        <div class="controls">
                            <input type="text" class="filds-ost-desc form-control search_tik" placeholder=""  value="" />
                            <input type="hidden" class="filds-ost-desc form-control search_tik_hid" placeholder=""  value="" />
                      
                    
                      
                            <div class="ajax_search_block select2-results" id="ser_bl_tik select2-results-2 select2-drop-active"></div>
              
                      
                        </div>
                    </div>
            
            </div>
            
            </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>

<div class="container container-fixed-lg">
<div class="row">
<div class="col-md-12">
          
     
          
          
                    <div class="panel panel-default">
                      <div class="panel-heading separator">
                        <div class="panel-title"><?=__("Information about ticket")?>
                        </div>
                      </div>
                      <div class="panel-body m-t-20">
                     
                        
             
                        <div class="row">
                        <div class="col-md-4">
                        <div class="row">
                                              <div class="col-md-6">
                               <div class="form-group form-group-default disabled">
                        <label><?=__("Price")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_price ">
                      </div>
                      </div>
                      <div class="col-md-6">
                               
                               
                               
                               <div class="form-group form-group-default disabled"> 
                        <label><?=__("Sum of returning")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_price_null">
                      </div>
                      </div>
                      
                        
                        
                        <div class="col-md-12">
                        
                                       <div class="form-group form-group-default disabled">
                        <label><?=__("Status")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_status">
                      </div>
                        
                         
                        
                        <div class="form-group form-group-default disabled">
                        <label><?=__("Passenger")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_client">
                      </div>
                        
                        
                        
                  
                      
                      
                               <div class="form-group form-group-default disabled">
                        <label><?=__("Departure date")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_date">
                      </div>
                      
                      </div>
                      <div class="col-md-6">
                               <div class="form-group form-group-default disabled">
                        <label><?=__("From whence")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_from ">
                      </div>
                      </div>
                      <div class="col-md-6">
                               
                               
                               
                               <div class="form-group form-group-default disabled"> 
                        <label><?=__("Where")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_to">
                      </div>
                      </div>
                      
                      
                      <div class="col-md-12">
                      
                               <div class="form-group form-group-default disabled">
                        <label><?=__("Route number")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_route">
                      </div>
                      
                      
                               <div class="form-group form-group-default disabled">
                        <label><?=__("Carrier")?></label>
                        <input type="email" disabled=""  class="form-control search_tik_fer_name">
                      </div>
                        </div>
                        
                        
                        
                       <div class="col-xs-3" style="display: none;">
            <div class="form-group">
                <label class="form-label"><?=__('Route hid');?></label>
                <div class="controls">
                <input type="text" class="filds-ost-desc form-control search_tik_route_hid" disabled="disabled"  value="" />
                </div>
            </div>
        </div>
                        
          <input type="hidden" class="filds-ost-desc form-control search_tik_from_hid"  value="" />   
          
          <input type="hidden" class="filds-ost-desc form-control search_tik_to_hid"  value="" />
                        
                        
                        </div>
                        </div>
                       
                       
                           <div class="col-md-8">
        <div class="col-md-12">
            <div class="search_salon"></div>
        </div>
        <div class="col-md-6 transfer_block" style="display: none;">
            <div class="form-group col-md-12" style="position: relative;">
                <label><? echo __('Date');?></label>
                <input name="desc_i18n" type="text" class="datepicker_sell filds-ost-desc form-control route_date_modal"   value="" />
            </div>
            <div class="salon_modal"></div>                        
            <button class="tran_tik btm-edit btn btn-complete btn-salat"><?=__('Change the date of the departure')?></button>
            <div class="clearfix"></div>
        </div>
    
    
 
 
 
                         <div class="col-md-12 all_button" >
        <label>&nbsp;</label>
        <!-- for work insert class in button .cheng_open -->
       
       <div class="col-md-12"><button class="btm-edit btn btn-success btn-cons btn-large print_button" style="display: none;"><?=__('Print a ticket');?></button>
   </div>
       
        <div class="col-md-12 m-t-10">
        <button class="btm-edit btn btn-success btn-cons btn-large cheng_open" style="display: none;"><?=__('Open ticket');?></button>
        <button class="btm-edit btn btn-danger btn-cons btn-large tiket_null" style="display: none;"><?=__('Full ticket refund');?></button>
        <button class="btm-edit btn btn-danger btn-cons btn-large tiket_null_proc" style="display: none;"><?=__('Cancel Ticket');?></button>
   </div> 
   <div class="col-md-12 m-t-10">
        
        <button class="btm-edit btn btn-primary btn-cons btn-large transfer_tik" style="display: none;"><?=__('Move the ticket');?></button>
        <button class="btm-edit btn btn-success btn-cons btn-large sel_res_button" style="display: none;"><?=__('Sell the booked ticket');?></button>
        
   </div> 
   
    </div>
    
    
    
    <div class="row form-row" style="display: none;">
        <div class="col-md-12 print_ticket_block" id="print_ticket_block">
            <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="24" height="24" style="margin: auto; display: block;" />
        </div>
    </div>
                    
 
    
    
    </div>
    
                       
      <div class="col-md-12 history_block">
     
      </div>               
  
                     
                     
                        </div>
                        
                        </div>
                        
                        
                      </div>
                    </div>
             


           
          
            
            </div>
            </div>
          </div>





<script type="text/javascript">

function tickit_history(ID){
    //alert(ID);
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_ticket_history",
        data: {id:ID},
        async: false,
        success: function(data) {
            $('.history_block').html(data);
           
        },
        error:function(){
            alert('ошибка /tiket/ajax_get_ticket_history');
        }
    });   
} 

$('.tran_tik').click(function(){
    var Par = $(this).parents('.padding_center');
    var Tik = Par.find('.search_tik_hid').val();
    var Date = Par.find('.datepicker_sell').val();
    var NewPri = Par.find('.search_tik_price').val();
    var Plase = Par.find('.selected_plase').text();
    var Ferrryman = Par.find('.ferryman').val();
    var bus = Par.find('.buses').val();
    //alert(Ferrryman);
    //exit;
    if(Plase.length == 0){
        modal_info_open('<h1><?=__("Choose plase!")?></h1>');
        exit;
    }
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_transfer",
        data: {tik_id:Tik,date:Date,price:NewPri,plase:Plase,sesuser:$('.sesuser').val(),fer:Ferrryman,bus:bus},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            modal_info_open('<h3><?=__("Your ticket moved on date")?><span class="bold text-complete">'+Date+'</span></h3><p><?=__("Place in the bus")?> '+Plase+'</p>');
            modal_info_close('/tiket/sell');
        },
        error:function(){
            alert('ошибка /tiket/ajax_tiket_transfer');
        }
    });   
})



$('.datepicker_sell').datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.search_tik_route_hid').val();
        var SchemaHTml = '';
        var From = $('.search_tik_from_hid').val();
        var To = $('.search_tik_to_hid').val();
        
        
        //alert(From);
        //exit;
        
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_modal_transfer",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To},
            async: false,
            success: function(data) {
                SchemaHTml = data
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
        });
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:'<?=I18n::lang();?>',rice:1},
            async: false,
            success: function(data) {
                Top = data;
                //alert(Top);
            },
                error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
        });
        var newTop = Top.split(',');
        var INFO = $('<div class="info_top"><p>Bus - '+newTop[0]+'</p><p>Ferryman - '+newTop[3]+'</p></div>');
        //INFO.insertBefore('.search_salon');
        $('.search_salon').html(SchemaHTml);
        $('.cheng_open').removeClass('disabled');
    },
}); 



$('.search_tik').keyup(function(){
    var Vall = $(this).val();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_search_tik",
        data: {tik_id:Vall},
        async: false,
        success: function(data) {
            $('.ajax_search_block').html(data);
        },
        error:function(){
            alert('error ajax .search_tik');
        }
    });
})




$('.tiket_null').click(function(){
    
    $('.reserv_info').hide();
    
    var Parent = $(this).parents('.padding_center');
    var Tik_id = Parent.find('.search_tik_hid').val();
    var price = Parent.find('.search_tik_price').val();
    var Print = '';
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_null",
        data: {tiket_id:Tik_id,sesuser:$('.sesuser').val(),return_price:price},
        async: false,
        success: function(data) {
        //alert(data);
        //location="/tiket/search_tiks";
        $('.reserv_info').show();
        $('.reserv_info span').text('Ticket anulle!');
        
        },
        error:function(){
        alert('ошибка tiketAnul');
        }
    });
    /*
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_null_tiket_print",
        async: false,
        data: {tik:Tik_id,lang:$("#cur_lan").val()},
        success: function(data) {
        Print += data;
        },
        error:function(){
        alert('ошибка ajax_null_tiket_print');
        }
    });
    */
    $('#print_ticket_block').html(Print);       
    
    printDiv();
    
    location="/tiket/search_tiks";
    
    $('.padding_center input').each(function(){
    
    $(this).val('');
    })
})


$('.tiket_null_proc').click(function(){
    $('.reserv_info').hide();
    var Parent = $(this).parents('.padding_center');
    var Tik_id = Parent.find('.search_tik_hid').val();
    var price = Parent.find('.search_tik_price_null').val();
    //price = price.toFixed(2);
    
    //alert(Tik_id);
    //exit;
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_null",
        data: {tiket_id:Tik_id,sesuser:$('.sesuser').val(),return_price:price},
        async: false,
        success: function(data) {
    
        $('.reserv_info').show();
        $('.reserv_info span').text('Ticket anulle!');
        },
        error:function(){
        alert('ошибка tiketAnul');
        }
    });
    
    /*
    var Print = '';
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_null_tiket_print",
        async: false,
        data: {tik:Tik_id,lang:$("#cur_lan").val()},
        success: function(data) {
        Print += data;
        },
        error:function(){
        alert('ошибка ajax_null_tiket_print');
        }
    });
    */
    $('#print_ticket_block').html(Print);       
    printDiv();
    location="/tiket/search_tiks";
    $('.padding_center input').each(function(){
    $(this).val('');
    })
})            
  



$('.print_button').click(function(){


/*
modal_info_open('<h1>Hello !!!!</h1>');
modal_info_close('/tiket/search_tiks');
//location="/tiket/search_tiks";
//alert('ok');
exit;
*/


var tik_arrays = [];

tik_arrays.push($('.search_tik_hid').val());

var tik_arrays_open = [];

var Print = '';

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
alert('ошибка #sell_tik прямой');
}
});

$('.print_ticket_block').html(Print);
//printDiv();
setTimeout(printDiv(),1000);

//setTimeout()

//location="/tiket/search_tiks";
})



$('.transfer_tik').click(function(){
    $('.transfer_block').toggle();
    $('.tiket_null').toggle();
    $('.tiket_null_proc').toggle();
    $('.print_button').toggle();
    
    $(this).hide();
    
})

$('.route_date_modal').focus(function(){
getDateTran();
//exit;
})

function getDateTran(){
var RouteNameID = $('.search_tik_route_hid').val();
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

///*

//*/

$('.sel_res_button').click(function(){ // покупка после резервации
    $.ajax({
    type: "POST",
    url: "/tiket/ajax_sell_reserv",
    data: {id:$('.search_tik_hid').val(),sesuser:$('.sesuser').val()},
    async: false,
    success: function(data) {
    },
    error:function(code, opt, err){
    alert("sel_res_button");
    }
    });
    var Print = '';
    var tik_arrays = [];
    tik_arrays.push($('.search_tik_hid').val());
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
    location="/tiket/search_tiks";
    exit;
})



setInterval(Validation, 1000);

function Validation() {
    if($('.search_tik_status').val().length != 0){
    //alert('ok');
    $('.valid').each(function(){
    $(this).removeClass('noValid');
    if($(this).val().length < 3){
    $(this).addClass('noValid');
    }
    })
    }
}

$('.search_tik_date').focus(function(){
    getDateSearch();
}) 

function getDateSearch(){
    var RouteNameID = $('.search_tik_route_hid').val();
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
}   


$('.search_tik_date').datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {
        $('.info_top').remove();
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.search_tik_route_hid').val();
        var SchemaHTml = '';
        var From = $('.search_tik_from_hid').val();
        var To = $('.search_tik_to_hid').val()
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
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
        });
        //////////////////////////////////////
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:'<?=I18n::lang();?>',rice:1},
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
        //alert(newTop);
        var INFO = $('<div class="info_top"><p>Bus - '+newTop[0]+'</p><p>Time from - '+newTop[1]+'</p><p>Time to - '+newTop[2]+'</p></div>');
        //////////////////////////////////////
        
        INFO.insertBefore('.search_salon');
        
        $('.search_salon').html(SchemaHTml);
        $('.cheng_open').removeClass('disabled');
        
    },
}); 

$('.cheng_open').click(function(){

$('.reserv_info').hide();

var Parent = $(this).parents('.form-row');
var Tik_id = $('.search_tik_hid').val();
var Date = $('.search_tik_date').val();
var Plase = $('.selected_plase').text();
//alert(Plase);
//exit;
if(Plase.length == 0){
modal_info_open('<h1><?=__("Choose date")?></h1>');
exit;
}

$.ajax({
type: "POST",
url: "/tiket/ajax_chenge_open",
data: {tik_id:Tik_id,date:Date,plase:Plase,sesuser:$('.sesuser').val()},
async: false,
success: function(data) {
//alert(data);
///writeCall(data);
//SchemaHTml = data
//location="/tiket/search_tiks"

modal_info_open('<h1><?=__("I was Successful")?></h1><p><?=__("Date")?> '+Date+'</p><p><?=__("Seat")?> '+Plase+'</p>');
modal_info_close('/tiket/sell'); 

},
error:function(code, opt, err){
alert("Ошибка .cheng_open");
}
});

$('.padding_center input').each(function(){
$(this).val('');
})
})       


function printDiv() {
var printContents = document.getElementById('print_ticket_block').innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
}

function CallPrint(strid) {
var printContents = document.getElementById('print_ticket_block').innerHTML;
//var prtCSS = '<link rel="stylesheet" href="/templates/css/template.css" type="text/css" />';
var WinPrint = window.open('','','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
WinPrint.document.write('<div>');
//WinPrint.document.write(prtCSS);
WinPrint.document.write(printContents);
WinPrint.document.write('</div>');
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
//prtContent.innerHTML=strOldOne;
}
</script>