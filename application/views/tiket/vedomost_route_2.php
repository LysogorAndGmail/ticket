<input type="hidden" class="cur_url" value="<?=$_SERVER['REQUEST_URI'];?>" />


<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title">  
					  <?

                                    $al_tik_date_from = array();
                                    $al_tik_date_from = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_from_id')
                                                    ->and_where('ticket_type_id','=',1)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();
                                     $al_tik_date_from_reverse = array();               
                                     $al_tik_date_from_reverse = DB::select()->from('ticket')
                                                    ->where('route_name_id','=',$route['route_name_id'])
                                                    ->and_where('route_date','=',$route['date'])
                                                    ->and_where('ferryman_id','=',$route['ferryman_id'])
                                                    ->order_by('route_city_from_id')
                                                    ->and_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',2)
                                                    //->or_where('ticket_type_id','=',4)
                                                    ->execute()->as_array();                
                                   
                                    
                                     foreach($al_tik_date_from_reverse as $r){
                                        array_push($al_tik_date_from,$r);
                                     }
                                    
                                    $new_tik = array();   
                                    foreach($al_tik_date_from as $tik_from){
                                        $new_tik[$tik_from['user_id']][] = $tik_from;
                                    } 
                                    
                                    //print_r($new_tik);
                                    
                                    ?>

					
					<? 
                                    $all_cassa = 0;
                                    $route_name = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$route['route_name_id'])->and_where('culture','=',$lang)->execute()->current();
                                    echo '<span>'.$route_name['name'].'</span> (<span>'.$route_name['name_i18n'].'</span>)'; ?>
                    </div>
                  </div>
                  
                  <div class="panel-body">
            <div id="print_ved_block" >

                                   
                                    
                                  
                                     <table class="table-condensed"  style="width:100%">
                                        <tbody>
                                        <? foreach($new_tik as $bilet=>$val){
                                              if($bilet == 0){
                                                $bilet = 'SuperAdmin';
                                              }else{
                                                $new_name = DB::select()->from('system_users')->where('id','=',$bilet)->execute()->current();
                                                $bilet = $new_name['login'];
                                              }      
                                       //echo '<pre>';
                                       //print_r($new_tik);
                                       //echo '</pre>';                
                                            
                                              //  $city_from = Model::factory('OstMod')->get_ost($tik['route_city_from_id'],$lang);
                                              //  $city_to = Model::factory('OstMod')->get_ost($tik['route_city_to_id'],$lang);
                                                //print_r($city_from);
                                                
                                            ?>
                                       <div>
                                    
                                       <tr>
                                        <td id="prin<?=$bilet;?>">
                                       <h4><?=date('d.m.Y',strtotime($_GET['date']));?></h4>
                                       <span class="name-seller-cash"> <?=$bilet;?></span>
                                       
                                     
                                       
                                         <table class="table table-hover  table-condensed" id="example">
                                        <thead>
                                            <tr>
                                                <th align="center"> V </th>
                                                <th align="center"><?=__("Seats")?></th>
                                                <th><?=__("Client")?></th>
                                                <th><?=__("Route")?></th>
                                                <th><?=__("Ticket")?></th>
                                                <th><?=__("Price")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? $cou = 0; $all_sel = 0; foreach($val as $v){
                                                $city_from = Model::factory('OstMod')->get_ost($v['route_city_from_id'],$lang);
                                                $city_to = Model::factory('OstMod')->get_ost($v['route_city_to_id'],$lang);
                                                $people =  DB::select()->from('ticket_people')->where('id','=',$v['client_id'])->execute()->current();
                                                $valute =  DB::select()->from('ticket_valute')->where('tiket_id','=',$v['ticket_id'])->execute()->current();
                                                
                                                //print_r($people);
                                                //die;
                                                ?>
                                                <tr class="need">
                                                    <td></td>
                                                    <td><?=$v['value'];?></td>
                                                    <td><?=$people['soname'].' '.$people['name'];?></td>
                                                    <td><?$cit_fro = Model::factory('TiketMod')->mb_ucfirst($city_from['city_i18n']);
                                                $cit_to = Model::factory('TiketMod')->mb_ucfirst($city_to['city_i18n']);
                                                echo substr($cit_fro, 0, 6).'-'.substr($cit_to, 0, 6);?></td>
                                                    <td><?=$v['ticket_id'];?></td>
                                                    <td><?=$v['route_price_discount'].' '.$valute['valute'];?></td>
                                                </tr>
                                            <? $cou++; $all_sel += $v['route_price_discount'];}?>
                                            <tr class="need1" >
                                                <td colspan="5">  <span class="money-seller-cash"><?=__('Amount of');?>: </span></td>   
                                                <td> <span class="money-seller-cash"><?=$cou;?></span></td>
                                            </tr>
                                            <tr class="need1">
                                            	<td colspan="5">
                                                    <span class="money-seller-cash"><?=__('Total sum');?>: </span><br />
                                                    <span class="money-seller-cash"><?=__('Commission');?>: </span>
                                             </td>
                                            	<td> 
                                                    <span class="money-seller-cash"><?=$all_sel.' '.$valute['valute'];?></span><br />
                                                    <? $proc_price =  $all_sel/100 * $new_name['procent'];
                                                    //$al_pri_sum = $new_price - $proc_price;
                                                    //echo $proc_price ." ". $valll."<br />";?>
                                                    <span class="money-seller-cash"><?= $new_name['procent'].'% '.$proc_price.' '.$valute['valute'];?></span>
                                                </td>
                                        	</tr>
                                        </tbody>
                                        </table>
                                        </td>
                                       </tr>
                                       <tr>
                                        <td>
                                            <div class="col-md-12 ">
                                            
                                            <div role="toolbar" class="btn-toolbar">
                          <div class="btn-group sm-m-t-10">
                            <button class="btn btn-default pri_ved_bu " type="button" data-pri="prin<?=$bilet;?>" data-sys="<?=$bilet;?>" data-da="<?=$_GET['date'];?>" title="<?=__("Print");?>"><i class="fa fa-print"></i>
                            </button>
                            <button class="btn btn-default active   cre_csv" type="button"  data-pri="prin<?=$bilet;?>" data-sys="<?=$bilet;?>" title="<?=__("Export to Excel");?>"><i class="fa fa-file-excel-o"></i>

                            </button>
                            
                          </div>
                        </div>
                                         
                                            </div>
                                        </td>
                                       </tr>
                                       
                                        <?}?> 
                                        </tbody>
                                        </table>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>









        
        
        
        
        
    
     <script src="<?=Kohana::$base_url;?>assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-datatable/extra/js/TableTools.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?=Kohana::$base_url;?>assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url;?>assets/plugins/datatables-responsive/js/lodash.min.js"></script>

    <script src="<?=Kohana::$base_url;?>assets/js/datatables.js" type="text/javascript"></script>
                                
                                
                                
                                
                                
                                
        
        
        
        
<div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.cre_csv').click(function(){
    var ID = $(this).data('pri');
    var printContents = document.getElementById(ID).innerHTML;
    
    //var Arrr = [];
    //$('#print_ved_block .name-seller-cash').each(function(){
    //    Arrr.push($(this).text());
    //})
    //alert($(this).data('sys'));
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/tiket/create_ajax_csv",
        //async: false,
        data: {html:printContents,sys:$(this).data('sys')},
        success: function(data) {
            ///alert(data);
            location="/vedomost/csv_file.csv";
        },
        error:function(){
            alert('ошибка cre_csv');
        }
    });
})


$('.pri_ved_but').click(function(){
    var Div = $(this).data('pri');
    //alert(Div);
    printDiv(Div);
    var CUR = $('.cur_url').val();
    location=CUR;
})


function printDiv(ID) {
     var printContents = document.getElementById(ID).innerHTML;
     //alert(printContents);
     //exit;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     
     //window.close();
}
</script>