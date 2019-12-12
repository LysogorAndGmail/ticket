<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>


<!--<button class="btn btn-lg" data-toggle="modal" data-target="#myModal">modal</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <br>
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-8">
              <input type="text" class="form-control" placeholder="Your Card Number">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>-->


<?
                
    
 $sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
}else{
    $user_id = 0;
}
        
    
    $id = $info['buses_id'];
    $lang = 'ru';
    //$price = 50;
    $ses_valute = 'EUR';
    
    $from = $info['from'];
    $to = $info['to'];
    
    $ferryman_id = $info['ferryman_id'];
    $route_id = $info['route_name_id'];
    $fro = $from;
    $to = $to;
    
    $date = array_reverse(explode('/', $info['route_date']));
    $date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
    $route_date = $date;
    //echo $route_date;
    
    $all_discount = Model::factory('DiscountMod')->get_all_discount($lang);
    //print_r($all_discount);
    //die;
    
    $price_ch = DB::select()->from('routeprice')->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')
        ->where('route_city_from_id','=',$from)
        ->and_where('route_city_to_id','=',$to)
        ->and_where('route_name_id','=',$route_id)
        ->execute()->current();
        
    $valute = $price_ch['value'];    
    $price = $price_ch['price'];
    
     
     //echo $price;
    // echo '<pre>';
    //    print_r($price);
    //    echo '</pre>';
    //die;

            $bus_name = DB::select()->from('buses_i18n')->where('buses_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
            $bus = DB::select()->from('buses')->where('buses_id','=',$id)->execute()->current();
            $all_schema = DB::select()->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
            //
            //echo '<pre>';
            //print_r($all_schema);
            //echo '</pre>';
            //echo $from;
            //echo $to;
            if(empty($all_schema)){
                echo 'нет схемы на - '.$id;
            }
            
            $schema_arr = array();
            foreach($all_schema as $all){
                $schema_arr[$all['schema_name']][$all['dx']][$all['dy']] = $all;
            }
            
             $all_schema_plases = array();
            foreach($all_schema as $al_sh){
                if(is_numeric($al_sh['value'])){
                    $all_schema_plases[] = $al_sh['value'];
                }
                
            }
            
            
            //sell
            $sell_array = Model::factory('TiketMod')->sell_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            
            
            // end sell
            //reserv
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            
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
                
                array_push($new_block_plase,array('value'=>$sys_biz));
            }
            
            
            
            $old_disp_bizi = Model::factory('TiketMod')->old_disp($route_id,$fro,$to,$route_date); 
            
            foreach($old_disp_bizi as $old_biz){
                
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            
            $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($route_id,$fro,$to,$route_date);
            
            
            if(!empty($all_blocked_plase)){
                $all_bizi_nikolo = array_diff($all_schema_plases,$all_blocked_plase);
            }else{
                $all_bizi_nikolo = array();
            }
            
            
            
            
            
            
            
?> 
<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="ferryman" value="<?=$ferryman_id;?>" />
<input type="hidden" class="buses" value="<?=$id;?>" />
<div class="border-bus left ner_1">    
    <? foreach($schema_arr as $name=>$aa){ ?>
    <div class="one_scem ">
        <h4><?=$bus_name['name_i18n'];?></h4>
        <? foreach($aa as $x=>$ax){?>
        <div class="one_row">
            <? foreach($ax as $y=>$ay){ ?>
                <div class="bus_cres new_cre_1">
                <?php if($ay['value']=='sw' || $ay['value']=='st' || $ay['value']=='pr' || $ay['value'] == ''){?>
                    <div  class="bscheme-none"><?php echo $ay['value'];?></div>
                    <?php } else {?>
                    <div <? foreach($sell as $bil){ if($ay['value']  == $bil){ ?> data-toggle="modal" data-target="#myModal<?=$ay['value'];?>" <?}} ?> 
                         <? foreach($reserv as $res){ if($ay['value']  == $res){ ?> data-toggle="modal" data-target="#myModal<?=$ay['value'];?>" <?}} ?>
                        
                        class="bscheme choise 
                            
                            <? foreach($sell as $bil){ if($ay['value']  == $bil){ echo " bizi sell";}} ?>
                                <? foreach($new_block_plase as $blo){ if($ay['value']  == $blo['value']){ echo " blocket bizi";}} ?>
                                <?// foreach($null as $nul){ if($ay['value']  == $nul){ echo "null";}} ?>  
                                <? foreach($all_bizi_nikolo as $biz_nik){ if($ay['value'] == $biz_nik){ echo " blocket";}} ?>
                                <?// foreach($block_plase_array as $all=>$all_vall){ if($ay['value']  == $all_vall['value']){ echo "bizi";}} ?> 
                                <? foreach($reserv as $res){ if($ay['value']  == $res){ echo " bizi reserv";}} ?>" ><?php echo $ay['value']?></div>  
                    <?php } ?>
                </div>
            <?}?>
        </div>
        <div class="clearfix"></div>
        <?}?>
        
        <br />
    </div>
    <? } ?>
</div>

            
               
<script type="text/javascript">
//$('.blocket').click(function(){
//    alert($(this).text());
//})

    $('.blocket').click(function(){
        //var MaxSel =  1;
        //alert('hello');
        //exit;
        if($(this).parent().find('.selected_plase').html() == null){
            $(this).parent().find('.bscheme').addClass('selected_plase'); 
            
            var Par = $(this).parent();
            //var NewPrice = Prise + parseFloat($('.al').text());
            //$('.al').text(NewPrice.toFixed(2));
            var PlaseVal = $(this).text();
            var Block_name = '';
            $.ajax({
                    type: "POST",
                    url: "/tiket/ajax_blocket_get_name",
                    data: {plase:PlaseVal,route_name_id:$('.route_name_main').val(),from:$('.from_sel').val(),to:$('.to_sel').val()},
                    async: false,
                    success: function(data) {
                        //alert(data);
                        Block_name = data;
                    },
                    error:function(code, opt, err){
                        alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
                    }
                });
            //$('<div class="one_people col-md-12"><div class="form-group col-md-1"><label><?=__("№")?></label><span class="plase">'+PlaseVal+'</span></div><div class="form-group col-md-2"><label><?=__("Name")?></label><span>'+Block_name+'</span></div></div>').insertAfter('.peo_after');
            var plase_sel = Par.html();
            $('<div class="admin_choise_clear">'+plase_sel+'</div>').insertAfter('.admin_plases_clear');
            
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
             $('.admin_choise_clear div').each(function(){
             if($(this).text() == Tex){
                    $(this).parent().remove();
              } 
            });

        }
        
    })


$('.radioo').change(function(){
    $(this).parents('.form-row').find('.transfer_block').toggle();
    $(this).parents('.form-row').find('.returnet_block').toggle();
})


/*
function blocketAnul(ID){
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_blocket_null",
        data: {id:ID},
        success: function(data) {
            //alert(data);
            location="/tiket/sell";
        },
        error:function(){
            alert('ошибка записи step_3');
        }
    });
}
*/

$('.tran_tik').click(function(){
    var Par = $(this).parents('.transfer_block');
    var Tik = Par.find('.tik_sel_mod').val();
    var Date = Par.find('.datepicker_sell').val();
    var NewPri = $(this).prev('.tik_pri_modal').val();
    var Plase = Par.find(".salon_modal").find('.selected_plase').html();
    //alert(Plase);
    //exit;
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_tiket_transfer",
        data: {tik_id:Tik,date:Date,price:NewPri,plase:Plase},
        //async: false,
        success: function(data) {
            location="/tiket/sell";
            //if(data == Full){
            //alert(data);
             //   HTMLL.addClass('ui-state-active');
            //}
        },
        error:function(){
            //alert('ошибка записи step_3');
        }
    });  
})
    //var FG = 0;
    //$('.cur_pri').each(function(){
    //    FG += parseFloat($(this).text());
    //})
    //var NNN = parseFloat($('.al').text());
    //$('.al').text(FG.toFixed(2));
    
    function DellTable(ht,par,pri){
        par.each(function(){
            if($(this).html() == ht){
                $(this).removeClass('selected_plase');
            }
        })
    }
    
    $('.choise').click(function(){
        //var MaxSel =  1;
       
        if($(this).parent().find('.bizi').html() == null) {
        if($(this).parent().find('.selected_plase').html() == null){
            $(this).parent().find('.bscheme').addClass('selected_plase'); 
            
            var Par = $(this).parent();
            var Prise = parseFloat('<?=$price?>');
            //var NewPrice = Prise + parseFloat($('.al').text());
            //$('.al').text(NewPrice.toFixed(2));
            var PlaseVal = $(this).text();
            var DiscountBlock = $('.dis_block').html();
            //$('<div class="one_people col-md-12"><div class="form-group col-md-1"><label><?=__("№")?></label><span class="plase">'+PlaseVal+'</span><span class="dis_price" style="display:none;">'+Prise+'</span></div><div class="form-group col-md-2"><label><?=__("Name")?></label><input type="text" class="name form-control" /></div><div class="form-group col-md-2"><label><?=__("Soname")?></label><input type="text" class="soname form-control" /></div><div class="form-group col-md-2"><label><?=__("Date")?></label><input type="text" class="date form-control" /></div><div class="form-group col-md-2"><label><?=__("Tel")?></label><input type="text" class="tel form-control" /></div><div class="form-group col-md-2"><label><?=__("Tel2")?></label><input type="text" class="tel2 form-control" /></div><div class="form-group col-md-1">'+DiscountBlock+'</div></div>').insertAfter('.peo_after_clear');
            
            var plase_sel = Par.html();
            $('<div class="admin_choise_clear">'+plase_sel+'</div>').insertAfter('.admin_plases_clear');
            
        }else { 
            
            $(this).parent().find('.bscheme').removeClass('selected_plase');
            
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
             $('.admin_choise_clear div').each(function(){
             if($(this).text() == Tex){
                    $(this).parent().remove();
              } 
            });
            
            $('.one_people span').each(function(){
               if($(this).text() == Tex){
                    $(this).parents('.one_people').remove();
               } 
            });
            CURPRICEDISC();
        }
        }
        
    })


function CURPRICEDISC(){
    $('.al').text(0);
    var Start = 0;
    $('.dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    $('.al').text(Start.toFixed(2));
} 
    
$('.route_date_modal').focus(function(){
    
    setTimeout(getDate,10);
//    alert($(this).val());
    
})    

function getDate(){
    var RouteNameID = $('.route_name_main').val();
    //var RouteNameID = 1555;
    //alert(RouteNameID);
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
/*
$(".datepicker_sell").datepicker({
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
        $(this).parents().find('.ui-datepicker').hide();
        var RouteNameID = $(this).next('.rou_name').val();
        
        var SchemaHTml = '';
        var From = $(this).parent().find('.from_sel_mod').val();
        var To =  $(this).parent().find('.to_sel_mod').val();
        //alert(From);
        //exit;
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo",
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
        $(this).parent().next('.salon_modal').html(SchemaHTml);
    },
    });
*/    
    
</script>

<script src="<?=Kohana::$base_url?>assets/js/form_elements.js" type="text/javascript"></script>