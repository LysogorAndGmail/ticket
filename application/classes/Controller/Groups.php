<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Groups extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {  
        $this->chek_permition();
        $ses_user = $this->ses_user;
        //print_r($ses_user);
        //die
        //$this->chek_permition();    
        $data = array();
        $data['parent'] = $ses_user['group_id'];
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('group/index',$data);
	}
    public function action_add() {  
        $this->chek_permition();  
        if($_POST){
            DB::insert('groups',array(
            'name',
            'parent'
            ))->values(array(
            $_POST['group_name'],
            $_POST['parent']
            ))->execute();
            $this->redirect('/groups');
        }
	}
    
    public function action_edit(){
        $ses_user = $this->ses_user;
        $this->chek_admin_enter();  
        $data = array();
        if($_POST){
            $id = 0;
            if(isset($_POST['see_id'])){
                $id = 1;
            }
            $ferryman = 0;
            if(isset($_POST['see_ferryman'])){
                $ferryman = 1;
            }
            $price = 0;
            if(isset($_POST['see_price'])){
                $price = 1;
            }
            $client = 0;
            if(isset($_POST['see_client'])){
                $client = 1;
            }
            $sysuser = 0;
            if(isset($_POST['see_sysuser'])){
                $sysuser = 1;
            }
            $see_clients_phone = 0;
            if(isset($_POST['see_clients_phone'])){
                $see_clients_phone = 1;
            }
            
            $show_tik_vedomost = 0;
            if(isset($_POST['show_tik_vedomost'])){
                $show_tik_vedomost = 1;
            }
            
            $directions = 0;
            if(isset($_POST['see_directions'])){
                $directions = 1;
            }
            $date = 0;
            if(isset($_POST['see_date'])){
                $date = 1;
            }
            
            $show_block_blocket = 0;
            if(isset($_POST['show_block_blocket'])){
                $show_block_blocket = 1;
            }
            
            $menus = '';
            if(isset($_POST['menus'])){
                foreach($_POST['menus'] as $men){
                    $menus .= $men.',';
                }
            }
            //print_r($id);
            //die;
            DB::update('groups')->set(array(
                    'name'=>$_POST['group_name'],
                    'tik_see_id'=>$id,
                    'tik_see_ferryman'=>$ferryman,
                    'tik_see_price'=>$price,
                    'tik_see_client'=>$client,
                    'tik_see_sysuser'=>$sysuser,
                    'tik_see_directions'=>$directions,
                    'tik_see_date'=>$date,
                    'count_day_sell'=>$_POST['count_day_sell'],
                    'see_clients_phone'=>$see_clients_phone,
                    'show_block_blocket'=>$show_block_blocket,
                    'show_tik_vedomost'=>$show_tik_vedomost,
                    'reserv_anule'=>$_POST['reserv_anule'],
                    'menus'=>$menus
                ))->where('id','=',$_GET['id'])->execute();
        }
        
        if(isset($ses_user[0]['id'])){
        $all_disc = DB::select()->from('tickerdiscount')
            ->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('weight','DESC')->execute()->as_array();
        }else{
            $all_disc = DB::select()->from('tickerdiscount')
            //->where('sysuser_create','=',$ses_user[0]['id'])
            ->order_by('weight','DESC')->execute()->as_array();
        }
        $data['discounts'] = $all_disc;
        $data['edit_group'] = DB::select()->from('groups')->where('id','=',$_GET['id'])->execute()->current();
        if(isset($this->ses_user[0])){
            $parent_group = DB::select()->from('groups')->where('id','=',$data['edit_group']['parent'])->execute()->current();
        }else{
            $parent_group = array('menus'=>'1,2,3,4,5,6,7,8');
        }
        $data['parent_menus'] = explode(',',$parent_group['menus']);
        $data['edit_menus'] = explode(',',$data['edit_group']['menus']);   
        $this->template->content_admin = View::factory('group/edit_group',$data);
    }
    
    
    public function action_dell(){
        if($_GET){
            DB::delete('groups')->where('id','=',$_GET['id'])->execute();
            DB::delete('group_join')->where('group_id','=',$_GET['id'])->execute();
            $this->redirect("/groups");
        }
    }
    
    public function action_group_functions(){
        $this->chek_permition();  
        $data = array();
        $data['group_fun'] = DB::select()->from('group_functions')->execute()->as_array();    
        $this->template->content_admin = View::factory('group/group_functions',$data);
    }
    
    public function action_group_join(){
        $this->chek_permition();
        $ses_user = $this->ses_user;
        $clases_array = array(
            'Controller_Adminmess',
            'Controller_Buses',
            'Controller_Discounts',
            'Controller_Disp',
            'Controller_Ferryman',
            'Controller_Groups',
            'Controller_News',
            'Controller_Ost',
            'Controller_Rice',
            'Controller_Route',
            'Controller_Roz',
            'Controller_Tiket',
            'Controller_Sysuser',
            'Controller_Svitgo',
            );  
          $new_ar = array();  
            $class_methods = get_class_methods('Controller_Adminmess');
            for ($x = 0; $x < count($class_methods); $x++)
            {
                $mystring = $class_methods[$x];
                $findme   = 'action_';
                $pos = strpos($mystring, $findme);
                if($pos !== false){
                    array_push($new_ar, $mystring);
                }
                
            }
        $data = array();
        $data['first_metods'] = $new_ar;
        $data['all_clases'] = $clases_array;
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        $data['group_fun'] = DB::select()->from('group_functions')->execute()->as_array();    
        if($ses_user['group_id'] != 1){
            $data['all_parent_function'] = DB::select()->from('group_join')->where('group_id','=',$ses_user['group_id'])->execute()->as_array();
            $data['all_first_save'] = DB::select()->from('group_join')->where('group_id','=',$data['groups'][0]['id'])->execute()->as_array();
            $this->template->content_admin = View::factory('group/join_new_parent',$data);
        }else{
            $data['all_first_save'] = DB::select()->from('group_join')->where('group_id','=',$data['groups'][0]['id'])->execute()->as_array();  
            $this->template->content_admin = View::factory('group/join_new',$data);
        }
        
    }
    
     public function action_show_group(){
        
        $this->chek_permition(); 
        $id = $this->request->param('id'); 
        $data = array();
        $data['group'] = DB::select()->from('groups')->where('id','=',$id)->execute()->as_array();
        $data['join'] = DB::select()->from('group_join')->where('group_id','=',$id)->execute()->as_array(); 
        $data['group_fun'] = DB::select()->from('group_functions')->execute()->as_array();    
        $this->template->content_admin = View::factory('group/see_group',$data);
    }
    
    public function action_all_metods_names(){
        
        $this->chek_permition();
        $clases_array = array(
            'Controller_Adminmess',
            'Controller_Buses',
            'Controller_Discounts',
            'Controller_Disp',
            'Controller_Ferryman',
            'Controller_Groups',
            'Controller_News',
            'Controller_Ost',
            'Controller_Rice',
            'Controller_Route',
            'Controller_Roz',
            'Controller_Tiket',
            'Controller_Sysuser',
            );
        
        $new_ar = array();
        foreach($clases_array as $class){
            $class_methods = get_class_methods($class);
            $new_ar[$class] = $class_methods;
        }
        $fix = array();
        foreach($new_ar as $con=>$action){
            $new_ac = array();
            foreach($action as $ac){
                $findme   = 'action_';
                $findme2   = 'ajax';
                $pos2 = strpos($ac, $findme2);
                $pos = strpos($ac, $findme);
                if($pos !== false && $pos2 === false && $ac != "action_login" && $ac != "action_chang_lang"){
                    $new_ac[] = $ac;
                } 
            }
            $fix[$con] = $new_ac;
        }
        $data = array();
        $data['first_metods'] = $fix;
        $data['all_clases'] = $clases_array;
        $this->template->content_admin = View::factory('group/dostup',$data);
    }
    
    public function action_ajax_get_class_medods(){
        if($_POST){
            $new_ar = array();
            $class_methods = get_class_methods($_POST['search_class']);
            for ($x = 0; $x < count($class_methods); $x++){
                $mystring = $class_methods[$x];
                $findme   = 'action_';
                $findme2   = 'ajax';
                $pos = strpos($mystring, $findme);
                $pos2 = strpos($mystring, $findme2);
                if($pos !== false && $pos2 === false && $mystring != "action_login" && $mystring != "action_chang_lang"){
                    array_push($new_ar, $mystring);
                }
            }
            foreach($new_ar as $mes){
                $full = $_POST['search_class']."/".$mes;
                $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();    
                echo '<div>
                        <input type="checkbox" name="met[]" value="'.$mes.'" data-reveal-id="group_mod_'.$mes.'" data-link="'.$full.'" /> <span>'.$full.'</span> <span style="color: blue;">'.$ac_name['title'].'</span>
                </div>';
            }
            die;
        }
    }
    
    public function action_ajax_update_action_name(){
        if($_POST){
            $full = $_POST['controller'].'/'.$_POST['action'];
            $ch = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current(); 
            if(empty($ch)){
                DB::insert('group_actions_name',array(
                    'action',
                    'con',
                    'title',
                    'full_link'
                ))->values(array(
                    $_POST['action'],
                    $_POST['controller'],
                    $_POST['title'],
                    $full
                ))->execute();
            }else{
                DB::update('group_actions_name')->set(array(
                    'title'=>$_POST['title'],
                ))->where('full_link','=',$full)->execute();
            }
            //print_r($_POST);
            die;
        }
    }
    
    public function action_ajax_save_medods(){
        if($_POST){
            
            //print_r($_POST);
            //die;
            DB::delete("group_join")->where('group_id','=',$_POST['group'])->execute();
            foreach($_POST['metods'] as $m){
                $ex = explode('/',$m);
                //print_r($ex);
                //die;
                DB::insert('group_join',array(
                    'group_id',
                    'full_link',
                    'action',
                    'class'
                ))->values(array(
                    $_POST['group'],
                    $m,
                    $ex[1],
                    $ex[0]
                ))->execute();
            }
            echo "ok";
            //print_r($_POST);
            die;
        }
    }
    public function action_ajax_save_medods_parent(){
        if($_POST){
            //print_r($_POST);
            //die;
            DB::delete("group_join")->where('group_id','=',$_POST['group'])->execute();
            foreach($_POST['metods'] as $m){
                $ex = explode('/',$m);
                //print_r($ex);
                //die;
                DB::insert('group_join',array(
                    'group_id',
                    'full_link',
                    'action',
                    'class'
                ))->values(array(
                    $_POST['group'],
                    $m,
                    $ex[1],
                    $ex[0]
                ))->execute();
            }
            echo "ok";
            //print_r($_POST);
            die;
        }
    }
    
    
    public function action_ajax_get_group_medods(){
        if($_POST){
            $all = DB::select()->from('group_join')->where('group_id','=',$_POST['group'])->execute()->as_array(); 
            
            foreach($all as $mes){
                $full = $mes['full_link'];
                $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();
                //print_r($ac_name);
                //die;    
                echo '<div class="green">
                        <input type="checkbox" name="met[]" checked="checked" value="'.$mes['action'].'" data-reveal-id="group_mod_'.$mes['action'].'" data-link="'.$full.'" /> <span>'.$mes['full_link'].'</span> <span style="color: blue;">'.$ac_name['title'].'</span>
                </div>';
            }
            die;
        }
    }
 
    public function action_group_price() {
        //$this->chek_permition(); 
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $data = array();
        //$all = DB::select()->from('routeprice_groups')->order_by('route_name_id','DESC')->execute()->as_array();
        $al_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        foreach($al_routes as $rou){
            $al_r[] = $rou['route_name_id'];
        }
        $all = DB::select()->from('routeprice_groups')->where('route_name_id','in',$al_r)->order_by('route_name_id','DESC')->where('group_id','=',$ses_user[0]['group_id'])->execute()->as_array();
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id'].$a['group_id'].$a['valute'].$a['ret']] = $a;
        }
        $main_id = DB::select()->from('routeprice_groups')->order_by('main_id','DESC')->execute()->current();
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $data['main_id'] = $main_id['main_id']+1;
        $this->template->content_admin = View::factory('group/group_price/index',$data);
	}
    
    public function action_group_price_simple() {
        //$this->chek_permition(); 
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $data = array();

        $this->template->content_admin = View::factory('group/group_price/index_simple',$data);
	}
    
    public function action_add_group_price() {
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['all_fer'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            //print_r($all_ses_fer); 
            //die;
            if(!empty($all_ses_fer)){
                $data['all_fer'] = DB::select()->from('ferryman')->where('ferryman_id','in',$all_ses_fer)->execute()->as_array();
            }
            //print_r($all_par_groups); 
               
        }else{
            $data['all_fer'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        $all = DB::select()->from('routeprice_return_discount')->order_by('route_name_id','DESC')->execute()->as_array();
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id']] = $a;
        }
        
        $limit = 100;
        
        
            $all_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        //echo '<pre>';
        //print_r($all_routes);
        //echo '</pre>';
        //die;
            foreach($all_routes as $rou){
                $data['all_rou'][] = DB::select()->distinct(true)->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                ->and_where('culture','=',$lang)
                ->and_where('routename.route_name_id','=',$rou['route_name_id'])
                ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            
    
        
        
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $data['valutes'] = DB::select()->from('country')->execute()->as_array();
        $data['parent'] = $ses_user['group_id'];
        $data['langs'] = DB::select()->from('system_users_langs')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('group/group_price/add_group_price',$data);
	}
    
    public function action_edit_group_price() {
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['all_fer'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            //print_r($all_ses_fer); 
            //die;
            if(!empty($all_ses_fer)){
                $data['all_fer'] = DB::select()->from('ferryman')->where('ferryman_id','in',$all_ses_fer)->execute()->as_array();
            }
            //print_r($all_par_groups); 
               
        }else{
            $data['all_fer'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        $all = DB::select()->from('routeprice_return_discount')->order_by('route_name_id','DESC')->execute()->as_array();
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id']] = $a;
        }
        
        $limit = 100;
        
        
            $all_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        //echo '<pre>';
        //print_r($all_routes);
        //echo '</pre>';
        //die;
            foreach($all_routes as $rou){
                $data['all_rou'][] = DB::select()->distinct(true)->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                ->and_where('culture','=',$lang)
                ->and_where('routename.route_name_id','=',$rou['route_name_id'])
                ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            
    
        
        
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $data['valutes'] = DB::select()->from('country')->execute()->as_array();
        $data['parent'] = $ses_user['group_id'];
        $data['langs'] = DB::select()->from('system_users_langs')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('group/group_price/edit_group_price',$data);
	}
    
    public function action_del_group_price(){
        DB::delete('routeprice_groups')->where('route_name_id','=',$_GET['route_name_id'])
        ->and_where('ferryman_id','=',$_GET['fer_id'])
        ->and_where('group_id','=',$_GET['group_id'])
        ->and_where('valute','=',$_GET['valute'])
        ->and_where('ret','=',$_GET['ret'])
        ->execute();
        
        DB::delete('routeprice_groups_i18n')->where('main_id','=',$_GET['main_id'])->execute();
        
        $this->redirect('/groups/group_price');
    }
    
    public function action_ajax_update_group_price() {
        
        if($_POST){
            
            
           //  echo '<pre>';
           //print_r($_POST);
           //echo '</pre>';
           //die;
            $ses_user = $this->ses_user;
            
          $route_id = $_POST['route_name_id'];
          
          DB::delete('routeprice_groups')->where('route_name_id','=',$route_id)
        ->and_where('ferryman_id','=',$_POST['fer_id'])
        ->and_where('group_id','=',$_POST['group_id'])
        ->and_where('valute','=',$_POST['valute'])
        ->and_where('ret','=',$_POST['ret'])
        //->and_where('date_from','=',$_POST['date_from'])
        //->and_where('date_to','=',$_POST['date_to'])
        ->execute();
          
         $chel_lang = DB::select()->from('routeprice_groups_i18n')->where('main_id','=',$_POST['main_id'])->execute()->current();
         if(!empty($chel_lang)){
             $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
                    $i = 0;
                    foreach($langs as $one_title){
                        DB::update('routeprice_groups_i18n')->set(array(
                        'name_i18n'=>$_POST['title'][$i]
                        ))->where('main_id','=',$_POST['main_id'])->and_where('culture','=',$one_title['lang'])->execute();
                        $i++;
                    }
         }else{
              $langs = DB::select()->from('system_users_langs')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
                    $i = 0;
                    foreach($langs as $one_title){
                        DB::insert('routeprice_groups_i18n',array(
                            'main_id',
                            'name_i18n',
                            'culture'
                        ))->values(array(
                            $_POST['main_id'],
                            $_POST['title'][$i],
                            $one_title['lang']
                        ))->execute();
                        $i++;
                    }
         }
         
         
          
          //$valute_type = DB::select()->from('country')->where('valute','=',$_POST['valute'])->execute()->current();
            foreach($_POST['array'] as $item){
                $new_i = explode(':',$item);
                $citys = explode('_',$new_i[0]);
                $price = $new_i[1];
                
                $check = DB::select()->from('routeprice_groups')
                    ->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->and_where('group_id','=',$_POST['group_id'])
                    ->and_where('ret','=',$_POST['ret'])
                    //->and_where('date_from','=',$_POST['date_from'])
                    //->and_where('date_to','=',$_POST['date_to'])
                    ->execute()->current();
                if(!empty($check)){
                    DB::update('routeprice_groups')->set(array(
                        'price'=>$price
                    ))->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->and_where('group_id','=',$_POST['group_id'])
                    ->and_where('ret','=',$_POST['ret'])
                    //->and_where('date_from','=',$_POST['date_from'])
                    //->and_where('date_to','=',$_POST['date_to'])
                    ->execute();                  
                      
                }else{
                    DB::insert('routeprice_groups',array(
                        'route_name_id',
                        'route_city_from_id',
                        'route_city_to_id',
                        'valute',
                        'price',
                        'route_price_id',
                        'ferryman_id',
                        'group_id',
                        'date_from',
                        'date_to',
                        'ret',
                        'main_id',
                        'discount_id'
                        ))->values(array(
                        $route_id,
                        $citys[0],
                        $citys[1],
                        $_POST['valute'],
                        $price,
                        1,
                        $_POST['fer_id'],
                        $_POST['group_id'],
                        $_POST['date_from'],
                        $_POST['date_to'],
                        $_POST['ret'],
                        $_POST['main_id'],
                        $_POST['discount_id']
                        ))->execute();
                        
                      
                }
            }
            echo 'Update!';    
            die;   
        }
    }
    
    public function action_group_price_return() {
        //$this->chek_permition();
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['ferrymans'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            //print_r($all_ses_fer); 
            //die;
            if(!empty($all_ses_fer)){
                $data['ferrymans'] = DB::select()->from('ferryman')->where('ferryman_id','in',$all_ses_fer)->execute()->as_array();
            }
            //print_r($all_par_groups); 
            $al_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            foreach($al_routes as $rou){
                $al_r[] = $rou['route_name_id'];
            }
            
            $all = DB::select()->from('routeprice_group_return')->where('route_name_id','in',$al_r)->order_by('route_name_id','DESC')->execute()->as_array();
               
        }else{
            $data['ferrymans'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
          
            $all = DB::select()->from('routeprice_group_return')->order_by('route_name_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id'].$a['group_id'].$a['valute']] = $a;
        }
        //echo '<pre>';
        //print_r($all_pr);
        //echo '</pre>';
        // die;
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $this->template->content_admin = View::factory('/group/group_price_return/index',$data);
    }
    
    public function action_add_group_price_return() {
        //$this->chek_permition();
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['all_fer'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            //print_r($all_ses_fer); 
            //die;
            if(!empty($all_ses_fer)){
                $data['all_fer'] = DB::select()->from('ferryman')->where('ferryman_id','in',$all_ses_fer)->execute()->as_array();
            }
            //print_r($all_par_groups); 
               
        }else{
            $data['all_fer'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        $all = DB::select()->from('routeprice_group_return')->order_by('route_name_id','DESC')->execute()->as_array();
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id']] = $a;
        }
        
        $limit = 100;
        
        
            $all_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        //echo '<pre>';
        //print_r($all_routes);
        //echo '</pre>';
        //die;
            foreach($all_routes as $rou){
                $data['all_rou'][] = DB::select()->distinct(true)->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                ->and_where('culture','=',$lang)
                ->and_where('routename.route_name_id','=',$rou['route_name_id'])
                ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            
    
        if($ses_user[0]['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user[0]['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $data['valutes'] = DB::select()->from('country')->execute()->as_array();
        $this->template->content_admin = View::factory('/group/group_price_return/add_group_price',$data);
    }
    
    public function action_edit_group_price_return() {
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['all_fer'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            //print_r($all_ses_fer); 
            //die;
            if(!empty($all_ses_fer)){
                $data['all_fer'] = DB::select()->from('ferryman')->where('ferryman_id','in',$all_ses_fer)->execute()->as_array();
            }
            //print_r($all_par_groups); 
               
        }else{
            $data['all_fer'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        $all = DB::select()->from('routeprice_return_discount')->order_by('route_name_id','DESC')->execute()->as_array();
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id']] = $a;
        }
        
        $limit = 100;
        
        
            $all_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        //echo '<pre>';
        //print_r($all_routes);
        //echo '</pre>';
        //die;
            foreach($all_routes as $rou){
                $data['all_rou'][] = DB::select()->distinct(true)->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                ->and_where('culture','=',$lang)
                ->and_where('routename.route_name_id','=',$rou['route_name_id'])
                ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            
    
        
        
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $data['valutes'] = DB::select()->from('country')->execute()->as_array();
        $data['parent'] = $ses_user['group_id'];
        if($ses_user['group_id'] != 1){
            $data['groups'] = DB::select()->from('groups')->where('parent','=',$ses_user['group_id'])->execute()->as_array();    
        }else{
            $data['groups'] = DB::select()->from('groups')->execute()->as_array();
        }
        $this->template->content_admin = View::factory('group/group_price_return/edit_group_price_return',$data);
	}
    
    
    
    public function action_ajax_update_group_price_return() {
        
        if($_POST){
          $route_id = $_POST['route_name_id'];
          
          
           //echo '<pre>';
           //print_r($_POST);
           //echo '</pre>';
           //die;
          //$valute_type = DB::select()->from('country')->where('valute','=',$_POST['valute'])->execute()->current();
            foreach($_POST['array'] as $item){
                $new_i = explode(':',$item);
                $citys = explode('_',$new_i[0]);
                $price = $new_i[1];
                
                $check = DB::select()->from('routeprice_group_return')
                    ->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->and_where('group_id','=',$_POST['group'])
                    ->execute()->current();
                if(!empty($check)){
                    DB::update('routeprice_group_return')->set(array(
                        'price'=>$price
                    ))->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->and_where('group_id','=',$_POST['group'])
                    ->execute();
                }else{
                    DB::insert('routeprice_group_return',array(
                        'route_name_id',
                        'route_city_from_id',
                        'route_city_to_id',
                        'valute',
                        'price',
                        'route_price_id',
                        'ferryman_id',
                        'group_id'
                        ))->values(array(
                        $route_id,
                        $citys[0],
                        $citys[1],
                        $_POST['valute'],
                        $price,
                        1,
                        $_POST['fer_id'],
                        $_POST['group']
                        ))->execute();
                }
            }
            echo 'Update!';    
            die;   
        }
    }
    
    public function action_del_group_price_return(){
        DB::delete('routeprice_group_return')->where('route_name_id','=',$_GET['route_name_id'])
        ->and_where('ferryman_id','=',$_GET['fer_id'])
        ->and_where('group_id','=',$_GET['group_id'])
        ->and_where('valute','=',$_GET['valute'])
        ->execute();
        $this->redirect('/groups/group_price_return');
    }
    
} // End Admin
