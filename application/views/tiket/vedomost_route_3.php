<style>
.del_one {
    cursor: pointer;
    color: red;
}
</style>

<? 
$all_cassa = 0;
$route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
echo ''; ?>

<?
$al_tik_date_from = DB::select()->from('ticket')
                ->where('route_name_id','=',$route['route_name_id'])
                ->and_where('route_date','=',$route['date'])
                ->and_where('ferryman_id','=',$route['ferryman_id'])
                ->order_by('route_city_from_id')
                ->and_where('ticket_type_id','=',1)
                //->or_where('ticket_type_id','=',2)
                //->or_where('ticket_type_id','=',4)
                ->execute()->as_array();
                
 $al_tik_date_from_reverse = DB::select()->from('ticket')
                ->where('route_name_id','=',$route['route_name_id'])
                ->and_where('route_date','=',$route['date'])
                ->and_where('ferryman_id','=',$route['ferryman_id'])
                ->order_by('route_city_from_id')
                ->and_where('ticket_type_id','=',2)
                //->or_where('ticket_type_id','=',2)
                //->or_where('ticket_type_id','=',4)
                ->execute()->as_array();                


 foreach($al_tik_date_from_reverse as $r){
    array_push($al_tik_date_from,$r);
 }

$new_tik = array(); 
$df = 0;  
foreach($al_tik_date_from as $tik_from){
    if($df == 1){
        $df = 0;
    }
    $valute =  DB::select()->from('ticket_valute')->where('tiket_id','=',$tik_from['ticket_id'])->execute()->current();
    $new_name = DB::select()->from('system_users')->where('id','=',$tik_from['user_id'])->execute()->current();
    $proc_price =  trim($tik_from['route_price_discount'])/100 * trim($new_name['procent']);
    $proc_price += 0;
    //var_dump($proc_price);
    $tik_from['route_price_discount'] += 0;
    //var_dump($tik_from['route_price_discount']);
    $proc_price_minus =  $tik_from['route_price_discount'] - $proc_price;
    $one = array($tik_from['route_price_discount'],$valute['valute'],$new_name['procent'],$proc_price_minus);
    $one['valute'] = $valute['valute'];
    $new_tik[] = $one;
} 

//echo '<pre>';
//print_r($new_tik);
//echo '</pre>';
//die;
$sort_array = array();

if(!empty($new_tik)){
    $sort_array = sortt($new_tik);
}


function sortt($array){
        foreach($array as $arr) {
            $new['valute'][] = $arr['valute'];
        }
        array_multisort($new['valute'], constant('SORT_ASC'), $array);
        return $array;
}

$new_tik = array();
foreach($sort_array as $tik_from){
    $new_tik[$tik_from['valute']][] = $tik_from;
} 
$chez_user_tik = 0;
if(isset($new_tik['CZK'])){
    foreach($new_tik['CZK'] as $CZK){
        $chez_user_tik += $CZK[3];
    }
}

$uah_user_tik = 0;
if(isset($new_tik['UAH'])){
    foreach($new_tik['UAH'] as $UAH){
        $uah_user_tik += $UAH[3];
    }
}

$eur_user_tik = 0;
if(isset($new_tik['EUR'])){
    foreach($new_tik['EUR'] as $EUR){
        $eur_user_tik += $EUR[3];
    }
}

$pln_user_tik = 0;
if(isset($new_tik['PLN'])){
    foreach($new_tik['PLN'] as $PLN){
        $pln_user_tik += $PLN[3];
    }
}
/*



echo '<pre>';
print_r($new_tik);
echo '</pre>';

echo 'CZK - '.$chez_user_tik;

echo 'UAH - '.$uah_user_tik;

echo 'EUR - '.$eur_user_tik;
*/
?>

<input type="hidden" class="cur_url" value="<?=$_SERVER['REQUEST_URI'];?>" />
<input type="hidden" class="rou_id" value="<?=$_GET['id'];?>" />
<input type="hidden" class="datete" value="<?=$_GET['date'];?>" />

            <div class="bg-top-filters">
            <div class="content">  
   
            <form>
            <span><h3><?=__("Exchange rates")?></h3>
            
            
            
            <div class="col-md-4">
            
            
             1 EUR = <?$new_price = Googlecon::con('EUR','CZK',1); echo $new_price[0];?> CZK </span>
           ( <? $new_price = Googlecon::con('EUR','CZK',1); echo $new_price[0];?>
            
            <? $new_curs_eur = $new_price[0];
                if(isset($_GET['curs_eur'])){
                    $new_curs_eur = $_GET['curs_eur'];
                }
            ?> )
            <input type="hidden" name="id" value="<?=$_GET['id'];?>" />
            
            <input type="hidden" name="date" value="<?=$_GET['date'];?>" />
            
          <br>  <input type="text" name="curs_eur" value="<?=$new_curs_eur;?>" />
            
         
         </div>
         
         
         
             <div class="col-md-4">
         
            <span> 
            
            1 UAH = <?$new_price = Googlecon::con('UAH','CZK',1); echo $new_price[0];?> CZK</span>
            
            <?$new_price = Googlecon::con('UAH','CZK',1); echo $new_price[0];?>
            
            <? $new_curs_uah = $new_price[0];
                if(isset($_GET['curs_uah'])){
                    $new_curs_uah = $_GET['curs_uah'];
                }
            ?> )
            <br><input type="text" name="curs_uah"  value="<?=$new_curs_uah;?>" />
            
            
            
            </div>
                <div class="col-md-4">
            
            <span> 1 PLN = <?$new_price = Googlecon::con('PLN','CZK',1); echo $new_price[0];?> CZK</span>
            
         (   <?$new_price = Googlecon::con('PLN','CZK',1); echo $new_price[0];?>
            
            <? $new_curs_pln = $new_price[0];
                if(isset($_GET['curs_pln'])){
                    $new_curs_pln = $_GET['curs_pln'];
                }
            ?>)
            
            <br><input type="text" name="curs_pln"  value="<?=$new_curs_pln;?>" />
            <br>  <br>
            </div>
            
            <button class="btn btn-primary btn-cons" type="button"><?=__("Save changes")?></button>
            </form>
           
           </div>
           </div>
           
           
           <div class="content">  
   
           
            <div class="col-md-12">
        <div class="grid-body no-border email-body" style="min-height: 850px;">
            <div class=""><h2 class=" inline"><?=__("Payroll")?></h2></div>
            <div class=""><h4 class=" inline"><?=__("You can check your daily transport departure and all history of departures")?></h4></div>
            <div class=""><h6 class="inline rou_name"><?=__("Route")?>: <?=$route_name['name']; echo ' '.$route_name['name_i18n'];?></h6><br /> <h6 class="inline"><?=__("Date")?>:</h6> <h6 class="inline rou_date"><?=date('d.m.Y',strtotime($_GET['date']));?>,</h6> <br /><h6 class="inline rou_bus"><?=__("Bus")?>: <? $buses = DB::select()->from('buses')->where('buses_id','=',$route['buses_id'])->execute()->current(); print_r($buses['schema_name']);?></h6> <h6 class=" inline"><?=__("RN")?>: ........</h6> <h6 class="inline rou_nomber"><?=__("Bus number")?> - <?=$buses['gosnumber'];?></h6></div>
            <table class="table table-hover  table-condensed" id="example">
                <thead>
                    <tr>
                        <th align="center"><?=__("Country")?>:</th>
                        <th><?=__("UAH")?></th>
                        <th><?=__("CZK")?></th>
                        <th><?=__("EUR")?></th>
                        <th><?=__("PLN")?></th>
                        <th><?=__("Total")?> CZK</th>
                    </tr>
                </thead>
                <tbody id="example_bod">
                    <? $total_UAH = 0; $total_CZK = 0; $total_EUR = 0; $total_PLN = 0; $total_all_CZK = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0; $all_summ = 0;?>
                    <tr class="need">
                        <td><?=__("Currency / Exchange rate")?></td>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Currency','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0]; }?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Currency','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Currency','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Currency','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Oil")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Oil','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Oil','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Oil','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Oil','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Highway")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Highway','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Highway','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Highway','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Highway','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Customs fees")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Customs fees','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Customs fees','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Customs fees','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Customs fees','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Other charges")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other charges','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other charges','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other charges','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other charges','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Hotel")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Hotel','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Hotel','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Hotel','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Hotel','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Repairs")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Repairs','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Repairs','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Repairs','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Repairs','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Service")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Service','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].'</td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Service','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].'</td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Service','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].'</td>'; $total_EUR += $info['price']; $new_price_ =Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Service','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Drivers")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Drivers','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Drivers','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Drivers','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Drivers','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr class="need">
                        <td><?=__("Stevardka")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Stevardka','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Stevardka','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Stevardka','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Stevardka','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr>
                        <td><?=__("Other expenses")?> </td>
                        <? $total = 0; $total_all_CZK_CZK = 0; $total_all_CZK_UAH = 0; $total_all_CZK_EUR = 0; $total_all_CZK_PLN = 0;?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other expenses','UAH'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_UAH += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_uah); $total_all_CZK_UAH = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other expenses','CZK'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_CZK += $info['price']; $total_all_CZK_CZK = $info['price'];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other expenses','EUR'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_EUR += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_eur); $total_all_CZK_EUR = $new_price_[0];}?>
                        <? $info = Model::factory('TiketMod')->get_info_ved3($_GET['id'],$_GET['date'],'Other expenses','PLN'); if(empty($info)){ echo '<td></td>'; }else{ echo '<td>'.$info['price'].' '.$info['valute'].' <span class="del_one" data-id="'.$info['ved_id'].'">X</span></td>'; $total_PLN += $info['price']; $new_price_ = Googlecon::con_sam($info['price'],$new_curs_pln); $total_all_CZK_PLN = $new_price_[0];}?>
                        <td><? $total = $total_all_CZK_UAH + $total_all_CZK_CZK + $total_all_CZK_EUR  + $total_all_CZK_PLN; echo $total; $all_summ += $total; ?> CZK</td>
                    </tr>
                    <tr>
                        <td align="center"><?=__("Total cost")?>:</td>
                        <td><?=$total_UAH;?></td>
                        <td><?=$total_CZK;?></td>
                        <td><?=$total_EUR;?></td>
                        <td><?=$total_PLN;?></td>
                        <td><?=$all_summ;?> CZK</td>
                    </tr>
                    <tr>
                        <? $tot_sales = 0;?>
                        <td align="center"><?=__("Total sales")?>:</td>
                        <td><?=$uah_user_tik; $new_price_tot_uah = Googlecon::con_sam($uah_user_tik,$new_curs_uah); ?> UAH</td>
                        <td><?=$chez_user_tik;?> CZK</td>
                        <td><?=$eur_user_tik; $new_price_tot_eur = Googlecon::con_sam($eur_user_tik,$new_curs_eur); ?> EUR</td>
                        <td><?=$pln_user_tik; $new_price_tot_pln = Googlecon::con_sam($pln_user_tik,$new_curs_pln); ?> PLN</td>
                        <td><? $tot_sales = $new_price_tot_uah[0] + $chez_user_tik + $new_price_tot_eur[0] + $new_price_tot_pln[0]; echo $tot_sales; ?> CZK</td>
                    </tr>
                    <tr class="need1">
                        <td colspan="5">
                            <span class="money-seller-cash"><?=__('Full amount');?>: </span><br />
                        </td>
                    </tr>
                    <tr class="hiddd">
                        <td colspan="5">
                            <div class="col-md-12 ">
                                <div class="pull-right">
                                    <button type="submit"  class="pri_ved_but btn btn-success  btn-xs" ><?=__("Print");?></button>
                                    <button type="submit"  class="cre_csv btn btn-default  btn-xs btn-primary"><?=__("Export to Excel");?></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-top-filters" >
        <div class="col-md-12"><div class=""><h2><?=__('Add Data');?></h2></div>
            <div class="row parr">
                <div class="col-md-3"><?=__("Oil")?></div>
                <input type="hidden" class="type" value="Oil" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Highway")?></div>
                <input type="hidden" class="type" value="Highway" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Customs fees")?></div>
                <input type="hidden" class="type" value="Customs fees" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Other charges")?></div>
                <input type="hidden" class="type" value="Other charges" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Hotel")?></div>
                <input type="hidden" class="type" value="Hotel" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Repairs")?></div>
                <input type="hidden" class="type" value="Repairs" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Service")?></div>
                <input type="hidden" class="type" value="Service" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Drivers")?></div>
                <input type="hidden" class="type" value="Drivers" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Stevardka")?></div>
                <input type="hidden" class="type" value="Stevardka" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
            <div class="row parr">
                <div class="col-md-3"><?=__("Other expenses")?></div>
                <input type="hidden" class="type" value="Other expenses" />
                <div class="col-md-2"><input class="filds-ost-desc form-control pri" type="text" value="" placeholder="<?=__('amount');?>" ></div>
                <div class="col-md-2">
                    <select name="val" class="vall form-control">
                        <option value="CZK">CZK</option>
                        <option value="UAH">UAH</option>
                        <option value="PLN">PLN</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Save');?></button>
                </div>
            </div>
            <hr />
        </div>
    </div>
</div>

<script type="text/javascript">
$('.cre_csv').click(function(){
    var ID = 'example_bod';
    var printContents = document.getElementById(ID).innerHTML;
    
    //var Arrr = [];
    //$('#print_ved_block .name-seller-cash').each(function(){
    //    Arrr.push($(this).text());
    //})
    $('.rou_name').text();
    $('.rou_nomber').text();
    $('.rou_date').text();
    $('.rou_bus').text();
    //alert();
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/create_ajax_csv_ved_3",
        //async: false,
        data: {html:printContents,name:$('.rou_name').text(),nomer:$('.rou_nomber').text(),date:$('.rou_date').text(),bus:$('.rou_bus').text()},
        success: function(data) {
            //alert(data);
            location="/vedomost/csv_file.csv";
        },
        error:function(){
            alert('ошибка cre_csv');
        }
    });
})


$('.del_one').click(function(){
    var ID = $(this).data('id');
    //alert(ID);
    //exit;
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_dell_ved_3",
        data: {id:ID},
        async: false,
        success: function(data) {
            //alert(data);
            ///writeCall(data);
            //SchemaHTml = data;
            location=''+$('.cur_url').val();
            
        },
        error:function(code, opt, err){
            alert("Ошибка : /tiket/ajax_save_vedomost_3");
        }
   });
})


$('.save_one').click(function(){
    var Parr = $(this).parents('.parr');
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_save_vedomost_3",
        data: {route_name_id:$('.rou_id').val(),date:$('.datete').val(),type:Parr.find('.type').val(),price:Parr.find('.pri').val(),valute:Parr.find('.vall').val()},
        async: false,
        success: function(data) {
            //alert(data);
            ///writeCall(data);
            //SchemaHTml = data;
            location=''+$('.cur_url').val();
            
        },
        error:function(code, opt, err){
            alert("Ошибка : /tiket/ajax_save_vedomost_3");
        }
   });
})

$('.pri_ved_but').click(function(){
    var Div = 'example';
    //alert(Div);
    $('.hiddd').remove();  
    printDiv(Div);
    var CUR = $('.cur_url').val();
    location=CUR;
})


function printDiv(ID) {
    $('.rou_name').text();
    $('.rou_nomber').text();
    $('.rou_date').text();
    $('.rou_bus').text();
     
     var printContents = document.getElementById(ID).innerHTML;
     //alert(printContents);
     //exit;
     var originalContents = document.body.innerHTML;

      
        
     document.body.innerHTML = '<h4>'+$('.rou_name').text()+'</h4><h4>'+$('.rou_date').text()+'</h4><h4>'+$('.rou_bus').text()+'</h4><h4>'+$('.rou_nomber').text()+'</h4><table>'+printContents+'</table>';

     window.print();

     document.body.innerHTML = originalContents;
     
     //window.close();
}

</script>