<style>
#ui-datepicker-div {
padding: 0px;
background: #fff;
border: 1px solid #ddd;
width: 260px !important;
}
.ui-corner-all {
    
}
.noValid {
    border: 1px solid red !important;
}
.noValid_empty {
    border: 1px solid red !important;
}
.novalcheck {
    color: red !important;
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
                            <?if(!empty($_GET)){?>
                            <div class="route_nav">
                                <a href="/roz/add_route_step_1?id=<?=$_GET['id'];?>" class="activ"><?=__("Info")?></a>
                                <a href="/roz/add_route_step_2?id=<?=$_GET['id'];?>" class=""><?=__("Timetable")?></a>
                                <a href="/roz/add_route_step_3?id=<?=$_GET['id'];?>" class=""><?=__("Date and Carry")?></a>
                                <a href="/roz/add_route_step_4?id=<?=$_GET['id'];?>" class=""><?=__("Price")?></a>
                            </div>
                            <?}?>
                            <div class="padding_center">
                                <div class="col-md-6">
                                    <div class="row">
                                    <form action="/roz/add_route_step_1_new" class="formm" method="post" >
                                    
                                    
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
                                                    <label><? echo __('Blocked');?>:</label>
                                                    <div class="row-fluid">
                                                        <div class="slide-success">
                                                            <input type="checkbox" name="is_validate" class="iosblue" value="1" />
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="update-data-ost">
                                                    <div class="u-ost-colum-a" id="tab_body">
                                                        <div class="ru_tab">
                                                            <input type="hidden" name="old" value="<? if($_GET){ echo $_GET['id'];}?>" />
                                                            <div class="form-group">            
                                                                <label><? echo __('Route ID');?></label>
                                                                <input name="route_id" type="text" class="filds-ost-name_1 form-control valid"  <? if($roz_rou){ ?> disabled="disabled" value="<?=$roz_rou['route_id']?>" <? }else {?> value="<?=$last_rout['route_id'] +1;?>" <?}?> />
                                                            </div>
                                                            <div class="form-group">            
                                                                <label><? echo __('Number');?></label>
                                                                <input name="name" type="text" class="filds-ost-name_1 form-control valid"  value="<?=$roz_rou['name']?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label><? echo __('Name');?></label>
                                                                <input name="name_i18n" type="text" class="filds-ost-name form-control valid"   value="<?=$roz_rou['name_i18n']?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label><? echo __('Typ');?></label>
                                                                <select name="route_type" class="route_type_menu form-control">
                                                                    <option value="1" <? if($roz_rou['route_type'] == 1){ echo 'selected="selected"'; }?>><? echo __('Bus');?></option>
                                                                    <option value="2" <? if($roz_rou['route_type'] == 2){ echo 'selected="selected"'; }?>><? echo __('Train');?></option>
                                                                    <option value="gorod"><? echo __('Гор.транспорт');?></option>
                                                                </select>
                                                                <div class="sub">
                                                                    <select name="route_type_sub" class="route_type_sub_menu form-control" style="display: none;">
                                                                        <option value="3"><? echo __('City Bus');?></option>
                                                                        <option value="4"><? echo __('IC');?></option>
                                                                        <option value="5"><? echo __('Mini Bus');?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><? echo __('Country From');?></label>
                                                                <select name="country_id" class="country_id form-control">
                                                                    <? foreach($all_countrys as $contry){?>
                                                                        <option <? if($roz_rou['country_id'] == $contry['country_id']){ echo 'selected="selected"'; }?> value="<? echo $contry['country_id'];?>"><? echo $contry['name_i18n'];?></option>
                                                                    <?}?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><? echo __('Country Where');?></label>
                                                                <select name="country_id_to" class="country_id form-control">
                                                                    <? foreach($all_countrys as $contry_to){?>
                                                                        <option <? if($roz_rou['country_id_to'] == $contry_to['country_id']){ echo 'selected="selected"'; }?> value="<? echo $contry_to['country_id'];?>"><? echo $contry_to['name_i18n'];?></option>
                                                                    <?}?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><? echo __('Date');?>:</label>
                                                                <div class="time_time input-append success no-padding" style="width: 95%;">
                                                                    <input type="text" value="<?=$roz_rou['time_end']?>" name="time_end" id="time_end" class="form-control valid" />
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
                                            <div class="">
                                                <? if($roz_rou['route_id']){?>
                                                <input type="submit" class="btm-edit btn btn-salat btn-cons" id="edit_ost_button" value="<? echo __('Edit');?>"/>  
                                                <?}else{?>
                                                <input type="button" class="btm-edit btn btn-salat btn-cons" id="add_ost_button" value="<? echo __('Add');?>"/>
                                                <?}?>
                                                <input type="submit" class="btn btn-white btn-cons" id="close_ost_button" value="<? echo __('Close');?>"/>  
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane" id="panel2-2">
                                            <div class="form-group">
                                                <label>Українська</label>
                                                <input name="name_i18n_ua" type="text" class="filds-ost-name ua valid"   value="<?=$roz_rou['name_i18n_ua']?>" />
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="panel2-3">
                                            <div class="form-group">
                                                <label>English</label>
                                                <input name="name_i18n_en" type="text" class="filds-ost-name en valid"   value="<?=$roz_rou['name_i18n_en']?>" />
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="panel2-4">
                                            <div class="form-group">
                                                <label>Čeština</label>
                                                <input name="name_i18n_cs" type="text" class="filds-ost-name cs valid"   value="<?=$roz_rou['name_i18n_cs']?>" />
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

$('.formm').submit(function(){
    if($('#add_ost_button').hasClass('novalcheck')){
        return false;
    }
    //exit;
    
})

$('#add_ost_button').click(function(){
    if($(this).hasClass('novalcheck')){
        exit;
    }else{
        $('.formm').submit();
    }
})

function Validation() {
  
    var PeopCou = [];
    $('.noValid').each(function(){
        PeopCou.push(1);
    });
    if(PeopCou.length != 0){
        //alert('Choice seat!');
        //exit;
        //$('.bottom_block_sell').show();
        $('#add_ost_button').removeClass('novalcheck');
    }
  
  //alert("прошло 3 сек")
  $('.valid').each(function(){
    $(this).removeClass('noValid');
    if($(this).val().length != 0){
        if($(this).hasClass('tel') && $(this).val().length <= 8){
            $(this).addClass('noValid');
            $('#add_ost_button').addClass('novalcheck');
            
        }else{
            
            if($(this).val().length <= 1){
                $(this).addClass('noValid');
                $('#add_ost_button').addClass('novalcheck');
                
            }
        }
        if($(this).hasClass('soname') && $(this).val().length <= 2){
            $(this).addClass('noValid');
            $('#add_ost_button').addClass('novalcheck');
          
        }
        
    }else{
        $(this).addClass('noValid');
        $('#add_ost_button').addClass('novalcheck');

    }
    
  })

}

setInterval(Validation, 1000);


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

