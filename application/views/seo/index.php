<div class="content">    
	<div class="page-title">
    <h3><?=__("Seo")?></h3></div>
    
    <a href="/seo/add" class="btn btn-success btn-cons"><?=__("Create")?></a>
    
  
  
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
                                                <th><?=__("Title")?></th>
                                                <th><?=__("URL")?></th>
                                                <th><?=__("Lang")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($all as $n){?>
                                                <tr class="">
                                                    <td><?=$n['main_id'];?></td>
                                                    <td><?=$n['title'];?></td>
                                                    <td><?=$n['url'];?></td>
                                                    <td><?=$n['culture'];?></td>
                                                    <td>
                                                        <a href="/seo/edit?id=<?=$n['main_id'];?>"><i class="fa fa-edit"></i></a>&nbsp;
                                                        <a class="shure" href="/seo/dell?id=<?=$n['main_id'];?>"><i class="fa fa-times"></i></a>
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

