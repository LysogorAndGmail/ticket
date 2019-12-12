
        <div class="row">                
                <div class="">
                <table class="table table-striped table-fixed-layout table-hover">
                    <thead>
                        <tr>
                            <th><?=__("Route Name ID")?></th>
                            <th><?=__("Route ID")?></th>
                            <th><?=__("Number")?></th>
                            <th><?=__("Route Name")?></th>
                            <th><?=__("Add Parent")?></th>
                            <th><?=__("Route Time")?></th>
                            <th><?=__("Rice")?></th>
                            <th><?=__("Backroute")?></th>
                            <th><?=__("Publiched")?></th>
                            <th><?=__("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){ ?>
                            <tr class="insert_af">
                                <td >
                                    <input type="checkbox" name="route_name_id[]" id="<?=$a['route_name_id'];?>" value="<?=$a['route_name_id'];?>" class="one_r_id" />
                                    <?=$a['route_name_id'];?>
                                </td>
                                <td><?=$a['route_id'];?></td>
                                <td><?=$a['name'];?></td>
                                <td><?=$a['name_i18n'];?></td>
                                <td><? if(empty($a['child'])){?><a href="/roz/add_parent?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Add Parent")?>"><icon class="fa fa-clock-o m-r-5"></i></a><?}?></td>
                                <td><? if(!empty($a['parent'])){ echo $a['start_from'].' / <a href="#'.$a['parent'].'">'.$a['parent'].'</a>';};?></td>
                                <td>
                                    <div>
                                            <? $cou = array(); for($i=2;$i<=10;$i++){
                                        $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                        if(!empty($ch)){  $cou[] = 1;?>
                                                <!--<a class="" href="/rice/see?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>"><?=$i;?></a>&nbsp; <a class="" href="/rice/dell?route_name_id=<?=$a['route_name_id'];?>&rice=<?=$i;?>">X</a><br />  -->              
                                      <?  }
                                      }  ?>
                                    </div>
                                    <span data-tooltip class="has-tip" title="<?=count($cou)+2;?>">
                                    <a href="/rice/add_rice?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Add Rice")?>"><icon class="fa fa-cogs m-r-5"></i></a></span>
                                </td>
                                <td>
                                    <? $chch = ''; 
                                    $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->execute()->current(); 
                                    $reverse_route = DB::select()->from('route_reverse')->where('reverse_id','=',$a['route_name_id'])->execute()->current();
                                    if(!empty($reverse_route)){
                                        $chch = $reverse_route['reverse_id'];
                                    } 
                                    if(!empty($main_route)){
                                        $chch = $main_route['main_id'];
                                    }
                                    if(!empty($chch)){   
                                        ?>
                                        <span data-tooltip class="has-tip" title="<?=$chch;?>"><a href="/route/reverse?id=<?=$a['route_name_id'];?>" title="<?=__("Add Backroute")?>"><icon class="fa fa-mail-reply m-r-5"></i></a></span>
                                    <?}else{?>
                                        <a href="/route/reverse?id=<?=$a['route_name_id'];?>"  title="<?=__("Add Backroute")?>"><icon class="fa fa-mail-reply m-r-5"></i></a>
                                    <?}?>
                                </td>
                                <td>
                                    <? if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; } ?>
                                </td>
                                <td >
                                    <!---->
                                    <a href="/route/edit_route?route_name_id=<?=$a['route_name_id'];?>"  title="<?=__("Edit")?>"><icon class="fa fa-pencil-square-o m-r-5"></i></a> |
                                    <a class="shure" href="/route/delete_route?route_name_id=<?=$a['route_name_id'];?>" title="<?=__("Delete")?>"><icon class="fa fa-times m-r-5"></i></a>
                                </td>
                            </tr>
                        <?}?>
                   </tbody>
                </table>
                </div>
            </div>