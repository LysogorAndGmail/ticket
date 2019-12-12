<script type="text/javascript" src="<?=Kohana::$base_url?>js/shortcut.js"></script>
<script type="text/javascript">
shortcut.add("alt+s", function() {
        alert("alt+s");
    });
</script>

<? $sesuser =  Session::instance()->get('ses_user'); ?>

<!--Page start-->



    
    <div class="container container-fixed-lg">
   
    
            <!-- START PANEL -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="panel-title"><?=__("Сash desk")?>
                </div>
                
              </div>
              <div class="panel-body p-t-10" style="background-color:#f1f2f6">
                <div class="row">
                  <form method="GET" >
                  
                                  <div class="col-md-3">
             <div class="form-group">
 <label><?=__("Agents")?></label>
                        <select name="user_id" class="form-control">
                            <option value=""><?=__("All")?></option>
                            <? foreach($sysusers as $all){?>
                            <option value="<?=$all['id'];?>" <?if(isset($_GET['user_id']) && $_GET['user_id'] == $all['id']){ echo 'selected="selected"'; }?> ><?=$all['login'];?></option>
                            <?}?>
                        </select>                  </div>
                  </div>
                  
                               <div class="col-md-2">
             <div class="form-group">
     <label><?=__("Way of payment")?></label>
                        <select name="payment" class="form-control">
                            <option value=""><?=__("All")?></option>
                            <option value=""><?=__("Terminal")?></option>
                            <option value=""><?=__("Cash")?></option>
                        </select>                </div>
                  </div>
                  
                  
                               <div class="col-md-3">
             <div class="form-group">
   <label><?=__("Route")?></label>
                        <select name="route_name_id" class="form-control">
                            <option value=""><?=__("All")?></option>
                            <?foreach($routes as $r){?>
                            <option value="<?=$r['name'];?>" <?if(isset($_GET['route_name_id']) && $_GET['route_name_id'] == $r['name']){ echo 'selected="selected"'; }?>><?=$r['name'];?></option>
                            <?}?>
                        </select>                </div>
                  </div>
                  
                            <div class="col-md-2">
                  <div class="form-group">
                   <label><?=__("From")?></label>
                            <input type="text" name="create_report" id="in_1" class="form-control" value="<?if(isset($_GET['create_report'])){ echo $_GET['create_report']; }?>"  placeholder="<?=__("Date of creating")?>"/> 
                  </div>
                  </div>
                  
                  
                  <div class="col-md-2">
                  <div class="form-group">
                  <label><?=__("To")?></label>
                            <input type="text" name="create_report_to" id="in_2" class="form-control" value="<?if(isset($_GET['create_report_to'])){ echo $_GET['create_report_to']; }?>" placeholder="<?=__("Date of creating")?>"/>
                  </div>
                  </div>
                  
                  <div class="clearfix"></div>
       
                  
                  
                                <div class="col-md-3">
             <div class="form-group">
     <label><?=__("Carrier")?></label>
                            <select name="ferryman_id" class="form-control">
                                <option value=""><?=__("All")?></option>
                                <? foreach($ferrymans as $f){?>
                                <option value="<?=$f['ferryman_id'];?>" <?if(isset($_GET['ferryman_id']) && $_GET['ferryman_id'] == $f['ferryman_id']){ echo 'selected="selected"'; }?>><?=$f['name'];?></option>
                                <?}?>
                            </select>                  </div>
                  </div>
                  
                  
                          <div class="col-md-2">
                       <div class="form-group">
                              <label><?=__("Status")?></label>
                        <select name="status" class="form-control">
                            <option value=""><?=__("All")?></option>
                            <option value="1" <?if(isset($_GET['status']) && $_GET['status'] == 1){ echo 'selected="selected"'; }?>><?=__("Sold")?></option>
                            <option value="2" <?if(isset($_GET['status']) && $_GET['status'] == 2){ echo 'selected="selected"'; }?>><?=__("Booking")?></option>
                            <option value="3" <?if(isset($_GET['status']) && $_GET['status'] == 3){ echo 'selected="selected"'; }?>><?=__("Returned")?></option>
                            <option value="4" <?if(isset($_GET['status']) && $_GET['status'] == 4){ echo 'selected="selected"'; }?>><?=__("Moved")?></option>
                            <option value="5" <?if(isset($_GET['status']) && $_GET['status'] == 5){ echo 'selected="selected"'; }?>><?=__("Open")?></option>
                        </select>
                           </div>
                  </div>
                  
                  
                  
                  <div class="col-md-3">
                  <div class="form-group">
                        <label><?=__("Ticket number")?> </label>
               
                          <input type="text" name="ticket_id" class="form-control" value="<?if(isset($_GET['ticket_id'])){ echo $_GET['ticket_id']; }?>" />
                      </div>
                  
                  </div>
                  
          
                  
                    
                  
                  
        
                  
          
                  
                 
                   
                
                  
                  
                  
                  
                 
                  
                              <div class="col-md-2">
                  <div class="form-group">
                  <label><?=__("From")?></label>
                            <input type="text" name="route_date" id="in_3" class="form-control" value="<?if(isset($_GET['route_date'])){ echo $_GET['route_date']; }?>" placeholder="<?=__("Date of departure")?>"/>
                            </div>
                  </div>
                  
                  
                  <div class="col-md-2">
             <div class="form-group">
                  <label><?=__("To")?></label>
                            <input type="text" name="route_date_to" id="in_4" class="form-control" value="<?if(isset($_GET['route_date_to'])){ echo $_GET['route_date_to']; }?>"  placeholder="<?=__("Date of departure")?>" />
                  </div>
                  </div>
                  
                  
                  <div class="col-md-12">    <button type="submit" class="btn btn-success btn-cons "><i class="icon-ok"></i> <?=__("Search")?></button></div>
                  
                  
                  </form>
                </div>
              </div>
            </div>
            <!-- END PANEL -->
          </div>
    
    
    
    
    
    
      <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg ">
            <!-- START PANEL -->
            <div class="panel panel-default">
              <div class="panel-heading">
     
         
                <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
                          <button class="btn btn-default" type="button" title=" <?=__("Export to Exel")?>"><i class="fa fa-file-excel-o"></i>
                          </button>
                          <button class="btn btn-default" type="button" title=" <?=__("Export to PDF")?>"><i class="fa fa-file-pdf-o"></i>
                          </button>
                
                        </div></div>
              
              
              
                   
              
              
              
                
      
                <div class="clearfix"></div>
              </div>
              <div class="panel-body" >
  
              
                <table class="table table-striped table-hover" id="tableWithExportOptions">
                  <thead>
                      <tr>
                        <th ><?=__("№")?></th>
                        <th ><?=__("Order")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Date of creating")?></th>
                        <th><?=__("Users")?></th>
                        <th><?=__("Route")?></th>
                        <th ><?=__("Carrier")?></th>
                        <th><?=__("Route date")?></th>
                        <th><?=__("Cities")?></th>
                        <th><?=__("Client")?></th>
                        <th><?=__("Discount")?></th>
                        <th><?=__("Price")?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <? $all_count = 0;            
                     $al_val_price = array();
                     foreach($tikets as $t){
                        $city_from = Model::factory('OstMod')->get_ost($t['route_city_from_id'],$lang);
                        $city_to = Model::factory('OstMod')->get_ost($t['route_city_to_id'],$lang);
                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$t['ferryman_id'])->execute()->current();
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['sys_user'])->execute()->current();
                        if($t['user_id'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['user_id'] == '198'){
                            $sususer['login'] = 'inet';
                        }
                        switch($t['status']){
                            case'1':
                            $status = ''.__("Sold");
                            break;
                            case'2':
                            $status = ''.__("Booking");
                            break;
                            case'3':
                            $status = ''.__("Returned");
                            break;
                            case'4': 
                            $status = ''.__("Moved");
                            break;
                            case'5':
                            $status = ''.__("Open");;
                            break;
                        }
                        
                        //if (array_key_exists($t['valute'], $al_val_price)) {
                            /*
                            if($status == 'sell' || $status == 'reserv' || $status == 'open'){
                                $all_count = $al_val_price[$t['valute']];
                                //echo $cou_val;
                                $al_val_price[$t['valute']] = $all_count+$t['price'];
                            }
                            if($status == 'return'){
                                $all_count = $al_val_price[$t['valute']];
                                //echo $cou_val;
                                $al_val_price[$t['valute']] = $all_count-$t['price'];
                            }
                            */
                        //}
                        ///*
                        //else{
                            if($t['status'] == 1 || $t['status'] == 5){
                                //$all_count = $t['price'];
                                if($t['status'] == 1){
                                    $chek_open_prev = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',5)->execute()->current();
                                    if(empty($chek_open_prev)){
                                        $al_val_price[] = array('valute'=>$t['valute'],"+",$t['route_price_discount']);
                                    }else{
                                        $t['route_price_discount'] = '';
                                        $t['valute'] = '';
                                    }
                                }else{
                                    $al_val_price[] = array('valute'=>$t['valute'],"+",$t['route_price_discount']);
                                }
                                
                                
                            }
                            if($t['status'] == 3){
                                //echo $cou_val;
                                $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                if(!empty($chek_sell)){
                                    if($t['route_price_discount'] != $t['return_price']){
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['return_price']);
                                    }else{
                                        $al_val_price[] = array('valute'=>$t['valute'],"-",$t['route_price_discount']);
                                    }
                                    
                                }    
                            }
                        
                        //}
                        //*/
                        //echo '<pre>';
                        //print_r($all_count);
                        //echo '</pre>';
                        //die;
                         
                        ?>
                    <tr class="<?=$status;?>">
                            <td class="id" data-ticket_id="<?=$t['ticket_id'];?>" width="5%"><?=$t['maska'];?></td>
                            <? $orderr = Model::factory('TiketMod')->get_order($t['ticket_id']);?>
                            <td class="order_id" width="5%"><?=$orderr;?></td>
                            <td class="color_<?=$t['status'];?>"><?=$status;?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($t['create_report']));?></td>
                            <td><?=$sususer['login'];?></td>
                            <td><span title="<?=$t['route_name_id'];?>"><? $rou_name = Model::factory('RouteMod')->get_route_route_id($t['route_name_id'],$lang,1); if(isset($rou_name[0]['name'])){ echo $rou_name[0]['name'];}?></span></td>
                            <td><?=$fermann_id['name'];?></td>
                            <td><? if(!empty($t['route_date'])){ echo date("d.m.Y",strtotime($t['route_date']));}?></td>
                            <td width="15%"><?=$city_from['city_i18n']." - ".$city_to['city_i18n'];?></td>
                            <td><?=$t['name'].' '.$t['soname'];?></td>
                            <td  width="3%"class="color_<?=$t['status'];?>"><font class="color_<?=$t['status'];?>"><? $discont = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$t['discount_id'])->and_where('culture','=',$lang)->execute()->current(); echo $discont['name_simple_i18n'];?></font></td> 
                            <td width="5%"><? if($t['status'] == 3){ 
                                //$rou_dat = strtotime($t['route_date'].' '.$t['route_time']);
                                //$sel_dat = strtotime($t['create_report']);
                                //$proc = Model::factory('TiketMod')->get_fer_proc($rou_dat,$sel_dat,$t['ferryman_id']);
                                //echo $proc;
                                //$pro_price = $t['price']/100 * $proc;
                                    $chek_sell = DB::select()->from('ticketreport')->where('ticket_id','=',$t['ticket_id'])->and_where('status','=',1)->execute()->current();
                                    if(!empty($chek_sell)){
                                        if($t['route_price_discount'] != $t['return_price']){
                                            $t['route_price_discount'] = $t['return_price']; 
                                            echo "-";
                                        }else{
                                            $t['route_price_discount'] = $t['route_price_discount']; 
                                            echo "-";
                                        }
                                        
                                    }else{
                                        $t['price'] = '';
                                        $t['valute'] = '';
                                    }
                                }
                                if($t['status'] == 4 || $t['status'] == 2){
                                    $t['route_price_discount'] = '';
                                    $t['valute'] = '';
                                }
                                 echo $t['route_price_discount'].' '.$t['valute'];?></td>
                        </tr>
                         <?}?>
          
                  </tbody>
                </table>
              
              
     
</div>
              
              </div>
            </div>
             <? $order_array = array(); if(!empty($al_val_price)){ $order_array = Model::factory('TiketMod')->order_array($al_val_price,'valute');} $sort_valute = array(); foreach($al_val_price as $vals){ $sort_valute[$vals['valute']][] = $vals; } //echo '<pre>'; print_r($sort_valute); echo '</pre>'; die;?>
            
            <div class="container">
                     <div class="col-md-6">
                     
                     <h2 class="semi-bold"><?=__('Commission');?></h2>
                     
                      <? if(isset($sesuser[0]['login'])){?>
       <div class="name-seller-cash"><h3 class="bold"><?=$sesuser[0]['login'];?>&nbsp;&nbsp;<font color="#000000"><?=$sesuser[0]['procent'];?> %:</font></h3></div>
      
       <div class="all_cou"><h3 class="semi-bold">
	   <?  $i=1; foreach($sort_valute as $valll=>$prii){ 
                        $new_price = 0;
                        foreach($prii as $p){
                            $pos = strripos($p[0], "-");
                             if ($pos === false) {
                                $new_price += $p[1]; 
                             }else {
                              $new_price -= $p[1]; 
                              }
                        }
                        $proc_price = $new_price/100 * $sesuser[0]['procent'];
                        //$al_pri_sum = $new_price - $proc_price;
                        echo $proc_price ." ". $valll."<br />";
                    }  ?></span>
                    
                    </h3>
                    </div>
       
       <?}?></div>
        <div class="col-md-6" style=" text-align:right">
        <div class="money-seller-cash"><h2><?=__('Total sum');?>:</h2> </div>
         <div class="all_cou"><h3 class="bold"><?  $i=1; foreach($sort_valute as $valll=>$prii){ 
                        $new_price = 0;
                        foreach($prii as $p){
                            $pos = strripos($p[0], "-");
                             if ($pos === false) {
                                $new_price += $p[1]; 
                             }else {
                              $new_price -= $p[1]; 
                              }
                        }
                        echo $new_price ." ". $valll."<br />";
                    }  ?></span></h3></div>
          
       
       </div>       
            <!-- END PANEL -->
       
       </div>
       
       
       
          </div>
          <!-- END CONTAINER FLUID -->
    
    
    
    
    


<!--Page end-->




<script type="text/javascript">
$('.cre_csv').click(function(){
    var Arr = [];
    $('.csv tbody tr').each(function(){
        Arr.push($(this).html());
    })
    
    //var Arrr = [];
    //$('#print_ved_block .name-seller-cash').each(function(){
    //    Arrr.push($(this).text());
    //})
    //alert(Arr);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_create_csv_kassa",
        async: false,
        data: {html:Arr},
        success: function(data) {
            //alert(data);
            location="/vedomost/csv_file.csv";
            //$('#print_duv').html(data);
        },
        error:function(){
            alert('ошибка cre_csv');
        }
    });
})

$('#pri_ved_but').click(function(){
    var Arr = [];
    $('.id').each(function(){
        Arr.push($(this).data('ticket_id'));
    })
    //alert(Arr);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_print_ticket_kassa",
        data: {array:Arr,lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            //HTmm = data;
            //$(HTmm).insertAfter('.return_peo_after');
            $('#print_duv').html(data);
        },
        error:function(code, opt, err){
            alert("pri_ved_but");
        }
    });
    
    //$('#print_duv .row').hide();
    printDiv();
    location.reload();
    
})
function printDiv() {
     var printContents = document.getElementById('print_duv').innerHTML;
     //printContents += '<div style="padding-top:30px;">'+document.getElementById('inbox-wrapper_').innerHTML+'</div>';
     
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}

$(document).ready(function(){
    $("#in_1,#in_2,#in_3,#in_4").datepicker({
        <?// Model::factory('TiketMod')->dataciper(I18n::lang());?>
        //minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        showOtherMonths: true,
        selectOtherMonths: true
    });
})
</script>