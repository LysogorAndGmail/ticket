<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>

<!--<link href="<?=Kohana::$base_url;?>assets/design.css" rel="stylesheet">-->
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
        
    
    $id = $info['buses_id'];    
    
    $ferryman_id = $info['ferryman_id'];
    $route_id = $info['route_name_id'];
    $fro = $from;
    $to = $to;
    $route_date = $info['date'];
    //echo $route_date;
    
    
    
    $all_discount = Model::factory('DiscountMod')->get_all_discount($lang);
    
    $price_array = Model::factory('TiketMod')->chek_price_model($route_id,$from,$to,$ses_valute,$ferryman_id);
    
    //print_r($price_array);
    //die;;
    
    $price = $price_array[0];
    $valute = $price_array[1];
    
            $bus_name = DB::select()->from('buses_i18n')->where('buses_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
            $bus = DB::select()->from('buses')->where('buses_id','=',$id)->execute()->current();
            $all_schema = DB::select()->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
            
            $all_schema_plases = array();
            foreach($all_schema as $al_sh){
                if(is_numeric($al_sh['value'])){
                    $all_schema_plases[] = $al_sh['value'];
                }
                
            }
            
            //
            //echo '<pre>';
            //print_r($all_schema);
            //echo '</pre>';
            //echo $from;
            //echo $to;
            if(empty($all_schema)){
                echo 'нет схемы на - '.$id;
            }
            
            $schema_arr = array();
            foreach($all_schema as $all){
                $schema_arr[$all['schema_name']][$all['dx']][$all['dy']] = $all;
            }
            
            
            //sell
            $sell_array = Model::factory('TiketMod')->sell_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            
            
            // end sell
            //reserv
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            
            //echo '<pre>';
            //print_r($reserv_array);
            //echo '</pre>';
            //die;
            
            
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            } 
           
            $new_block_plase = Model::factory('TiketMod')->block_plase($route_id,$id,$ferryman_id,$fro,$to,$route_date);
            
            
            
            $sysuser_block_plase = Model::factory('TiketMod')->sysuser_block_plase($user_id,$route_id,$id);
            
            
            foreach($sysuser_block_plase as $sys_biz){
                
                array_push($new_block_plase,array('value'=>$sys_biz));
            }
            
            
            
            $old_disp_bizi = Model::factory('TiketMod')->old_disp($route_id,$fro,$to,$route_date); 
            
            foreach($old_disp_bizi as $old_biz){
                
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            
            $all_blocked_plase = Model::factory('BusesMod')->get_blocket_nikolo($route_id,$fro,$to,$route_date);
            
            
            if(!empty($all_blocked_plase)){
                $all_bizi_nikolo = array_diff($all_schema_plases,$all_blocked_plase);
            }else{
                $all_bizi_nikolo = array();
            }
            
            
            if(empty($price)){
                echo __("Contact your administrator.").__("No price.");
                die;
            }
            /*
            $block_plase_array = Model::factory('TiketMod')->block_all($id,$ferryman_id); 
            
            
            
            $all_block_rega = array();
            $search_reg = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$route_id)->execute()->current();
            $ost_reg_from = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$fro)->execute()->current();
            $ost_reg_to = DB::select()->from('regabus_join_osts')->where('svitgo_ost_id','=',$to)->execute()->current(); 
            
            
            if(!empty($search_reg)){
                $new_block = array();
                $route = new stdClass();
                $route->route_id = $search_reg['reg_route_id'];
                $route->from_id = $ost_reg_from['reg_ost_id'];
                $route->to_id = $ost_reg_to['reg_ost_id'];
                $route->date = $route_date;
                $reg = new Regabus();
                $rega = $reg::get_route($route);
                $all_block_rega = $rega[0]->free_seat;
                //print_r($rega[0]);
                //die;
                $valute = 'CZK';
                $price = $rega[0]->price;
                
                foreach($all_schema as $one_pl){
                $new_block[] = $one_pl['value'];  
                }
                if(empty($all_block_rega)){
                    echo 'не совпадают остановки Regabus';
                    die;
                }
                $bloc_reg = array_diff($new_block,$all_block_rega);
                
            }
           
            //sell
            $sell_array = Model::factory('TiketMod')->sell_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            } 
            // end sell
            //reserv
            $reserv_array = Model::factory('TiketMod')->reserv_plase($route_id,$route_date,$id,$ferryman_id,$fro,$to);
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            } 
           
            $new_block_plase = Model::factory('TiketMod')->block_plase($route_id,$id,$ferryman_id,$fro,$to,$route_date);
            
            
            
            $sysuser_block_plase = Model::factory('TiketMod')->sysuser_block_plase($user_id,$route_id,$id);
            
            
            foreach($sysuser_block_plase as $sys_biz){
                
                array_push($new_block_plase,array('value'=>$sys_biz));
            }
            
            
            
            $old_disp_bizi = Model::factory('TiketMod')->old_disp($route_id,$fro,$to,$route_date); 
            
            foreach($old_disp_bizi as $old_biz){
                
                array_push($new_block_plase,array('value'=>$old_biz));
            }
            
            
            
            if(empty($price)){
                echo __("Contact your administrator.").__("No price.");
                die;
            }
            
             */

 ?> 

<input type="hidden" class="sesuser" value="<?=$user_id;?>" />
<input type="hidden" class="ferryman" value="<?=$ferryman_id;?>" />
<input type="hidden" class="buses" value="<?=$id;?>" />
<div class="border-bus left ner_1 bus">  
    <? foreach($schema_arr as $name=>$aa){ ?>
    <div class="one_scem">
        <!--<h4>&nbsp;<?//=$bus_name['name_i18n'];?></h4>-->
        <? foreach($aa as $x=>$ax){?>
        <div class="one_row">
            <? foreach($ax as $y=>$ay){ ?>
                <div class="bus_cres new_cre_1 place occ">
                <?php if($ay['value']=='WC' || $ay['value']=='st' || $ay['value']=='pr' || $ay['value'] == ''){?>
                    <div  class="bscheme-none place empty"><?php echo $ay['value'];?></div>
                    <?php } else {?>
                    <div
                       
                        class="bscheme choise_modal tip 
                           <? if(!empty($bloc_reg)){foreach($bloc_reg as $re_se){ if($ay['value']  == $re_se){ echo "bizi";}} }?> 
                                <? foreach($sell as $bil){ if($ay['value']  == $bil){ echo "bizi sell";}} ?>
                                <? foreach($new_block_plase as $blo){ if($ay['value']  == $blo['value']){ echo "blocket bizi";}} ?>
                                <?// foreach($null as $nul){ if($ay['value']  == $nul){ echo "null";}} ?>  
                                <? foreach($all_bizi_nikolo as $biz_nik){ if($ay['value'] == $biz_nik){ echo " blocket";}} ?>
                                <?// foreach($block_plase_array as $all=>$all_vall){ if($ay['value']  == $all_vall['value']){ echo "bizi";}} ?> 
                                <? foreach($reserv as $res){ if($ay['value']  == $res){ echo "bizi reserv";}} ?>" ><?php echo $ay['value']?></div> 
                    <?php } ?>
                </div>
            <?}?>
        </div>
        <div class="clearfix"></div>
        <?}?>
        
        <br />
    </div>
    <? } ?>
</div>
<div class="bus-info-right left" style="display: none;">  
    <span class="choise-bus-tittle"><h6><? echo __('Your Seat');?></h6></span>
    <div class="dis_all">
        <div class="admin_plases"></div>
        <span class="cur_pri r-bus-price" style="display:none;"><?=$price;?></span><span class="Ch_cr" style="display:none;"><?=$price;?></span><span class="DiID" style="display:none;"></span> 
        <div class="clearfix"></div>
    </div>
    <div class="r-bus-cart-btm"></div>
</div>
<div class="row" style="display: none;">
    <div class="pay-bus-s">
        <div class="medium-6 columns">
            <div class="medium-6 columns">
                <div class="cart b-cart-design">
                    <? echo __('Total');?>: <span class="al">0</span> <span class="al_val"><? echo $valute;?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.choise_modal').click(function(){
    
        if($(this).parent().find('.bizi').html() == null) {
        if($(this).parent().find('.selected_plase').html() == null){
            if(couPeople() == 1){
                $(this).parent().find('.bscheme').addClass('selected_plase');
            }
          
        }else { 
            
            $(this).parent().find('.bscheme').removeClass('selected_plase');
        }
        }
        
    })
function couPeople(){
    var Cou = 1;
    $('.selected_plase').each(function(){
        Cou += 1;
    });
    return Cou;
}
</script>

<!--
<script src="<?=Kohana::$base_url?>assets/js/form_elements.js" type="text/javascript"></script>

<script src="<?=Kohana::$base_url?>assets/js/core.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url?>assets/js/chat.js" type="text/javascript"></script> 
<script src="<?=Kohana::$base_url?>assets/js/demo.js" type="text/javascript"></script>-->