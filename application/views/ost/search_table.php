<table style="width:100%; border: none;" cellpadding="0" cellspacing="0">
    <thead>
        <tr class='nohover'>
            <th class='first'>ID</th>
            <th><?=__('Name');?>cccc</th>
            <th><?=__('City');?></th>
            <th><?=__('Село');?></th>
            <th><?=__('Валидность');?></th>
            <th><?=__('Маршруты');?></th>
            <th><?=__('Область');?></th>
            <th>ua</td>
            <th>en</th>
            <th>cs</th>
            <th class='last'><?=__('Событие');?></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($all as $re) {
            $nnn = $re['route_city_id'];
            
            $ukr = Model::factory('OstMod')->get_ajax_ost_id($nnn,'ua');
            $en = Model::factory('OstMod')->get_ajax_ost_id($nnn,'en');
            $cs = Model::factory('OstMod')->get_ajax_ost_id($nnn,'cs');
            $count = Model::factory('OstMod')->get_ajax_ost_route($nnn);
            $region = DB::select()->from('ost_regions')->where('ost_id','=',$nnn)->execute()->current();
            if(!empty($region['region_id'])) {
            $reg = DB::select()->from('regions')->join('regions_i18n')->on('regions.region_id','=','regions_i18n.region_id')->where('regions.region_id','=',$region['region_id'])->and_where('regions_i18n.culture','=','ru')->execute()->current();
            $reg = $reg['name'];
            }else {
            $reg = 'нет';
            }
            echo "<tr class='newspaper-c'>
            <td class='first'>".$nnn."</th>
            <td >".$re['name_i18n']."</td>
            <td >".$re['city_i18n']."</td>
            <td >".$re['village']."</td>
            <td>".$re['is_validate']."</td>
            <td>".$count."</td>
            <td>".$reg."</td>
            <td>".$ukr."</td>
            <td>".$en."</td>
            <td>".$cs."</td>
            <td class='last'>
            <a href='/ost/update_ost?ost_id=".$nnn."&lang=ru'><img src='".Kohana::$base_url."img/ui/edit-document.png' width='16' height='16' title='".__('Редактировать')."' /></a>&nbsp;
            <a class='shure' href='/ost/delete_ost?ost_id=".$nnn."&lang=ru'><img src='".Kohana::$base_url."img/ui/delete.png' width='16' height='16' title='".__('Удалить')."' /></a>
            </td>
            </tr>";
        }?>
    </tbody>
</table>