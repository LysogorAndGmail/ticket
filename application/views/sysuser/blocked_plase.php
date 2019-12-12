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
  
  
  <div class="content">    
	<div class="page-title">
    <h3><?=__("Block Seat")?></h3>
    
   
    </div>
   


  <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
       
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
              <div class="col-md-6">
                                                   <? $i=1; foreach($all_buses_base as $base){
                                $bus_name = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$base['bus_id'])->where('culture','=',$lang)->execute()->current();
                                $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                                    ->and_where('culture','=',$lang)
                                    ->and_where('is_public','=',1)
                                    ->and_where('routename.route_name_id','=',$base['route_id'])
                                    ->order_by('routename.route_name_id','DESC')->execute()->current();
                                ?>
                                <div class="btn btn-block btn-white"><?=$i;?>) <?=$route_name['name_i18n'].' '.$bus_name['name_i18n'].' '.$base['plases'];?> 
                                
                                <a class="btn btn-danger btn-xs btn-mini" href="/sysuser/del_blocked_plase?sys_id=<?=$_GET['id'];?>&route_id=<?=$base['route_id'];?>&bus_id=<?=$base['bus_id'];?>"><?=__("Delete")?></a></div>
                                
                                
                              
                            
							  </div>
							
							
							
							
							
							<? $i++;}?>         
                            <div class="col-md-6">
                                <input type="hidden" class="user_id" value="<?=$_GET['id'];?>" />
                             
                             <div class="form-group">
                        <label class="form-label"><?=__('Route')?></label>
                        
                        <div class="controls">
                        <select class="route_id">
                                    <? foreach($routes as $r){?>
                                        <option value="<?=$r['route_name_id'];?>"><?=$r['route_name_id']." ".$r['name_i18n'];?></option>
                                    <?}?>
                                </select>
                        </div>
                      </div>
                             
                             
                                              <div class="form-group">
                        <label class="form-label"><?=__('Bus')?></label>
                        
                        <div class="controls">
                            <select class="bus_id">
                                    <? foreach($buses as $b){?>
                                        <option value="<?=$b['buses_id'];?>"><?=$b['name_i18n'];?></option>
                                    <?}?>
                                </select>
                        </div>
                      </div>
                             
                  
                                                     <div class="form-group">
                        <label class="form-label"><?=__('Seats')?></label>
                        
                        <div class="controls">
                            <input type="text" class="plases" placeholder="5,10,16" />
                        </div>
                      </div>
                                
                                                                     <div class="form-group">
                   
                        
                        <div class="controls">
                              <button class="save btn btn-success btn-cons"><?=__('Add')?></button>
                        </div>
                      </div>
                                
                                
                             
                                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 









</div><!--Content div-->
  
  
  
  
  
  
  
  
  
  
<script type="text/javascript">
$('.save').click(function(){
    $.ajax({
        url: '/sysuser/ajax_save_blocked_plase',
        type: 'POST',
        async: false,
        data: {user:$('.user_id').val(),bus_id:$('.bus_id').val(),plase:$('.plases').val(),route:$('.route_id').val()},
        error: function(){
            alert('errror');
        },
        success: function(data) {
            //$(data).insertAfter(InAF); 
            //alert(data);
            //exit;
            //startFrom += 30;
            //inProgress = false;
            
        }  
    });
    location="/sysuser/blocked_plase?id=<?=$_GET['id'];?>";
})

</script>