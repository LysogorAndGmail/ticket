<div class="container container-fixed-lg">
 
  <div class="row">
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3>Back- <span class="semi-bold">Index</span></h3>
    </div>		
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Step 4")?></h3>
                            <div class="route_nav">
                                <a href="/roz/add_route_step_1?id=<?=$_GET['id'];?>" class=""><? echo __('Info');?></a>
                                <a href="/roz/add_route_step_2?id=<?=$_GET['id'];?>" class=""><? echo __('Timetable');?></a>
                                <a href="/roz/add_route_step_3?id=<?=$_GET['id'];?>" class=""><? echo __('Date and Carry');?></a>
                                <a href="/roz/add_route_step_4?id=<?=$_GET['id'];?>" class="activ"><? echo __('Price');?></a>
                            </div>
                            <div class="padding_center">
                                <div class="row">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12">
                                        <? $new = array(); foreach($sel_val as $va){
                                            $new[$va['valute']] = $va;
                                        } foreach($new as $i=>$vall){?>
                                        <button class="btn btn-info btn-cons"><?=$i;?></button>
                                        <a href="#"><i class="fa fa-times"></i></a><br />
                                        <?}?>
                                        </div>
                                        <form method="POST" action="/roz/add_route_step_4?id=<?=$_GET['id'];?>">
                                            <div class="col-md-12">
                                                <div class="col-md-6 no-padding">
                                                    <div class="form-group">
                                                        <label><?=__("Valuta")?></label>
                                                        <select name="valute" class="form-control">
                                                            <? foreach($valutes as $valute){?>
                                                                <option value="<?=$valute['valute']?>"><?=$valute['valute']?></option>
                                                            <?}?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button class="btn btn-success btn-cons see_tab"><?=__("View Table")?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="overflow: auto;">
                                                <table class="table table-striped table-fixed-layout table-hover main_route_price" id="emails">
                                                    <? $count = count($all_ost);?>
                                                    <tr>
                                                        <td colspan="2" class="strong"></td>
                                                        <? if (1){ 
                                                             for ($i = 0; $i < $count; $i++){ 
                                                                 if (($count - 1) > $i) { ?>
                                                        <td><? echo $all_ost[$i]['ost_city']; ?></td>
                                                        <? } }  }else{ 
                                                             for ($i = $count; $i > 0; $i--){ 
                                                                 if (($count) > $i) { ?>
                                                        <td><? echo $all_ost[$i]['ost_city']; ?></td>
                                                        <? }  }  } ?>
                                                    </tr>
                                                    <? for ($i = 0; $i < $count; $i++){ 
                                                     if ($i){ ?>
                                                        <tr <? if ($i % 2 == 0){ ?> class="rows1"<? }?>>
                                                            <td><? echo $i?></td>
                                                            <td><? echo $all_ost[$i]['ost_city']; ?></td>
                                                            <? for ($j = 0; $j < $count - 1; $j++){ 
                                                             if ((($count - 1) > $j && $j < $i && $all_ost[$j]['ost_id'] != $all_ost[$i]['ost_id'])) { 
                                                                $pri = DB::select()->from('add_route_step_5')->where('ost_id_from','=',$all_ost[$j]['ost_id'])->and_where('ost_id_to','=',$all_ost[$i]['ost_id'])->execute()->current();
                                                                ?>
                                                                <td><input name="<?=$all_ost[$j]['ost_id'].'_'.$all_ost[$i]['ost_id'];?>" type="text" value="<?=$pri['price'];?>" /></td>
                                                            <? }elseif ($j > $i) { ?>
                                                                <td></td>
                                                            <? }else{ ?>
                                                                <td><? echo $all_ost[$i]['ost_id']; ?></td>
                                                            <? } } ?>
                                                        </tr>
                                                    <? } } ?>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="chek_all btn btn-salat btn-cons"><?=__("Save Price")?></button>
                                            </div>
                                        </form>
                                        <div class="col-md-12">
                                            <form action="/roz/save_route_db" method="POST">
                                                <input type="hidden" name="step_1_id" value="<?=$_GET['id'];?>" />
                                                <button class="chek_all btn btn-danger btn-cons"><?=__("Save Step")?></button>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
</div>
<script type="text/javascript">
$('.see_tab').click(function(e){
    e.preventDefault();
})
</script>