<table class="table table-striped table-fixed-layout table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th><?=__("Name")?></th>
            <th><?=__("Description")?></th>
            <th><?=__("Actions")?></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($all as $b){?>
            <tr class="">
                <td ><?=$b['buses_id'];?></td>
                <td ><?=$b['name_i18n'];?></td>
                <td ><?=$b['description_i18n'];?></td>
                <td ><a href="/buses/update_bus?id=<?=$b['buses_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a>&nbsp;<a href="/buses/del_bus?id=<?=$b['buses_id']?>"><i class="fa fa-times"></i></a></td>
            </tr>
        <?}?>
    </tbody>
</table>