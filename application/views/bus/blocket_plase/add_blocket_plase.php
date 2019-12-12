<?$lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
?>







<div class="container container-fixed-lg">
  <div class="row">
        <!-- START PANEL -->
        <div class="col-md-12">
        <!-- START PANEL -->
        <div class="panel panel-default">
        <div class="panel-heading">
        <div class="panel-title"><?=__("Block places")?>
        </div>
        </div>
        <div class="panel-body">
        <div class="row">
        <div class="col-md-6 no-padding">
            <br />
            <?// print_r($edit_group);?>
            
            <div class="form-group">
                <label class="form-label"><?=__("A list of routes")?></label>
                <div class="controls">
                <select name="" class="route_name_main form-control ">
                    <option value=""> <?=__("Select")?> </option>
                    <? foreach($routes as $route){?>
                    <option value="<?=$route['route_name_id'];?>"><?=$route['name_i18n'];?></option>
                    <?}?>
                </select>
                </div>
            </div>
            
            
            <input type="hidden" class="from" value="<?=$from;?>" />
            <input type="hidden" class="to" value="<?=$to;?>" />
            
        
        </div>
        
        <div class="clearfix"></div>
        
        
        <div class="main_hide_block" style="display: none;">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label"><?=__("Carrier")?></label>
                    <div class="controls">
                    <select name="" class="ferryman form-control ">
                    </select>
                    </div>
                </div>
            </div>
             <div class="col-md-12">&nbsp;</div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label><?=__("From whence")?></label>
                    <select name="ost_from" class="form-control from_sel" >
                        <option value="Id"></option>
                    </select>                
                </div>
            </div>       
            <div class="col-sm-3">
                <div class="form-group">
                    <label><?=__("Where")?></label>
                    <select name="ost_to" class="form-control to_sel"  >
                        <option value="Id"></option> 
                    </select>                 
                </div>
            </div>  
            
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-6">
            
            
            
            <div class="radio radio-success">
            <input type="radio" id="yes" name="day" value="day" checked="checked" class="week_or_day">
            <label for="yes"><?=__("Select a day")?></label>
            <input type="radio" id="no" name="day" value="week" class="week_or_day">
            <label for="no"><?=__("Weeks")?></label>
            </div>
            
            
            </div>
            
            <div class="clearfix"></div>
            
            
            <div class="col-md-6 day_block" >
            <label><?=__("Select a day")?></label>
            <div class="row-fluid">
            <input name="desc_i18n" id="datepicker_sell" type="text" class="datepicker_sell filds-ost-desc form-control route_date inp" placeholder=""  value="" />
            </div>
            </div>
            <div class="col-md-12 week_block" style="display: none;">
            
            <div class="form-group">
            <label><?=__("Select day of the week")?></label>
            
            </div>
            
            
            
            <div data-toggle="buttons" class="btn-group">
            <label class="btn btn-complete">
            <input type="radio" id="option1" name="options"  class="day_cron" value="1"> <? echo __('Monday');?>
            </label>
            <label class="btn btn-complete">
            <input type="radio" id="option2" name="options"  class="day_cron" value="2"> <? echo __('Tuesday');?>
            </label>
            <label class="btn btn-complete">
            <input type="radio" id="option3" name="options"  class="day_cron" value="3"> <? echo __('Wensday');?>
            </label>
            <label class="btn btn-complete">
            <input type="radio" id="option3" name="options"  class="day_cron" value="4"> <? echo __('Thursday');?>
            </label>
            
            <label class="btn btn-complete">
            <input type="radio" id="option3" name="options"  class="day_cron" value="5"> <? echo __('Friday');?>
            </label>
            
            <label class="btn btn-complete">
            <input type="radio" id="option3" name="options"  class="day_cron" value="6"> <? echo __('Saturday');?>
            </label>
            
            
            <label class="btn btn-complete">
            <input type="radio" id="option3" name="options"  class="day_cron" value="0"> <? echo __('Sunday');?>
            </label>
            </div>
            
            
            
            <div class="row m-t-20">
            
            
            </div>
            
            
            
            </div>
            <div class="col-md-12">&nbsp;</div>
            
            <div class="col-md-12">                           
            <div role="alert" class="alert alert-info">
            <button data-dismiss="alert" class="close"><i class="fa fa-unlock-alt" title="<? echo __('Unblock');?>"></i></button>
            <div class="info_blocket_block"></div>
            <strong>
            <? echo __('Place');?>: 
            <div class="main_plases_block">
            <span class="admin_plases"></span>
            </div> 
            </strong>
            </div>   
            </div>
            
            
            <div class="col-md-12">
            
            <div class="salon col-md-12"></div>
            <div class="col-sm-2"><span class="fer_sell item-count animate-number semi-bold"></span></div>
            </div>
            
            <div class="form-group col-md-12">
            <label class="form-label"></label>
            <div class="controls">
            <button class="btn btn-complete btn-cons save_blocket_plase"><?=__("Block")?></button>
            <button class="btn btn-default btn-cons"><?=__("Close")?></button>
            </div>
            </div>
            
        </div> <!-- end main_hide_block -->
        
        </div>
        
        
        
        </div>
        </div>
        </div>
<!-- END PANEL -->
              </div>
              
            </div>
  </div>









<script type="text/javascript">
$('.save_blocket_plase').click(function(){
    var array_plases = [];
    $('.main_plases_block .selected_plase').each(function(){
        array_plases.push($(this).html());
    })
    
    var day_week = $('.week_or_day:checked').val();
    
    var week_id = $('.day_cron:checked').val();
    if(week_id == undefined){
        week_id = 1;
    }
    //alert(week_id);
    $.ajax({
            type: "POST",
            url: "/tiket/ajax_newblocket_plases",
            data: {plases:array_plases,day_week:day_week,date:$('#datepicker_sell').val(),route:$('.route_name_main').val(),sesuser:$('.sesuser').val(),ferryman:$('.ferryman').val(),buses:$('.buses').val(),week_id:week_id},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                ///writeCall(data);
                //SchemaHTml = data;
                location="/api/test_newblock_cron";
                
            },
            error:function(code, opt, err){
                alert("Ошибка : save_blocket_plase ajax_blocket_plases");
            },
       });
})

$('.day_cron').change(function(){
         $('.salon').html('');
        
        var RouteNameID = $('.route_name_main').val();
        var SchemaHTml = '';
        var From = $('.from').val();
        var To = $('.to').val();
        
        //alert(To);
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_blocket_plase_schema_svitgo_week",
            data: {route_name_id:RouteNameID,from:From,to:To,rice:1,day_week:$(this).val()},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                ///writeCall(data);
                SchemaHTml = data;
                
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_schema_svitgo ajax_blocket_plase_schema_svitgo_week");
            },
       });
       
  
  $('.salon').html(SchemaHTml);
  
        
        $('.date_from_schema_end').val('');
        
        
        $('.sell_rice').show(); 
        
        $('.open_on').attr('disabled',true);  
        
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_chek_newblocket_plase_week",
            data: {route_name_id:RouteNameID,date:$(this).val(),buses:$('.buses').val(),ferryman:$('.ferryman').val()},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                $('.info_blocket_block').html(data);
                //Top = data;
            },
            error:function(code, opt, err){
                alert("Ошибка : /buses/ajax_chek_newblocket_plase");
            },
            complete: function(){
                //ajax_animation_stop();
                //$("body").css('display','block');
                //alert('ok');
            }
       });
        

})
/*
$('.route_name_main').change(function(){
    if($(this).val() != ''){
        $('.main_hide_block').show();
         $('.salon').html('');
         $.ajax({
                type: "POST",
                url: "/buses/ajax_get_first_ost",
                data: {route_name_id:$(this).val()},
                async: false,
                success: function(data) {
                    var newnew = data.split(',');
                    //alert(data);
                    //exit;
                    ///writeCall(data);
                    //SchemaHTml = data;
                    $('.from').val(newnew[0]);
                    $('.to').val(newnew[1]);
                    
                },
                error:function(code, opt, err){
                    alert("Ошибка : ajax_see_schema_svitgo /buses/ajax_get_first_ost");
                },
           });
     }else{
        $('.main_hide_block').hide();
     }
})
*/
$('.farryman').change(function(){
    if($(this).val() != ''){
        $('.main_hide_block').show();
    }
})

$('.route_name_main').change(function(){ 
    
    $('.ajax_load').show();
    
    var ParBlo = $(this).parents('.sell_form');
    if($(this).val() != ''){
    $('.main_hide_block').show();
         $('.salon').html('');
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            var Select = "<option value=''> - </option>";
            Select += data;
            $('.from_sel').html(Select);
            //$('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_route_ost_last",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            //$('.from_sel').html(data);
            $('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            //alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    
    $.ajax({
        type: "POST",
        url: "/buses/ajax_get_route_farrymans",
        data: {route_name_id:$(this).val(),lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            //$('.from_sel').html(data);
            //$('.to_sel').html(data);
            //$('.return_from_sel').html(data);
            //$('.return_to_sel').html(data);
            $('.ferryman').html(data);
            ///alert(data);
        },
        error:function(){
            alert('write error route_name_main');
        }
    });
    }
    // }else{
    //    $('.main_hide_block').hide();
    // }
   // ajax_animation_stop();
   setTimeout(HideAnimm,100);
    
})

$('.to_sel').change(function(){
    $('.to').val($(this).val());
})

$('.from_sel').change(function(){
    
    $('.ajax_load').show();    
    var RoutName = $('.route_name_main').val();
    $.ajax({
    type: "POST",
    url: "/tiket/ajax_get_route_ost_weight",
    data: {route_name_id:RoutName,ost:$(this).val(),lang:$("#cur_lan").val()},
    success: function(data) {
    //$('.from_sel').html(data);
     var Select = "<option value=''> - </option>";
    Select += data;
    $('.to_sel').html(Select);
    
    //alert(data);
    },
    error:function(){
    alert('ошибка from_sel');
    }
    });

    setTimeout(HideAnimm,100);
    
    $('.from').val($(this).val());

})


$("#datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    //showButtonPanel: true,
    onSelect: function (dateText, inst) {
        
        
        $('.salon').html('');
        $('.ajax_load').show();
        
        //$('.ajax_load').hide,1000);     
        //sleep(1000);
        
        $('.one_people').remove();
        $('.al').text('');
        $('.al_bascet').text('');
        $('.top_val').text('');
                
        
        $('#ui-datepicker-div').hide();
        var RouteNameID = $('.route_name_main').val();
        var SchemaHTml = '';
        var From = $('.from_sel').val();
        var To = $('.to_sel').val();
        
        //alert(To);
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_blocket_plase_schema_svitgo",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                ///writeCall(data);
                SchemaHTml = data;
                
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_schema_svitgo /buses/ajax_see_schema_svitgo");
            },
       });
        
       var ricee = ''; 
        $.ajax({
            type: "POST",
            url: "/buses/ajax_get_sell_rice",
            data: {route_name_id:RouteNameID,date:dateText,from:From},
            async: false,
            success: function(data) {
                ricee = data
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_get_sell_rice");
            }
       });
       
       
       //alert(ricee); 
      $('.sell_rice').html(ricee);  
      //exit;  
        
       // $('.animation_ajax').hide();
      ///////////  arive
        
        var Top = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_see_route_arive",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,lang:$("#cur_lan").val(),rice:1},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                Top = data;
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_route_arive");
            },
            complete: function(){
                //ajax_animation_stop();
                //$("body").css('display','block');
                //alert('ok');
            }
       });
       var newTop = Top.split(',');
       $('.bus_sell').text(newTop[0]);
       $('.bus_sell_from').text(newTop[1]);
       $('.bus_sell_to').text(newTop[2]);
       $('.fer_sell').text(newTop[3]);
       $('.platform_from').text(newTop[4]);
       $('.platform_to').text(newTop[5]);
       $('.free_plase').text(newTop[6]);
       $('.biz_plase').text(newTop[7]);
       
       
       //alert(newTop[10]);
     ///////////  depart 
        $('.fix_block').hide();
        
        /////////enter schema 
        
        //if(newTop[1].length == 11 || newTop[2].length == 11){
        //    $('.salon').html("<? echo "<h4>".__("Contact your administrator.")."<br />".__("Error")."<br />".__("№ 2055")."!<h4>";?>");
        //}else {
            $('.salon').html(SchemaHTml);
            var Op = $('.open_on:checked').val();
            if(Op == 'on'){ 
                $('#open_tik').show();
            }else{
                $('.bat_sell_modall').show();
                $('#order_tik').show();
            }
         ///   $('.bottom_block_sell').show();
        //}  
        
        
        $('.date_from_schema_end').val(newTop[10]);
        
        
        $('.sell_rice').show(); 
        
        $('.open_on').attr('disabled',true);  
        
        
        $.ajax({
            type: "POST",
            url: "/buses/ajax_chek_newblocket_plase",
            data: {route_name_id:RouteNameID,date:$('.date_from_schema').val(),buses:$('.buses').val(),ferryman:$('.ferryman').val()},
            async: false,
            success: function(data) {
                //alert(data);
                //exit;
                $('.info_blocket_block').html(data);
                //Top = data;
            },
            error:function(code, opt, err){
                //alert("Ошибка : /buses/ajax_chek_newblocket_plase");
            },
            complete: function(){
                //ajax_animation_stop();
                //$("body").css('display','block');
                //alert('ok');
            }
       });
        
        //();
        setTimeout(HideAnimm,100);

    }, // end selected date
});

$('.route_date').focus(function(){
    //ajax_animation_start();
    //setTimeout(getDate,10);
    //var start = new Date();
    getDate();
    //var end = new Date();
    //alert('Скорость ' + (end.getTime()-start.getTime()) + ' мс');    
    
})

function getDate(){
     var RouteNameID = $('.route_name_main').val();
     var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only_blocket_plase",
            data: {route_name_id:RouteNameID,from:$('.from_sel').val(),fer:$('.ferryman').val()},
            async: false,
            success: function(data) {
                
                Artex = data;
                //alert(data);
                //exit; 
            },
            error:function(){
                alert('ошибка записи step_3');
            }
            
       });
      
       var arr = Artex.split(',');
       
       
       
    //var ii = 1;
    var iii = 0;
    $('.ui-datepicker-group a').each(function(){
        
        var textT = $(this).text();
        if(textT.length == 1){
            textT = '0'+textT;
        }
        var HTMLL = $(this);
        var mons = $(this).parent().data('month');
            mons += 1;
            mons = '0'+mons;
        if(mons == '010'){
            mons = '10';
        }
        if(mons == '011'){
            mons = '11';
        }
        if(mons == '012'){
            mons = '12';
        } 
        var earT = $(this).parent().data('year');
        var Full = earT+'-'+mons+'-'+textT;
        //alert(Full);
        //alert(arr[0]);
        //exit;
        for(var st = 0; st<=Artex.length; st++){
            if(arr[st] == Full){
                HTMLL.addClass('ui-state-active');
            }
        }
        //alert(Full);
        //exit;
        //}
        iii++;
    })
    
    
    
    $('.ui-datepicker-group a').each(function(){
        var HTMLL = $(this);
        if(!HTMLL.hasClass("ui-state-active")){
            HTMLL.parent().addClass('ui-datepicker-unselectable ui-state-disabled');
        }
    })
}


$('.sellect_all').click(function(){
    $('.fer_con').find('.discounts').attr('checked',true);
})
$('.week_or_day').change(function(){
    $('.salon').html('');
    if($(this).val() == 'week'){
        $('.day_block').hide();
        $('.week_block').show();
        
        var cron_dates = [];
        var RouteNameID = $('.route_name_main').val();
        var Artex = '';
        $.ajax({
            type: "POST",
            url: "/buses/ajax_get_cron_dates",
            data: {route_name_id:RouteNameID},
            async: false,
            success: function(data) {
                
                Artex = data;
                
            },
            error:function(){
                alert('ошибка записи step_3');
            }
            
       });
     var arr = Artex.split(',');
     
     $('.day_cron').each(function(){
        var day_val = $(this).val();
        var thiss = $(this);
        for(var st = 0; st<=Artex.length; st++){
            if(arr[st] == day_val){
                thiss.parent().addClass('noHide');
                //alert(day_val);
            }
        }
     })
     
     $('.day_cron').each(function(){
        if(!$(this).parent().hasClass('noHide')){
            $(this).parent().hide();
        }
     })
     
        
    }else{
        $('.day_block').show();
        $('.week_block').hide();
    }
})

function HideAnimm(){
    $(".ajax_load").hide();
}
</script>