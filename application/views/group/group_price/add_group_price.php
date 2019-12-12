
<div class="content">    
	<div class="row" id="inbox-wrapper">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					 <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <div class="large-12 medium-12  columns insert_in">
                                <p>&nbsp;</p>
                			    <label><?=__('Discount ID')?></label>
                                <input type="text" name="discount_id" class="discount_id" value="" />
                                <input type="hidden" name="group_id" class="group_id" value="<?=$parent;?>" />
                                <div class="clearfix"></div>
                                <br />
                                
                                <div class="hide_div col-md-6">
                                        <ul class="nav nav-tabs" id="tab-01">
                                            <? $i=0; foreach($langs as $lang){?>
                                                <li <? if($i==0){?>class="active" <?}?> ><a href="#panel2-<?=$i;?>"><?=$lang['lang'];?></a></li>
                                            <? $i++;}?>
                                        </ul>
                                        <div class="tab-content">
                                            <? $i=0; foreach($langs as $lang){?>
                                                <div class="tab-pane  <? if($i==0){?>active<?}?>" id="panel2-<?=$i;?>">
                                                   <div class="form-group">
                                                        <label><?=__("Title")?> - <span style="color: red;"><?=$lang['lang'];?></span></label>
                                                        <div class="input-with-icon  right">
                                                            <input name="title[]" type="text" class="form-control langs"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            <? $i++;}?>
                                        </div>
                                    </div>
                                    
                                <div class="clearfix">&nbsp;</div>
                                
                               <div class="form-group">
                                    <label class="form-label"><? echo __('Return');?></label>
                                    <div class="radio">
                                        <input name="ret" class="ret" type="radio"  id="male" value="1"  />
                                        <label for="male"><? echo __('Yes');?></label>
                                        <input id="female" class="ret" name="ret" type="radio"  value="0" checked="checked"  />
                                        <label for="female"><? echo __('No');?></label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label><?=__('Date from')?></label>
                                    <input type="text" name="date_from" class="date_from date" />
                                </div>
                                <div class="col-md-3">
                                    <label><?=__('Date to')?></label>
                                    <input type="text" name="date_to" class="date_to date" />
                                </div>
                                <div class="clearfix"></div>
                                
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
$(document).ready(function(){
    $(".date").datepicker({
        <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
        minDate:new Date(),
        dateFormat: "yy-mm-dd",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        //showOtherMonths: true,
        selectOtherMonths: true
    });
/////////////
})

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
    
    
    var langs_array = [];
    $('.langs').each(function(){
        langs_array.push($(this).val());
    })
    
    var ret = 0;
    $('.ret').each(function(){
        if($(this).attr('checked') == 'checked'){
            ret = $(this).val();
        }
    })
    
    //exit;
    
    
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
        url: "/groups/ajax_update_group_price",
        data: {route_name_id:$('.route').val(),valute:$('.valute').val(),fer_id:$('.ferryman').val(),array:newArr,group_id:$('.group_id').val(),date_from:$('.date_from').val(),date_to:$('.date_to').val(),ret:ret,main_id:'<?=$_GET['main_id'];?>',title:langs_array,discount_id:$('.discount_id').val()},
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