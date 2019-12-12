<div class="large-3 medium-3 columns rig_bor">
    <div class="bag_gray">
        <img src="<?=Kohana::$base_url;?>img/menu_left/menu_icon.jpg" width="20" height="16" />
    </div>
    <div class="bag_blugray">
        <a href="/ferryman/see_all" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ferryman/see_all'){ echo 'activs';}?>"><?=__("List ferryman");?></a>
        <a href="/buses/see_all" class="radius button <?if($_SERVER['REQUEST_URI'] == '/buses/see_all'){ echo 'activs';}?>"><?=__("List buses");?></a>
        <a href="/buses/all_schema" class="radius button <?if($_SERVER['REQUEST_URI'] == '/buses/all_schema'){ echo 'activs';}?>"><?=__("List scheme");?></a>
        <a href="/ferryman/add" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ferryman/add'){ echo 'activs';}?>"><?=__("Add ferryman");?></a>
        <a href="/buses/add" class="radius button <?if($_SERVER['REQUEST_URI'] == '/buses/add'){ echo 'activs';}?>"><?=__("Add bus");?></a>
        <a href="/buses/save_bus_schema" class="radius button <?if($_SERVER['REQUEST_URI'] == '/buses/save_bus_schema'){ echo 'activs';}?>"><?=__("Add scheme");?></a>
        <a href="/ferryman" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ferryman'){ echo 'activs';}?>"><?=__("Link");?></a>
    </div>
</div>