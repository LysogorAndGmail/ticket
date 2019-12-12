<div class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple no-border">
                <table class="table table-striped table-fixed-layout table-hover" id="emails">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?=__("Email")?></th>
                            <th><?=__("Phone")?></th>
                            <th><?=__("Join Tik ID")?></th>
                            <th><?=__("Number")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){?>
                            <tr class="">
                                <td><?=$a['id'];?></td>
                                <td><?=$a['email'];?></td>
                                <td><?=$a['phone'];?></td>
                                <td><?=$a['join_ticket_id'];?></td>
                                <td><?=$a['number'];?></td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>