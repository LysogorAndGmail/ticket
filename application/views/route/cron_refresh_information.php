<?
$lang = Session::instance()->get('leng');
if(!$lang) {
    $lang = 'EN';
}
?>
<div class="content">    
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple"> 
                        <div class="grid-body no-border email-body" style="min-height: 850px; padding-top: 20px;">
                            <h3><?=$info;?></h3>
                            <h2><?=__("Loguot");?></h2>
                            <button class="btn btn-danger"><a href="/route/edit_route3?route_name_id=<?=$_GET['route_name_id']?>"><?=__("Back")?></button></button>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
</div>