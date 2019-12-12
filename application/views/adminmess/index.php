<div class="content">    
    
    <div class="row">
        <? foreach($admin_mess as $i=>$mess){?>
        <div class="col-md-12">
            <div class="grid simple no-border">
                <div class="grid-title no-border descriptive clickable">
                    <h4 class="semi-bold"><? $user = DB::select()->from('users_full')->where('user_id','=',$mess['user_id'])->execute()->current(); echo $user['name']."New Ticket";?></h4>
                    <p><span><?=$mess['id'];?></span><span><?=$mess['mess'];?></span><span><?=$mess['answer'];?></span></p>
                    <div class="actions"> <a class="view" title="<?=__("View")?>" href="javascript:;"><i class="fa fa-search"></i></a> <a class="remove" href="javascript:;" title="<?=__("Delete")?>"><i class="fa fa-times"></i></a> </div>
                </div>
                <div class="grid-body  no-border" style="display:none">
                    <form action="/adminmess/add_answer?id=<?=$mess['id'];?>" method="post">
                        <label><?=__("Answer")?>:</label>
                        <textarea name="answer" class="form-control"></textarea>
                        <p></p>
                        <button class="btn btn-primary" ><?=__("Send")?></button>
                    </form>
                </div>
            </div>
        </div>
        <?}?>
    </div>
</div>