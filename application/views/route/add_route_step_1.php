<div class="bag_gray marg_fix">
    <div class="tabs-settings padding_b">
        <div class="t-p-message"><div class="t-p-m-number">5</div></div><div class=" t-p-settings"><a href="">Настройки</a></div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
    <div class="padding_center">
        <div class="row">
            <div class="blue-title-bar">
                <div class="blue-down-arrov"></div>
                <div class="blue-space">
                <div class="blue-title">
                <h4><? echo __('Добавление маршрута');?></h4>
                </div>
                <div class="blue-btm"><div class="tabs_ost_add"><p><span class="span_ru"><? echo __('Русский');?></span> <span class="span_ua"><? echo __('Украинский');?></span> <span class="span_en"><? echo __('Английский');?></span></p></div></div>
                </div>
            </div>
            <div class="left-padding-content filds-ost form-vertical">
                <div class="control-group">
                    <div class="validate-update-ost">
                    <form action="" id="add_route_form" method="post" >
                    <? echo __('Блокировка');?>:
                    <input name="is_validate" value="0" type="radio" /><? echo __('Да');?> <input name="is_validate" type="radio" value="1" checked="checked" /><? echo __('Нет');?>
                    </div>   
                </div>
                <div class="update-data-ost">
                    <div style="position: relative;">
                        <div class="info_popup pop-windows-error">
                        <div class="pop-windows-error-text"><p></p></div>
                        <div class="pop-windows-error-close"><img class="close_info_popup" src="<?=Kohana::$base_url?>images/close_search_form.png" width="22" height="22" /></div>
                        </div>
                    </div>
                    <div class="u-ost-colum-a" id="tab_body">
                        <div class="ru_tab">
                            <div class="control-group">            
                                <label><span class="name-input-ost"><? echo __('ID Route');?>:</span>
                                    <input name="route_id" type="text" class="filds-ost-name_1"  value="<?=$last_rout['route_id'] +1;?>" />
                                </label>
                            </div>
                            <div class="control-group">            
                                <label><span class="name-input-ost"><? echo __('Номер');?>:</span>
                                    <input name="name" type="text" class="filds-ost-name_1"  value="" />
                                </label>
                            </div>
                            <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Название');?>:</span>
                                    <input name="name_i18n" type="text" class="filds-ost-name"   value="" />
                                </label>
                            </div>
                            <div class="control-group">
                                <span class="name-input-ost"><? echo __('Тип');?>:</span>
                                <select name="route_type" class="route_type_menu">
                                    <option value="1"><? echo __('Автобус');?></option>
                                    <option value="2"><? echo __('Поезд');?></option>
                                    <option value="gorod"><? echo __('Гор.транспорт');?></option>
                                </select>
                                <select name="route_type" class="route_type_sub_menu">
                                    <option value="3"><? echo __('Г.Автобус');?></option>
                                    <option value="4"><? echo __('Электричка');?></option>
                                    <option value="5"><? echo __('Маршрутка');?></option>
                                </select>
                            </div>
                            <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Страна');?>:</span>
                                    <select name="country_id" class="country_id">
                                        <? foreach($all_countrys as $contry){?>
                                            <option value="<? echo $contry['country_id'];?>"><? echo $contry['name_i18n'];?></option>
                                        <?}?>
                                    </select>
                                </label>
                            </div>
                            <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Страна куда');?>:</span>
                                    <select name="country_id_to" class="country_id">
                                        <? foreach($all_countrys as $contry){?>
                                            <option value="<? echo $contry['country_id'];?>"><? echo $contry['name_i18n'];?></option>
                                        <?}?>
                                    </select>
                                </label>
                            </div>
                            <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Время действия маршрута или период');?>:</span></label>
                                    <select class="time_or_period" name="period_or_time">
                                            <option value="period">Период</option>
                                            <option value="time">Время</option>
                                    </select>
                                    <div class="main_period"></div>
                                    <div class="period_period" style="display: none;"> Месецев:
                                        <select name="period">
                                            <? for($i=1; $i<13; $i++){?>
                                            <option value="<?=$i;?>"><?=$i;?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                    <div class="time_time" style="display: none;">
                                        от:<input type="text" value="" name="time_start" /> до:<input type="text" value="" name="time_end" />
                                    </div>
                            </div>
                            <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Перевозчик');?>:</span></label>
                                <div>
                                    <select name="farryman_id">
                                        <? foreach($all_fer as $fer){?>
                                        <option value="<?=$fer['ferryman_id']?>"><?=$fer['name']?></option>
                                        <?}?>
                                    </select>
                                </div>           
                                <div class="show_admin_ost"></div>
                            </div>
                        </div>
                        <!-- start UA tabs -->
                        <div class="ua_tab">
                             <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Название UA');?>:</span>
                                    <input name="name_i18n_ua" type="text" class="filds-ost-name_ua"   value="" />
                                </label>
                            </div>
                        </div>
                        <!-- end UA tabs -->
                        <!-- start EN tabs -->
                        <div class="en_tab">
                             <div class="control-group">
                                <label><span class="name-input-ost"><? echo __('Название EN');?>:</span>
                                    <input name="name_i18n_en" type="text" class="filds-ost-name_en"   value="" />
                                </label>
                            </div>
                        </div>
                        <!-- end EN tabs -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="update-ost-btm">
                <input id="admin_login_submit" type="submit" class="btm-edit" id="add_ost_button" value="<? echo __('Добавить');?>"/>  
                </div>
                </form>
                <div class="clearfix"></div>
                <div class="space-small"></div>    
            </div>
        </div>
    </div>

<script type="text/javascript">
$('.main_input_city').keyup(function(){
    $.ajax({
        method:'post',
        url:'/route/show_farryman_ajax',
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

