<? 
    $join_tik = DB::select()->from('join_ticket')->where('id','=',$order_id)->execute()->current();
    $tikets = explode(',',$join_tik['tikets']);
    array_pop($tikets);
    $lang = $join_tik['lang'];
    $value = $join_tik['valute'];
    $full_price = $join_tik['full_price'];
    $pincod = $join_tik['pincod'];
    $full_tiks = array();
    $one_wey = 0;
    $chak_wey = 0;
    $return_route = 0;
    foreach($tikets as $one_tik){
        $full = DB::select()->from('ticket')->where('ticket_id','=',$one_tik)->execute()->current();
        if($one_wey != 0 && $one_wey != $full['route_name_id']){
            $chak_wey = 1;
            $return_route = $full['route_name_id'];
        }
        $one_wey = $full['route_name_id'];
        $full_tiks[] = $full;
    }
    if($return_route != 0){
        if(count($full_tiks) == 2){
            //$all_weys = array_chunk($full_tiks, 2);
            $one_weys_array = array($full_tiks[0]);
            $return_weys_array = array($full_tiks[1]);
        }else{
            $all_weys = array_chunk($full_tiks, 2);
            $one_weys_array = $all_weys[0];
            $return_weys_array = $all_weys[1];
        }
        
    }
    //echo $chak_wey;
    $user_by = DB::select()->from('user_tiket')->where('join_tiket_id','=',$join_tik['id'])->execute()->current();
    $user_by = DB::select()->from('users')->join('users_full')->on('users.user_id','=','users_full.user_id')->where('users.user_id','=',$user_by['user_id'])->execute()->current();;
    
    //die;
    //echo $tikets; 
    //print_r($tikets);
    //echo '<pre>'; print_r($one_weys_array); echo '</pre>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Your order:H26T9L</title>
  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  .header {padding: 20px 30px 20px 30px;}
  .innerpadding {padding: 10px 30px 10px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; }
  .h1, .h2, .h3, .bodycopy {color: #153643; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 5px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .h3 {padding: 0 0 5px 0; font-size: 20px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #000;}
  .footercopy a {color: #ffffff; text-decoration: underline;}
  .col222{ background:#22262e}
  .text-white{ color:#fff}
  .travelers-td { font-size:12px}
  .travelers-td th { text-align:left; padding-left:5px}
  .travelers-td td { border-top:#e5e9ec 1px solid; padding-left:5px;}
  .text-info {
    color: #0090d9 !important;
}

.content{font-family: sans-serif;}
  /*Two column layout*/
.two-column {
	text-align: center;
	font-size: 0;
	padding: 20px 10px 0px 30px;
}

.info-route .two-column {
	text-align: center;
	font-size: 0;
	padding: 0px 0px 10px 0px;
}


.info-route .two-column .column {
	width: 100%;
	max-width: 270px;
	display: inline-block;
	vertical-align: top;
}



.two-column .column {
	width: 100%;
	max-width: 280px;
	display: inline-block;
	vertical-align: top;
}
.two-column .contents {
	font-size: 14px;
	text-align: left;
}
.two-column img {
	width: 100%;
	max-width: 240px;
	height: auto;
}
.two-column .text {
	padding-top: 10px;
}

  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }

  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/

  </style>
</head>

<body yahoo bgcolor="#edeff0">
<table width="100%" bgcolor="#edeff0" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
     
      </tr>
      <!--Order-->
      <tr >
<td class="two-column" bgcolor="#22262e">
						<!--[if (gte mso 9)|(IE)]>
						<table width="100%">
						<tr>
						<td width="50%" valign="top">
						<![endif]-->
						<div class="column">
							<table width="100%">
								<tbody><tr>
									<td class="inner">
										<table class="contents">
											<tbody><tr>
												<td class="text-white">
													 <?=__("Order number")?>
												</td>
											</tr>
											<tr>
												<td class="text-white h1">
													<?=$order_id;?>
												</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>
						</div>
						<!--[if (gte mso 9)|(IE)]>
						</td><td width="50%" valign="top">
						<![endif]-->
						<div class="column">
							<table width="100%">
								<tbody><tr>
									<td class="inner">
										<table class="contents">
											<tbody><tr>
									<td class="inner">
										<table class="contents">
											<tbody><tr>
												<td class="text-white">
													<?=__("Pin - code")?>
												</td>
											</tr>
											<tr>
												<td class="text-white h1">
													<?=$pincod;?>
												</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>
									</td>
								</tr>
							</tbody></table>
						</div>
						<!--[if (gte mso 9)|(IE)]>
						</td>
						</tr>
						</table>
						<![endif]-->
	<table>
    <tbody>
           <tr>
                    <td class="subhead" style="padding: 0 0 10px 3px;">
                    
                 <?=__("Your tickets in attachments")?>          
                    
                    </td>
                  </tr>
    				
                    </tbody>
                    </table>
                    </td>
      </tr>
     
     
      <!--/order-->
    
    <tr>
        <td class="innerpadding ">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="info-route">
            <tr>
              <td class="h2 text-info">
             <?=__("Information about routes")?>
              </td>
            </tr>
            <?
                $route_from = DB::select()->from('routename')->where('route_name_id','=',$full_tiks[0]['route_name_id'])->execute()->current();
                $faryman = DB::select()->from('ferryman')->where('ferryman_id','=',$full_tiks[0]['ferryman_id'])->execute()->current();
                $ost_from = DB::select()->from('routecity_i18n')->where('route_city_id','=',$full_tiks[0]['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current(); 
                $ost_to = DB::select()->from('routecity_i18n')->where('route_city_id','=',$full_tiks[0]['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current();
                $platform_from = DB::select()->from('platform')->where('route_name_id','=',$full_tiks[0]['route_name_id'])->and_where('ost_id','=',$full_tiks[0]['route_city_from_id'])->and_where('day_week','=',0)->execute()->current();
                $platform_to = DB::select()->from('platform')->where('route_name_id','=',$full_tiks[0]['route_name_id'])->and_where('ost_id','=',$full_tiks[0]['route_city_to_id'])->and_where('day_week','=',0)->execute()->current();
                //print_r($platform_to['value']);
            ?>
            <tr>
                <td>
                    <table class="contents"  cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="h3"><?=__("One way")?></td>
                            </tr>
                            <tr style="padding:0px; margin:0px; line-height:5px;">    
                                <td class="">
                                    <p style="font-weight:bold; font-size:11px;"><?=$route_from['name']." ".$faryman['name']." ".date('d.m.Y',strtotime($full_tiks[0]['route_date']));?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="two-column" bgcolor="" >
                    <div class="column">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td class="inner">
                                        <table class="contents">
                                            <tbody>
                                                <tr>
                                                    <td class="">
                                                    <?=__("Departs from")?>:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class=""><?  $time = explode(':',$full_tiks[0]['route_time']); echo $time[0].':'.$time[1];?></td>
                                                </tr>
                                                <tr>
                                                <td class=" h3">
                                                    <?=$ost_from['city_i18n'].' '.$ost_from['name_i18n'].' '.$platform_from['value'];?>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td class="inner">
                                        <table class="contents">
                                            <tbody>
                                                <tr>
                                                    <td class="inner">
                                                        <table class="contents">
                                                            <tbody><tr>
                                                            <td class="">
                                                            <?=__("Arrives to")?>:
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td class="">
                                                                <?  $time = explode(':',$full_tiks[0]['route_timeto']); echo $time[0].':'.$time[1];?>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td class=" h3">
                                                             <?=$ost_to['city_i18n'].' '.$ost_to['name_i18n'].' '.$platform_to['value'];?>
                                                            </td>
                                                            </tr>  
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            
        <tr>
        <td class="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2 text-info">
               <?=__("Travellers")?>
              </td>
            </tr>
            <?  if($return_route == 0){
                    $one_weys_array = $full_tiks;
                }
                foreach($one_weys_array as $one_tik_people){
                $client = DB::select()->from('ticket_people')->where('id','=',$one_tik_people['client_id'])->execute()->current();
                ?>
            <tr>
              <td class="bodycopy">   
                <table width="90%" class="travelers-td" cellspacing="0" cellpadding="0" >
                    <tbody>
                        <tr>
                            <th scope="col"><?=__("First name")?></th>
                            <th scope="col"> <?=__("Last name")?></th>
                            <th scope="col"><?=__("Price")?></th>
                            <th scope="col"><?=__("Tariff")?></th>
                            <!--<th scope="col">Baggage</th>-->
                            <th scope="col"> <?=__("Seat")?></th>
                        </tr>
                        <tr>
                            <td scope="col"><?=$client['name'];?></td>
                            <td scope="col"><?=$client['soname'];?></td>
                            <td scope="col"><?=$one_tik_people['route_price_discount'].' '.$value;?></td>
                            <td scope="col"><?  $discount_id = $one_tik_people['discount_id']; $dis_name = Model::factory('DiscountMod')->get_disc_name($discount_id,$lang); echo $dis_name['name_i18n']; ?> <? if($discount_id == 1 && $one_tik_people['return_discount'] == 1){ echo ', '.__('Return'); } ?></td>
                            <!--<td scope="col">-</td>-->
                            <td scope="col"><?=$one_tik_people['value'];?></td>
                        </tr>
                    </tbody>
                </table>
                <table style="font-size:12px">
                    <tbody>
                        <tr>
                            <td> <?=__("Ticket")?>: <?=$one_tik_people['ticket_id'];?></td>
                        </tr>
                    </tbody>
                </table>
                <table style="">
                    <tbody>
                        <tr>
                            <td class="h3"> <?=__("Total price")?>: <?=$one_tik_people['route_price_discount'].' '.$value;?></td>
                        </tr>
                        <tr style="font-size:11px;">
                            <td><?=__("Cancellation Policy")?>:</td>
                        </tr>
                    </tbody>
                </table>        
              </td>
            </tr>
            <?}?>
            
          </table>
        </td>
      </tr>
            
            <? if($return_route != 0){ 
                $route_from_return = DB::select()->from('routename')->where('route_name_id','=',$return_weys_array[0]['route_name_id'])->execute()->current();
                $faryman_return = DB::select()->from('ferryman')->where('ferryman_id','=',$return_weys_array[0]['ferryman_id'])->execute()->current(); 
                $ost_from_return = DB::select()->from('routecity_i18n')->where('route_city_id','=',$return_weys_array[0]['route_city_from_id'])->and_where('culture','=',$lang)->execute()->current(); 
                $ost_to_return = DB::select()->from('routecity_i18n')->where('route_city_id','=',$return_weys_array[0]['route_city_to_id'])->and_where('culture','=',$lang)->execute()->current(); 
                $platform_from_return = DB::select()->from('platform')->where('route_name_id','=',$return_weys_array[0]['route_name_id'])->and_where('ost_id','=',$return_weys_array[0]['route_city_from_id'])->and_where('day_week','=',0)->execute()->current();
                $platform_to_return = DB::select()->from('platform')->where('route_name_id','=',$return_weys_array[0]['route_name_id'])->and_where('ost_id','=',$return_weys_array[0]['route_city_to_id'])->and_where('day_week','=',0)->execute()->current();
            ?>
            <tr>
                <td>
                    <table class="contents"  cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="h3"><?=__("Return way")?></td>
                            </tr>
                            <tr style="padding:0px; margin:0px; line-height:5px;">    
                                <td class="">
                                    <?if(!empty($faryman_return)){?>
                                        <p style="font-weight:bold; font-size:11px;"><?=$route_from_return['name']." ".$faryman_return['name']." ".date('d.m.Y',strtotime($return_weys_array[0]['route_date']));?></p>
                                    <?}else{?>
                                        <p style="font-weight:bold; font-size:11px;"><?=$route_from_return['name']." OPEN";?></p>
                                    <?}?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="two-column" bgcolor="" >
                    <div class="column">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td class="inner">
                                        <table class="contents">
                                            <tbody>
                                                <tr>
                                                    <td class="">
                                                    <?=__("Departs from")?>:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="">
                                                        <?if(!empty($faryman_return)){?>
                                                            <?  $time = explode(':',$return_weys_array[0]['route_time']); echo $time[0].':'.$time[1];?>
                                                        <?}?>
                                                    </td>                                                    
                                                </tr>
                                                <tr>
                                                <td class=" h3">
                                                    <?=$ost_from_return['city_i18n'].' '.$ost_from_return['name_i18n'].' '.$platform_from_return['value'];?>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td class="inner">
                                        <table class="contents">
                                            <tbody>
                                                <tr>
                                                    <td class="inner">
                                                        <table class="contents">
                                                            <tbody><tr>
                                                            <td class="">
                                                            <?=__("Arrives to")?>:
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td class="">
                                                                <?if(!empty($faryman_return)){?>
                                                                    <?  $time = explode(':',$return_weys_array[0]['route_timeto']); echo $time[0].':'.$time[1];?>
                                                                <?}?>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td class=" h3">
                                                             <?=$ost_to_return['city_i18n'].' '.$ost_to_return['name_i18n'].' '.$platform_to_return['value'];?>
                                                            </td>
                                                            </tr>  
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <?}?>
            
            
            
            
            
          </table>
        </td>
      </tr>
    
    
    
    
        <?if($return_route != 0){?>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2 text-info">
               <?=__("Travellers")?>
              </td>
            </tr>
            <? foreach($return_weys_array as $one_tik_people){
                $client = DB::select()->from('ticket_people')->where('id','=',$one_tik_people['client_id'])->execute()->current();
                ?>
            <tr>
              <td class="bodycopy">   
                <table width="90%" class="travelers-td" cellspacing="0" cellpadding="0" >
                    <tbody>
                        <tr>
                            <th scope="col"><?=__("First name")?></th>
                            <th scope="col"> <?=__("Last name")?></th>
                            <th scope="col"><?=__("Price")?></th>
                            <th scope="col"><?=__("Tariff")?></th>
                            <!--<th scope="col">Baggage</th>-->
                            <th scope="col"> <?=__("Seat")?></th>
                        </tr>
                        <tr>
                            <td scope="col"><?=$client['name'];?></td>
                            <td scope="col"><?=$client['soname'];?></td>
                            <td scope="col"><?=$one_tik_people['route_price_discount'].' '.$value;?></td>
                            <td scope="col"><?  $discount_id = $one_tik_people['discount_id']; $dis_name = Model::factory('DiscountMod')->get_disc_name($discount_id,$lang); echo $dis_name['name_i18n']; ?> <? if($discount_id == 1 && $one_tik_people['return_discount'] == 1){ echo ', '.__('Return'); } ?></td>
                            <!--<td scope="col">-</td>-->
                            <td scope="col"><?=$one_tik_people['value'];?></td>
                        </tr>
                    </tbody>
                </table>
                <table style="font-size:12px">
                    <tbody>
                        <tr>
                            <td> <?=__("Ticket")?>: <?=$one_tik_people['ticket_id'];?></td>
                        </tr>
                    </tbody>
                </table>
                <table style="">
                    <tbody>
                        <tr>
                            <td class="h3"> <?=__("Total price")?>: <?=$one_tik_people['route_price_discount'].' '.$value;?></td>
                        </tr>
                        <tr style="font-size:11px;">
                            <td><?=__("Cancellation Policy")?>:</td>
                        </tr>
                    </tbody>
                </table>        
              </td>
            </tr>
            <?}?>
            
          </table>
        </td>
      </tr>
      <?}?>
        
      
      
       <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2 text-info">
               <?=__("Contact information")?>
              </td>
            </tr>
            <tr>
              <td class="bodycopy">
               
               <p style=" font-weight:bold"><?=$user_by['name'].' '.$user_by['soname'];?></p>
               <p><?=__("Phone number")?>:<?=$user_by['phone'];?></p>
               <p><?=__("E-mail")?>:<?=$user_by['email'];?></p>
               
              </td>
            </tr>
          </table>
        </td>
      </tr>
      
        <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2 text-info">
              <?=__("Price summary")?>:
              </td>
            </tr>
            <tr>
              <td class="bodycopy">
               
              <h2><?=$join_tik['full_price'].' '.$value;?></h2>
              
              
               
              </td>
            </tr>
          </table>
        </td>
      </tr>
      
      
      
  
     

      <tr>
    
      </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>


</body>
</html>