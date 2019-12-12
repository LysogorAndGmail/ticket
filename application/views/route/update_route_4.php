<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<div class="content">    
  
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step")?> 4</h3>
                            <div class="route_nav">
                                <a href="/route/edit_route?route_name_id=<?=$_GET['route_name_id'];?>"  ><?=__("Info")?></a>
                                <a href="/route/edit_route2?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Timetable")?></a>
                                <a href="/route/edit_route3?route_name_id=<?=$_GET['route_name_id'];?>" ><?=__("Date and Carry")?></a>
                                <a href="/route/edit_route4?route_name_id=<?=$_GET['route_name_id'];?>" class="activ"><?=__("Price")?></a>
                            </div>
                            <div class="padding_center">
                                <div class="row">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12">
                                        <? $new = array(); foreach($sel_val as $va){
                                            $new[$va['valute']] = $va;
                                        } foreach($new as $i=>$vall){
                                            //print_r($vall['valute']);
                                            //die;
                                            //$val_name = DB::select()->from('country')->where('country_id','=',$i)->execute()->current();
                                            ?>
                                        <button class="btn btn-info btn-cons che_price" data-route="<?=$_GET['route_name_id'];?>" data-valute="<?=$vall['valute'];?>"><?=__('Check');?> <?=$vall['valute'];?></button>&nbsp;
                                        <button class="btn btn-info btn-cons update_price" data-route="<?=$_GET['route_name_id'];?>" data-valute="<?=$vall['valute'];?>"><?=__('Update');?> <?=$vall['valute'];?></button>
                                        <span style="cursor: pointer;" class="dell_price"><i class="fa fa-times"></i></span><br />
                                        <?}?>
                                        </div>
                                        <form method="POST" action="/route/edit_route4?route_name_id=<?=$_GET['route_name_id'];?>">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><?=__("Valuta")?></label>
                                                    <select name="valute">
                                                        <? foreach($valutes as $valute){?>
                                                            <option value="<?=$valute['valute']?>"><?=$valute['valute']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-hover main_route_price" id="emails">
                                                    <? $count = count($all_ost);?>
                                                    <tr>
                                                        <td colspan="2" class="strong" style="width: 80px !important;"></td>
                                                        <? if (1){ 
                                                             for ($i = 0; $i < $count; $i++){ 
                                                                 if (($count - 1) > $i) { ?>
                                                                    <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                                        <? } }  }else{ 
                                                             for ($i = $count; $i > 0; $i--){ 
                                                                 if (($count) > $i) { ?>
                                                                    <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                                        <? }  }  } ?>
                                                    </tr>
                                                    <? for ($i = 0; $i < $count; $i++){ 
                                                     if ($i){ ?>
                                                        <tr <? if ($i % 2 == 0){ ?> class="rows1"<? }?> >
                                                            <td><? echo $i?></td>
                                                            <td style="width: 80px !important;"><? $ost = Model::factory('RouteMod')->get_ost_name($all_ost[$i]['route_city_id'],$lang); echo $ost['city_i18n']." - ".$ost['name_i18n']; ?></td>
                                                            <? for ($j = 0; $j < $count - 1; $j++){ 
                                                             if ((($count - 1) > $j && $j < $i && $all_ost[$j]['route_city_id'] != $all_ost[$i]['route_city_id'])) { 
                                                                //$pri = DB::select()->from('RoutePrice')->where('route_name_id','=',$_GET['route_name_id'])->and_where('route_city_from_id','=',$all_ost[$j]['route_city_id'])->and_where('route_city_to_id','=',$all_ost[$i]['route_city_id'])->execute()->as_array(); print_r($pri);//$all_ost[$j]['route_city_id'])->and_where('ost_id_to','=',$all_ost[$i]['route_city_id'])->execute()->current();
                                                                ?>
                                                                <td style="width: 80px !important;"><input style="width: 80px !important;" name="<?=$all_ost[$j]['route_city_id'].'_'.$all_ost[$i]['route_city_id'];?>" type="text" value="<?//=$pri['price'];?>" /></td>
                                                            <? }elseif ($j > $i) { ?>
                                                                <td></td>
                                                            <? }else{ ?>
                                                                <td><? //echo $all_ost[$i]['route_city_id']; ?></td>
                                                            <? } } ?>
                                                        </tr>
                                                    <? } } ?>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-salat btn-cons"><?=__("Save Price")?></button>
                                            </div>
                                            
                                        </form>
                                        
                                        <form action="/roz/save_route_db" method="POST">
                                            <!--<button>записать</button>-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.che_price').click(function(){
    //ajax_animation_start();
    $('.main_route_price input').each(function(){
       $(this).val(''); 
    });
    var Sp = '';
    $.ajax({
        type: "POST",
        url: "/route/ajax_get_price_all",
        data: {route_name_id:$(this).data('route'),valute:$(this).data('valute')},
        async: false,
        success: function(data) {
            //alert(data);
            Sp = data            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   
   var DF = Sp.split(':');
   //exit;  
   //delete DF[DF.length-1];
    for(var nn = 0; nn<=DF.length-1; nn++){
        var Del = DF[nn].split(',');
        //delete DF[DF.length-1];
        //alert(Del);
        //exit;
        $('.main_route_price input').each(function(){
            //$(this).val('');    
            var Name = $(this).attr('name');
            var par = $(this).parent('td');
            if(Name == Del[0]){
                par.find('input').val(Del[1]);                    
            }
        //alert(Del[0]);  
    })
    
   }
   
   //ajax_animation_stop();
   //alert(DF);
})
$('.update_price').click(function(){   
   var newArr = [];
   $('.main_route_price input').each(function(){
        if($(this).val().length > 0){
            var Name = $(this).attr('name')+':'+$(this).val();
            newArr.push(Name);
        }
   })
   if(newArr.length == 0){
        alert('Empty Check Valute!');
        exit;
   }
   //alert(newArr);
   $.ajax({
        type: "POST",
        url: "/route/ajax_update_price",
        data: {route_name_id:$(this).data('route'),valute:$(this).data('valute'),array:newArr},
        async: false,
        success: function(data) {
            alert(data);
            //Sp = data            
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   //alert(DF);
})
$('.dell_price').click(function(){
    //ajax_animation_start();
    $.ajax({
        type: "POST",
        url: "/route/ajax_dell_price",
        data: {route_name_id:$(this).prev().data('route'),valute:$(this).prev().data('valute')},
        async: false,
        success: function(data) {
            //alert(data);
            //Sp = data
                    
        },
        error:function(){
            alert('ошибка записи step_2');
        }
   });
   location="/route/edit_route4?route_name_id="+$(this).prev().data('route')+"";  
   //ajax_animation_stop();  
})
</script>