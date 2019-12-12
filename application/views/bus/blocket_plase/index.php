
  
  
  
  
  
  
  
  <div class="container container-fixed-lg">
 
 
 
 
 
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("List of blockets")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">     
                              <div class="section grey">
            <div class="section grey col-md-12 p-t-10 p-b-10">
               
                            
                                  <div class="btn-group">
            
            <a href="/buses/add_blocket_plase" class="btn btn-success btn-cons"  ><?=__("Add new blockets")?></a>
            
                    
                       
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
                                                <? $groups = array(); foreach($groups as $group){
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