<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Seo extends Controller_Disp {
    
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
            $data['all'] = DB::select()->from('seo')->where('sys_user_id','=',$this->ses_user[0]['id'])->and_where('culture','=','ru')->execute()->as_array();
        }else{
            $data['all'] = DB::select()->from('seo')->and_where('culture','=','ru')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('seo/index',$data);
	}
    
    public function action_add() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$this->ses_user[0]['id'])->execute()->as_array();
            $i=0; foreach($langs as $lang){
                DB::insert('seo',array(
                    'main_id',
                    'url',
                    'title',
                    'desc',
                    'key',
                    'culture',
                    'sys_user_id'
                ))->values(array(
                    $_POST['main_id'],
                    $_POST['url'][$i],
                    $_POST['title'][$i],
                    $_POST['desc'][$i],
                    $_POST['key'][$i],
                    $lang['lang'],
                    $this->ses_user[0]['id']
                ))->execute();
                
                $i++;
            }
            $this->redirect('/seo');
        }
        $data = array();
        //$data['all_parents'] = DB::select()->from('system_users')->where('parent_sysuser','=',1)->execute()->as_array();
        $all = DB::select()->from('seo')->order_by('main_id','DESC')->execute()->current();
        $data['main_id'] = $all['main_id']+1;
        $data['langs'] = DB::select()->from('system_users_langs')->where('sysuser_id','=',$this->ses_user[0]['id'])->execute()->as_array();
        $this->template->content_admin = View::factory('seo/add',$data);
	}
    
  
    
    public function action_edit() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
            DB::delete('seo')->where('main_id','=',$_POST['main_id'])->execute();
            
            $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$this->ses_user[0]['id'])->execute()->as_array();
            $i=0; foreach($langs as $lang){
                DB::insert('seo',array(
                    'main_id',
                    'url',
                    'title',
                    'desc',
                    'key',
                    'culture',
                    'sys_user_id'
                ))->values(array(
                    $_POST['main_id'],
                    $_POST['url'][$i],
                    $_POST['title'][$i],
                    $_POST['desc'][$i],
                    $_POST['key'][$i],
                    $lang['lang'],
                    $this->ses_user[0]['id']
                ))->execute();
                
                $i++;
            }
            $this->redirect('/seo');
        }
        //$this->chek_permition();  
        $data = array();
        $data['langs'] = DB::select()->from('system_users_langs')->where('sysuser_id','=',$this->ses_user[0]['id'])->execute()->as_array();
        $data['main_id'] = $_GET['id'];
        $this->template->content_admin = View::factory('seo/edit',$data);
	}
    
  
    

    public function action_dell() {
        DB::delete('seo')->where('main_id','=',$_GET['id'])->execute();
        $this->redirect('/seo');
	}
    
    
    
} // End Admin
