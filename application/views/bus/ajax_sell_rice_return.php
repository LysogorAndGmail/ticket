<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<div data-toggle="buttons" class="btn-group">
<? foreach($all_rice as $rice){ 
    $time_from = DB::select()->from('routeweek')->where('route_name_id','=',$route_name_id)->and_where('r_id','=',$city_from['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$rice['rice'])->execute()->current();
    if(!empty($time_from['hours'])){ 
    ?>
   
   
   <label class="btn btn-complete">
        <input type="radio" id="<?=$rice['rice'];?>" name="return_rice" class="radio_rice_return" data-rice="<?=$rice['rice'];?>" <? if($rice['rice'] == 1){ echo 'checked="checked"'; }?>><? echo __("Flight");?> <?=$rice['rice'];?> <?=$time_from['hours']?>
    </label>
   
          
<? } 

}?>
</div>
<script type="text/javascript">


$('.radio_rice_return').change(function(){
    //alert();
        
       $('.return_salon').html('');
       
       $('.return_people .one_people').remove(); 
        //$('#ui-datepicker-div').hide();
        var RouteNameID = $('.return_route_name_main').val();
        var SchemaHTml = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo",
            data: {route_name_id:RouteNameID,date:$('#return_datepicker_sell').val(),from:From,to:To,rice:$(this).data('rice')},
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
        
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:$('#return_datepicker_sell').val(),from:From,to:To,lang:$("#cur_lan").val(),rice:$(this).data('rice')},
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
      $('.return_bus_sell').text(newTop[0]);
      $('.return_bus_sell_from').text(newTop[1]);
      $('.return_bus_sell_to').text(newTop[2]);
      $('.return_fer_sell').text(newTop[3]);
       
        
      $('.return_salon').html(SchemaHTml);
      
      RETURNCURPRICEDISC();

})


</script>