<div class="container container-fixed-lg">
 
  <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step")?> 2</h3>
                            
                            <div class="alert" style="display: none;">
                  <button class="close" data-dismiss="alert"></button>
                  Saved </div>
                            
                            <div class="route_nav">
                                <a href="/roz/add_route_step_1?id=<?=$_GET['id'];?>" class=""><? echo __('Info');?></a>
                                <a href="/roz/add_route_step_2?id=<?=$_GET['id'];?>" class="activ"><? echo __('Timetable');?></a>
                                <a href="/roz/add_route_step_3?id=<?=$_GET['id'];?>" class=""><? echo __('Date and Carry');?></a>
                                <a href="/roz/add_route_step_4?id=<?=$_GET['id'];?>" class=""><? echo __('Price');?></a>
                            </div>
                            <div class="col-md-12 no-padding par">
                                <div class="col-md-12 no-padding">
                                    <span class="in_af"></span>
                                    <h2 class="rou_tit"><?=$roz_rou['name'];?> - <?=$roz_rou['name_i18n'];?></h2>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="grey">
                                        <div class="form-group col-md-6 no-padding">
                                            <label><? echo __('Station or City');?></label>
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
                                <div class="col-md-12 no-padding">
                                    <table class="table table-striped table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><? echo __('Id');?></th>
                                                <th><? echo __('Station');?></th>
                                                <th><? echo __('Platform');?></th>
                                                <th><? echo __('Mon');?></th>
                                                <th><? echo __('Tue');?></th>
                                                <th><? echo __('Wen');?></th>
                                                <th><? echo __('Thu');?></th>
                                                <th><? echo __('Fri');?></th>
                                                <th><? echo __('Sat');?></th>
                                                <th><? echo __('Sun');?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="so"> 
                                            <? $i=1; foreach($all_ost as $ost){?>              
                                                <tr>        
                                                    <td>
                                                        <span><?=$ost['ost_id'];?></span>
                                                    </td>                    
                                                    <td>
                                                        <?=$ost['ost_name'];?> - <?=$ost['ost_city'];?>
                                                    </td>
                                                    <td>
                                                        <input name="platform" type="text" class="platform" value="<?=$ost['platform'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['po'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['po_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['vt'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['vt_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['sr'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['sr_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['ch'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['ch_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['pi'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['pi_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['su'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['su_from'];?>"/>
                                                    </td>
                                                    <td>
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['vo'];?>"/><br />
                                                        <input name="time" type="text" class="t-t-input custom_time" value="<?=$ost['vo_from'];?>"/>
                                                    </td>
                                                    <td><img onclick="DelSVZ(<?=$ost['ost_id'];?>)" src="<?=Kohana::$base_url?>img/ui/delete-grey.png" width="12" height="12" /></td>
                                                </tr>
                                            <? $i++; }?>  
                                        </tbody>
                                    </table>  
                                </div>         
                                <div class="col-md-12 no-padding" style="background-color: #fff;">  
                                    <div class="pull-left">
                                    <button class="btn btn-salat btn-cons save_weight small"><? echo __('Save order');?></button> 
                                    <button class="btn btn-white btn-cons save_step small"><? echo __('Save');?></button>   
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
//////////////

$('.new_join').keyup(function(){
    //alert('h');
    $.ajax({
      type: "POST",
      url: "/roz/ajax_ost_join",
      data: { ost_name: $(this).val() }
            }).error(function(){
                alert('ошибка ajax остановки!');
            }).success(function(data) {
                if(data != 1) {
                    $('#show_ost').html(data);
                }
        });
})

$('.add_to_roz').click(function(){
    
   var ID = $(this).parents('.grey').find('.ost_id').val();
   var Name = $(this).parents('.grey').find('.new_join').val();
   var City = $(this).parents('.grey').find('.ost_city').val();
   //alert(Name);
   //exit;
   $.ajax({
        type: "POST",
        async:false,
        url: "/roz/save_step_2",
        data: {step_id:'<?=$roz_rou['id']?>',id:ID,name:Name,city:City},
        success: function(data) {
            //alert(data);
            location="/roz/add_route_step_2?id=<?=$roz_rou['id']?>";
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
})

 

$(function() {
    
     $('tbody').sortable();
/*    
   
    
 //////////////////   
$( "#join_ost" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: '/roz/auto_new',
          dataType: "json",
          data: {
            featureClass: "P",
            style: "full",
            maxRows: 12,
            name_startsWith: request.term,
            lang:'ru'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.city +  ", " + item.name,
                value: item.city +  ", " + item.name,
                id: item.id,
                type: item.type
              }
            }));
          },
          error:function(){
            alert('eror');
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        $('.route_from').val(ui.item.id);
      },

	 
	  open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<div>" )
        .append( "<img src='<?=Kohana::$base_url;?>img/ui/transport/"+item.type+".png' width='22' height='22' /><a>" + item.label +"</a>" )
        .appendTo( ul );
    };
    
     */
});


$('.save_step').click(function(){
    var Val = [];
    $(this).parents('.par').find('.t-t-input').each(function(){
        Val.push($(this).val());
    });
    
    var Platform = [];
    $(this).parents('.par').find('.platform').each(function(){
        Platform.push($(this).val());
    });

    var HTM = $('.so').html();
    //alert(Platform);
    //exit;
    $.ajax({
        type: "POST",
        url: "/roz/save_step",
        data: {step_id:'<?=$roz_rou['id']?>',html:HTM,val:Val,platform:Platform},
        success: function(data) {
            //alert(data);
            location="/roz/add_route_step_2?id=<?=$roz_rou['id']?>";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})

$('.save_weight').click(function(){
    var HTM = $('.so').html();
    $.ajax({
        type: "POST",
        url: "/roz/save_weight",
        data: {step_id:'<?=$roz_rou['id']?>',html:HTM},
        success: function(data) {
            //alert(data);
            //location="/roz/add_route_step_2?id=<?=$roz_rou['id']?>";
            $('.alert').show();
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
}) 


function DelSVZ(id){
    $.ajax({
        type: "POST",
        url: "/roz/del_ost",
        data: {step_id:'<?=$roz_rou['id']?>',id:id},
        success: function(data) {
            //alert(data);
            location="/roz/add_route_step_2?id=<?=$roz_rou['id']?>";
            $('.error').show();
            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
}


</script>
<!--<script src="<?=Kohana::$base_url;?>assets/js/group_list.js" type="text/javascript"></script>-->
<script src="<?=Kohana::$base_url;?>assets/js/messages_notifications.js" type="text/javascript"></script>
