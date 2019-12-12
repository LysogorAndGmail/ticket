<style>
.one_scem {
}
.one_row {
    clear: both;
}
div.cc {
    width: 20px;
    height: 20px;
    outline: 1px solid black;
    float: left;
    text-align: center;
}
div.blu {
    background-color: #1da0db;
}
</style>
<? foreach($new_all as $name=>$aa){ ?>
<div class="one_scem medium-2 columns">
    <h4><?=$name;?></h4>
    <? foreach($aa as $x=>$ax){?>
    <div class="one_row">
        <? foreach($ax as $y=>$ay){ ?>
            <div class="cc <? if(!empty($ay['value']) && $ay['value'] != "sw" && $ay['value'] != "pr" && $ay['value'] != "st"){ echo "blu"; }?>"><?=$ay['value'];?></div>
        <?}?>
    </div>
    <?}?>
    <div class="clearfix"></div>
    <br />
</div>
<? } ?>