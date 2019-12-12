<?$tikets = DB::select()->from('ticketreport')->where('ticket_id','=',$id)->execute()->as_array();?>
<table class="table table-hover table-condensed table-striped ">
                <thead>
                    <tr>
                        <th><?=__("№")?></th>
                        <th><?=__("Status")?></th>
                        <th><?=__("Create")?></th>
                        <th><?=__("Users")?></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <? 
                     foreach($tikets as $t){
                        
                        $sususer = DB::select()->from('system_users')->where('id','=',$t['sys_user'])->execute()->current();
                        if($t['sys_user'] == 0){
                            $sususer['login'] = 'SuperAdmin';
                        }
                         if($t['sys_user'] == '198'){
                            $sususer['login'] = 'inet';
                        }
                        switch($t['status']){
                            case'1':
                            $status = ''.__("Sold");
                            break;
                            case'2':
                            $status = ''.__("Reserved");
                            break;
                            case'3':
                            $status = ''.__("Return");
                            break;
                            case'4':
                            $status = ''.__("Transfer");
                            break;
                            case'5':
                            $status = ''.__("Open");;
                            break;
                        }
                        
                       
                        ?>
                        <tr class="<?=$status;?> ">
                            <td class="id"><?=$t['ticket_id'];?></td>
                            <td class="color_<?=$t['status'];?>"><?=$status;?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($t['create_report']));?></td>
                            <td><?=$sususer['login'];?></td>
                        </tr>
                         <?}?>
                         
                </tbody>
            </table>