<? //print_r($last_rout_name_id);?>
<div>   
    <div class="blue-title-bar">
        <div class="blue-down-arrov"></div>
        <div class="blue-space">
        <div class="blue-title">
        <h4><? echo __('Добавление маршрута');?></h4>
        </div>
        <div class="blue-btm"><div class="tabs_ost_add"></div></div>
        </div>
    </div>
    <div class="left-padding-content filds-ost form-vertical">
        <div class="add_route_navigation"><a href="/admin/add_new_route?route_name_id=<?=$last_rout_name_id['route_name_id'];?>"> <- Создание названия</a></div>
                
                    <div class="control-group">
                        <label><span class="name-input-ost"><? echo __('Город');?>:</span></label>
                        <input type="hidden" class="route_id" value="<?=$last_rout_name_id['route_id'];?>" />
                        <input type="hidden" class="route_name_id" value="<?=$last_rout_name_id['route_name_id'];?>" />
                        <div>
                            <input type="text" class="main_input_city" />
                        </div>
                            <div class="all_city_block">
                                <div class="block_city">
                                </div>
                            </div>           
                        <div class="show_admin_ost"></div>
                    </div>
                    <button class="add_city_block btm-edit" >Сохранить порядок</button>                    
                </div>
            
            <div class="clearfix"></div>
        <div class="update-ost-btm"> 
        </div>
        <div class="clearfix"></div>
        <div class="space-small"></div>    
</div>
<script type="text/javascript">
$('.main_input_city').keyup(function(){
    $.ajax({
        method:'post',
        url:'/route/show_ost_ajax',
        data:{city_name:$(this).val()},
        error:function(){
            alert('error');
        },
        success:function(data){
            $('.show_admin_ost').html(data);
        }
    }); //end ajax
})
</script>