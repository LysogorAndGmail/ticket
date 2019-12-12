<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Svitgo extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_join_ticks() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['all'] = DB::select()->from('join_ticket')->order_by('id','DESC')->execute()->as_array();
        $this->template->content_admin = View::factory('svitgo/join_ticks',$data);
	}
    
    public function action_free_users() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['all'] = DB::select()->from('free_users')->order_by('id','DESC')->execute()->as_array();
        $this->template->content_admin = View::factory('svitgo/free_users',$data);
	}
    
    public function action_my_city() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        //if(!$lang) {
            $lang = 'en';
        //}
        $data = array();
        $data['lang'] = $lang;
        //print_r($ses_user);
        //if($ses_user['group_id'] == 1){
            
        //}
        $data['all'] = DB::select('my_city.id','my_city_i18n.name','my_city_i18n.title','my_city_i18n.meta','img','alt','css','country_id','culture')->from('my_city')->join('my_city_i18n')->on('my_city.id','=','my_city_i18n.my_city_id')->where('sys_user_id','=',$ses_user['group_id'])->order_by('my_city.id','DESC')->execute()->as_array();
        $this->template->content_admin = View::factory('my_city/index',$data);
	}
    
    public function action_add_my_city() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_city';
        //if(!$lang) {
        $lang = 'en';
        //}
        if($_POST){
            
            //echo '<pre>';
            //print_r($_SERVER);
            //echo '</pre>';
            //die;
            
            $lang = $_POST['lang'];
            
            $img_name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            
            $id = DB::insert('my_city',array(
                    'country_id',
                    'img',
                    'css',
                    'alt',
                    'sys_user_id'
                ))->values(array(
                    $_POST['country_id'],
                    $img_name,
                    $_POST['css'],
                    $_POST['alt'],
                    $ses_user['group_id']
                ))->execute();
                
                
                DB::insert('my_city_i18n',array(
                    'my_city_id',
                    'name',
                    'title',
                    'meta',
                    'text',
                    'culture',
                    'from_search',
                    'to_search',
                    'title_city',
                    'intro_text_city',
                    'city_link_title',
                    'city_link_url',
                    'title_browser',
                    'keywords'
                ))->values(array(
                    $id[0],
                    $_POST['name'],
                    $_POST['title'],
                    $_POST['meta_description'],
                    $_POST['text'],
                    $lang,
                    $_POST['from_search'],
                    $_POST['to_search'],
                    $_POST['title_city'],
                    $_POST['intro_text_city'],
                    $_POST['city_link_title'],
                    $_POST['city_link_url'],
                    $_POST['title_browser'],
                    $_POST['keywords']
                ))->execute();
                
                
                if(isset($_POST['route_citys'])){
                    foreach($_POST['route_citys'] as $ro){
                        DB::insert('my_city_osts',array(
                            'my_city_id',
                            'route_city_id',
                        ))->values(array(
                            $id[0],
                            $ro,
                        ))->execute();
                    }
                }
                
                mkdir($wey."/".$id[0], 0777);
                move_uploaded_file($temp, $wey."/".$id[0]."/1920_".$img_name);
                chmod($wey."/".$id[0]."/1920_".$img_name, 0755);
                
                $image = Image::factory($wey."/".$id[0]."/1920_".$img_name);
                $image->crop(1172, 480);
                $image->save($wey."/".$id[0]."/1172_".$img_name);
                chmod($wey."/".$id[0]."/1172_".$img_name, 0755);
                
                $image->crop(640, 300);
                $image->save($wey."/".$id[0]."/640_".$img_name);
                chmod($wey."/".$id[0]."/640_".$img_name, 0755);
                
                $this->redirect('/svitgo/my_city');          
        }
        $data = array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $this->template->content_admin = View::factory('my_city/add',$data);
	}
    
    public function action_edit_my_city() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $lang = $_GET['lang'];
        $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_city';
        if($_POST){            
            if(isset($_POST['fild_icon'])){
            $filds = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
            
            $i=0;foreach($filds as $one){
                DB::update('my_city_filds')->set(array(
                    'icon'=>$_POST['fild_icon'][$i],
                    'link'=>$_POST['fild_link'][$i], 
                ))->where('id','=',$one['id'])->execute();
                
                $chek_fild_lang = DB::select()->from('my_city_filds_i18n')->where('fild_id','=',$one['id'])->and_where('culture','=',$lang)->execute()->current();
                if(empty($chek_fild_lang)){
                    DB::insert('my_city_filds_i18n',array(
                        'fild_id',
                        'title',
                        'culture',
                    ))->values(array(
                        $one['id'],
                        $_POST['fild_title'][$i],
                        $lang,
                    ))->execute();
                }else{
                    DB::update('my_city_filds_i18n')->set(array(
                        'title'=>$_POST['fild_title'][$i],
                    ))->where('fild_id','=',$one['id'])->and_where('culture','=',$lang)->execute();
                }                
                
                 
                $i++;
            }
            }
            
           
             
            if(isset($_FILES['photo']['name'])){
                $img_name = $_FILES['photo']['name'];
                $temp = $_FILES['photo']['tmp_name'];
                $filename = $wey."/".$_GET['id'];
                if (file_exists($filename)) {
                $this->removeDirectory($wey."/".$_GET['id']);
                }
                mkdir($wey."/".$_GET['id'], 0777);
                move_uploaded_file($temp, $wey."/".$_GET['id']."/1920_".$img_name);
                chmod($wey."/".$_GET['id']."/1920_".$img_name, 0755);
                
                $image = Image::factory($wey."/".$_GET['id']."/1920_".$img_name);
                $image->crop(1172, 480);
                $image->save($wey."/".$_GET['id']."/1172_".$img_name);
                chmod($wey."/".$_GET['id']."/1172_".$img_name, 0755);
                
                $image->crop(640, 300);
                $image->save($wey."/".$_GET['id']."/640_".$img_name);
                chmod($wey."/".$_GET['id']."/640_".$img_name, 0755);
                
                
                DB::update('my_city')->set(array(
                    'country_id'=>$_POST['country_id'],
                    'img'=>$img_name,
                    'css'=>$_POST['css'],
                    'alt'=>$_POST['alt'],         
                ))->where('id','=',$_GET['id'])->execute(); 
            }else{
                DB::update('my_city')->set(array(
                    'country_id'=>$_POST['country_id'],
                    //'img'=>$img_name,
                    'css'=>$_POST['css'],
                    'alt'=>$_POST['alt'],        
                ))->where('id','=',$_GET['id'])->execute();
            }
            
             DB::update('my_city_i18n')->set(array(
                    'name'=>$_POST['name'],
                    'title'=>$_POST['title'], 
                    'meta'=>$_POST['meta_description'],   
                    'text'=>$_POST['text'],  
                    'title_city'=>$_POST['title_city'],
                    'intro_text_city'=>$_POST['intro_text_city'],
                    'city_link_title'=>$_POST['city_link_title'],
                    'city_link_url'=>$_POST['city_link_url'],
                    'title_browser'=>$_POST['title_browser'],
                    'keywords'=>$_POST['keywords']      
                ))->where('my_city_id','=',$_GET['id'])->and_where('culture','=',$lang)->execute();
            
            
            DB::delete('my_city_osts')->where('my_city_id','=',$_GET['id'])->execute();
            if(isset($_POST['route_citys'])){
                foreach($_POST['route_citys'] as $ro){
                    DB::insert('my_city_osts',array(
                        'my_city_id',
                        'route_city_id',
                    ))->values(array(
                        $_GET['id'],
                        $ro,
                    ))->execute();
                }
            }
            
        }
        //if(!$lang) {
        
        //}
        $data = array();
        $data['lang'] = $lang;
        $data['edit'] = DB::select()->from('my_city')->join('my_city_i18n')->on('my_city.id','=','my_city_i18n.my_city_id')->where('my_city.id','=',$_GET['id'])->and_where('culture','=',$lang)->execute()->current();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['route_citys'] = DB::select()->from('routecity_i18n')->where('city_i18n','LIKE','%'.$data['edit']['name'].'%')->and_where('culture','=',$lang)->execute()->as_array();
        $data['edit_route_citys'] = DB::select()->from('my_city_osts')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        $data['filds'] = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        $this->template->content_admin = View::factory('my_city/edit',$data);
	}
    
    public function action_dell_my_city() {  
        DB::delete('my_city')->where('id','=',$_GET['id'])->execute();
        DB::delete('my_city_osts')->where('my_city_id','=',$_GET['id'])->execute();
        $this->redirect('/svitgo/my_city');
	}
    
    public function action_ajax_dell_city_img(){
        if($_POST){
            $edit = DB::select()->from('my_city')->where('id','=',$_POST['id'])->execute()->current();
            $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_city';
            //$this->removeDirectory($wey."/".$_POST['id']);
            unlink($wey."/".$_POST['id']."/1920_".$edit['img']);
            unlink($wey."/".$_POST['id']."/1172_".$edit['img']);
            unlink($wey."/".$_POST['id']."/640_".$edit['img']);
            DB::update('my_city')->set(array(
            'img'=>''          
            ))->where('id','=',$_POST['id'])->execute(); 
            
            echo 'ok'; 
            die;
        }
    }
    
    public function action_ajax_join_my_city(){
        if($_POST){
            DB::insert('my_city_join',array(
                'my_city_id_parent',
                'my_city_id_child',
                'blok'
            ))->values(array(
                $_POST['id'],
                $_POST['child'],
                $_POST['block'],
            ))->execute();
            
            echo 'ok'; 
            die;
        }
    }
    
    public function action_ajax_dell_join_my_city(){
        if($_POST){
            
            DB::delete('my_city_join')->where('id','=',$_POST['id'])->execute();
            
            echo 'ok'; 
            die;
        }
    }
    
    public function action_ajax_add_filds(){
        if($_POST){
            $fild = DB::insert('my_city_filds',array(
                'my_city_id',
            ))->values(array(
                $_POST['id'],
            ))->execute();
            
            DB::insert('my_city_filds_i18n',array(
                'fild_id',
                'culture'
            ))->values(array(
                $fild[0],
                'en'
            ))->execute();
            echo 'ok'; 
            die;
        }
    }
    
    public function action_ajax_dell_filds(){
        if($_POST){
            
            DB::delete('my_city_filds')->where('id','=',$_POST['id'])->execute();
            echo 'ok'; 
            die;
        }
    }
    
    public function action_resize_img(){
        //$img = new Image();
        $data = array();
        //echo '<pre>';
        //print_r($_SERVER);
        //echo '</pre>';
        //die;
        
        // открываем папку
        //$dh = opendir("/var/www/vhosts/svitgo.com/httpdocs/img");
        //while($filename = readdir($dh))
        //{
        // любые операции с вашим файлом, например
        //$fs = filesize($filename);
        //$ft = filetype($filename);
        //echo "Имя: ".$filename."<br />";
        //}
        
        
        
        $wey = '/var/www/vhosts/svitgo.com.ua/img';
        
        $text = '';
        $image = Image::factory($wey.'/logosvitgo.png');
        
        //echo '<pre>';
        //print_r($image);
        //echo '</pre>';
        //die;
        
        $text .= 'Размер изображения: '.$image->width.'x'.$image->height.' px'."<br />";
        $image->crop(1172, 480);
        $image->save($wey.'/my_city/2.jpg');
        $text .= 'Размер изображения: '.$image->width.'x'.$image->height.' px'."<br />";
        //echo $image->render('jpg');
        $image->crop(640, 300);
        $image->save($wey.'img/my_city/3.jpg');
        $text .= 'Размер изображения: '.$image->width.'x'.$image->height.' px'."<br />";
        /*
        $image->resize(300, 50, Image::AUTO);
        $image->save('img/my_city/timetables4.jpg');
        $text .= 'Размер изображения: '.$image->width.'x'.$image->height.' px'."<br />";
        */
        $data['info'] = $text;
        $this->template->content_admin = View::factory('my_city/resize',$data);
        //$img->resize();
    }
    
    function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
       foreach($objs as $obj) {
         is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       }
    }
    rmdir($dir);
  }
  
  
  public function action_add_my_city_lang() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
            $lang = 'EN';
        //}
        if($_POST){
            $filds = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
            
            $i=0;foreach($filds as $one){
                DB::insert('my_city_filds_i18n',array(
                    'fild_id',
                    'title',
                    'culture'
                ))->values(array(
                    $one['id'],
                    $_POST['fild_title'][$i],
                    $_GET['lang']
                ))->execute();
                $i++;
            }
           
            $id = DB::insert('my_city_i18n',array(
                    'my_city_id',
                    'name',
                    'title',
                    'meta',
                    'text',
                    'culture',
                    'from_search',
                    'to_search'
                ))->values(array(
                    $_GET['id'],
                    $_POST['name'],
                    $_POST['title'],
                    $_POST['meta_description'],
                    $_POST['text'],
                    $_GET['lang'],
                    $_POST['from_search'],
                    $_POST['to_search'],
                ))->execute();
                                
                $this->redirect('/svitgo/my_city');          
        }
        $data = array();
        $data['filds'] = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $this->template->content_admin = View::factory('my_city/add_lang',$data);
	}
    
    public function action_edit_my_city_lang() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
        $lang = 'EN';
        //}
        if($_POST){
                       
            
            $filds = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        
            $i=0;foreach($filds as $one){
                $chek_fild_lang = DB::select()->from('my_city_filds_i18n')->where('my_city_filds_i18n.fild_id','=',$one['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
                if(!empty($chek_fild_lang)){
                    DB::update('my_city_filds_i18n')->set(array(
                        'title'=>$_POST['fild_title'][$i],          
                    ))->where('fild_id','=',$one['id'])->and_where('culture','=',$_GET['lang'])->execute(); 
                }else{
                    DB::insert('my_city_filds_i18n',array(
                    'fild_id',
                    'title',
                    'culture',
                ))->values(array(
                    $one['id'],
                    $_POST['fild_title'][$i],
                    $_GET['lang']
                ))->execute();
                }
                $i++;
            }
           
                DB::update('my_city_i18n')->set(array(
                    'name'=>$_POST['name'],
                    'title'=>$_POST['title'],   
                    'meta'=>$_POST['meta_description'],   
                    'text'=>$_POST['text'],  
                    'from_search'=>$_POST['from_search'],
                    'to_search'=>$_POST['to_search'],
                    'title_city'=>$_POST['title_city'],
                    'intro_text_city'=>$_POST['intro_text_city'],
                    'city_link_title'=>$_POST['city_link_title'],
                    'city_link_url'=>$_POST['city_link_url'],
                    'title_browser'=>$_POST['title_browser'],
                    'keywords'=>$_POST['keywords']               
                ))->where('my_city_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute(); 
                                
                $this->redirect('/svitgo/my_city');          
        }
        $data = array();
        //$data['filds'] = DB::select()->from('my_city_filds')->join('my_city_filds_i18n')->on('my_city_filds.id','=','my_city_filds_i18n.fild_id')->where('my_city_filds.my_city_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute()->as_array();
        //if(empty($data['filds'])){
        $data['filds'] = DB::select()->from('my_city_filds')->where('my_city_filds.my_city_id','=',$_GET['id'])->execute()->as_array();
        //}
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['edit'] = DB::select()->from('my_city')->join('my_city_i18n')->on('my_city.id','=','my_city_i18n.my_city_id')->where('my_city.id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
        $this->template->content_admin = View::factory('my_city/edit_lang',$data);
	}
    
      public function action_dell_my_city_lang() {  
       
        if($_GET){
                       
            DB::delete('my_city_i18n')->where('my_city_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute();
            $filds = DB::select()->from('my_city_filds')->where('my_city_filds.my_city_id','=',$_GET['id'])->execute()->as_array();
            foreach($filds as $fild){
                DB::delete('my_city_filds_i18n')->where('fild_id','=',$fild['id'])->and_where('culture','=',$_GET['lang'])->execute();
            }   
            $this->redirect('/svitgo/my_city');  
        }
	}
    
    public function action_answers() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        //if(!$lang) {
            $lang = 'en';
        //}
        $data = array();
        $data['lang'] = $lang;
        $data['all'] = DB::select()->from('answers')->join('answers_i18n')->on('answers.id','=','answers_i18n.answer_id')->where('sysuser_id','=',$ses_user[0]['id'])->order_by('answers.id','DESC')->execute()->as_array();
        $this->template->content_admin = View::factory('answers/index',$data);
	}
    
    public function action_add_answers() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
        $lang = 'en';
        //}
        if($_POST){
            
            
                $id = DB::insert('answers',array(
                    'name',
                    'weight',
                    'sysuser_id'
                ))->values(array(
                    $_POST['name'],
                    $_POST['weight'],
                    $ses_user[0]['id']
                ))->execute();
                
                $lang = $_POST['lang'];
                
                DB::insert('answers_i18n',array(
                    'answer_id',
                    'text',
                    'text2',
                    'culture',
                ))->values(array(
                    $id[0],
                    $_POST['text'],
                    $_POST['text2'],
                    $lang
                ))->execute();
                
               
                
                $this->redirect('/svitgo/answers');          
        }
        $data = array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $this->template->content_admin = View::factory('answers/add',$data);
	}
    
    public function action_dell_answers() {  
        DB::delete('answers')->where('id','=',$_GET['id'])->execute();
        DB::delete('answers_i18n')->where('answer_id','=',$_GET['id'])->execute();
        $this->redirect('/svitgo/answers');
	}
    
     public function action_add_answer_lang() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
            $lang = 'EN';
        //}
        if($_POST){
            
            $id = DB::insert('answers_i18n',array(
                    'answer_id',
                    'text',
                    'text2',
                    'culture'
                ))->values(array(
                    $_GET['id'],
                    $_POST['text'],
                    $_POST['text2'],
                    $_GET['lang']
                ))->execute();
                                
                $this->redirect('/svitgo/answers');          
        }
        $data = array();
        $data['filds'] = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $this->template->content_admin = View::factory('answers/add_lang',$data);
	}
    
     public function action_edit_answers_lang() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
            $lang = 'EN';
        //}
        if($_POST){
            
                DB::update('answers_i18n')->set(array(
                    'text'=>$_POST['text'],
                    'text2'=>$_POST['text2'],   
                ))->where('answer_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute(); 
                
                DB::update('answers')->set(array(
                    'weight'=>$_POST['weight'],
                ))->where('id','=',$_GET['id'])->execute();
                                
                $this->redirect('/svitgo/answers');          
        }
        $data = array();
        $data['filds'] = DB::select()->from('my_city_filds')->where('my_city_id','=',$_GET['id'])->execute()->as_array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['edit'] = DB::select()->from('answers_i18n')->where('answer_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
        $data['edit_weight'] = DB::select()->from('answers')->where('id','=',$_GET['id'])->execute()->current();
        $this->template->content_admin = View::factory('answers/edit_lang',$data);
	}
    
    public function action_ajax_ost_my_city() {
        if($_POST) {
            if(strlen($_POST['val']) > 1){
            $data = array();             
            $res = Model::factory('OstMod')->get_all_ost_city($_POST['val'],$_POST['lang']);          
            $data['route_citys'] = $res;  
             echo View::factory('my_city/ajax_ost_block',$data); 
            }
            die;
        }
    }
    
    public function action_ajax_city_my_city() {
        if($_POST) {
            if(strlen($_POST['val']) > 1){
            $data = array();             
            $res = Model::factory('OstMod')->get_all_ost_city($_POST['val'],$_POST['lang']); 
            $new = array();
            foreach($res as $r){
                $new[$r['city_i18n']] = $r['city_i18n'];
            }         
            
            //echo '<pre>';
            //print_r($res);
            //echo '</pre>';
            //echo '<pre>';
            //print_r($new);
            //echo '</pre>';
            //die;
            
            $data['route_citys'] = $new;  
             echo View::factory('my_city/ajax_city_block',$data); 
            }
            die;
        }
    }
    
    public function action_my_post() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        //if(!$lang) {
            $lang = 'en';
        //}
        $data = array();
        $data['lang'] = $lang;
        //print_r($ses_user);
        //if($ses_user['group_id'] == 1){
            
        //}
        $data['all'] = DB::select('my_post.id','my_post_i18n.name','my_post_i18n.title','my_post_i18n.meta','img','alt','css','country_id','culture','my_post.sys_user_id')->from('my_post')->join('my_post_i18n')->on('my_post.id','=','my_post_i18n.my_post_id')->where('sys_user_id','=',$ses_user['group_id'])->order_by('my_post.id','DESC')->execute()->as_array();
        $this->template->content_admin = View::factory('my_post/index',$data);
	}
    
    public function action_add_my_post() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_post';
        //if(!$lang) {
        $lang = 'en';
        //}
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            
            $lang = $_POST['lang'];
            
            $img_name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            
            $id = DB::insert('my_post',array(
                    'img',
                    'css',
                    'alt',
                    'sys_user_id',
                    'cat',
                    'template'
                ))->values(array(
                    $img_name,
                    $_POST['css'],
                    $_POST['alt'],
                    $ses_user['group_id'],
                    $_POST['cat'],
                    $_POST['template']
                ))->execute();
                
                
                DB::insert('my_post_i18n',array(
                    'my_post_id',
                    'name',
                    'title',
                    'meta',
                    'text',
                    'culture',
                    'short_text',
                    'short_title',
                    'keywords'
                ))->values(array(
                    $id[0],
                    $_POST['name'],
                    $_POST['title'],
                    $_POST['meta_description'],
                    $_POST['text'],
                    $lang,
                    $_POST['short_text'],
                    $_POST['short_title'],
                    $_POST['keywords']
                ))->execute();
                
                
               
                mkdir($wey."/".$id[0], 0777);
                move_uploaded_file($temp, $wey."/".$id[0]."/1920_".$img_name);
                chmod($wey."/".$id[0]."/1920_".$img_name, 0755);
                
                $image = Image::factory($wey."/".$id[0]."/1920_".$img_name);
                $image->crop(1172, 480);
                $image->save($wey."/".$id[0]."/1172_".$img_name);
                chmod($wey."/".$id[0]."/1172_".$img_name, 0755);
                
                $image->crop(640, 300);
                $image->save($wey."/".$id[0]."/640_".$img_name);
                chmod($wey."/".$id[0]."/640_".$img_name, 0755);
                
                $this->redirect('/svitgo/my_post');          
        }
        $data = array();
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['cat'] = DB::select()->from('my_post_cat')->join('my_post_cat_i18n')->on('my_post_cat.my_post_cat_id','=','my_post_cat_i18n.my_post_cat_id')->where('culture','=',$lang)->execute()->as_array();
        //print_r($data['cat']);
        $this->template->content_admin = View::factory('my_post/add',$data);
	}
    
    public function action_edit_my_post() {  
        //$this->chek_permition();
        //die;
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $lang = $_GET['lang'];
        $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_post';
        if($_POST){            
           
            
           
             
            if(!empty($_FILES['photo']['name'])){
                $img_name = $_FILES['photo']['name'];
                $temp = $_FILES['photo']['tmp_name'];
                $filename = $wey."/".$_GET['id'];
                if (file_exists($filename)) {
                $this->removeDirectory($wey."/".$_GET['id']);
                }
                mkdir($wey."/".$_GET['id'], 0777);
                move_uploaded_file($temp, $wey."/".$_GET['id']."/1920_".$img_name);
                chmod($wey."/".$_GET['id']."/1920_".$img_name, 0755);
                
                $image = Image::factory($wey."/".$_GET['id']."/1920_".$img_name);
                $image->crop(1172, 480);
                $image->save($wey."/".$_GET['id']."/1172_".$img_name);
                chmod($wey."/".$_GET['id']."/1172_".$img_name, 0755);
                
                $image->crop(640, 300);
                $image->save($wey."/".$_GET['id']."/640_".$img_name);
                chmod($wey."/".$_GET['id']."/640_".$img_name, 0755);
                
                
                DB::update('my_post')->set(array(
                    
                    'img'=>$img_name,
                    'css'=>$_POST['css'],
                    'alt'=>$_POST['alt'],
                    'cat'=>$_POST['cat'], 
                    'template'=>$_POST['template'],        
                ))->where('id','=',$_GET['id'])->execute(); 
            }else{
                DB::update('my_post')->set(array(
                    
                    //'img'=>$img_name,
                    'css'=>$_POST['css'],
                    'alt'=>$_POST['alt'],  
                    'cat'=>$_POST['cat'],
                    'template'=>$_POST['template'],                  
                ))->where('id','=',$_GET['id'])->execute();
            }            
           
            
        }
        //if(!$lang) {
        
        //}
        $data = array();
        $data['lang'] = $lang;
        $data['edit'] = DB::select()->from('my_post')->where('my_post.id','=',$_GET['id'])->execute()->current();
        
        $data['cat'] = DB::select()->from('my_post_cat')->join('my_post_cat_i18n')->on('my_post_cat.my_post_cat_id','=','my_post_cat_i18n.my_post_cat_id')->where('culture','=',$lang)->execute()->as_array();
        
        $this->template->content_admin = View::factory('my_post/edit',$data);
	}
    
    public function action_add_my_post_lang() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
            $lang = 'EN';
        //}
        if($_POST){
           
            DB::insert('my_post_i18n',array(
                    'my_post_id',
                    'name',
                    'title',
                    'meta',
                    'text',
                    'culture',
                    'short_text',
                    'short_title',
                    'keywords'
                ))->values(array(
                    $_GET['id'],
                    $_POST['name'],
                    $_POST['title'],
                    $_POST['meta_description'],
                    $_POST['text'],
                    $_GET['lang'],
                    $_POST['short_text'],
                    $_POST['short_title'],
                    $_POST['keywords']
                ))->execute();
                                
                $this->redirect('/svitgo/my_post');          
        }
        $data = array();
        
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $this->template->content_admin = View::factory('my_post/add_lang',$data);
	}
    
    public function action_edit_my_post_lang() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/my_city';
        //if(!$lang) {
        $lang = 'EN';
        //}
        if($_POST){
            
            DB::update('my_post_i18n')->set(array(
                'name'=>$_POST['name'],
                'title'=>$_POST['title'],   
                'meta'=>$_POST['meta_description'],   
                'text'=>$_POST['text'], 
                'short_text'=>$_POST['short_text'],   
                'short_title'=>$_POST['short_title'], 
                'keywords'=>$_POST['keywords']               
            ))->where('my_post_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute(); 
                            
            $this->redirect('/svitgo/my_post');          
        }
        $data = array();
        //$data['filds'] = DB::select()->from('my_city_filds')->join('my_city_filds_i18n')->on('my_city_filds.id','=','my_city_filds_i18n.fild_id')->where('my_city_filds.my_city_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute()->as_array();
        //if(empty($data['filds'])){
        
        $data['countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['edit'] = DB::select()->from('my_post')->join('my_post_i18n')->on('my_post.id','=','my_post_i18n.my_post_id')->where('my_post.id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
        //echo '<pre>';
        //print_r($data['edit']);
        //echo '</pre>';
        $this->template->content_admin = View::factory('my_post/edit_lang',$data);
	}
    
    
    public function action_dell_my_post() {  
        DB::delete('my_post')->where('id','=',$_GET['id'])->execute();
        DB::delete('my_post_i18n')->where('my_post_id','=',$_GET['id'])->execute();
        $this->redirect('/svitgo/my_post');
	}
    
    public function action_dell_my_post_lang() {  
        //DB::delete('my_post')->where('id','=',$_GET['id'])->execute();
        DB::delete('my_post_i18n')->where('my_post_id','=',$_GET['id'])->and_where('culture','=',$_GET['lang'])->execute();
        $this->redirect('/svitgo/my_post');
	}
    
    public function action_ajax_dell_post_img(){
        if($_POST){
            $edit = DB::select()->from('my_post')->where('id','=',$_POST['id'])->execute()->current();
            $wey = '/var/www/vhosts/svitgo.com/svitgo.com.ua/img/my_post';
            //$this->removeDirectory($wey."/".$_POST['id']);
            unlink($wey."/".$_POST['id']."/1920_".$edit['img']);
            unlink($wey."/".$_POST['id']."/1172_".$edit['img']);
            unlink($wey."/".$_POST['id']."/640_".$edit['img']);
            DB::update('my_post')->set(array(
            'img'=>''          
            ))->where('id','=',$_POST['id'])->execute(); 
            
            echo 'ok'; 
            die;
        }
    }
    
} // End Admin
