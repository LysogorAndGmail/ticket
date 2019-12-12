<div class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple no-border">
                <table class="table table-striped table-fixed-layout table-hover" id="emails">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?=__("Date")?></th>
                            <th><?=__("Date Change")?></th>
                            <th><?=__("PIN cod")?></th>
                            <th><?=__("Tickets")?></th>
                            <th><?=__("Status")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){?>
                            <tr class="">
                                <td><?=$a['id'];?></td>
                                <td><?=$a['date'];?></td>
                                <td><?=$a['date_change'];?></td>
                                <td><?=$a['pincod'];?></td>
                                <td><?=$a['tikets'];?></td>
                                <td><?=$a['status'];?></td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>