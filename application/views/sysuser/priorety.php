<?
$lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }

?>

<style>
  .sortable {
    list-style: none;
    padding-left: 0;
    margin-left: 0;
  }
  .ui-state-default:hover {
    width: 100% !important;
  }
  .ui-state-default:hover {
    width: 100% !important;
    outline: none !important;
    border: none !important;
    background: #d1dade;
    color: #505458;
  }
  .ui-state-default{
    width: 100% !important;
    color: #6F7B8A;
    border: none;
    background: #d9e0e4;
    margin: 2px;
    text-align: left;
    border-radius: 2px;
  }
  .ui-state-default .ui-icon {
    display: none;
  }
  </style>
<? //echo '<pre>'; print_r($routes); echo '</pre>';?>  
  
  







<div class="container container-fixed-lg">
   
    
            <!-- START PANEL -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="panel-title"><?=__("Sale settings")?>
                </div>
                
              </div>
              <div class="panel-body p-t-10">
                <div class="row">
                  <table class="table table-striped table-fixed-layout ">
                                                <thead>
                                                    <tr>
                                                        <!--<th><?=__("Route Name ID")?></th>-->
                                                        <th><?=__("Route number")?></th>
                                                        <!--<th><?=__("Route Name")?></th>-->
                                                        <!--<th><?=__("Route Priorety")?></th>-->
                                                        <th><?=__("Main city")?></th>
                                                        <!--<th><?=__("Slave city")?></th>-->
                                                        <th><?=__("Reverse route")?></th>
                                                        <th><?=__("Direction")?></th>
                                                       
                                                    </tr> 
                                                </thead>
                                                <tbody>
                                                    <? foreach($routes as $a){ ?>
                                                        <tr class="insert_af_no">
                                                            <!--<td><?=$a['route_name_id'];?></td>-->
                                                            <td><?=$a['name'];?></td>
                                                            <!--<td><?=$a['name_i18n'];?></td>-->
                                                             <? $prior_old = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sysuser[0]['id'])->where('route','=',$a['route_name_id'])->execute()->current();

                                                                if(empty($prior_old)){
                                                                    $prior_old = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$sysuser[0]['id'])->where('route','=',$a['reverse_id'])->execute()->current();
                                                                }
                                                                if(empty($prior_old)){
                                                                    
                                                                echo __('');
                                                                }
                                                                 ?>
                                                            <!--<td><?=$prior_old['route'];?></td>-->
                                                            <td><? $ost_name = DB::select()->from('routecity_i18n')->where('route_city_id','=',$prior_old['main_city_id'])->and_where('culture','=',$lang)->execute()->current(); echo $ost_name['name_i18n'].' '.$ost_name['city_i18n']; if(empty($prior_old)){ echo __('Add city'); }?></td>
                                                            <!--<td><?=$prior_old['slave_city_id'];?></td>-->
                                                            <td><span class="text-danger"><? $r_name = DB::select()->from('routename_i18n')->where('route_name_id','=',$prior_old['slave_route'])->and_where('culture','=',$lang)->execute()->current(); echo $r_name['name_i18n'];?></span></td>
                                                            <td>
                                                           
                                                           
                                                              <a href="/sysuser/select_main_route?id=<?=$a['route_name_id'];?>&next=<?=$a['reverse_id'];?>" class="btn btn-default btn-cons m-r-20"><?=__("Direction")?></a>
                                                           
                                                           
                                                              <a href="/sysuser/select_main_city?id=<?=$prior_old['route'];?>" class="btn btn-default btn-cons m-r-20"><?=__("Station")?></a>
                                                            </td>
                                                           
                                                        </tr>
                                                    <?}?>
                                               </tbody>
                                            </table>
                </div>
              </div>
            </div>
            <!-- END PANEL -->
          </div>










 

      
     


















<script type="text/javascript">
$('.save_prior').click(function(){
    var par = $(this).parents('.modal-content');
    var Pri_SEL = par.find('.mai_r:checked');
    
    //alert(Pri_SEL.val());
    //exit;
    
    var US_CH = Pri_SEL.val();
    var City_main_parent = Pri_SEL.parent();
    var Ci_par_id = City_main_parent.find('.in_rev:checked').val(); //main_city_id
    var Ci_slave_bl = City_main_parent.next('.col-md-6').html(); //main_city_id
    var Ci_id_slave = City_main_parent.next('.col-md-6').find('.in_rev:checked').val();
    if(Ci_slave_bl == null){
        Ci_slave_bl = City_main_parent.prev('.col-md-6').html();
        Ci_id_slave = City_main_parent.prev('.col-md-6').find('.in_rev:checked').val();
    }
    $.ajax({
        url: '/sysuser/save_priorety',
        type: 'POST',
        async: false,
        data: {priory_route:US_CH,prior_city:Ci_par_id,slave_city:Ci_id_slave},
        error: function(){
            alert('errror');
        },
        success: function(data) {
            //$(data).insertAfter(InAF); 
            alert(data);
            //exit;
            //startFrom += 30;
            //inProgress = false;
            
        }  
    });
    //location="/sysuser/routes_priorety";
})

</script>