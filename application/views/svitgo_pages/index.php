<div class="content">    
	<div class="page-title" ><h3><?=__("Pages")?></h3>
     </div>		
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                                    <p>&nbsp;</p>
                                    <a href="/pages/add_page" class="btn btn-success btn-cons"><?=__("Create Page")?></a>
                                
                                    <table class="table table-striped table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th><?=__("Name")?></th>
                                                <th><?=__("Alias")?></th>
                                                <th><?=__("RU")?></th>
                                                <th><?=__("UA")?></th>
                                                <th><?=__("EN")?></th>
                                                <th><?=__("CS")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($pages as $n){?>
                                                <tr class="">
                                                    <td><?=$n['page_id'];?></td>
                                                    <td><?=$n['name_i18n'];?></td>
                                                    <td><?=$n['slug'];?></td>
                                                    <td><a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=ru"><i class="fa fa-edit"></i></a></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_page($n['page_id'],'ua'); if(!empty($chek_lang)){ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=ua"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=ua"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_page($n['page_id'],'en'); if(!empty($chek_lang)){ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=en"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=en"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_page($n['page_id'],'cs'); if(!empty($chek_lang)){ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=cs"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/pages/update_page?id=<?=$n['page_id'];?>&lang=cs"><?=__("Add")?></a> <?}?></td>
                                                    <td>
                                                        <a class="shure" href="/pages/dell_page?id=<?=$n['page_id'];?>"><i class="fa fa-times"></i></a>
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