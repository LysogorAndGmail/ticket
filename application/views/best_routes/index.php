<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                <p>&nbsp;</p>
                                <a href="/pages/add_best_routes" class="btn btn-success btn-cons"><?=__("Create");?></a>        
                                <table class="table table-striped table-fixed-layout table-hover" id="emails">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th><?=__("For Lang")?></th>
                                            <th><?=__("From")?></th>
                                            <th><?=__("To")?></th>
                                            <th><?=__("Img")?></th>
                                            <th><?=__("Sys User")?></th>
                                            <th><?=__("Actions")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($best as $b){?>
                                            <tr class="">
                                                <td><?=$b['id'];?></td>
                                                <td><?=$b['for_lang'];?></td>
                                                <td><? $city = DB::select()->from('routecity_i18n')->where('route_city_id','=',$b['from'])->and_where('culture','=',$lang)->execute()->current(); echo $city['city_i18n']; ?></td>
                                                <td><? $city = DB::select()->from('routecity_i18n')->where('route_city_id','=',$b['to'])->and_where('culture','=',$lang)->execute()->current(); echo $city['city_i18n']; ?></td>
                                                <td><?=$b['img'];?></td>
                                                <td><?=$b['sys_id'];?></td>
                                                <td><a href="/pages/edit_best_routes?id=<?=$b['id'];?>" ><i class="fa fa-edit"></i></a><a href="/pages/del_best_routes?id=<?=$b['id'];?>" class="shure"><i class="fa fa-times"></i></a></td>
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