<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<div data-toggle="buttons" class="btn-group">
                            
                           
<? foreach($all_rice as $rice){ 
    $time_from = DB::select()->from('routeweek')->where('route_name_id','=',$route_name_id)->and_where('r_id','=',$city_from['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice['rice'])->execute()->current();?>
    
    
    
    <? if(!empty($time_from['hours'])){ //'<pre>';// print_r($rice); echo '</pre>';?>

    
    <label class="btn btn-complete">
        <input type="radio" id="<?=$rice['rice'];?>" name="rice" class="radio_rice" data-rice="<?=$rice['rice'];?>" <? if($rice['rice'] == 1){ echo 'checked="checked"'; }?>><? echo __("Flight");?> <?=$rice['rice'];?> <?=$time_from['hours']?>
    </label>
    
    
<? } // если есть время

 }?> 
 </div>
<script type="text/javascript">


$('.radio_rice').change(function(){
    //alert();
            
       //ajax_animation_start();
        
       $('.salon').html('');
       
       $('.people .one_people').remove(); 
        //$('#ui-datepicker-div').hide();
        var RouteNameID = $('.route_name_main').val();
        var SchemaHTml = '';
        var From = $('.from_sel').val();
        var To = $('.to_sel').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo",
            data: {route_name_id:RouteNameID,date:$('#datepicker_sell').val(),from:From,to:To,rice:$(this).data('rice')},
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
        
        
        //$('.salon').html(SchemaHTml);
        //exit; 
       // ajax_animation_stop();
       // $('.animation_ajax').hide();
      ///////////  arive
      
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:$('#datepicker_sell').val(),from:From,to:To,lang:$("#cur_lan").val(),rice:$(this).data('rice')},
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
       $('.bus_sell').text(newTop[0]);
       $('.bus_sell_from').text(newTop[1]);
       $('.bus_sell_to').text(newTop[2]);
       $('.fer_sell').text(newTop[3]);
       
       
       
      //  alert(newTop[3]);
        
     ///////////  depart 
        //$('.fix_block').hide();
        
        /////////enter schema 
        
       // if(newTop[1].length == 11 || newTop[2].length == 11){
       //     $('.salon').html("empty time arrive or depart");
       // }else {
       //     $('.salon').html(SchemaHTml);
       //     var Op = $('.open_on:checked').val();
       //     if(Op == 'on'){ 
       //         $('#open_tik').show();
       //     }else{
       //         $('.bat_sell_modall').show();
       //         $('#order_tik').show();
       //     }
       //     $('.bottom_block_sell').show();
       // }  
        
        $('.salon').html(SchemaHTml);
        
        CURPRICEDISC();
        
        //ajax_animation_stop();
        
        //$('.sell_rice').show();
})


</script>