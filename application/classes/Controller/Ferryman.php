<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ferryman extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['content'] = '';
        if($_POST){
            $data['all'] = array();
            if(!empty($_POST['id'])){
                $data['all'] = Model::factory('FerrymanMod')->search_ferryman_id($_POST['id']);
            }
            if(!empty($_POST['name'])){
                $data['all'] = Model::factory('FerrymanMod')->search_ferryman_name($_POST['name']);
            }
            $con = View::factory('ferryman/search_table',$data);
            $data['content'] = $con;
        }
        $data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();    
        //$this->template->left_sidebar_admin = View::factory('ferryman/left');
        $this->template->content_admin = View::factory('ferryman/index',$data);
	}
    
    public function action_see_all() {
        $this->chek_permition();
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
               
        }else{
            $data['ferrymans'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        $this->template->content_admin = View::factory('/ferryman/see_all',$data);
    }
    
    public function action_discoun_tiket_list() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['dis'] = DB::select()->from('ticket_null')->where('ferryman_id','=',$_GET['id'])->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        $this->template->content_admin = View::factory('/ferryman/discount_tiket_list',$data);
    }
    
    public function action_add_disck() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['fer_id'] = $_GET['id'];
        if($_POST){
            DB::insert('ticket_null',array('ferryman_id','hours','procents'))->values(array($_POST['fer_id'],$_POST['hours'],$_POST['proc']))->execute();
            $this->redirect('/ferryman/see_all');
        }
        //$data['ferrymans'] = DB::select()->from('ferryman')->execute()->as_array();    
        //$this->template->left_sidebar_admin = View::factory('ferryman/left');
        $this->template->content_admin = View::factory('ferryman/add_disck',$data);
	}
    
    public function action_del_disc(){
        DB::delete('ticket_null')->where('id','=',$_GET['id'])->execute();
        $this->redirect('/ferryman/see_all');
    }
    
    public function action_ajax_ferryman_seach(){
        
        echo '<script type="text/javascript">
                $(".search_fe input").change(function(){
                        $(".show_hide").show();
                })
             </script>';
        if($_POST){
         
         $fers = DB::select()->from('ferryman')->where('name','LIKE','%'.$_POST['search'].'%')->execute()->as_array();
        echo '<table class="table table-striped table-fixed-layout table-hover" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>'.__("Title").'</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($fers as $f){
                echo '<tr class="">
                    <td>'.$f["ferryman_id"].'</td>
                    <td>'.$f["name"].'</td>
                    <td><input type="radio" name="fer_id" value="'.$f["ferryman_id"].'" /> </td>
                </tr>';
            }
         echo '</tbody>
        </table>';
        //    print_r($_POST);
            die;
        }
    }
    
    public function action_ajax_ferryman_buses_save(){
        if($_POST){
            DB::delete('ferryman_buses')->where('fer_id','=',$_POST['fer_id'])->execute();
            if(!empty($_POST['buses'])){
                foreach($_POST['buses'] as $bus){
                    DB::insert('ferryman_buses',array('fer_id','buses_id'))->values(array($_POST['fer_id'],$bus))->execute();
                }
            }
            //print_r($_POST);
            die;
        }
    }
    
    public function action_add() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
         $ses_user = $this->ses_user;
        $data = array();
        if($_POST){              
            $bus_id = DB::insert('ferryman',array(
                'name',
                'firmaname',
                'tel1',
                'tel2',
                'fax',
                'address',
                'address2'
            ))->values(array(
                $_POST['name'],
                $_POST['company'],
                $_POST['tel'],
                $_POST['tel2'],
                $_POST['fax'],
                $_POST['adress'],
                $_POST['adress2']
            ))->execute();
            
            
            if($ses_user['group_id'] != 1){
            
                DB::insert('system_users_ferryman',array(
                    'sys_id',
                    'fer_id'
                ))->values(array(
                    $ses_user[0]['id'],
                    $bus_id[0]
                ))->execute();
            
            }
            //die;
            $this->redirect("/ferryman/see_all");
        }
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        $this->template->content_admin = View::factory('/ferryman/add',$data);
    }
    
    public function action_update() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data = array();
        $id = $_GET['id'];
        if($_POST){
            
            DB::update('ferryman')->set(array(
                'name'=>$_POST['name'],
                'firmaname'=>$_POST['company'],
                'tel1'=>$_POST['tel'],
                'tel2'=>$_POST['tel2'],
                'fax'=>$_POST['fax'],
                'address'=>$_POST['adress'],
                'address2'=>$_POST['adress2'],
                'reserv_anule'=>$_POST['reserv_anule']
            ))->where('ferryman_id','=',$id)->execute();
            
            $this->redirect("/ferryman/see_all");
        }
        $data['edit'] = DB::select()->from('ferryman')->where('ferryman_id','=',$id)->execute()->current();
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        $this->template->content_admin = View::factory('/ferryman/edit',$data);
    }
    
    public function action_del() {
        $this->chek_permition();
        DB::delete('ferryman')->where('ferryman_id','=',$_GET['id'])->execute();
        $this->redirect("/ferryman/see_all");
    }
    
    public function action_all_return_price() {
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
               
        }else{
            $data['ferrymans'] = DB::select()->from('ferryman')->order_by('ferryman_id','DESC')->execute()->as_array();
        }  
        
        //$this->template->left_sidebar_admin = View::factory('/ferryman/left',$data);
        
        $al_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            foreach($al_routes as $rou){
                $al_r[] = $rou['route_name_id'];
            }
        
        
        
        $all = DB::select()->from('routeprice_return_discount')->where('route_name_id','in',$al_r)->order_by('route_name_id','DESC')->execute()->as_array();
        
        $all_pr = array();
        foreach($all as $a){
            $all_pr[$a['route_name_id'].$a['ferryman_id']] = $a;
        }
        //echo '<pre>';
        //print_r($all_pr);
        //echo '</pre>';
        // die;
        $data['lang'] = $lang;
        $data['all'] = $all_pr;
        $this->template->content_admin = View::factory('/ferryman/return_price/all',$data);
    }
    
     public function action_add_return_price() {
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
        $this->template->content_admin = View::factory('/ferryman/return_price/add',$data);
    }
    
    public function action_ajax_get_price_table(){
        if($_POST){
            $lang = Session::instance()->get('leng');
             if(!$lang) {
                $lang = 'en';
             }
            $data = array();
            $data['lang'] = $lang;
            $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight')->execute()->as_array();
            echo View::factory('/ferryman/return_price/ajax_price_table',$data);
            die;
        }
    }
    
    public function action_ajax_get_price_table_edit(){
        if($_POST){            
            $lang = Session::instance()->get('leng');
             if(!$lang) {
                $lang = 'en';
             }
            $data = array();
            $data['lang'] = $lang;
            $data['post'] = $_POST;
            $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight')->execute()->as_array();
            
            
            //print_r($data['edit_price']);
            echo View::factory('/group/group_price/ajax_price_table_edit',$data);
            die;
        }
    }
    
    public function action_ajax_get_price_table_edit_return(){
        if($_POST){
            
            
            $lang = Session::instance()->get('leng');
             if(!$lang) {
                $lang = 'en';
             }
            $data = array();
            $data['lang'] = $lang;
            $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight')->execute()->as_array();
            
            $data['edit_price'] = DB::select()->from('routeprice_group_return')
                ->where('route_name_id','=',$_POST['route_name_id'])
                ->and_where('ferryman_id','=',$_POST['fer_id'])
                ->and_where('group_id','=',$_POST['group_id'])
                ->and_where('valute','=',$_POST['valute'])
                ->order_by('weight')->execute()->current();
            //print_r($data['edit_price']);
            echo View::factory('/group/group_price_return/ajax_price_table_edit_return',$data);
            die;
        }
    }
    
    public function action_edit_discount_price(){
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
        $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$_GET['route_name_id'])->order_by('weight')->execute()->as_array();
        $data['edit'] = DB::select()->from('routeprice_return_discount')->where('route_name_id','=',$_GET['route_name_id'])->and_where('ferryman_id','=',$_GET['fer_id'])->execute()->as_array();
        $this->template->content_admin = View::factory('/ferryman/return_price/edit_discount_price',$data);
    }
    
    public function action_del_return_price(){
        DB::delete('routeprice_return_discount')->where('route_name_id','=',$_GET['route_name_id'])->and_where('ferryman_id','=',$_GET['fer_id'])->execute();
        $this->redirect('/ferryman/all_return_price');
    }
    
    public function action_ajax_update_discount_price() {
        
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
                
                $check = DB::select()->from('routeprice_return_discount')
                    ->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->execute()->current();
                if(!empty($check)){
                    DB::update('routeprice_return_discount')->set(array(
                        'price'=>$price
                    ))->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->and_where('ferryman_id','=',$_POST['fer_id'])
                    ->execute();
                }else{
                    DB::insert('routeprice_return_discount',array(
                        'route_name_id',
                        'route_city_from_id',
                        'route_city_to_id',
                        'valute',
                        'price',
                        'route_price_id',
                        'ferryman_id'
                        ))->values(array(
                        $route_id,
                        $citys[0],
                        $citys[1],
                        $_POST['valute'],
                        $price,
                        1,
                        $_POST['fer_id']
                        ))->execute();
                }
            }
            echo 'Update!';    
            die;   
        }
    }
    
     public function action_ajax_get_discount_price() {
        if($_POST) {
            $route_price = DB::select()->from('routeprice_return_discount')->where('route_name_id','=',$_POST['route_name_id'])->and_where('valute','=',$_POST['valute'])->and_where('ferryman_id','=',$_POST['fer'])->order_by('weight','DESC')->execute()->as_array();
            $new = '';
            foreach($route_price as $prise){
                $new .= $prise['route_city_from_id'].'_'.$prise['route_city_to_id'].','.$prise['price'].':'; 
            }
            //echo '<pre>';
            //print_r($route_price);
            //echo '</pre>';
            echo $new;
            die;
        }
        die;
    }
    
} // End Admin
