<div class="bag_gray marg_fix">
    <div class="tabs-settings padding_b">
        <div class="t-p-message"><div class="t-p-m-number">5</div></div><div class=" t-p-settings"><a href=""><?=__("Panel")?></a></div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
    <span>&nbsp;</span>
    <div class="clearfix"></div>
    <h4><?=__("List Users")?></h4>
    <div class="bor_bot" style="margin: 0 -16px;">&nbsp;</div>
    
    <div class="padding_center">
        <div class="row">
            <div class="large-12 medium-12  columns insert_in">
			    <table style="width:100%; border: none;" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                <th width="200"><?=__("ID")?></th>
                                <th width="200"><?=__("Login")?></th>
                                <th width="200"><?=__("Password")?></th>
                                <th><?=__("Group")?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach($sysusers as $all){
                                $group_name = DB::select()->from('groups')->where('id','=',$all['group_id'])->execute()->current();
                                ?>
                                <tr class="">
                                    <td ><?=$all['id'];?></td>
                                    <td ><?=$all['login'];?></td>
                                    <td ><?=$all['pass'];?></td>
                                    <td ><?=$group_name['name'];?></td>
                                </tr>
                            <?}?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>