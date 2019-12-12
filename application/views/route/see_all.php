<div class="content">    
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3>Back- <span class="semi-bold">Index</span></h3>
    </div>		
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <div class="large-12 medium-12  columns insert_in">  
                            <p>&nbsp;</p>
    
    <div class="fast_select">
        all <input type="checkbox" name="" value="" class="sel_all" /><div>Publiched <span class="pub_all" data-s="1">Yes</span> <span class="un_pub" data-s="0">No</span> | <span class="del_all">Delete</span></div>
    </div>
    <p>&nbsp;</p>
    <ul class="nav nav-tabs" id="tab-01">
        <li class="active"><a href="#panel2-1">Publiched</a></li>
        <li><a href="#panel2-2">No publiched</a></li>
    </ul>
    <div class="padding_center tab-content">
        <div class="tab-pane active" id="panel2-1">
        <div class="row">                
                <div class="col-md-12">
                <table class="table table-striped table-fixed-layout table-hover">
                    <thead>
                        <tr>
                            <th>RouteNameID</th>
                            <th>RouteID</th>
                            <th>Number</th>
                            <th>Route Name</th>
                            <th>Add Parent</th>
                            <th>Route Time</th>
                            <th>Rice</th>
                            <th>Backroute</th>
                            <th>Publiched</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){ ?>
                            <tr class="insert_af">
                                <td >
                                    <input type="checkbox" name="route_name_id[]" id="<?=$a['route_name_id'];?>" value="<?=$a['route_name_id'];?>" class="one_r_id" />
                                    <?=$a['route_name_id'];?>
                                </td>
                                <td><?=$a['route_id'];?></td>
                                <td><?=$a['name'];?></td>
                                <td><?=$a['name_i18n'];?></td>
                                <td><? if(empty($a['child'])){?><a href="/roz/add_parent?route_name_id=<?=$a['route_name_id'];?>">add</a><?}?></td>
                                <td><? if(!empty($a['parent'])){ echo $a['start_from'].' / <a href="#'.$a['parent'].'">'.$a['parent'].'</a>';};?></td>
                                <td>
                                    <div>
                                            <? $cou = array(); for($i=2;$i<=10;$i++){
                                        $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                        if(!empty($ch)){  $cou[] = 1;?>
                                                <!--<a class="" href="/rice/see?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>"><?=$i;?></a>&nbsp; <a class="" href="/rice/dell?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>">X</a><br />  -->              
                                      <?  }
                                      }  ?>
                                    </div>
                                    <span data-tooltip class="has-tip" title="<?=count($cou)+2;?>"><a href="/rice/add_rice?route_name_id=<?=$a['route_name_id'];?>">add</a></span>
                                </td>
                                <td>
                                    <? $chch = ''; 
                                    $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->execute()->current(); 
                                    $reverse_route = DB::select()->from('route_reverse')->where('reverse_id','=',$a['route_name_id'])->execute()->current();
                                    if(!empty($reverse_route)){
                                        $chch = $reverse_route['reverse_id'];
                                    } 
                                    if(!empty($main_route)){
                                        $chch = $main_route['main_id'];
                                    }
                                    if(!empty($chch)){   
                                        ?>
                                        <span data-tooltip class="has-tip" title="<?=$chch;?>"><a href="/route/reverse?id=<?=$a['route_name_id'];?>">add</a></span>
                                    <?}else{?>
                                        <a href="/route/reverse?id=<?=$a['route_name_id'];?>">add</a>
                                    <?}?>
                                </td>
                                <td>
                                    <? if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; } ?>
                                </td>
                                <td >
                                    <!---->
                                    <a href="/route/edit_route?route_name_id=<?=$a['route_name_id'];?>">edit</a> |
                                    <a class="shure" href="/route/delete_route?route_name_id=<?=$a['route_name_id'];?>">del</a>
                                </td>
                            </tr>
                        <?}?>
                   </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="panel2-2">
        <div class="row">                
                <div class="col-md-12">
                <table class="table table-striped table-fixed-layout table-hover">
                    <thead>
                        <tr>
                            <th>RouteNameID</th>
                            <th>RouteID</th>
                            <th>Number</th>
                            <th>Route Name</th>
                            <th>Rice</th>
                            <th>Backroute</th>
                            <th>Publiched</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all_no as $a){ ?>
                            <tr class="insert_af_no">
                                <td >
                                    <input type="checkbox" name="route_name_id[]" value="<?=$a['route_name_id'];?>" class="one_r_id" />
                                    <?=$a['route_name_id'];?>
                                </td>
                                <td><?=$a['route_id'];?></td>
                                <td><?=$a['name'];?></td>
                                <td><?=$a['name_i18n'];?></td>
                                <td>
                                    <div>
                                            <? $cou = array(); for($i=2;$i<=10;$i++){
                                        $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                        if(!empty($ch)){  $cou[] = 1;?>
                                                <!--<a class="" href="/rice/see?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>"><?=$i;?></a>&nbsp; <a class="" href="/rice/dell?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>">X</a><br />  -->              
                                      <?  }
                                      }  ?>
                                    </div>
                                    <span data-tooltip class="has-tip" title="<?=count($cou)+2;?>"><a href="/rice/add_rice?route_name_id=<?=$a['route_name_id'];?>">add</a></span>
                                </td>
                                <td>
                                    <? $chch = ''; 
                                    $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->execute()->current(); 
                                    $reverse_route = DB::select()->from('route_reverse')->where('reverse_id','=',$a['route_name_id'])->execute()->current();
                                    if(!empty($reverse_route)){
                                        $chch = $reverse_route['reverse_id'];
                                    } 
                                    if(!empty($main_route)){
                                        $chch = $main_route['main_id'];
                                    }
                                    if(!empty($chch)){   
                                        ?>
                                        <span data-tooltip class="has-tip" title="<?=$chch;?>"><a href="/route/reverse?id=<?=$a['route_name_id'];?>">add</a></span>
                                    <?}else{?>
                                        <a href="/route/reverse?id=<?=$a['route_name_id'];?>">add</a>
                                    <?}?>
                                </td>
                                <td>
                                    <? if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; } ?>
                                </td>
                                <td >
                                    <!---->
                                    <a href="/route/edit_route?route_name_id=<?=$a['route_name_id'];?>">edit</a> |
                                    <a class="shure" href="/route/delete_route?route_name_id=<?=$a['route_name_id'];?>">del</a>
                                </td>
                            </tr>
                        <?}?>
                   </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
                   
                        
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
     $('.route_name,.route_id,.route_nom,.route_route_id').keyup(function(){
         var Vall = $(this).val();
         //if(Vall.length > 1){
            var Sort = $(this).attr('class');
            $.ajax({
            url: '/route/search_sort',
            type: 'POST',
            data: {sort: Sort,val:Vall},
            error: function(){
            alert('errror');
            },
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
           location="/route/see_all"; 
           //alert(data);
        }  
    });
    //alert(Arr);
})
   /*
    $(window).scroll(function(){
        var InAF = $('.insert_af').last();
        var Ciu = $('.insert_af').length;
        //alert(Ciu);
        //exit;
        var Scrol = $(window).scrollTop();
        //var CurHe = $(document).height() - 600;
        var CuBl = $('.insert_in').height() - 800;
        if(Scrol > CuBl){
            //
            $.ajax({
                url: '/route/scroll',
                type: 'POST',
                data: {lang:$('#cur_lan').val(),ofset:Ciu},
                error: function(){
                    alert('errror');
                },
                success: function(data) {
                   $(data).insertAfter(InAF); 
                    //alert(data);
                }  
            });
            //alert('больше');
        }
    });
    */
    
    
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