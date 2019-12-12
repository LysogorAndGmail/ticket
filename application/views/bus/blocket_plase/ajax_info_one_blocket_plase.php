<div class="blocket_info">
    <? $i=1; foreach($all as $one){?>
        <p> <?=$i;?> <?=$one['date'];?> - <?=$one['plases'];?> - <?=$one['sesuser'];?> <a href="/buses/delete_blocket_plase?id=<?=$one['bp_id'];?>"><button class="btn btn-danger"><?=__("Delete")?></button></a></p>
    <? $i++;}?>
</div>