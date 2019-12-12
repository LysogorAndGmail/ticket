<? $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}
?>
<style>
.ajax_search_block .on_tik,.ajax_search_client .one_cl {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color:none;
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
    position: relative !important;
    top:0;
    background-color: #e5e5e5;
    
}
.ajax_search_client {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: none;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.ajax_search_client li{
    margin: 0;
    padding: 0;
}

.ajax_search_client ul{
        padding: 0;
    margin-top: -4px;
    margin-left: -6px;
    width: 509px;
    max-height: 300px;
    overflow: auto;
    box-shadow: 0 2px 4px grey;
}

.ajax_search_block .on_tik:hover,.ajax_search_client .one_cl:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}
.ajax_search_block ul {
    padding: 0;
    margin-top: -30px;
    width: 509px;
    max-height: 300px;
    overflow: auto;
    box-shadow: 0 2px 4px grey;
}
#ui-datepicker-div {
    position: absolute;
    top: 302px;
    left: 291.5px;
    z-index: 1;
}
</style>

<div class="content">  
	<div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class=""><h2 class=" inline"><?=__("Search Order")?></h2></div>
            <div class=""><h4 class=" inline"><?=__("You can easy find and manage all orders")?></h4></div>
        </div>
    </div>
</div>


<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="default_valute" value="<? if(isset($sesuser[0]['default_valute'])){ echo $sesuser[0]['default_valute'];}?>" />
    <div class="alert alert-info reserv_info" style="margin-top: 25px; margin-bottom: 0px; margin-left: 15px; margin-right: 15px; display: none;">
        <button class="close" onclick="$(this).parent().hide()" ></button>Info:&nbsp;<span></span>. 
    </div>


       <div class="col-md-12">
                                            <form>
                                                <div class="form-group col-md-2" style="position: relative;">
                                                    <label><?=__("Date from")?></label>
                                                    <input name="date" id="datepicker_sell" type="text" class="filds-ost-desc form-control" placeholder="<?=__("Date from")?>"  value="<?if(isset($_GET['date'])){ echo $_GET['date']; }?>" />
                                                </div>
                                                   <div class="form-group col-md-2" style="position: relative;">
                                                    <label><?=__("Date to")?></label>
                                                    <input name="date_to" id="datepicker_sell_to" type="text" class="filds-ost-desc form-control" placeholder="<?=__("Date to")?>"  value="<?if(isset($_GET['date_to'])){ echo $_GET['date_to']; }?>" />
                                                </div>
                                                
                                                <div class="col-md-2 form-group">
                                                    <label>&nbsp;</label>
                                                    <button class="btm-edit btn btn-success"><i class="icon-ok"></i> <?=__("Search")?></button>
                                                </div>
                                                   </form>
</div>

<div class="form-group col-md-12">
                                            <div class="col-md-12">
                                                <label><?=__("Order ID")?></label>
                                                <input type="text" class="filds-ost-desc form-control search_order" placeholder=""  value="" />
                                                <div class="ajax_search_block"></div>
                                                <br />
                                                <span style="clear: both;">&nbsp;</span>
                                                <!--<button class="ret_order btn btn-danger btn-cons"  style="display:none; float: left;"><?=__("Retrieve order");?></button>-->
                                                <button class="sell_order btn btn-warning btn-cons" style="display:none; float: left;"><?=__("Sale");?></button>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <form action="" method="POST">
                                                <div class="col-md-6">
                                                    <label><?=__("Client")?></label>
                                                    <input type="text" name="name" class="filds-ost-desc form-control search_client" placeholder=""  value="<?=$client;?>" />
                                                    <input type="hidden" name="client_id" class="filds-ost-desc form-control search_client_id" placeholder=""  value="" />
                                                    <div class="ajax_search_client"></div>
                                                    <br />
                                                    <span style="clear: both;">&nbsp;</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>&nbsp;</label>
                                                    <button class="ret_order btn btn-danger btn-cons"  style=""><?=__("Search");?></button>
                                                </div>
                                            </form>
                                        </div>

<div id="inbox-wrapper" class="row">
			<div class="col-md-12 pad_con">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
							<div style="min-height: 850px;" class="grid-body no-border">
							<br>
							 <div class="row-fluid">
							 <div class="row-fluid dataTables_wrapper">
								<h2 class=" inline"><?if($client){ echo $client;}else{ echo __('Daily sales');}?></h2>
								
								
									<div class="clearfix"></div>
								</div>
								
															
								<table class="table table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th><?=__("№")?></th>
                                                    <th><?=__("Tickets")?></th>
                                                    <th><?=__("Status")?></th>
                                                    <th><?=__("Date")?></th>
                                                    <th><?=__("Valuta")?></th>
                                                    <th><?=__("Language")?></th>
                                                    <th><?=__("Pin")?></th>
                                                    <th><?=__("Price")?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $all_count = 0;            
                                                 
                                                 foreach($orders as $o){ 
                                                    $status = '';
                                                    switch($o['status']){
                                                        case 1:
                                                        $status = __("Sold");
                                                        break;
                                                        case 0:
                                                        $status = __("Reserved");
                                                        break;
                                                        case 2:
                                                        $status = __("Returned");
                                                        break;
                                                    }
                                                    ?>
                                                    
                                                    
                                                    <tr>
                                                        <td class="id"><?=$o['id'];?></td>
                                                        <td class="id"><? $all_tiks = explode(',',$o['tikets']); array_pop($all_tiks); foreach($all_tiks as $tiks_one){ $maska = DB::select()->from('ticket')->where('ticket_id','=',$tiks_one)->execute()->current(); echo $maska['maska'].','; }?></td>
                                                        <td class="id"><?=$status;?></td>
                                                        <td class="id"><?=$o['date'];?></td>
                                                        <td class="id"><?=$o['valute'];?></td>
                                                        <td class="id"><?=$o['lang'];?></td>
                                                        <td class="id"><?=$o['pincod'];?></td>
                                                        <td class="id"><?=$o['full_price'];?></td>
                                                    </tr>
                                                     <?}?>
                                                     
                                            </tbody>
                                        </table>
							 
							 </div>							
							</div>
							</div>	
						</div>
					</div>
				</div>	
		</div>

<div class="row form-row" style="display: none;" >
                                    <div class="col-md-12 print_ticket_block" id="print_ticket_block">
                                        <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="24" height="24" style="margin: auto; display: block;" />
                                    </div>
                                </div>
<script type="text/javascript">
///*
$("#datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 1,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});
//*/
$("#datepicker_sell_to").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    //minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 1,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});



$('.sell_order').click(function(){
    var Order = $(this).parent().find('.search_order').val();
    var Print = '';
    
    var tik_arrays = [];
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_order",
        data: {order_id:Order},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            //$('.ajax_search_block').html(data);
            var Tiks = data.split(',');
            for(var ss=0; ss<Tiks.length; ss++){
                tik_arrays.push(Tiks[ss]);
            }
            
            
        },
        error:function(){
            alert('error ajax .search_tik');
        }
        
   });

    $.ajax({
        type: "POST",
        url: "/tiket/ajax_sell_tikets_new_print",
        async: false,
        data: {tik_arrays:tik_arrays,lang:$("#cur_lan").val()},
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
    
    //alert(Order);
    $('.reserv_info').text('<?=__("Ticket selled!");?>');
    $('.reserv_info').show();
    $('.ajax_search_block').html('');
    $(this).parent().find('.search_order').val('');
    
    $('.ret_order').hide();
    $('.sell_order').hide();
    
    location="/tiket/search_orders";
})



$('.ret_order').click(function(){
    var Order = $(this).parent().find('.search_order').val();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_return_order",
        data: {order_id:Order},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            //$('.ajax_search_block').html(data);
        },
        error:function(){
            alert('error ajax .search_tik');
        }
        
   });
    //alert(Order);
    $('.reserv_info').text('<?=__("Ticket returned!");?>');
    $('.reserv_info').show();
    $('.ajax_search_block').html('');
    $(this).parent().find('.search_order').val('');
    
    $('.ret_order').hide();
})


$('.on_tik').click(function(){
    alert('fgh');
})


$('.search_order').keyup(function(){
    var Vall = $(this).val();
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_search_order",
        data: {order_id:Vall},
        async: false,
        success: function(data) {
            $('.ajax_search_block').html(data);
        },
        error:function(){
            alert('error /tiket/ajax_search_order');
        }
        
   });
   
})

$('.search_client').keyup(function(){
    var Vall = $(this).val();
    $.ajax({
        type: "POST",
        url: "/sysuser/ajax_search_client",
        data: {client:Vall,name:$('.search_client').val()},
        async: false,
        success: function(data) {
            $('.ajax_search_client').html(data);
        },
        error:function(){
            alert('error /sysuser/ajax_search_client');
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