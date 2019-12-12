<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Disp extends Controller_Template {

    
    public $template = 'template_disp';
    
    public $ses_user  = ''; 
    
    public function before()
    {
        parent::before();
        View::set_global('title', 'Админка');				
        $this->template->top_head_admin = View::factory('top_head_disp');
        $this->template->header_admin = View::factory('header_disp');
        $this->template->content_admin = '';
        $this->template->footer = View::factory('footer');
        $this->ses_user = Session::instance()->get('ses_user');
        if(isset($this->ses_user[0]['time_zone'])){
            date_default_timezone_set($this->ses_user[0]['time_zone']);
        }
        //$this->cache = Cache::instance();
       
        
    }            
	public function action_index()
	{  
        $this->chek_admin_enter(); 
        $data = array();
        $lang = 'ru';      
        $this->template->content_admin = View::factory('index',$data);
	}
    
    public function action_login()
	{ 
       //$this->template = '';
       $data = array();
       $data['info'] = '';
       if(!empty($_POST)) 
       {
           $admin_login = $_POST['admin_login'];
           $admin_pass = $_POST['admin_pass'];
	       $config = Kohana::$config->load('admin_login_pass');
           $cod_login = $config->get('admin_login');
           $cod_pass = $config->get('admin_pass');
    
	       if($admin_login == $cod_login && $admin_pass == $cod_pass) {
             $ses_user = array('login'=>$cod_login,'type'=>0,'group_id'=>1);
             Session::instance()->set('ses_user',$ses_user);
             $this->redirect('/');
	       }
           else {
                $chek_sysusers = DB::select()->from('system_users')->where('login','=',$admin_login)->and_where('pass','=',$admin_pass)->execute()->current();
                if(!empty($chek_sysusers)){
                    $this->refresh_cron();
                    $ses_user = array('login'=>$admin_login,'type'=>2,'group_id'=>$chek_sysusers['group_id'],$chek_sysusers);
                    Session::instance()->set('ses_user',$ses_user);
                    Session::instance()->set('leng',$chek_sysusers['default_lang']);
                    $this->redirect('/');
                
                }else{
                    $data['info'] = 'Не верный ввод информации!';
                }
                
           }
	       
	   }
       $this->template = View::factory('template_login',$data);
	   //$this->template->header_admin = '';
	   //$this->template->content_admin = View::factory('disp/disp_login');
       //$this->template->left_sidebar_admin = '';
	}
    
    public function action_add_support(){
        if($_POST){
            
            DB::insert('support',array(
                'supp_name',
                'supp_soname',
                'supp_email',
                'supp_phone',
                'supp_login',
                'supp_pass'
            ))->values(array(
                $_POST['supp_name'],
                $_POST['supp_soname'],
                $_POST['supp_email'],
                $_POST['supp_phone'],
                $_POST['supp_login'],
                $_POST['supp_pass']
            ))->execute();
            $data = array();
            $data['lang'] = $_POST['lang'];
            $this->template = View::factory('support/add_support_success',$data);
        }
    }
    
    
    public function action_log_out()
	{ 
        Session::instance()->delete('ses_user');
        $this->redirect('/');
	}
    
    
    public function chek_admin_enter() {
        $ses_user = Session::instance()->get('ses_user');
        if(empty($ses_user)) {
            $this->redirect('disp/login');
        }
    }
    
    public function action_chang_lang() {
        if($_POST) {
            Session::instance()->set('leng',$_POST['lang']);
            echo 'ok';            
            die; 
        }
    }
    
    protected function chek_permition() {
        $ses = $this->ses_user;
        if(empty($ses)){
            $this->redirect('disp/login');
        }
        $ses_group = $ses['group_id'];
        if($ses_group != 1){
            $action = 'action_'.$this->request->action();
            $ch_class = get_class($this);
            $full = $ch_class.'/'.$action;
            $res = DB::select()->from('group_join')->where('group_id','=',$ses_group)->and_where('full_link','=',$full)->execute()->current();
            if(empty($res)) {
            $this->redirect('errors/access');
            die;
            //$this->redirect('disp/login');
            }
        }
        
    }
    
    public function action_reset_pass() {
        if($_POST) {
            //Session::instance()->set('leng',$_POST['lang']);
            //echo 'ok';
            $chek_sysusers = DB::select()->from('system_users')->where('email','=',trim($_POST['email']))->execute()->current();
                if(!empty($chek_sysusers)){
                    //$ses_user = array('login'=>$admin_login,'type'=>2,'group_id'=>$chek_sysusers['group_id'],$chek_sysusers);
                    //Session::instance()->set('ses_user',$ses_user);
                    //$this->redirect('/');
                    $pass = $this->password_genaration(8);
                    
                    DB::update('system_users')->set(array(
                    'pass'=>$pass
                    ))->where('id','=',$chek_sysusers['id'])->execute();
                    
                    $this->send_user_mail($_POST['email'],$chek_sysusers['login'],$pass,'EN');
                    //print_r($pass);
                    echo 'messege send!';
                }else{
                    echo 'this email is not registed!';
                }  
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
    
    function send_user_mail($to,$user_login,$user_pass,$lang) {
    
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
    
    function refresh_cron(){ 
        
        $now_sec = strtotime('now');
        $last_sec = strtotime('+3 month');
        //$last_sec = strtotime($last_day['date']);
        
        $raznitca = $last_sec - $now_sec;
        
        //$raznitca = $plus - $now_sec; //86400
        
        $newnew = round($raznitca/(3600*24));
        
        $dat_array = array();
        $NewDate = date('Y-m-d');
        for($i=1;$i<=$newnew;$i++){
            $NewDate = Date('Y-m-d',strtotime('+1 day', strtotime($NewDate)));
            $dat_array[] = array($NewDate,date('w',strtotime($NewDate)));            
        }
        //$newnew
        $all_cron = DB::select()->from('cron')->execute()->as_array();
        
        //echo '<pre>';
        //print_r($all_cron);
        //echo '</pre>';
        //die;
        foreach($all_cron as $cr){
            //$route_cron = DB::select()->from('cron')->where('route_name_id','=',$cr['route_name_id'])->and_where('ferryman_id','=',$cr['ferryman_id'])->execute()->current();
            
            $all_date_need = explode(',',$cr['type']);
            
            foreach($dat_array as $dates){
                foreach($all_date_need as $need){
                    if($dates[1] == $need){
                        //echo '<pre>';
                        //print_r($dates);
                        //echo '</pre>';
                        $chek = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$cr['route_name_id'])->and_where('ferryman_id','=',$cr['ferryman_id'])->and_where('date','=',$dates[0])->execute()->current();
                        if(empty($chek)){
                            DB::insert('routeferrymanweek',array(
                                'route_name_id',
                                'ferryman_id',
                                'date',
                                'rice',
                                'buses_id',
                                'route_type_id'
                            ))->values(array(
                                $cr['route_name_id'],
                                $cr['ferryman_id'],
                                $dates[0],
                                1,
                                $cr['bus_id'],
                                1
                            ))->execute();
                        }
                    }
                }
            }
        }
        
        ///////////////////////////////// cron blocket
        $now_day_week = date('w');
        $only_day = array();
        foreach($dat_array as $one_date){
            if($one_date[1] == $now_day_week){
                $only_day[] = $one_date;
            }
        }
        
        $all_new_cron_blocket = DB::select()->from('newblocket_plase')
        //->and_where('week_id','=',$now_day_week)
        ->and_where('blocket_type','=','week')->execute()->as_array();
        
        foreach($all_new_cron_blocket as $one_cron_block){
            foreach($dat_array as $only){
                $chek_block_last_date = DB::select()->from('newblocket_plase')->where('route_name_id','=',$one_cron_block['route_name_id'])
                ->and_where('blocket_type','=','day')
                ->and_where('ferryman','=',$one_cron_block['ferryman'])
                ->and_where('buses','=',$one_cron_block['buses'])
                //->and_where('week_id','=',$one_cron_block['week_id'])
                ->order_by('date','DESC')
                ->execute()->current();
                if(strtotime($only[0]) > strtotime($chek_block_last_date['date']) && $one_cron_block['week_id'] == $only[1]){
                    DB::insert('newblocket_plase',array(
                        'route_name_id',
                        'blocket_type',
                        'plases',
                        'date',
                        'ferryman',
                        'sesuser',
                        'buses',
                        'week_id'                    
                    ))->values(array(
                        $one_cron_block['route_name_id'],
                        'day',
                        $one_cron_block['plases'],
                        $only[0],
                        $one_cron_block['ferryman'],
                        $one_cron_block['sesuser'],
                        $one_cron_block['buses'],
                        1
                    ))->execute();
                }
            }
        }
        /////////////////////////////////
    }
    
} // End Admin
