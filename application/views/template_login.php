<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang);// echo $lang; 
 if(isset($_GET['lang'])){
    I18n::lang($_GET['lang']);
    $lang = $_GET['lang'];
 }

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title></title>
    <!-- Bootstrap core CSS -->
    <link href="<?=Kohana::$base_url;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=Kohana::$base_url;?>assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?=Kohana::$base_url;?>assets/css/normalize.css" rel="stylesheet">
    <link href="<?=Kohana::$base_url;?>assets/css/non-responsive.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?=Kohana::$base_url;?>assets/css//ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?=Kohana::$base_url;?>assets/styles.css" rel="stylesheet">
    <link href="<?=Kohana::$base_url;?>assets/theme.css" rel="stylesheet">
    <link href="<?=Kohana::$base_url;?>assets/design.css" rel="stylesheet">
    <!-- Font Icon -->
    <link href="<?=Kohana::$base_url;?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="error-body no-top lazy"  data-original="assets/img/work.jpg"  style="background-image: url('assets/img/work.jpg')"> 

<!-- modal info --!>
<button type="submit" data-toggle="modal" data-target="#info_modal" class="btm-edit btn btn-success info_modal" style="font-family: Open Sans; font-weight:600;  margin-left: 30px; margin-top: 18px; display: none; "><i class="fa fa-print"></i>&nbsp;<?=__("Sell ticket")?></button>
                                            
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


<input type="hidden" class="cur_lan" value="<?=$lang;?>" />
<div class="container">

<div class="col-md-6">




    <div class="login-wrapper ">
    
    
    
    
    
      <!-- START Login Right Container-->
      <div class="login-container bg-white p-b-50">
      
          <div class="col-md-12 p-l-50 m-l-20 p-r-50 m-r-20 p-t-10 p-b-20 m-t-30 sm-p-l-15 sm-p-r-15">
    
    
    <a class="btn btn-default btn-cons" href="/disp/login?lang=en" >English</a>
    
    <a class="btn btn-default btn-cons" href="/disp/login?lang=ru" >Русский</a>
    
    
    </div>
      
      
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="<?=Kohana::$base_url;?>img/logosvitgo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" >
          <p class="p-t-35"><?=__('Sign into your account')?></p>
          <!-- START Login Form -->
      
      

      
      
      
      
      
         
          
                <form id="frm_login form-login " class="login-formm animated fadeIn p-t-15" method="post">   
          
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label><?=__('Login')?></label>
              <div class="controls">
               <input name="admin_login" id="login_username" type="text"  class="form-control txtusername design-input-login" placeholder="<?=__('Login')?>">
            
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label><?=__('Password')?></label>
              <div class="controls">
              
                    <input name="admin_pass" id="txtpassword" type="password"  class="form-control design-input-login"  placeholder="<?=__('Password')?>" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding">
                <div class="checkbox ">
                  <input type="checkbox" value="1" id="checkbox1">
                  <label for="checkbox1"><?=__('Keep Me Signed in')?></label>
                </div>
              </div>
              <div class="col-md-6 text-right">
              
              </div>
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit"><?=__('Sign in')?></button>
          </form>
          <!--END Login Form-->

        </div>
      </div>
      <!-- END Login Right Container-->
      
      
      
    </div>
    
    </div>
    
    
   <div class="col-md-6">
   

<div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title">
                    <?=__('Support')?>
                    </div>
                  </div>
                  <div class="panel-body">
                    <h5>
						    <?=__('Contact Support')?>
						</h5>
                    <form action="/disp/add_support" method="post" class="support_form">
                    <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label> <?=__('First Name')?></label>
                   
                        <input type="text" name="supp_name" required="" class="form-control">
                      </div>
                      
                      </div>
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label> <?=__('Last Name')?></label>
                 
                        <input type="text" name="supp_soname" required="" class="form-control">
                      </div>
                      </div>
                      
                      </div>
              
                    <input type="hidden" name="lang" value="<?=$lang;?>" />
          
                        <div class="row">
                    <div class="col-sm-6">
               <div class="form-group">
                        <label><?=__('Email')?></label>
                  
                        <input type="email" name="supp_email" required="" placeholder="ex: some@example.com" class="form-control">
                      </div>
                      
                      </div>
                      <div class="col-sm-6">
              <div class="form-group">
                        <label><?=__('Phone')?></label>
                  
                        <input type="text" required="" name="supp_phone" placeholder="ex: +380 97 07 07 332" class="form-control">
                      </div>
                      </div>
                      
                      </div>
          
          
          
          
                         <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label> <?=__('Login')?></label>
                   
                        <input type="text" required="" name="supp_login" class="form-control">
                      </div>
                      
                      </div>
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label> <?=__('Password')?></label>
                 
                        <input type="text" required="" name="supp_pass" class="form-control">
                      </div>
                      </div>
                      
                      </div>
          
          
             <button class="btn btn-success btn-cons m-t-10 subb_button" type="submit"><?=__('Request')?></button>
          
          
          
                    </form>
                  </div>
                </div>


   </div>	
    
    

    
    </div>
<!-- END CONTAINER -->    
    <!-- START OVERLAY -->
    <div class="overlay hide" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="overlay-content has-results m-t-20">
        <!-- BEGIN Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Logo !-->
          <img class="overlay-brand" src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
          <!-- END Overlay Logo !-->
          <!-- BEGIN Overlay Close !-->
          <a href="#" class="close-icon-light overlay-close text-black fs-16">
            <i class="pg-close"></i>
          </a>
          <!-- END Overlay Close !-->
        </div>
        <!-- END Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Controls !-->
          <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
          <br>
          <div class="inline-block">
            <div class="checkbox right">
              <input id="checkboxn" type="checkbox" value="1" checked="checked">
              <label for="checkboxn"><i class="fa fa-search"></i> Search within page</label>
            </div>
          </div>
          <div class="inline-block m-l-10">
            <p class="fs-13">Press enter to search</p>
          </div>
          <!-- END Overlay Controls !-->
        </div>
        <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
        <div class="container-fluid">
          <span>
                <strong>suggestions :</strong>
            </span>
          <span id="overlay-suggestions"></span>
          <br>
          <div class="search-results m-t-40">
            <p class="bold">Pages Search Results</p>
            <div class="row">
              <div class="col-md-6">
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div>
                      <img width="50" height="50" src="assets/img/profiles/avatar.jpg" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on pages</h5>
                    <p class="hint-text">via john smith</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div>T</div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> related topics</h5>
                    <p class="hint-text">via pages</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div><i class="fa fa-headphones large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> music</h5>
                    <p class="hint-text">via pagesmix</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
              </div>
              <div class="col-md-6">
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-info text-white inline m-t-10">
                    <div><i class="fa fa-facebook large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on facebook</h5>
                    <p class="hint-text">via facebook</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-complete text-white inline m-t-10">
                    <div><i class="fa fa-twitter large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5">Tweats on<span class="semi-bold result-name"> ice cream</span></h5>
                    <p class="hint-text">via twitter</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular text-white bg-danger inline m-t-10">
                    <div><i class="fa fa-google-plus large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5">Circles on<span class="semi-bold result-name"> ice cream</span></h5>
                    <p class="hint-text">via google plus</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
              </div>
            </div>
          </div>
        </div>
        <!-- END Overlay Search Results !-->
      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->

<!-- BEGIN CORE TEMPLATE JS -->
<script src="<?=Kohana::$base_url;?>assets/js/bootstrap.min.js"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/plugins/jquery-lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="<?=Kohana::$base_url;?>assets/js/login_v2.js" type="text/javascript"></script>

<script type="text/javascript">
$('#login_toggle').click(function(){
		$('#frm_login').show();
		$('#frm_register').hide();
	})
$('#register_toggle').click(function(){
	$('#frm_login').hide();
	$('#frm_register').show();
})
$('.closes').click(function(){
    $(this).parents('.forget_block').hide();
})
///*
$('.reset').click(function(){
    var emeil = $('.em').val();
    $.ajax({
        type: "POST",
        url: "/disp/reset_pass",
        data: {email:emeil},
        success: function(data) {
            //alert(data);
            //location="/roz/add_route_step_3?id=";
            $('.infofo').text(data);
        },
        error:function(){
            alert('error reset password!');
        }
   });
})
//*/
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


$('.culture li').click(function(){
    //alert($(this).data('lan'));
    //exit;
    $.ajax({
        type: "POST",
        url: "/chang_lang",
        data: { lang: $(this).data('lan'),text: $(this).text() }
    }).success(function() {
        location='/';
    }).error(function(){
        alert('error');
    });
})



function get_name_browser(){
    // получаем данные userAgent
    var ua = navigator.userAgent;    
    // с помощью регулярок проверяем наличие текста,
    // соответствующие тому или иному браузеру
    if (ua.search(/Chrome/) > 0) return 'Google Chrome';
    if (ua.search(/Firefox/) > 0) return 'Firefox';
    if (ua.search(/Opera/) > 0) return 'Opera';
    if (ua.search(/Safari/) > 0) return 'Safari';
    if (ua.search(/MSIE/) > 0) return 'Internet Explorer';
    // условий может быть и больше.
    // сейчас сделаны проверки только 
    // для популярных браузеров
    return 'Не определен';
}
 
// пример использования
var browser = get_name_browser();
if(browser == 'Firefox'){
    //$('.login-container').html('<h1 style="text-align:center;">Please download other browser: Google Chrome, Opera, Safari</h1>');
    //alert('Please download other browser');
    //exit;
}

$(document).ready(function(){
    var CurLan = $('.cur_lan').val();
    $('.culture li').each(function(){
        if($(this).data('lan') == CurLan){
            $('.cur_text').text($(this).text());
        }
    })
    //alert(CurLan);
})
$('.support_form').submit(function(){
    var chekk = 0;
    $(this).find('input').each(function(){
        //alert($(this).val());
        if($(this).val().length < 2){
            chekk++;
        }
    })
    if(chekk != 0){
        modal_info_open('<?=__("Validation error")?>');
        return false;
    }
    //alert(chekk);
    
})
function modal_info_open(textt){
    $('.info_body').html(textt);
    $('.info_modal').click();
}
</script>

</body>
</html>