<? $all_discount = Model::factory('DiscountMod')->get_all_discount($lang);?>
<label><?=__("Discount");?></label>
<select class="discount_open">
    <?foreach($all_discount as $di){?>
    <option value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
    <?}?>
</select>