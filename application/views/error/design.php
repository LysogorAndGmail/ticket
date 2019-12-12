<br />
<br />
<div class="one_people col-md-12 no-padding">
<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>

<? 
$plase = 7;
$price = 100;
$valute = 'UAH';
$all_discount_hidden = array();
$all_discount = array();

$sesuser = Session::instance()->get('ses_user');?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>

<style>
.one_people {
    height: 92px;
    background-color: #dee9f5 !important;
    border-bottom: 1px solid #dddddd;
}
.in_1{
    width: 37px;
    height: 36px;
    background-color: #1da0db !important;
    padding-top: 9px !important;
    text-align: center !important;
    margin: 0;
    margin-top: 10px;
    margin-left: 10px;
    margin-right: 3px;
}
.in_2{
    width: 130px;
    height: 47px;
    text-align: center !important;
    padding:0 5px !important;
    padding-top: 10px !important;
    margin: 0 !important;
}
.in_3{
    width: 130px;
    height: 47px;
    text-align: center !important;
    padding:0 5px !important;
    padding-top: 10px !important;
}
.in_4{
    width: 85px;
    height: 47px;
    text-align: center !important;
    padding:0 5px !important;
    padding-top: 10px !important;
}
.in_5{
    width: 100px;
    height: 47px;
    text-align: center !important;
    padding:0 5px !important;
    padding-top: 10px !important;
}
.in_3 select{
    height: 37px !important;
    width: 120px !important;
}
.in_2 input{
    height: 37px !important;
    width: 120px !important;
}
.in_1 span{
    color: #fff;
    width: 100%;
    text-align: center;
}
.pad_top {
    padding-top: 18px !important;
    margin: 0;
}
.sellect_custom {
    text-align: center !important;
    position: relative;
    top:-28px;
    left:79px;
    z-index: 99999999;
}
select:disabled {
    background-color: #e5e5e5 !important;
}

.discount_hid {
    display: none;
}

.bot_us {
    background-color: #f1f8ff !important;
    height: 34px;
    margin-top: 10px;
    padding-top: 6px;
    font-size: 14px;
}
.dis_5_of_10 {
    background-color: #fff !important;
    height: 60px;
    margin-top: 95px;
    border: 3px solid #e4e8eb;
    font-size: 14px;
    position: absolute;
}
</style>

<div class="one_people col-md-12 no-padding">
    <div class="form-group col-md-1 no-padding in_1">
        <span class="plase"><?=$plase;?></span>
        <span class="dis_price" style="display:none;"><?=$price;?></span>
    </div>
    <div class="form-group col-md-2 in_2">
        <input type="text" class="soname form-control ajax_tel valid upper" />
        <span class="ajax_people_block"></span>
    </div>
    <div class="form-group col-md-2 in_2">
        <input type="text" class="name form-control valid upper" />
    </div>
    <div class="col-md-2 in_5">
        <input type="text" class="date form-control custom_date valid" id="date" />
    </div>
    <div class="form-group col-md-2 in_2">
        <input type="text" class="tel form-control valid" value="<?=$sesuser[0]['phone_kod'];?>"  />
    </div>
    <div class="form-group col-md-2 no-padding" style="display: none;">
        <input type="text" class="tel2 form-control" id="phone2"/>
    </div>
    <div class="form-group col-md-1 in_3 par_sell" style="margin: 0;">
        <select class="discount_hid" disabled="disabled">
            <?foreach($all_discount_hidden as $di){?>
            <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
            <?}?>
        </select>
        <select class="discount">
            <option  value=""> - </option>
            <?foreach($all_discount as $di){?>
            <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
            <?}?>
        </select>
    </div>
    <div class="form-group col-md-1 in_3 pad_top" style="text-align: left !important;">
            <? $random = rand(5, 15);?>
            <span style="margin-right: 10px; cursor: pointer; display: none;" data-toggle="modal" data-target="#my<?=$random;?>" class="edit_cleent"><i class="fa fa-pencil-square-o m-r-5" style="color: #1da0db; font-size: 18px; margin: 2px 5px 0;"></i></span><span class="clear_cleent" style="cursor: pointer;"><i class="fa fa-undo" style="color: #1da0db; font-size: 18px; margin: 2px 0;"></i></span>
            <!-- Modal -->
            <div class="modal fade" id="my<?=$random;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 id="myModalLabel" class="semi-bold">Edit Client</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row form-row">
                                <input type="hidden" class="cleent_id" />
                                <div class="col-md-8">
                                    <label><?=__('Last Name')?></label>
                                    <input type="text" class="form-control edit_soname" >
                                </div>
                                <div class="col-md-8">
                                    <label><?=__('First Name')?></label>
                                    <input type="text" class="form-control edit_name" >
                                </div>
                                <div class="col-md-8">
                                    <label><?=__('Birthday')?></label>
                                    <input type="text" class="form-control edit_date" >
                                </div>
                                <div class="col-md-8">
                                    <label><?=__('Phone')?></label>
                                    <input type="text" class="form-control edit_phone" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('Close')?></button>
                            <button type="button" class="btn btn-primary update_cleent_but" data-dismiss="modal"><?=__('Update Client')?></button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="form-group col-md-12 bot_us">
        <span style="margin: 0 8px; cursor: pointer;" class="rem_plase"><i class="fa fa-times-circle-o" style="color: #fc2525; font-size: 18px;"></i></span>&nbsp;<span style="font-weight: bold; margin-left: 7px;"><?=__('Tariff')?>:</span>&nbsp;<span class="info_discounts" ><? if(!empty($all_discount_hidden)){ echo $all_discount_hidden[0]['name_simple_i18n'];}?></span>
        <div class="form-group col-md-4 pull-right" style="margin-top: -3px;">
            <span style="font-size: 18px; font-weight: bold;" class="dis_price_inf" ><?=$price;?></span> <?=$valute;?>
        </div>
    </div>
    <div class="form-group col-md-12 dis_5_of_10">
        <div class="col-md-6" style="margin-top: 17px;">
            <p style="font-weight: bold; color:#000;"><span><?=__("Client")?>:</span><span class="in_dis_5_10 info_discounts"></span></p>
        </div>
        <div class="col-md-6" style="margin-top: 8px;">
            <span class="btn  conform_dis btn-success"><?=__('Да')?></span>
            <span class="btn conform_dis_no btn-danger" style="margin-left: 5px;"><?=__('Нет')?></span>
        </div>
        
    </div>
</div>

</div>