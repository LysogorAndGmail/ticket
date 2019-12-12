

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Passengers")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">
            
            <div class="col-md-12">
            
            <table class="table table-striped" id="example2" >
                                                    <thead>
                                                      <tr>
                                                        <th>ID</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Last Name")?></th>
                                                        <th><?=__("Date")?></th>
                                                        <th><?=__("Phone")?></th>
                                                        <th><?=__("Count of Trip")?></th>
                                                        <th><?=__("Tickets")?></th>
                                                        <th><?=__("Operation")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <? foreach($all as $c){?>
                                                        <tr class="">
                                                            <td><?=$c['id'];?></td>
                                                            <td><?=$c['name'];?></td>
                                                            <td><?=$c['soname'];?></td>
                                                            <td><?=$c['date'];?></td>
                                                            <td><?=$c['tel'];?></td>
                                                            <td><?=$c['count_trip'];?></td>
                                                            <td><a class="btn btn-complete " href="/sysuser/see_clints_tiks?id=<?=$c['id'];?>"><i class="fa fa-ticket"></i>

</a></td>
                                                            <td>
                                                             
                                                                                                                                           <div class="btn-group">
                      
                         
                                            
                                                                <a href="/sysuser/edit_client?id=<?=$c['id'];?>" title="<?=__("Edit")?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                                                <a class="shure btn btn-default" href="/sysuser/del_client?id=<?=$c['id'];?>" title="<?=__("Delete")?>"><i class="fa fa-trash-o"></i></a>
                        </div>
                                              
                                        
                                                            </td>
                                                            <td style="display: none;">
                                                                
                                                            </td>
                                                            <td style="display: none;">
                                                                
                                                            </td>
                                                            <td style="display: none;">
                                                               
                                                            </td>
                                                            <td style="display: none;">
                                                               
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











  
<script type="text/javascript">
/* Formating function for row details */
function fnFormatDetails ( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="inner-table">';
    sOut += '<tr><td>Language:</td><td>'+aData[9]+' '+aData[10]+' '+aData[11]+' '+aData[12]+'</td></tr>';
    sOut += '</table>';
     
    return sOut;
}

</script> 
 
 
<? include_once('js/mytables_i18n.php');?>