

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Agents")?>
                    </div>
                
                    
                
                
                  </div>
                  <div class="panel-body">
                 <div class="btn-group dropdown-default pull-left"> <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <?=__("Operation")?><span class="caret"></span> </a>
                          <ul class="dropdown-menu ">
                            <li><a href="/sysuser/add"><?=__("Add Agents")?></a>
                            </li>
                     
                          </ul>
                        </div>
            
            
            <div class="row">
           
                                    
                               <table class="table table-striped table-fixed-layout " id="emails" >
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th><?=__("User")?></th>
                                                <th><?=__('Enter')?></th>
                                                <th><?=__("Group")?></th>
                                                <th><?=__("Block Seats")?></th>
                                                <th><?=__("Operation")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($sysusers as $all){
                                                $group_name = DB::select()->from('groups')->where('id','=',$all['group_id'])->execute()->current();
                                                ?>
                                                <tr class="">
                                                    <td ><?=$all['id'];?></td>
                                                    <td ><?=$all['login'];?></td>
                                                    <td><span class="btn btn-warning btn-cons sysenter" data-id="<?=$all['id'];?>"><i class="fa fa-sign-in" title="<?=__('Enter')?>"></i></span>
                                                    
                                                    
                                   
                                                    
                                                    
                                                    
                                                    </td>
                                                    <td><?=$group_name['name'];?></td>
                                                    <td><a class="btn btn-danger" href="/sysuser/blocked_plase?id=<?=$all['id'];?>"><i class="fa fa-lock"></i>
</a></td>
                                                    <td >
                                                    <div class="btn-group">
                          <a href="/sysuser/edit?id=<?=$all['id'];?>" title="<?=__("Edit")?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                          <a href="/sysuser/dell?id=<?=$all['id'];?>" title="<?=__("Delete")?>" class="btn btn-default" ><i class="fa fa-trash-o"></i></a>
                         
                       
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





































 <script type="text/javascript">
 $('.sysenter').click(function(){
    var ID = $(this).data('id');
    $.ajax({
        type: "POST",
        url: "/sysuser/enter_client",
        data: {id:ID},
        success: function(data) {
            //$('.ajax_bl').html(data);
            //alert('ok');
            location="/";
        },
        //error:function(code, opt, err){
        //        alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        //}
   });
  })
 
 </script>