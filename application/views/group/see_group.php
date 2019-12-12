<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <a href="#" class="small radius button" data-reveal-id="group_mod">Создать Функцию</a>
        <div id="group_mod" class="reveal-modal" data-reveal>
            <form action="/group/add" method="post">
                <label>Название:</label>
                <input type="text" name="group_name" />
                <label>Тип:</label>
                <input type="text" name="group_type" />
                <button>Создать</button>
            </form>
        </div>
        <div class="row">
            <div class="large-12 medium-12  columns">
                <? foreach($group_fun as $group){?>
                    <p><input type="checkbox" name="join_tik" <? foreach($join as $j){ if($group['id'] == $j['function_id']){ echo 'checked="checked"';}}?> /><?=$group['url'];?></p>
                <?}?>  
            </div>
        </div>
    </div>
</div>