<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<div class="col-md-12 p-t-50 no-padding">

<div class="main_block_map " style="width: 700px;">
    <div class=""><select id="locationSelect" style="width:100%;visibility:hidden;" ></select></div>
    <div id="map_canvas"  class="google-map-ost" style="width: 100%; height: 300px;"></div>
    
    <div class=""><select id="locationSelect" style="width:100%;visibility:hidden;" ></select></div>
    <div id="map_canvas2"  class="google-map-ost" style="width: 100%; height: 300px;"></div>
</div>

</div>
<!-- end google map -->
<!-- google map 2 -->
<style>
#map {
    height:300px;
}
.main_block_map2{
    display: none;
}
</style>
</div>


<div class="print_ticket_block" id="print_ticket_block"></div>
<script type="text/javascript">

var Print = $('.main_block_map').html();

$('.print_ticket_block').html(Print);
setTimeout(printDiv(),1000);


function printDiv() {
 var printContents = document.getElementById('print_ticket_block').innerHTML;
 var originalContents = document.body.innerHTML;

 document.body.innerHTML = printContents;

 window.print();

 document.body.innerHTML = originalContents;
}   

function show_google_map(ost_id){
    //alert(ost_id);
    //exit;
    var Coordinats = '';
    
    
            //alert(data);
            //exit;
            //Coordinats = data.split(',');
            $('.main_block_map').show();
            $('.main_block_map2').hide();
            $('.name_ost').text();
            $('.desc_ost').text();
            ///$('.address_ost').text(Coordinats[4]);
            initialize('48.442904','25.574287');
            //window.scrollTo(0, 0);
            
            //exit;
            
      
   
   
}

show_google_map(1690);

function show_google_map2(ost_id){
    //alert(ost_id);
    //exit;
    var Coordinats = '';
    
    
            //alert(data);
            //exit;
            //Coordinats = data.split(',');
            $('.main_block_map').show();
            $('.main_block_map2').hide();
            $('.name_ost').text();
            $('.desc_ost').text();
            ///$('.address_ost').text(Coordinats[4]);
            initialize2('50.083338','25.150001');
            //window.scrollTo(0, 0);
            
            //exit;

}

show_google_map2(1690);

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

function initialize2(Lat,Lng) {     
    var myLatlng = new google.maps.LatLng(Lat,Lng);
    var myOptions = {
        zoom: 12,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas2"), myOptions);
    
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
            $('.lat_g2').val(marker.position.lat());
            $('.lng_g2').val(marker.position.lng());
       // 
         //alert($('#gpos').val());
         })       
}
 </script>