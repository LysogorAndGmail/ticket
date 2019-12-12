<style>
#show_ost {
    position: absolute; 
    z-index:999; 
    background-color: #fff;
    margin-top:-17px;
    overflow: auto;
    border: 1px solid black;
}
.on {
    cursor: pointer;
    padding: 10px;
    padding-bottom: 0;
}
</style>
<div class="content">    
 	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Rice")?> <?=$_GET['rice'];?></h3>
                            <div class="col-md-12 no-padding par">
                                <div class="col-md-12 no-padding">
                                    <span class="in_af"></span>
                                    <h3 class="rou_tit"><?=$route_name['name'];?> - <?=$route_name['name_i18n'];?></h3>
                                    <div class="col-md-2 pull-right"><a class="btm-edit btn btn-success btn-cons" style="margin-top: -50px;" href="/rice/see2?route_name_id=<?=$_GET['route_name_id'];?>&rice=<?=$_GET['rice'];?>">See Ferryman</a></div>
                                </div>
                                <div class="col-md-12 no-padding">
                             <span class="rice_val" style="display: none;"><?=$_GET['rice'];?></span>
                            <table class="table table-striped table-hover" id="emails">
                                <thead>
                                    <tr>
                                        <th width="20"><? echo __('Id');?></th>
                                        <th width=""><? echo __('Station');?></th>
                                        <th width="80"><? echo __('Mon');?></th>
                                        <th width="80"><? echo __('Thu');?></th>
                                        <th width="80"><? echo __('Wen');?></th>
                                        <th width="80"><? echo __('Thu');?></th>
                                        <th width="80"><? echo __('Fri');?></th>
                                        <th width="80"><? echo __('Sat');?></th>
                                        <th width="80"><? echo __('Sun');?></th>
                                    </tr>
                                </thead>
                                <tbody class="sortable">           
                                    <? foreach($all_ost as $ost){?>              
                                        <tr>        
                                            <td><span><?=$ost['route_city_id'];?></span></td>                    
                                            <td><? $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$ost['route_city_id'])->and_where('culture','=','ru')->execute()->current(); echo $ost_name['name_i18n'].' - '; echo $ost_name['city_i18n'];?></td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],0,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],1,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],2,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],3,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],4,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],5,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                                <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],6,$_GET['rice']);?>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/>
                                                <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td></td>
                                        </tr>
                                    <?}?>    
                                </tbody>
                            </table>
                            <button class="btn btn-white btn-cons update_step small"><? echo __('Update');?></button>                      
                        </div>                    
                    </div>
                    <div class="clearfix"></div>
                </div> 
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
    $('tbody').sortable();
})
$('.update_step').click(function(){
    var Val = [];
    $(this).parents('.par').find('.t-t-input').each(function(){
        Val.push($(this).val());
    });
    var HTM = $('.sortable').html();
    //alert(Val);
    //exit;
    $.ajax({
        type: "POST",
        url: "/rice/ajax_update_rice1",
        data: {step_id:'<?=$_GET['route_name_id'];?>',html:HTM,val:Val,rice:$('.rice_val').text()},
        success: function(data) {
            //alert(data);
            location="/rice/see?route_name_id=<?=$_GET['route_name_id'];?>&rice=<?=$_GET['rice'];?>";
            //$('.warning').show();
            
        },
        error:function(){
            alert('ошибка ajax_update_rice1');
        }
   });
}) 
$('#get_ost_join').keyup(function(){
    $.ajax({
      type: "POST",
      url: "/roz/ajax_ost_join",
      data: { ost_name: $(this).val() }
            }).error(function(){
                alert('ошибка ajax остановки!');
            }).success(function(data) {
                if(data != 1) {
                    $('#show_ost').html(data);
                }
        });
})
$('.add_to_roz').click(function(){
   var ID = $(this).parents('.panel-t-t').find('.ost_id').val();
   var Name = $(this).parents('.panel-t-t').find('#get_ost_join').val();
   var City = $(this).parents('.panel-t-t').find('.ost_city').val();
   //alert(ID);
   //exit;
   $.ajax({
        type: "POST",
        url: "/route/add_ost_step_2",
        data: {step_id:'<?=$_GET['route_name_id']?>',id:ID,name:Name,city:City},
        success: function(data) {
            //alert(data);
            location="/route/edit_route2?route_name_id=<?=$_GET['route_name_id']?>";
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
})

function DelSVZ(id){
    $.ajax({
        type: "POST",
        url: "/route/del_ost",
        data: {step_id:'<?=$_GET['route_name_id']?>',id:id},
        success: function(data) {
            //alert(data);
            location="/route/edit_route2?route_name_id=<?=$_GET['route_name_id']?>";
            //$('.error').show();
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
}

</script>













