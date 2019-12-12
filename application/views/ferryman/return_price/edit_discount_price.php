<div class="content">    
	<div class="row" id="inbox-wrapper">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					 <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <div class="large-12 medium-12  columns insert_in">
                               <p>&nbsp;</p>
                			    <label><?=__('Ferryman')?></label>
                                <select class="ferryman col-md-6">
                                    <?foreach($all_fer as $fer){?>
                                        <option value="<?=$fer['ferryman_id'];?>" <?if($edit[0]['ferryman_id'] == $fer['ferryman_id']){?>selected="selected"<?}?>><?=$fer['name'];?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <label><?=__("Valuta")?></label>
                                <select class="valute col-md-6" name="valute">
                                    <? foreach($valutes as $valute){?>
                                        <option value="<?=$valute['valute']?>" <?if($edit[0]['valute'] == $valute['valute']){?>selected="selected"<?}?>><?=$valute['valute']?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <label><?=__('Routes')?></label>
                                <select class="route col-md-6">
                                    <option value="">-</option>
                                    <?foreach($all_rou as $rou){?>
                                        <option value="<?=$rou['route_name_id'];?>" <?if($edit[0]['route_name_id'] == $rou['route_name_id']){?>selected="selected"<?}?>><?=$rou['route_name_id'].' '.$rou['name'].' '.$rou['name_i18n'];?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <div class="ajax_block">
                                    <table class="table table-hover main_route_price" id="emails">
                                    <? $count = count($all_ost);?>
                                    <tr>
                                        <td colspan="2" class="strong" style="width: 80px !important;"></td>
                                        <? if (1){ 
                                             for ($i = 0; $i < $count; $i++){ 
                                                 if (($count - 1) > $i) { ?>
                                                    <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                        <? } }  }else{ 
                                             for ($i = $count; $i > 0; $i--){ 
                                                 if (($count) > $i) { ?>
                                                    <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                        <? }  }  } ?>
                                    </tr>
                                    <? for ($i = 0; $i < $count; $i++){ 
                                     if ($i){ ?>
                                        <tr <? if ($i % 2 == 0){ ?> class="rows1"<? }?> >
                                            <td><? echo $i?></td>
                                            <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                            <? for ($j = 0; $j < $count - 1; $j++){ 
                                             if ((($count - 1) > $j && $j < $i && $all_ost[$j]['route_city_id'] != $all_ost[$i]['route_city_id'])) { 
                                                //$pri = DB::select()->from('RoutePrice')->where('route_name_id','=',$_GET['route_name_id'])->and_where('route_city_from_id','=',$all_ost[$j]['route_city_id'])->and_where('route_city_to_id','=',$all_ost[$i]['route_city_id'])->execute()->as_array(); print_r($pri);//$all_ost[$j]['route_city_id'])->and_where('ost_id_to','=',$all_ost[$i]['route_city_id'])->execute()->current();
                                                ?>
                                                <td style="width: 80px !important;"><input style="width: 80px !important;" name="<?=$all_ost[$j]['route_city_id'].'_'.$all_ost[$i]['route_city_id'];?>" type="text" value="<?//=$pri['price'];?>" /></td>
                                            <? }elseif ($j > $i) { ?>
                                                <td></td>
                                            <? }else{ ?>
                                                <td><? //echo $all_ost[$i]['route_city_id']; ?></td>
                                            <? } } ?>
                                        </tr>
                                    <? } } ?>
                                </table>
                                </div>
                                <p>&nbsp;</p>
                                <button class="btn btn-info update_discount_price"><?=__('Update')?></button>
                            </div>
                        </div>
                   </div>	
				</div>
			</div>
		</div>	
	</div>
<div class="clearfix"></div>
</div>
<script type="text/javascript">
function GetPrice(){

    //ajax_animation_start();
    $('.main_route_price input').each(function(){
       $(this).val(''); 
    });
    var Sp = '';
    $.ajax({
        type: "POST",
        url: "/ferryman/ajax_get_discount_price",
        data: {route_name_id:'<?=$_GET['route_name_id'];?>',valute:$('.valute').val(),fer:'<?=$_GET['fer_id'];?>'},
        async: false,
        success: function(data) {
            //alert(data);
            Sp = data            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   
   var DF = Sp.split(':');
   //exit;  
   //delete DF[DF.length-1];
    for(var nn = 0; nn<=DF.length-1; nn++){
        var Del = DF[nn].split(',');
        //delete DF[DF.length-1];
        //alert(Del);
        //exit;
        $('.main_route_price input').each(function(){
            //$(this).val('');    
            var Name = $(this).attr('name');
            var par = $(this).parent('td');
            if(Name == Del[0]){
                par.find('input').val(Del[1]);                    
            }
        //alert(Del[0]);  
    })
    
   }
   
   //ajax_animation_stop();
   //alert(DF);
 
}
GetPrice();

$('.update_discount_price').click(function(){   
   var newArr = [];
   $(this).parents('.insert_in').find('.main_route_price input').each(function(){
        if($(this).val().length > 0){
            var Name = $(this).attr('name')+':'+$(this).val();
            newArr.push(Name);
        }
   })
   if(newArr.length == 0){
        alert('Empty Check Valute!');
        exit;
   }
   //alert(newArr);
   
   //exit;
   $.ajax({
        type: "POST",
        url: "/ferryman/ajax_update_discount_price",
        data: {route_name_id:$('.route').val(),valute:$('.valute').val(),fer_id:$('.ferryman').val(),array:newArr},
        async: false,
        success: function(data) {
            alert(data);
            //Sp = data            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   //alert(DF);
})
</script>
