<script type="text/javascript">
$(function () {
	$('.defaultEntry').timeEntry();
});
</script>
<div>   
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
        <div class="add_route_navigation"><a href="/admin/add_new_route">Создание названия</a> <a href="/admin/add_new_route_2">Создание направления</a> <a href="/admin/add_new_route_3">Создание рассписания</a></div> 
        <form action="/admin/add_new_route_3" method="POST">
            <!-- !-->
                <table id="newspaper-c" summary="Personal Movie Rating">
                    <thead>
                        <tr class='nohover'>
                            <th scope='col'>ID</th>
                            <th scope='col'>WEIGHT</th>
                            <th scope='col'>Название</th>
                            <th scope='col'>Город</th>
                            <th scope='col'>Пон</th>
                            <th scope='col'>Вто</th>
                            <th scope='col'>Сре</th>
                            <th scope='col'>Чет</th>
                            <th scope='col'>Пят</th>
                            <th scope='col'>Суб</th>
                            <th scope='col'>Вос</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?>
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <span class="week_id" style="display: none;">1</span>
                                    <button class="load_trans">загрузить транспорт</button>
                                    <div class="all_buses"></div>
                                    <div class="buscheme"></div>
                                    <span class="chak_all">все</span>
                                    <span class="chak_odd">четные</span>
                                    <span class="chak_even">не четные</span>
                                    <div class="show_all_dates"></div>   
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -2
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>  
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -3
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>  
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -4
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>  
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -5
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>  
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -6
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>  
                                </div>
                            </td>
                            <td>
                                <span onclick="$(this).next('.count').show()">доб. перевозчика</span>
                                <div class="count" style="display: none;">
                                    <span onclick="$(this).parent().hide()" style="float: right;">X</span>
                                    route_id - <?=$rout_info[0]['route_id'];?> день -7
                                    <input type="text" class="main_input_city" style="width: 150px !important;" />
                                    <input type="text" class="farryman_id" name="farryman_id" value="" />
                                    <div class="show_admin_ost"></div>
                                    <button class="load_trans">загрузить транспорт</button>
                                     
                                </div>
                            </td>
                        </tr>
                    <? foreach($rout_info as $rout) {?>
                        
                        <tr class='newspaper-c'>
                            <td><? echo $rout['route_city_id'];?></td>
                            <td><? echo $rout['weight'];?></td>
                            <td><? $ost = Model::factory('Ost')->get_ost($rout['route_city_id'],'ru'); echo $ost['name_i18n'];?></td>
                            <td><? echo $ost['city_i18n'];?></td>
                            <td>
                                <input type="text" name="<?=$rout['route_city_id']."_0_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_0_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                            <td>
                                <input type="text" name="<?=$rout['route_city_id']."_1_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_1_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                             <td>
                                <input type="text" name="<?=$rout['route_city_id']."_2_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_2_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                            <td>
                                <input type="text" name="<?=$rout['route_city_id']."_3_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_3_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                             <td>
                                <input type="text" name="<?=$rout['route_city_id']."_4_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_4_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                            <td>
                                <input type="text" name="<?=$rout['route_city_id']."_5_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_5_arr";?>" value="00:00" class="defaultEntry" />
                            </td>
                             <td>
                                <input type="text" name="<?=$rout['route_city_id']."_6_dep";?>" value="00:00" class="defaultEntry" /><br />
                                <input type="text" name="<?=$rout['route_city_id']."_6_arr";?>" value="00:00" class="defaultEntry" />
                            </td>                            
                        </tr>
                    <?}?>				
                    </tbody>
                </table>
                <table id="table-footer">
                    <tr><td>sdsd</td></tr>
                </table>
            <!-- ! -->
            <button class="btm-edit">Сохранить рассписание</button>
        </form>  
    </div>
</div>
<script type="text/javascript">
$('.main_input_city').keyup(function(){
    var Show_all = $(this).parent('.count').find('.show_admin_ost');
    $.ajax({
        method:'post',
        url:'/route/show_farryman_ajax',
        data:{city_name:$(this).val()},
        error:function(){
            alert('error');
        },
        success:function(data){
            Show_all.html(data);
        }
    }); //end ajax
})
$('.load_trans').click(function(){
    var Week_id = $(this).prev('.week_id').text();
    var Farry_id = $(this).parent('.count').find('.farryman_id');
    var All_busses =  $(this).next('.all_buses');
    $.ajax({
        method:'post',
        url:'/route/show_farryman_bus',
        data:{id:Farry_id.val()},
        error:function(){
            alert('error');
        },
        success:function(data){
           All_busses.html(data);
            startDate(Week_id);
            
        }
    }); //end ajax
    return false;
})

function startDate(week_id){
    $.ajax({
        method:'post',
        url:'/route/route_dates',
        data:{week_id:week_id},
        error:function(){
            alert('error__');
        },
        success:function(data){
           $('.show_all_dates').html(data);
            
        }
        });
}

$('.chak_all').click(function(){
    $(this).parent('.count').find('.show_all_dates input').attr('checked','checked');
})


</script>