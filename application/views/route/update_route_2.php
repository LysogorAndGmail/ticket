<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<div class="container container-fixed-lg">
 
  <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step")?> 2</h3>
                            <div class="route_nav">
                                   <a href="/route/edit_route?route_name_id=<?=$_GET['route_name_id'];?>"  ><?=__("Info")?></a>
                                <a href="/route/edit_route2?route_name_id=<?=$_GET['route_name_id'];?>" class="activ"><?=__("Timetable")?></a>
                                <a href="/route/edit_route3?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Date and Carry")?></a>
                                <a href="/route/edit_route4?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Price")?></a>
                            </div>
                            <div class="col-md-12 no-padding par">
                                <div class="col-md-12 no-padding">
                                    <span class="in_af"></span>
                                    <h3 class="rou_tit"><?=$route_name['name'];?> - <?=$route_name['name_i18n'];?></h3>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="grey">
                                        <div class="form-group col-md-6 no-padding">
                                            <label><? echo __('Station or City');?></label>
                                            <input type="text" class="fields form-control new_join" name="get_ost" value="" width="50" />
                                            <div id="show_ost"></div>
                                            <input type="hidden" class="ost_id" value="" />
                                            <input type="hidden" class="ost_city" value="" />
                                        </div>
                                        <div class="col-md-6 no-padding">
                                            <label>&nbsp;</label>
                                            <button class="add_to_roz tiny btn btn-success btn-cons mar_left" ><? echo __('Add');?></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <table class="table table-striped table-hover" id="emails">
                                    <thead>
                                    <tr>
                                    <th><? echo __('Id');?></th>
                                    <th><? echo __('Station');?></th>
                                    <th><? echo __('Platform');?></th>
                                    <th><? echo __('Mon');?></th>
                                    <th><? echo __('Tue');?></th>
                                    <th><? echo __('Wen');?></th>
                                    <th><? echo __('Thu');?></th>
                                    <th><? echo __('Fri');?></th>
                                    <th><? echo __('Sat');?></th>
                                    <th><? echo __('Sun');?></th>
                                    </tr>
                                    </thead>
                                    <tbody class="so">           
                                        <? foreach($all_ost as $ost){?>              
                                        <tr>        
                                            <td><span><?=$ost['route_city_id'];?></span></td>                    
                                            <td><? $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$ost['route_city_id'])->and_where('culture','=',$lang)->execute()->current(); echo $ost_name['name_i18n'].' - '; echo $ost_name['city_i18n'];?></td>
                                            <td><? $platform = DB::select()->from('routedistance')->where('r_id','=',$ost['r_id'])->and_where('route_name_id','=',$ost['route_name_id'])->execute()->current();?><input name="platform" type="text" class="platform" value="<?=$platform['platform'];?>"/></td>  
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],0,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],1,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],2,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],3,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],4,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],5,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td>
                                            <? $ost_time = Model::factory('RouteMod')->get_city_time($ost['r_id'],6,1);?>
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['a_hours'];?>"/><br />
                                            <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost_time['hours'];?>"/>
                                            </td>
                                            <td><img onclick="DelSVZ(<?=$ost['route_city_id'];?>)" src="<?=Kohana::$base_url?>img/ui/delete-grey.png" width="12" height="12" title="<? echo __('Delete');?>" /></td>
                                            </tr>
                                        <?}?>    
                                    </tbody>
                                    </table>           
                                </div>
                                <div class="col-md-12 no-padding" style="background-color: #fff;">  
                                    <div class="pull-left">
                                    <button type="submit" class="btn btn-salat btn-cons save_weight"><i class="icon-ok"></i><? echo __('Save order');?></button>
                                    <button type="button" class="btn btn-white btn-cons update_step"><? echo __('Update');?></button>
                                    </div>
                                </div>                      
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.save_weight').click(function(){
    var HTM = $('.so').html();
    //alert(HTM);
    //exit;
    $.ajax({
        type: "POST",
        url: "/route/save_weight",
        data: {route_name_id:'<?=$_GET['route_name_id']?>',html:HTM},
        success: function(data) {
            //alert(data);
            location="/route/edit_route2?route_name_id=<?=$_GET['route_name_id']?>";
            //$('.success').show();
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
}) 
$(function() {
    $('tbody').sortable();
})
$('.update_step').click(function(){
    var Val = [];
    $(this).parents('.par').find('.t-t-input').each(function(){
        Val.push($(this).val());
    });
    
    var Platform = [];
    $(this).parents('.par').find('.platform').each(function(){
        Platform.push($(this).val());
    });
    
    var HTM = $('.so').html();
    var ST = '<?=$_GET['route_name_id']?>';
    //alert(Val);
    //exit;
    $.ajax({
        type: "POST",
        url: "/route/update_route2",
        data: {step_id:ST,html:HTM,val:Val,platform:Platform},
        success: function(data) {
            //alert(data);
            location="/route/edit_route2?route_name_id=<?=$_GET['route_name_id']?>";
            $('.warning').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние update_step");
            }
   });
}) 
$('.new_join').keyup(function(){
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
   
   var ID = $(this).parents('.grey').find('.ost_id').val();
   var Name = $(this).parents('.grey').find('.new_join').val();
   var City = $(this).parents('.grey').find('.ost_city').val();
   //alert(City);
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
            alert('ошибка записи add_to_roz');
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
$(function($){
	   $("#date").mask("99/99/9999");
	   $("#phone").mask("(999) 999-9999");
	   $("#tin").mask("99-9999999");
	   $("#ssn").mask("999-99-9999");
       $(".custom_date").mask("99/99/9999");
       $(".custom_time").mask("99:99");
	});
</script>
<script src="<?=Kohana::$base_url;?>js/mask.js" type="text/javascript"></script>










