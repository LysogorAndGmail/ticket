<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-6">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Change password")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <form method="POST" action="/sysuser/chen_pass">
    <div class="col-md-12">
    <div class="form-group">
    <label class="form-label"><? echo __('New password');?></label>
    <div class="input-with-icon  right">
    <i class=""></i>
    <input name="new_pass" type="text" value="" class="new_pass form-control valid" />
    </div>
    </div>
    <div class="form-group">
    <label class="form-label"><? echo __('Repeat new password');?></label>
    <div class="input-with-icon  right">
    <i class=""></i>
    <input name="rep_pass" type="text" value="" class="rep_pass form-control valid" />
    </div>
    </div>
    <div class="form-group">
    <label class="form-label"></label>
    <div class="input-with-icon  right">
    <i class=""></i>
    <button class="cha_bt btn btn-primary btn-cons"><?=__("Save")?></button>
    </div>
    </div>
    </div>
    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>


<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-6">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Change the language")?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            <div class="col-md-12">
               <ul class="poplang-content" style="list-style:none; margin-left:0px; padding-left:0px;">
                        <li data-lan="EN"><button class="btn btn-default btn-cons m-b-20" type="button">English</button></li>
                        <li data-lan="CS"><button class="btn btn-default btn-cons m-b-20" type="button">Čeština</button></li>                     
                        <li data-lan="RU"><button class="btn btn-default btn-cons m-b-20" type="button">Русский</button></li>
                    </ul>
                    
                    
                    </div>
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>




<?php /*?><div class="content">
    <div class="row" id="inbox-wrapper">
    <div class="col-md-12">
    <div class=""><h2 class=" inline"><?=__("Personal Account")?></h2></div>
    </div>
    </div>        
    <div class="row">
    
    <div class="col-md-12">
        <p><?=$info;?></p>
        <div class="row">
            <div class="tiles white col-md-12  no-padding">			
                <div class="tiles-body">
                    <h3 class="semi-bold"><?=__("Avatar")?></h3>
                    <form enctype="multipart/form-data" action="" method="post">
                     <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
                     Загружаемый файл: <input type="file" name="file">
                     <br />
                     <button class="btn btn-danger"><?=__('Upload')?></button>
                    </form>
    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="friend-list">
                                <div class="clearfix"></div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>	
    </div><?php */?>
    
    

    
    
    </div>
</div>

  <script type="text/javascript">
 $('.cha_bt').click(function(){
    if($('.new_pass').val().length == 0 || $('.rep_pass').val().length == 0){
        modal_info_open('<h3><?=__("The password must contain at least one uppercase letter and one numeric character")?></h3>');
        return false;
    }
    if($('.new_pass').val() != $('.rep_pass').val()){
        modal_info_open('<h3><?=__("The passwords you entered do not match each other")?></h3>');
        return false;
    }
    modal_info_open('<h1><?=__("Your password have been changed")?></h1>');
    modal_info_close('/sysuser/profil');
}) 
  
  
$('.poplang-content li').click(function(){
    //alert($(this).find('img').data('lan'));
    //exit;
    
        
     $.ajax({
        type: "POST",
        url: "/chang_lang",
        data: {lang: $(this).data('lan')},
        async: false,
        success: function(data) {
            //alert(data);
            //location="/tiket/sell";
            //if(data == Full){
            
             //   HTMLL.addClass('ui-state-active');
            //}
            modal_info_open('<h1><?=__("You have chosen a language")?></h1>');
            modal_info_close('/sysuser/profil');    
            //setTimeout(location="/tiket/search_tiks",10000);
            
            
        },
        error:function(){
            alert('ошибка tran_tik');
        }
    });     
        
    
        
        
})
  
  </script>