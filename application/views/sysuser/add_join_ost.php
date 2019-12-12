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
                        <h3 class="semi-bold h_ped"><?=__("Add Stop")?></h3>
                        <div class="padding_center">
                                <div class="col-md-6">
                                    <div class="row">
    <form id="add_material" action="" method="post" >
    <ul class="nav nav-tabs" id="tab-01">
        <li class="active" ><a href="#panel2-1">RU</a></li>
    </ul>
    <br />
    <div class="tab-content">
        <div class="tab-pane active" id="panel2-1">
            <div class="">
                <div class="update-data-ost">
                    <div class="ost_tabs">
                        <div class="u-ost-colum-a ost_ru">
                            <input type="hidden" name="join_route" value="<?=$_GET['id'];?>" />
                            <div class="form-group">
                                <label><? echo __('Name');?></label>
                                <input name="join_name" type="text" class="filds-ost-name name form-control"  value="" />
                            </div>
                            <div class="form-group">
                                <label><? echo __('Join ost ID');?></label>
                                <input name="join_id" type="text" class="filds-ost-desc form-control"   value="" />
                            </div>
                            <div class="form-group">
                                <label><? echo __('Weight');?></label>
                                <input name="weight" type="text" class="filds-ost-desc form-control"   value="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>  
    <div class="col-md-12 no-padding">   
        <button id="admin_login_submit" type="submit" class="btm-edit btn btn-success btn-cons"><?=__("Add")?></button>  
    </div>
    </form>
    </div>
                        
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
    <!-- end google -->