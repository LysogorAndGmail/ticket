<nav class="navbar navbar-inverse navbar-fixed-top">
    <?$sesuser = Session::instance()->get('ses_user');//print_r($sesuser);
    if(!isset($sesuser[0])){
        $all_user_menus = '1,2,3,4,5,6,7,8';
    }else{
        $user_group = DB::select()->from('groups')->where('id','=',$sesuser[0]['group_id'])->execute()->current();
        $all_user_menus = $user_group['menus'];
    }
    $all_user_menus = explode(',',$all_user_menus); 
    ?>
      <div class="container">
       <!-- <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"></a>
        </div>-->
        <div id="navbar" >
          <ul class="nav navbar-nav">
            <?foreach($all_user_menus as $menus){ if($menus == 1){ ?>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=__("Tickets")?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/tiket/sell"><?=__("Sale of tickets")?></a></li>
                        <li><a href="/tiket/search_tiks"><?=__("Find tickets")?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/sysuser/clients"><?=__("Show the list of passengers")?></a></li>
                       
                    </ul>
                </li>
            <?}}?>
            <?foreach($all_user_menus as $menus){ if($menus == 2){ ?>
                <li><a href="/tiket"><?=__("Сash desk")?></a></li>
            <?}}?>
            <?foreach($all_user_menus as $menus){ if($menus == 3){ ?>
                <li><a href="/tiket/vedomost"><?=__("Сheck list")?></a></li>
            <?}}?>
            <?foreach($all_user_menus as $menus){ if($menus == 4){ ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=__("Settings")?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="/sysuser/routes_priorety"><?=__("Sale settings")?></a></li>
                     <li><a href="/buses/add_blocket_plase"><?=__("Block places")?></a></li>
                    <li><a href="/groups"><?=__("List of groups")?></a></li>
                    <li><a href="/sysuser"><?=__("List of agents")?></a></li>
                    <li><a href="/discounts"><?=__("List of discounts")?></a></li>
                    </ul>
                </li>
            <?}}?>
            <?foreach($all_user_menus as $menus){ if($menus == 5){ ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=__("Content")?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="/svitgo/my_city"><?=__("Destinations")?></a></li>
                    <li><a href="/svitgo/my_post"><?=__("Article manager")?></a></li>
                    </ul>
                </li>
            <?}}?>
            <?foreach($all_user_menus as $menus){ if($menus == 6){ ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=__("Components")?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="/sysuser/support"><?=__("Support")?></a></li>
                </ul>
            </li>
            <?}}?>
            
               <?foreach($all_user_menus as $menus){ if($menus == 7){ ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=__("History")?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="/buses/blocket_plase_history"><?=__("Seats")?></a></li>
                </ul>
            </li>
            <?}}?>
            
            
            
          </ul>
          
        
          
     
          
          
          
          <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                    <? $ses =  Session::instance()->get('ses_user');?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span style="color: #fff;"><? if(isset($ses[0])){ echo $ses[0]['first_name'].' '.$ses[0]['last_name'];}else{ echo'SuperAdmin';}?></span><span class="caret"></span></a>
              <ul class="dropdown-menu profile-dropdown">

                <li><a href="/sysuser/profil"><?=__("User profile")?></a></li>
                  <li class=" bg-master-lighter"><a class="clearfix" href="/disp/log_out">
                    <span class="pull-left"><?=__("Logout")?></span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a></li>
              </ul>
            </li>
          </ul>
          
        </div><!--/.nav-collapse -->
        
        
      </div>
    </nav>

<input type="hidden" id="cur_lan" value="<?=I18n::lang();?>" />
    <input type="hidden" id="find_lan" value="<?//=Loc::get_loc();?>" />
    <input type="hidden" id="base_cur" value="<? if(!empty($_SERVER['REQUEST_URI'])){ echo $_SERVER['REQUEST_URI'];  }else {echo '/';}?>" />    
    
    
    
    

<!-- modal info --!>
<button type="submit" data-toggle="modal" data-target="#info_modal" class="btm-edit btn btn-success info_modal" style="font-family: Open Sans; font-weight:600;  margin-left: 30px; margin-top: 18px; display: none;"><i class="fa fa-print"></i>&nbsp;<?=__("Sell ticket")?></button>
                                            
<div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content tab-content">
        <div class="modal-header">
          <button type="button" class="close info_close" data-dismiss="modal" aria-hidden="true">×</button>
          <br />
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-12 info_body">
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal"><?=__("Confirm")?></button>
        </div>
      </div>
    </div>
</div>

<!--end  modal info --!>

<script type="text/javascript">

function modal_info_open(textt){
    $('.info_body').html(textt);
    $('.info_modal').click();
}
function modal_info_close(locate){
    $('.info_close').click(function(){
        location=""+locate+"";
    })
}

$('.language').click(function(e){
    e.stopPropagation();
    var Len_BL = $('.main-language-panel');
    if(Len_BL.css('display') == 'none'){
        Len_BL.show();
    }
    else {
        Len_BL.hide();
    }
})
$('.poplang-content li').click(function(){
    //alert($(this).find('img').data('lan'));
    //exit;
    $.ajax({
      type: "POST",
      url: "/chang_lang",
      data: { lang: $(this).data('lan') }
            }).success(function() {
                location=''+$('#base_cur').val();
            }).error(function(){
                alert('error');
        });
})
$('.top-reload').click(function(){
    location=''+$('#base_cur').val();
})

</script>         