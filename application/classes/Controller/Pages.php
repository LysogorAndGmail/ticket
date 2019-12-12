<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pages extends Controller_Disp {

                   
    public function before(){
        parent::before();
         $this->chek_admin_enter(); 
    } 
    
    public function action_index(){  
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'ru';
        }
        $this->chek_permition();  
        $data = array();
        $data['pages'] = Model::factory('PostMod')->get_all_pages($lang);
        $this->template->content_admin = View::factory('svitgo_pages/index',$data);
    }
    
    public function action_add_page() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            $article = DB::insert('pages',array(
                'slug',
            ))->values(array(
                $_POST['alias']
            ))->execute();
            
            DB::insert('pages_i18n',array(
                    'page_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $article[0],
                    $_POST['title'],
                    'ru'
                ))->execute();
            
            $this->redirect('/pages');
        }
        $this->chek_permition();  
        $data = array();
        $this->template->content_admin = View::factory('svitgo_pages/add_page',$data);
	}
    
    public function action_update_page() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
            $chek_lang = Model::factory('PostMod')->get_page($_POST['id'],$_POST['lang']); if(!empty($chek_lang)){
            
                DB::update('pages')->set(array(
                    'slug'=>$_POST['alias'],
                ))->where('page_id','=',$_POST['id'])->execute();
                
                DB::update('pages_i18n')->set(array(
                    'name_i18n'=>$_POST['title']
                ))->where('page_id','=',$_POST['id'])->and_where('culture','=',$_POST['lang'])->execute();
            
            }else {
                DB::insert('pages_i18n',array(
                    'page_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $_POST['id'],
                    $_POST['title'],
                    $_POST['lang']
                ))->execute();
            }
            
            $this->redirect('/pages');
        }
        $this->chek_permition();  
        $data = array();
        $data['edit'] = Model::factory('PostMod')->get_page($_GET['id'],$_GET['lang']);
        $this->template->content_admin = View::factory('svitgo_pages/edit_page',$data);
	}
    
    public function action_dell_page() {
        DB::delete('pages')->where('page_id','=',$_GET['id'])->execute();
        DB::delete('pages_i18n')->where('page_id','=',$_GET['id'])->execute();
        $this->redirect('/pages');
	}
    
    public function action_best_routes(){  
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        //$this->chek_permition();  
        $sysuser = $this->ses_user;
        $data = array();
        $data['lang'] = $lang;
        
        $data['best'] = DB::select()->from('best_routes')->where('sys_id','=',$sysuser[0]['id'])->execute()->as_array();
        $this->template->content_admin = View::factory('best_routes/index',$data);
    }
    
    public function action_add_best_routes() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        //$this->chek_permition();  
        $data = array();
        $sys = $this->ses_user;
        $valutes = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
        $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
        $data['langs'] = $langs;
        $data['valutes'] = $valutes;
        $this->template->content_admin = View::factory('best_routes/add',$data);
	}
    
    
    public function action_edit_best_routes() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $sys = $this->ses_user;
        if($_POST){
            
            $chek_img = DB::select()->from('best_routes')->where('id','=',$_GET['id'])->execute()->current();
            if(isset($_FILES['photo'])){
            if($_FILES['photo']['name'] != $chek_img['img']){
            //print_r($_FILES['name']);
            
            //die;
            
            
            $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/best_routes';
            
           //unlink($wey."/".$_GET['id']."/".$chek_img['img']);
           //rmdir($wey."/".$_GET['id']); 
            
            $img_name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            
            DB::update('best_routes')->set(array(
                'from'=>$_POST['from'],
                'to'=>$_POST['to'],
                'for_lang'=>$_POST['lang'],
                'img'=>$img_name,
            ))->where('id','=',$_GET['id'])->execute();
                
            mkdir($wey."/".$_GET['id'], 0777);
            move_uploaded_file($temp, $wey."/".$_GET['id']."/".$img_name);
            chmod($wey."/".$_GET['id']."/".$img_name, 0755);
            }
            }else{
                
                DB::update('best_routes')->set(array(
                    'from'=>$_POST['from'],
                    'to'=>$_POST['to'],
                    'for_lang'=>$_POST['lang'],
               ))->where('id','=',$_GET['id'])->execute();
                
                
            }
            
            DB::delete('best_routes_price')->where('best_id','=',$_GET['id'])->execute();
            
            $valutess = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
                
            $i=0;
            foreach($_POST['valutes'] as $valutes){
                DB::insert('best_routes_price',array(
                    'best_id',
                    'valute',
                    'value'
                ))->values(array(
                    $_GET['id'],
                    $valutess[$i]['valute'],
                    $valutes
                ))->execute();
                $i++;
            }
            
            $this->redirect('/pages/best_routes');
            
            
        }
        $data = array();
        $sys = $this->ses_user;
        $edit = DB::select()->from('best_routes')->where('id','=',$_GET['id'])->execute()->current();
        $valutes = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
        $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
        //print_r($langs);
       // die;
        $data['edit'] = $edit;
        $data['valutes'] = $valutes;
        $data['langs'] = $langs;
        $this->template->content_admin = View::factory('best_routes/edit',$data);
	}
    
    public function action_search_city(){
        if($_POST){
            echo '<script type="text/javascript">
                $(".sel_rou").click(function(){
                    var Par = $(this).parents(".controls");
                    Par.find(".page_from").val($(this).find("span").text());
                    Par.find(".ajax_bloc").html("");
                })
            </script>';
            $lang = 'en';
            $name = $_POST['val'];
           
            
                $res = DB::select()->from('routecity_i18n')
                
                ->where('city_i18n','LIKE','%'.$name.'%')
                ->and_where('culture','=',$lang)
                //->and_where('sysuser_id','=',$ses_user[0]['id'])
                ->execute()->as_array();
                //print_r($res);
                //die;
                //$res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','in',$all_routes)->and_where('name_i18n','LIKE','%'.$name.'%')->where('culture','=','ru')->order_by('routename.route_name_id','DESC')->limit(30)->execute()->as_array();
                //print_r($all);
                //die;

            
            echo '<ul>';
            foreach($res as $r){
                echo '<li class="sel_rou"><div><span>'.$r['route_city_id'].'</span> '.$r['city_i18n'].'</div></li>';
            }
            echo '</ul>';
            
            die;
        }
    }
    
    public function action_save_best_routes(){
        if($_POST){
            //die;
            $sys = $this->ses_user;
            
            $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/best_routes';
            
            $img_name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            
            $main = DB::insert('best_routes',array(
                    'from',
                    'to',
                    'sys_id',
                    'for_lang',
                    'img'
                ))->values(array(
                    $_POST['from'],
                    $_POST['to'],
                    $sys[0]['id'],
                    $_POST['lang'],
                    $img_name
                ))->execute();
                
            mkdir($wey."/".$main[0], 0777);
            move_uploaded_file($temp, $wey."/".$main[0]."/".$img_name);
            chmod($wey."/".$main[0]."/".$img_name, 0755);
            
            $valutess = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$sys[0]['id'])->execute()->as_array();
                
            $i=0;
            foreach($_POST['valutes'] as $valutes){
                DB::insert('best_routes_price',array(
                    'best_id',
                    'valute',
                    'value'
                ))->values(array(
                    $main[0],
                    $valutess[$i]['valute'],
                    $valutes
                ))->execute();
                $i++;
            }
            
            $this->redirect('/pages/best_routes');
            
            
        }
    }
    
    public function action_del_best_routes() {
        DB::delete('best_routes')->where('id','=',$_GET['id'])->execute();
        DB::delete('best_routes_price')->where('best_id','=',$_GET['id'])->execute();
        $this->redirect('/pages/best_routes');
	}
    
    public function action_ajax_dell_bast_img(){
        if($_POST){
             $chek_img = DB::select()->from('best_routes')->where('id','=',$_POST['id'])->execute()->current();

               $wey = '/var/www/vhosts/svitgo.com/httpdocs/img/best_routes';
               unlink($wey."/".$_POST['id']."/".$chek_img['img']);
               rmdir($wey."/".$_POST['id']); 
               DB::update('best_routes')->set(array(
                    'img'=>'',
               ))->where('id','=',$_POST['id'])->execute();
            
            die;
        }
    }
    

 
} // End Page
