<div class="content">    
	<div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3><?=__("Back")?> - <span class="semi-bold"><?=__("Index")?></span></h3>
     </div>		
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                                    <p>&nbsp;</p>
                                    <a href="/post/add_menu" class="btn btn-success btn-cons"><?=__("Create menu")?></a>
                            
                                    <table class="table table-striped table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th><?=__("Name")?></th>
                                                <th><?=__("Menu List")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($menus as $n){?>
                                                <tr class="">
                                                    <td><?=$n['menu_id'];?></td>
                                                    <td><?=$n['menu_title'];?></td>
                                                    <td><a href="/post/menu_list?id=<?=$n['menu_id'];?>">list</a></td>
                                                    <td>
                                                        <a href="/post/update_menu?id=<?=$n['menu_id'];?>"><i class="fa fa-edit"></i></a>&nbsp;
                                                        <a class="shure" href="/post/dell_menu?id=<?=$n['menu_id'];?>"><i class="fa fa-times"></i></a>
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