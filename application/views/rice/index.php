<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <div class="row">
            <div class="large-12 medium-12  columns insert_in"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
     $('.ost_id,.ost_city,.ost_name,.ost_vill').keyup(function(){
         var Vall = $(this).val();
         //if(Vall.length > 1){
            var Sort = $(this).attr('class');
            $.ajax({
                url: '/ost/ajax_ost',
                type: 'POST',
                data: {sort: Sort,val:Vall},
                error: function(){
                    alert('errror');
                },
                success: function(data) {
                    //if(data != 1){
                        $('.insert_in').html(data);
                    //}
                    
                }  
            });
        //}
     })
</script>