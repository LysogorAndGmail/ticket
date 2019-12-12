<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<div class="content">    
 	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Platform")?></h3>
                            <div class="col-md-12 no-padding par">
                                <div class="col-md-12 no-padding">
                                    <span class="in_af"></span>
                                    <h3 class="rou_tit"><?=$route_name['name'];?> - <?=$route_name['name_i18n'];?></h3>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <table class="table table-striped table-hover" id="emails">
                                    <thead>
                                    <tr>
                                    <th><? echo __('Id');?></th>
                                    <th><? echo __('Station');?></th>
                                    <th><? echo __('Mon');?></th>
                                    <th><? echo __('Thu');?></th>
                                    <th><? echo __('Wen');?></th>
                                    <th><? echo __('Tue');?></th>
                                    <th><? echo __('Fri');?></th>
                                    <th><? echo __('Sat');?></th>
                                    <th><? echo __('Sun');?></th>
                                    </tr>
                                    </thead>
                                    <tbody class="so">           
                                        <? foreach($all_ost as $ost){?>              
                                        <tr>        
                                            <td>
                                                <span class="idd"><?=$ost['route_city_id'];?></span>
                                            </td>                    
                                            <td>
                                                <? $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$ost['route_city_id'])->and_where('culture','=',$lang)->execute()->current(); echo $ost_name['name_i18n'].' - '; echo $ost_name['city_i18n'];?>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],0,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>  
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],1,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],2,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],3,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],4,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],5,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                            <td>
                                                <? $platform = Model::factory('RouteMod')->get_platform($_GET['route_name_id'],6,$ost['route_city_id'],3); ?>
                                                <input name="platform" type="text" class="t-t-input" value="<?=$platform['value'];?>"/>
                                            </td>
                                        <?}?>    
                                    </tbody>
                                    </table>           
                                </div>
                                <div class="col-md-12 no-padding" style="background-color: #fff;">  
                                    <div class="pull-left">
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

$('.update_step').click(function(){
    var Val = [];
    $(this).parents('.par').find('.t-t-input').each(function(){
        Val.push($(this).val());
    });
    
    var Ostt = [];
    $(this).parents('.par').find('.idd').each(function(){
        Ostt.push($(this).text());
    });
    
    
    $.ajax({
        type: "POST",
        url: "/route/ajax_update_platform",
        data: {val:Val,route: '<?=$_GET['route_name_id']?>',osts:Ostt},
        success: function(data) {
            alert('Update!');
            location.reload();
            //location="/route/edit_route2?route_name_id=<?=$_GET['route_name_id']?>";
            //$('.warning').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние update_step");
            }
   });
})


</script>







