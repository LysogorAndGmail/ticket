<?
$ses_user = Session::instance()->get('ses_user');
//echo $ses_user[0]['id'];
?>

 <div class="container container-fixed-lg">
 
  <div class="row">
    <div class="row" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="col-md-12 grey">           
                            <form method="POST">
                                <div class="col-md-3">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Route Name ID")?></label>
                                        <input type="text" name="route_name_id" placeholder="" class="route_name_id form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Route ID")?></label>
                                        <input type="text" name="route_id" placeholder="" class="route_id form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Route Name")?></label>
                                        <input type="text" name="route_name" placeholder="" class="route_name form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Number")?></label>
                                        <input type="text" name="nom" placeholder="" class="nom form-control">
                                    </div>
                                </div>             
                            </form>
                        </div> 
                        <div class="grid-body no-border email-body" style="min-height: 850px; padding-top: 20px;">
                            <div class="col-md-12 second-filter-bar">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="fast_select">
                                            <div class="checkbox check-default">
                                                <input type="checkbox" id="checkbox1" name="" value="" class="sel_all" />
                                                <label for="checkbox1"><?=__("Select all")?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div><?=__("Published")?><span class="pub_all" data-s="1"> <a href=""><?=__("Yes")?></a></span> <span class="un_pub" data-s="0"><a href=""><?=__("No")?></a></span> | <span class="del_all"><a href=""><?=__("Delete")?></a></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 insert_in">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?=__("Route Name ID")?></th>
                            <th><?=__("Route ID")?></th>
                            <th><?=__("Number")?></th>
                            <th><?=__("Route Name")?></th>
                            <th><?=__("Add Parent")?></th>
                            <th><?=__("Route Time")?></th>
                            <th><?=__("Rice")?></th>
                            <th><?=__("Platform")?></th>
                            <th><?=__("Backroute")?></th>
                            <th><?=__("Published")?></th>
                            <th><?=__("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($routes as $a){ ?>
                            <tr class="insert_af">
                                <td >
                                    <input type="checkbox" name="route_name_id[]" id="<?=$a['route_name_id'];?>" value="<?=$a['route_name_id'];?>" class="one_r_id" />
                                    <?=$a['route_name_id'];?>
                                </td>
                                <td><?=$a['route_id'];?></td>
                                <td><?=$a['name'];?></td>
                                <td><?=$a['name_i18n'];?></td>
                                <td><? if(empty($a['child'])){?><a href="/roz/add_parent?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Add Parent")?>"><icon class="fa fa-clock-o m-r-5"></i></a><?}?></td>
                                <td><? if(!empty($a['parent'])){ echo $a['start_from'].' / <a href="#'.$a['parent'].'">'.$a['parent'].'</a>';};?></td>
                                <td>
                                    <div>
                                            <? $cou = array(); for($i=2;$i<=10;$i++){
                                        $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                        if(!empty($ch)){  $cou[] = 1;?>
                                                <a class="" href="/rice/see?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>"><?=$i;?></a>&nbsp; <a class="" href="/rice/delete_rice?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>">X</a><br />             
                                      <?  }
                                      }  ?>
                                    </div>
                                    <span data-tooltip class="has-tip" title="<?=count($cou)+2;?>">
                                    <a href="/rice/add_rice?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Add Rice")?>"><icon class="fa fa-cogs m-r-5"></i></a></span>
                                </td>
                                <td>
                                    <a href="/route/platform?route_name_id=<?=$a['route_name_id'];?>"  title="<?=__("Platform")?>"><?=__("Platform")?></a>
                                </td>
                                <td>
                                    <? $chch = ''; 
                                    $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->or_where('reverse_id','=',$a['route_name_id'])->execute()->current(); 
                                    if(!empty($main_route)){?>
                                        <span data-tooltip class="has-tip" title="<?=$chch;?>"><? if($main_route['main_id'] == $a['route_name_id']){ echo $main_route['reverse_id']; }else{ echo $main_route['main_id']; } ?></span>
                                    <?}else{?>
                                        <a href="/route/reverse?id=<?=$a['route_name_id'];?>"  title="<?=__("Add Backroute")?>"><icon class="fa fa-mail-reply m-r-5"></i></a>
                                    <?}?>
                                </td>
                                <td>
                                    <? if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; } ?>
                                </td>
                                <td >
                                    <!---->
                                    <? if($ses_user['group_id'] != 1){
                                    $chek_edit = DB::select()->from('system_users_edit_routes')->where('user_id','=',$ses_user[0]['id'])->and_where('route_name_id','=',$a['route_name_id'])->execute()->current(); 
                                    if(!empty($chek_edit)){?>
                                    <a href="/route/edit_route?route_name_id=<?=$a['route_name_id'];?>"  title="<?=__("Edit")?>"><icon class="fa fa-pencil-square-o m-r-5"></i></a> |
                                    <a class="shure" href="/route/delete_route?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Delete")?>"><icon class="fa fa-times m-r-5"></i></a>
                                    <?}}else{?>
                                    <a href="/route/edit_route?route_name_id=<?=$a['route_name_id'];?>"  title="<?=__("Edit")?>"><icon class="fa fa-pencil-square-o m-r-5"></i></a> |
                                    <a class="shure" href="/route/delete_route?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Delete")?>"><icon class="fa fa-times m-r-5"></i></a>
                                    <?}?>
                                </td>
                            </tr>
                        <?}?>
                   </tbody>
                </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
</div>
<script type="text/javascript">
     $('.limit,.pub').change(function(){
        $('.lim_form').submit();
    })
     
     $('.route_name,.route_id,.nom,.route_name_id').keyup(function(){
         var Vall = $(this).val();
         //if(Vall.length > 1){
            var Sort = $(this).attr('name');
            var Pub = $('.pub').val();
            //alert(Pub);
            //exit;
            $.ajax({
            url: '/route/search_sort',
            type: 'POST',
            data: {sort: Sort,val:Vall,lang:$('#cur_lan').val(),pub:Pub},
            //error: function(){
            //    alert('errror');
            //},
            success: function(data) {
                $('.insert_in').html(data);
            }  
            });
        //}
     })
    
$('.sel_all').change(function(){
    if($(this).attr('checked') == 'checked'){
        $('.one_r_id').each(function(){
            $(this).attr('checked','checked');
        })
    }else{
        $('.one_r_id').each(function(){
            $(this).removeAttr('checked');
        })
    }
    
}) 
$('.pub_all,.un_pub').click(function(){
    var Do = $(this).data('s');
    //exit;
    var Arr = [];
    $('.one_r_id:checked').each(function(){
        Arr.push($(this).val());
    })
    $.ajax({
        url: '/route/all_pub',
        type: 'POST',
        data: {arr:Arr,dodo:Do},
        error: function(){
            alert('errror');
        },
        success: function(data) {
           location="/route"; 
           //alert(data);
        }  
    });
    //alert(Arr);
})
    
    
    ////////////////
$(document).ready(function(){
    var inProgress = false;
    var startFrom = 30;
    var inProgress_no = false;
    var startFrom_no = 30;
    /*
    $(window).scroll(function() {
        var AC =  $('.tabs-content').find('.active').attr('id');
        if(AC == 'panel2-1'){
            startScroll(startFrom,inProgress);
            startFrom += 30;
            inProgress = false;            
        }else{
            startScroll_no(startFrom_no,inProgress_no);
            startFrom_no += 30;
            inProgress_no = false; 
        }
    });
    */
    function startScroll(startFrom,inProgress){
        var BLLH = $('#panel2-1').height();
        var Ciu = $('.insert_af').length;
        var InAF = $('.insert_af').last();
        var Scrol = $(window).scrollTop() + $(window).height();
        if(Scrol != BLLH - 400 && !inProgress) {
         //alert('jhk');
         //   if(Scrol > CuBl){
            $.ajax({
                url: '/route/scroll',
                type: 'POST',
                async: false,
                data: {lang:$('#cur_lan').val(),ofset:startFrom},
                error: function(){
                    alert('errror');
                },
                beforeSend: function() {
                    inProgress = true;
                },
                success: function(data) {
                   $(data).insertAfter(InAF); 
                    //alert(data);
                    //startFrom += 30;
                    //inProgress = false;
                }  
            });
            
        }
    }
    
    function startScroll_no(startFrom,inProgress){
        var BLLH2 = $('#panel2-2').height();
        var Ciu = $('.insert_af_no').length;
        var InAF = $('.insert_af_no').last();
        var Scrol = $(window).scrollTop() + $(window).height();
        if(Scrol != BLLH2 - 400 && !inProgress) {
         //alert('jhk');
         //   if(Scrol > CuBl){
            $.ajax({
                url: '/route/scroll_no',
                type: 'POST',
                async: false,
                data: {lang:$('#cur_lan').val(),ofset:startFrom},
                error: function(){
                    alert('errror');
                },
                beforeSend: function() {
                    inProgress = true;
                },
                success: function(data) {
                   $(data).insertAfter(InAF); 
                    //alert(data);
                    //startFrom += 30;
                    //inProgress = false;
                }  
            });
            
        }
    }
    
    
});
    
    
    ///////////////
    
     
</script>