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

Demo ticket

<?=$tik['name'].' '.$tik['soname'];?>
<br>
<?php echo $tik['maska'];?>
<br>
<?=$from['city_i18n']?>, <?=$from['name_i18n']?>
<br>
<?=$to['city_i18n']?>, <?=$to['name_i18n']?>

</div>

<div style="padding: 5px;" class="ticket-nikolo">

<?=$tik2['name'].' '.$tik2['soname'];?>

<br>

<?php echo $tik2['maska'];?>
<br>
<?=$from2['city_i18n']?>, <?=$from2['name_i18n']?>
<br>

<?=$to2['city_i18n']?>, <?=$to2['name_i18n']?> 

</div>


