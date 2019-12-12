<?
$lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }
 $sesuser = Session::instance()->get('ses_user');

?>


<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Select the main route")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="col-md-12">
                             <? $first = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename_i18n.route_name_id','=',$_GET['id'])->and_where('culture','=',$lang)->execute()->current();
                                $second = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename_i18n.route_name_id','=',$_GET['next'])->and_where('culture','=',$lang)->execute()->current();
                                
                                $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sesuser[0]['id'])->where('route','=',$_GET['id'])->execute()->current();
                                if(empty($chek_pri)){
                                    $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sesuser[0]['id'])->where('route','=',$_GET['next'])->execute()->current();
                                }
                                
                                 ?>
                              <div class="radio radio-success">
                                <input id="male" type="radio" name="df" class="mai_r" <? if(!empty($chek_pri) && $chek_pri['route'] == $first['route_name_id']){ ?>checked="checked" <?}?> value="<?=$first['route_name_id'];?>">
                                <label for="male"><?=$first['route_name_id']. ' ' .$first['name_i18n'];?></label>
                                <input id="female" type="radio" name="df" class="mai_r" <? if(!empty($chek_pri) && $chek_pri['route'] == $second['route_name_id']){ ?>checked="checked" <?}?> value="<?=$second['route_name_id'];?>">
                                <label for="female"><?=$second['route_name_id']. ' ' .$second['name_i18n'];?></label>
                              </div> 
                              <br />
                              <button class="chen btn  btn-success btn-cons"><?=__("Save")?></button>
                              <??>
                        </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>













  
  
  
  
  



      
     
  
  
  
<script type="text/javascript">
$('.chen').click(function(){
    
    var Pri_SEL = $('.mai_r:checked');
    var master = Pri_SEL.val();
    
    var slave = [];
    $('input.mai_r').each(function(){
        //alert($(this).val());
        if($(this).val() != master){
        //    var slave = $(this).val();
            slave.push($(this).val());
        }
    })

    $.ajax({
        url: '/sysuser/save_priorety_route',
        type: 'POST',
        async: false,
        data: {master:master,slave:slave[0]},
        error: function(){
            alert('errror');
        },
        success: function(data) {
            //$(data).insertAfter(InAF); 
            //alert(data);
            //exit;
            //startFrom += 30;
            //inProgress = false;
            location="/sysuser/routes_priorety";
            
        }  
    });
})


</script>  
  
  <? die;?>
  
  
  
  
  
  
  
  <? /*
  <a href="#" class="btn btn-success btn-cons"  data-toggle="modal" data-target="#myModal<?=$a['route_name_id'];?>"><?=__("Select")?></a>
                                                                <div class="modal fade" id="myModal<?=$a['route_name_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" style="width: 880px !important;">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                 <? $chek = DB::select()->from('system_users_priorety')->where('sysuser_id','=',$sysuser[0]['id'])->and_where('route','=',$a['route_name_id'])->execute()->current();
                                                                                    if(!empty($chek)){
                                                                                        $new_main =$chek['route'];
                                                                                        $new_slave = $chek['slave_route'];
                                                                                    }//else{
                                                                                    //    $new_main = $chek['slave_route'];
                                                                                    //    $new_slave = $chek['route'];
                                                                                    //}
                                                                                      
                                                                                      
                                                                                        
                                                                                       
                                                                                        
                                                                                     ?>
                                                                                    <!-- main --> 
                                                                                    <div class="col-md-6 mai_rou">                                             
                                                                                    <input type="radio" name="df" class="mai_r" value="<?=$full_main['route_name_id']?>" <? if($prior_old['route'] == $a['route_name_id']){?>checked="checked" <?}?> /> <?=$full_main['name_i18n'];?>
                                                                                    <hr />
                                                                                    <br />
                                                                                    <ul>
                                                                                        <? 
                                                                                         $al_r_main = DB::select()->from('route')->where('route_name_id','=',$full_main['route_name_id'])->order_by('weight')->execute()->as_array();
                                                                            
                                                                                        foreach($al_r_main as $al){
                                                                                        $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$al['route_city_id'])->and_where('culture','=',$lang)->execute()->current();
                                                                                        ?>
                                                                                        
                                                                                        <li><input type="radio" name="sity_main" class="in_rev" 
                                                                                         <? if($prior_old['main_city_id'] == $al['route_city_id']){?>checked="checked" <?}?>
                                                                                        
                                                                                        value="<?=$al['route_city_id'];?>"  /><?=$al['route_city_id'];?> <?=$ost_name['name_i18n'].' '.$ost_name['city_i18n'];?></li>
                                                                                        <?}?>
                                                                                    </ul>
                                                                                    <div class="clearfix">&nbsp;</div>
                                                                                </div> <!-- end main -->
                                                                                <?if(!empty($a['reverse_id'])){ 
                                                                                    $full_slave = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename_i18n.route_name_id','=',$new_slave)->and_where('culture','=',$lang)->execute()->current();
                                                                                    
                                                                                     ?>
                                                                                
                                                                                <div class="col-md-6 sla_rou">
                                                                                <?//if(!empty($a['reverse_id'])){?>
                                                                                    <input type="radio" name="df" class="mai_r" value="<?=$full_slave['route_name_id']?>" <? if($prior_old['slave_route'] == $a['reverse_id']){?>checked="checked" <?}?> /> <?=$full_slave['name_i18n'];?>
                                                                                    <?//}?>                                               
                                                                                    <hr />
                                                                                    <br />
                                                                                    <ul >
                                                                                        <? $al_r_slave = DB::select()->from('route')->where('route_name_id','=',$full_slave['route_name_id'])->order_by('weight')->execute()->as_array();
                                                    
                                                                                        foreach($al_r_slave as $al){
                                                                                        
                                                                                        $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$al['route_city_id'])->and_where('culture','=',$lang)->execute()->current();
                                                    
                                                                                        ?>
                                                                                        <li><input type="radio" name="sity_rev" class="in_rev" 
                                                                                        <? if($prior_old['slave_city_id'] == $al['route_city_id']){?>checked="checked" <?}?>
                                                                                        value="<?=$al['route_city_id'];?>" /> </span><?=$al['route_city_id'];?> <?=$ost_name['name_i18n'].' '.$ost_name['city_i18n'];?></li>
                                                                                        <?}?>
                                                                                    </ul>
                                                                                    <div class="clearfix">&nbsp;</div>
                                                                                </div>
                                                                                <?}?>
                                                                                <div class="clearfix">&nbsp;</div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Close")?></button>
                                                                                <button class="btn btn-salat save_prior" data-dismiss="modal"><?=__("Save")?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                */?>