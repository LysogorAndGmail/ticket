<table class="table table-striped table-fixed-layout table-hover" id="emails">
    <thead>
        <tr>
            <th>ID</th>
            <th><?=__("Name")?></th>
            <th><?=__("Address")?></th>
            <th><?=__("Actions")?></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($all as $men){?>
            <tr class="">
                <td ><?=$men['ferryman_id'];?></td>
                <td ><?=$men['name'];?></td>
                <td ><?=$men['address'];?></td>
                <td >
                    <a href="/ferryman/update?id=<?=$men['ferryman_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a>&nbsp;<a href="/ferryman/del?id=<?=$men['ferryman_id']?>"><i class="fa fa-times"></i></a>
                </td>
            </tr>
        <?}?>
    </tbody>
</table>