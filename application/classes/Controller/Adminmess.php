<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminmess extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	
    public function action_index() {  
        $this->chek_permition();
        $data = array();
        $data['admin_mess'] = DB::select()->from('admin_mess')->execute()->as_array();
        $this->template->content_admin = View::factory('adminmess/index',$data);
	}
    
    public function action_add_answer(){
        $this->chek_permition();
        if($_GET){
            
            $ad_mes = DB::select()->from('admin_mess')->where('id','=',$_GET['id'])->execute()->current();
            
            $user = DB::select()->from('users')->where('user_id','=',$ad_mes['user_id'])->execute()->current();
            
            //print_r($user);
            //die;
            
            DB::update('admin_mess')->set(array('answer'=>1))->where('id','=',$_GET['id'])->execute();
            
            
            $res = DB::insert('admin_answers',array(
            'mess_id',
            'answer',
            'date'
            ))->values(array(
            $_GET['id'],
            $_POST['answer'],
            Date('Y-m-d H:i:s')
            ))->execute();
            
            $config = Kohana::$config->load('email');
            Email::connect($config);
            $subject = 'Ответ Svitgo.com';
            $from = 'svitgo@gmail.com';
            $message = "Вам итветели на вопрос!";
            $to = trim($user['email'].'');
            Email::send($to, $from, $subject, $message, $html = true);
            
            $this->redirect('/adminmess');
        }
    }
    
} // End Adminmess
