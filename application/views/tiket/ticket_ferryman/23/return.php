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
        .all-ticket { font-family:Verdana, Geneva, sans-serif; font-size:60%;}
	.all-ticket h2 { font-size:14px !important; padding:0px; margin:0px;} 
.ticket-nikolo	hr { margin: 0px 0px  0px 0px; }

	
	.all-ticket tr { padding:0px; margin:0px;} 
	
	
</style>
<? //echo '<pre>'; print_r($discount[0][0]['distance']); echo '</pre>';?>
<div style="padding: 5px;" class="ticket-nikolo">
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusová jízdenka - Doklad cestujícího.</h2>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['name'].' '.$tik['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=__('Nast.');?>: <?=$platform_from['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from['address'];?></div>
        </td>
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik['route_date']));?> <?=date('H:i',strtotime($tik['route_time']));?></div>
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to['city_i18n']?>, <?=$to['name_i18n']?> </div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$to['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?>  <?=date('H:i',strtotime($tik['route_timeto']));?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer['name'];?></div>
        </td>
    </tr>
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik['route_price'].' '.$tik['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['route_price_discount'].' '.$tik['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>informace:</td>
    </tr>
    <tr>
        <td style="font-size:7px">Tranzit přes Polsko 1 zavazadlo do 25 kg - zdarma, každé další za poplatek 200 CZK. Čas příjezdu je orientační. Jízdné je osvobozeno od DPH dle § 70.<br>
        Podmínky pro vrácení jízdenky: do 48 h před odjezdem - sankce 25%, mezi 48 a 6 hod. před odjezdem - sankce 50 %, méně než 6 hodin před odjezdem - sankce 100 %</td>
    </tr>
</table> 
<br>
<br>
<br>
<br>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusova jízdenka - Kontrolní kupón. 1</h2>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['name'].' '.$tik['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=__('Nast.');?>: <?=$platform_from['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from['address'];?></div>
        </td>	
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik['route_date']));?> <?=date('H:i',strtotime($tik['route_time']));?></div>
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to['city_i18n']?>, <?=$to['name_i18n']?> </div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$to['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?>  <?=date('H:i',strtotime($tik['route_timeto']));?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer['name'];?></div>
        </td>
    </tr>
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik['route_price'].' '.$tik['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['route_price_discount'].' '.$tik['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>



<br>
</br>
<br>
<br>
<br>



<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusova jízdenka - Interní doklad. </h2>
        </td>
    </tr>
    <tr>
        <td> 
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['name'].' '.$tik['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from['city_i18n']?>, <?=$from['name_i18n']?> <?=__('Nast.');?>: <?=$platform_from['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from['address'];?></div>
        </td>
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik['route_date']));?> <?=date('H:i',strtotime($tik['route_time']));?></div> 
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to['city_i18n']?>, <?=$to['name_i18n']?> </div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$to['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?>  <?=date('H:i',strtotime($tik['route_timeto']));?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer['name'];?></div>
        </td>
    </tr> 
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik['route_price'].' '.$tik['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik['route_price_discount'].' '.$tik['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>
<br>
 
</div>

<div style="padding: 5px;" class="ticket-nikolo">







<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusová jízdenka - Doklad cestujícího.</h2>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['name'].' '.$tik2['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik2['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=__('PL.');?>: <?=$platform_from2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from2['address'];?></div>
        </td>
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik2['route_date']));?> <?=date('H:i',strtotime($tik2['route_time']));?></div>
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=__('PL.');?>: <?=$platform_to2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa:
             <?=$to2['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik2['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik2['route_date_end']));}else{ $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']);} ?> <?=date('H:i',strtotime($tik2['route_timeto']));?>  </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer2['name'];?></div>
        </td>
    </tr>
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount2['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik2['route_price'].' '.$tik2['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['route_price_discount'].' '.$tik2['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>informace:</td>
    </tr>
    <tr>
        <td style="font-size:7px">Tranzit přes Polsko 1 zavazadlo do 25 kg - zdarma, každé další za poplatek 200 CZK. Čas příjezdu je orientační. Jízdné je osvobozeno od DPH dle § 70.<br>
        Podmínky pro vrácení jízdenky: do 48 h před odjezdem - sankce 25%, mezi 48 a 6 hod. před odjezdem - sankce 50 %, méně než 6 hodin před odjezdem - sankce 100 %</td>
    </tr>
</table> 
</br>
</br>
</br>
</br>





<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusova jízdenka - Kontrolní kupón. 1</h2>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['name'].' '.$tik2['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik2['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=__('PL.');?>: <?=$platform_from2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from2['address'];?></div>
        </td>	
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik2['route_date']));?> <?=date('H:i',strtotime($tik2['route_time']));?></div>
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=__('PL.');?>: <?=$platform_to2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$to2['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik2['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik2['route_date_end']));}else{ $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']);} ?> <?=date('H:i',strtotime($tik2['route_timeto']));?>  </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer2['name'];?></div>
        </td>
    </tr>
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount2['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik2['route_price'].' '.$tik2['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['route_price_discount'].' '.$tik2['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>



<br>
</br>
<br>
<br>
<br>




<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td>
            <h2>Autobusova jízdenka - Interní doklad. </h2>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">cestující:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['name'].' '.$tik2['soname'];?></div>
        </td>
        <td>
            <div class="">číslo jizdenky:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?php echo $tik2['maska'];?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">odkud:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$from2['city_i18n']?>, <?=$from2['name_i18n']?> <?=__('PL.');?>: <?=$platform_from2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$from2['address'];?></div>
        </td>
        <td>
            <div class="">odjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=date('d/m/Y',strtotime($tik2['route_date']));?> <?=date('H:i',strtotime($tik2['route_time']));?></div>
        </td>
        <td style="padding-left:40px;">
            <div class="">sedadlo:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['value']?></div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">kam:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> <?=__('PL.');?>: <?=$platform_to2['value'];?></div><div class="" style="font-weight:bold; font-size:8px"> adresa: <?=$to2['address'];?></div>
        </td>
        <td>
            <div class="">příjezd:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><? if($tik2['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik2['route_date_end']));}else{ $date_to2 = Model::factory('TiketMod')->get_date_to($tik2['route_date'],$tik2['route_name_id'],$tik2['route_time'],$tik2['route_timeto'],$from2['route_city_id'],$to2['route_city_id']);} ?> <?=date('H:i',strtotime($tik2['route_timeto']));?>  </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="">linka:</div>
            <div class="" style="font-size:12px;"><?php echo  $route_name['name'];?></div>
        </td>
        <td>
            <div class="">dopravce:</div>
            <div class="" style="font-size:12px; "><?=$fer2['name'];?></div>
        </td>
    </tr>
</table>
<hr />
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">druh jízdného:</div>
            <div class="" style="font-size:12px;"><?=$discount2['name_simple_i18n'];?></div>
        </td>
        <td width="25%">
            <div class="">cena jízdného:</div>
            <div class="" style="font-size:12px;"><?=$tik2['route_price'].' '.$tik2['valute'];?></div>
        </td>
        <td width="25%">
            <div class="">zavazadla:</div>
            <div class="" style="font-size:12px;"></div>
        </td>
        <td width="25%">
            <div class="">Konečná cena:</div>
            <div class="" style="font-size:12px; font-weight:bold; text-decoration:underline"><?=$tik2['route_price_discount'].' '.$tik2['valute'];?></div>
        </td>
    </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="0" class="all-ticket" width="100%">
    <tr>
        <td width="25%">
            <div class="">prodejce:</div>
            <div class="" style="font-size:12px;"><?=$sususer['login'];?></div>
        </td>
        <td width="25%">
            <div class="" style="border:2px dashed #000; padding:6px; margin-right:5px;">místo pro razítko</div>
        </td>
        <td width="25%">
            <div class="">datum a čas prodeje:</div>
            <div class="" style="font-size:12px;"><?php echo date('d.m.Y');?> <?php echo date('H:i');?></div>
        </td>
        <td width="25%">
        </td>
    </tr>
</table>
<br>
</div>


