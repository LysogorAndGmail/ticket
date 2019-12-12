<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sysuser extends Controller_Disp {
    
    public function before() {
        parent::before();
        $this->chek_admin_enter(); 
    } 
               
	public function action_index() {  
        $ses_user = $this->ses_user;
        $this->chek_permition();
        $data = array();
        if($ses_user['group_id'] != 1){
            //$all_par_groups = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();
            //if(!empty($all_par_groups)){
                $data['sysusers'] = DB::select()->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            //}else{
                //$data['sysusers'] = DB::select()->from('system_users')->where('group_id','=',$ses_user['group_id'])->execute()->as_array();
            //}
            //print_r($all_par_groups); 
            //print_r($ses_user); 
            //die;   
        }else{
            $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();
        }    
        //$this->template->left_sidebar_admin = View::factory('sysuser/left');
        $this->template->content_admin = View::factory('sysuser/index',$data);
	}
    
   	public function action_see_all() {  
        $ses_user = $this->ses_user;
        $this->chek_permition();   
        $data = array();
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array();    
        //$this->template->left_sidebar_admin = View::factory('sysuser/left');
        $this->template->content_admin = View::factory('sysuser/see_all',$data);
	}
    
    public function action_add() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        //print_r($ses_user);
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $data = array();
        if($_POST){
            
            //print_r($_POST);
            //die;
            
            if(isset($ses_user[0]['id'])){
                $sus_id = $ses_user[0]['id'];
            }else{
                $sus_id = 1;
            }
            
            
            $img_name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            move_uploaded_file($temp, "img/sys_user_photo/".$img_name);
            
            $sysuser_id = DB::insert('system_users',array(
                'login',
                'activ',
                'email',
                'first_name',
                'last_name',
                'tel',
                'adress',
                'pass',
                'date_create',
                'procent',
                'city',
                'group_id',
                'photo',
                'parent_sysuser',
                'default_valute',
                'time_zone',
                'company',
                'id_company',
                'vat',
                'company_adress',
                'bank',
                'skype',
                'phone_kod',
                'default_lang',
                'adres_bank',
                'iban',
                'swift',
                'see_main_menu'
            ))->values(array(
                $_POST['login'],
                $_POST['activ'],
                $_POST['email'],
                $_POST['f_name'],
                $_POST['l_name'],
                $_POST['tel'],
                $_POST['adress'],
                $_POST['pass'],
                $_POST['date_create'],
                $_POST['procent'],
                $_POST['city'],
                $_POST['group'],
                $img_name,
                $sus_id,
                'EUR',
                $_POST['zone'],
                $_POST['company'],
                $_POST['id_company'],
                $_POST['vat'],
                $_POST['company_adress'],
                $_POST['bank'],
                $_POST['skype'],
                $_POST['phone_kod'],
                $_POST['default_lang'],
                $_POST['adres_bank'],
                $_POST['iban'],
                $_POST['swift'],
                $_POST['see_main_menu']
            ))->execute();
            
            if(!empty($_POST['valute'])){
                foreach($_POST['valute'] as $val){
                    DB::insert('system_users_valutes',array(
                        'sysuser_id',
                        'valute',
                    ))->values(array(
                        $sysuser_id[0],
                        $val,
                    ))->execute();
                }
            }
            
            if(!empty($_POST['langs'])){
                foreach($_POST['langs'] as $val){
                    DB::insert('system_users_langs',array(
                        'sysuser_id',
                        'lang',
                    ))->values(array(
                        $sysuser_id[0],
                        $val,
                    ))->execute();
                }
            }
            
            if(!empty($_POST['ferrymans'])){
                foreach($_POST['ferrymans'] as $val){
                    DB::insert('system_users_ferryman',array(
                        'sys_id',
                        'fer_id',
                    ))->values(array(
                        $sysuser_id[0],
                        $val,
                    ))->execute();
                }
            }
            
            if(!empty($_POST['routes'])){
                foreach($_POST['routes'] as $rou){
                    DB::insert('system_users_routes',array(
                        'sysuser_id',
                        'route_name_id',
                    ))->values(array(
                        $sysuser_id[0],
                        $rou,
                    ))->execute();
                }
            }
            //die;
            if(isset($_POST['send_mail'])){    
                if($_POST['send_mail']){
                $this->send_user_mail($_POST['email'],$_POST['login'],$_POST['pass'],$lang);        
                }
            }
            $this->redirect("/sysuser");
        }
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();
            //print_r($data['groups']);
            $all_rou = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $new_r = array();
            foreach($all_rou as $r){
                $new_r[] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->and_where('routename.route_name_id','=',$r['route_name_id'])
            ->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            $data['routes'] = $new_r;
            $data['valutes'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['langs'] = DB::select()->from('language')->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
            $data['routes'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
            $data['valutes'] = DB::select()->from('country')->execute()->as_array();
            $data['langs'] = DB::select()->from('language')->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array(); 
            //echo '<pre>';
            //print_r($data['ferrymans']);
            //echo '</pre>';
            //die;
        } 
        //print_r($data['routes']);
        //die;
        //$this->template->left_sidebar_admin = View::factory('sysuser/left',$data);
        
        $this->template->content_admin = View::factory('sysuser/add',$data);
    }
    
     public function action_edit(){
        $this->chek_permition();
        $ses_user = $this->ses_user;
        //print_r($ses_user);
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data = array();
        if(isset($ses_user[0]['id'])){
            $all_disc = DB::select()->from('tickerdiscount')
            ->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('ferryman_id','ASC')->execute()->as_array();
        }else{
            $all_disc = DB::select()->from('tickerdiscount')
            //->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('ferryman_id','ASC')->execute()->as_array();
        }
        
        
        $data['discounts'] = $all_disc;
        if($_POST){
            /////////////////////
            $return_discount = 0;
            if(isset($_POST['return_discount'])){
                $return_discount = 1;
            }
            //echo '<pre>';
            //print_r($_POST);
            ///echo '</pre>';
            //die;
            DB::update('system_users')->set(array(
                'login'=>$_POST['login'],
                'activ'=>$_POST['activ'],
                'email'=>$_POST['email'],
                'first_name'=>$_POST['f_name'],
                'last_name'=>$_POST['l_name'],
                'tel'=>$_POST['tel'],
                'adress'=>$_POST['adress'],
                'procent'=>$_POST['procent'],
                'city'=>$_POST['city'],
                'group_id'=>$_POST['group'],
                'default_valute'=>$_POST['default_valute'],
                'time_zone'=>$_POST['zone'],
                'company'=>$_POST['company'],
                'id_company'=>$_POST['id_company'],
                'vat'=>$_POST['vat'],
                'company_adress'=>$_POST['company_adress'],
                'bank'=>$_POST['bank'],
                'skype'=>$_POST['skype'],
                'phone_kod'=>$_POST['phone_kod'],
                'default_lang'=>$_POST['default_lang'],
                'return_discount'=>$return_discount,
                'adres_bank'=>$_POST['adres_bank'],
                'iban'=>$_POST['iban'],
                'swift'=>$_POST['swift'],
                'see_main_menu'=>$_POST['see_main_menu'],
                ))->where('id','=',$_POST['id'])->execute();
            
           DB::delete('system_users_valutes')->where('sysuser_id','=',$_POST['id'])->execute();
            
            if(!empty($_POST['valute'])){
                foreach($_POST['valute'] as $val){
                    DB::insert('system_users_valutes',array(
                        'sysuser_id',
                        'valute',
                    ))->values(array(
                        $_POST['id'],
                        $val,
                    ))->execute();
                }
            }
            
            DB::delete('system_users_langs')->where('sysuser_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['langs'])){
                foreach($_POST['langs'] as $rou){
                    DB::insert('system_users_langs',array(
                        'sysuser_id',
                        'lang',
                    ))->values(array(
                        $_POST['id'],
                        $rou,
                    ))->execute();
                }
            }
            
            
            
            
            DB::delete('system_users_ferryman')->where('sys_id','=',$_POST['id'])->execute();
            
            if(!empty($_POST['ferrymans'])){
                foreach($_POST['ferrymans'] as $val){
                    DB::insert('system_users_ferryman',array(
                        'sys_id',
                        'fer_id',
                    ))->values(array(
                        $_POST['id'],
                        $val,
                    ))->execute();
                }
            }
            
            DB::delete('system_users_routes')->where('sysuser_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['routes'])){
                foreach($_POST['routes'] as $rou){
                    DB::insert('system_users_routes',array(
                        'sysuser_id',
                        'route_name_id',
                    ))->values(array(
                        $_POST['id'],
                        $rou,
                    ))->execute();
                }
            }
            
            
            DB::delete('system_users_scheme')->where('sysuser_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['schemes'])){
                foreach($_POST['schemes'] as $rou){
                    DB::insert('system_users_scheme',array(
                        'sysuser_id',
                        'chema',
                    ))->values(array(
                        $_POST['id'],
                        $rou,
                    ))->execute();
                }
            }
            
            DB::delete('system_users_see_cassa')->where('user_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['see_cassa'])){
                foreach($_POST['see_cassa'] as $rou){
                    DB::insert('system_users_see_cassa',array(
                        'user_id',
                        'route_name_id',
                    ))->values(array(
                        $_POST['id'],
                        $rou,
                    ))->execute();
                }
            }
            
            DB::delete('system_users_edit_routes')->where('user_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['edit_route'])){
                foreach($_POST['edit_route'] as $rou){
                    DB::insert('system_users_edit_routes',array(
                        'user_id',
                        'route_name_id',
                    ))->values(array(
                        $_POST['id'],
                        $rou,
                    ))->execute();
                }
            }
            
            DB::delete('system_users_discounts')->where('sys_id','=',$_POST['id'])->execute();
            
            
            if(!empty($_POST['discounts'])){
                foreach($_POST['discounts'] as $dis){
                    DB::insert('system_users_discounts',array(
                        'sys_id',
                        'dis_id',
                    ))->values(array(
                        $_POST['id'],
                        $dis,
                    ))->execute();
                }
            }
            
            
            //die;
            $this->redirect("/sysuser");
            
            
            ////////////////////
        }
        $data['edit_sys'] = DB::select()->from('system_users')->where('id','=',$_GET['id'])->execute()->current();
        $data['edit_fer'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$_GET['id'])->execute()->as_array();
        //echo '<pre>';
        //print_r($data['edit_fer']);
        //echo '</pre>';
        $data['edit_rou'] = DB::select()->from('system_users_routes')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        $data['edit_see'] = DB::select()->from('system_users_see_cassa')->where('user_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_route'] = DB::select()->from('system_users_edit_routes')->where('user_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_value'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_scheme'] = DB::select()->from('system_users_scheme')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_discounts'] = DB::select()->from('system_users_discounts')->where('sys_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_langs'] = DB::select()->from('system_users_langs')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        
        $data['edit_menus'] = DB::select()->from('system_users_menus')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();
            $all_rou = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $new_r = array();
            foreach($all_rou as $r){
                $new_r[] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->and_where('routename.route_name_id','=',$r['route_name_id'])
            ->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            $data['routes'] = $new_r;
            $data['valutes'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$_GET['id'])->execute()->as_array();
            
            
            $all_schema = DB::select()->from('system_users_scheme')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $new_all = array();
            foreach($all_schema as $all){
                        $new_all[$all['chema']] = $all;
                    }
            $data['schemes'] = $new_all; 
            $data['langs'] = DB::select()->from('language')->execute()->as_array();
            
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
            $new_all = array(); 
            $all_schema = DB::select()->from('bscheme')->order_by('schema_id','ASC')->execute()->as_array();
            if(!empty($all_schema)){  foreach($all_schema as $all){
                        $new_all[$all['schema_name']] = $all;
                    }
            }
            $data['schemes'] = $new_all; 
            //echo '<pre>';
            //print_r($new_all);
            //echo '</pre>';
            //die;
            $data['routes'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
            $data['valutes'] = DB::select()->from('country')->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
            $data['langs'] = DB::select()->from('language')->execute()->as_array();
        }
        
        $this->template->content_admin = View::factory('sysuser/edit',$data);
    }
    
    
    public function action_dell(){
        if($_GET){
            DB::delete('system_users')->where('id','=',$_GET['id'])->execute();
            DB::delete('system_users_routes')->where('sysuser_id','=',$_GET['id'])->execute();
            DB::delete('system_users_valutes')->where('sysuser_id','=',$_GET['id'])->execute();
            $this->redirect("/sysuser");
        }
    }
    
    public function action_profil(){
        $data = array();
        
        $ses_user = $this->ses_user;
        
        $info = '';
        
        if($_POST){
            
                if (empty($_FILES['file']['name'])){
                    echo 'empty fild';
                    die;
                }
            
                $pic_weight = 3000;
                $pic_height = 3000;
          
                //директория загрузки
                $uploaddir = 'img/sys_user_photo/';
                //новое имя изображения
                $apend=date('YmdHis').$_FILES['file']['name'];
                //путь к новому изображению
                $uploadfile = "$uploaddir$apend";
                
                //print_r($_FILES);
                if($_FILES['file']['error'] > 0){
                 //в зависимости от номера ошибки выводим соответствующее сообщение
                 //UPLOAD_MAX_FILE_SIZE - значение установленное в php.ini
                 //MAX_FILE_SIZE значение указанное в html-форме загрузки файла
                 switch ($_FILES['file']['error'])
                 {
                 case 1: $info = "Размер файла превышает допустимое значение UPLOAD_MAX_FILE_SIZE"; break;
                 case 2: $info = "Размер файла превышает допустимое значение MAX_FILE_SIZE"; break;
                 case 3: $info = "Не удалось загрузить часть файла"; break;
                 case 4: $info = "Файл не был загружен"; break;
                 case 6: $info = "Отсутствует временная папка."; break;
                 case 7: $info = "Не удалось записать файл на диск."; break;
                 case 8: $info = "PHP-расширение остановило загрузку файла."; break;
                 }
                 exit;
                }
                //die;
                //Проверка расширений загружаемых изображений
                if($_FILES['file']['type'] == "image/gif" || $_FILES['file']['type'] == "image/png" ||
                $_FILES['file']['type'] == "image/jpg" || $_FILES['file']['type'] == "image/jpeg"){
                    //черный список типов файлов
                    $blacklist = array(".php", ".phtml", ".php3", ".php4");
                    foreach ($blacklist as $item){
                        if(preg_match("/$item\$/i", $_FILES['file']['name'])){
                            $info = "Нельзя загружать скрипты.";
                            exit;
                        }
                    }
                    
                    //перемещаем файл из временного хранилища
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){
                        //получаем размеры файла
                        $size = getimagesize($uploadfile);
                        //проверяем размеры файла, если они нам подходят, то оставляем файл
                        if ($size[0] < $pic_weight && $size[1] < $pic_height){
                            //.....код
                            //я обычно заношу пути к изображениям в бд
                            //.....код
                            
                            $info = "<center><br>Файл ($uploadfile) загружен.</center>";

                            DB::update('system_users')->set(array(
                            'photo'=>$apend,
                            ))->where('id','=',$ses_user[0]['id'])->execute();
                            
                        }
                        //если размеры файла нам не подходят, то удаляем файл unlink($uploadfile);
                        else {
                            $info = "<center><br>Размер пикселей превышает допустимые нормы.</center>";
                            unlink($uploadfile);
                        }
                        
                        
                    }
                    else{
                        $info = "<center><br>Файл не загружен, вернитесь и попробуйте еще раз.</center>";
                    }
                    
                }
                else{
                    $info = "<center><br>Можно загружать только изображения в форматах jpg, jpeg, gif и png.</center>";
                }
                
           

    
        }
        $data['info'] = $info;
        
        $this->template->content_admin = View::factory('sysuser/profil',$data);
    }
    
    public function action_routes_priorety(){
        $data = array();
        //$this->chek_permition();
        $ses_user = $this->ses_user;
        //print_r($ses_user);
        $data['sysuser'] = $ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        if($ses_user['group_id'] != 1){
            
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();
            $new_r = array();
            $all_user = DB::select()->from('system_users_routes')
                ->join('routename')->on('system_users_routes.route_name_id','=','routename.route_name_id')
                ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                ->and_where('culture','=',$lang)
                ->and_where('is_public','=',1)
                ->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            
            foreach($all_user as $r){              
                
                $rev = DB::select('reverse_id')->from('route_reverse')->where('main_id','=',$r['route_name_id'])->execute()->current();
                $r['reverse_id'] = $rev['reverse_id'];
                $new_r[] = $r;
 
            }
            
            $ff = array();
            
            foreach($new_r as $nn){
                if(!empty($nn['reverse_id'])){
                    $ff[] = $nn;
                }
            }
            $data['routes'] = $ff;
            
            $data['valutes'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();   
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
            $data['routes'] = DB::select()->from('routename')
            ->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            //->join('route_reverse','LEFT')->on('routename.route_name_id','=','route_reverse.main_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
            $data['valutes'] = DB::select()->from('country')->execute()->as_array();
            $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('sysuser/priorety',$data);
    }
    
    public function action_save_priorety(){
        if($_POST){
            
            //echo '<pre>';
            $rev_rou = DB::select()->from('route_reverse')->where('main_id','=',$_POST['priory_route'])->or_where('reverse_id','=',$_POST['priory_route'])->execute()->current();
            //print_r($_POST);
            //echo '</pre>';
            //die;
            $ses_user = $this->ses_user;
            
            $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$ses_user[0]['id'])->where('route','=',$_POST['priory_route'])->execute()->current();
            if(empty($chek_pri)){
                $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$ses_user[0]['id'])->where('route','=',$rev_rou['reverse_id'])->execute()->current();
            }
            
            //print_r($ses_user);
            //print_r($chek_pri);
            //die;
            
            if(!empty($chek_pri)){
                /////////////
                //$rev_rou = DB::select()->from('route_reverse')->where('main_id','=',$_POST['priory_route'])->or_where('reverse_id','=',$_POST['priory_route'])->execute()->current();
                    //if($rev_rou['main_id'] == $_POST['priory_route']){
                    //    $slave_route = $rev_rou['reverse_id'];
                    //}else{
                    //    $slave_route = $rev_rou['main_id'];
                    //}
                
                DB::delete('system_users_priorety')->where('id','=',$chek_pri['id'])->execute();
                
                DB::insert('system_users_priorety',array(
                    'sysuser_id',
                    'route',
                    'slave_route',
                    'main_city_id',
                    'slave_city_id'
                ))->values(array(
                    $ses_user[0]['id'],
                    $_POST['priory_route'],
                    $rev_rou['reverse_id'],
                    $_POST['prior_city'],
                    $_POST['slave_city']
                ))->execute();
             //}
                
              
            }else{
            //$rev_rou = DB::select()->from('route_reverse')->where('main_id','=',$_POST['priory_route'])->or_where('reverse_id','=',$_POST['priory_route'])->execute()->current();
            //if($rev_rou['main_id'] == $_POST['priory_route']){
            //    $slave_route = $rev_rou['reverse_id'];
            //}else{
            //    $slave_route = $rev_rou['main_id'];
            //}
            DB::insert('system_users_priorety',array(
                    'sysuser_id',
                    'route',
                    'slave_route',
                    'main_city_id',
                    'slave_city_id'
                ))->values(array(
                    $ses_user[0]['id'],
                    $_POST['priory_route'],
                    $rev_rou['reverse_id'],
                    $_POST['prior_city'],
                    $_POST['slave_city']
                ))->execute();
            }
            //    echo 'ok';
            //print_r($_POST);
            die;
        }
    }
    
    function password_genaration($max){
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
        $size=StrLen($chars)-1; 
        $password=null; 
        while($max--) {
            $password.=$chars[rand(0,$size)]; 
        }
        return $password;
    }
    
    
    public function action_ajax_pass_generate(){
        if($_POST){
            $pass = $this->password_genaration(8);
            echo $pass;
            die;
        }
    }
    
    public function send_user_mail($to,$user_login,$user_pass,$lang) {
    
    $config = Kohana::$config->load('email');
    Email::connect($config);
    //if($lang == 'en'){
        $subject = 'Registration disp.svitgo.com';
    //}
    $from = 'noreply@svitgo.com';
    $data['pass'] = $user_pass;
    $data['login'] = $user_login;
    $data['group'] = 'Regabus';
    $data['lang'] = $lang;
    $message = View::factory('sysuser/email_mess',$data);
    //$message = "login - ".$user_login." pass - ".$user_pass;
    Email::send($to, $from, $subject, $message, $html = true);
    
    }
    
    public function action_ajax_update_cleent() {  
        if($_POST){
            $ses_user = $this->ses_user;
            $chek_client_sesuser = Model::factory('TiketMod')->showphone_for_tel($_POST['id'],$ses_user[0]['id']);
            if($chek_client_sesuser != 1){
                DB::update('ticket_people')->set(array(
                'name'=>$_POST['name'],
                'soname'=>$_POST['soname'],
                'tel2'=>$_POST['phone2'],
                'date'=>$_POST['date'],
                ))->where('id','=',$_POST['id'])->execute();
            }else{
                DB::update('ticket_people')->set(array(
                'name'=>$_POST['name'],
                'soname'=>$_POST['soname'],
                'tel'=>$_POST['phone'],
                'tel2'=>$_POST['phone2'],
                'date'=>$_POST['date'],
                ))->where('id','=',$_POST['id'])->execute();
            }
            
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            echo 'ok';
            die;
        }
	}
    
    public function action_blacklist(){
        $data = array();
        if($_POST){
            DB::insert('system_users_blacklist',array(
                'tel',
            ))->values(array(
                $_POST['tel'],
            ))->execute();
            $this->redirect('/sysuser/blacklist');
        }
        $data['all'] = DB::select()->from('system_users_blacklist')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/blacklist',$data);
    }
    
    public function action_clients(){
        $data = array();
        $ses_user = $this->ses_user;
        if(isset($ses_user[0]['id'])){
            
            ///////////////////////////////
            
            $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses_user[0]['id']);
            
            if(count($children_arr_a) == 1){ // нет детей видет только свои билеты
                $al_tik = DB::select(array('client_id','id'),'name','soname','count_trip','tel','ticket_people.date','old_tickets')->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')->where('user_id','=',$ses_user[0]['id'])->execute()->as_array();
                $new = array();
                foreach($al_tik as $tik){
                    $new[$tik['name'].$tik['soname']] = $tik;
                }
                $al_create = DB::select()->from('ticket_people')->where('sysuser_create_id','=',$ses_user[0]['id'])->execute()->as_array();
                $new2 = array();
                foreach($al_create as $old_tik){
                    $new2[$old_tik['name'].$old_tik['soname']] = $old_tik;
                }
                $newnew = $new2 + $new;
                $data['all'] = $newnew;

            }else{
                $al_tik = DB::select(array('client_id','id'),'name','soname','count_trip','tel','ticket_people.date','old_tickets')->from('ticket')->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')->where('user_id','in',$children_arr_a)->execute()->as_array();
                $new = array();
                foreach($al_tik as $tik){
                    $new[$tik['name'].$tik['soname']] = $tik;
                }
                $al_create = DB::select()->from('ticket_people')->where('sysuser_create_id','=',$ses_user[0]['id'])->execute()->as_array();
                $new2 = array();
                foreach($al_create as $old_tik){
                    $new2[$old_tik['name'].$old_tik['soname']] = $old_tik;
                }
                $newnew = $new2 + $new;
                $data['all'] = $newnew;
            }
            

            
            
            
            
            
            ////////////////////////////////
            
            
        }else{
            $data['all'] = DB::select()->from('ticket_people')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('sysuser/clients',$data);
    }
    
    
     public function action_see_clints_tiks() {  
        $ses_user = $this->ses_user; 
        $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
        $data = array();
        $data['lang'] = $lang;
        if($_GET){
             $children_arr = array();
            $children_arr_a = array();
            $children_arr = DB::select('id')->from('system_users')->where('parent_sysuser','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($children_arr)){
                foreach($children_arr as $ch){
                    $children_arr_a[] = $ch['id'];
                }
            }
            array_push($children_arr_a,$ses_user[0]['id']);
            $client_id = $_GET['id'];
            $clients = DB::select()->from('ticket')
                ->join('ticketreport')->on('ticket.ticket_id','=','ticketreport.ticket_id')
                ->join('ticket_valute')->on('ticket.ticket_id','=','ticket_valute.tiket_id')
                ->join('ticket_people')->on('ticket.client_id','=','ticket_people.id')
                ->where('client_id','=',$client_id)->and_where('user_id','in',$children_arr_a)->execute()->as_array();
            $data['tikets'] = $clients; 
        }
        $this->template->content_admin = View::factory('sysuser/see_clients_tiks',$data);
	}
    
    public function action_edit_client(){
        $data = array();
        if($_POST){
            DB::update('ticket_people')->set(array(
            'name'=>$_POST['name'],
            'soname'=>$_POST['soname'],
            'tel'=>$_POST['phone'],
            'date'=>$_POST['date'],
            ))->where('id','=',$_POST['id'])->execute();
            $this->redirect('/sysuser/clients');
        }
        $data['edit'] = DB::select()->from('ticket_people')->where('id','=',$_GET['id'])->execute()->current();
        $this->template->content_admin = View::factory('sysuser/edit_clients',$data);
    }
    public function action_add_client(){
        $data = array();
        $ses_user = $this->ses_user;
        if($_POST){ 
            
            $count_of_trip = 0;
            if(!empty($_POST['old_ticks'])){
               $all = explode(',',$_POST['old_ticks']);
               $count_of_trip = count($all);
            }
            DB::insert('ticket_people',array(
                'name',
                'soname',
                'date',
                'tel',
                'sysuser_create_id',
                'old_tickets',
                'count_trip'
            ))->values(array(
                $_POST['name'],
                $_POST['soname'],
                $_POST['date'],
                $_POST['phone'],
                $ses_user[0]['id'],
                $_POST['old_ticks'],
                $count_of_trip
            ))->execute();
            $this->redirect('/sysuser/clients');
        }
        $this->template->content_admin = View::factory('sysuser/add_clients',$data);
    }
    
    public function action_enter_client(){
        $data = array();
        if($_POST){ 
            Session::instance()->delete('ses_user');
            $chek_sysusers = DB::select()->from('system_users')->where('id','=',$_POST['id'])->execute()->current();
            $ses_user = array('login'=>$chek_sysusers['login'],'type'=>2,'group_id'=>$chek_sysusers['group_id'],$chek_sysusers);
            Session::instance()->set('ses_user',$ses_user);
            $this->redirect('/');
        }
        $this->template->content_admin = View::factory('sysuser/enter_clients',$data);
    }
    
    public function action_del_client(){
        if($_GET){
            //DB::delete('ticket_people')->where('id','=',$_GET['id'])->execute();
            $this->redirect("/sysuser/clients");
        }
    }
    
    public function action_statistik(){
        $data = array();
        $data['all_auto'] = DB::select()->from('ticket_auto_anule')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/statistik',$data);
    }
    
    public function action_select_main_route(){
        $data = array();
        $this->template->content_admin = View::factory('sysuser/select_main_route',$data);
    }
    
    public function action_save_priorety_route(){
        
            //echo '<pre>';
            $ses_user = $this->ses_user;
            $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$ses_user[0]['id'])->where('route','=',$_POST['master'])->execute()->current();
            if(empty($chek_pri)){
                $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$ses_user[0]['id'])->where('route','=',$_POST['slave'])->execute()->current();
            }
            if(empty($chek_pri)){
                DB::insert('system_users_priorety',array(
                    'sysuser_id',
                    'route',
                    'slave_route',
                ))->values(array(
                    $ses_user[0]['id'],
                    $_POST['master'],
                    $_POST['slave']
                ))->execute();
            }else{
                DB::delete('system_users_priorety')->where('id','=',$chek_pri['id'])->execute();
                
                DB::insert('system_users_priorety',array(
                    'sysuser_id',
                    'route',
                    'slave_route',
                ))->values(array(
                    $ses_user[0]['id'],
                    $_POST['master'],
                    $_POST['slave']
                ))->execute();
            }
            
            die;
    }
    
    public function action_select_main_city(){
        $data = array();
        $this->template->content_admin = View::factory('sysuser/select_main_city',$data);
    }
    
    public function action_save_priorety_city(){
        
            
            
            $ses_user = $this->ses_user;
            $chek_pri = DB::select()->from('system_users_priorety')->and_where('sysuser_id','=',$ses_user[0]['id'])->where('route','=',$_POST['route'])->execute()->current();
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            //    DB::delete('system_users_priorety')->where('id','=',$chek_pri['id'])->execute();
            DB::update('system_users_priorety')->set(array(
            'main_city_id'=>$_POST['master'],
            ))->where('id','=',$chek_pri['id'])->execute();
            
            die;
    }
    
    
    public function action_api_keys(){
        $ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        $data = array();
        $data['keys'] = DB::select()->from('api_keys')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/api_keys',$data);
    }
    
    public function action_add_api_key(){
        $ses_user = $this->ses_user;
        if($_POST){
            DB::insert('api_keys',array(
                'company',
                'group_id',
                'sysuser_id',
                'key'
            ))->values(array(
                $_POST['company'],
                $_POST['group'],
                $_POST['sysuser'],
                md5($_POST['company'].$_POST['group'])
            ))->execute();
            //print_r($_POST);
            //die;
        }
        //print_r($ses_user);
        //die;
        $data = array();
        $data['keys'] = DB::select()->from('api_keys')->execute()->as_array();
        $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array(); 
        $this->template->content_admin = View::factory('sysuser/add_api_key',$data);
    }
    
    public function action_edit_api_key(){
        $ses_user = $this->ses_user;
        if($_POST){
            
            DB::update('api_keys')->set(array(
                'company'=>$_POST['company'],
                'group_id'=>$_POST['group'],
                'sysuser_id'=>$_POST['sysuser'],
                'see_plase'=>$_POST['see_plase'],
            ))->where('id','=',$_GET['id'])->execute();
            
            $this->redirect('/sysuser/api_keys');
            //print_r($_POST);
            //die;
        }
        //print_r($ses_user);
        //die;
        $data = array();
        $data['edit'] = DB::select()->from('api_keys')->where('id','=',$_GET['id'])->execute()->current();
        $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        $data['sysusers'] = DB::select()->from('system_users')->execute()->as_array(); 
        $this->template->content_admin = View::factory('sysuser/edit_api_key',$data);
    }
    
    public function action_delete_api_key(){
        $ses_user = $this->ses_user;
        if($_GET){
            
            DB::delete('api_keys')->where('id','=',$_GET['id'])->execute();
            
            $this->redirect('/sysuser/api_keys');
            //print_r($_POST);
            //die;
        }
    }
    
    public function action_join_routes(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        $data = array();
        $data['keys'] = DB::select()->from('regabus_join_routes')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/join_routes',$data);
    }
    
    
    public function action_add_join_route_ost(){
        if($_POST){
            $id = DB::insert('regabus_join_osts',array(
                    'svitgo_ost_id',
                    'reg_ost_id',
                    'join_route'
                ))->values(array(
                    $_POST['svitgo_ost'],
                    $_POST['join_ost'],
                    $_POST['join_route']
                ))->execute();
            die;
        }
    }
    
    public function action_dell_join_route_ost(){
        if($_POST){
            DB::delete('regabus_join_osts')->where('id','=',$_POST['id'])->execute();
            die;
        }
    }
    
    
    
    public function action_see_join_route(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        $data = array();
        $join_route = DB::select()->from('regabus_join_routes')->where('svitgo_route_name_id','=',$_GET['join_id'])->execute()->current();
        $data['join_route'] = $join_route['reg_route_id'];
        $data['all_ost'] = DB::select()->from('route')->where('route.route_name_id','=',$_GET['join_id'])->order_by('weight')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/see_join_route',$data);
    }
    
    public function action_see_all_join_osts(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        $data = array();
        $array = DB::select()->from('regabus_join_osts')->execute()->as_array();
         
        $data['keys'] = $array;

        $this->template->content_admin = View::factory('sysuser/see_all_join_osts',$data);
    }
    
    public function action_see_all_join_osts_regabus(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        $data = array();
        $array = DB::select()->from('regabus_osts')->execute()->as_array();
         
        $data['keys'] = $array;

        $this->template->content_admin = View::factory('sysuser/see_all_join_osts_regabus',$data);
    }
    
    public function action_del_reg_join() {
        $id = $_GET['reg_ost_id'];
        DB::delete('regabus_join_osts')->where('reg_ost_id','=',$id)->execute();
        $this->redirect('/sysuser/see_join_route?join_id='.$_GET['join_id']);
    }
    
    public function action_del_join_ost() {
        $id = $_GET['reg_ost_id'];
        DB::delete('regabus_join_osts')->where('id','=',$id)->execute();
        $this->redirect('/sysuser/see_join_route?join_id='.$_GET['join_id']);
    }
    
    public function action_join_reg_ost(){
        if($_POST){
            
            $chek = DB::select()->from('regabus_join_osts')->where('reg_ost_id','=',$_POST['reg_id'])->execute()->current();
            
            //print_r($_POST);
            //die;
            if(!empty($chek)){
                DB::update('regabus_join_osts')->set(array(
                'svitgo_ost_id'=>$_POST['svitgo_id'],
                ))->where('reg_ost_id','=',$_POST['reg_id'])->execute();
            }else{
                $id = DB::insert('regabus_join_osts',array(
                    'svitgo_ost_id',
                    'reg_ost_id'
                ))->values(array(
                    $_POST['svitgo_id'],
                    $_POST['reg_id']
                ))->execute();
            }
            
            
            
            
            //
            //
            die;
        }
    }
    
    public function action_auto_new_POST() {
        if($_POST) {      
            echo '<script>
            $(".aj_ost").click(function(){
                $(this).parents("td").find(".inputString_to").val($(this).text());
                $(this).parents("td").find(".ajax_ost_id").val($(this).data("id"));
                $(this).parents("td").find(".ajax").html("");
                
            })
            </script>';
            
             //
             if(strlen($_POST['val']) > 1){
                
            $param =  $this->uperr($_POST['val']);
            $lang = $_POST['lang'];
            $limit = 18;

            $res = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE city_i18n REGEXP '^$param' AND culture = '$lang' ORDER BY city_i18n LIMIT $limit")->execute()->as_array();
            $serch = array();
            $al_ci = array();
            foreach($res as $r){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                //array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>'city'));       
            }
            
            //echo '<pre>';
           //         print_r($_POST);
           //         echo '</pre>';
           //     die;
            ///*
            $res_vil = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE village REGEXP '^$param' AND culture = '$lang' ORDER BY village LIMIT $limit")->execute()->as_array();
            foreach($res_vil as $r_vil){
                
                array_push($serch, array('name'=>$r_vil['name_i18n'],'city'=>$r_vil['village'],'id'=>$r_vil['route_city_id'],'type'=>'village'));               
            }
            //*/
            if(!empty($serch)){
                echo '<ul>';
                foreach($serch as $s){
                    echo '<li class="aj_ost" data-id="'.$s['id'].'">'.$s['id'].' '.$s['name']." ".$s['city'].'</li>';
                   
                }
                //
                echo '</ul>';
                die;
            }
            }
             
        }
        die;
    }  
    
    public function uperr($word) {
        
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');

    }
    
    public function action_add_join_ost(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        if($_POST){
            //print_r($_POST);
            //die;               
                
                $id = DB::insert('regabus_osts',array(
                    'reg_name',
                    'reg_ost_id',
                    'join_route',
                    'weight'
                ))->values(array(
                    $_POST['join_name'],
                    $_POST['join_id'],
                    $_POST['join_route'],
                    $_POST['weight']
                ))->execute();
                
                $this->redirect('/sysuser/see_join_route?join_id='.$_POST['join_route']);
                
            
        }
        $data = array();
        $data['join_id'] = $_GET['id'];
        //$data['keys'] = DB::select()->from('regabus_osts')->where('join_route','=',$_GET['join_id'])->order_by('weight')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/add_join_ost',$data);
    }
    
    public function action_edit_join_ost(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        if($_POST){
            //print_r($_POST);
            //die;
            DB::update('regabus_osts')->set(array(
                'reg_name'=>$_POST['join_name'],
                'reg_ost_id'=>$_POST['join_id'],
                'weight'=>$_POST['weight'],
                ))->where('id','=',$_GET['id'])->execute();
                
                $this->redirect('/sysuser/see_join_route?join_id='.$_POST['join_route']);
                
            
        }
        $data = array();
        $data['edit'] = DB::select()->from('regabus_osts')->where('id','=',$_GET['id'])->execute()->current();
        $this->template->content_admin = View::factory('sysuser/edit_join_ost',$data);
    }
    
    public function action_edit_old_join_ost(){
        //$ses_user = $this->ses_user;
        //print_r($ses_user);
        //die;
        if($_POST){
            //print_r($_POST);
            //die;
            DB::update('regabus_osts')->set(array(
                'join_route'=>$_POST['route'],
                'reg_name'=>$_POST['join_name'],
                'reg_ost_id'=>$_POST['join_id'],
                'weight'=>$_POST['weight'],
                ))->where('id','=',$_GET['id'])->execute();
                
                $this->redirect('/sysuser/all_orl_osts');
                
            
        }
        $data = array();
        $data['edit'] = DB::select()->from('regabus_osts')->where('id','=',$_GET['id'])->execute()->current();
        $data['routes'] = DB::select()->from('regabus_join_routes')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/edit_old_join_ost',$data);
    }
    
    public function action_all_orl_osts(){
        $data = array();
        $data['all'] = DB::select()->from('regabus_osts')->where('join_route','=','')->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/all_old_osts',$data);
    }
    
    public function action_search_route(){
        $data = array();
        //$date = array_reverse(explode('/', $_GET['date']));
        //$tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
        $this->template->content_admin = View::factory('search_route/search_route',$data);
    }
    
    public function action_auto_new_search_route() {
        if($_POST) {      
            echo '<script>
            $(".aj_ost").click(function(){
                $(this).parents(".one_search").find(".search_osts").val($(this).text());
                $(this).parents(".one_search").find(".ajax_ost_id").val($(this).data("id"));
                $(this).parents(".one_search").find(".ajax").html("");                
            })
            </script>';
            
             //
             if(strlen($_POST['val']) > 1){
                
            $param =  $this->uperr($_POST['val']);
            $lang = $_POST['lang'];
            $limit = 18;
            $_POST['search_type'] = array(1,2,3);
             
           /*

            $res = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE city_i18n REGEXP '^$param' AND culture = '$lang' ORDER BY city_i18n LIMIT $limit")->execute()->as_array();
            $serch = array();
            $al_ci = array();
            foreach($res as $r){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                //array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>'city'));       
            }
            
            //
            ///*
            $res_vil = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE village REGEXP '^$param' AND culture = '$lang' ORDER BY village LIMIT $limit")->execute()->as_array();
            foreach($res_vil as $r_vil){
                
                array_push($serch, array('name'=>$r_vil['name_i18n'],'city'=>$r_vil['village'],'id'=>$r_vil['route_city_id'],'type'=>'village'));               
            }
            //*/
            
            $res = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE city_i18n REGEXP '^$param' AND culture = '$lang' ORDER BY city_i18n LIMIT $limit")->execute()->as_array();
            $serch = array();
            $al_ci = array();
            foreach($res as $r){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                //array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                $al_ci[$r['city_i18n']] = $r['city_i18n'];              
            }
            $i = 0; foreach($al_ci as $ci){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                $al_t = 'все остановки,';
                if($lang == 'EN'){
                    $al_t = 'All stations,';
                }
                if($lang == 'CS'){
                    $al_t = 'Všechny zastávky,';
                }
                if($lang == 'UA'){
                    $al_t = 'Всі зупинки,';
                }
                array_push($serch, array('name'=>$al_t,'city'=>$ci,'id'=>$ci,'type'=>'city'));               
            $i++;}
            
            foreach($res as $r){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                //$al_ci[$r['city_i18n']] = $r['city_i18n'];              
            }
            $res_name = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE name_i18n REGEXP '^$param' AND culture = '$lang'  ORDER BY name_i18n LIMIT $limit")->execute()->as_array();
            foreach($res_name as $r_name){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r_name['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r_name['name_i18n'],'city'=>$r_name['city_i18n'],'id'=>$r_name['route_city_id'],'type'=>$all_types['type_id']));               
            }
            $res_vil = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE village REGEXP '^$param' AND culture = '$lang' ORDER BY village LIMIT $limit")->execute()->as_array();
            foreach($res_vil as $r_vil){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r_vil['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'EN'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r_vil['name_i18n'],'city'=>$r_vil['village'],'id'=>$r_vil['route_city_id'],'type'=>$all_types['type_id']));               
            }
            //
            
            //print_r($serch);
            //die;
            
            if(!empty($serch)){
                echo '<div class="bg-auto-in"><ul class="select2-results select2-results-svitgo">';
                foreach($serch as $s){
                    //print_r($s);
                    //die;
                    //if(!empty($s['route_city_id'])){
                        echo '<li class="aj_ost select2-results-dept-0 ost-auto" data-id="'.$s['id'].'">'.$s['name']." ".$s['city'].'</li>';
                    //}else{
                    //    echo '<li class="aj_ost" data-id="'.$s['route_city_id'].'">'.$s['name_i18n']." ".$s['city_i18n'].'</li>';
                    //}
                    
                   
                }
                //
                echo '</ul></div>';
                die;
            }
            
            }
            die; 
        }
        
    } 
    
    public function action_ajax_search_route(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            $data = array();
            
            $from = $_POST['from'];
            $to = $_POST['to'];
            
            $return_from = '';
            $return_to = '';
            
            $lang = array($_POST['lang']);
            //echo $to;
            $return_open = $_POST['return_open'];
            $city = 1;
            $city_to = 1;
            
            if($_POST['return_ch'] == 1){
                $return_from = $_POST['return_from'];
                $return_to = $_POST['return_to'];
            }
            
            
            
            switch($lang[0]){
                case 'RU': 
                
                $cg = strpos($from,'все');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                
                $cg_to = strpos($to,'все');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
              
                break;
                case 'UA':
                $cg = strpos($from,'Всі');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Всі');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'EN':
                $cg = strpos($from,'All');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'All');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'CS':
                $cg = strpos($from,'Všechny');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Všechny');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
            }
            
           
            
            $new_ar = array();
            if($city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                
              
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_from[1])->and_where('name_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_from[1])->and_where('name_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar[] = $rr;
            }
            
            
            
            if($city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_to[1])->and_where('name_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_to[1])->and_where('name_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar_to[] = $rr;
            }
            
            
             
            /// обратка
            if(!empty($return_to) && !empty($return_from)){
            
            $return_city = 1;
            $return_city_to = 1;
            
            switch($lang[0]){
                case 'RU': 
                
                $cg = strpos($return_from,'все');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                
                $cg_to = strpos($return_to,'все');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
              
                break;
                case 'UA':
                $cg = strpos($return_from,'Всі');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Всі');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'EN':
                $cg = strpos($return_from,'All');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'All');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'CS':
                $cg = strpos($return_from,'Všechny');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Všechny');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
            }
            
            
            $return_new_ar = array();
            if($return_city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_from[1])->and_where('name_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_from[1])->and_where('name_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar[] = $rr;
            }
            
            
            $return_new_ar_to = array();
            if($return_city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_to[1])->and_where('name_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_to[1])->and_where('name_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar_to[] = $rr;
            }
            
            }
            
            
            ///  обратка
            
            //$valid_date = $this->intervalDate_new($sd);
            //$day_week = $valid_date.' '.$time;
            //$day_week = date("w",strtotime($day_week));
            
            
            
            //$chek_from = DB::select()->from('route')->where('route_city_id','=',$_POST['from'])->execute()->as_array();
            //$r_from = $chek_from['r_id'];
            //$chek_to = DB::select()->from('route')->where('route_city_id','=',$_POST['to'])->execute()->as_array();
            $date = array_reverse(explode('/', $_POST['date']));
            $tran_date = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            
            
            
            $n_d_full = $tran_date.' 00:00:01';
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }  
                
            
            
                $all_osts_routes = Model::factory('TiketMod')->get_all_routes_from_osts($new_ar,$new_ar_to);
                
             //    echo '<pre>';
              //print_r($all_osts_routes);
              //echo '</pre>';
              //die;
                
                $all_routes = array();
                foreach($all_osts_routes as $al_r_ost){
           
                    $al_route = Model::factory('TiketMod')->search_api_meny_osts($al_r_ost[0],$al_r_ost[1],$tran_date,$day_week,$lang[0],1);
                    //die;
                    if(!empty($al_route)){
                        $all_routes[] = $al_route;
                    }
                    
                }
                
               
              //  echo $all_routes[0]['from']['route_city_id'];
            $all_routes_new = array();
             for($i=0; $i<count($all_routes[0]); $i++){
                $all_routes_new[$i] = $all_routes[0][$i];
             }
                
                $all_routes = $all_routes_new;
                
                //echo count($all_routes[0]);
                
                
             // echo '<pre>';
             //  print_r($all_routes);
             //  echo '</pre>';
              // die; 
             //$all_routes = $this->search_api($new_ar,$new_ar_to,$tran_date,$day_week,$lang[0],1);  
             //$all_routes = Model::factory('TiketMod')->search_api_meny_osts($new_ar,$new_ar_to,$tran_date,$day_week,$lang[0],1);  
             
             
               
               
             
             //$all_routes = Model::factory('TiketMod')->search_all_route_new($new_ar,$new_ar_to,$tran_date,$day_week,1,$lang[0]);
             
          
             
            
            //foreach($all_routes as $arr) {
            //    $new['otpravka_sort'][] = $arr['otpravka_sort'];
            //}
            //if(!empty($new)){
            //    array_multisort($new['otpravka_sort'], constant('SORT_ASC'), $all_routes);
            //}
            
       
              
            //echo 'ok';    
            //die;
            
            
            $all_routes_return = array();    
            
                
                
             //echo '<pre>';
             //print_r($_POST['date_return']);
             //echo '</pre>';
             //die; 
            if($return_open == 1){
                $all_routes_return = Model::factory('TiketMod')->search_all_route_new_open($return_new_ar,$return_new_ar_to);
            }
            else{
                if(!empty($_POST['date_return'])){
                $date_return = array_reverse(explode('/', $_POST['date_return']));
                $tran_date_return = date('Y-m-d', mktime(0, 0, 0, $date_return[1], $date_return[2], $date_return[0]));
                
                $n_d_full_return = $tran_date_return.' 00:00:01';
                    $day_return = date('w',strtotime($n_d_full_return));    
                    switch($day_return){
                        case 0:
                        $day_week_return = 6;
                        break;
                        case 1:
                        $day_week_return = 0;
                        break;
                        case 2:
                        $day_week_return = 1;
                        break;
                        case 3:
                        $day_week_return = 2;
                        break;
                        case 4:
                        $day_week_return = 3;
                        break;
                        case 5:
                        $day_week_return = 4;
                        break;
                        case 6:
                        $day_week_return = 5;
                        break;
                    } 
                    $all_routes_return = Model::factory('TiketMod')->search_all_route_new($return_new_ar,$return_new_ar_to,$tran_date_return,$day_week_return,1,$lang[0]);
                     
                    foreach($all_routes_return as $arr) {
                        $neww['otpravka_sort'][] = $arr['otpravka_sort'];
                    }
                    if(!empty($neww['otpravka_sort'])){
                        array_multisort($neww['otpravka_sort'], constant('SORT_ASC'), $all_routes_return);
                    }
                }
                
            }
            
           
            
               
            
            
            
            /*
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die; 
            //*/
            //echo '<pre>';
            //print_r($all_routes);
            //echo '</pre>';
            //die;
             
            // 
              //  die;
            /*
            $new = array();
            foreach($chek_from as $all_from){
                foreach($chek_to as $all_to){
                    if($all_from['route_name_id'] == $all_to['route_name_id'] && $all_from['weight'] < $all_to['weight']){
                        $chek_day = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$all_from['route_name_id'])->and_where('date','=',$tran_date)->execute()->current();
                        $arive = DB::select('hours','a_hours')->from('routeweek')->where('route_name_id','=',$all_from['route_name_id'])->and_where('r_id','=',$all_from['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',1)->execute()->current();
                        $depart = DB::select('hours','a_hours')->from('routeweek')->where('route_name_id','=',$all_from['route_name_id'])->and_where('r_id','=',$all_to['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',1)->execute()->current();
                        if(!empty($chek_day)){
                            $new[] = array($all_from,$all_to,$chek_day,$arive,$depart);
                        }
                    }
                }
            }
            
            */
            
            
             $all_sys_routes = DB::select('route_name_id')->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            
            
            
            if($return_open == 1 || !empty($_POST['date_return'])){
                
                if(!empty($all_routes_return)){
                    $return_city_from = Model::factory('OstMod')->get_ost($all_routes_return[0]['from'][0],$lang[0]);
                    $return_city_to = Model::factory('OstMod')->get_ost($all_routes_return[0]['to'][0],$lang[0]);
                    
                    $data['return_from'] = $return_city_from['city_i18n'];
                    $data['return_to'] = $return_city_to['city_i18n'];
                    
                     
                    
                    $new_all_routes_return = array();
                    foreach($all_routes_return as $ar){
                        
                        foreach($all_sys_routes as $sys_routes){
                            if($ar['from']['route_name_id'] == $sys_routes['route_name_id']){
                                $new_all_routes_return[] = $ar;
                        
                            }
                        }    
                    }
                    
                    $all_routes_return = $new_all_routes_return;
                } 
            }         
            ///*
            //echo '<pre>';
            //print_r();
            //echo '</pre>';
            //die;
            //*/
            //die;
            if(!empty($all_routes)){
                $city_from = Model::factory('OstMod')->get_ost($all_routes[0]['from'][0],$lang[0]);
                $city_to = Model::factory('OstMod')->get_ost($all_routes[0]['to'][0],$lang[0]); 
                //die;
                ///*
                $new_all_routes = array();
                foreach($all_routes as $ar){
                    foreach($all_sys_routes as $sys_routes){
                        if($ar['from']['route_name_id'] == $sys_routes['route_name_id']){
                            $new_all_routes[] = $ar;
                        }
                    }    
                }
                //*/
                
                
                //$all_routes = $new_all_routes; 
                
                $new_all_routes = array();
                $curr_time = strtotime('now');
                foreach($all_routes as $ar){    
                    $start = strtotime($ar['from']['date'].' '.$ar['from']['time']);
                    if($curr_time < $start){
                        $new_all_routes[] = $ar;
                    }
                }
                
                $all_routes = $new_all_routes;
                
                $data['from'] = $city_from['city_i18n'];
                $data['to'] = $city_to['city_i18n'];
            }else{
                $data['from'] = '';
                $data['to'] = '';
            }
            
            
            //print_r($all_routes);
            
            $data['return_open'] = $return_open;
            $data['routes'] = $all_routes; 
            $data['routes_return'] = $all_routes_return;
            $data['date'] = $tran_date;
            $data['day_week'] = $day_week;
            
            
            
            
            
            echo View::factory('search_route/search_route_ajax_blocks',$data);
            
            
            
            die;
        }
    } 
    
    
    public function action_ajax_search_route_get_one_people_return(){
        if($_POST){
            $ses_user = $this->ses_user;
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['id'] = $_POST['id'];
            $data['plase'] = $_POST['plase'];
            $data['price'] = $_POST['price'];
            $data['valute'] = $_POST['valute'];
            $data['tel'] = $_POST['tel'];
            $data['name'] = $_POST['name'];
            $data['soname'] = $_POST['soname'];
            $data['date'] = $_POST['date'];
            $data['price_new'] = 100;
            $data['route_name_id'] = $_POST['route_name_id'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            //print_r($data);
            
            //echo $data['price_new'];
            echo View::factory('search_route/get_one_people_search_route_return',$data);
            die;
        }
    }
    
    public function action_ajax_search_route_open(){
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            
            
            $data = array();
            
            $from = $_POST['from'];
            $to = $_POST['to'];
            
            $return_from = $_POST['return_from'];
            $return_to = $_POST['return_to'];
            
            $lang = array($_POST['lang']);
            
            $date_return = $_POST['date_return'];
            
            
            $return_open = $_POST['return_open'];
            //echo $return_open;
            //die;
            //echo $to;
            
            $city = 1;
            $city_to = 1;
            
            switch($lang[0]){
                case 'RU': 
                
                $cg = strpos($from,'все');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                
                $cg_to = strpos($to,'все');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
              
                break;
                case 'UA':
                $cg = strpos($from,'Всі');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Всі');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'EN':
                $cg = strpos($from,'All');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'All');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
                case 'CS':
                $cg = strpos($from,'Všechny');
                $new_from = explode(',',$from);
                $new_from = array(trim($new_from[0]),trim($new_from[1]));
                if($cg === false){
                    $city = 0;
                }
                $cg_to = strpos($to,'Všechny');
                $new_to = explode(',',$to);
                $new_to = array(trim($new_to[0]),trim($new_to[1]));
                if($cg_to === false){
                    $city_to = 0;
                }
                break;
            }
            
            
            $new_ar = array();
            if($city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                
              
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_from[1])->and_where('name_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_from[1])->and_where('name_i18n','=',$new_from[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar[] = $rr;
            }
            
            
            
            if($city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$new_to[1])->and_where('name_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$new_to[1])->and_where('name_i18n','=',$new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $new_ar_to[] = $rr;
            }
            
             
            /// обратка
            if(!empty($return_to) && !empty($return_from)){
            
            $return_city = 1;
            $return_city_to = 1;
            
            switch($lang[0]){
                case 'RU': 
                
                $cg = strpos($return_from,'все');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                
                $cg_to = strpos($return_to,'все');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
              
                break;
                case 'UA':
                $cg = strpos($return_from,'Всі');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Всі');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'EN':
                $cg = strpos($return_from,'All');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'All');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
                case 'CS':
                $cg = strpos($return_from,'Všechny');
                $return_new_from = explode(',',$return_from);
                $return_new_from = array(trim($return_new_from[0]),trim($return_new_from[1]));
                if($cg === false){
                    $return_city = 0;
                }
                $cg_to = strpos($return_to,'Všechny');
                $return_new_to = explode(',',$return_to);
                $return_new_to = array(trim($return_new_to[0]),trim($return_new_to[1]));
                if($cg_to === false){
                    $return_city_to = 0;
                }
                break;
            }
            
            
            $return_new_ar = array();
            if($return_city == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar[] = $rr;                    
                }
                
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_from[1])->and_where('name_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->current(); 
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_from[1])->and_where('name_i18n','=',$return_new_from[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar[] = $rr;
            }
            
            
            $return_new_ar_to = array();
            if($return_city_to == 1) {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->as_array();
                foreach($res as $rr) {
                    $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$rr['route_city_id'])->execute()->as_array();
                    $return_new_ar_to[] = $rr;                    
                }
            }else {
                $res = DB::select('route_city_id')->from('routecity_i18n')->where('city_i18n','=',$return_new_to[1])->and_where('name_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                if(empty($res)){
                    $res = DB::select('route_city_id')->from('routecity_i18n')->where('village','=',$return_new_to[1])->and_where('name_i18n','=',$return_new_to[1])->and_where('culture','=',$lang[0])->execute()->current();
                }
                $rr['type'] = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$res['route_city_id'])->execute()->as_array();
                $rr['route_city_id'] = $res['route_city_id'];
                $return_new_ar_to[] = $rr;
            }
            
            }

           
 
                
             $all_routes = Model::factory('TiketMod')->search_all_route_new_open($new_ar,$new_ar_to);
             
             
             if($return_open == 1){
                $all_routes_return = Model::factory('TiketMod')->search_all_route_new_open($new_ar_to,$new_ar);
             }else{
                
                $date_return = array_reverse(explode('/', $_POST['date_return']));
                $tran_date_return = date('Y-m-d', mktime(0, 0, 0, $date_return[1], $date_return[2], $date_return[0]));

                $n_d_full_return = $tran_date_return.' 00:00:01';
                $day_return = date('w',strtotime($n_d_full_return));    
                switch($day_return){
                    case 0:
                    $day_week_return = 6;
                    break;
                    case 1:
                    $day_week_return = 0;
                    break;
                    case 2:
                    $day_week_return = 1;
                    break;
                    case 3:
                    $day_week_return = 2;
                    break;
                    case 4:
                    $day_week_return = 3;
                    break;
                    case 5:
                    $day_week_return = 4;
                    break;
                    case 6:
                    $day_week_return = 5;
                    break;
                }
                $data['date'] = $tran_date_return; 
                
                
                $all_routes_return = Model::factory('TiketMod')->search_all_route_new($return_new_ar,$return_new_ar_to,$tran_date_return,$day_week_return);
             }
             
             
            

            //foreach($all_routes as $arr) {
            //    $new['otpravka_sort'][] = $arr['otpravka_sort'];
            //}
            //if(!empty($new)){
            //    array_multisort($new['otpravka_sort'], constant('SORT_ASC'), $all_routes);
            //}

            
            
            
            //}
            
           
            
            $data['routes'] = $all_routes; 
            $data['routes_return'] = $all_routes_return;
            $data['date'] = '';//$tran_date;
            $data['day_week'] = '';//$day_week;
            $data['from'] = $from;
            $data['to'] = $to;
            $data['return_from'] = $return_from;
            $data['return_to'] = $return_to; 
            
            $data['return_open'] = $return_open;
            
            /*
            echo '<pre>';
            print_r($all_routes_return);
            echo '</pre>';
            die;
            */
            echo View::factory('search_route/search_route_ajax_blocks_open',$data);
            

            die;
        }
    } 
    
    
    
    
     public function action_ajax_get_one_people_no_search_route(){
        if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $ses_user = $this->ses_user;
            $data['plase'] = $_POST['plase'];
            
            $data['valute'] = $_POST['valute'];
            $data['route_name_id'] = $_POST['route_name_id'];
            //$price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
            $data['price'] = $_POST['price'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            //if($data['all_discount'] == 1 || $data['all_discount_hidden'] == 1){
            //    echo 'No carrier discounts!';
            //    die;
            //}
            echo View::factory('search_route/get_one_people_no_search_route',$data);
            die;
        }
    }
    
    
    public function action_ajax_get_one_people_return_search_route(){
        if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $ses_user = $this->ses_user;
            $data['id'] = $_POST['id'];
            $data['plase'] = $_POST['plase'];
            $data['price'] = $_POST['price'];
            $data['valute'] = $_POST['valute'];
            $data['tel'] = $_POST['tel'];
            $data['name'] = $_POST['name'];
            $data['soname'] = $_POST['soname'];
            $data['date'] = $_POST['date'];
            $data['all_discount'] = Model::factory('DiscountMod')->get_all_discount_ferryman($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            $data['all_discount_hidden'] = Model::factory('DiscountMod')->get_all_discount_ferryman_hidden($_POST['ferryman_id'],$lang,$ses_user[0]['id']);
            echo View::factory('search_route/get_one_people_search_route',$data);
            die;
        }
    }
    
    public function action_ajax_get_return_discount(){
        if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $ses_user = $this->ses_user;
            
            $data = array();
            $return_price = 10;
            
            //print_r($_POST);
            //die;
            /*
            /////////////////// chek group return prise
            $res_group_price = DB::select()->from('routeprice_group_return')
                    ->where('route_city_from_id','=',$_POST['from'])
                    ->and_where('route_name_id','=',$_POST['route'])
                    ->and_where('route_city_to_id','=',$_POST['to'])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['ferryman_id'])
                    ->and_where('group_id','=',$ses_user[0]['group_id'])
                    ->execute()->current();
            
            //print_r($res_group_price);
            //die;
            if(!empty($res_group_price['price'])){
                $return_price = $res_group_price['price'];
            }else{
            
                ////////////
                
                $res = DB::select()->from('routeprice_return_discount')
                        ->where('route_city_from_id','=',$_POST['from'])
                        ->and_where('route_name_id','=',$_POST['route'])
                        ->and_where('route_city_to_id','=',$_POST['to'])
                        ->and_where('valute','=',$_POST['valute'])
                        ->and_where('ferryman_id','=',$_POST['ferryman_id'])
                        ->execute()->current();
               
                if(!empty($res['price'])){
                    $return_price = $res['price'];
                }
            }
            */
            echo $return_price;
            die;
        }
    }
     
   	public function action_blocked_plase() {  
        $ses_user = $this->ses_user;
        //$this->chek_permition();  
        $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
        $data = array();
        $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$_GET['id'])->execute()->as_array();
        if(!empty($all_ses_fer)){
            $fer = DB::select('buses_id')->from('ferryman')->join('ferryman_buses')->on('ferryman.ferryman_id','=','ferryman_buses.fer_id')->where('ferryman.ferryman_id','in',$all_ses_fer)->execute()->as_array();
            $data['buses'] = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')
            ->where('buses.buses_id','in',$fer)
            ->where('culture','=',$lang)->execute()->as_array();
        }    
        $all_rou = DB::select()->from('system_users_routes')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
            $new_r = array();
            foreach($all_rou as $r){
                $new_r[] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->and_where('routename.route_name_id','=',$r['route_name_id'])
            ->order_by('routename.route_name_id','DESC')->execute()->current();
            }
        $data['routes'] = $new_r;
        //$this->template->left_sidebar_admin = View::factory('sysuser/left');
        $data['all_buses_base'] = DB::select()->from('sysuser_blocked_plases')->where('sysuser_id','=',$_GET['id'])->execute()->as_array();
        $this->template->content_admin = View::factory('sysuser/blocked_plase',$data);
	}
    
    
    public function action_ajax_save_blocked_plase(){
        if($_POST){
            
            DB::insert('sysuser_blocked_plases',array(
                'sysuser_id',
                'bus_id',
                'plases',
                'route_id'
            ))->values(array(
                $_POST['user'],
                $_POST['bus_id'],
                $_POST['plase'],
                $_POST['route']
            ))->execute();
            //print_r($_POST);
            die;
        }
    }
    
    public function action_del_blocked_plase(){
        if($_GET){
            
            DB::delete('sysuser_blocked_plases')
                ->where('sysuser_id','=',$_GET['sys_id'])
                ->and_where('bus_id','=',$_GET['bus_id'])
                ->and_where('route_id','=',$_GET['route_id'])
                ->execute();
            $this->redirect("/sysuser/blocked_plase?id=".$_GET['sys_id']);
        }
    }
    
    
    public function action_ajax_get_select_open(){
        if($_POST){
            $data = array();
            $data['route_name_id'] = $_POST['route_name_id'];
            $data['from'] = $_POST['from'];
            $data['to'] = $_POST['to'];
            echo View::factory('search_route/select_for_open',$data);
            die;
        }
    }
    
    public function action_ajax_get_one_people_open(){
                if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            } 
            $data = array();
            $data['plase'] = $_POST['plase'];
            $data['valute'] = $_POST['valute'];
            //print_r($_POST);
            //die;
            //$ferryman = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            
            $countrys = DB::select()->from('country')->where('valute','=',$data['valute'])->execute()->current();
//die;
    $price_ch = DB::select()->from('routeprice')
    //->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')
        ->where('route_name_id','=',$_POST['route_name_id'])
        ->and_where('route_city_from_id','=',$_POST['from'])
        ->and_where('route_city_to_id','=',$_POST['to'])
        ->and_where('valute','=',$_POST['valute'])
        ->execute()->current();
        
        if(empty($price_ch)){
            $price_ch = DB::select()->from('routeprice')
            //->join('routevalute')->on('routeprice.route_valute_id','=','routevalute.route_valute_id')
            ->where('route_name_id','=',$_POST['route_name_id'])
            ->and_where('route_city_from_id','=',$_POST['from'])
            ->and_where('route_city_to_id','=',$_POST['to'])
            //->and_where('valute','=',$_POST['valute'])
            ->execute()->current();
        }
            
         $valute = $price_ch['valute'];    
         $price = $price_ch['price'];
         
         
     
     if(!empty($price)){ 
            if($valute == 'ua'){
                $valute = 'UAH';
            }
            if($valute == 'cs'){
                $valute = 'CZK';
            }
            $new_price = Googlecon::con($valute,$_POST['valute'],$price);
            $valute = $new_price[1];
            $price = $new_price[0];
        }
            
            //$price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
          //  die;
            
            $data['price'] = $price;
            $data['valute'] = $valute;
            //$data['all_discount_hidden'] = array();
            //print_r($data['all_discount_hidden']);
            //die;
            //print_r($price_ch);
            //die;
            echo View::factory('search_route/get_one_people_open',$data);
            die;
        }
    }
    
     public function action_ajax_search_client(){
        if($_POST){
            
            echo "<script>
            $('.one_cl').click(function(){
                $('.search_client').val($(this).text());
                $('.search_client_id').val($(this).data('id'));
                $('.ajax_search_client').html('');
            })</script>";
            
            
            if(strlen($_POST['client']) >= 2){
                $clients = DB::select()->from('ticket_people')->where('soname','LIKE','%'.$_POST['client'].'%')->limit(20)->execute()->as_array();
                if(!empty($clients)){
                    echo '<ul>';
                    foreach($clients as $cl){
                        echo '<li class="one_cl" data-id="'.$cl['id'].'">'.$cl['name'].' '.$cl['soname'].'</li>';
                    }
                    echo '</ul>';
                }
            }
            
            
            //print_r($_POST);
            die;
        }
    }
    
    
   
    
    public function action_chen_pass(){
        if($_POST){
            $ses_user = $this->ses_user;
            DB::update('system_users')->set(array(
                'pass'=>$_POST['new_pass'],
                ))->where('id','=',$ses_user[0]['id'])->execute();
            //print_r($_POST);
            $this->redirect('/sysuser/profil');
            die;
        }
    }
    
    public function action_send_retry_order(){
        $data = array();
        $data['orders'] = array();
        $data['orders'] = DB::select(
        'join_ticket.id',
        'tikets',
        'join_ticket.status',
        'date',
        'valute',
        'lang',
        'pincod',
        'full_price',
        'sysuser_id',
        'pay_id',
        'users.user_id',
        'name',
        'soname',
        'email'      
        )->from('join_ticket')
        ->join('user_tiket')->on('join_ticket.id','=','user_tiket.join_tiket_id')
        ->join('users')->on('user_tiket.user_id','=','users.user_id')
        ->join('users_full')->on('users.user_id','=','users_full.user_id')
        ->order_by('join_ticket.id','DESC')->execute()->as_array();
    
        $this->template->content_admin = View::factory('sysuser/send_retry_order',$data);
    }
    
    public function action_ajax_send_retry_order(){
        if($_POST){
            
            Model::factory('Pdf')->sendmail_order_nikolo($_POST['id'],$_POST['email']);
        
            die;
        }
    }
   
    public function action_support(){
        $data = array();
        if(!isset($this->ses_user[0])){
            $data['all'] = DB::select()->from('support')->execute()->as_array();
            $this->template->content_admin = View::factory('support/support_list',$data);
        }else{
            $this->template->content_admin = '';
        }
        
    }
    
    
    public function action_dell_support(){
        DB::delete('support')->where('supp_id','=',$_GET['id'])->execute(); 
        $this->redirect('/sysuser/support');
    }
    
    
    
} // End Admin
