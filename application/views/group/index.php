
  
  
  
  
  
  
  
  <div class="container container-fixed-lg">
 
 
 
 
 
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("List of groups")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">     
                              <div class="section grey">
            <div class="section grey col-md-12 p-t-10 p-b-10">
               
                            
                                  <div class="btn-group">
            
            <a href="#" class="btn btn-success btn-cons"  data-toggle="modal" data-target="#myModal"><?=__("Add new group")?></a>
            
                    
                       
                        </div>
                                        
                                        <div class="modal fade  " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form action="/groups/add" method="post" class="m-t-20">
                                                            <input type="hidden" name="parent" value="<?=$parent;?>" />
                                                            <label><?=__("Group name")?></label>
                                                            <input type="text" name="group_name" class="form-control" />
                                                    </div>
                                                    <div class="modal-footer">
                                                       
                                                        <button class="btn btn-complete btn-cons btn-salat"><?=__("Add")?></button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Close")?></button>
                                                       
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
      
            
            </div>
            </div>
            <div class="col-md-12">
                        
                                        <table  class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?=__("Group name")?></th>
                                                    <th><?=__("User")?></th>
                                                    <th><?=__("Operation")?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? foreach($groups as $group){
                                                    $par_name = DB::select()->from('groups')->where('id','=',$group['parent'])->execute()->current();?>
                                                    <tr class="">
                                                        <td ><a href="/group/<?=$group['id'];?>"><?=$group['name'];?></a></td>
                                                        <td ><?=$par_name['name'];?></td>
                                                        <td >
                                                                                            <div class="btn-group">
                          <a href="/groups/edit?id=<?=$group['id'];?>" title="<?=__("Edit")?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                          <a  href="/groups/dell?id=<?=$group['id'];?>" title="<?=__("Delete")?>" class="btn btn-default" ><i class="fa fa-trash-o"></i></a>
                         
                       
                        </div>
                                                        
                                                        
                                                        
                                            </td>
                                                    </tr>
                                                <?}?>
                                            </tbody>
                                        </table>
                                    </div>
            </div> 
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>