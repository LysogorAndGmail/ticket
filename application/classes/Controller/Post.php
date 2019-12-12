<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        //$this->chek_permition();  
        $data = array();
        $data['sysuser'] = $this->ses_user;
        if(isset($this->ses_user[0])){
            $data['posts'] = DB::select()->from('svitgoarticle')->join('svitgoarticle_i18n')->on('svitgoarticle.article_id','=','svitgoarticle_i18n.article_id')->where('sys_id','=',$this->ses_user[0]['id'])->and_where('culture','=','ru')->execute()->as_array();
        }else{
            $data['posts'] = Model::factory('PostMod')->get_all_posts('ru');
        }
        $this->template->content_admin = View::factory('svitgo_post/index',$data);
	}
    
    public function action_post_menu() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $this->chek_permition();  
        $data = array();
        $data['menus'] = Model::factory('PostMod')->get_all_menu($lang);
        $this->template->content_admin = View::factory('svitgo_post/post_menu',$data);
	}
    
    public function action_add_post() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            $article = DB::insert('svitgoarticle',array(
                'article_status',
                'sys_id'
            ))->values(array(
                1,
                $_POST['sys_id']
            ))->execute();
            
            DB::insert('svitgoarticle_i18n',array(
                    'article_id',
                    'article_title',
                    'article_text',
                    'culture'
                ))->values(array(
                    $article[0],
                    $_POST['article_title'],
                    $_POST['article_text'],
                    'ru'
                ))->execute();
            
            $this->redirect('/post');
        }
        $this->chek_permition();  
        $data = array();
        $data['all_parents'] = DB::select()->from('system_users')->where('parent_sysuser','=',1)->execute()->as_array();
        $this->template->content_admin = View::factory('svitgo_post/add_post',$data);
	}
    
    public function action_add_menu() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            $article = DB::insert('svitgomenu',array(
                'menu_title',
            ))->values(array(
                $_POST['title']
            ))->execute();
            
            $this->redirect('/post/post_menu');
        }
        $this->chek_permition();  
        $data = array();
        $this->template->content_admin = View::factory('svitgo_post/add_menu',$data);
	}
    
    public function action_update_post() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
            $chek_lang = Model::factory('PostMod')->get_post($_POST['id'],$_POST['lang']); if(!empty($chek_lang)){
            
                DB::update('svitgoarticle_i18n')->set(array(
                    'article_title'=>$_POST['article_title'],
                    'article_text'=>$_POST['article_text']
                ))->where('article_id','=',$_POST['id'])->and_where('culture','=',$_POST['lang'])->execute();
            
            }else {
                DB::insert('svitgoarticle_i18n',array(
                    'article_id',
                    'article_title',
                    'article_text',
                    'culture'
                ))->values(array(
                    $_POST['id'],
                    $_POST['article_title'],
                    $_POST['article_text'],
                    $_POST['lang']
                ))->execute();
            }
            
            $this->redirect('/post');
        }
        //$this->chek_permition();  
        $data = array();
        $data['edit'] = Model::factory('PostMod')->get_post($_GET['id'],$_GET['lang']);
        $this->template->content_admin = View::factory('svitgo_post/edit_post',$data);
	}
    
    public function action_edit_menu_list() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
              DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title'],
                ))->where('list_id','=',$_GET['id'])->and_where('culture','=','ru')->execute();
            
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_en'],
                ))->where('list_id','=',$_GET['id'])->and_where('culture','=','en')->execute();
                
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_uk'],
                ))->where('list_id','=',$_GET['id'])->and_where('culture','=','uk')->execute();
                
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_cs'],
                ))->where('list_id','=',$_GET['id'])->and_where('culture','=','cs')->execute();
            
            $this->redirect('/post/menu_list');
        }
        //$this->chek_permition();  
        $data = array();
        $data['edit'] = DB::select()->from('svitgomenu_list_i18n')->where('list_id','=',$_GET['id'])->execute()->as_array();
        //$data['list'] = Model::factory('PostMod')->get_menu_list($_GET['id'],$lang);
        $this->template->content_admin = View::factory('svitgo_post/edit_menu_list',$data);
	}
    
    public function action_ajax_edit_menu_list() {
	    
        if($_POST){
            
              DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title'],
                ))->where('list_id','=',$_POST['id'])->and_where('culture','=','ru')->execute();
            
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_en'],
                ))->where('list_id','=',$_POST['id'])->and_where('culture','=','en')->execute();
                
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_uk'],
                ))->where('list_id','=',$_POST['id'])->and_where('culture','=','uk')->execute();
                
                DB::update('svitgomenu_list_i18n')->set(array(
                    'title'=>$_POST['title_cs'],
                ))->where('list_id','=',$_POST['id'])->and_where('culture','=','cs')->execute();
            
            die;
        }
        //$this->chek_permition();  
    
	}
    
    public function action_menu_list() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'ru';
        }
        $this->chek_permition();  
        $data = array();
        $data['list'] = Model::factory('PostMod')->get_menu_list($_GET['id'],$lang);
        $this->template->content_admin = View::factory('svitgo_post/menu_list',$data);
	}
    
    
    public function action_ajax_add_menu_list_item() {
	    if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            }
            $id = DB::insert('svitgomenu_list',array(
                'link',
                'menu_id'
            ))->values(array(
                $_POST['link'],
                $_POST['id']
            ))->execute();
            
            DB::insert('svitgomenu_list_i18n',array(
                'list_id',
                'title',
                'culture',
                'menu_id'
            ))->values(array(
                $id[0],
                $_POST['title'],
                'ru',
                $_POST['id']
            ))->execute();
            
            DB::insert('svitgomenu_list_i18n',array(
                'list_id',
                'title',
                'culture',
                'menu_id'
            ))->values(array(
                $id[0],
                $_POST['title_en'],
                'en',
                $_POST['id']
            ))->execute();
            
            DB::insert('svitgomenu_list_i18n',array(
                'list_id',
                'title',
                'culture',
                'menu_id'
            ))->values(array(
                $id[0],
                $_POST['title_ua'],
                'uk',
                $_POST['id']
            ))->execute();
            
            DB::insert('svitgomenu_list_i18n',array(
                'list_id',
                'title',
                'culture',
                'menu_id'
            ))->values(array(
                $id[0],
                $_POST['title_cs'],
                'cs',
                $_POST['id']
            ))->execute();
            die;
        }
	}
    
     public function action_ajax_dell_menu_list_item() {
	    if($_POST){
            $lang = Session::instance()->get('leng');
            if(!$lang) {
                $lang = 'EN';
            }
            DB::delete('svitgomenu_list')->where('list_id','=',$_POST['id'])->execute();
            die;
        }
	}
    
    public function action_dell_post() {
        DB::delete('svitgoarticle')->where('article_id','=',$_GET['id'])->execute();
        DB::delete('svitgoarticle_i18n')->where('article_id','=',$_GET['id'])->execute();
        $this->redirect('/post');
	}
    
     public function action_dell_menu() {
        DB::delete('svitgomenu')->where('menu_id','=',$_GET['id'])->execute();
        DB::delete('svitgomenu_list')->where('menu_id','=',$_GET['id'])->execute();
        DB::delete('svitgomenu_list_i18n')->where('menu_id','=',$_GET['id'])->execute();
        $this->redirect('/post/post_menu');
	}
    
} // End Admin
