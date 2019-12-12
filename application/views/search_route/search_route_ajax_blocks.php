<?
$lang = Session::instance()->get('leng');
if(!$lang) {
    $lang = 'EN';
}
 I18n::lang($lang);
 
$sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
    $ses_valute = $sesuser[0]['default_valute'];
}else{
    $user_id = 0;
    $ses_valute = 'EUR';
}
//echo $return_open;
?>
<style>

.hide_div {
    display: none;
}
.main_info span{
    padding: 0 20px;
}

.disp-route-result:hover { background:#fff4ad}

</style>
<div class="col-md-12 no-padding">
<div class="tiles blue ">
              <div class="tiles-body">
		<h3 class="text-white"><?=$from;?> - <?=$to?> <?=__("Outbound journey")?></h3>
      <h5 class="text-white"><?=Date('d.m.Y',strtotime($date));?> <?=$day_week;?></h5>
			  </div>			
			</div>
</div>

<div class="main_blok">
     
               <div class="one_row_routes main_routes">
    <?foreach($routes as $route){
        //echo '<pre>';
        //print_r($route);
        //echo '</pre>';
        //die;

            $bus = DB::select()->from('buses')->where('buses_id','=',$route['from']['buses_id'])->execute()->current();
            $all_schema = DB::select('value')->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
          $new_schema = array();
          foreach($all_schema as $chem){
                if(!empty($chem['value']) && $chem['value'] != 'sw'){
                    $new_schema[] = $chem['value'];
                }
          }        
            $sell_array = Model::factory('TiketMod')->sell_plase($route['from']['route_name_id'],$route['from']['date'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from'][0],$route['to'][0]);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route['from']['route_name_id'],$route['from']['date'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from'][0],$route['to'][0]);
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            }     
            $new_block_plase = Model::factory('TiketMod')->block_plase($route['from']['route_name_id'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from'][0],$route['to'][0],$route['from']['date']);
            $old_disp_bizi = array();
            foreach($old_disp_bizi as $old_biz){
                if(isset($old_biz) && !empty($old_biz)){
                    array_push($new_block_plase,array('value'=>$old_biz));
                }
                
            }
            $all_plase_free = count($new_schema)
             - count($sell) 
             - count($reserv) 
             - count($new_block_plase);
        
        
        
        
        
        
        $city_from = Model::factory('OstMod')->get_ost($route['from'][0],$lang);
        $city_to = Model::factory('OstMod')->get_ost($route['to'][0],$lang);
        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$route['from']['ferryman_id'])->execute()->current();
        $bus = DB::select()->from('buses_i18n')->where('buses_id','=',$route['from']['buses_id'])->and_where('culture','=',$lang)->execute()->current();
        //$get_fer_week = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$route[0]['route_name_id'])->and_where('date','=',$tran_date)->execute()->current();
        $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['from']['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
        
        $price_array = Model::factory('TiketMod')->chek_price_model($route['from']['route_name_id'],$route['from'][0],$route['to'][0],$ses_valute,$route['from']['ferryman_id']);
        $price = $price_array[0];
        $valute = $price_array[1];
        
        
        ?>
        
<div class="one_blol_search_route first_people ">
    <div class="col-md-12  disp-route-result p-t-10 selector-heading-result   ">
        <div class="col-md-6 col-sm-6">
            <div class="col-md-6 col-sm-6"><h3 class="semi-bold"><?=$route['from']['hours'];?></h3> <?=$city_from['name_i18n'];?></div>
            <div class="col-md-6 col-sm-6"> <h3 class="semi-bold"><?=$route['to']['a_time'];?></h3> <?=$city_to['name_i18n'];?></div>
        </div>
        <div class="col-md-3 col-sm-3">
            <table class="table table-hover no-more-tables">
                <tbody>
                    <tr>
                        <td><?=$route_name['name'];?>, <?=$fermann_id['name'];?></td>
                    </tr>
                    <tr>
                        <td><span><?=__("Seats")?>: </span> <span class="semi-bold"><?=$all_plase_free;?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3 col-sm-3 text-center">
            <h4 class="semi-bold text-center"><?=$price." ".$valute;?></h4>
            <button onclick="$(this).parents('.one_blol_search_route').find('.hide_div').toggle(),start($(this),'<?=$route_name['route_name_id'];?>','<?=$route['from']['date'];?>','<?=$route['from'][0];?>','<?=$route['to'][0];?>',1)" class="btm-edit btn btn-success buy-btm"> <?=__("Choice ticket")?> <i class="fa fa-cart-arrow-down"></i></button>
        </div>
    </div>
    <div class="blog-bar-no-padding"></div>
    <div class="clearfix"></div>
    <div class="hide_div col-md-12 one_par">
        <div class="des-bus row"><div class="col-md-4"><h4><?=$city_from['name_i18n'];?> <?=__("Platform")?>: <?if($route['from']['platform']['value']){echo $route['from']['platform']['value'];}?></h4><h6><?=$route['from']['hours'];?> Date <?=date('d.m.Y',strtotime($route['from']['date']));?></h6></div>  <div class="col-md-1"><i class="fa fa-angle-right fa-1x"></i></div>  <div class="col-md-4"><h4><?=$city_to['name_i18n'];?>  <?=__("Platform")?>: <?if($route['to']['platform']['value']){echo $route['to']['platform']['value'];}?></h4><h6><?=$route['to']['a_hours'];?> Date <?=date('d.m.Y',strtotime($route['to']['end_date']));?></h6></div></div>
        <div class="row">
            <div class="salon col-md-2"></div>
            <div class="all_people col-md-10">
                <div class="peo_after"></div>
            </div>
        </div>
    </div>     
    <div class="clearfix"></div>
</div>
      <?}?>         
 
              </div>
      
    <? // обратка ?>

  
               <div class="return_row_route main_routes">
    <? if($return_open == 0){?>
    <? if(!empty($routes_return)){?>

   <div class="col-md-12 no-padding">
<div class="tiles black ">
              <div class="tiles-body">
		<h3 class="text-white"><?=$return_from;?> - <?=$return_to?> <?=__("Return journey")?></h3>
      <h5 class="text-white"><?=Date('d.m.Y',strtotime($date));?> <?=$day_week;?></h5>
			  </div>			
			</div>
</div>
   

    <?}?>
    <?foreach($routes_return as $route){
        //echo '<pre>';
        //print_r($route);
        //echo '</pre>';
        //die;
        
        
        
        
            $bus = DB::select()->from('buses')->where('buses_id','=',$route['from']['buses_id'])->execute()->current();
            $all_schema = DB::select('value')->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
          $new_schema = array();
          foreach($all_schema as $chem){
                if(!empty($chem['value']) && $chem['value'] != 'sw'){
                    $new_schema[] = $chem['value'];
                }
          }        
            $sell_array = Model::factory('TiketMod')->sell_plase($route['from']['route_name_id'],$route['from']['date'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from']['route_city_id'],$route['to']['route_city_id']);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route['from']['route_name_id'],$route['from']['date'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from']['route_city_id'],$route['to']['route_city_id']);
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            }     
            $new_block_plase = Model::factory('TiketMod')->block_plase($route['from']['route_name_id'],$route['from']['buses_id'],$route['from']['ferryman_id'],$route['from']['route_city_id'],$route['to']['route_city_id'],$route['from']['date']);
            $old_disp_bizi = array();
            foreach($old_disp_bizi as $old_biz){
                if(isset($old_biz) && !empty($old_biz)){
                    array_push($new_block_plase,array('value'=>$old_biz));
                }
                
            }
            $all_plase_free = count($new_schema)
             - count($sell) 
             - count($reserv) 
             - count($new_block_plase);
       
        
        $city_from = Model::factory('OstMod')->get_ost($route['from']['route_city_id'],$lang);
        $city_to = Model::factory('OstMod')->get_ost($route['to']['route_city_id'],$lang);
        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$route['from']['ferryman_id'])->execute()->current();
        $bus = DB::select()->from('buses_i18n')->where('buses_id','=',$route['from']['buses_id'])->and_where('culture','=',$lang)->execute()->current();
        //$get_fer_week = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$route[0]['route_name_id'])->and_where('date','=',$tran_date)->execute()->current();
        $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['from']['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
        
        $price_array = Model::factory('TiketMod')->chek_price_model($route['from']['route_name_id'],$route['from']['route_city_id'],$route['to']['route_city_id'],$ses_valute,$route['from']['ferryman_id']);
        $price = $price_array[0];
        $valute = $price_array[1];
        
        //echo $price;
        
        ?>
<div class="one_blol_search_route return return_people">
    <div class="col-md-12  disp-route-result p-t-10 selector-heading-result   ">
        <div class="col-md-6 col-sm-6">
            <div class="col-md-6 col-sm-6"><h3 class="semi-bold"><?=$route['from']['hours'];?></h3> <?=$city_from['name_i18n'];?></div>
            <div class="col-md-6 col-sm-6"> <h3 class="semi-bold"><?=$route['to']['a_hours'];?></h3> <?=$city_to['name_i18n'];?></div>
        </div>
        <div class="col-md-3 col-sm-3">
            <table class="table table-hover no-more-tables">
                <tbody>
                    <tr>
                        <td><?=$route_name['name'];?>, <?=$fermann_id['name'];?></td>
                    </tr>
                    <tr>
                        <td><span><?=__("Seats")?>: </span> <span class="semi-bold"><?=$all_plase_free;?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3 col-sm-3 text-center">
            <h4 class="semi-bold text-center"><?=$price." ".$valute;?></h4>
            <button onclick="$(this).parents('.one_blol_search_route').find('.hide_div').toggle(),start($(this),'<?=$route['from']['route_name_id'];?>','<?=$route['from']['date'];?>','<?=$route['from']['route_city_id'];?>','<?=$route['to']['route_city_id'];?>',2)" class="btm-edit btn btn-success buy-btm"> <?=__("Choice ticket")?> <i class="fa fa-cart-arrow-down"></i></button>
        </div>
    </div>
    <div class="hide_div col-md-12 one_par">
        <div class="des-bus row"><div class="col-md-4"><h4><?=$city_from['name_i18n'];?> <?=__("Platform")?>: <?=$route['from']['platform']['value'];?></h4><h6><?=$route['from']['hours'];?> Date <?=date('d.m.Y',strtotime($route['from']['date']));?></h6></div>  <div class="col-md-1"><i class="fa fa-angle-right fa-1x"></i></div>  <div class="col-md-4"><h4><?=$city_to['name_i18n'];?>  <?=__("Platform")?>: <?=$route['to']['platform']['value'];?></h4><h6><?=$route['to']['a_hours'];?> Date <?=date('d.m.Y',strtotime($route['to']['end_date']));?></h6></div></div>
        <div class="row">
            <div class="salon col-md-2"></div>
            <div class="all_people col-md-10">
            <div class="return_peo_after"></div>
            </div>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
    <?}?>
    <?}else{ // return open 1?>
        <? if(!empty($routes_return)){?>
    <h2><?=$return_to;?> - <?=$return_from?> <?=__("Return")?></h2>
    <h5><?=$day_week;?></h5>
    <?}?>
    <?foreach($routes_return as $route){
        $city_from = Model::factory('OstMod')->get_ost($route['from']['route_city_id'],$lang);
        $city_to = Model::factory('OstMod')->get_ost($route['to']['route_city_id'],$lang);
       
        //$get_fer_week = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$route[0]['route_name_id'])->and_where('date','=',$tran_date)->execute()->current();
        $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['from']['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
        
        
       
        
        $price_ch = DB::select()->from('routeprice')
        ->where('route_name_id','=',$route['from']['route_name_id'])
        ->and_where('route_city_from_id','=',$route['from']['route_city_id'])
        ->and_where('route_city_to_id','=',$route['to']['route_city_id'])
        ->and_where('valute','=',$ses_valute)
        ->execute()->current();
        
        if(empty($price_ch)){
        $price_ch = DB::select()->from('routeprice')
        ->where('route_name_id','=',$route['from']['route_name_id'])
        ->and_where('route_city_from_id','=',$route['from']['route_city_id'])
        ->and_where('route_city_to_id','=',$route['to']['route_city_id'])
        ->execute()->current();
        }
       
       
       
        $valute = $price_ch['valute'];    
        $price = $price_ch['price'];
        
        if(!empty($price)){ 
        if($valute == 'ua'){
        $valute = 'UAH';
        }
        if($valute == 'cs'){
        $valute = 'CZK';
        }
        $new_price = Googlecon::con($valute,$ses_valute,$price);
        $valute = $new_price[1];
        $price = $new_price[0];
        }

        ?>
        <div class="one_blol_search_route first_people">
       
            <div class="selector-heading-result left_ser">
                <div class="col-md-1 label--departure cell"><?=$route_name['name'];?></div>
                <div class="col-md-1 label--departure cell"><?=$route['from']['hours'];?>-</div>
                <div class="col-md-1 label--transfer cell"><i class="fa fa-angle-right fa-1x"></i></div>
                <div class="col-md-1 label--arrival cell"> <?=$route['to']['a_hours'];?>-</div>
                <div class="col-md-1 label--transfer cell">0</div>
                <div class="col-md-1 label--transfer cell"><?//=$all_plase_free;?>-</div>
                <div class="col-md-3 label--details cell"><?//=$fermann_id['name'];?>OPEN</div>
                <div class="info_for_sell" style="display: none;">
                    <input type="text" class="route_name_id" value="<?=$route_name['route_name_id'];?>" />
                    <input type="text" class="from_id" value="<?=$route['from']['route_city_id'];?>" />
                    <input type="text" class="to_id" value="<?=$route['to']['route_city_id'];?>" />
                </div>
                <div class="col-md-3 label-price-btm "><button onclick="$(this).parents('.left_ser').next('.hide_div').toggle(),start_open($(this),'<?=$route_name['route_name_id'];?>','<?=$route['from']['date'];?>','<?=$route['from']['route_city_id'];?>','<?=$route['to']['route_city_id'];?>',1)" class="btm-edit btn btn-success buy-btm"> <?=__("Choice ticket")?> <i class="fa fa-cart-arrow-down"></i></button></div>              
            </div>
            <div class="hide_div col-md-12 one_par">
               
               <div class="des-bus row"><div class="col-md-4"><h4><?=$city_from['name_i18n'];?> <?=__("Platform")?>: </h4><h6><?=$route['from']['hours'];?> Date <?//=date('d.m.Y',strtotime($route['from']['date']));?></h6></div>  <div class="col-md-1"><i class="fa fa-angle-right fa-1x"></i></div>  <div class="col-md-4"><h4><?=$city_to['name_i18n'];?>  <?=__("Platform")?>: </h4><h6> Date </h6></div></div>
               
               <div class="row">
                <div class="salon col-md-2"></div>
                
                <div class="all_people col-md-10">
                
                
                    <div class="peo_after"></div>
                </div>
                </div>
            </div>

        </div>
        <div class="clearfix">&nbsp;</div>
    <?}?>    
    <? }?>
    </div>
               
  
    <div class="clearfix">&nbsp;</div>
</div>
<div class="clearfix">&nbsp;</div>
<script type="text/javascript">
function start(thiss,RouteNameID,dateText,From,To,wey){
    
    //alert(dateText);
    
    $(".ajax_load").show();
    
    var Salon = thiss.parents('.one_blol_search_route').find('.salon');
    thiss.parents('.one_blol_search_route').addClass('activ_now');
    var SchemaHTml = '';
    $.ajax({
            type: "POST",
            url: "/buses/ajax_see_schema_svitgo_for_search_route",
            data: {route_name_id:RouteNameID,date:dateText,from:From,to:To,rice:1,wey:wey},
            async: false,
            success: function(data) {
                //alert(data);
                ///writeCall(data);
                SchemaHTml = data;
                
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_schema_svitgo_for_search_route");
            },
       });
      Salon.html(SchemaHTml);
      thiss.parents('.main_routes').find('.one_blol_search_route').each(function(){
          if(!$(this).hasClass('activ_now')){
            $(this).remove();
          }
      })
      //thiss.parents('.one_blol_search_route').show();
      setTimeout(HideAnimm,500);
}

function start_open(thiss,RouteNameID,dateText,From,To,wey){
    
    //alert(wey);
    
    $(".ajax_load").show();
    
    var Salon = thiss.parents('.one_blol_search_route').find('.salon');
    thiss.parents('.one_blol_search_route').addClass('activ_now');
    var SchemaHTml = '';
    $.ajax({
            type: "POST",
            url: "/sysuser/ajax_get_select_open",
            data: {route_name_id:RouteNameID,date:$('#datepicker_sell').val(),from:From,to:To,rice:1,wey:wey},
            async: false,
            success: function(data) {
                //alert(data);
                ///writeCall(data);
                SchemaHTml = data;
                
            },
            error:function(code, opt, err){
                alert("Ошибка : ajax_see_schema_svitgo_for_search_route");
            },
       });
      Salon.html(SchemaHTml);
      thiss.parents('.main_routes').find('.one_blol_search_route').each(function(){
          if(!$(this).hasClass('activ_now')){
            $(this).remove();
          }
      })
      //thiss.parents('.one_blol_search_route').show();
      setTimeout(HideAnimm,500);
}
function HideAnimm(){
    $(".ajax_load").hide();
}
</script>