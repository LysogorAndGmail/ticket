<div class="content">    
	<div class="page-title">
    <h3><?=__("Articles")?></h3></div>
    <? if($sysuser['login'] == 'svitgo'){?>
    <a href="/post/add_post" class="btn btn-success btn-cons"><?=__("Create article")?></a>
    <a href="/post/post_menu" class="btn btn-success btn-cons"><?=__("Menu")?></a>
    <?}?>
  
  
    <!-- BEGIN TEXT-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
            
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                                 <table class="table table-striped table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th><?=__("Name")?></th>
                                                <th><?=__("RU")?></th>
                                                <th><?=__("UK")?></th>
                                                <th><?=__("EN")?></th>
                                                <th><?=__("CS")?></th>
                                                <th><?=__("Parent Sysuser")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($posts as $n){?>
                                                <tr class="">
                                                    <td><?=$n['article_id'];?></td>
                                                    <td><?=$n['article_title'];?></td>
                                                    <td><a href="/post/update_post?id=<?=$n['article_id'];?>&lang=ru"><i class="fa fa-edit"></i></a></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_post($n['article_id'],'uk'); if(!empty($chek_lang)){ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=uk"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=uk"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_post($n['article_id'],'en'); if(!empty($chek_lang)){ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=en"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=en"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('PostMod')->get_post($n['article_id'],'cs'); if(!empty($chek_lang)){ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=cs"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/post/update_post?id=<?=$n['article_id'];?>&lang=cs"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $sus = DB::select()->from('system_users')->where('id','=',$n['sys_id'])->execute()->current(); echo $sus['login'];?></td>
                                                    <td>
                                                        <a class="shure" href="/post/dell_post?id=<?=$n['article_id'];?>"><i class="fa fa-times"></i></a>
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
	<!-- END TEXT-->	 

  
  
  
    </div>


























