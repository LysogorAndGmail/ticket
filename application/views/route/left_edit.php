<style>
    .p_bl {
        background-color: #0c87cb;
        padding: 15px;
        margin: 2px 0 !important;
    }
    .p_bl a{
        color:#fff;
    }
</style>
<div class="large-3 medium-3 columns rig_bor">
    <div class="bag_gray">
        <img src="<?=Kohana::$base_url;?>img/menu_left/menu_icon.jpg" width="20" height="16" />
    </div>
    <div class="bag_blugray">
        <a href="/route/see_all" class="radius button <?if($_SERVER['REQUEST_URI'] == '/route/see_all'){ echo 'activs';}?>">all routes</a>
        <a href="/route" class="radius button <?if($_SERVER['REQUEST_URI'] == '/route'){ echo 'activs';}?>">filter</a>
        <? $cou = array(); for($i=2;$i<=10;$i++){
    $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_GET['route_name_id'])->and_where('rice','=',$i)->execute()->current();
    if(!empty($ch)){?>
            <div class="row collapse l-smal p_bl">
                <a href="/rice/see?route_name_id=<?=$_GET['route_name_id'];?>&rice=<?=$i;?>">rice <?=$i;?></a> <a class="shure" style="float: right;" href="/rice/delete_rice?route_name_id=<?=$_GET['route_name_id'];?>&rice=<?=$i;?>"><img src="<?=Kohana::$base_url;?>img/ui/delete-grey.png" width="12" height="12" /></a>
            </div>
    <?  }}  ?>
    </div>
</div>
