<?

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
//die;

$fer = DB::select()->from('ferryman')->where('ferryman_id','=',$tik['ferryman_id'])->execute()->current();

$rou = DB::select()->from('routename_i18n')->where('route_name_id','=',$tik['route_name_id'])->and_where('culture','=',$lang)->execute()->current();

$from = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current();
$to = DB::select()->from('routecity_i18n')->where('route_city_id','=',$tik['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();
?>
<!--
<div class="col-md-8 returnet_block">
<h3><?=__('Ticket');?>: - <?=$tik['ticket_id'];?></h3>
<h3><?=__('User Sell');?>: - <?=$sususer['login'];?></h3>
<h3><?=__('Client');?>: - <?=$tik['name'].' '.$tik['soname'];?></h3>
<h3><?=__('Route Date');?>: <?=date('d/m/Y',strtotime($tik['route_date']));?></h3>
<h3><?=__('Price');?>: <?=$tik['price'].' '.$tik['valute'];?></h3>
</div>
<hr />-->
<pre>-----------------------------------------------------------------------------</pre>

 <table>
    <tr>
        <td colspan="3" align="right" style="padding-right:10px">
            <strong><?php echo __('E-TICKET')?></strong>
        </td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __('Dopravce / Перевізник:') ?><strong><?=$fer['name'];?></strong></nobr>
        </td>
        <td class="ticket_1"></td>
        <td class="ticket_2">
            <nobr><?php echo __('Jizdenka / квиток') ?> <?php echo $tik['ticket_id'];?></nobr>
        </td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Jmeno / Ім'я:") ?>
                <strong><?=$tik['name'].' '.$tik['soname'];?><strong></nobr>
        </td>
        <td class="ticket_1"></td>
        <td class="ticket_2"><?php echo __('Linka / Маршрут') ?> <?php echo  $rou['name_i18n'];?></td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Odjezd / Відправлення:") ?>
                <strong><?=$from['city_i18n']?>, <?=$from['name_i18n']?></strong>
            </nobr>
        </td>
        <td class="ticket_1">
            <nobr>
                <strong><?=date('d/m/Y',strtotime($tik['route_date']));?>,</strong> 
            </nobr/>
        </td>
        <td class="ticket_2"></td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Prijezd / Прибуття:") ?>
                <strong><?=$to['city_i18n']?>, <?=$to['name_i18n']?></strong>
            </nobr>
        </td>
        <td class="ticket_1">
            <nobr>
                <strong><?=date('d/m/Y',strtotime($tik['route_date']));?>,</strong>
            </nobr>
        </td>
        <td class="ticket_2"><?php echo __('Sedadlo / Місце:')?> <?=$tik['value']?> </td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Cena / Ціна:") ?><?=$tik['price'].' '.$tik['valute'];?></nobr>
        </td>
        <td class="ticket_1"></td>
        <td class="ticket_2">
            <nobr><?php echo __('Prodejce / Продав')?> <?=$sususer['login'];?></nobr>
        </td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr>
                <strong><?php echo __("Celkem / Всього:") ?> <?=$tik['price'].' '.$tik['valute'];?>
            </nobr>
            </strong></td>
        <td class="ticket_1"></td>
        <td class="ticket_2">
            <nobr><?php echo __('Datum / Дата :')?> <?php echo date('d/m/Y H:i:s');?></nobr>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo __("Интерни заметки")?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo __("Заметки стюардесe")?> 
        </td>
    </tr>
    <tr class="ticket_info">
        <td colspan="3">
           
        </td>
    </tr>
</table>
