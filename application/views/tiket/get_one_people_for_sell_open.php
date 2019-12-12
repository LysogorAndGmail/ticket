<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>

<? $sesuser = Session::instance()->get('ses_user');?>


<style>
.ajax_people_block .on_peo {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: #fff;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.ajax_people_block .on_peo:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}

.ajax_people_block {
    position: absolute;
    width: 500px;
    z-index:999999;
    left:-35px;
    box-shadow:  0 2px 4px gray;
    background-color: #fff !important;
}
.ajax_people_block ul{
    padding: 0 !important;
}

.ajax_people_id_block {
    position: absolute;
    width: 500px;
    z-index:999999;
    left:-35px;
    box-shadow:  0 2px 4px gray;
    background-color: #fff !important;
}
.ajax_people_id_block ul{
    padding: 0 !important;
}

.ajax_people_id_block .on_peo {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: #fff;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.ajax_people_id_block .on_peo:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}



.one_people {
    height: 92px;
    background-color: #dee9f5 !important;
    border-bottom: 1px solid #dddddd;
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
    height: 93px;
    margin-top: 91px;
    border: 3px solid #e4e8eb;
    font-size: 14px;
    position: absolute;
    z-index:999;
    display: none;
}
</style>
<? $mil_sek = strtotime('now');// echo $mil_sek;

?>
<div class="one_people col-md-12 no-padding">
 <div class="col-md-12">
    
    
    
    <div class=" col-md-1 in_1_sec">
        <div class="controls p-t-10">
        <input type="text" class="cl_id ajax_cl_id form-control" />
        <span class="ajax_people_id_block"></span>
         <span class="dis_price" style="display:none;"><?=$price;?></span>
   
   </div>
   
   
    </div>
    
    
    <div class=" col-md-2 in_2">
     <div class="controls p-t-10">
         <input type="text" class="soname form-control ajax_tel valid upper" />
        <span class="ajax_people_block"></span>
        </div>
    </div>
    
    
    
    <div class="col-md-2 in_2">
     <div class="controls p-t-10">
        <input type="text" class="name form-control valid upper" />
        </div>
    </div>
    
    
    
    <div class="col-md-2 in_5">
     <div class="controls p-t-10">
              <input type="text" class="date form-control custom_date valid" id="date<?=$mil_sek?>" title="format 99/99/9999" />

        </div>
    </div>
    
    
    
    <div class="col-md-2 in_2">
     <div class="controls p-t-10">
        <input type="text" class="tel form-control valid" value="<?=$sesuser[0]['phone_kod'];?>" maxlength="12"  />
  </div>
    </div>
    
    
    
    <div class="form-group col-md-2 no-padding" style="display: none;">
        <input type="text" class="tel2 form-control" id="phone2"/>
    </div>
    
    
    
    <div class="col-md-1 in_3 par_sell" style="margin: 0;">
       
        <div class="controls p-t-10">
            <select class="discount_hid" disabled="disabled">
            <? if(is_array($all_discount_hidden)){ foreach($all_discount_hidden as $di){?>
            <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
            <?}}?>
        </select>
        <select class="discount">
            <? if(is_array($all_discount)){foreach($all_discount as $di){?>
            <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
            <?}}?>
        </select>
    
    </div>
    
    </div>
   
   
   </div>
   

<div class="col-md-12">
    <div class="form-group col-md-8 bot_us">
          &nbsp;<span style="font-weight: bold; margin-left: 7px;"><?=__('Tariff')?>:</span>&nbsp;<span class="info_discounts" ><? if(!empty($all_discount_hidden)){ echo $all_discount_hidden[0]['name_simple_i18n'];}?></span>
        <div class="form-group col-md-4 pull-right" style="margin-top: -3px;">
            <span style="font-size: 18px; font-weight: bold;" class="dis_price_inf" ><?=$price;?></span> <?=$valute;?>
        </div>
    </div>
    
    <div class="col-md-3 in_3 pad_top " >
      <div class="controls ">
     
     <? $random = rand(5, 15);?>
            <span style="margin-right: 10px; cursor: pointer; display: none;" data-toggle="modal" data-target="#my<?=$random;?>" class="edit_cleent"><i title="<?=__('Edit Client')?>" class="fa fa-pencil-square-o m-r-5" style="color: #1da0db; font-size: 18px; margin: 2px 5px 0;"></i></span><span class="clear_cleent" style="cursor: pointer;"><i class="fa fa-undo" title="<?=__('Refresh')?>" style="color: #1da0db; font-size: 18px; margin: 2px 0;"></i></span>&nbsp;<span style="margin: 0 8px; cursor: pointer;" class="rem_plase"><i class="fa fa-times-circle-o" style="color: #fc2525; font-size: 18px;"></i></span>
            <!-- Modal -->
            <div class="modal fade" id="my<?=$random;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">?</button>
                            <h4 id="myModalLabel" class="semi-bold"><?=__('Edit Client')?></h4>
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
                                <div class="col-md-8">
                                    <label><?=__('Phone')?>2</label>
                                    <input type="text" class="form-control edit_phone2" >
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
    
    </div>
    
    
    
    
    
</div>

<div class="form-group col-md-12 dis_5_of_10">
         <div class="col-md-7" style="margin-top: 31px;">
            <p style="font-weight: bold; color:#000;"><span>-</span> <span class="in_dis_5_10 info_discounts_5_10"></span></p>
            <input type="hidden" class="info_discounts_5_10_val" value="" />
        </div>
        <div class="col-md-5" style="margin-top: 26px;">
            <span class="btn  conform_dis btn-success"><?=__('Confirm')?></span>
            <span class="btn conform_dis_no btn-danger" style="margin-left: 5px;"><?=__('Cancel')?></span>
        </div>
    </div>
</div>
<script src="<?=Kohana::$base_url?>js/mask.js" type="text/javascript"></script>


<script type="text/javascript">
$('.conform_dis_no').click(function(){
    var Par = $(this).parents('.one_people');
    Par.find('.dis_5_of_10').hide();
})

$('.conform_dis').click(function(){
    /////
    var Par = $(this).parents('.one_people');
    var CurDis = Par.find('.info_discounts_5_10_val').val();
    
    
    var Prise = parseFloat('<?=$price?>');
    
    var PlaseVal = $(this).parents('.one_people').find('.plase').text();
    
    Par.find('.discount_hid option').each(function(){
        $(this).attr('selected',false);
    });
    
    Par.find('.discount_hid option').each(function(){
        if($(this).val() == CurDis){
        
            $(this).attr('selected','selected');
            //alert($(this).val());
            Par.find('.discount_hid').select();
            /////
            var Proc = 0;
            $.ajax({
                type: "POST",
                url: "/discounts/ajax_get_discount",
                data: {dis_id:$(this).val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    Proc = parseFloat(data);
                },
                error:function(code, opt, err){
                    alert("Состояние custom_date length");
                }
            });                
            
            //alert(Par.find('.discount_hid option:selected').text());
            Par.find('.info_discounts').text(Par.find('.discount_hid option:selected').text());
            
            //var PRI = parseFloat($('.al').text());
            var PRiDIS = Prise/100*Proc;
            var NewPriceDIS = Prise - PRiDIS;
            
            $('.people .plase').each(function(){
                if($(this).text() == PlaseVal){
                    $(this).next('.dis_price').text(NewPriceDIS.toFixed(2));
                    $(this).parents('.one_people').find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
                }
            })
            //$('.al').text(NewPriceDIS.toFixed(2));
            //alert(NewPriceDIS);
            
            
            
            PeopleCURPRICEDISC();
            //exit;
            /////
        }
        
    });
    
    /////////////////////////////
    
    
    Par.find('.dis_5_of_10').hide();
    
    /////////////////////////////
    
    //alert(CurDis);
    //exit;
    
    //var PlaseVal
    //alert('select');
    
    
    
    //var Proc = 0;
    //$.ajax({
    //    type: "POST",
    //    url: "/discounts/ajax_get_discount_10",
    //    data: {dis_id:Valuee,fer_id:$('.ferryman').val()},
    //    async: false,
    //    success: function(data) {
            //alert(data);
     //       Proc = parseFloat(data);
     //   },
     //   error:function(code, opt, err){
            //alert("Состояние custom_date");
     //   }
    //});                
    //alert(Proc);
    //exit;
    //alert(Par.find('.discount_hid option:selected').text());
    //Par.find('.info_discounts').text(Par.find('.discount_hid option:selected').text());
    
    //var PRI = parseFloat($('.al').text());
    //var PRiDIS = Prise/100*Proc;
    //var NewPriceDIS = Prise - PRiDIS;
    //$('.plase').each(function(){
       // if($(this).text() == PlaseVal){
     //       Par.find('.dis_price').text(NewPriceDIS.toFixed(2));
     //       Par.find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
        //}
    //})
    //$('.al').text(NewPriceDIS.toFixed(2));
    //alert(NewPriceDIS);
    //Par.find('.dis_5_of_10').hide();
    
    //CURPRICEDISC();
    
    //exit;
    /////
})



$('.update_cleent_but').click(function(){
    var ID = $(this).parents('.modal-content').find('.cleent_id').val();
    var Name = $(this).parents('.modal-content').find('.edit_name').val();
    var Soname = $(this).parents('.modal-content').find('.edit_soname').val();
    var Date = $(this).parents('.modal-content').find('.edit_date').val();
    var Phone = $(this).parents('.modal-content').find('.edit_phone').val();
    var Phone2 = $(this).parents('.modal-content').find('.edit_phone2').val();
    $.ajax({
            type: "POST",
            url: "/sysuser/ajax_update_cleent",
            data: {id:ID,name:Name,soname:Soname,date:Date,phone:Phone,phone2:Phone2},
            async: false,
            success: function(data) {
                //alert(data);
                //Proc = parseFloat(data);
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        });    
})
    

$('.discount').change(function(){
        //alert('ok');
        //exit;
        if($(this).val() != ''){
        var Prise = parseFloat('<?=$price?>');
        var PlaseVal = $(this).parents('.one_people').find('.plase').text();
        var Proc = 0;
        var Par = $(this).parents('.one_people');
        $(this).attr('selected','selected');
        
        
         //////////// проверка фиксированая цена или проценты
        
        var Chek_fix = '';
        
        $.ajax({
            type: "POST",
            url: "/discounts/ajax_chek_fixet",
            data: {dis_id:$(this).val(),route_name_id:'<?=$route_name_id;?>'},
            async: false,
            success: function(data) {
                //alert(data);
                //Proc = parseFloat(data);
                //exit;
                Chek_fix = data;
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        }); 
        
        if(Chek_fix == 'fix'){
        var fix_price = 0;    
            $.ajax({
                type: "POST",
                url: "/discounts/ajax_get_discount_fix",
                data: {dis_id:$(this).val(),route_name_id:'<?=$route_name_id;?>',valute:'<?=$valute;?>'},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //Proc = parseFloat(data);
                    fix_price = parseFloat(data);
                },
                error:function(code, opt, err){
                    alert("Состояние : ajax_get_discount_fix");
                }
            });     
            
        var NewPriceDIS = fix_price;
        $('.people .plase').each(function(){
            if($(this).text() == PlaseVal){
                $(this).next('.dis_price').text(NewPriceDIS.toFixed(2));
                $(this).parents('.one_people').find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
            }
        })    
            
        }else{ 
        
        
        
        
        
        $.ajax({
            type: "POST",
            url: "/discounts/ajax_get_discount",
            data: {dis_id:$(this).val()},
            async: false,
            success: function(data) {
                //alert(data);
                Proc = parseFloat(data);
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        });                
        
        //var PRI = parseFloat($('.al').text());
        var PRiDIS = Prise/100*Proc;
        var NewPriceDIS = Prise - PRiDIS;
        
        Par.find('.dis_price').text(NewPriceDIS.toFixed(2));
        Par.find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
        
        //$('.al').text(NewPriceDIS.toFixed(2));
        }
        //Par.find('.info_discounts').text($(this).text());
        Par.find('.info_discounts').text(Par.find('.discount option:selected').text());
        
        //alert(NewPrice);
        PeopleCURPRICEDISC();
        //exit;
        //$('.al').text(0);
        
        
        
        }
    })



$(function($){
   $("#date<?=$mil_sek?>").mask("99/99/9999");
   $("#phone").mask("(999) 999-99-99");
   $("#phone2").mask("(999) 999-99-99");
   
   $('.valid').focus(function(){
      $(this).removeClass('noValid_empty');
    })

});

$('.clear_cleent').click(function(){
    
    var Parent = $(this).parents('.one_people');
    Parent.find('.soname').val('');
    Parent.find('.name').val('');
    Parent.find('.tel').val('');
    Parent.find('.date').val('');
})


$('.rem_plase').click(function(){
    
    var Plase = $(this).parents('.one_people').find('.plase').text();
    $(this).parents('.one_people').remove();
    PeopleCURPRICEDISC();
})

function PeopleCURPRICEDISC(){
    $('.al').text(0);
    var Start = 0;
    $('.people').find('.dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    //Sums)
    $('.al').text(Math.round(Start));
    $('.top_val').text('<?=$valute;?>');
    
    al_busket();
    //alert(Start);
}

function al_busket(){
    
    $('.al_bascet').text(0);
    var Start = 0;
    //$('.return_dis_price').each(function(){
    Start = parseFloat($('.return_al').html());
    var Start2 = 0;
    //$('.return_dis_price').each(function(){
    Start2 = parseFloat($('.al').text());
    
    var Sums = Start + Start2;
    //alert(Sums);
    $('.al_bascet').text(Math.round(Sums));
}

$('.upper').keyup(function(){
   var Vall = $(this).val();
   if(Vall.length == 1){
    var predlojenie = Vall; 
   var pervayabukva =predlojenie.charAt(0).toLowerCase(); 
   var novaya = predlojenie.charAt(0).toUpperCase(); 
   var predlojenie_new = predlojenie.replace(pervayabukva, novaya); 
   //alert(predlojenie_new);
   $(this).val(''+predlojenie_new);
   }
   
})


$('.ajax_tel').keyup(function(){
    var Blo = $(this);
    //Blo.next('.ajax_loadd').show(1000);
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_get_people_no_ferryman",
        data: {tel:$(this).val(),ferryman_id:3},
        //async: ,
        success: function(data) {
            //alert(data);
            //Proc = parseFloat(data);
            Blo.next('.ajax_people_block').html(data);
            
            
        },
        error:function(code, opt, err){
            //alert("Состояние ajax_tel");
        }
    });
    //Blo.next('.ajax_loadd').hide(10000);
})

$('.ajax_cl_id').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_cl_id",
                data: {id:$(this).val(),ferryman_id:3},
                //async: false,
                success: function(data) {
                    //alert(data);
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_id_block').html(data);
                },
                error:function(code, opt, err){
                    //alert("Состояние ajax_cl_id");
                }
            });
        })
        
   $('.custom_date').blur(function(){
                //alert();
                var Prise = parseFloat('<?=$price?>');
                var Par = $(this).parents('.one_people');
                var FiarstData = '';
                $.ajax({
                    type: "POST",
                    url: "/discounts/ajax_get_discount_age",
                    data: {burn:$(this).val(),ferryman_id:3},
                    async: false,
                    success: function(data) {
                        //alert(data);
                        //exit;
                        if(data.length > 0){
                            //alert('>');
                                Par.find('option').each(function(){
                                if($(this).val() == data){
                                    $(this).attr('selected','selected');
                                    //alert($(this).val());
                                    Par.find('.discount_hid').select();
                                    /////
                                    var Proc = 0;
                                    $.ajax({
                                        type: "POST",
                                        url: "/discounts/ajax_get_discount",
                                        data: {dis_id:$(this).val()},
                                        async: false,
                                        success: function(data) {
                                            //alert(data);
                                            Proc = parseFloat(data);
                                        },
                                        error:function(code, opt, err){
                                            alert("Состояние custom_date length");
                                        }
                                    });                
                                    
                                    //alert(Par.find('.discount_hid option:selected').text());
                                    Par.find('.info_discounts').text(Par.find('.discount_hid option:selected').text());
                                    
                                    var PRiDIS = Prise/100*Proc;
                                    var NewPriceDIS = Prise - PRiDIS;
                                    
                                    Par.find('.dis_price').text(NewPriceDIS.toFixed(2));
                                    Par.find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
                                    
                                    //$('.al').text(NewPriceDIS.toFixed(2));
                                    
                                    //Par.find('.info_discounts').text($(this).text());
                                    //Par.find('.info_discounts').text(Par.find('.discount option:selected').text());
                                    
                                    //alert(NewPrice);
                                    PeopleCURPRICEDISC();
                                    
                                    //exit;
                                    /////
                                }
                            })
                        }//else{
                            //alert('her');
                        //}
                        //exit;
                        
                    },
                    error:function(code, opt, err){
                        alert("Состояние : custom_date ошибка");
                    }
                });
             })    
</script>

