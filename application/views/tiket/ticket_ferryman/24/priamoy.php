<? $lang = Session::instance()->get('leng');
if(!$lang) {
    $lang = 'EN';
}
I18n::lang($lang);


 
$tik = DB::select()->from('ticket')
->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
->where('ticket_id','=',$id)
->execute()->current();

$sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
if($tik['user_id'] == 0){
$sususer['login'] = 'SuperAdmin';
}
//echo '<pre>';
//print_r($tik);
//echo '</pre>';

$discount = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$tik['discount_id'])->and_where('culture','=',$lang)->execute()->current();

//die;

$fer = DB::select()->from('ferryman')->where('ferryman_id','=',$tik['ferryman_id'])->execute()->current();

$rou = DB::select()->from('routename_i18n')->where('route_name_id','=',$tik['route_name_id'])->and_where('culture','=',$lang)->execute()->current();

$route_name = DB::select()->from('routename')->where('route_name_id','=',$tik['route_name_id'])->execute()->current();

$from = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
$to = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();


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


?>






<STYLE type="text/css">

body {margin-top: 0px;margin-left: 0px;}

#page_1 {margin: 38px 0px 109px 37px;padding: 0px;border: none;width: 757px;}





#page_2 {position:relative; overflow: hidden;margin: 38px 0px 1075px 38px;padding: 0px;border: none;width: 756px;}





.ft0{font: 11px 'Arial';line-height: 14px;}
.ft1{font: 9px 'Arial';line-height: 12px;}
.ft2{font: 21px 'Arial';line-height: 24px;}
.ft3{font: 1px 'Arial';line-height: 1px;}
.ft4{font: bold 11px 'Arial';line-height: 14px;}
.ft5{font: 1px 'Arial';line-height: 8px;}
.ft6{font: 13px 'Arial';line-height: 16px;}
.ft7{font: 10px 'Arial';line-height: 13px;}
.ft8{font: bold 10px 'Arial';line-height: 12px;}
.ft9{font: 12px 'Arial';line-height: 15px;}
.ft10{font: 1px 'Arial';line-height: 12px;}
.ft11{font: 11px 'Arial';line-height: 12px;}
.ft12{font: 19px 'Arial';line-height: 22px;}
.ft13{font: 1px 'Arial';line-height: 9px;}
.ft14{font: 1px 'Arial';line-height: 13px;}
.ft15{font: 11px 'Arial';line-height: 13px;}
.ft16{font: bold 8px 'Arial';line-height: 10px;}
.ft17{font: 17px 'Arial';line-height: 19px;}
.ft18{font: bold 8px 'Arial';margin-left: 2px;line-height: 10px;}

.p0{text-align: left;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p1{text-align: left;padding-left: 0px;margin-top: 0px;margin-bottom: 0px;}
.p2{text-align: left;padding-left: 43px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p3{text-align: left;padding-left: 3px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p4{text-align: left;padding-left: 5px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p5{text-align: center;padding-left: 11px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p6{text-align: left;padding-left: 7px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p7{text-align: left;padding-left: 6px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p8{text-align: right;padding-right: 33px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p9{text-align: right;padding-right: 52px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p10{text-align: center;padding-left: 12px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p11{text-align: left;padding-left: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p12{text-align: left;padding-left: 0px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p13{text-align: left;padding-left: 124px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p14{text-align: left;padding-left: 1px;margin-top: 46px;margin-bottom: 0px;}
.p15{text-align: left;padding-left: 130px;margin-top: 0px;margin-bottom: 0px;}
.p16{text-align: left;padding-left: 30px;margin-top: 82px;margin-bottom: 0px;}
.p17{text-align: left;padding-left: 40px;margin-top: 0px;margin-bottom: 0px;}
.p18{text-align: right;padding-right: 43px;margin-top: 2px;margin-bottom: 0px;}
.p19{text-align: left;padding-right: 59px;margin-top: 0px;margin-bottom: 0px;}
.p20{text-align: left;margin-top: 10px;margin-bottom: 0px;}
.p21{text-align: justify;padding-left: 26px;padding-right: 52px;margin-top: 10px;margin-bottom: 0px;}
.p22{text-align: justify;padding-left: 26px;padding-right: 48px;margin-top: 0px;margin-bottom: 0px;}
.p23{text-align: left;margin-top: 20px;margin-bottom: 0px;}
.p24{text-align: left;padding-right: 44px;margin-top: 10px;margin-bottom: 0px;}
.p25{text-align: left;padding-right: 52px;margin-top: 10px;margin-bottom: 0px;}
.p26{text-align: left;margin-top: 0px;margin-bottom: 0px;}

.td0{padding: 0px;margin: 0px;width: 240px;vertical-align: bottom;}
.td1{padding: 0px;margin: 0px;width: 107px;vertical-align: bottom;}
.td2{border-left: #f8f8f8 1px solid;border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 118px;vertical-align: bottom;background: #f8f8f8;}
.td3{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;background: #f8f8f8;}
.td4{padding: 0px;margin: 0px;width: 6px;vertical-align: bottom;background: #f8f8f8;}
.td5{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 29px;vertical-align: bottom;background: #f8f8f8;}
.td6{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;background: #f8f8f8;}
.td7{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 99px;vertical-align: bottom;background: #f8f8f8;}
.td8{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;background: #f8f8f8;}
.td9{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;background: #f8f8f8;}
.td10{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;background: #f8f8f8;}
.td11{padding: 0px;margin: 0px;width: 120px;vertical-align: bottom;}
.td12{padding: 0px;margin: 0px;width: 74px;vertical-align: bottom;}
.td13{padding: 0px;margin: 0px;width: 30px;vertical-align: bottom;}
.td14{padding: 0px;margin: 0px;width: 80px;vertical-align: bottom;}
.td15{padding: 0px;margin: 0px;width: 100px;vertical-align: bottom;}
.td16{padding: 0px;margin: 0px;width: 97px;vertical-align: bottom;}
.td17{padding: 0px;margin: 0px;width: 66px;vertical-align: bottom;}
.td18{padding: 0px;margin: 0px;width: 72px;vertical-align: bottom;}
.td19{padding: 0px;margin: 0px;width: 104px;vertical-align: bottom;}
.td20{padding: 0px;margin: 0px;width: 68px;vertical-align: bottom;}
.td21{padding: 0px;margin: 0px;width: 6px;vertical-align: bottom;}
.td22{padding: 0px;margin: 0px;width: 163px;vertical-align: bottom;}
.td23{padding: 0px;margin: 0px;width: 184px;vertical-align: bottom;}
.td24{padding: 0px;margin: 0px;width: 243px;vertical-align: bottom;}
.td25{padding: 0px;margin: 0px;width: 91px;vertical-align: bottom;}
.td26{border-left: #f8f8f8 1px solid;border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 118px;vertical-align: bottom;background: #f8f8f8;}
.td27{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;background: #f8f8f8;}
.td28{border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 6px;vertical-align: bottom;background: #f8f8f8;}
.td29{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 29px;vertical-align: bottom;background: #f8f8f8;}
.td30{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;background: #f8f8f8;}
.td31{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 99px;vertical-align: bottom;background: #f8f8f8;}
.td32{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;background: #f8f8f8;}
.td33{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;background: #f8f8f8;}
.td34{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;background: #f8f8f8;}
.td35{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;background: #f8f8f8;}
.td36{border-right: #f8f8f8 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;}
.td37{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;background: #f8f8f8;}
.td38{border-right: #f8f8f8 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;}
.td39{border-left: #e9e9e9 1px solid;border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 118px;vertical-align: bottom;}
.td40{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;}
.td41{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 29px;vertical-align: bottom;}
.td42{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;}
.td43{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 99px;vertical-align: bottom;}
.td44{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
.td45{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;}
.td46{border-right: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;}
.td47{border-left: #e9e9e9 1px solid;border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 118px;vertical-align: bottom;}
.td48{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;}
.td49{border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 6px;vertical-align: bottom;}
.td50{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 29px;vertical-align: bottom;}
.td51{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 79px;vertical-align: bottom;}
.td52{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 99px;vertical-align: bottom;}
.td53{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
.td54{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;}
.td55{border-right: #e9e9e9 1px solid;border-bottom: #e9e9e9 1px solid;padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;}
.td56{padding: 0px;margin: 0px;width: 156px;vertical-align: bottom;}
.td57{padding: 0px;margin: 0px;width: 283px;vertical-align: bottom;}
.td58{border-left: #f1f1f1 1px solid;border-right: #f1f1f1 1px solid;border-top: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 154px;vertical-align: bottom;}
.td59{border-right: #f1f1f1 1px solid;border-top: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 271px;vertical-align: bottom;}
.td60{padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
.td61{border-left: #f1f1f1 1px solid;border-right: #f1f1f1 1px solid;border-bottom: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 154px;vertical-align: bottom;}
.td62{border-right: #f1f1f1 1px solid;border-bottom: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 271px;vertical-align: bottom;}
.td63{border-left: #f1f1f1 1px solid;border-right: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 154px;vertical-align: bottom;}
.td64{border-right: #f1f1f1 1px solid;padding: 0px;margin: 0px;width: 271px;vertical-align: bottom;}

.tr0{height: 15px;}
.tr1{height: 17px;}
.tr2{height: 8px;}
.tr3{height: 32px;}
.tr4{height: 31px;}
.tr5{height: 27px;}
.tr6{height: 36px;}
.tr7{height: 14px;}
.tr8{height: 26px;}
.tr9{height: 19px;}
.tr10{height: 12px;}
.tr11{height: 22px;}
.tr12{height: 51px;}
.tr13{height: 18px;}
.tr14{height: 9px;}
.tr15{height: 13px;}

.t0{width: 800px;margin-left: 0px;font: 9px 'Arial';}
.t1{width: 100%;font: 11px 'Arial';}
.t2{width: 100%;font: 11px 'Arial';}
.t3{ width:400px;}
.tdpas { padding:10px 10px 10px 10px; background-color:#f4f4f4; -webkit-print-color-adjust: exact; }
.tdpastext { padding:10px 10px 10px 10px; background-color:#fff; -webkit-print-color-adjust: exact; }

.m-t-30 { margin-top:30px;}

.p-t-30 { padding-top:30px;}

.m-t-30 { margin-bottom:30px}
</STYLE>
</HEAD>

<BODY>
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
</BODY>
</HTML>









