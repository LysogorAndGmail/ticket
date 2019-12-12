<style>
#ui-datepicker-div {
padding: 0px;
background: #fff;
border: 1px solid #ddd;
width: 260px !important;
}
.ui-corner-all {
    
}
</style>
<div class="container container-fixed-lg">
 
  <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step")?> 1</h3>
                            <div class="route_nav">
                                <a href="/route/edit_route?route_name_id=<?=$_GET['route_name_id'];?>" class="activ" ><?=__("Info")?></a>
                                <a href="/route/edit_route2?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Timetable")?></a>
                                <a href="/route/edit_route3?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Date and Carry")?></a>
                                <a href="/route/edit_route4?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Price")?></a>
                            </div>
                            <div class="padding_center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <form action="" id="add_route_form for" method="post" >
                                            <ul data-init-reponsive-tabs="dropdownfx" class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs">
                                                <li class="active">
                                                    <a href="#panel2-1" data-toggle="tab"><span>RU</span></a>
                                                </li>
                                                <li>
                                                    <a href="#panel2-2" data-toggle="tab"><span>UK</span></a>
                                                </li>
                                                <li>
                                                    <a href="#panel2-3" data-toggle="tab"><span>EN</span></a>
                                                </li>
                                                <li>
                                                    <a href="#panel2-4" data-toggle="tab"><span>CS</span></a>
                                                </li>
                                            </ul>
                                    
                                            <div class="tab-content">
                                            <div id="panel2-1" class="tab-pane active">
                                                    <div class="left-padding-content filds-ost form-vertical">
                                                        <div class="form-group">
                                                            <label><? echo __('Blocked');?></label>
                                                            <!--<div class="radio">
                                                            <input name="is_validate" id="male" value="1" type="radio" <? if($route_name['is_public'] == 1){ echo 'checked="checked"';}?> />
                                                            <label for="male"><? echo __('Yes');?></label>
                                                            <input name="is_validate" id="female" type="radio" value="0" <? if($route_name['is_public'] == 0){ echo 'checked="checked"';}?>  />
                                                            <label for="female"><? echo __('No');?></label>
                                                            </div>
                                                             -->
                                                            <div class="row-fluid">
                                                                <div class="slide-success">
                                                                    <input type="checkbox" name="is_validate" value="1" <? if($route_name['is_public'] == 1){ echo 'checked="checked"';}?>/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="update-data-ost">
                                                            <div class="u-ost-colum-a" id="tab_body">
                                                                <div class="ru_tab">
                                                                    <div class="form-group">            
                                                                        <label><? echo __('Route ID');?></label>
                                                                        <input name="route_id" type="text" class="filds-ost-name_1 form-control" value="<?=$route_name['route_id'];?>" />
                                                                    </div>
                                                                    <div class="form-group">            
                                                                        <label><? echo __('Number');?></label>
                                                                        <input name="name" type="text" class="filds-ost-name_1 form-control" value="<?=$route_name['name'];?>" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><? echo __('Name');?></label>
                                                                        <input name="name_i18n" type="text" class="filds-ost-name form-control" value="<?=$route_name['name_i18n'];?>" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><? echo __('Typ');?></label>
                                                                        <select name="route_type" class="form-control route_type_menu">
                                                                        <option value="1" <? if($route_name['types'] == 1){ echo 'selected="selected"'; }?>><? echo __('Bus');?></option>
                                                                        <option value="2" <? if($route_name['types'] == 2){ echo 'selected="selected"'; }?>><? echo __('Train');?></option>
                                                                        <option value="gorod"><? echo __('Public Transport');?></option>
                                                                        </select>
                                                                        <div class="sub">
                                                                        <select name="route_type_sub" class="form-control route_type_sub_menu" style="display: none;">
                                                                        <option value="3"><? echo __('Bus');?></option>
                                                                        <option value="4"><? echo __('IC');?></option>
                                                                        <option value="5"><? echo __('Mini Bus');?></option>
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><? echo __('Country From');?></label>
                                                                        <select name="country_id" class="form-control country_id">
                                                                        <? foreach($all_countrys as $contry){?>
                                                                        <option <? if($route_name['country_id'] == $contry['country_id']){ echo 'selected="selected"'; }?> value="<? echo $contry['country_id'];?>"><? echo $contry['name_i18n'];?></option>
                                                                        <?}?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><? echo __('Country Where');?></label>
                                                                        <select name="country_id_to" class="form-control country_id">
                                                                        <? foreach($all_countrys as $contry_to){?>
                                                                        <option <? if($route_name['country_to_id'] == $contry_to['country_id']){ echo 'selected="selected"'; }?> value="<? echo $contry_to['country_id'];?>"><? echo $contry_to['name_i18n'];?></option>
                                                                        <?}?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><? echo __('Date');?></label>
                                                                        <div class="time_time input-append success no-padding" style="width: 95%;">
                                                                            <? $dat = '';
                                                                            if(!empty($route_name['start_from'])){ 
                                                                            $dat = Date('d/m/Y',strtotime($route_name['start_from'].' 00:00:00'));
                                                                            }?>
                                                                            <input type="text" name="time_end" id="time_end" class="form-control" value="<?=$dat;?>" />
                                                                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="space-small"></div>    
                                                    </div>
                                                    <div class="update-ost-btm">
                                                        <input type="submit" class="btn btn-salat btn-cons" id="edit_ost_button" value="<? echo __('Save');?>"/>
                                                        <input type="submit" class="btn btn-white btn-cons" id="close_ost_button" value="<? echo __('Close');?>"/>  
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="panel2-2">
                                                    <div class="form-group">
                                                        <label><? echo __('UA');?>:</label>
                                                        <input name="name_i18n_ua" type="text" class="form-control filds-ost-name ua" value="<?=$name_i18n_ua['name_i18n'];?>" />
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="panel2-3">
                                                    <div class="form-group">
                                                        <label><? echo __('EN');?>:</label>
                                                        <input name="name_i18n_en" type="text" class="form-control filds-ost-name en"   value="<?=$name_i18n_en['name_i18n'];?>" />
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="panel2-4">
                                                    <div class="form-group">
                                                        <label><? echo __('CS');?>:</label>
                                                        <input name="name_i18n_cs" type="text" class="form-control filds-ost-name cs"   value="<?=$name_i18n_cs['name_i18n'];?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
$(document).ready(function(){
    $("#time_end").datepicker({
        <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
        minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        //showOtherMonths: true,
        selectOtherMonths: true
    });
/////////////
})
$('.route_type_menu').change(function(){
    var Vl = $(this).val();
    if(Vl == 'gorod'){
        $('.sub').find('.route_type_sub_menu').show();
    }else{
        $('.sub').find('.route_type_sub_menu').hide();
    }
})
$('#add_ost_button').click(function(e){
    if($('.ua').val().length == 0 || $('.en').val().length == 0 || $('.cs').val().length == 0){
        e.preventDefault();
        alert('Не заполнены поля с переводами!');
    }
})
</script>

