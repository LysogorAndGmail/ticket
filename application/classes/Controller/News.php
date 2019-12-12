<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {  
        $this->chek_permition();  
        $data = array();
        $data['news'] = Model::factory('NewsMod')->get_all('ru');
        $data['langvige'] = DB::select()->from('language')->execute()->as_array();
        $this->template->content_admin = View::factory('news/index',$data);
	}
    
    public function action_select_news_cats() {  
        $this->chek_permition();  
        $data = array();
        $data['news_cats'] = Model::factory('NewsMod')->get_all_cats('ru');
        $this->template->content_admin = View::factory('news/select_news_cats',$data);
	}
    
    public function action_add_news() {  
        $this->chek_permition();
        if($_POST){
            
            $server = '/var/www/vhosts/svitgo.com/data.svitgo.com/img';
            
            $img_name = $_FILES['icon']['name'];
            $temp = $_FILES['icon']['tmp_name'];
            
            $img_name_big = $_FILES['big']['name'];
            $temp_big = $_FILES['big']['tmp_name'];
            
            move_uploaded_file($temp, $server."/news_img/".$img_name);
            
            move_uploaded_file($temp_big, $server."/news_img/".$img_name_big);
            
            $res = DB::insert('svitgonews',array(
            'cat_id',
            'news_date',
            'icon',
            'big',
            'alt'
            ))->values(array(
            $_POST['cat_id'],
            $_POST['news_date'],
            $_FILES['icon']['name'],
            $img_name_big,
            $_POST['alt']
            ))->execute();
            
            $res = DB::insert('svitgonews_i18n',array(
            'news_id',
            'title',
            'intro',
            'text',
            'culture'
            ))->values(array(
            $res[0],
            $_POST['title'],
            $_POST['intro'],
            $_POST['text'],
            'ru'
            ))->execute();
            
            $this->redirect('/news');
        }  
        $data = array();
        $data['news_cats'] = Model::factory('NewsMod')->get_all_cats('ru');
        $this->template->content_admin = View::factory('news/add_news',$data);
	}
    
    public function action_update_news() {  
        $this->chek_permition();
        if($_POST){
            
            //print_r($_POST);
            //die;
            
            DB::update('svitgonews')->set(array(
            'cat_id'=>$_POST['cat_id'],
            'news_date'=>$_POST['news_date'],
            'icon'=>$_POST['icon'],
            'big'=>$_POST['big'],
            'alt'=>$_POST['alt']
            ))->where('news_id','=',$_POST['id'])->execute();
            
            DB::update('svitgonews_i18n')->set(array(
            'title'=>$_POST['title'],
            'text'=>$_POST['text'],
            'intro'=>$_POST['intro'],            
            ))->where('news_id','=',$_POST['id'])->and_where('culture','=',$_POST['lang'])->execute();
            
            $this->redirect('/news');
        }  
        $data = array();
        $id = $_GET['id'];
        $lang = $_GET['lang'];
        $data['id'] = $id;
        $data['lang'] = $lang;
        $data['news'] = Model::factory('NewsMod')->get_news($id,$lang);
        $data['news_cats'] = Model::factory('NewsMod')->get_all_cats($lang);
        $this->template->content_admin = View::factory('news/update_news',$data);
	}
    
    public function action_add_news_cat() {  
        $this->chek_permition();
        if($_POST){
            $res = DB::insert('svitgo_news_cat',array(
            'name'
            ))->values(array(
            $_POST['title']
            ))->execute();
            
            $res = DB::insert('svitgo_news_cat_i18n',array(
            'cat_id',
            'title',
            'culture'
            ))->values(array(
            $res[0],
            $_POST['title'],
            'ru'
            ))->execute();
            
            $this->redirect('news/select_news_cats');
        }  
        $data = array();
        $data['langvige'] = DB::select()->from('language')->execute()->as_array();   
        $this->template->content_admin = View::factory('news/add_news_cat',$data);
	}
    
    public function action_del_news(){
        $this->chek_permition();
        if($_GET){
             DB::delete('svitgonews')->where('news_id','=',$_GET['id'])->execute();
             DB::delete('svitgonews_i18n')->where('news_id','=',$_GET['id'])->execute();
            $this->redirect('/news');
        }
    }
    
    public function action_del_news_cat(){
        $this->chek_permition();
        if($_GET){
             DB::delete('svitgo_news_cat')->where('id','=',$_GET['id'])->execute();
             DB::delete('svitgo_news_cat_i18n')->where('cat_id','=',$_GET['id'])->execute();
            $this->redirect('/news/select_news_cats');
        }
    }
    
    public function action_add_news_lang(){
        $this->chek_permition();
        if($_POST){
            $res = DB::insert('svitgonews_i18n',array(
            'news_id',
            'title',
            'intro',
            'culture',
            'text'
            ))->values(array(
            $_POST['news_id'],
            $_POST['title'],
            $_POST['intro'],
            $_POST['culture'],
            $_POST['text']
            ))->execute();
            $this->redirect('/news');
        }
        $data = array();
        $data['langvige'] = DB::select()->from('language')->execute()->as_array();
        $data['news'] = Model::factory('NewsMod')->get_all('ru');
        $this->template->content_admin = View::factory('news/add_news_lang',$data);
          
    }
    public function action_add_news_cat_lang(){
        $this->chek_permition();
        if($_POST){
            $res = DB::insert('svitgo_news_cat_i18n',array(
            'cat_id',
            'title',
            'culture'
            ))->values(array(
            $_POST['cat_id'],
            $_POST['title'],
            $_POST['culture']
            ))->execute();
            
            $this->redirect('news/select_news_cats');
        }
        $data = array();
        $data['langvige'] = DB::select()->from('language')->execute()->as_array();
        $data['news_cats'] = Model::factory('NewsMod')->get_all_cats('ru');   
        $this->template->content_admin = View::factory('news/add_news_cat_lang',$data);  
    }
    
    public function action_upload_img() {        
        $this->chek_permition();
        if($_FILES) {
            $img_name = $_FILES['icon']['name'];
            $temp = $_FILES['icon']['tmp_name'];
            $server = '/var/www/vhosts/svitgo.com/data.svitgo.com/img';
            //echo '<pre>';
            //print_r($server);
            //echo '</pre>';      
            //die;      
            if (move_uploaded_file($temp, $server."/news_img/".$img_name)) {
                echo "Файл корректен и был успешно загружен.\n";
                $this->redirect('/news/upload_img');
            } else {
                echo "Возможная атака с помощью файловой загрузки!\n";
                die;
            }
            
        }
        $data = array();  
        $this->template->content_admin = View::factory('news/upload_img',$data); 
    }
    
    public function action_del_file(){
        $this->chek_permition();
        if($_GET){
            $server = '/var/www/vhosts/svitgo.com/data.svitgo.com/img/news_img';
            unlink("$server".$_GET['name']);
            $this->redirect('/news/upload_img');
        }
    }
    
    public function action_svitgo_add_news() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
            $server = '/var/www/vhosts/svitgo.com/data.svitgo.com/img';
            
            $img_name = $_FILES['icon']['name'];
            $temp = $_FILES['icon']['tmp_name'];
            
            $img_name_big = $_FILES['big']['name'];
            $temp_big = $_FILES['big']['tmp_name'];
            
            move_uploaded_file($temp, $server."/news_img/".$img_name);
            
            move_uploaded_file($temp_big, $server."/news_img/".$img_name_big);
            
            $res = DB::insert('svitgonews',array(
            'cat_id',
            'news_date',
            'icon',
            'big',
            'alt'
            ))->values(array(
            $_POST['cat_id'],
            $_POST['news_date'],
            $_FILES['icon']['name'],
            $img_name_big,
            $_POST['alt']
            ))->execute();
            
            $res = DB::insert('svitgonews_i18n',array(
            'news_id',
            'title',
            'intro',
            'text',
            'culture'
            ))->values(array(
            $res[0],
            $_POST['title'],
            $_POST['intro'],
            $_POST['text'],
            'ru'
            ))->execute();
            
            $this->redirect('/news');
        }  
        $data = array();
        $data['svitgo_news_cats'] = Model::factory('NewsMod')->get_all_cats_svitgo($lang);
        $this->template->content_admin = View::factory('news/svitgo/svitgo_add_news',$data);
	}
    
    
} // End Admin
