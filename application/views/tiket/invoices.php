<? $sesuser = Session::instance()->get('ses_user'); 
$lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }//print_r($sesuser); ?>
<div class="bg-top-filters" >
    <div class="col-md-12"><div class=""><h2><?=__('Add Data');?></h2></div>
        <div class="row parr">
            <form method="GET" >
                <div class="col-md-1"><?=__("Dispetcher")?></div>
                <div class="col-md-3">
                    <select name="disp">
                        <? foreach($sysusers as $all){?>
                        <option value="<?=$all['id'];?>" <?if(isset($_GET['disp']) && $_GET['disp'] == $all['id']){ echo 'selected="selected"'; }?> ><?=$all['login'];?></option>
                        <?}?>
                    </select>
                </div>
                <div class="col-md-12"></div>
                <div class="col-md-1"><?=__("Dispetcher")?></div>
                <div class="col-md-4 no-padding">
                            <div class="col-md-6 form-group">
                                <label><?=__("Date From")?></label>
                                <input type="text" name="from" id="in_1" class="form-control" value="<?if(isset($_GET['from'])){ echo $_GET['from']; }?>" /> 
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?=__("Date To")?></label>
                                <input type="text" name="to" id="in_2" class="form-control" value="<?if(isset($_GET['to'])){ echo $_GET['to']; }?>" />
                            </div>
                        </div>
                <br />
                <div class="col-md-12">
                    <button class="btm-edit btn btn-success btn-cons btn-large save_one" style=""><?=__('Search');?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="grid simple">
            <div class="grid-body no-border invoice-body"> <br>
                <div class="pull-left"> <img src="assets/img/invoicelogo.png" data-src="assets/img/invoicelogo.png" data-src-retina="assets/img/invoicelogo2x.png" width="222" height="31" class="invoice-logo" alt="">
                    <address>
                    <?=$main_addres;?>
                    </address>
                </div>
                <div class="pull-right">
                    <h2>invoice</h2>
                </div>
                <div class="clearfix"></div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="semi-bold">Daren forthway</h4>
                        <address>
                        <?=$slave_addres;?>
                        </address>
                    </div>
                    <div class="col-md-3"> <br>
                        <div>
                        <div class="pull-left"> INVOICE NO : </div>
                        <div class="pull-right"> 000985 </div>
                        <div class="clearfix"></div>
                        </div>
                        <div>
                        <div class="pull-left"> INVOICE DATE : </div>
                        <div class="pull-right"> 15/02/13 </div>
                        <div class="clearfix"></div>
                        </div>
                        <br>
                        <div class="well well-small green">
                        <div class="pull-left"> Total Due : </div>
                        <div class="pull-right"> 84,000 USD </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px" class="unseen text-center">ID</th>
                            <th class="text-left"><?=__('Route')?></th>
                            <th class="text-right"><?=__('Ferryman')?></th>
                            <th class="text-right"><?=__('Price')?></th>
                            <th class="text-right"><?=__('%')?></th>
                            <th class="text-right"><?=__('Summ')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        
                        $all_price = 0; 
                        $all_price_proch = 0;
                        $all_price_summ = 0;
                        
                        foreach($tikets as $tik){?>
                        <tr>
                            <td class="unseen text-center"><?=$tik['ticket_id'];?></td>
                            <td><? $rou_name = Model::factory('RouteMod')->get_route_route_id($tik['route_name_id'],$lang,1); if(isset($rou_name[0]['name'])){ echo $rou_name[0]['name'];}?></td>
                            <td class="text-right"><? $fermann_id = DB::select()->from('ferryman')->where('ferryman_id','=',$tik['ferryman_id'])->execute()->current(); echo $fermann_id['name'];?></td>
                            <td class="text-right"><?=$tik['price'].' '.$tik['valute']; $all_price += $tik['price'];?></td>
                            <td class="text-right"><? $one = $tik['price']/100 * $procent; echo $one.' '.$tik['valute']; $all_price_proch += $one;?></td>
                            <td class="text-right"><? $summ = $tik['price'] - $one; echo $summ.' '.$tik['valute']; $all_price_summ += $summ;?></td>
                        </tr>
                        <?}?>
                        <tr>
                            <td colspan="2" rowspan="4" >
                                <h4 class="semi-bold">terms and conditions</h4>
                                <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
                                <h5 class="text-right semi-bold">Thank you for your business</h5>
                            </td>
                            <td class="text-right"><strong>Subtotal</strong></td>
                            <td class="text-right"><?=$all_price;?></td>
                            <td class="text-right"><?=$all_price_proch;?></td>
                            <td class="text-right"><?=$all_price_summ;?></td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><strong>Shipping</strong></td>
                            <td class="text-right">$0.00</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><strong>VAT Included in Total</strong></td>
                            <td class="text-right">$0.00</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><div class="well well-small green"><strong>Total</strong></div></td>
                            <td class="text-right"><strong></strong></td>
                            <td class="text-right"><strong></strong></td>
                            <td class="text-right"><strong>$1607.00</strong></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <h5 class="text-right text-black">Designer identity</h5>
                <h5 class="text-right semi-bold text-black">John Smith</h5>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="invoice-button-action-set">
            <p>
                <button class="btn btn-primary" type="button"><i class="fa fa-print"></i></button>
            </p>
            <p>
                <button class="btn " type="button"><i class="fa fa-cloud-download"></i></button>
            </p>
        </div>
    </div>
</div>

	
 <div class="clearfix"></div>
 <button type="submit" class="cre_csv btn btn-default  btn-xs btn-primary"><?=__("Export to Excel");?></button>
<button type="submit" id="pri_ved_but" class="btm-edit btn btn-success btn-cons" ><?=__("Print");?></button>
 <div id="print_duv"></div>
  </div>

  <!-- END PAGE --> 

<script type="text/javascript">
$('.cre_csv').click(function(){
    var Arr = [];
    $('#example tbody tr').each(function(){
        Arr.push($(this).html());
    })
    
    //var Arrr = [];
    //$('#print_ved_block .name-seller-cash').each(function(){
    //    Arrr.push($(this).text());
    //})
    //alert(Arr);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_create_csv_kassa",
        async: false,
        data: {html:Arr},
        success: function(data) {
            //alert(data);
            location="/vedomost/csv_file.csv";
            //$('#print_duv').html(data);
        },
        error:function(){
            alert('ошибка cre_csv');
        }
    });
})

$('.cre_csv').click(function(){
    var Arr = [];
    $('#example tbody tr').each(function(){
        Arr.push($(this).html());
    })
    
    //var Arrr = [];
    //$('#print_ved_block .name-seller-cash').each(function(){
    //    Arrr.push($(this).text());
    //})
    //alert(Arr);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_create_csv_kassa",
        async: false,
        data: {html:Arr},
        success: function(data) {
            //alert(data);
            location="/vedomost/csv_file.csv";
            //$('#print_duv').html(data);
        },
        error:function(){
            alert('ошибка cre_csv');
        }
    });
})

$('#pri_ved_but').click(function(){
    var Arr = [];
    $('.id').each(function(){
        Arr.push($(this).text());
    })
    //alert(Arr);
    //exit;
    $.ajax({
        type: "POST",
        url: "/tiket/ajax_print_ticket_kassa",
        data: {array:Arr,lang:$("#cur_lan").val()},
        async: false,
        success: function(data) {
            //alert(data);
            //exit;
            //HTmm = data;
            //$(HTmm).insertAfter('.return_peo_after');
            $('#print_duv').html(data);
        },
        error:function(code, opt, err){
            alert("pri_ved_but");
        }
    });
    
    //$('#print_duv .row').hide();
    printDiv();
    location.reload();
    
})
function printDiv() {
     var printContents = document.getElementById('print_duv').innerHTML;
     //printContents += '<div style="padding-top:30px;">'+document.getElementById('inbox-wrapper_').innerHTML+'</div>';
     
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}

$(document).ready(function(){
    $("#in_1,#in_2,#in_3,#in_4").datepicker({
        <?// Model::factory('TiketMod')->dataciper(I18n::lang());?>
        //minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        showOtherMonths: true,
        selectOtherMonths: true
    });
})
</script>