<script type="text/javascript">
$('.select_city').click(function(){
    $(this).parents('.search_city_block').prev('.search_city').val($(this).text());
    $(this).parents('.search_city_block').html('');
})
</script>
<div class="btn-group open">
    <ul class="dropdown-menu">
        <? foreach($route_citys as $rs=>$city){?>
              <li class="select_city" style="cursor: pointer;"><a><?=$city;?></a></li>
        <? }?>
    </ul>
</div>