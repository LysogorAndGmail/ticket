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
                                    <a href="/news/add_news" class="btn btn-success btn-cons"><?=__("Create News")?></a>
                                    <a href="/news/add_news_lang" class="btn btn-success btn-cons"><?=__("Translate")?></a>
                                    <a href="/news/select_news_cats" class="btn btn-success btn-cons"><?=__("Category")?></a>
                                    <a href="/news/upload_img" class="btn btn-success btn-cons"><?=__("Upload Images")?></a>
                                
                                    <table class="table table-striped table-fixed-layout table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th width="200"><?=__("Name")?></th>
                                                <th><?=__("Category")?></th>
                                                <th><?=__("Images")?></th>
                                                <th><?=__("Date")?></th>
                                                <th><i class="fa fa-globe"></i></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($news as $n){?>
                                                <tr class="">
                                                    <td><?=$n['news_id'];?></td>
                                                    <td><?=$n['title'];?></td>
                                                    <td><? $new_cat = Model::factory('NewsMod')->get_news_cat($n['cat_id'],'ru'); echo $new_cat['title'];?></td>
                                                    <td><?=$n['icon'];?></td>
                                                    <td><?=$n['news_date'];?></td>
                                                    <td><?=__("Langs")?></td>
                                                    <td>
                                                        <a href="/news/update_news?id=<?=$n['news_id'];?>&lang=ru"><i class="fa fa-edit"></i></a>&nbsp;
                                                        <a class="shure" href="/news/del_news?id=<?=$n['news_id'];?>"><i class="fa fa-times"></i></a>
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