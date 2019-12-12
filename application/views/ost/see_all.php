<div class="bag_gray marg_fix">
    <div class="tabs-settings padding_b">
        <div class="t-p-message"><div class="t-p-m-number">5</div></div><div class=" t-p-settings"><a href=""><?= __('Settings');?></a></div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
    <div class="padding_center">
        <div class="row">
            <div class="large-12 medium-12  columns insert_in">
			    <table style="width:100%; border: none;" cellpadding="0" cellspacing="0">
                <thead>
                <tr class='nohover'>
                        <th class='first'>ID</th>
                        <th><?= __('Name');?></th>
                        <th><?=__('City');?></th>
                        <th><?=__('Село');?></th>
                        <th><?=__('Валидность');?></th>
                        <th><?=__('Маршруты');?></th>
                        <th><?=__('Область');?></th>
                        <th>uk</td>
                        <th>en</th>
                        <th>cs</th>
                        <th class='last'><?=__('Событие');?></th>
                        </tr></thead><tbody>

              <?  foreach($res as $re) {
                    $nnn = $re['route_city_id'];
                    
                    $ukr = Model::factory('OstMod')->get_ajax_ost_id($nnn,'uk');
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
                        <a class='shure' href='/ost/del_ost?id=".$nnn."'><img src='".Kohana::$base_url."img/ui/delete.png' width='16' height='16' title='".__('Удалить')."' /></a>
                    </td>
                    </tr>";
                
				
				}
                echo '</tbody></table>'; ?>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var inProgress = false;
    var startFrom = 30;
    $(window).scroll(function() {
        startScroll(startFrom,inProgress);
        startFrom += 30;
        inProgress = false;            
    });
    
    function startScroll(startFrom,inProgress){
        var Ciu = $('.newspaper-c').length;
        var InAF = $('.newspaper-c').last();
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 400 && !inProgress) {
         //alert('jhk');
         //exit;
         //   if(Scrol > CuBl){
            $.ajax({
                url: '/ost/scroll',
                type: 'POST',
                async: false,
                data: {lang:$('#cur_lan').val(),ofset:startFrom},
                error: function(){
                    alert('errror');
                },
                beforeSend: function() {
                    inProgress = true;
                },
                success: function(data) {
                   $(data).insertAfter(InAF); 
                    //alert(data);
                    //startFrom += 30;
                    //inProgress = false;
                }  
            });
            
        }
    }    
    
});
</script>