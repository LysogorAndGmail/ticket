<? 
/*
echo '<pre>';
print_r($all_rou);
echo '</pre>';
die;
*/
?>
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
                                        <option value="<?=$fer['ferryman_id'];?>"><?=$fer['name'];?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <label><?=__("Valuta")?></label>
                                <select class="valute col-md-6" name="valute">
                                    <? foreach($valutes as $valute){?>
                                        <option value="<?=$valute['valute']?>"><?=$valute['valute']?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <label><?=__('Routes')?></label>
                                <select class="route col-md-6">
                                    <option value="">-</option>
                                    <?foreach($all_rou as $rou){?>
                                        <option value="<?=$rou['route_name_id'];?>"><?=$rou['route_name_id'].' '.$rou['name'].' '.$rou['name_i18n'];?></option>
                                    <?}?>
                                </select>
                                <div class="clearfix"></div>
                                <p>&nbsp;</p>
                                <div class="ajax_block"></div>
                                <p>&nbsp;</p>
                                <button class="btn btn-info update_discount_price" style="display: none;"><?=__('Add')?></button>
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
$('.route').change(function(){
    $(".ajax_load").show();
    $.ajax({
        type: "POST",
        url: "/ferryman/ajax_get_price_table",
        data: {route_name_id:$(this).val()},
        async: false,
        success: function(data) {
            //alert(data);
            //Sp = data
            $('.ajax_block').html(data);            
        },
        error:function(){
            alert('ошибка route change');
        }
   });
   $('.update_discount_price').show();
   setTimeout(HideAnimm,500);
})
function HideAnimm(){
    $(".ajax_load").hide();
}

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
            //alert(data);
            //Sp = data    
            location="/groups/group_price";           
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   //alert(DF);
})
</script>