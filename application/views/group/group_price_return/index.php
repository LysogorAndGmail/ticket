<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                                        <p>&nbsp;</p>
                        			    <a class="btn btn-danger" href="/groups/add_group_price_return"><?=__("Add")?></a>
                                        <p>&nbsp;</p>
                                        <table class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                    <tr>
                                                        <th><?=__("Route Name ID")?></th>
                                                        <th><?=__("Group")?></th>
                                                        <th><?=__("Valute")?></th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Ferryman")?></th>
                                                        <th><?=__("Actions")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach($all as $a){
                                                        $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$a['ferryman_id'])->execute()->current();
                                                        $group = DB::select()->from('groups')->where('id','=',$a['group_id'])->execute()->current();
                                                        $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$a['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
                                                        ?>
                                                        <tr class="">
                                                            <td ><?=$a['route_name_id'];?></td>
                                                            <td ><?=$group['name'];?></td>
                                                            <td ><?=$a['valute'];?></td>
                                                            <td ><?=$route_name['name'];?></td>
                                                            <td ><?=$fermann_id['name'];?></td>
                                                            <td >
                                                                <a href="/groups/edit_group_price_return?fer_id=<?=$a['ferryman_id'];?>&route_name_id=<?=$a['route_name_id'];?>&group_id=<?=$a['group_id'];?>&valute=<?=$a['valute'];?>"><?=__("Edit")?></a>&nbsp;&nbsp;
                                                                <a href="/groups/del_group_price_return?fer_id=<?=$a['ferryman_id'];?>&route_name_id=<?=$a['route_name_id'];?>&group_id=<?=$a['group_id'];?>&valute=<?=$a['valute'];?>"><i class="fa fa-times"></i></a>
                                                            </td>
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
		</div>
 <div class="clearfix"></div>
  </div>