 <div class="container container-fixed-lg">
 
  <div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                <p>&nbsp;</p>
                                <a href="/roz/add_route_step_1" class="btn btn-success btn-cons"><?=__("Create Route");?></a>        
                                <table class="table table-striped table-fixed-layout table-hover" id="emails">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th><?=__("Route ID")?></th>
                                            <th><?=__("Number")?></th>
                                            <th><?=__("Name")?></th>
                                            <th><?=__("Step")?> 1</th>
                                            <th><?=__("Step")?> 2</th>
                                            <th><?=__("Step")?> 3</th>
                                            <th><?=__("Step")?> 4</th>
                                            <th><?=__("Actions")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($routes_roz as $r){?>
                                            <tr class="">
                                                <td><?=$r['id'];?></td>
                                                <td><?=$r['route_id'];?></td>
                                                <td><?=$r['name'];?></td>
                                                <td><?=$r['name_i18n'];?></td>
                                                <td><a href="/roz/add_route_step_1?id=<?=$r['id'];?>" class="btn btn-lg"><?=__("1")?></a></td>
                                                <td><a href="/roz/add_route_step_2?id=<?=$r['id'];?>" class="btn btn-lg"><?=__("2")?></a></td>
                                                <td><a href="/roz/add_route_step_3?id=<?=$r['id'];?>" class="btn btn-lg"><?=__("3")?></a></td>
                                                <td><a href="/roz/add_route_step_4?id=<?=$r['id'];?>" class="btn btn-lg"><?=__("4")?></a></td>
                                                <td><a href="/roz/del_route_step?id=<?=$r['id'];?>" class="shure"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                            </div>
							</div>	
						</div>
					</div>
				</div>	
		</div>
 <div class="clearfix"></div>
  </div>