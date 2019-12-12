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
                    <div class="panel-title"> <?=__("Select the main station")?>
                    </div>
                  </div>
                  <div class="panel-body">
                               <div class="col-md-12">
                             <div class="radio radio-success">
                             <? 
                                
                                //$chek_main_city = 
                                
                                $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sesuser[0]['id'])->where('route','=',$_GET['id'])->execute()->current();
                                if(empty($chek_pri)){
                                    echo 'emty system_users_priorety route -'.$_GET['id'];
                                    //$chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sesuser[0]['id'])->where('route','=',$_GET['next'])->execute()->current();
                                }
                                
                                 ?>
                                 
                              
                                <? 
                                 $al_r_main = DB::select()->from('route')->where('route_name_id','=',$chek_pri['route'])->order_by('weight')->execute()->as_array();
                    
                                $i= 1; foreach($al_r_main as $al){
                                    $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$al['route_city_id'])->and_where('culture','=',$lang)->execute()->current();
                                ?>
                                
                                
                                    <input id="male<?=$i;?>" type="radio" name="sity_main" class="in_rev" <? if($chek_pri['main_city_id'] == $al['route_city_id']){?>checked="checked" <?}?> value="<?=$al['route_city_id'];?>"  />
                                    <label for="male<?=$i;?>"><?=$al['route_city_id'];?> <?=$ost_name['name_i18n'].' '.$ost_name['city_i18n'];?></label><br />
                                <? $i++;}?>
                              </div>
                              <br />
                              <button class="chen btn btn-success btn-cons"><?=__("Save")?></button>
                              
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
    
    var Pri_SEL = $('.in_rev:checked');
    var master = Pri_SEL.val();
    //alert(master);
    //exit;
    $.ajax({
        url: '/sysuser/save_priorety_city',
        type: 'POST',
        async: false,
        data: {master:master,route:'<?=$_GET['id'];?>'},
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