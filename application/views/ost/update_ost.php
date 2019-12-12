<style>
.google-map-ost {
width: 900px;
height: 400px;
margin-bottom: 20px;
}
</style>
<div class="content">    
  	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white --> 
                        <h3 class="semi-bold h_ped"><?=__("Edit Stop")?></h3>
                        <div class="padding_center">
                                <div class="col-md-6">
                                    <div class="row">
    <form id="add_material" action="/ost/update_ost?ost_id=<?php echo $_GET['ost_id'];?>&lang=<?=$_GET['lang'];?>" method="post" >
    <input type="hidden" name="id" value="<?php echo $_GET['ost_id'];?>" />
    <ul class="nav nav-tabs" id="tab-01">
        <li class="active" ><a href="#panel2-1">RU</a></li>
        <li><a href="#panel2-2">UK</a></li>
        <li><a href="#panel2-3">EN</a></li>
        <li><a href="#panel2-4">CS</a></li>
    </ul>
    <br />
    <?//print_r($edit);?>
    <div class="tab-content">
        <div class="tab-pane active" id="panel2-1">
            <div class="form-group">
                <label><? echo __('Validate');?></label>
                <div class="row-fluid">
                    <div class="slide-success">
                        <input type="checkbox" name="is_validate" class="iosblue" value="1" <?if($edit_ost['is_validate'] == 1) { echo 'checked="checked"';}?>/>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="update-data-ost">
                    <div class="ost_tabs">
                        <div class="u-ost-colum-a ost_ru">
                            <div class="form-group">
                                <label><? echo __('Name');?></label>
                                <input name="name_i18n" type="text" class="filds-ost-name name form-control"  value="<?php echo $edit_ost['name_i18n'];?>" />
                            </div>
                            <div class="form-group">
                                <label><? echo __('Description');?></label>
                                <input name="desc_i18n" type="text" class="filds-ost-desc form-control"   value="<?php echo $edit_ost['desc_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Village');?></label>
                                <input name="village" type="text" class="filds-ost-address vil form-control"  value="<?php echo $edit_ost['village'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('City');?></label>
                                <input name="city_i18n" type="text" id="ost_city"  value="<?php echo $edit_ost['city_i18n'];?>" class="filds-ost-city city form-control" />
                            </div>
                            <div class="form-group">
                                <label><? echo __('Address');?></label>
                                <input name="address" type="text" class="filds-ost-address form-control"  value="<?php echo $edit_ost['address'];?>" />
                                
                            </div>
                        </div>
                    </div>
                    <div class="u-ost-colum-b">
                        <div class="form-group">
                            <label><? echo __('Border');?></label>
                            <input name="cordon" type="text"  value="<?php echo $edit_ost['cordon'];?>" class="form-control" />
                            
                        </div>
                        <div class="form-group">
                            <label><? echo __('Tel');?></label>
                            <input name="phone" type="text"  value="<?php echo $edit_ost['phone'];?>" class="form-control" />
                            
                        </div>
                        <div class="form-group">
                            <label><? echo __('Fax');?></label>
                            <input name="fax" type="text"  value="<?php echo $edit_ost['fax'];?>" class="form-control" />
                            
                        </div>
                        <div class="form-group">
                            <label><? echo __('ZIP');?></label>
                            <input name="postal" type="text"  value="<?php echo $edit_ost['postal'];?>"  class="form-control"/>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="panel2-2">
            <div class="">
                <div class="update-data-ost">
                    <div class="ost_tabs">
                        <div class="u-ost-colum-a ost_ru">
                            <div class="form-group">
                                <label><? echo __('Name');?></label>
                                <input name="name_i18n_ua" type="text" class="filds-ost-name name_ua form-control"  value="<?php echo $edit_ost_ua['name_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Description');?></label>
                                <input name="desc_i18n_ua" type="text" class="filds-ost-desc form-control"   value="<?php echo $edit_ost_ua['desc_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Village');?> </label>
                                <input name="village_ua" type="text" class="filds-ost-address vil_ua form-control"  value="<?php echo $edit_ost_ua['village'];?>" />
                               
                            </div>
                            <div class="form-group">
                                <label><? echo __('City');?></label>
                                <input name="city_i18n_ua" type="text" id="ost_city"  value="<?php echo $edit_ost_ua['city_i18n'];?>" class="filds-ost-city city_ua form-control" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Address');?></label>
                                <input name="address_ua" type="text" class="filds-ost-address form-control"  value="<?php echo $edit_ost_ua['address'];?>" />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="panel2-3">
            <div class="">
                <div class="update-data-ost">
                    <div class="ost_tabs">
                        <div class="u-ost-colum-a ost_ru">
                            <div class="form-group">
                                <label><? echo __('Name');?></label>
                                <input name="name_i18n_en" type="text" class="filds-ost-name name_en form-control"  value="<?php echo $edit_ost_en['name_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Description');?></label>
                                <input name="desc_i18n_en" type="text" class="filds-ost-desc form-control"   value="<?php echo $edit_ost_en['desc_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Village');?></label>
                                <input name="village_en" type="text" class="filds-ost-address vil_en form-control"  value="<?php echo $edit_ost_en['village'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('City');?></label>
                                <input name="city_i18n_en" type="text" id="ost_city"  value="<?php echo $edit_ost_en['city_i18n'];?>" class="filds-ost-city city_en" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Address');?></label>
                                <input name="address_en" type="text" class="filds-ost-address form-control"  value="<?php echo $edit_ost_en['address'];?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="panel2-4">
            <div class="">
                <div class="update-data-ost">
                    <div class="ost_tabs">
                        <div class="u-ost-colum-a ost_ru">
                            <div class="form-group">
                                <label><? echo __('Name');?></label>
                                <input name="name_i18n_cs" type="text" class="filds-ost-name name_cs form-control"  value="<?php echo $edit_ost_cs['name_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Description');?></label>
                                <input name="desc_i18n_cs" type="text" class="filds-ost-desc form-control"   value="<?php echo $edit_ost_cs['desc_i18n'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Village');?></label>
                                <input name="village_cs" type="text" class="filds-ost-address vil_cs form-control"  value="<?php echo $edit_ost_cs['village'];?>" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('City');?></label>
                                <input name="city_i18n_cs" type="text" id="ost_city"  value="<?php echo $edit_ost_cs['city_i18n'];?>" class="filds-ost-city city_cs form-control" />
                                
                            </div>
                            <div class="form-group">
                                <label><? echo __('Address');?></label>
                                <input name="address_cs" type="text" class="filds-ost-address form-control"  value="<?php echo $edit_ost_cs['address'];?>" />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>  
    <div class="col-md-6">
        <h3>&nbsp;</h3>
        <h3>&nbsp;</h3>
        <div class="form-group">
            <label><? echo __('Type');?></label>
            <? $res = DB::select()->from('ost_types')->where('route_city_id','=',$edit_ost['route_city_id'])->execute()->as_array(); if(empty($res)) { $res[0]['type_id'] = 1;} ?>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox1" type="checkbox" value="1" <? foreach($res as $item) { if($item['type_id'] == 1) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox1"><? echo __('International Bus');?></label>
                </div>
            </div>
          
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox3" type="checkbox" value="3" <? foreach($res as $item) { if($item['type_id'] == 3) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox3"><? echo __('City Bus');?></label>
                </div>
            </div>
          
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox2" type="checkbox" value="2" <? foreach($res as $item) { if($item['type_id'] == 2) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox2"><? echo __('Train');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox4" type="checkbox" value="4" <? foreach($res as $item) { if($item['type_id'] == 4) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox4"><? echo __('IC');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox5" type="checkbox" value="5" <? foreach($res as $item) { if($item['type_id'] == 5) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox5"><? echo __('Mini Bus');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox6" type="checkbox" value="6" <? foreach($res as $item) { if($item['type_id'] == 6) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox6"><? echo __('Trolleybus');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox7" type="checkbox" value="7" <? foreach($res as $item) { if($item['type_id'] == 7) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox7"><? echo __('Tram');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox8" type="checkbox" value="8" <? foreach($res as $item) { if($item['type_id'] == 8) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox8"><? echo __('Public Bus');?></label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="checkbox check-success 	">
                    <input name="city_type[]" id="checkbox9" type="checkbox" value="9" <? foreach($res as $item) { if($item['type_id'] == 9) { echo 'checked="checked"';}} ?>>
                    <label for="checkbox9"><? echo __('Metro');?></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label><? echo __('Coordinates');?></label>
            <input name="lat" type="text" class="lat_g" value="<?php echo $edit['lat'];?>" />
            <input name="lng" type="text" class="lng_g" value="<?php echo $edit['lng'];?>" />
        </div>
    </div>
    <div class="col-md-12 no-padding">   
        <button id="admin_login_submit" type="submit" class="btm-edit btn btn-salat btn-cons"><?=__("Save")?></button>  
    </div>
    </form>
    <div class="col-md-12 no-padding">
        <button class="btn btn-error btn-cons"  onclick="initialize(<?php if(empty($edit_ost['lat'])) { echo '50.44052124';}else {echo $edit_ost['lat'];}  ;?>,<?php if(empty($edit_ost['lng'])) { echo '30.48994827';}else {echo $edit_ost['lng'];} ?>)">Google <? echo __('Map');?></button>                          
    </div>
    </div>
                        
    <div class=""><select id="locationSelect" style="width:100%;visibility:hidden" ></select></div>
    <div id="map_canvas"  class="google-map-ost"></div>                   
                        
                        
                        
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>

<!-- google -->
<script type="text/javascript">
$('#admin_login_submit').click(function(e){
    if($('.name').val().length == 0 || $('.name_ua').val().length == 0 || $('.name_en').val().length == 0 || $('.name_cs').val().length == 0){
        alert('Заполните поля');
        e.preventDefault();
        exit;
    }
    if($('.vil_ua').val().length == 0 && $('.city_ua').val().length == 0){
        alert('Заполните поля');
        e.preventDefault();
         exit;
        
    }
    if($('.vil_en').val().length == 0 && $('.city_en').val().length == 0){
        alert('Заполните поля');
        e.preventDefault();
         exit;
        
    }
    if($('.vil_cs').val().length == 0 && $('.city_cs').val().length == 0){
        alert('Заполните поля');
        e.preventDefault();
         exit;
        
    }
    
})


    
  function initialize(Lat,Lng) {     
    var myLatlng = new google.maps.LatLng(Lat,Lng);
    var myOptions = {
        zoom: 12,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var contentString = '<div id="content">Тут всё то про что должно быть рассказано</div>';
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable: true,
        title: 'маркер'
    });
    google.maps.event.addListener(marker, 'dragend', function() {
            marker.position.lat();
            initialize(marker.position.lat(),marker.position.lng());
            $('.lat_g').val(marker.position.lat());
            $('.lng_g').val(marker.position.lng());
       // 
         //alert($('#gpos').val());
         })       
}

</script>
<?  $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?latlng=""&sensor=false&language=ru');
        // Если геокодировать удалось, то записываем в БД
        $status = $xml->status;
		echo $xml;
        if ($status == 'OK') {
            $lat = $xml->result->geometry->location->lat;
			$lng = $xml->result->geometry->location->lng;
            echo '<pre>';
            //print_r($xml);
            echo $lat.','.$lng;
            echo $xml->result[2]->formatted_address;
            echo '</pre>';
        } else {
            
        }
  
 ?>