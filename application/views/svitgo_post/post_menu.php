
<div class="content">    
	<div class="page-title">
    <h3><?=__("Menu Manager")?></h3></div>
   
 <a href="/post/add_menu" class="btn btn-success btn-cons"><?=__("Create menu")?></a>
  <!-- BEGIN BASIC FORM ELEMENTS-->
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
                                                <th><?=__("List Menu")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($menus as $n){?>
                                                <tr class="">
                                                    <td><?=$n['menu_id'];?></td>
                                                    <td><?=$n['menu_title'];?></td>
                                                    <td><a href="/post/menu_list?id=<?=$n['menu_id'];?>"><?=__("Show")?></a></td>
                                                    <td>
                                                       
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
	<!-- END BASIC FORM ELEMENTS-->	 









</div><!--Content div-->






























