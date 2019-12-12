<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="col-md-6 no-padding">
                                        <p>&nbsp;</p>
                                        <p><a class="btn btn-danger" href="/groups/add_group_price"><?=__("Add")?></a></p>
                                        <p>&nbsp;</p>
                                        <table  class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?=__("Name")?></th>
                                                    <th><?=__("Creator")?></th>
                                                    <th><?=__("Actions")?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $groups = array(); foreach($groups as $group){
                                                    $par_name = DB::select()->from('groups')->where('id','=',$group['parent'])->execute()->current();?>
                                                    <tr class="">
                                                        <td ><a href="/group/<?=$group['id'];?>"><?=$group['name'];?></a></td>
                                                        <td ><?=$par_name['name'];?></td>
                                                        <td ><a href="/groups/edit?id=<?=$group['id'];?>"><?=__("Edit")?></a>&nbsp;&nbsp;<a href="/groups/dell?id=<?=$group['id'];?>"><?=__("Delete")?></a></td>
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