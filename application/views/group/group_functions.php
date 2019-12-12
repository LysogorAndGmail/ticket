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
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Controller</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($group_fun as $group){?>
                            <tr class="">
                                <td><?=$group['id'];?></td>
                                <td><?=$group['url'];?></td>
                                <td><?=$group['controller'];?></td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>