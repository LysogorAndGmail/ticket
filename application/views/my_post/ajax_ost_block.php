<?$i=1; foreach($route_citys as $rs){?>
    <div style="float: left; padding: 5px; width: 100px;">
        <div class="row-fluid">
            <div class="checkbox check-default">
                <input id="checkbox<?=$rs['route_city_id'];?>" name="route_citys[]" type="checkbox" class="route_citys" value="<?=$rs['route_city_id'];?>">
                <label for="checkbox<?=$rs['route_city_id'];?>"><?=$rs['city_i18n']." ".$rs['name_i18n'];?></label>
            </div>
        </div> 
    </div>
    <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
<? $i++;}?>