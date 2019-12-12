<div class="content">    
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3>Back- <span class="semi-bold">Index</span></h3>
    </div>		
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                                                
                            <div class="col-md-12 no-padding">
                                <div class="col-md-12 no-padding">
                                    <span class="in_af"></span>
                                    <h2 class="rou_tit"><?=$route_name['name'];?> - <?=$route_name['name_i18n'];?></h2>
                                    <div class="col-md-2 pull-right">sdf</div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="grey">
                                        <div class="form-group col-md-6 no-padding">
                                            <label><? echo __('Station or City:');?></label>
                                            <input type="text" class="fields form-control new_join" name="get_ost" />
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
                                <div class="col-md-12 no-padding par">          
                        <?   for($i=10;$i>=1;$i--){
                $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$route_name['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                if(!empty($ch)){
                    $i += 1; 
                    echo 'это рейс <span class="rice_val">'.$i.'</span>';
                    break;
                }
                      } ?>
                            <table class="table table-striped table-hover" id="emails">
                                <thead>
                                    <tr>
                                        <th><? echo __('Id');?></th>
                                        <th><? echo __('Station');?></th>
                                        <th><? echo __('Mon');?></th>
                                        <th><? echo __('Thu');?></th>
                                        <th><? echo __('Wen');?></th>
                                        <th><? echo __('Thu');?></th>
                                        <th><? echo __('Fri');?></th>
                                        <th><? echo __('Sat');?></th>
                                        <th><? echo __('Sun');?></th>
                                    </tr>
                                </thead>
                                <tbody class="sortable">           
                                    <? foreach($all_ost as $ost){?>              
                                        <tr>        
                                            <td><span><?=$ost['route_city_id'];?></span></td>                    
                                            <td><? $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$ost['route_city_id'])->and_where('culture','=','ru')->execute()->current(); echo $ost_name['name_i18n'].' - '; echo $ost_name['city_i18n'];?></td>
                                            <td>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                                
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                                
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                                
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                                
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                                
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td>
                                               
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                                <input name="time" type="text" class="t-t-input custom_time" value=""/>
                                            </td>
                                            <td></td>
                                        </tr>
                                    <?}?>    
                                </tbody>
                            </table>
                            <button class="btn btn-white btn-cons update_step small"><? echo __('Save');?></button>           
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
$(function() {
    $('tbody').sortable();
})
$('.update_step').click(function(){
    var Val = [];
    //alert($(this).parent('.par').html());
    //exit;
    $(this).parent('.par').find('.t-t-input').each(function(){
        Val.push($(this).val());
    });
    var HTM = $('.sortable').html();
    //alert(IS);
    //exit;
    $.ajax({
        type: "POST",
        url: "/rice/add_rice1",
        data: {step_id:'<?=$_GET['route_name_id']?>',html:HTM,val:Val,rice:$('.rice_val').text()},
        success: function(data) {
            //$('.html').html(data);
            location="/rice/add_rice2?route_name_id=<?=$_GET['route_name_id']?>";
            //$('.warning').show();
            
        },
        error:function(){
            alert('ошибка записи rice');
        }
   });
}) 

</script>

<script src="<?=Kohana::$base_url;?>assets/js/messages_notifications.js" type="text/javascript"></script>











