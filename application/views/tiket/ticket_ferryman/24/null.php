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
<table width="800" border="0"  style="font-size:110%">
  <tr>
    <td width="148"><strong></strong></td>
    <td width="642">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="right"><?=__('Confirmation for customer');?></div></td>
  </tr>
  <tr>
    <td colspan="2"><p align="center"><strong><?=__('Confirmation of ticket cancellations');?></strong></p></td>
  </tr>
  <tr>
    <td><?=__('Operator');?></td>
    <td><?=$sususer['first_name']." ".$sususer['last_name'];?></td>
  </tr>
  <tr>
    <td><?=__('Passenger name');?></td>
    <td><?=$tik['name'].' '.$tik['soname'];?></td>
  </tr>
  <tr>
    <td><?=__('Ticket number');?></td>
    <td><?=$id;?></td>
  </tr>
  <tr>
    <td><?=__('Date and time of return');?></td>
    <td><?=Date('d.m.Y, H:i:s');?></td>
  </tr>
  <tr>
    <td><?=__('Returned amount');?></td>
    <td><?=$tik['route_price'] - $tik['return_price'];?></td>
  </tr>
  <tr>
    <td><?=__('Note');?></td>
    <td><? $al_pro = $tik['return_price']*100/$tik['route_price']; echo $al_pro;?></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>--------------------------------------------</p>
    </div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <?=__('stamp and signature');?>
    </div></td>
  </tr>
  <tr>

  </tr>
</table>





