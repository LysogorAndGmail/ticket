<style>
#scissors {
    height: 43px; /* image height */
    width: 90%;
    margin: auto auto;
    background-image: url('http://i.stack.imgur.com/cXciH.png');
    background-repeat: no-repeat;
    background-position: right;
    position: relative;
}
#scissors div {
    position: relative;
    top: 50%;
    border-top: 3px dashed black;
    margin-top: -3px;
}
</style>



<? echo ''; 
$lang = Session::instance()->get('leng');
if(!$lang) {
    $lang = 'EN';
}
I18n::lang($lang);

 
$tik = DB::select()->from('ticket')
->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
->where('ticket_id','=',$id)
->execute()->current();

$tik2 = DB::select()->from('ticket')
->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
->where('ticket_id','=',$id2)
->execute()->current();

$sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
if($tik['user_id'] == 0){
$sususer['login'] = 'SuperAdmin';
}
//echo '<pre>';
//print_r($tik);
//echo '</pre>';
//die;
$discount = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$tik['discount_id'])->and_where('culture','=',$lang)->execute()->current();

$discount2 = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$tik2['discount_id'])->and_where('culture','=',$lang)->execute()->current();



$fer = DB::select()->from('ferryman')->where('ferryman_id','=',$tik['ferryman_id'])->execute()->current();

$rou = DB::select()->from('routename_i18n')->where('route_name_id','=',$tik['route_name_id'])->and_where('culture','=',$lang)->execute()->current();

$from = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
$to = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();


$route_name = DB::select()->from('routename')->where('route_name_id','=',$tik['route_name_id'])->execute()->current();

$fer2 = DB::select()->from('ferryman')->where('ferryman_id','=',$tik2['ferryman_id'])->execute()->current();

$rou2 = DB::select()->from('routename_i18n')->where('route_name_id','=',$tik2['route_name_id'])->and_where('culture','=',$lang)->execute()->current();

$from2 = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik2['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
$to2 = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik2['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();


$r_id_from = DB::select()->from('route')->where('route_name_id','=',$tik['route_name_id'])->and_where('route_city_id','=',$tik['route_city_from_id'])->execute()->current();
$r_id_to = DB::select()->from('route')->where('route_name_id','=',$tik['route_name_id'])->and_where('route_city_id','=',$tik['route_city_to_id'])->execute()->current();

//$platform_from = DB::select()->from('routedistance')->where('route_name_id','=',$tik['route_name_id'])->and_where('r_id','=',$r_id_from['r_id'])->execute()->current();
//$platform_to = DB::select()->from('routedistance')->where('route_name_id','=',$tik['route_name_id'])->and_where('r_id','=',$r_id_to['r_id'])->execute()->current();

$day_week = date('w',strtotime($tik['route_date'].' 00:00:01'));
switch($day_week){
    case 0:
    $day_week = 6;
    break;
    case 1:
    $day_week = 0;
    break;
    case 2:
    $day_week = 1;
    break;
    case 3:
    $day_week = 2;
    break;
    case 4:
    $day_week = 3;
    break;
    case 5:
    $day_week = 4;
    break;
    case 6:
    $day_week = 5;
    break;
}       




$platform_from = DB::select()->from('platform')->where('route_name_id','=',$tik['route_name_id'])->and_where('ost_id','=',$tik['route_city_from_id'])->and_where('day_week','=',$day_week)->execute()->current();
$platform_to = DB::select()->from('platform')->where('route_name_id','=',$tik['route_name_id'])->and_where('ost_id','=',$tik['route_city_to_id'])->and_where('day_week','=',$day_week)->execute()->current();


$r_id_from2 = DB::select()->from('route')->where('route_name_id','=',$tik2['route_name_id'])->and_where('route_city_id','=',$tik2['route_city_from_id'])->execute()->current();
$r_id_to2 = DB::select()->from('route')->where('route_name_id','=',$tik2['route_name_id'])->and_where('route_city_id','=',$tik2['route_city_to_id'])->execute()->current();

$day_week2 = date('w',strtotime($tik2['route_date'].' 00:00:01'));
switch($day_week2){
    case 0:
    $day_week2 = 6;
    break;
    case 1:
    $day_week2 = 0;
    break;
    case 2:
    $day_week2 = 1;
    break;
    case 3:
    $day_week2 = 2;
    break;
    case 4:
    $day_week2 = 3;
    break;
    case 5:
    $day_week2 = 4;
    break;
    case 6:
    $day_week2 = 5;
    break;
}       


$platform_from2 = DB::select()->from('platform')->where('route_name_id','=',$tik2['route_name_id'])->and_where('ost_id','=',$tik2['route_city_from_id'])->and_where('day_week','=',$day_week2)->execute()->current();
$platform_to2 = DB::select()->from('platform')->where('route_name_id','=',$tik2['route_name_id'])->and_where('ost_id','=',$tik2['route_city_to_id'])->and_where('day_week','=',$day_week2)->execute()->current();
?>




<style>
td {
    padding: 5px;
}
span.smalll {
    font-size: 11px;
}
</style>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table border="1" cellpadding="0" cellspacing="0" style="width: 1030px !important; color:black !important;font-size:16px;">
    <tr>
        <td colspan="4" style="text-align: center;"><?=__('Ticket for bus');?></td>
        <td colspan="3" style="text-align: center;">№ <?=__('Ticket');?>: <?php echo $tik['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Passenger');?>:</span><br /><strong><?=$tik['name'].' '.$tik['soname'];?></strong></td>
        <td colspan="3" style="text-align: center;"><?=__('Ticket for passenger');?></td>
        <td style="text-align: center;"><span class="smalll"><?=__('Date of sale');?>:</span><br />
                <?php echo date('d.m.Y');?>         
        </td>
        <td style="text-align: center;"><span class="smalll"><?=__('Time of sale');?>:</span><br />
                <?php echo date('H:i');?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>: <?=$fer['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('One way');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;"><span class="smalll"><?=__('Seller');?>: <?=$sususer['login'];?></span></td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=__('PL.');?>: <?=$platform_from['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_time']));?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik['price'].' '.$tik['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>:<?=$discount['name_tiket'];?></span><br />
            <?=__('TRF');?>: <?=$tik['route_price_discount'].' '.$tik['valute'];?><br />
            <?=__('Total');?>: <?=$tik['route_price_discount'].' '.$tik['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to['city_i18n']?>, <?=$to['name_i18n']?> <?=__('PL.');?>: <?=$platform_to['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_timeto']));?>        
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>: <?=$fer2['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('Return journey');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;">&nbsp;</td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=__('PL.');?>: <?=$platform_from2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik2['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_time']));?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik2['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik2['price'].' '.$tik2['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount2['name_tiket'];?></span><br />
            <?=__('TRF');?>: <? //$raz2 = $tik2['price'] - $tik2['route_price_discount']; echo ' -'.$raz2.' '.$tik2['valute'];?><?=$tik2['route_price_discount'].' '.$tik2['valute'];?><br />
            <?=__('Total');?>: <?$tik_all = $tik['route_price_discount'] + $tik2['route_price_discount']; echo $tik_all.' '.$tik2['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=__('PL.');?>: <?=$platform_to2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
             <? if($tik2['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik2['route_date_end']));}else{ $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']);} ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_timeto']));?>    
        </td>
    </tr>
</table>
<div style="width: 1030px; text-align: center; padding-bottom: 5px;">
"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px; font-size:16px;">
Kontakty REGABUS v ČR: +420 608 822 892, +420 777 228 990            Kontakty REGABUS v Ukrajině: +38 067 675-19-76, +38 095 679-36-56 
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px;">
<img src="http://disp.svitgo.com/img/cutticket.png" width="" height="" />
</div>

<div id="scissors">
    <div></div>
</div>


<table border="1" cellpadding="0" cellspacing="0" style="width: 1030px !important; color:black !important;font-size:16px;">
    <tr>
        <td colspan="4" style="text-align: center;"><?=__('Ticket for bus');?></td>
        <td colspan="3" style="text-align: center;">№ <?=__('Ticket');?>:<?php echo $tik2['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Passenger');?>:</span><br /> <strong><?=$tik['name'].' '.$tik['soname'];?></strong></td>
        <td colspan="3" style="text-align: center;"><?=__('Direction');?>: <?=__('Return journey');?></td>
        <td style="text-align: center;"><span class="smalll"><?=__('Date of sale');?>:</span><br />
                <?php echo date('d.m.Y');?>         
        </td>
        <td style="text-align: center;"><span class="smalll"><?=__('Time of sale');?>:</span><br />
                <?php echo date('H:i');?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>:<?=$fer2['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('Retur journey');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;">&nbsp;</td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=__('PL.');?>: <?=$platform_from2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik2['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_time']));?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik2['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik2['price'].' '.$tik2['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount2['name_tiket'];?></span><br />
            <?=__('TRF');?>: <?=$tik['route_price_discount'].' '.$tik['valute'];?><br />
             <?=__('Total');?>: <?=$tik2['route_price_discount'].' '.$tik2['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=__('PL.');?>: <?=$platform_to2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <? if($tik2['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik2['route_date_end']));}else{ $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']);} ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_timeto']));?>      
        </td>
    </tr>
</table>
<div style="width: 1030px; text-align: center; padding-bottom: 5px;">
"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px; font-size:16px;">
Kontakty REGABUS v ČR: +420 608 822 892, +420 777 228 990            Kontakty REGABUS v Ukrajině: +38 067 675-19-76, +38 095 679-36-56 
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px;">

       <img src="http://disp.svitgo.com/img/cutticket.png" width="" height="" />

</div>








<table border="1" cellpadding="0" cellspacing="0" style="width: 1030px !important; color:black !important;font-size:16px;">
    <tr>
        <td colspan="4" style="text-align: center;"><?=__('Ticket for bus');?></td>
        <td colspan="3" style="text-align: center;">№ <?=__('Ticket');?>:<?php echo $tik['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Passenger');?>:</span><br /> <strong><?=$tik['name'].' '.$tik['soname'];?></strong></td>
        <td colspan="3" style="text-align: center;"><?=__('Direction');?>: <?=__('One way');?></td>
        <td style="text-align: center;"><span class="smalll"><?=__('Date of sale');?>:</span><br />
                <?php echo date('d.m.Y');?>         
        </td>
        <td style="text-align: center;"><span class="smalll"><?=__('Time of sale');?>:</span><br />
                <?php echo date('H:i');?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>:<?=$fer['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('One way');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;"><span class="smalll"><?=__('Seller');?>: <?=$sususer['login'];?></span></td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=__('PL.');?>: <?=$platform_from['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_time']));?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik['price'].' '.$tik['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount['name_tiket'];?></span><br />
            <?=__('TRF');?>:<?=$tik['route_price_discount'].' '.$tik['valute'];?><br />
             <?=__('Total');?>: <?=$tik['route_price_discount'].' '.$tik['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to['city_i18n']?>, <?=$to['name_i18n']?> <?=__('PL.');?>: <?=$platform_to['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=date('H:i',strtotime($tik['route_timeto']));?>         
        </td>
    </tr>
</table>
<div style="width: 1030px; text-align: center; padding-bottom: 5px;">
"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px; font-size:16px;">
Kontakty REGABUS v ČR: +420 608 822 892, +420 777 228 990            Kontakty REGABUS v Ukrajině: +38 067 675-19-76, +38 095 679-36-56 
</div>

<div style="width: 1030px; text-align: center; padding-bottom: 20px;">

 <img src="http://disp.svitgo.com/img/cutticket.png" width="" height="" />
 
 
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>





<?php /*?><table border="1" cellpadding="0" cellspacing="0" style="width: 1030px !important; color:black !important">
    <tr>
        <td colspan="4" style="text-align: center;"><?=__('Ticket for bus');?></td>
        <td colspan="3" style="text-align: center;">№ <?=__('Ticket');?>:<?php echo $tik['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Passenger');?>:</span><br /> <?=$tik['name'].' '.$tik['soname'];?></td>
        <td colspan="3" style="text-align: center;"><?=__("Confirmation for seller")?></td>
        <td style="text-align: center;"><span class="smalll"><?=__('Date of sale');?>:</span><br />
                <?php echo date('d.m.Y');?>         
        </td>
        <td style="text-align: center;"><span class="smalll"><?=__('Time of sale');?>:</span><br />
                <?php echo date('H:i');?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>:<?=$fer['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('One way');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;"><span class="smalll"><?=__('Seller');?>: <?=$sususer['login'];?></span></td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=$platform_from['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=$tik['route_time'];?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik['price'].' '.$tik['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount['name_i18n'];?></span><br />
            <?=__('TRF');?>: <? $raz = $tik['price'] - $tik['route_price_discount']; echo ' -'.$raz.' '.$tik['valute'];?><br />
             <?=__('Total');?>: <?=$tik['route_price_discount'].' '.$tik['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to['city_i18n']?>, <?=$to['name_i18n']?> <?=$platform_to['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <? $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']); ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=$tik['route_timeto'];?>          
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Ferryman');?>:<?=$fer2['name'];?></span></td>
        <td colspan="2"><span class="smalll"><?=__('Direction');?>: <?=__('Retur journey');?></span></td>
        <td><span class="smalll"><?=__('Route');?>: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;">&nbsp;</td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=$platform_from2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <?=date('d/m/Y',strtotime($tik2['route_date']));?>
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            <?=$tik2['route_time'];?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            <?=$tik2['value']?>
        </td>
        <td colspan="2" rowspan="2">
            <?=__('TRF');?>: <?=$tik2['price'].' '.$tik2['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount2['name_i18n'];?></span><br />
            <?=__('TRF');?>: <? $raz2 = $tik2['price'] - $tik2['route_price_discount']; echo ' -'.$raz2.' '.$tik2['valute'];?><br />
             <?=__('Total');?>: <?=$tik2['route_price_discount'].' '.$tik2['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Arrive');?>:</span><br />
            <?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=$platform_to2['value'];?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            <? $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']); ?>
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            <?=$tik2['route_timeto'];?>          
        </td>
    </tr>
</table>
<div style="width: 1030px; text-align: center; padding-bottom: 20px;"><span class="smalll">"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956 </span></div><?php */?>



