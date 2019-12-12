<div class="content">    

		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                        			    <p>&nbsp;</p>
                                        <table class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Address")?></th>
                                                        <th><?=__("Return Policy")?></th>
                                                        <th><?=__("Actions")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach($ferrymans as $men){?>
                                                        <tr class="">
                                                            <td ><?=$men['ferryman_id'];?></td>
                                                            <td ><?=$men['name'];?></td>
                                                            <td ><?=$men['address'];?></td>
                                                            <td ><a href="/ferryman/discoun_tiket_list?id=<?=$men['ferryman_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a></td>
                                                            <td >
                                                                <a href="/ferryman/update?id=<?=$men['ferryman_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a>&nbsp;<a class="shure" href="/ferryman/del?id=<?=$men['ferryman_id']?>"><i class="fa fa-times"></i></a>
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