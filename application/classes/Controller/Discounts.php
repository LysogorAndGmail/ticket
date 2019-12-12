<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Discounts extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {
        $this->chek_permition(); 
        $ses_user = $this->ses_user;
        $data = array();
        if(isset($ses_user[0]['id'])){
            $all_disc = DB::select()->from('tickerdiscount')
            ->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('weight','DESC')->execute()->as_array();
        }else{
            $all_disc = DB::select()->from('tickerdiscount')
            ->order_by('weight','DESC')->execute()->as_array();
        }
        //$new_dis = array();  
        //foreach($all_disc as $dis_main){
        //    $new_dis[$dis_main['main_id']] = $dis_main;
        //}
        
        
        
        $data['discounts'] = $all_disc;
        //echo '<pre>';
        //print_r($all_disc);
        //echo '</pre>';
        //$new = array();
        //foreach($all_disc as $dis){
        //    $new[$dis['main_id']] = $dis['main_id'];
        //}
        //$data['dis_join'] = $new;
        
        $data['langvige'] = DB::select()->from('language')->execute()->as_array();
        if(isset($ses_user[0]['id'])){
            $data['ferrymans'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
        }else{
            $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('discount/index',$data);
	}
    
    public function action_add_new() {  
        $this->chek_permition();
        $ses_user = $this->ses_user;
        if($_POST){
            if($_POST['main_id'] == 'new'){
                $last_main = DB::select()->from('tickerdiscount')->order_by('main_id','DESC')->execute()->as_array();
                //print_r($last_main[0]['main_id']);
                if(!empty($last_main)){
                    $_POST['main_id'] = $last_main[0]['main_id']+1;
                }else{
                    $_POST['main_id'] = 1;
                }
                
                //die;
            }
            $res = DB::insert('tickerdiscount',array(
            'value',
            'ferryman_id',
            'main_id',
            'weight',
            'age',
            'site_only',
            'see_sell',
            'hidden',
            'sysuser_create',
            'open'
            ))->values(array(
            $_POST['value'],
            $_POST['fer_id'],
            $_POST['main_id'],
            $_POST['weight'],
            $_POST['age'],
            $_POST['site_only'],
            $_POST['see_sell'],
            $_POST['hidden'],
            $ses_user[0]['id'],
            $_POST['open']
            ))->execute();
            
            $res = DB::insert('tickerdiscount_i18n',array(
            'ticker_discount_id',
            'name_i18n',
            'culture',
            'name_simple_i18n'
            ))->values(array(
            $_POST['main_id'],
            $_POST['name_i18n'],
            'ru',
            $_POST['name_simple_i18n'],
            ))->execute();
            
            $res = DB::insert('tickerdiscount_i18n',array(
            'ticker_discount_id',
            'name_i18n',
            'culture',
            'name_simple_i18n'
            ))->values(array(
            $_POST['main_id'],
            $_POST['name_i18n_ua'],
            'ua',
            $_POST['name_simple_i18n_ua'],
            ))->execute();
            
            $res = DB::insert('tickerdiscount_i18n',array(
            'ticker_discount_id',
            'name_i18n',
            'culture',
            'name_simple_i18n'
            ))->values(array(
            $_POST['main_id'],
            $_POST['name_i18n_cs'],
            'cs',
            $_POST['name_simple_i18n_cs'],
            ))->execute();
            
            $res = DB::insert('tickerdiscount_i18n',array(
            'ticker_discount_id',
            'name_i18n',
            'culture',
            'name_simple_i18n'
            ))->values(array(
            $_POST['main_id'],
            $_POST['name_i18n_en'],
            'en',
            $_POST['name_simple_i18n_en'],
            ))->execute();
            
            $this->redirect('/discounts');
        }  
        $data = array();
        $data['all_fers'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
        $all_disc = DB::select()->from('tickerdiscount')
            ->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('weight','DESC')->execute()->as_array();
        $new = array();
        foreach($all_disc as $dis){
            $new[$dis['main_id']] = $dis['main_id'];
        }
        $data['discounts'] = $new;
        //die;    
        $this->template->content_admin = View::factory('discount/add_new',$data);
	}
    
    public function action_edit() {  
        $this->chek_permition();
        $ses_user = $this->ses_user;
        $data = array();
        if(isset($ses_user[0]['id'])){
            $data['all_valutes'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['all_routes'] = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        }else{
            $data['all_valutes'] = DB::select()->from('system_users_valutes')->execute()->as_array();
            $data['all_routes'] = DB::select()->from('system_users_routes')->execute()->as_array();
        }
        
        $data['parent'] = $ses_user['group_id'];
        if($ses_user['group_id'] != 1){
            $data['all_groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['all_groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        
        if($_POST){ 
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            if(empty($_POST['fix_route'])){
                echo __('Choise route');
                die;
            }
            
            
            $string_routes = implode(',',$_POST['fix_route']);
            
            // echo '<pre>';
            //print_r($string_routes);
            //echo '</pre>';
            //die;
            
            
            $all_valutes = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            foreach($all_valutes as $valss){
                DB::delete('discount_fixet_price')->where('discount_id','=',$_GET['id'])->and_where('valute','=',$valss['valute'])->execute();
                if(!empty($_POST[$valss['valute']])){
                    $res = DB::insert('discount_fixet_price',array(
                        'discount_id',
                        'valute',
                        'main_id',
                        'value'
                    ))->values(array(
                        $_GET['id'],
                        $valss['valute'],
                        $_POST['main_id'],
                        $_POST[$valss['valute']]
                    ))->execute();
                }
            }            
            
            DB::update('tickerdiscount')->set(array(
                'value'=>$_POST['value'],
                'ferryman_id'=>$_POST['fer_id'],
                'main_id'=>$_POST['main_id'],
                'weight'=>$_POST['weight'],
                'age'=>$_POST['age'],
                'site_only'=>$_POST['site_only'],
                'see_sell'=>$_POST['see_sell'],
                'hidden'=>$_POST['hidden'],
                '5_tik'=>$_POST['5_tik'],
                '10_tik'=>$_POST['10_tik'],
                'routes'=>$string_routes,
                'group_id'=>$_POST['group_id'],
                'open'=>$_POST['open'],
                ))->where('ticker_discount_id','=',$_GET['id'])->execute();
                
                 DB::update('tickerdiscount_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n'],
                'name_simple_i18n'=>$_POST['name_simple_i18n'],
                ))->where('ticker_discount_id','=',$_POST['main_id'])->and_where('culture','=','ru')->execute();
                
                 DB::update('tickerdiscount_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_en'],
                'name_simple_i18n'=>$_POST['name_simple_i18n_en'],
                ))->where('ticker_discount_id','=',$_POST['main_id'])->and_where('culture','=','en')->execute();
                
                 DB::update('tickerdiscount_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_ua'],
                'name_simple_i18n'=>$_POST['name_simple_i18n_ua'],
                ))->where('ticker_discount_id','=',$_POST['main_id'])->and_where('culture','=','ua')->execute();
                
                 DB::update('tickerdiscount_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_cs'],
                'name_simple_i18n'=>$_POST['name_simple_i18n_cs'],
                ))->where('ticker_discount_id','=',$_POST['main_id'])->and_where('culture','=','cs')->execute();
            
            
            $this->redirect('/discounts');
        }  
        if(isset($ses_user[0]['id'])){
            $data['all_fers'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
        }else{
            $data['all_fers'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')->execute()->as_array();
        }
        
        $data['edit'] = DB::select()->from('tickerdiscount')->where('ticker_discount_id','=',$_GET['id'])->execute()->current();
        $data['edit_ru'] = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$data['edit']['main_id'])->and_where('culture','=','ru')->execute()->current();
        $data['edit_en'] = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$data['edit']['main_id'])->and_where('culture','=','en')->execute()->current();
        $data['edit_ua'] = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$data['edit']['main_id'])->and_where('culture','=','ua')->execute()->current();
        $data['edit_cs'] = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$data['edit']['main_id'])->and_where('culture','=','cs')->execute()->current();
        $all_disc = DB::select()->from('tickerdiscount')
            ->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('weight','DESC')->execute()->as_array();
        $new = array();
        foreach($all_disc as $dis){
            $new[$dis['main_id']] = $dis['main_id'];
        }
        $data['discounts'] = $new;
        $this->template->content_admin = View::factory('discount/edit',$data);
	}
    
    public function action_del_discount(){
        $this->chek_permition();
        if($_GET){
            $res = DB::delete('tickerdiscount')->where('ticker_discount_id','=',$_GET['id'])->execute();
            $this->redirect('/discounts');
        }
    }
    
    public function action_add_lang(){
        $this->chek_permition();
        if($_POST){
            $res = DB::insert('tickerdiscount_i18n',array(
            'ticker_discount_id',
            'name_i18n',
            'culture',
            'name_simple_i18n'
            ))->values(array(
            $_POST['main_id'],
            $_POST['name_i18n'],
            $_POST['culture'],
            $_POST['simple_name_i18n'],
            ))->execute();
            $this->redirect('/discounts');
        }  
    }
    
    public function action_ajax_get_discount(){
        if($_POST){
            $res = DB::select()->from('tickerdiscount')->join('tickerdiscount_i18n')->on('tickerdiscount.main_id','=','tickerdiscount_i18n.ticker_discount_id')->where('main_id','=',$_POST['dis_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
            echo $res['value'].'#'.$res['name_simple_i18n'];//print_r($_POST);
            
            die;
        }  
    }
    
    public function action_ajax_get_discount_fix(){
        if($_POST){
            
            $gek_ferr = DB::select()->from('discount_fixet_price')
            ->where('main_id','=',$_POST['dis_id'])
            //->and_where('route_name_id','=',$_POST['route_name_id'])
            ->and_where('valute','=',$_POST['valute'])->execute()->current();
            //echo $res['value'];
            echo $gek_ferr['value'];
            die;
        }  
    }
    
    public function action_ajax_get_discount_10(){
        if($_POST){
            //print_r($_POST);
            $res = DB::select()->from('tickerdiscount')->where('ferryman_id','=',$_POST['fer_id'])->and_where('hidden','=',1)->and_where('5_tik','=',0)->and_where('10_tik','=',1)->execute()->current();
            echo $res['value'];
            die;
        }  
    }
    
    
    public function action_ajax_get_discount_age(){
        if($_POST){
            //print_r($_POST);
            //die;
            if(strlen($_POST['burn']) == 10){
                $al_ex = explode('/',$_POST['burn']);
                
                $age = date('Y') - $al_ex[2];
                //print_r($age);
                //die;
                $res = DB::select('age','main_id')->from('tickerdiscount')->where('ferryman_id','=',$_POST['ferryman_id'])->and_where('hidden','=',1)->and_where('5_tik','=',0)->and_where('10_tik','=',0)->execute()->as_array();
                //echo '<pre>';
                //print_r($res);
                //echo '<pre>';
                //die;
                $ret = ''; 
                foreach($res as $r){
                    if(strlen($r['age']) > 2){
                        $age_del = explode('-',$r['age']);
                        if($age <=$age_del[1] && $age >= $age_del[0]){
                            $ret = $r['main_id'];
                        }
                    }
                }
                echo $ret;
                //print_r($ret);
                die;
                
            }
            die;
        }  
    }
    
    public function action_ajax_add_fers_discouns(){
        if($_POST){
            
            $ses_user = $this->ses_user;
            
            $gek_ferr = DB::select()->from('tickerdiscount')->where('main_id','=',$_POST['id'])->and_where('ferryman_id','=',$_POST['old_fer_id'])->execute()->current();
            foreach($_POST['fers'] as $fer_new){
                
                //echo $fer_new;
                //die;
                
                $gek_ferr_one = DB::select()->from('tickerdiscount')->where('main_id','=',$_POST['id'])->and_where('ferryman_id','=',$fer_new)->execute()->current();
                if(empty($gek_ferr_one)){
                    $res = DB::insert('tickerdiscount',array(
                    'value',
                    'ferryman_id',
                    'main_id',
                    'weight',
                    'age',
                    'site_only',
                    'see_sell',
                    'hidden',
                    'sysuser_create'
                    ))->values(array(
                    $gek_ferr['value'],
                    $fer_new,
                    $gek_ferr['main_id'],
                    $gek_ferr['weight'],
                    $gek_ferr['age'],
                    $gek_ferr['site_only'],
                    $gek_ferr['see_sell'],
                    $gek_ferr['hidden'],
                    $ses_user[0]['id']
                    ))->execute();
                }
                
            }
                   
            die;
        }  
    }
    
    public function action_ajax_chek_fixet(){
        if($_POST){
            //print_r($_POST);   
            //die;  
            $che = 'no';
            $gek_ferr = DB::select()->from('discount_fixet_price')->where('main_id','=',$_POST['dis_id'])->execute()->current();
            if(!empty($gek_ferr)){
                $che = 'fix';
            }
            echo $che;
            die;
        }  
    }
    
    public function action_priorety() {
        //$this->chek_permition(); 
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $data = array();
        $data['discounts'] = DB::select()->from('tickerdiscount')->where('group_id','=',$ses_user[0]['group_id'])->order_by('weight','DESC')->execute()->as_array();
        $all_disc = $data['discounts'];
       
        $data['lang'] = $lang;
        $new = array();
        foreach($all_disc as $dis){
            $new[$dis['main_id']] = $dis['main_id'];
        }
        $data['all_discounts'] = $new;
        if($_POST){
        //echo '<pre>';
        //print_r($_POST['fix_route']);
        //echo '</pre>';
            DB::delete('system_users_priorety_discounts')->where('sysuser_id','=',$ses_user[0]['id'])->execute();
            /*
            foreach($_POST['fix_route'] as $id){
                $res = DB::insert('system_users_priorety_discounts',array(
                    'main_id',
                    'priory',
                    'sysuser_id'
                    ))->values(array(
                    $id,
                    1,
                    $ses_user[0]['id'],
                    ))->execute();
            }
            */
            foreach($new as $dis){
                $prior = 0;
                foreach($_POST['fix_route'] as $return){
                    if($return == $dis){
                        $prior = 1;
                    }
                }
                DB::insert('system_users_priorety_discounts',array(
                    'main_id',
                    'priory',
                    'sysuser_id'
                    ))->values(array(
                    $dis,
                    $prior,
                    $ses_user[0]['id'],
                    ))->execute();
            }
        
        }
        
        
        $all_disc = $data['discounts'];
       
        $data['lang'] = $lang;
        $new = array();
        foreach($all_disc as $dis){
            $new[$dis['main_id']] = $dis['main_id'];
        }
        $data['all_discounts'] = $new;
        
        $this->template->content_admin = View::factory('discount/priorety',$data);
	}
    
    
    
} // End Admin
