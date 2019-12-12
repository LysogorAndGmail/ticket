<style>
#ui-datepicker-div {
    width: 1040px !important;
    position: absolute;
    display: none !important;
}
#ui-datepicker-div div.ui-datepicker-group{
    float: left !important;
    margin: 10px;
}
.cron_block .no-padding{
    background-color: #e5e5e5 !important;
    margin-bottom: 15px;
}
</style>




<div class="container container-fixed-lg">
   	
       <?   
    $dat = '';
    if(!empty($route_name['start_from'])){ 
        $dat = Date('d/m/Y',strtotime($route_name['start_from'].' 00:00:00'));
        //echo $route_name['start_from'].'<br />';
        //echo $dat;
    }
    
    $d1 = new DateTime("now");
    $d2 = new DateTime($route_name['start_from']);
    $days = $d1->diff($d2)->days;
    $mons = $days/30;
    $roy_mon = round($mons);
    //echo '<pre>';
    //echo 
    //echo '</pre>';
    
    
?>  <input type="hidden" class="rou_mon" value="<?=$roy_mon;?>" />
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step")?> 3</h3>
                            <div class="route_nav">
                                   <a href="/route/edit_route?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Info")?></a>
                                <a href="/route/edit_route2?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Timetable")?></a>
                                <a href="/route/edit_route3?route_name_id=<?=$_GET['route_name_id'];?>" class="activ"><?=__("Date and Carry")?></a>
                                <a href="/route/edit_route4?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Price")?></a>
                            </div>
                            <div class="padding_center col-md-12">
                                <div class="row" style="position: relative;">
                                    <!-- cron block -->
                                    <div class="cron_block">
                                        <div class="col-md-12 no-padding">
                                            <? 
                                            $all_crons = DB::select()->from('cron')->where('route_name_id','=',$_GET['route_name_id'])->execute()->as_array();
                                            
                                        foreach($all_crons as $ron_one){
                                            $cron_fer_name = DB::select()->from('ferryman')->where('ferryman_id','=',$ron_one['ferryman_id'])->execute()->current();
                                         $cron_buses_name = DB::select()->from('buses_i18n')->where('buses_id','=',$ron_one['bus_id'])->and_where('culture','=','ru')->execute()->current();
                                         ?>
                                        <span  class="btn btn-info btn-cons show_cron_dates" data-id="<?=$cron_fer_name['ferryman_id'];?>" data-bus_id="<?=$cron_buses_name['buses_id'];?>" ><? echo $cron_fer_name['name']; ?> <? echo $cron_buses_name['name_i18n']; ?></span>
                                        <a href="/api/del_cron_dates?route_name_id=<?=$route_name['route_name_id']."&fer_id=".$cron_fer_name['ferryman_id']."&bus_id=".$cron_buses_name['buses_id'];?>"><i class="fa fa-times"></i></a><br />
                                        <?}
                                            
                                            
                                            $cron = DB::select()->from('cron')->where('route_name_id','=',$_GET['route_name_id'])->execute()->current();
                                            $cron_days = explode(',',$cron['type']);
                                            
                                           
                                            ?>
                                            <div class="col-md-12">
                                                <p
                                            </div>
                                            <div class="col-md-4">
                                                <label><?=__("Ferryman")?></label>
                                                <select class="cron_ferry form-control" name="">
                                                    <option value=""> - </option>
                                                    <? foreach($all_fer as $f){?>
                                                    <option value="<?=$f['ferryman_id']?>" ><?=$f['name']?></option>
                                                    <?}?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label><?=__("Bus")?></label>
                                                <select class="cron_bus form-control" name="" >
                                                    
                                                </select>
                                             </div>
                                             <div class="col-md-12">&nbsp;</div>
                                             <br />
                                             <div class="col-md-4">
                                                <label><?=__("Days Week")?></label>
                                                <div class="row-fluid">
                                                    <div class="checkbox check-primary">
                                                        <input id="checkbox1" type="checkbox" class="day_cron" value="1">
                                                        <label for="checkbox1"><? echo __('Mon');?></label>
                                                        <input id="checkbox2" type="checkbox" class="day_cron" value="2">
                                                        <label for="checkbox2"><? echo __('Tue');?></label>
                                                        <input id="checkbox3" type="checkbox" class="day_cron" value="3">
                                                        <label for="checkbox3"><? echo __('Wen');?></label>
                                                        <input id="checkbox4" type="checkbox" class="day_cron" value="4">
                                                        <label for="checkbox4"><? echo __('Thu');?></label>
                                                        <input id="checkbox5" type="checkbox" class="day_cron" value="5">
                                                        <label for="checkbox5"><? echo __('Fri');?></label>
                                                        <input id="checkbox6" type="checkbox" class="day_cron" value="6">
                                                        <label for="checkbox6"><? echo __('Sat');?></label>
                                                        <input id="checkbox0" type="checkbox" class="day_cron" value="0">
                                                        <label for="checkbox0"><? echo __('Sun');?></label>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <label>&nbsp;</label>
                                                <button class="btn btn-success btn-cons refresh_cron" ><?=__("Refresh Cron")?></button>
                                            </div>
                                        </div>    
                                    </div>
                                    
                                    
                                    
                                    
                                    <!-- -->
                                    <div class="form-group">
                                        <label><? echo __('Date');?></label>
                                        <div class="time_time input-append success no-padding" style="width: 95%;">
                                            <? $dat = '';
                                            if(!empty($route_name['start_from'])){ 
                                            $dat = Date('d/m/Y',strtotime($route_name['start_from'].' 00:00:00'));
                                            }?>
                                            <input type="text" name="time_end" class="form-control" value="<?=$dat;?>" />
                                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <h3 class="semi-bold rou_tit"><?=__("Ferryman")?></h3>
                                    <div class="form-group">
                                        <? $d_f = array(); foreach($all_dates as $d){
                                            
                                            $d_f[$d['buses_id']] = $d;
                                        }?>
                                        <? foreach($d_f as $dd){ 
                                         $fer_name = DB::select()->from('ferryman')->where('ferryman_id','=',$dd['ferryman_id'])->execute()->current();
                                         $buses_name = DB::select()->from('buses_i18n')->where('buses_id','=',$dd['buses_id'])->and_where('culture','=','ru')->execute()->current();
                                            //echo '<pre>';
                                            //print_r($buses_name);
                                            //echo '</pre>';
                                          ?>
                                        <span  class="btn btn-info btn-cons show_fer_dates" data-id="<?=$dd['ferryman_id'];?>" data-bus_id="<?=$dd['buses_id'];?>" ><? echo $fer_name['name']; ?> <? echo $buses_name['name_i18n']; ?></span>
                                        <a href="/route/del_edit_route3?route_name_id=<?=$route_name['route_name_id']."&fer_id=".$dd['ferryman_id']."&bus_id=".$dd['buses_id'];?>"><i class="fa fa-times"></i></a><br />
                                        <?}?>
                                    </div>
                                    <hr />
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-4">
                                            <label><?=__("Ferryman")?></label>
                                            <select class="ferry form-control" name="fer_id">
                                                <option value=""> - </option>
                                                <? foreach($all_fer as $f){?>
                                                <option value="<?=$f['ferryman_id']?>"><?=$f['name']?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label><?=__("Bus")?></label>
                                            <select class="bus form-control" name="bus_id" >
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
$('.show_cron_dates').click(function(){
    $('.day_cron').each(function(){
        $(this).attr('checked',false);
    })
    var ID = $(this).data('id');
    var BusID = $(this).data('bus_id');
    var Arr = [];
    $.ajax({
        type: "POST",
        url: "/api/ajax_show_cron_dates",
        data: {id:ID,route_name_id:'<?=$_GET['route_name_id'];?>',bus_id:BusID},
        //async: false,
        success: function(data) {
            
           Arr = data.split(','); 
            
           for(var i = 0; i<Arr.length; i++){
                $('.day_cron').each(function(){
                    if($(this).val() == Arr[i]){
                        $(this).attr('checked',true);
                    }
                })
           }
           
            //if(data == Full){
                //alert(HTMLL);
            //    HTMLL.addClass('select');
           //}
            
        },
        error:function(){
            //alert('ошибка записи step_3');
        },
        complete:function(){
            //ajax_animation_stop();
        }
   });  
})
$('.refresh_cron').click(function(){
    //ajax_animation_start();
    //exit;
    var Parent = $(this).parents('.cron_block');
    var Ferss = Parent.find('.cron_ferry').val();
    var Buss = Parent.find('.cron_bus').val();
    if(Buss == null || Ferss == null){
        alert("<?=__('Choise Ferryman and Bus')?>");
        exit;
    }
    var CronDat = [];
    Parent.find('.day_cron:checked').each(function(){
        CronDat.push($(this).val());
    });
    //alert(CronDat);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/api/ajax_refresh_cron",
        data: {step_id:'<?=$route_name['route_name_id'];?>',fer_id:Ferss,bus_id:Buss,type:CronDat},
        success: function(data) {
            //alert(data);
            location="/api/test";
            //location="/route/cron_refresh_info?route_name_id=<?=$route_name['route_name_id']?>";
        },
        error:function(){
            alert('<?=__("Select dey Week!")?>');
        }
   });
   
})
$('.cl').click(function(){
    //ajax_animation_start();
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
        url: "/route/save_edit_route_3",
        data: {step_id:'<?=$route_name['route_name_id'];?>',fer_id:FerID,d_arr:AR,bus:$('.bus').val(),user_choise:UserChoise},
        success: function(data) {
            //alert(data);
            location="/route/edit_route3?route_name_id=<?=$route_name['route_name_id']?>";
        },
        error:function(){
            //alert('ошибка записи step_3');
        }
   });
   //$('.ajax_load').hide();
   //ajax_animation_stop();
})

$('.chek_all').click(function(){
    //ajax_animation_start();
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
    //$('.empty_all').click();
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
    
    //var monss = $('.rou_mon').val();
    
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: GetMan(),
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
    
function GetMan(){
    var intValue = parseInt($('.rou_mon').val());
    return intValue;
}    
    
    
$("#datepicker_roz").datepicker( "show" );
var vitt = $('.white-content').height();
vitt += 50;
//alert(vitt+50);


var nenwn = $('#ui-datepicker-div').height() + vitt;
nenwn += 50;

$('.page-content').css('height',''+ nenwn +'px');

$('#ui-datepicker-div').css('top',''+vitt+'px');

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

$('.cron_ferry').change(function(){
    $.ajax({
        type: "POST",
        url: "/buses/ajax_buses",
        data: {id:$(this).val()},
        success: function(data) {
            $('.cron_bus').html(data);
            //location="/roz/add_route_step_3?id=<?=$route_name['route_name_id']?>";
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})




$('.show_fer_dates').click(function(){
    //ajax_animation_start();
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
                    data: {id:ID,day:Full,route_name_id:<?=$route_name['route_name_id']?>,rice:1,bus_id:BusID},
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
                        //ajax_animation_stop();
                    }
               });  
            })
        })
    })
    //setTimeout(ajax_animation_stop,10);
})
<?                //                echo '<pre>';
                  //                print_r($cron_days);
                  //                echo '</pre>';
                  //                die;
                                    ?>
  
</script>
