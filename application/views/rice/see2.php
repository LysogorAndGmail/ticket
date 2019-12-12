<style>
#ui-datepicker-div {
}
#ui-datepicker-div {
    display: block !important;
}
</style>
<div class="content">    
   	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Rice")?> <span class="rice"><?=$_GET['rice'];?></span></h3>
                            <div class="padding_center col-md-12" style="min-height: 1662px;">
                                <div class="row" style="position: relative;">
                                    <h3 class="semi-bold rou_tit"><?=__("Ferryman")?></h3>
                                    <span class="rice_val" style="display: none;"><?=$_GET['rice'];?></span>
                                    <div class="form-group">
                                        <? $d_f = array(); foreach($all_dates as $d){
                                            $d_f[$d['buses_id']] = $d;
                                        }?>
                                        <? foreach($d_f as $dd){ 
                                         $fer_name = DB::select()->from('ferryman')->where('ferryman_id','=',$dd['ferryman_id'])->execute()->current();
                                         $buses_name = DB::select()->from('buses_i18n')->where('buses_id','=',$dd['buses_id'])->and_where('culture','=','ru')->execute()->current();
                                          ?>
                                            <span  class="btn btn-info btn-cons show_fer_dates" data-id="<?=$dd['ferryman_id'];?>" data-bus_id="<?=$dd['buses_id'];?>" ><? echo $fer_name['name']; ?> <? echo $buses_name['name_i18n']; ?></span>
                                            <a href="/rice/del_see2?route_name_id=<?=$route_name['route_name_id']."&fer_id=".$dd['ferryman_id']."&bus_id=".$dd['buses_id']."&rice=".$_GET['rice'];?>"><i class="fa fa-times"></i></a><br />
                                        <?}?>
                                    </div>
                                    <hr />
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-4">
                                            <label><?=__("Ferryman")?></label>
                                            <select class="ferry form-control" name="fer_id">
                                                <? foreach($all_fer as $f){?>
                                                <option value="<?=$f['ferryman_id']?>"><?=$f['name']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label><?=__("Bus")?></label>
                                            <select class="bus form-control" name="bus_id" >
                                                <? foreach($all_bus as $b){
                                                $bus_name = DB::select()->from('buses_i18n')->where('buses_id','=',$b['buses_id'])->and_where('culture','=','ru')->execute()->current();
                                                ?>
                                                <option value="<?=$b['buses_id']?>"><?=$bus_name['name_i18n']?></option>
                                                <?}?>
                                            </select>
                                         </div>
                                         <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-success btn-cons cl mer_bot" ><?=__("Add")?></button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                    <hr />
                                    <div class="t-step-date">
                                        <span class="chek_all btn btn-danger btn-cons"><? echo __('Select all');?></span>
                                        <span class="empty_all btn btn-warning btn-cons"><? echo __('Clean all');?></span>
                                        <span class="even btn btn-warning btn-cons"><? echo __('Even');?></span>
                                        <span class="odd btn btn-warning btn-cons"><? echo __('Odd');?></span>
                                        <span class="day" data-week="0"><a><? echo __('Mon');?></a></span>
                                        <span class="day" data-week="1"><a><? echo __('Tue');?></a></span>
                                        <span class="day" data-week="2"><a><? echo __('Wen');?></a></span>
                                        <span class="day" data-week="3"><a><? echo __('Thu');?></a></span>
                                        <span class="day" data-week="4"><a><? echo __('Fri');?></a></span>
                                        <span class="day" data-week="5"><a><? echo __('Sat');?></a></span>
                                        <span class="day" data-week="6"><a><? echo __('Sun');?></a></span>
                                        <input type="hidden" class="user_choise" value="" />
                                    </div>
                                    <input type="text" id="datepicker_roz" style="visibility: hidden;" disabled="disabled" />
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

$('.cl').click(function(){
    ajax_animation_start();
    //exit;
    var UserChoise = $('.user_choise').val();
    //alert(UserChoise);
    //exit;
    var AR = [];
    $('a.select').each(function(){
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
        var ear = $(this).parent().data('year');
        var num = $(this).text();
        if(num.length == 1){
            num = '0'+num;
        }
        var Full = ear+'-'+mons+'-'+num;
        AR.push(Full); 
    })
    var FerID = $('.ferry').val();
    $.ajax({
        type: "POST",
        url: "/rice/add_rice_ajax_2_new",
        data: {step_id:'<?=$route_name['route_name_id'];?>',fer_id:FerID,d_arr:AR,bus:$('.bus').val(),rice:$('.rice_val').text()},
        success: function(data) {
            //alert(data);
            location="/rice/see2?route_name_id=<?=$_GET['route_name_id'];?>&rice=<?=$_GET['rice'];?>";
        },
        error:function(){
            alert('ошибка add_rice_ajax_2');
        }
   });
   //$('.ajax_load').hide();
   ajax_animation_stop();
})

$('.chek_all').click(function(){
    ajax_animation_start();
    $('a.ui-state-default').each(function(){
        $(this).addClass('select');
    })
    $('.user_choise').val("all");
    ajax_animation_stop();
    
})
$('.empty_all').click(function(){
    $('a.ui-state-default').each(function(){
        $(this).removeClass('select');
    })
    $('.user_choise').val("");
})
$('.day').click(function(){
    $('.empty_all').click();
    var WeeK = $(this).data('week');
    $('.user_choise').val($(this).data('week'));
    $('.ui-datepicker-group').each(function(){
        $(this).find('tr').each(function(){
            $(this).find('td').each(function(i){
                if(i == WeeK){
                    $(this).find('a').addClass('select');
                }
            })
        })
    })
    
})
$('.even').click(function(){
    $('.empty_all').click();
    $('.ui-datepicker-group').each(function(){
        $(this).find('tr').each(function(){
            $(this).find('a').each(function(){
                if( $(this).text() % 2 ){
                    $(this).addClass('select');
                }
                //alert($(this).html());
                //exit;
            })
        })
    })
    $('.user_choise').val("even");
})
$('.odd').click(function(){
    $('.empty_all').click();
    $('.ui-datepicker-group').each(function(){
        $(this).find('tr').each(function(){
            $(this).find('a').each(function(){
                if( $(this).text() % 2 ){
                    
                }else{
                    $(this).addClass('select');
                }
                //alert($(this).html());
                //exit;
            })
        })
    })
    $('.user_choise').val("odd");
})

$("#datepicker_roz").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {
        //inst.inline = false;
        //$(".ui-datepicker-calendar .ui-datepicker-current-day").removeClass("ui-datepicker-current-day").children().removeClass("ui-state-active").addClass('select');
        //console.log(inst);
        // Your CSS changes, just in case you still need them
        //$('a.ui-state-default').removeClass('ui-state-highlight');
        
        //$(this).addClass('select');
        //alert('her');
    },
    });
    
$("#datepicker_roz").datepicker( "show" );

$(document).ready(function(){
/*    
function isert_line(){
    $('.ui-datepicker-group').each(function(i){
        if(i == 1){
            $('<hr>').insertAfter($(this).next('.ui-datepicker-group'));
        }
        if(i == 4){
            $('<hr>').insertAfter($(this).next('.ui-datepicker-group'));
        }
        if(i == 7){
            $('<hr>').insertAfter($(this).next('.ui-datepicker-group'));
        }
    })
}
isert_line();
*/
///////////////

$('.ui-state-default').click(function(){
    if($(this).parent().find('a.select').html() == null){
        $(this).addClass('select');
    }else{
        $(this).removeClass('select');
    }
    //$(this).addClass('select');
})
//////////////
}) 

$('.ferry').change(function(){
    $.ajax({
        type: "POST",
        url: "/buses/ajax_buses",
        data: {id:$(this).val()},
        success: function(data) {
            $('.bus').html(data);
            //location="/roz/add_route_step_3?id=<?=$route_name['route_name_id']?>";
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})

$('.show_fer_dates').click(function(){
    ajax_animation_start();
    var ID = $(this).data('id');
    $('.ui-datepicker-group').each(function(){
        $(this).find('tr').each(function(){
            $(this).find('a').each(function(){
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
                //exit;
                $.ajax({
                    type: "POST",
                    url: "/route/ajax_fer_dates",
                    data: {id:ID,day:Full,route_name_id:<?=$route_name['route_name_id']?>,rice:$('.rice').text()},
                    //async: false,
                    success: function(data) {
                        
                        if(data == Full){
                            //alert(HTMLL);
                            HTMLL.addClass('select');
                        }
                        
                    },
                    error:function(){
                        //alert('ошибка записи step_3');
                    },
                    complete:function(){
                        ajax_animation_stop();
                    }
               });  
            })
        })
    })
    //setTimeout(ajax_animation_stop,10);
})


$('.show_fer_dates').click(function(){
    ajax_animation_start();
    var ID = $(this).data('id');
    var BusID = $(this).data('bus_id');
    $('.ui-datepicker-group').each(function(){
        $(this).find('tr').each(function(){
            $(this).find('a').each(function(){
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
                //exit;
                $.ajax({
                    type: "POST",
                    url: "/route/ajax_fer_dates",
                    data: {id:ID,day:Full,route_name_id:<?=$route_name['route_name_id']?>,rice:$('.rice_val').text(),bus_id:BusID},
                    //async: false,
                    success: function(data) {
                        
                        if(data == Full){
                            //alert(HTMLL);
                            HTMLL.addClass('select');
                        }
                        
                    },
                    error:function(){
                        //alert('ошибка записи step_3');
                    },
                    complete:function(){
                        ajax_animation_stop();
                    }
               });  
            })
        })
    })
    //setTimeout(ajax_animation_stop,10);
})

  


</script>
