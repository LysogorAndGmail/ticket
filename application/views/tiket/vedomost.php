
<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-grey no-margin-b">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Сheck list")?>
                    </div>
                  </div>
                  <div class="panel-body">
                  <form> 
                                  <div class="col-md-3">
             <div class="form-group">
   <label><?=__("Route")?></label>
                        <select name="route_name_id" class="form-control">
                            <?foreach($routes_new as $r){?>
                            <option value="<?=$r['route_name_id'];?>" <?if(isset($_GET['route_name_id']) && $_GET['route_name_id'] == $r['route_name_id']){ echo 'selected="selected"'; }?>><?=$r['name'];?></option>
                            <?}?>
                        </select>             </div>
                  </div>
                  
                              <div class="col-md-3">
             <div class="form-group">
   <label><?=__("From")?></label>
                          <input name="date" id="datepicker_sell" type="text" class="filds-ost-desc form-control" placeholder="<?=__("Date")?>"  value="<?if(isset($_GET['date'])){ echo $_GET['date']; }?>" />            </div>
                  </div>
                  
                                    <div class="col-md-3">
             <div class="form-group">
   <label><?=__("To")?></label>
                        <input name="date_to" id="datepicker_sell_to" type="text" class="filds-ost-desc form-control" placeholder="<?=__("Date")?>"  value="<?if(isset($_GET['date_to'])){ echo $_GET['date_to']; }?>" /></div>
                  </div>
                  
                    <div class="col-md-3">      <div class="form-group m-t-25"> <button type="submit" class="btm-edit btn btn-success "><i class="icon-ok"></i> <?=__("Search")?></button></div></div>
                  </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>



<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
              
                  <div class="panel-body">
            <div class="col-md-12">
                 <table class="table table-striped table-fixed-layout">
                <thead>
                    <tr>
                        <th><?=__("Route")?></th>
                        <th><?=__("Route name")?></th>
                        <th><?=__("Carrier")?></th>
                        <th><?=__("Bus")?></th>
                        <th><?=__("Flight")?></th>
                        <th><?=__("Passengers")?></th>
                        <th><?=__("Сheck list")?> (2)</th>
                        <th><?=__("Сheck list")?> (3)</th>
                        <th><?=__("Route date")?></th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach($routes as $route=>$tik){
                    $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$tik[0]['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
                    $buses = Model::factory('BusesMod')->get_bus($tik[0]['buses_id'],$lang); 
                    $fer = DB::select()->from('ferryman')->where('ferryman_id','=',$tik[0]['ferryman_id'])->execute()->current(); 
                    $all_people = DB::select()->from('ticket')->where('route_name_id','=',$tik[0]['route_name_id'])->and_where('route_date','=',$tik[0]['route_date'])->execute()->as_array(); 
                    $cou_people = count($all_people);
                    ?>
                    <tr>
                        <td><span class="muted"><a href="/tiket/vedomost_route?id=<?=$tik[0]['route_name_id'];?>&date=<?=$tik[0]['route_date'];?>"><?=$route_name['name'];?></a></span></td>
                        <td><?=$route_name['name_i18n'];?></td>
                        <td><?=$fer['name'];?></td>
                        <td><?=$buses['name_i18n'];?></td>
                        <td>1</td>
                        <td><? echo $cou_people;?></td>
                        <td><a href="/tiket/vedomost_route_2?id=<?=$tik[0]['route_name_id'];?>&date=<?=$tik[0]['route_date'];?>"><?=$route_name['name'];?></a></td>
                        <td><a href="/tiket/vedomost_route_3?id=<?=$tik[0]['route_name_id'];?>&date=<?=$tik[0]['route_date'];?>"><?=$route_name['name'];?></a></td>
                        <td><?=date('d.m.Y',strtotime($tik[0]['route_date']));?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
                  <hr />
            <div class="money-seller-cash"><?=__("Total")?>: </div>
               
               
               
               
               </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>





















<? //include_once('js/mytables_i18n.php');?>

<script type="text/javascript">
///*
$("#datepicker_sell").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});
//*/
$("#datepicker_sell_to").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    //minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
    }, // end selected date
});

</script>