


<div class="admin-login-block">


<div class="admin_login">
     <div class="logo-admin"><img src="<?php echo Kohana::$base_url;?>img/logo.png" width="180" height="38" alt="logo" /></div>

<p class="title-login"><? echo __('Добро пожаловать,  в панель администратора');?>:</p>
<div class="admin-login">
  
  <form id="admin_login_form" action="" method="post" >
     <div class="fild-login-a">
        <label>
        <div class="font-loginadmin"><? echo __('Логин');?>:</div>
            <input name="admin_login" type="text" class="fild-login" />
        </label>
        </div>
        <br />
        <label>
         <div class="fild-pass">
        <div class="font-loginadmin"><? echo __('Пароль');?>:</div>
            <input name="admin_pass" type="password" class="fild-login" />
        </label>
         </div>
       <div class="btm-admin">
        <input id="admin_login_submit" class="btm-edit" type="submit" value="<? echo __('Вход в систему');?>"/ >  
    </div>
    </form>
</div>

</div>
                  </div>