

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




<DIV id="page_1">
 


<DIV id="id_1">
<TABLE cellpadding=0 cellspacing=0 class="t1 p-t-30">
<TR>
	
    <TD class="t3"><IMG src="https://svitgo.com.ua/img/logosvitgo.png" id="img1"></TD>
    <TD class="tr0 td0"><P class="p0 ft0"><?=__('Order number');?></P></TD>
    <TD class="tr0 td0"><P class="p0 ft0"><?=__('Ticket number');?></P></TD>
	<TD class="tr0 td1"><P class="p0 ft1"><?=__('Phone');?></P></TD> 
</TR>

<TR>
	
    <TD class="t3"></TD>
    <TD class="tr0 td0"><P class="p0 ft0"><P class="p1 ft2"><NOBR>-</NOBR></P></TD>
    <TD class="tr0 td0"><P class="p0 ft0"><P class="p1 ft2"><NOBR><?php echo $tik['ticket_id'];?></NOBR></P></TD>
	<TD class="tr0 td1"><P class="p0 ft1"><P class="p1 ft2"><NOBR>-</NOBR></P></TD>
</TR>

</TABLE>


<table class="t1 ">
<tbody>
<tr>
<div class="m-t-30 m-t-30" style="text-align:center; padding:10px; background:#ececec">

<p class="p5 ft8"><?=__('Direction');?></p>

</div>
</tr>


<tr class="m-t-30">
<td class="tr3 td11"></td>
<td width="40%"><P class="p3 ft0"><?=__('Departure');?></P>



<P class="p3 ft2" style="padding-top:10px;"> <?=$from['city_i18n']?></P>

<p class="p3 ft0"><!--Россия--></p>

<p class="p3 ft6" style="padding-top:20px;"> <?=date('d/m/Y',strtotime($tik['route_date']));?><!--06 Март 2016, воскресенье--></p>
<p class="p3 ft0"><?=date('H:i',strtotime($tik['route_time']));?>, <?=$from['name_i18n']?>, <?=$platform_from['value'];?></p>
</td>

<td width="40%"><P class="p3 ft0"><?=__('Arrival');?></P>



<P class="p3 ft2" style="padding-top:10px;"> 
	
 <?=$to['city_i18n']?></P>

<p class="p3 ft0"><!--Россия--></p>

<p class="p3 ft6" style="padding-top:20px;"><? if($tik['route_date_end'] != '0000-00-00'){ echo date('d/m/Y',strtotime($tik['route_date_end']));}else{ $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']);} ?><!--06 Март 2016, воскресенье--></p>
<p class="p3 ft0"><?=date('H:i',strtotime($tik['route_timeto']));?>  , <?=$to['name_i18n']?>, <?=$platform_to['value'];?></p>
</td>
</tr>

</tbody>
</table>






<table>

<tbody>

<div class="m-t-30 m-t-30"  style="text-align:center; padding:10px; background:#ececec">

<p class="p5 ft8"><?=__('Passenger');?></p>

</div>
<tr>

<td class="tdpas" width="40%"><p class="p3 ft6"><?=__('First Name');?> <?=__('Last Name');?></p></td>

<td class="tdpas" width="20%"><p class="p3 ft6"><?=__('Birth date');?></p></td>

<td class="tdpas" width="20%"><p class="p3 ft6"><?=__('Place in the bus');?></p></td>


<td class="tdpas" width="20%"><p class="p3 ft6"><?=__('Tariff');?></p></td>


<td class="tdpas"><p class="p3 ft6"><?=__('Price');?></p></td>


</tr>

<tr>

<td class="tdpastext" width="40%"><p class="p3 ft6"><?=$tik['name'].' '.$tik['soname'];?></p></td>

<td class="tdpastext" width="20%"><p class="p3 ft6">-</p></td>

<td class="tdpastext" width="20%"><p class="p3 ft6"> <?=$tik['value']?></p></td>


<td class="tdpastext" width="20%"><p class="p3 ft6"><?=$discount['name_tiket'];?></p></td>


<td class="tdpastext"><p class="p3 ft6"><?=$tik['route_price_discount'].' '.$tik['valute'];?></p></td>


</tr>


</tbody>
</table>



</DIV>

<div class="m-t-30 m-t-30"  style="text-align:center; padding:10px; background:#ececec">

<p class="p5 ft8"><?=__('Tickets payment');?></p>

</div>

<DIV id="id_2">
<DIV id="id_2_1">
<TABLE cellpadding=0 cellspacing=0 class="t2">


<TR>
	<TD class="tr0 td56" width="20%"><P class="p11 ft0"><?=__('Agent');?></P></TD>
	<TD  class="tr0 td57" width="20%"><P class="p12 ft0"><?=__('Status');?></P></TD>
    
    <TD  class="tr0 td57" width="60%"><P class="p12 ft0"><?=__('Date of sale');?></P></TD>
    
</TR>
<TR>
	<TD class="tr11 td56"><P class="p11 ft6"><?=$sususer['login'];?></P></TD>
	<TD  class="tr11 td57"><P class="p12 ft12"><?=__('Paid in full');?></P></TD>
    <TD class="tr11 td56"><P class="p11 ft6"><?php echo date('d.m.Y');?>   </P></TD>

</TR>

</TABLE>

</DIV>

</DIV>






<!--<DIV id="id_3">
<P class="p14 ft16">Время отправления указано местное.</P>

<P class="p19 ft16">В момент посадки при себе необходимо иметь оригиналы паспортов всех путешественников (для детей - свидетельства о рождении). Для Вашего удобства мы рекомендуем распечатать эту квитанцию.</P>
<P class="p20 ft16">При проезде в транспортном средстве, осуществляющем регулярные перевозки пассажиров и багажа, пассажир имеет право:</P>
<P class="p21 ft16"><SPAN class="ft16">1)</SPAN><SPAN class="ft18">провозить с собой бесплатно ручную кладь в количестве не более одного места, длина, ширина и высота которого в сумме не превышают сто двадцать сантиметров, одну пару лыж в чехле, детские санки, детскую коляску, сохранность которых при перевозке обеспечивается пассажиром;</SPAN></P>
<P class="p22 ft16"><SPAN class="ft16">2)</SPAN><SPAN class="ft18">перевозить за плату в багажном отделении транспортного средства или в отдельном транспортном средстве багаж в количестве не более двух мест, длина, ширина и высота которого в сумме не превышают сто восемьдесят сантиметров.</SPAN></P>
<P class="p23 ft16">Условия договора:</P>
<P class="p24 ft16">Договор перевозки считается заключенным и вступившим в силу с момента покупки Вами билета. Настоящая квитанция является подтверждением факта покупки указанного в квитанции билета на указанный рейс.</P>
<P class="p25 ft16">Перевозка и другие предоставляемые перевозчиком услуги подчиняются всем условиям договора перевозки, правилам перевозки и правилам применения выбранного вами тарифа, являющихся неотъемлемой частью этого договора. Условия вашего договора перевозки включены в настоящий билет, посредством ссылки на таковые. С условиями договора перевозки (правилами перевозки, правилами применения тарифа) можно ознакомиться в офисе продаж Перевозчика или на сайте Перевозчика.</P>
</DIV>-->
</DIV>
<DIV id="page_2">


<P class="p26 ft16">Возврат электронного билета можно произвести в кассе Перевозчика.</P>
</DIV>


