<div class="container container-fixed-lg">
    <div class="row">
        <!-- START PANEL -->
        <div class="col-md-12">
            <!-- START PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><?=__("Logs")?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">     
                        <div class="section grey">
                            <div class="section grey col-md-12 p-t-10 p-b-10">
                                <div class="btn-group">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table  class="table table-striped table-fixed-layout table-hover">
                                <thead>
                                    <tr>
                                        <th><?=__("Route name")?></th>
                                        <th><?=__("User")?></th>
                                        <th><?=__("Bus")?></th>
                                        <th><?=__("IP")?></th>
                                        <th><?=__("Date of creating")?></th>
                                        <th><?=__("Seats")?></th>
                                        <th><?=__("Carrier")?></th>
                                        <th><?=__("Status")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? $groups = array(); foreach($all as $a){ 
                                       $route_name = DB::select()->from('routename')->where('route_name_id','=',$a['route_name_id'])->execute()->current();
                                       $user = DB::select()->from('system_users')->where('id','=',$a['sysuser_id'])->execute()->current(); 
                                       $bus = DB::select()->from('buses_i18n')->where('buses_id','=',$a['buses_id'])->and_where('culture','=','EN')->execute()->current();  
                                       $fer = DB::select()->from('ferryman')->where('ferryman_id','=',$a['ferryman'])->execute()->current();    
                                    ?>
                                    <tr class="">
                                        <td ><?=$route_name['name'];?></td>
                                        <td ><?=$user['login'];?></td>
                                        <td ><?=$bus['name_i18n'];?></td>
                                        <td ><?=$a['ip'];?></td>
                                        <td ><?=Date('H:i d.m.Y',strtotime($a['create_date']));?></td>
                                        <td ><?=$a['plases'];?></td>
                                        <td ><?=$fer['name'];?></td>
                                        <td ><?=$a['du'];?></td>
                                    </tr>
                                    <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>