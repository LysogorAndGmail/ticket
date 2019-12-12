
<div class="container container-fixed-lg">
 
 
 
 
 
 
 
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Support")?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            
            
            <div class="row">
            
  
            
                     <table class="table table-hover" id="emails">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?=__("Name")?></th>
                            <th><?=__("Soname")?></th>
                            <th><?=__("Phone")?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){?>
                            <tr class="">
                                <td><?=$a['supp_id'];?></td>
                                <td><?=$a['supp_name'];?></td>
                                <td><?=$a['supp_soname'];?></td>
                                <td><?=$a['supp_phone'];?></td>
                                <td>
                                    <div class="btn-group dropdown-default"> <a href="#" data-toggle="dropdown" class="btn dropdown-toggle" style="width: 141px;"> <?=__("Operation")?><span class="caret"></span> </a>
                                        <ul class="dropdown-menu " style="width: 141px;">    
                                            <li> <a class="shure" href="/sysuser/dell_support?id=<?=$a['supp_id'];?>"><?=__("Delete")?></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            
            </div>
            
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>

<span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger see_modal" style="display: none;"><?=__('Delete images')?></span>
<div class="modal fade" id="info_modal_city" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content tab-content">
        <div class="modal-header">
          <button type="button" class="close info_close" data-dismiss="modal" aria-hidden="true">×</button>
          <br />
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-12 info_body">
                <input type="text" class="parent_id" />
                <input type="text" class="bloc" />
                <input type="text" class="children_id" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal">No</button><button type="button" class="btn btn-default" onclick="join_my_city()">Confirm</button>
        </div>
      </div>
    </div>
</div>
<span data-toggle="modal" data-target="#info_modal_city_lang" class="btn btn-danger see_modal_lang" style="display: none;"><?=__('Delete images')?></span>
<div class="modal fade" id="info_modal_city_lang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content tab-content">
        <div class="modal-header">
          <button type="button" class="close info_close" data-dismiss="modal" aria-hidden="true">×</button>
          <br />
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-12 info_body">
                <input type="text" class="parent_id" />
                <?$contrys = DB::select()->from('language')->execute()->as_array();?>
                <select name="lang" class="lang_city">
                    <?foreach($contrys as $con){?>
                        <option value="<?=$con['culture'];?>"><?=$con['name'];?></option>
                    <?}?>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal">No</button><button type="button" class="btn btn-default" onclick="my_city_add_lang()">Confirm</button>
        </div>
      </div>
    </div>
</div>
