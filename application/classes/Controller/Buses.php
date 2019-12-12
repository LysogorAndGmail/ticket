<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Buses extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }            
	public function action_index() {  
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        }
        $limit = 30;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }
        $data = array();
        $data['content'] = '';
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($all_ses_fer)){
                $fer = DB::select('buses_id')->from('ferryman')->join('ferryman_buses')->on('ferryman.ferryman_id','=','ferryman_buses.fer_id')->where('ferryman.ferryman_id','in',$all_ses_fer)->execute()->as_array();
                $data['fiarst'] = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')
                ->where('buses.buses_id','in',$fer)
                ->where('culture','=',$lang)->execute()->as_array();
            }
        }else{
            $data['fiarst'] = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('culture','=',$lang)
            ->execute()->as_array();
        }    
        //$this->template->left_sidebar_admin = View::factory('bus/left');
        $this->template->content_admin = View::factory('bus/index',$data);
	}
    
    public function action_ajax_seach_buses(){
        if($_POST){
            $lang = $_POST['lang'];
            $data['all'] = array();
            switch($_POST['input']){
                case'buses_id':
                $data['all'] = Model::factory('BusesMod')->search_bus_id($_POST['search'],$lang);
                break;
                case'buses_i18n':
                $data['all'] = Model::factory('BusesMod')->search_bus_name($_POST['search'],$lang);
                break;
            }
            echo View::factory('bus/search_table',$data);
            //$data['content'] = $con;
            die;
        }
    }
    
    
    public function action_ajax_get_cron_dates(){
        if($_POST){
            //print_r($_POST);
            $all_week = DB::select()->from('cron')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
            echo $all_week['type'];
            die;
        }
    }
    
    
    public function action_see_all() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
         if(!$lang) {
            $lang = 'EN';
         }
         $data['buses'] = array();
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($all_ses_fer)){
                $fer = DB::select()->from('ferryman')->join('ferryman_buses')->on('ferryman.ferryman_id','=','ferryman_buses.fer_id')->where('ferryman.ferryman_id','in',$all_ses_fer)->execute()->as_array();
                //print_r($fer);
            }
        }else{
            //$data['buses'] = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('culture','=',$lang)->order_by('buses.buses_id','DESC')->execute()->as_array();
        }           
        
        //$this->template->left_sidebar_admin = View::factory('/bus/left',$data);
        $this->template->content_admin = View::factory('/bus/see_all',$data);
    }
    
    public function action_see_fer() {  
        $this->chek_permition();  
        $data = array();
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['buses'] = DB::select()->from('buses_i18n')->where('culture','=','ru')->execute()->as_array();
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();  
        $this->template->left_sidebar_admin = View::factory('/bus/left',$data); 
        $this->template->content_admin = View::factory('bus/see_fer',$data);
	}
    
    public function action_ajax_buses(){
        if($_POST){
            $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
         if(!$lang) {
            $lang = 'EN';
         }
            $bus = DB::select()->from('ferryman_buses')->where('fer_id','=',$_POST['id'])->execute()->as_array();
             foreach($bus as $b){
                $bus_name = DB::select()->from('buses_i18n')->where('buses_id','=',$b['buses_id'])->and_where('culture','=',$lang)->execute()->current();
                echo '<option value="'.$b['buses_id'].'">'.$bus_name['name_i18n'].'</option>';
             }
            die;
        }
    }
    
    public function action_ajax_search_buses(){
        if($_POST){
            $al_fer_bus = DB::select('buses_id')->from('ferryman_buses')->where('fer_id','=',$_POST['fer_id'])->execute()->as_array();
            //print_r($al_fer_bus);
            //die;
            $bus_name = DB::select()->from('buses_i18n')->where('name_i18n','LIKE','%'.$_POST['name'].'%')->and_where('culture','=',$_POST['lang'])->execute()->as_array();
            echo '<table class="table table-striped table-fixed-layout table-hover" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>'.__("Title").'</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach($al_fer_bus as $ff){
                $df = DB::select()->from('buses_i18n')->where('buses_id','=',$ff['buses_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                echo '<tr class="green">
                    <td>'.$df["buses_id"].'</td>
                    <td>'.$df["name_i18n"].'</td>
                    <td><input type="checkbox"  name="bus_id[]" checked="checked" value="'.$df["buses_id"].'" /> </td>
                </tr>';
            }
            foreach($bus_name as $b){
                echo '<tr class="">
                    <td>'.$b["buses_id"].'</td>
                    <td>'.$b["name_i18n"].'</td>
                    <td><input type="checkbox" name="bus_id[]" value="'.$b["buses_id"].'" /> </td>
                </tr>';
            }
         echo '</tbody>
        </table>';
            die;
        }
    }
    
    public function action_ajax_buses_chek(){
        if($_POST){
            $bus = DB::select()->from('buses_i18n')->and_where('culture','=','ru')->execute()->as_array();
            $fer = DB::select()->from('ferryman_buses')->where('fer_id','=',$_POST['id'])->execute()->as_array();
             foreach($bus as $b){
                echo '<div><input type="checkbox" name="bus_id[]" value="'.$b['buses_id'].'"';
                 foreach($fer as $f){ if($b['buses_id'] == $f['buses_id']){ 
                    echo 'checked="checked"'; }
                  }
                    echo ' />&nbsp;'.$b['name_i18n'].'</div>';
             }
            die;
        }
    }
    
    public function action_save_buses(){
        $this->chek_permition();
        if($_POST){
            DB::delete('ferryman_buses')->where('fer_id','=',$_POST['fer_id'])->execute();
            foreach($_POST['bus_id'] as $bus){
                DB::insert('ferryman_buses',array('fer_id','buses_id'))->values(array($_POST['fer_id'],$bus))->execute();
            }
            $this->redirect('/buses/see_fer');
        }
    }
    
    public function action_add() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $data = array();
        $all_ses_fer = DB::select('fer_id')->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            if(!empty($all_ses_fer)){
                $data['all_ferrymans'] = DB::select()->from('ferryman')->where('ferryman.ferryman_id','in',$all_ses_fer)->execute()->as_array();
                
            }
        if($_POST){
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            $bus_id = DB::insert('buses',array(
                'buses_type_id',
                'schema_name',
            ))->values(array(
                $_POST['buses_type_id'],
                $_POST['schema_name']
            ))->execute();
            ///ru
            
            ///////////////
            
            DB::insert('ferryman_buses',array('fer_id','buses_id'))->values(array($_POST['ferryman'],$bus_id[0]))->execute();
            //////////////
            
            
            DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $bus_id[0],
                $_POST['name_i18n'],
                $_POST['desc_i18n'],
                'ru'
            ))->execute();
            ///
            ///ua
            DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $bus_id[0],
                $_POST['name_i18n_ua'],
                $_POST['desc_i18n_ua'],
                'ua'
            ))->execute();
            ///
            ///en
            DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $bus_id[0],
                $_POST['name_i18n_en'],
                $_POST['desc_i18n_en'],
                'en'
            ))->execute();
            ///
            ///cs
            DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $bus_id[0],
                $_POST['name_i18n_cs'],
                $_POST['desc_i18n_cs'],
                'cs'
            ))->execute();
            ///
            ///
            //print_r($_POST);
            //die;
            $this->redirect("/buses");
        }
        $all = DB::select()->from('bscheme')->execute()->as_array();
        foreach($all as $a){
            $new_all[$a['schema_name']] = $a;
        }
        $data['all_schema'] = $new_all;
        $start = $all[0]['schema_name'];
        $star_schema = DB::select()->from('bscheme')->where('schema_name','=',$start)->order_by('schema_id','ASC')->execute()->as_array();
          foreach($star_schema as $bb){
                    $aa[$bb['schema_name']][$bb['dx']][$bb['dy']] = $bb;
                }
        $data['start_schema'] =  $aa;
        //die;
        //$this->template->left_sidebar_admin = View::factory('/bus/left',$data);
        $this->template->content_admin = View::factory('/bus/add',$data);
    }
    
    public function action_update_bus() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $data = array();
        $id = $_GET['id'];
        if($_POST){
            $bus_id = DB::update('buses')->set(array(
                'buses_type_id'=>$_POST['buses_type_id'],
                'schema_name'=>$_POST['schema_name']
            ))->where('buses_id','=',$id)->execute();
            ///ru
            DB::update('buses_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n'],
                'description_i18n'=>$_POST['desc_i18n']
            ))->where('buses_id','=',$id)->and_where('culture','=','ru')->execute();
            ///
            $ch_ua = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','ua')->execute()->current();
            ///ua
            if(!empty($ch_ua)){
                DB::update('buses_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_ua'],
                'description_i18n'=>$_POST['desc_i18n_ua']
                ))->where('buses_id','=',$id)->and_where('culture','=','ua')->execute();
            }else{
                DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_ua'],
                $_POST['desc_i18n_ua'],
                'ua'
            ))->execute();
            }
            
            $ch_en = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','en')->execute()->current();
            ///ua
            if(!empty($ch_en)){
                DB::update('buses_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_en'],
                'description_i18n'=>$_POST['desc_i18n_en']
                ))->where('buses_id','=',$id)->and_where('culture','=','en')->execute();
            }else{
                DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_en'],
                $_POST['desc_i18n_en'],
                'en'
            ))->execute();
            }
            
            $ch_cs = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','cs')->execute()->current();
            ///ua
            if(!empty($ch_cs)){
                DB::update('buses_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n_cs'],
                'description_i18n'=>$_POST['desc_i18n_cs']
                ))->where('buses_id','=',$id)->and_where('culture','=','cs')->execute();
            }else{
                DB::insert('buses_i18n',array(
                'buses_id',
                'name_i18n',
                'description_i18n',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_cs'],
                $_POST['desc_i18n_cs'],
                'cs'
            ))->execute();
            }
            //die;
            $this->redirect("/buses");
        }
        $edit_bus = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','ru')->execute()->current();
        $edit_bus_ua = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','ua')->execute()->current();
        $edit_bus_en = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','en')->execute()->current();
        $edit_bus_cs = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$id)->and_where('buses_i18n.culture','=','cs')->execute()->current();
        $data['edit_bus'] = $edit_bus;
        $all = DB::select()->from('bscheme')->execute()->as_array();
            foreach($all as $a){
            $new_all[$a['schema_name']] = $a;
            }
            $data['all_schema'] = $new_all;
        if(empty($edit_bus['schema_name'])){
            $start = $all[0]['schema_name'];
            $star_schema = DB::select()->from('bscheme')->where('schema_name','=',$start)->order_by('schema_id','ASC')->execute()->as_array();
            foreach($star_schema as $bb){
            $aa[$bb['schema_name']][$bb['dx']][$bb['dy']] = $bb;
            }
            $data['start_schema'] =  $aa;
        }else {
            $aa = array();
            $star_schema = DB::select()->from('bscheme')->where('schema_name','=',$edit_bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
            foreach($star_schema as $bb){
            $aa[$bb['schema_name']][$bb['dx']][$bb['dy']] = $bb;
            }
            $data['start_schema'] =  $aa;
        }
        //print_r($edit_bus);
        $data['edit_bus_ua'] = $edit_bus_ua;
        $data['edit_bus_en'] = $edit_bus_en;
        $data['edit_bus_cs'] = $edit_bus_cs;
        
        
        //die;
        //$this->template->left_sidebar_admin = View::factory('/bus/left',$data);
        $this->template->content_admin = View::factory('/bus/edit',$data);
    }
    
    public function action_save_bus_schema() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $data = array();
        $data['lang'] = $lang;
        //$this->template->left_sidebar_admin = View::factory('/bus/left',$data);
        $this->template->content_admin = View::factory('/bus/save_bus_schema',$data);
    }
    
    public function action_ajax_save_schema() {
         //$this->chek_permition();
         if($_POST) {
            //print_r($_POST);
            //die;
            for($i=0;$i<$_POST['rows'];$i++){
                for($ii=0;$ii<$_POST['cols'];$ii++){
                    ///*
                    DB::insert('bscheme',array(
                        'value',
                        'dx',
                        'dy',
                        'schema_name',
                        'description'
                    ))->values(array(
                        $_POST['html'][$i][$ii],
                        $i,
                        $ii,
                        $_POST['name'],
                        $_POST['desc']
                    ))->execute();
                    
                    //*/
                    //print_r($_POST['html'][$i][$ii]);
                    //die;
                } 
            }
            //preg_match_all("!<div(.*?)>(.*?)</div>!si", $_POST['html'], $table);
            //print_r($_POST);
            echo 'Ok';
            die;
         }
    }
    
    public function action_all_schema() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $data = array();
        $data['all_schema'] = DB::select()->from('bscheme')->order_by('schema_id','ASC')->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('/bus/left',$data);
        $this->template->content_admin = View::factory('/bus/all_schema',$data);
    }
    
    public function action_del_schema() {
         $this->chek_permition();
         if($_GET) {
            DB::delete('bscheme')->where('schema_name','=',$_GET['id'])->execute();
            $this->redirect('/buses/all_schema');
         }
    }
    
    public function action_ajax_see_schema() {
         if($_POST) {
              $all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              foreach($all_schema as $all){
                        $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
                    }
              $data = array();
              $data['new_all'] = $new_all;
            echo View::factory('/bus/ajax_schema',$data);      
            die;
         }
    }
    
    public function action_ajax_see_schema_svitgo() {
         if($_POST) {
                //print_r($_POST);
                //die;
               $lang = Session::instance()->get('leng');
                 if(!$lang) {
                    $lang = 'EN';
                 } 
                
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];  
                  
                $chek_parent = DB::select()->from('routename')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
                if(!empty($chek_parent['parent']) && (strtotime($n_d) > strtotime($chek_parent['start_from']))){
                    
                    $_POST['route_name_id'] = $chek_parent['parent'];
                    
                    echo __('Route END');
                    //echo '>';
                    //echo '<br />';
                    //die;
                }
                
                
                
                $date_start = Model::factory('TiketMod')->find_routes_minus_date_model_sell($_POST['route_name_id'],$_POST['from'],$_POST['to'],$n_d);
                //print_r($date_start);
                //die; 
                if(!empty($date_start[1])){
                    $n_d = $date_start[1];
                }
                //echo '<pre>';
                //print_r($date_start);
                //echo '</pre>';
                //die;
                
                
                            
                $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->and_where('rice','=',$_POST['rice'])->execute()->current();
              
              //print_r($main_info);
              //die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              $data = array();
              //$data['new_all'] = $new_all;
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
              
              $data['rice'] = $_POST['rice'];
              
              $data['lang'] = $lang;
              
              //echo 'ok';
              //die;
              
            echo View::factory('/bus/svitgo_schema',$data);      
            die;
         }
    }
    
    public function action_ajax_see_schema_svitgo_modal_transfer() {
         if($_POST) {
                //print_r($_POST);
                $newdate = explode('/',$_POST['date']);
                 
                
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0]; 
                
                               
              
                $main_info = DB::select()->from('routeferrymanweek')
                ->where('route_name_id','=',$_POST['route_name_id'])
                ->and_where('date','=',$n_d)
                ->execute()->current();
                
              //print_r($main_info);
              //die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              $data = array();
              //$data['new_all'] = $new_all;
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
            echo View::factory('/bus/svitgo_schema_modal_transfer',$data);      
            die;
         }
    }
    
    public function action_ajax_see_route_arive() {
         if($_POST) {
                //print_r($_POST);
                         
                
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];
                $n_d_full = $n_d.' 00:00:01';
                
                
                $chek_date_model = Model::factory('TiketMod')->find_routes_minus_date_model($_POST['route_name_id'],$_POST['from'],$_POST['to'],$n_d);
                //echo '<pre>';
                //print_r($chek_date_model);
                //echo '</pre>';
                //die;
                //$newdate = explode('/',$_POST['date']);
                //$n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];
                /*
                if(isset($chek_date_model[0][1]) && !empty($chek_date_model[0][1])){
                    $n_d_full = $chek_date_model[0][1].' 00:00:01';
                    //$n_d = $chek_date_model[0][1];
                }else{
                    $n_d_full = $n_d.' 00:00:01';
                }
                */
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                }   
                
                $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->and_where('rice','=',$_POST['rice'])->execute()->current();
                $city_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
                $city_to = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['to'])->execute()->current();
                $buses = DB::select()->from('buses_i18n')->where('buses_id','=',$main_info['buses_id'])->and_where('culture','=',$_POST['lang'])->execute()->current();
                $time_from = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$city_from['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$_POST['rice'])->execute()->current();
                $time_to = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$city_to['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$_POST['rice'])->execute()->current();
                
                $platform_from = DB::select()->from('platform')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ost_id','=',$_POST['from'])->and_where('day_week','=',$day_week)->execute()->current();
                $platform_to = DB::select()->from('platform')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ost_id','=',$_POST['to'])->and_where('day_week','=',$day_week)->execute()->current();
               
               /////////////new dey
               
                $all_ost = DB::select('r_id','weight')->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('weight','BETWEEN',array($city_from['weight'],$city_to['weight']))->order_by('weight','ASC')->execute()->as_array();
                //echo count($all_ost);
                
                
                
                
                
                $new = array();
                
                foreach($all_ost as $ost){
                    $arive = DB::select('hours','a_hours')->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',$day_week)->and_where('rice','=',$_POST['rice'])->execute()->current();
                    $ost['pribitie'] = $arive['a_hours'];
                    $ost['otpravka'] = $arive['hours'];
                    $ost['pribitie_secund'] = strtotime( '2014-01-01 '.$arive['a_hours'].':00');
                    $ost['otpravka_secund'] = strtotime( '2014-01-01 '.$arive['hours'].':00');
                    //$arive_to = DB::select('a_hours')->from('routeweek')->where('route_name_id','=',1590)->and_where('r_id','=',$ost['r_id'])->and_where('week_id','=',0)->and_where('rice','=',1)->execute()->current();
                    if(!empty($ost['pribitie']) || !empty($ost['otpravka'])){
                        $new[] = $ost;
                    }
                    
                }
                
                if(isset($chek_date_model[0][1]) && !empty($chek_date_model[0][1])){
                    $n_d_full = $chek_date_model[0][1].' 00:00:01';
                    $n_d = $chek_date_model[0][1];
                }
                
                $date_chek_from = strtotime($n_d.$time_from['hours']);
               $date_chek_to = strtotime($n_d.$time_to['a_hours']);
               
               
               
               
               
               $da_end = date('d/m/Y',strtotime($n_d_full));
               $da_end_next = date('d/m/Y',strtotime($n_d_full));
                
                $start = 0;
                $day = 0;
                
                
                for($i = 0; $i<count($new); $i++){
                    $start = $new[$i]['pribitie_secund'];
                    if(isset($new[$i+1]['pribitie_secund'])){
                        $start_next = $new[$i+1]['pribitie_secund'];
                        if($start > $start_next){
                            //echo $n['weight'];
                            $day += 1; 
                        }
                    }
                    
                    //echo $new[$i]['pribitie'].'<br />';
                    //echo $new[$i]['pribitie_secund'].'<br />';
                    //echo $new[$i]['weight'].'<br />';
                }
                
               if($day != 0){
                    $da_end_next = date('d/m/Y',strtotime($n_d. ' + '.$day.' day')); 
               }
               
               
              
              $bus = DB::select()->from('buses')->where('buses_id','=',$main_info['buses_id'])->execute()->current();
              $all_schema = DB::select('value')->from('bscheme')->where('schema_name','=',$bus['schema_name'])->order_by('schema_id','ASC')->execute()->as_array();
              
              $new_schema = array();
              foreach($all_schema as $chem){
                    if(!empty($chem['value']) && $chem['value'] != 'sw'){
                        $new_schema[] = $chem['value'];
                    }
              }
              
              
            
                
                
                  
            $sell_array = Model::factory('TiketMod')->sell_plase($_POST['route_name_id'],$n_d,$main_info['buses_id'],$main_info['ferryman_id'],$_POST['from'],$_POST['to']);
            $sell = array();
            foreach($sell_array as $tes=>$vall){
                $sell[] = $vall['value'];   
            }
            // end sell
            //reserv
            $reserv_array = Model::factory('TiketMod')->reserv_plase($_POST['route_name_id'],$n_d,$main_info['buses_id'],$main_info['ferryman_id'],$_POST['from'],$_POST['to']);
            $reserv = array();
            foreach($reserv_array as $res=>$vll){
                $reserv[] = $vll['value'];   
            } 
            
            
            
                
                
            $new_block_plase = Model::factory('TiketMod')->block_plase($_POST['route_name_id'],$main_info['buses_id'],$main_info['ferryman_id'],$_POST['from'],$_POST['to'],$n_d);
            
            
            $old_disp_bizi = array();
            //$old_disp_bizi = Model::factory('TiketMod')->old_disp($_POST['route_name_id'],$_POST['from'],$_POST['to'],$n_d); 
            
            
            //print_r($new_block_plase);
           // die;
            
            
            foreach($old_disp_bizi as $old_biz){
                if(isset($old_biz) && !empty($old_biz)){
                    array_push($new_block_plase,array('value'=>$old_biz));
                }
                
            }
            
            
            
            
            
            $all_plase_free = count($new_schema)
             - count($sell) 
             - count($reserv) 
             - count($new_block_plase);
            
            
            $biz_plase = count($new_schema) - $all_plase_free;
            //$biz_plase = count($new_schema);
           //echo '<pre>';
           //print_r($new_schema);
           //echo '</pre>';
           //die;
              
              
              $farryman_name = DB::select()->from('ferryman')->where('ferryman_id','=',$main_info['ferryman_id'])->execute()->current();
              echo $buses['name_i18n'].','.$time_from['hours'].' '.$da_end.','.$time_to['a_hours'].' '.$da_end_next.','.$farryman_name['name'].','.$platform_from['value'].','.$platform_to['value'].','.$all_plase_free.','.$biz_plase.','.$main_info['ferryman_id'].','.$da_end.','.$da_end_next;
            die;
         }
    }
    
    public function action_ajax_see_schema_svitgo_return() {
         if($_POST) {
                //print_r($_POST);
               $ses_user = $this->ses_user; 
                
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];                
                
                
                
                
                
                $chek_parent = DB::select()->from('routename')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
                if(!empty($chek_parent['parent']) && (strtotime($n_d) > strtotime($chek_parent['start_from']))){
                    
                    $_POST['route_name_id'] = $chek_parent['parent'];
                    
                    //echo '>';
                    //echo '<br />';
                    //die;
                }
                
                
                $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->execute()->current();
                
               // print_r($main_info);
              //  die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              $data = array();
              //$data['new_all'] = $new_all;
              
              $data['return_discount'] = $ses_user[0]['return_discount'];
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
            echo View::factory('/bus/return_svitgo_schema',$data);      
            die;
         }
    }
    
    public function action_del_bus() {
         $this->chek_permition();
         if($_GET) {
            DB::delete('buses')->where('buses_id','=',$_GET['id'])->execute();
            DB::delete('buses_i18n')->where('buses_id','=',$_GET['id'])->execute();
            $this->redirect('/buses');
         }
    }
    
    public function action_php() {
        phpinfo();
        die;
    }
    
    
    public function action_ajax_get_sell_rice(){
        if($_POST) {
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];
                $n_d_full = $n_d.' 00:00:01';
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                } 
                             
                $all_rice = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->execute()->as_array();
                
                //$all_rice = array_reverse($all_rice);
                //echo '<pre>';
                //print_r($all_rice);
                //echo '</pre>';
                //die;
                $city_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
              $data = array();
              $data['city_from'] = $city_from;
              $data['route_name_id'] = $_POST['route_name_id'];
              $data['all_rice'] = $all_rice;
              $data['day_week'] = $day_week;
              echo View::factory('/bus/ajax_sell_rice',$data);
            die;
         }
    }
    
    public function action_ajax_get_sell_rice_return(){
        if($_POST) {
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];
                $n_d_full = $n_d.' 00:00:01';
                $day = date('w',strtotime($n_d_full));    
                switch($day){
                    case 0:
                    $day_week = 6;
                    break;
                    case 1:
                    $day_week = 0;
                    break;
                    case 2:
                    $day_week = 1;
                    break;
                    case 3:
                    $day_week = 2;
                    break;
                    case 4:
                    $day_week = 3;
                    break;
                    case 5:
                    $day_week = 4;
                    break;
                    case 6:
                    $day_week = 5;
                    break;
                } 
                             
                $all_rice = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->execute()->as_array();
                $all_rice = array_reverse($all_rice);
                
                $city_from = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
              $data = array();
              $data['city_from'] = $city_from;
              $data['route_name_id'] = $_POST['route_name_id'];
              $data['all_rice'] = $all_rice;
              $data['day_week'] = $day_week;
              echo View::factory('/bus/ajax_sell_rice_return',$data);
            die;
         }
    }
    
     public function action_ekipaj() {
        $this->chek_permition();  
        $data = array();
        $data['all'] = DB::select()->from('ekipaj')->execute()->as_array(); 
        $this->template->content_admin = View::factory('bus/ekipaj',$data);      
    }
    
    public function action_add_new_ekipaj() {
        //$this->chek_permition();  
        if($_POST){
            DB::insert('ekipaj',array(
                'name',
                'bus_id',
            ))->values(array(
                $_POST['name'],
                $_POST['bus'],
            ))->execute();
            $this->redirect('/buses/ekipaj');
        }
        $data = array();
        $data['all'] = DB::select()->from('ekipaj')->execute()->as_array();
        $this->template->content_admin = View::factory('bus/add_new_ekipaj',$data);      
    }
    
    public function action_dell_ekipaj() {
         //$this->chek_permition();
         if($_GET) {
            DB::delete('ekipaj')->where('id','=',$_GET['id'])->execute();
            $this->redirect('/buses/ekipaj');
         }
    }
    
    public function action_ekipaj_persons() {
        $this->chek_permition();  
        $data = array();
        $data['all'] = DB::select()->from('ekipaj_persons')->execute()->as_array();
        $this->template->content_admin = View::factory('bus/ekipaj_persons',$data);      
    }
    
    public function action_add_ekipaj_persone() {
        //$this->chek_permition();  
        if($_POST){
            DB::insert('ekipaj_persons',array(
                'name',
                'ekipaj_id',
                'persone_type'
            ))->values(array(
                $_POST['name'],
                $_POST['ekipaj'],
                $_POST['type']
            ))->execute();
            $this->redirect('/buses/ekipaj_persons');
        }
        $data = array();
        $data['all'] = DB::select()->from('ekipaj_persons')->execute()->as_array();
        $this->template->content_admin = View::factory('bus/add_ekipaj_persone',$data);      
    }
    
    public function action_dell_ekipaj_persone() {
         //$this->chek_permition();
         if($_GET) {
            DB::delete('ekipaj_persons')->where('id','=',$_GET['id'])->execute();
            $this->redirect('/buses/ekipaj_persons');
         }
    }
    
    public function action_ajax_get_ekip() {
        //$this->chek_permition();  
        if($_POST){
            $all = DB::select()->from('ekipaj_persons')->where('ekipaj_id','=',$_POST['ekip'])->execute()->as_array();
           $string = '';
           foreach($all as $a){
           $string .= '<p>'.$a['persone_type'].' '.$a['name'].'</p>';
           }
           echo $string;
           die;
        } 
    }
    
    public function action_ajax_see_schema_svitgo_for_search_route() {
         if($_POST) {
            
            $sesuser = Session::instance()->get('ses_user');
            if(isset($sesuser[0])){
                $user_id = $sesuser[0]['id'];
                $ses_valute = $sesuser[0]['default_valute'];
            }else{
                $user_id = 0;
                $ses_valute = 'EUR';
            }
                //print_r($_POST);
                //die;
               $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         } 
                
                //$newdate = explode('/',$_POST['date']);
                $n_d = $_POST['date'];//'20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];                
                $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->and_where('rice','=',$_POST['rice'])->execute()->current();
                

              $data = array();
              //$data['new_all'] = $new_all;
              
              $price_array = Model::factory('TiketMod')->chek_price_model($_POST['route_name_id'],$_POST['from'],$_POST['to'],$ses_valute,$main_info['ferryman_id']);
    
                $price = $price_array[0];
                $valute = $price_array[1];
              
              
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
              $data['rice'] = $_POST['rice'];
              $data['return_discount'] = 1;
              $data['lang'] = $lang;
              $data['price'] = $price;
              
              //echo $price;
              
           if($_POST['wey'] == 1){
                echo View::factory('search_route/svitgo_schema_search_route',$data);      
           }else{
                echo View::factory('search_route/svitgo_schema_search_route_return',$data); 
           }
            
            die;
         }
    }
    
    public function action_bagaj() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        }
        $limit = 30;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }
        $data = array();
        $data['content'] = '';
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select()->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['bagaj'] = DB::select()->from('bagaj')->join('bagaj_i18n')->on('bagaj.id','=','bagaj_i18n.bagaj_id')->where('culture','=',$lang)->and_where('sysuser','=',$ses_user[0]['id'])
            ->execute()->as_array();
        }else{
            $data['bagaj'] = DB::select()->from('bagaj')->join('bagaj_i18n')->on('bagaj.id','=','bagaj_i18n.bagaj_id')->where('culture','=',$lang)
            ->execute()->as_array();
        }    
        //$this->template->left_sidebar_admin = View::factory('bus/left');
        $this->template->content_admin = View::factory('bus/bagaj',$data);
	}
    
    public function action_add_bagaj() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $ses_user = $this->ses_user;
        if($_POST){
            $article = DB::insert('bagaj',array(
                'price',
                'sysuser'
            ))->values(array(
                $_POST['price'],
                $ses_user[0]['id']
            ))->execute();
            
            DB::insert('bagaj_i18n',array(
                    'bagaj_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $article[0],
                    $_POST['title'],
                    'en'
                ))->execute();
            
            $this->redirect('/buses/bagaj');
        }
        //$this->chek_permition();  
        $data = array();
        $this->template->content_admin = View::factory('bus/add_bagaj',$data);
	}
    
    public function action_update_bagaj() {
	    $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        if($_POST){
            
            $chek_lang = Model::factory('BusesMod')->get_bagaj($_GET['id'],$_GET['lang']); if(!empty($chek_lang)){
            
                DB::update('bagaj')->set(array(
                    'price'=>$_POST['price'],
                ))->where('id','=',$_POST['id'])->execute();
                
                DB::update('bagaj_i18n')->set(array(
                    'name_i18n'=>$_POST['title']
                ))->where('bagaj_id','=',$_POST['id'])->and_where('culture','=',$_POST['lang'])->execute();
            
            }else {
                DB::insert('bagaj_i18n',array(
                    'bagaj_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $_POST['id'],
                    $_POST['title'],
                    $_POST['lang']
                ))->execute();
            }
            
            $this->redirect('/buses/bagaj');
        }
        //$this->chek_permition();  
        $data = array();
        $data['edit'] = Model::factory('BusesMod')->get_bagaj($_GET['id'],$_GET['lang']);
        $this->template->content_admin = View::factory('bus/edit_bagaj',$data);
	}
    
    public function action_dell_bagaj() {
        DB::delete('bagaj')->where('id','=',$_GET['id'])->execute();
        DB::delete('bagaj_i18n')->where('bagaj_id','=',$_GET['id'])->execute();
        $this->redirect('/buses/bagaj');
	}
    
     public function action_blocket_plase() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        }
        $limit = 30;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }
        $data = array();
        $data['content'] = '';
        if($ses_user['group_id'] != 1){
            $all_ses_fer = DB::select()->from('system_users_ferryman')->where('sys_id','=',$ses_user[0]['id'])->execute()->as_array();
            $data['bagaj'] = DB::select()->from('bagaj')->join('bagaj_i18n')->on('bagaj.id','=','bagaj_i18n.bagaj_id')->where('culture','=',$lang)->and_where('sysuser','=',$ses_user[0]['id'])
            ->execute()->as_array();
        }else{
            $data['bagaj'] = DB::select()->from('bagaj')->join('bagaj_i18n')->on('bagaj.id','=','bagaj_i18n.bagaj_id')->where('culture','=',$lang)
            ->execute()->as_array();
        }    
        //$this->template->left_sidebar_admin = View::factory('bus/left');
        $this->template->content_admin = View::factory('bus/blocket_plase/index',$data);
	}
    
    public function action_add_blocket_plase() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        }
        $limit = 30;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
        }
        $data = array();
        $data['content'] = '';
        if($ses_user['group_id'] != 1){
            $all_rou = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $new_r = array();
            foreach($all_rou as $r){
                $new_r[] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->and_where('routename.route_name_id','=',$r['route_name_id'])
            ->order_by('routename.route_name_id','DESC')->execute()->current();
            }
            $data['routes'] = $new_r;
        }else{
            $data['routes'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->order_by('routename.route_name_id','DESC')->execute()->as_array();
        }
        $data['from'] = '';
        $data['to'] = ''; 
        //$all_dates = DB::select()->from('routeferrymanweek')->where('route_name_id','=',1590)->and_where('rice','=',1)->execute()->as_array();
        //echo '<pre>';
        //print_r($all_dates);
        //echo '</pre>';   
        //$this->template->left_sidebar_admin = View::factory('bus/left');
        $this->template->content_admin = View::factory('bus/blocket_plase/add_blocket_plase',$data);
	}
    
    public function action_ajax_get_first_ost(){
        if($_POST){
            $first = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight','ASC')->limit(1)->execute()->as_array();
            $last = DB::select()->from('route')->where('route_name_id','=',$_POST['route_name_id'])->order_by('weight','DESC')->limit(1)->execute()->as_array();
            //echo '<pre>';
            //print_r($first);
            //echo '</pre>';
            $str = $first[0]['route_city_id'].','.$last[0]['route_city_id'];
            echo $str;  
            die;
        }
    }
    
        public function action_ajax_blocket_plase_schema_svitgo() {
         if($_POST) {
                //print_r($_POST);
                //die;
               $lang = Session::instance()->get('leng');
                 if(!$lang) {
                    $lang = 'EN';
                 } 
                
                $newdate = explode('/',$_POST['date']);
                $n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];  
                  
                $chek_parent = DB::select()->from('routename')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
                if(!empty($chek_parent['parent']) && (strtotime($n_d) > strtotime($chek_parent['start_from']))){
                    
                    $_POST['route_name_id'] = $chek_parent['parent'];
                    
                    echo __('Route END');
                    //echo '>';
                    //echo '<br />';
                    //die;
                }
                
                
                
                $date_start = Model::factory('TiketMod')->find_routes_minus_date_model_sell($_POST['route_name_id'],$_POST['from'],$_POST['to'],$n_d);
                //print_r($date_start);
                //die; 
                if(!empty($date_start[1])){
                    $n_d = $date_start[1];
                }
                //echo '<pre>';
                //print_r($date_start);
                //echo '</pre>';
                //die;
                
                
                            
                $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->and_where('rice','=',$_POST['rice'])->execute()->current();
              
              //print_r($main_info);
              //die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              $data = array();
              //$data['new_all'] = $new_all;
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
              
              $data['rice'] = $_POST['rice'];
              
              $data['lang'] = $lang;
              
              //echo 'ok';
              //die;
              
            echo View::factory('/bus/blocket_plase/svitgo_schema_one_day',$data);      
            die;
         }
    }
    
    public function action_ajax_blocket_plase_schema_svitgo_week() {
         if($_POST) {
               //print_r($_POST);
               //die;
               $lang = Session::instance()->get('leng');
                 if(!$lang) {
                    $lang = 'EN';
                 } 
                
                
                $naw_date = date('w');
                $n_d = date('Y-m-d');
                
                if($naw_date != $_POST['day_week']){
                    for($i=1; $i<=7; $i++){
                        $date_plus = date('Y-m-d',strtotime("+$i day"));
                        $date_day_week = date('w',strtotime("+$i day"));
                        if($date_day_week == $_POST['day_week']){
                            $n_d = $date_plus;
                        }
                    }
                }
                
                //echo $n_d;
               //die;
                //$newdate = explode('/',$_POST['date']);
                //$n_d = '20'.$newdate[2].'-'.$newdate[1].'-'.$newdate[0];  
                  
                $chek_parent = DB::select()->from('routename')->where('route_name_id','=',$_POST['route_name_id'])->execute()->current();
               
                
               $main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('date','=',$n_d)->and_where('rice','=',$_POST['rice'])->execute()->current();
                            
              //$main_info = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('week_id','=',$_POST['day_week'])->and_where('rice','=',$_POST['rice'])->execute()->current();
              
              //print_r($main_info);
              //die;
              //$all_schema = DB::select()->from('bscheme')->where('schema_name','=',$_POST['name'])->order_by('schema_id','ASC')->execute()->as_array();
              //foreach($all_schema as $all){
              //          $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
              //      }
              $data = array();
              //$data['new_all'] = $new_all;
              $data['info'] = $main_info;
              $data['from'] = $_POST['from'];
              $data['to'] = $_POST['to'];
              
              $data['rice'] = $_POST['rice'];
              
              $data['lang'] = $lang;
              
             // echo 'ok';
             // die;
              
            echo View::factory('/bus/blocket_plase/svitgo_schema_week',$data);      
            die;
         }
    }
    
    public function action_ajax_chek_newblocket_plase(){
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            $data = array();
            
            $all = DB::select()->from('newblocket_plase')
                ->where('route_name_id','=',$_POST['route_name_id'])
                ->and_where('date','=',$_POST['date'])
                ->and_where('buses','=',$_POST['buses'])
                ->and_where('ferryman','=',$_POST['ferryman'])
                ->execute()->as_array();
            $data['all'] = $all;
            echo View::factory('/bus/blocket_plase/ajax_info_one_blocket_plase',$data);
            
            die;
        }
    }
    
    public function action_ajax_chek_newblocket_plase_week(){
        if($_POST){
            
            
            $data = array();
            
            $all = DB::select()->from('newblocket_plase')
                ->where('route_name_id','=',$_POST['route_name_id'])
                ->and_where('week_id','=',$_POST['date'])
                ->and_where('buses','=',$_POST['buses'])
                ->and_where('blocket_type','=','week')
                ->and_where('ferryman','=',$_POST['ferryman'])
                ->execute()->as_array();
            $data['all'] = $all;
            echo View::factory('/bus/blocket_plase/ajax_info_one_blocket_plase_week',$data);
            
            die;
        }
    }
    
    public function action_delete_blocket_plase(){
        if($_GET){
            $all = DB::select()->from('newblocket_plase')->where('bp_id','=',$_GET['id'])->execute()->current();
            
             $block = DB::insert('newblocket_plase_history',array(
                    'route_name_id',
                    'plases',
                    'ferryman',
                    'sysuser_id',
                    'buses_id',
                    'ip',
                    'du'                    
                ))->values(array(
                    $all['route_name_id'],
                    $all['plases'],
                    $all['ferryman'],
                    $this->ses_user[0]['id'],
                    $all['buses'],
                    $_SERVER['REMOTE_ADDR'],
                    'delete'
                ))->execute();  
            
            DB::delete('newblocket_plase')
                ->where('route_name_id','=',$all['route_name_id'])
                ->and_where('week_id','=',$all['week_id'])
                ->and_where('buses','=',$all['buses'])
                ->and_where('plases','=',$all['plases'])
                ->and_where('ferryman','=',$all['ferryman'])
            ->execute();
            $this->redirect('/buses/add_blocket_plase');
        }
    }
    
    
    public function action_ajax_get_route_farrymans(){
        if($_POST){
            
            
            $data = array();
            
            $all = DB::select()->from('routeferrymanweek')
                ->where('route_name_id','=',$_POST['route_name_id'])->order_by('ferryman_id')
                ->execute()->as_array();
                
            $newarray = array();     
            foreach($all as $a){
                $newarray[$a['ferryman_id']] = $a;
            }    
            
            $srt = '<option value=""> - </option>';
            foreach($newarray as $newar){
                $ferryman_name = DB::select()->from('ferryman')->where('ferryman_id','=',$newar['ferryman_id'])->execute()->current();
                $srt .= "<option value='".$newar['ferryman_id']."'>".$ferryman_name['name']."</option>";
            }
            //echo '<pre>';
            //print_r($srt);
            ////echo '</pre>';
            //die;
            echo $srt;
            //echo View::factory('/bus/blocket_plase/ajax_info_one_blocket_plase_week',$data);
            
            die;
        }
    }
    
    public function action_blocket_plase_history() {  
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        $ses_user = $this->ses_user;
        if(!$lang) {
            $lang = 'EN';
        }
        
        $data = array();
        
        if($ses_user['group_id'] != 1){
            $all_routes =  DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            $al_r = array();
            foreach($all_routes as $route){
                 array_push($al_r,$route['route_name_id']);
            }
            //print_r($al_r);
            $data['all'] = DB::select()->from('newblocket_plase_history')->where('route_name_id','in',$al_r)->execute()->as_array();
        }else{
            $data['all'] = DB::select()->from('newblocket_plase_history')->execute()->as_array();
        }    
        //$this->template->left_sidebar_admin = View::factory('bus/left');
        $this->template->content_admin = View::factory('bus/blocket_plase/history',$data);
	}
    
} // End Admin
