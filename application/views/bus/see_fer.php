<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <!--<a href="#" class="small radius button" data-reveal-id="group_mod">Превязка перевозчика</a>
        <div id="group_mod" class="reveal-modal" data-reveal>
            <form action="/group/add" method="post">
                <label>Название:</label>
                <input type="text" name="group_name" />
                <label>Тип:</label>
                <input type="text" name="group_type" />
                <button>Создать</button>
            </form>
        </div>-->
        <div class="row">
            <form action="/buses/save_buses" method="POST">
                <div class="medium-3 columns">
                    <select class="ferry" name="fer_id">
                        <? foreach($all_fer as $f){?>
                        <option value="<?=$f['ferryman_id']?>"><?=$f['name']?></option>
                        <?}?>
                    </select>
                </div>
                <div class="large-12 medium-12  columns">
                    <div class="bus_chek">
                        <? foreach($buses as $b){?>
                            <div>
                                <input type="checkbox" name="bus_id[]" value="<?=$b['buses_id'];?>" <? foreach($all_bus as $ab){ if($b['buses_id'] == $ab['buses_id']){ echo 'checked="checked"'; } }?> />&nbsp;<?=$b['name_i18n'];?>
                            </div>
                        <?}?>
                    </div>
                </div>
                <button>edit</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$('.ferry').change(function(){
    $.ajax({
        type: "POST",
        url: "/buses/ajax_buses_chek",
        data: {id:$(this).val()},
        success: function(data) {
            $('.bus_chek').html(data);
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})
</script>