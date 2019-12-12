<? /*
echo '<pre>';
            print_r($post);
            echo '</pre>';
            //die;
     //       */
?>

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
                
                $edit_price = DB::select()->from('routeprice_groups')
                ->where('route_name_id','=',$post['route_name_id'])
                ->and_where('ferryman_id','=',$post['fer_id'])
                ->and_where('route_city_from_id','=',$all_ost[$j]['route_city_id'])
                ->and_where('route_city_to_id','=',$all_ost[$i]['route_city_id'])
                ->and_where('group_id','=',$post['group_id'])
                ->and_where('valute','=',$post['valute'])
                ->and_where('ret','=',$post['ret'])
                ->order_by('weight')->execute()->current();
                
            //    echo '<pre>';
            //print_r($edit_price);
            //echo '</pre>';
            //die;
                
                ?>
                <td style="width: 80px !important;"><input style="width: 80px !important;" name="<?=$all_ost[$j]['route_city_id'].'_'.$all_ost[$i]['route_city_id'];?>" type="text" value="<?=$edit_price['price'];?>" /></td>
            <? }elseif ($j > $i) { ?>
                <td></td>
            <? }else{ ?>
                <td><? //echo $all_ost[$i]['route_city_id']; ?></td>
            <? } } ?>
        </tr>
    <? } } ?>
</table>