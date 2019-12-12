<? $sesuser = Session::instance()->get('ses_user'); //print_r($sesuser);
$lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
 ?>

<style>
.grid.simple .grid-body tbody > tr:hover > td {
    background: none !important;
}

.grid.simple .grid-body tbody > tr.sell > td {
    background-color: yellowgreen;
}
.grid.simple .grid-body tbody > tr.return  > td {
    background-color: pink;
}
#ui-datepicker-div {
    width: 280px !important;
}
</style>
<script type="text/javascript" src="<?=Kohana::$base_url?>js/shortcut.js"></script>
<script type="text/javascript">
shortcut.add("alt+s", function() {
        alert("alt+s");
    });
</script>
<div class="content">  
	<div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="">
                <h2 class=" inline"><?=__("Ticket Auto Anule")?></h2>
            </div>
        </div>
    </div>
</div>
<div class="content">    
       <div class="grid simple ">
            <table class="table table-hover table-condensed" id="example">
                <thead>
                    <tr>
                        <th><?=__("№")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Anule")?></th>
                        <th><?=__("Users")?></th>
                        <th><?=__("Route")?></th>
                        <th><?=__("Ferryman")?></th>
                        <th><?=__("Route date")?></th>
                        <th><?=__("Cities")?></th>
                        <th><?=__("Client")?></th>
                        <th><?=__("Discount")?></th>
                        <th><?=__("Price")?></th>
                    </tr>
                </thead>
                <tbody>
                    <? $all_count = 0;            
                     $al_val_price = array();
                     foreach($tikets as $t){
                        $city_from = Model::factory('OstMod')->get_ost($t['city_from'],$lang);
                        $city_to = Model::factory('OstMod')->get_ost($t['city_to'],$lang);
                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$t['ferryman_id'])->execute()->current();
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['user_create'])->execute()->current();
                        if($t['user_create'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['user_create'] == '198'){
                            $sususer['login'] = 'inet';
                        }
                        switch($t['status']){
                            case'1':
                            $status = 'sell';
                            break;
                            case'2':
                            $status = 'reserv';
                            break;
                            case'3':
                            $status = 'return';
                            break;
                            case'4':
                            $status = 'transfer';
                            break;
                            case'5':
                            $status = 'open';
                            break;
                        }
                        ?>
                        <tr class="<?=$status;?>">
                            <td><?=$t['tiket_id'];?></td>
                            <td><?=$status;?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($t['anule']));?></td>
                            <td><?=$sususer['login'];?></td>
                            <td><span title="<?=$t['route_name_id'];?>"><? $rou_name = Model::factory('RouteMod')->get_route_route_id($t['route_name_id'],$lang,1); echo $rou_name[0]['name'];?></span></td>
                            <td><?=$fermann_id['name'];?></td>
                            <td><? if(!empty($t['route_date'])){ echo date("d.m.Y",strtotime($t['route_date']));}?></td>
                            <td><?=$city_from['city_i18n']." - ".$city_to['city_i18n'];?></td>
                            <td><?=$t['client'];?></td>
                            <td><?=$t['discount'];?></td>
                            <td><? echo $t['price'];?></td>
                        </tr>
                         <?}?>
                         
                </tbody>
            </table>
            
        
    </div>
    
    

<? include_once('js/mytables_i18n.php');?>

	
 <div class="clearfix"></div>
  </div>
  <!-- END PAGE --> 

<script type="text/javascript">
$(document).ready(function(){
    $("#in_1,#in_2,#in_3,#in_4").datepicker({
        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авгу", "Сент", "Окт", "Ноя", "Дек" ],
        monthNames:[ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        gotoCurrent: true,
        dayNamesMin: [ "Вос" , "Пон", "Вто", "Сре", "Чет", "Пят", "Суб",  ],
        //minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        showOtherMonths: true,
        selectOtherMonths: true
    });
})
</script>