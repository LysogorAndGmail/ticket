<br />
<div class="one_people col-md-12 no-padding">
    <? $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
     I18n::lang($lang); ?>
    
    <? 
    $plase = 7;
    $price = 100;
    $valute = 'UAH';
    $all_discount_hidden = array();
    $all_discount = array();
    
    $sesuser = Session::instance()->get('ses_user');?>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    
    <script>
      $(function() {
        $( document ).tooltip();
      });
      </script>
    
    <div class="row form-row" >
        <div class="col-md-12 print_ticket_block" id="print_ticket_block">
            <?/* */ ?>
            
            <?
$id = 300;
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
<pre>-----------------------------------------------------------------------------</pre>




<table border="1" style="width: 800px !important; color:black !important">
    <tr>
        <td colspan="4" style="text-align: center;">КВИТОК НА АВТОБУС </td>
        <td colspan="3" style="text-align: center;">№ Квитка: <?php echo $tik['ticket_id'];?></td>
    </tr>
    <tr>
        <td><span class="smalll">Пасажир:</span><br /> <?=$people['name'].' '.$people['soname'];?></td>
        <td colspan="3" style="text-align: center;">Kвиток в одну сторону</td>
        <td style="text-align: center;"><span class="smalll">Дата продажі:</span><br />
                <?php echo date('d.m.Y');?>         
        </td>
        <td style="text-align: center;"><span class="smalll">Час продажі:</span><br />
                <?php echo date('H:i');?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll">Перевізник: <?=$fer['name'];?></span></td>
        <td colspan="2"><span class="smalll">Напрямок: В одну сторону</span></td>
        <td><span class="smalll">Маршрут: <?php echo  $route_name['name'];?></span></td>
        <td colspan="2" style="text-align: center;"><span class="smalll">Продавець: <?=$sususer['login'];?></span></td>
    </tr>
    <tr>

        <td><span class="smalll">Від'їзд:</span><br />
            <?=$from['city_i18n'];?>, <?=$from['name_i18n'];?>
        </td>
        <td><span class="smalll">Дата:</span><br />
            <?=$tik['route_date'];?>
        </td>
        <td><span class="smalll">Час:</span><br />
            <?=$tik['route_time'];?>
        </td>
        <td rowspan="2" style="text-align: center; vertical-align: central;">Сидіння:
            <?=$tik['value'];?>
        </td>
        <td colspan="2" rowspan="2">
            TRF: <?=$tik['price'].' '.$tik['valute'];?><br />
            <span class="smalll">Скидка: ---</span><br />
            TRF: <?=$tik['price'].' '.$tik['valute'];?><br />
            ВСЬОГО: <?=$tik['price'].' '.$tik['valute'];?>
        </td>
    </tr>
    <tr>
        <td><span class="smalll">Приїзд:</span><br />
            <?=$to['city_i18n'];?>, <?=$to['name_i18n'];?>
        </td>
        <td><span class="smalll">Дата:</span><br />
            <? $date_to = Model::factory('TiketMod')->get_date_to($tik['route_date'],$tik['route_name_id'],$tik['route_time'],$tik['route_timeto'],$from['route_city_id'],$to['route_city_id']); ?>
        </td>
        <td>
            <span class="smalll">Час:</span><br />
            <?=$tik['route_timeto'];?>
            
        </td>
    </tr>
</table>
<div style="width: 800px; text-align: center; padding-bottom: 20px;"><span class="smalll">"REGA & R“ spol. s r.o. Husitská 37, Praha-3 130 00 IČ 25762427, DIČ 25762427. Firma je zapsana v Obch. rejst. Městského soudu Praha oddil C, vložka 67956 </span></div>







 <table border="1">
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
                <strong><?=$people['name'].' '.$people['soname'];?><strong></nobr>
        </td>
        <td class="ticket_1"></td>
        <td class="ticket_2"><?php echo __('Linka / Маршрут') ?> <?php echo  $rou['name_i18n'];?></td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Odjezd / Відправлення:") ?>
                <strong><?=$from['city_i18n']?>, <?=$from['name_i18n']?> </strong>
            </nobr>
        </td>
        <td class="ticket_1">
            <nobr>
                <strong>Open,</strong> 
            </nobr/>
        </td>
        <td class="ticket_2"></td>
    </tr>
    <tr>
        <td class="ticket_0">
            <nobr><?php echo __("Prijezd / Прибуття:") ?>
                <strong><?=$to['city_i18n']?>, <?=$to['name_i18n']?> </strong>
            </nobr>
        </td>
        <td class="ticket_1">
            <nobr>
                <strong>Open,</strong>
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


<?/**/?>
            
        </div>
    </div>  
</div>
                        
                       
