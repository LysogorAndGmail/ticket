<? echo 'туда'; 
$lang = Session::instance()->get('leng');
if(!$lang) {
    $lang = 'EN';
}
I18n::lang($lang);

$tik = DB::select()->from('ticket')
//->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
->where('ticket_id','=',$id)
->execute()->current();

$people = DB::select()->from('ticket_people')->where('id','=',$tik['client_id'])->execute()->current();

//echo '<pre>';
//print_r($people);
//echo '</pre>';
//die;

$sususer = DB::select()->from('system_users')->where('id','=',$tik['user_id'])->execute()->current();
if($tik['user_id'] == 0){
$sususer['login'] = 'SuperAdmin';
}

$discount = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$tik['discount_id'])->and_where('culture','=',$lang)->execute()->current();

$fer = DB::select()->from('ferryman')->where('ferryman_id','=',$tik['ferryman_id'])->execute()->current();

$rou = DB::select()->from('routename_i18n')->where('route_name_id','=',$tik['route_name_id'])->and_where('culture','=',$lang)->execute()->current();

$route_name = DB::select()->from('routename')->where('route_name_id','=',$tik['route_name_id'])->execute()->current();

$from = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
$to = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();

$r_id_from = DB::select()->from('route')->where('route_name_id','=',$tik['route_name_id'])->and_where('route_city_id','=',$tik['route_city_from_id'])->execute()->current();
$r_id_to = DB::select()->from('route')->where('route_name_id','=',$tik['route_name_id'])->and_where('route_city_id','=',$tik['route_city_to_id'])->execute()->current();


?>
<style>
td {
    padding: 5px;
}
span.smalll {
    font-size: 8px;
}
</style>
<table border="1" cellpadding="0" cellspacing="0" style="width: 1030px !important; color:black !important">
    <tr>
        <td colspan="4" style="text-align: center;"><?=__('OPEN');?>:  </td>
        <td colspan="3" style="text-align: center;">№ <?=__('Ticket');?>: : <?php echo $tik['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Passenger');?>:</span><br /> <?=$people['name'].' '.$people['soname'];?></td>
        <td colspan="3" style="text-align: center;"><?=__('One way');?></td>
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
        <td><span class="smalll"><?=__('Route');?>:<?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;"><span class="smalll"><?=__('Seller');?>: <?=$sususer['login'];?></span></td>
    </tr>
    <tr>

        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$from['city_i18n']?>, <?=$from['name_i18n']?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            Open
        </td>
        <td><span class="smalll"><?=__('Time');?>:</span><br />
            Open
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;"><?=__('Place');?>:
            
        </td>
        <td colspan="2" rowspan="2">
            TRF: <?=$tik['price'].' '.$tik['valute'];?><br />
            <span class="smalll"><?=__('Discount');?>: <?=$discount['name_tiket'];?></span><br />
            TRF: <?=$tik['price'].' '.$tik['valute'];?><br />
            <?=__('Total');?>: <?=$tik['price'].' '.$tik['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll"><?=__('Departure');?>:</span><br />
            <?=$to['city_i18n']?>, <?=$to['name_i18n']?>
        </td>
        <td><span class="smalll"><?=__('Date');?>:</span><br />
            Open
        </td>
        <td>
            <span class="smalll"><?=__('Time');?>:</span><br />
            Open            
        </td>
    </tr>
</table>
<div style="width: 1030px; text-align: center; padding-bottom: 20px;"><span class="smalll">"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956 </span></div>


