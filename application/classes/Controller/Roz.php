<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Roz extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }
                
	public function action_index() {  
        $this->chek_permition();  
        $data = array();
        $data['routes_roz'] = DB::select()->from('add_route_step_1')->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('roz/left_side_simple',$data);
        $this->template->content_admin = View::factory('roz/index',$data);
        
	}
    
    public function action_ajax_ost_join() {
         echo "<script type='text/javascript'>
                 $('.on').click(function(){
                    $('.new_join').val($(this).find('.one_ost').text());
                    $('.ost_id').val($(this).find('.one_ost').data('id'));
                    $('.ost_city').val($(this).find('.one_ost').data('city'));
                    $('#show_ost').html('');
                })
                </script>";
                $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'ru';
        }
        if($_POST) {
            if(strlen($_POST['ost_name']) > 2) {
                $res = DB::select()->from('routecity_i18n')->where('city_i18n','LIKE','%'.$_POST['ost_name'].'%')->and_where('culture','=',$lang)->execute()->as_array();
                foreach($res as $r){
                    if(empty($r['village'])){
                        echo '<div class="on"><span class="one_ost" data-id="'.$r['route_city_id'].'" data-city="'.$r['city_i18n'].'">'.$r['name_i18n'].'</span>  - '.$r['city_i18n'].$r['village'].'  / '.$r['route_city_id'].'</div><br />';
                    }else {
                        echo '<div class="on"><span class="one_ost" data-id="'.$r['route_city_id'].'" data-city="'.$r['city_i18n'].'">'.$r['name_i18n'].'</span>  - село '.$r['village'].'  / '.$r['route_city_id'].'</div><br />';
                    }
                    
                }            
            }
        }
        die;
    }
    
    public function action_ost_join_chak() {
        echo "<script type='text/javascript'>$('.del_svz').click(function(){
            DelSVZ($(this).next('span').text());
            })</script>";
        if($_POST) {
            $res = DB::select()->from('addtypstop_route')->join('addtypstop_svz')->on('addtypstop_route.id','=','addtypstop_svz.svaz_route_id')->where('ost_id_from','=',$_POST['array'][0])->and_where('ost_id_to','=',$_POST['array'][1])->execute()->as_array();
            if(empty($res)){
                $res = DB::select()->from('addtypstop_route')->join('addtypstop_svz')->on('addtypstop_route.id','=','addtypstop_svz.svaz_route_id')->where('ost_id_from','=',$_POST['array'][1])->and_where('ost_id_to','=',$_POST['array'][0])->execute()->as_array();
            }
            if(!empty($res)){
                foreach($res as $sv){
                    echo $sv['text'].' <span class="del_svz" style="color:red;">Удалить</span><span style="display:none;">'.$sv['id'].'</span><br />';
                }
            }else {
                echo 'Связей нет';
            }
        }
        die;
    }
    
    public function action_save_step_2() {
        $this->chek_permition();
        if($_POST) {
            //print_r($_POST);
            //die;
            $weight = DB::select()->from('add_route_step_2')->where('step_1_id','=',$_POST['step_id'])->execute()->as_array();
            $weight = count($weight);
            $res = DB::insert('add_route_step_2',array(
            'step_1_id',
            'ost_id',
            'ost_name',
            'ost_city',
            'weight'
            ))->values(array(
            $_POST['step_id'],
            $_POST['id'],
            $_POST['name'],
            $_POST['city'],
            $weight
            ))->execute();
        }
        die;
    }
    
    public function action_save_weight() {
        $this->chek_permition();
        if($_POST) {
            $html = $_POST['html'];
            preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $html, $prices);
            foreach($prices[0] as $p){
                preg_match_all('!<td(.*?)>(.*?)<span>(.*?)</span>(.*?)</td>!si', $p, $ne);
                $new_ar[] = $ne[3][0]; 
            }
            foreach($new_ar as $i=>$wi){
                DB::update('add_route_step_2')->set(array(
                'weight'=>$i,        
                ))->where('step_1_id','=',$_POST['step_id'])->and_where('ost_id','=',$wi)->execute();
            }
            die;
        }
        die;
    }
    
    
    public function action_del_ost() {
        $this->chek_permition();
        if($_POST) {
            $res = DB::delete('add_route_step_2')->where('step_1_id','=',$_POST['step_id'])->and_where('ost_id','=',$_POST['id'])->execute();
        }
        die;
    }
    
    public function action_ost_join_add() {
        $this->chek_permition();
        if($_POST) {
            $res = DB::select()->from('addtypstop_route')->where('ost_id_from','=',$_POST['array'][0])->and_where('ost_id_to','=',$_POST['array'][1])->execute()->current();
            if(empty($res)){
                $res = DB::select()->from('addtypstop_route')->where('ost_id_from','=',$_POST['array'][1])->and_where('ost_id_to','=',$_POST['array'][0])->execute()->current();
            }
            if(!empty($res)){
                DB::insert('addtypstop_svz',array('svaz_route_id','text'))->values(array($res['id'],$_POST['text']))->execute();
                echo 'ok';
            }else {
                echo 'ошибка';
            }
        }
        die;
    }
    
    public function action_add_route_step_1() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        if($_POST){
        
        if(!empty($_POST['old'])){
            if($_POST['route_type'] == 'gorod'){
                $_POST['route_type'] = $_POST['route_type_sub'];
            }
            
        $block = 0;
        if(isset($_POST['is_validate'])){
            $block = 1;
        }
            
            DB::update('add_route_step_1')->set(array(
                'bloket'=>$block,
                'name'=>$_POST['name'],
                'name_i18n'=>$_POST['name_i18n'],
                'name_i18n_ua'=>$_POST['name_i18n_ua'],
                'name_i18n_en'=>$_POST['name_i18n_en'],
                'name_i18n_cs'=>$_POST['name_i18n_cs'],
                'route_type'=>$_POST['route_type'],
                'country_id'=>$_POST['country_id'],
                'country_id_to'=>$_POST['country_id_to'],
                'time_end'=>$_POST['time_end'],
                ))->where('id','=',$_POST['old'])->execute();
        }else {
          
          
          $block = 0;
        if(isset($_POST['is_validate'])){
            $block = 1;
        }
          
          
          if($_POST['route_type'] == 'gorod'){
            $_POST['route_type'] = $_POST['route_type_sub'];
          }
          $res = DB::insert('add_route_step_1',array(
            'bloket',
            'route_id',
            'name',
            'name_i18n',
            'name_i18n_ua',
            'name_i18n_en',
            'name_i18n_cs',
            'route_type',
            'country_id',
            'country_id_to',
            'time_end'
            ))->values(array(
            $block,
            $_POST['route_id'],
            $_POST['name'],
            $_POST['name_i18n'],
            $_POST['name_i18n_ua'],
            $_POST['name_i18n_en'],
            $_POST['name_i18n_cs'],
            $_POST['route_type'],
            $_POST['country_id'],
            $_POST['country_id_to'],
            $_POST['time_end']
            ))->execute();
            $this->redirect('roz/add_route_step_2?id='.$res[0]);
            } // empty old
        }
        
        $data = array();
        $id = '';
        if($_GET){
            $id = $_GET['id'];
        }
        $data['info'] = 'Добавление нового маршрута';
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['roz_rou'] = DB::select()->from('add_route_step_1')->where('id','=',$id)->execute()->current();
        $last_r = DB::select('route_id')->from('routename')->order_by('route_id','DESC')->limit(1)->execute()->current();
        $last_r_step = DB::select('route_id')->from('add_route_step_1')->order_by('id','DESC')->execute()->current();
        if($last_r_step > $last_r){
            $data['last_rout'] = $last_r_step;
        }else{
            $data['last_rout'] = $last_r; 
        }
        if($id){
            //$this->template->left_sidebar_admin = View::factory('/roz/left_side',$data);
        }else{
            //$this->template->left_sidebar_admin = View::factory('/roz/left_side_simple',$data);
        }
        $this->template->content_admin = View::factory('/roz/add_route_step_1',$data);
       
    }
    
    public function action_add_route_step_2() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $id = $_GET['id'];
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['all_ost'] = DB::select()->from('add_route_step_2')->where('step_1_id','=',$id)->order_by('weight','ASC')->execute()->as_array();
        $data['roz_rou'] = DB::select()->from('add_route_step_1')->where('id','=',$id)->execute()->current();
        //$this->template->left_sidebar_admin = View::factory('/roz/left_side',$data);
        $this->template->content_admin = View::factory('/roz/add_route_step_2',$data);
       
    }
    
    
    public function action_save_step() { /// он же add_route_step_2
        $this->chek_permition();
        if($_POST) {
            
            
            
            $html = $_POST['html'];
            preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $html, $prices);
            $val_arr = $_POST['val'];
            $wee = array_chunk($val_arr, 2);
            $de = array_chunk($wee,7);
            
            
            
            
            foreach($prices[0] as $p){
                preg_match_all('!<td(.*?)>(.*?)</td>!si', $p, $ne);
                preg_match_all('!<span(.*?)>(.*?)</span>!si', $ne[2][0], $id_ars);
                $id_ar[] = $id_ars[2][0];
            }
            
            foreach($id_ar as $i=>$id){
                
            //    echo '<pre>';
            //print_r($val_arr);
            //echo '</pre>';
            //die;
            
                DB::update('add_route_step_2')->set(array(
                'platform'=>$_POST['platform'][$i],
                'po'=>$de[$i][0][0],
                'po_from'=>$de[$i][0][1],
                'vt'=>$de[$i][1][0], 
                'vt_from'=>$de[$i][1][1], 
                'sr'=>$de[$i][2][0], 
                'sr_from'=>$de[$i][2][1], 
                'ch'=>$de[$i][3][0],
                'ch_from'=>$de[$i][3][1],  
                'pi'=>$de[$i][4][0],
                'pi_from'=>$de[$i][4][1],  
                'su'=>$de[$i][5][0],
                'su_from'=>$de[$i][5][1],  
                'vo'=>$de[$i][6][0],
                'vo_from'=>$de[$i][6][1],         
                ))->where('step_1_id','=',$_POST['step_id'])->and_where('ost_id','=',$id)->execute();
                
            }
            //print_r($de[0][0]);
            //die;
        }
        die;
    }
    
    public function action_add_route_step_3() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        $id = $_GET['id'];
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
       $data['all_fer'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')
        ->where('system_users_ferryman.sys_id','=',$ses_user[0]['id'])
        ->execute()->as_array();
        $data['all_ost'] = DB::select()->from('add_route_step_2')->where('step_1_id','=',$id)->order_by('weight','ASC')->execute()->as_array();
        $data['roz_rou'] = DB::select()->from('add_route_step_1')->where('id','=',$id)->execute()->current();
        $data['all_dates'] = DB::select()->from('add_route_step_3')->where('step_1_id','=',$id)->execute()->as_array();
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('/roz/left_side',$data);
        $this->template->content_admin = View::factory('/roz/add_route_step_3',$data);
       
    }
    
    public function action_save_step_3() {
        $this->chek_permition();
        if($_POST) {
            $res = DB::insert('add_route_step_3',array(
                'step_1_id',
                'fer_id',
                'bus_id'
            ))->values(array(
                $_POST['step_id'],
                $_POST['fer_id'],
                $_POST['bus']
            ))->execute();
            
            foreach($_POST['d_arr'] as $d){
                DB::insert('add_route_step_4',array(
                    'step_1_id',
                    'step_3_id',
                    'fer_id',
                    'date'
                ))->values(array(
                    $_POST['step_id'],
                    $res[0],
                    $_POST['fer_id'],
                    $d
                ))->execute();
            }
            echo 'ok';
            die;
        }
        die;
    }
    
    public function action_del_step_3(){
        $this->chek_permition();
        DB::delete('add_route_step_3')->where('step_1_id','=',$_GET['step_id'])->and_where('fer_id','=',$_GET['fer_id'])->execute();
        DB::delete('add_route_step_4')->where('step_1_id','=',$_GET['step_id'])->and_where('fer_id','=',$_GET['fer_id'])->execute();
        $this->redirect('roz/add_route_step_3?id='.$_GET['step_id']);
    }
    
    public function action_del_route_step(){
        $this->chek_permition();
        DB::delete('add_route_step_1')->where('id','=',$_GET['id'])->execute();
        DB::delete('add_route_step_2')->where('step_1_id','=',$_GET['id'])->execute();
        DB::delete('add_route_step_3')->where('step_1_id','=',$_GET['id'])->execute();
        DB::delete('add_route_step_4')->where('step_1_id','=',$_GET['id'])->execute();
        DB::delete('add_route_step_5')->where('step_1_id','=',$_GET['id'])->execute();
        $this->redirect('roz');
    }
    
    public function action_add_route_step_4() {
        $this->chek_permition();
        $id = $_GET['id'];
        
        if($_POST){
            
            $valute = $_POST['valute'];
            array_shift($_POST);
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            $new_ar = $_POST;
            foreach($new_ar as $i=>$ne){
                $new_i = explode('_',$i);
                $new_i['val'] = $ne;
                $n[] = $new_i;
            }
            foreach($n as $v){
                $res = DB::insert('add_route_step_5',array(
                    'step_1_id',
                    'ost_id_from',
                    'ost_id_to',
                    'price',
                    'valute',
                ))->values(array(
                    $id,
                    $v[0],
                    $v[1],
                    $v['val'],
                    $valute,
                ))->execute();
            
            }
            $this->redirect('roz/add_route_step_4?id='.$id);
        }
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['all_ost'] = DB::select()->from('add_route_step_2')->where('step_1_id','=',$id)->order_by('weight','ASC')->execute()->as_array();
        $data['all_ost_back'] = DB::select()->from('add_route_step_2')->where('step_1_id','=',$id)->order_by('weight','DESC')->execute()->as_array();
        $data['roz_rou'] = DB::select()->from('add_route_step_1')->where('id','=',$id)->execute()->current();
        $data['all_dates'] = DB::select()->from('add_route_step_3')->where('step_1_id','=',$id)->execute()->as_array();
        $data['valutes'] = DB::select()->from('country')->execute()->as_array();
        $data['sel_val'] = DB::select()->from('add_route_step_5')->where('step_1_id','=',$id)->execute()->as_array();
        //print_r($data['sel_val']);
        //$this->template->left_sidebar_admin = View::factory('/roz/left_side',$data);
        $this->template->content_admin = View::factory('/roz/add_route_step_4',$data);
       
    }
    
        public function action_save_route_db() {
        $this->chek_permition();
        if($_POST){
            $step_id = $_POST['step_1_id'];

            ///*
            $sp1 = DB::select()->from('add_route_step_1')->where('id','=',$step_id)->execute()->current();
            //print_r($sp1);
            //die;
            ///*
            $res1 = DB::insert('routename',array(
                'country_main_id',
                'route_id',
                'name',
                //'created',
                //'lifetime',
                'is_public',
                'is_public_country_id',
                'is_public_country_to_id',
                'life',
                'period',
                'subtypes',
                'types',
                'site_id'
            ))->values(array(
                $sp1['country_id'],
                $sp1['route_id'],
                $sp1['name'],
                //date('Y-m-d h:i:s'),
                //date('Y-m-d h:i:s'),
                1,
                $sp1['country_id'],
                $sp1['country_id_to'],
                2,
                3,
                0,
                $sp1['route_type'],
                1
            ))->execute();
            
            $res2 = DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'ru',
                $sp1['name_i18n']
            ))->execute(); 
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'ua',
                $sp1['name_i18n_ua']
            ))->execute();
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'en',
                $sp1['name_i18n_en']
            ))->execute();
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'cs',
                $sp1['name_i18n_cs']
            ))->execute();
            
            //print_r($_POST['cou']);
            //die;
            /*
            if($sp1['country_id'] != $sp1['country_id_to']){
                DB::insert('routecountry',array(
                    'route_id',
                    'country_id',
                    'weight',
                    'route_type_id'
                ))->values(array(
                    $sp1['route_id'],
                    $sp1['country_id'],
                    1,
                    1
                ))->execute();
 
                DB::insert('routecountry',array(
                    'route_id',
                    'country_id',
                    'weight',
                    'route_type_id'
                ))->values(array(
                    $sp1['route_id'],
                    $sp1['country_id_to'],
                    2,
                    1
                ))->execute();
               
            }else{
                
                DB::insert('routecountry',array(
                    'route_id',
                    'country_id',
                    'weight',
                    'route_type_id'
                ))->values(array(
                    $sp1['route_id'],
                    $sp1['country_id'],
                    1,
                    1
                ))->execute();
            }
            */
            
            $sp2 = DB::select()->from('add_route_step_2')->where('step_1_id','=',$step_id)->execute()->as_array();
            //echo '<pre>';
            //print_r($sp2);
            //echo '</pre>';
            //die;
            
            foreach($sp2 as $s2){
                
                $res4 = DB::insert('route',array(
                'route_id',
                'route_name_id',
                'country_id',
                'route_city_id',
                'created',
                'weight',
                'hidden',
                'weight_main',
                'route_type_id'
                ))->values(array(
                $sp1['route_id'],
                $res1[0],
                $sp1['country_id'],
                $s2['ost_id'],
                date('Y-m-d h:i:s'),
                $s2['weight'],
                0,
                1,
                1
                ))->execute();
                
                $s2['po'] = trim($s2['po']);
                $s2['po_from'] = trim($s2['po_from']);
                $s2['vt'] = trim($s2['vt']);
                $s2['vt_from'] = trim($s2['vt_from']);
                $s2['sr'] = trim($s2['sr']);
                $s2['sr_from'] = trim($s2['sr_from']);
                $s2['ch'] = trim($s2['ch']);
                $s2['ch_from'] = trim($s2['ch_from']);
                $s2['pi'] = trim($s2['pi']);
                $s2['pi_from'] = trim($s2['pi_from']);
                $s2['su'] = trim($s2['su']);
                $s2['su_from'] = trim($s2['su_from']);
                $s2['vo'] = trim($s2['vo']);
                $s2['vo_from'] = trim($s2['vo_from']);
                
                
                
                if(empty($s2['po'])){
                    $s2['po'] = null;
                }
                if(empty($s2['po_from'])){
                    $s2['po_from'] = null;
                }
                if(empty($s2['vt'])){
                    $s2['vt'] = null;
                }
                if(empty($s2['vt_from'])){
                    $s2['vt_from'] = null;
                }
                if(empty($s2['sr'])){
                    $s2['sr'] = null;
                }
                if(empty($s2['sr_from'])){
                    $s2['sr_from'] = null;
                }
                if(empty($s2['ch'])){
                    $s2['ch'] = null;
                }
                if(empty($s2['ch_from'])){
                    $s2['ch_from'] = null;
                }
                if(empty($s2['pi'])){
                    $s2['pi'] = null;
                }
                if(empty($s2['pi_from'])){
                    $s2['pi_from'] = null;
                }
                if(empty($s2['su'])){
                    $s2['su'] = null;
                }
                if(empty($s2['su_from'])){
                    $s2['su_from'] = null;
                }
                if(empty($s2['vo'])){
                    $s2['vo'] = null;
                }
                if(empty($s2['vo_from'])){
                    $s2['vo_from'] = null;
                }
                
                /////// week_id = 0
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                0,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['po_from'],
                $s2['po_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['po'],
                $s2['po'],
                ))->execute();
                ///////// end week_id = 0 
                
                /////// week_id = 1
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                1,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['vt_from'],
                $s2['vt_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['vt'],
                $s2['vt'],
                ))->execute();
                ///////// end week_id = 1 
                /////// week_id = 2
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                2,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['sr_from'],
                $s2['sr_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['sr'],
                $s2['sr'],
                ))->execute();
                ///////// end week_id = 2 
                
                /////// week_id = 3
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                3,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['ch_from'],
                $s2['ch_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['ch'],
                $s2['ch'],
                ))->execute();
                ///////// end week_id = 3 
                
                /////// week_id = 4
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                4,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['pi_from'],
                $s2['pi_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['pi'],
                $s2['pi'],
                ))->execute();
                ///////// end week_id = 4 
                
                /////// week_id =5
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                5,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['su_from'],
                $s2['su_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['su'],
                $s2['su'],
                ))->execute();
                ///////// end week_id = 5
                
                /////// week_id = 6
                $res5 = DB::insert('routeweek',array(
                'week_id',
                'name',
                'r_id',
                'country_id',
                'country_to_id',
                'hours',
                'time',
                'created',
                'days',
                'hidden',
                'route_id',
                'route_name_id',
                'a_hours',
                'a_time'
                ))->values(array(
                6,
                $sp1['name'],
                $res4[0],
                $sp1['country_id'],
                $sp1['country_id_to'],
                $s2['vo_from'],
                $s2['vo_from'],
                date('Y-m-d h:i:s'),
                0,
                0,
                $sp1['route_id'],
                $res1[0],
                $s2['vo'],
                $s2['vo'],
                ))->execute();
                ///////// end week_id = 6  
                
                $platform = DB::insert('routedistance',array(
                'r_id',
                'route_type_id',
                'route_name_id',
                'platform'
                ))->values(array(
                $res4[0],
                1,
                $res1[0], // мы всавляем route_name_id
                $s2['platform']
                ))->execute(); 
                //echo '<pre>';
                //print_r($sp2);
                //echo '</pre>';
                //die;
                } //end foreach 
                
                $sp3 = DB::select()->from('add_route_step_3')->where('step_1_id','=',$step_id)->execute()->as_array();
                
                foreach($sp3 as $s3){
                    $all_dates = DB::select()->from('add_route_step_4')->where('step_3_id','=',$s3['id'])->execute()->as_array();
                    foreach($all_dates as $d){
                        $platform = DB::insert('routeferrymanweek',array(
                            'route_name_id',
                            'r_id',
                            'date',
                            'route_id',
                            'ferryman_id',
                            'buses_id',
                            'route_type_id'
                            ))->values(array(
                            $res1[0],
                            $res1[0],
                            $d['date'],
                            $sp1['route_id'],
                            $s3['fer_id'],
                            $s3['bus_id'],
                            $sp1['route_type']
                            ))->execute();
                    }
                }
                
                //*/
                
                $sp5 = DB::select()->from('add_route_step_5')->where('step_1_id','=',$step_id)->execute()->as_array();
                foreach($sp5 as $s5){
                    $valute = $s5['valute']; // EUR
                    if($valute == 'EUR'){
                        $valute = 3;
                    }
                    if($valute == 'ГРН'){
                        $valute = 1;
                    }
                    if($valute == 'CZK'){
                        $valute = 2;
                    }
                    DB::insert('routeprice',array(
                            'route_name_id',
                            'route_city_from_id',
                            'route_city_to_id',
                            'route_valute_id',
                            'price',
                            //'route_name_id',
                            'route_price_id'
                            ))->values(array(
                            $res1[0],
                            $s5['ost_id_from'],
                            $s5['ost_id_to'],
                            $valute,
                            $s5['price'],
                            //$res1[0],
                            1
                            ))->execute();
                } 
                
                $ses_user = Session::instance()->get('ses_user');
                
                DB::insert('system_users_routes',array(
                    'sysuser_id',
                    'route_name_id',
                ))->values(array(
                    $ses_user[0]['id'],
                    $res1[0],
                ))->execute();
                
                $this->redirect('/roz/del_route_step?id='.$step_id);
            } // end post
    }
    
    public function action_auto_new() {
        $this->chek_permition();
        if($_GET) {      
            $param = $this->uperr($_GET['name_startsWith']);
            $lang = $_GET['lang'];
            $limit = 18;
            //die;
            $res = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE city_i18n REGEXP '^$param' AND culture = '$lang' ORDER BY city_i18n LIMIT $limit")->execute()->as_array();
            $serch = array();
            $al_ci = array();
            foreach($res as $r){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                //array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                $al_ci[$r['city_i18n']] = $r['city_i18n'];              
            }
            $i = 0; foreach($al_ci as $ci){
                //$all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                $al_t = 'все остановки';
                if($lang == 'en'){
                    $al_t = 'All stations';
                }
                if($lang == 'cs'){
                    $al_t = 'Všechny zastávky';
                }
                if($lang == 'ua'){
                    $al_t = 'Всі зупинки';
                }
                array_push($serch, array('name'=>$al_t,'city'=>$ci,'id'=>$ci,'type'=>'city'));               
            $i++;}
            
            foreach($res as $r){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r['name_i18n'],'city'=>$r['city_i18n'],'id'=>$r['route_city_id'],'type'=>$all_types['type_id'])); 
                //$al_ci[$r['city_i18n']] = $r['city_i18n'];              
            }
            $res_name = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE name_i18n REGEXP '^$param' AND culture = '$lang'  ORDER BY name_i18n LIMIT $limit")->execute()->as_array();
            foreach($res_name as $r_name){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r_name['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r_name['name_i18n'],'city'=>$r_name['city_i18n'],'id'=>$r_name['route_city_id'],'type'=>$all_types['type_id']));               
            }
            $res_vil = DB::query(Database::SELECT, "SELECT * FROM routecity_i18n WHERE village REGEXP '^$param' AND culture = '$lang' ORDER BY village LIMIT $limit")->execute()->as_array();
            foreach($res_vil as $r_vil){
                $all_types  = DB::select('type_id')->from('ost_types')->where('route_city_id','=',$r_vil['route_city_id'])->execute()->current();
                if(empty($r['name_i18n'])){
                    if($all_types['type_id'] == 1){
                        $r['name_i18n'] = 'AC';
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Bus station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'AS';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'АВ';
                    }
                    }else{
                        $r['name_i18n'] = 'Железнодорожный вокзал'; 
                    if($lang == 'en'){
                        $r['name_i18n'] = 'Train station';
                    }
                    if($lang == 'cs'){
                        $r['name_i18n'] = 'Vlakové nádraží';
                    }
                    if($lang == 'ua'){
                        $r['name_i18n'] = 'Железнодорожный вокзал';
                    }
                    }
                }
                array_push($serch, array('name'=>$r_vil['name_i18n'],'city'=>$r_vil['village'],'id'=>$r_vil['route_city_id'],'type'=>$all_types['type_id']));               
            }
            
            echo json_encode($serch);
            die; 
        }
        die;
    }  
    
    public function uperr($word) {
        
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');

    }
    
    public function action_ajax_fer_dates(){
        if($_POST){
            $all_days = DB::select()->from('add_route_step_4')->where('step_1_id','=',$_POST['route_name_id'])->and_where('fer_id','=',$_POST['id'])->execute()->as_array();
            foreach($all_days as $d){
                if($_POST['day'] == $d['date']){
                echo $d['date'];
                die;
                }
            }
        }
    }
    
    
    public function action_add_parent(){
        $this->chek_permition();
        $old_id = $_GET['route_name_id'];
            
        $old_route_name = DB::select()->from('routename')->where('route_name_id','=',$old_id)->execute()->current();
        
        $new_route_name = DB::insert('routename',array(
            'country_main_id',
            'route_id',
            'name',
            'is_public',
            'is_public_country_id',
            'is_public_country_to_id',
            'life',
            'period',
            'subtypes',
            'types',
            'site_id',
            'child'
        ))->values(array(
            $old_route_name['country_main_id'],
            $old_route_name['route_id'],
            $old_route_name['name'],
            1,
            $old_route_name['is_public_country_id'],
            $old_route_name['is_public_country_to_id'],
            2,
            3,
            0,
            $old_route_name['types'],
            1,
            1
        ))->execute();
        
        DB::update('routename')->set(array(
                'parent'=>$new_route_name[0],
                ))->where('route_name_id','=',$old_id)->execute();
            
        $new_route_i18n_ru = DB::select()->from('routename_i18n')->where('route_name_id','=',$old_id)->and_where('culture','=','ru')->execute()->current();
        $res2 = DB::insert('routename_i18n',array(
            'route_name_id',
            'culture',
            'name_i18n'
        ))->values(array(
            $new_route_name[0],
            'ru',
            $new_route_i18n_ru['name_i18n']
        ))->execute(); 
        
        $new_route_i18n_uk = DB::select()->from('routename_i18n')->where('route_name_id','=',$old_id)->and_where('culture','=','ua')->execute()->current();
        DB::insert('routename_i18n',array(
            'route_name_id',
            'culture',
            'name_i18n'
        ))->values(array(
            $new_route_name[0],
            'ua',
            $new_route_i18n_uk['name_i18n']
        ))->execute();
        
        $new_route_i18n_en = DB::select()->from('routename_i18n')->where('route_name_id','=',$old_id)->and_where('culture','=','en')->execute()->current();
        DB::insert('routename_i18n',array(
            'route_name_id',
            'culture',
            'name_i18n'
        ))->values(array(
            $new_route_name[0],
            'en',
            $new_route_i18n_en['name_i18n']
        ))->execute();
            
            
        $new_route_i18n_cs = DB::select()->from('routename_i18n')->where('route_name_id','=',$old_id)->and_where('culture','=','cs')->execute()->current();
        DB::insert('routename_i18n',array(
            'route_name_id',
            'culture',
            'name_i18n'
        ))->values(array(
            $new_route_name[0],
            'cs',
            $new_route_i18n_cs['name_i18n']
        ))->execute();
           
            
         
        $old_route = DB::select()->from('route')->where('route_name_id','=',$old_id)->execute()->as_array();
        
        foreach($old_route as $s2){
            
            $res4 = DB::insert('route',array(
            'route_id',
            'route_name_id',
            'country_id',
            'route_city_id',
            'created',
            'weight',
            'hidden',
            'weight_main',
            'route_type_id'
            ))->values(array(
            $s2['route_id'],
            $new_route_name[0],
            $s2['country_id'],
            $s2['route_city_id'],
            date('Y-m-d h:i:s'),
            $s2['weight'],
            0,
            1,
            1
            ))->execute();
            
        }   
        
        // all расписания
        
        

        $old_route = DB::select()->from('route')->where('route_name_id','=',$old_id)->order_by('weight')->execute()->as_array();
        
        $new_id = $new_route_name[0];
        $new_route = DB::select()->from('route')->where('route_name_id','=',$new_id)->order_by('weight')->execute()->as_array();
        
        /*
        echo '<pre>';
        print_r($old_route);
        echo '</pre>';  
        
        echo '<pre>';
        print_r($new_route);
        echo '</pre>';  
        */
        $i = 0;
        foreach($old_route as $old){
            //echo '<pre>';
            
            
            $all_route_week = DB::select()->from('routeweek')->where('r_id','=',$old['r_id'])->order_by('week_id')->execute()->as_array();
            foreach($all_route_week as $old_wek){
                DB::insert('routeweek',array(
                    'week_id',
                    'name',
                    'r_id',
                    'country_id',
                    'country_to_id',
                    'hours',
                    'time',
                    'created',
                    'days',
                    'hidden',
                    'rice',
                    'route_id',
                    'route_name_id',
                    'a_hours',
                    'a_time'
                ))->values(array(
                    $old_wek['week_id'],
                    $old_wek['name'],
                    $new_route[$i]['r_id'],
                    $old_wek['country_id'],
                    $old_wek['country_to_id'],
                    $old_wek['hours'],
                    $old_wek['time'],
                    date('Y-m-d h:i:s'),
                    $old_wek['days'],
                    $old_wek['hidden'],
                    $old_wek['rice'],
                    $old_wek['route_id'],
                    $new_id,
                    $old_wek['a_hours'],
                    $old_wek['a_time']
                ))->execute();
            }
           // print_r($all_route_week);
            
           // print_r($new_route[$i]);
          //  echo '</pre>'; 
            $i++;
        }
        
        
        
        
        $ses_user = $this->ses_user;
        
        DB::insert('system_users_routes',array(
            'sysuser_id',
            'route_name_id',
        ))->values(array(
            $ses_user[0]['id'],
            $new_route_name[0],
        ))->execute();
        
        DB::insert('system_users_edit_routes',array(
            'user_id',
            'route_name_id',
        ))->values(array(
            $ses_user[0]['id'],
            $new_route_name[0],
        ))->execute();
        
        
        
        
        
        
        $this->redirect("/route/save_start_date?route_name_id=".$old_id);  
        //echo '<pre>';
        //print_r($old_route);
        //echo '</pre>';
        //die;     
        //////////////////////////////////
        //print_r($old_id);
        //die;
        
    }
    
    public function action_add_route_step_1_new() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        if($_POST){
        
        
        if(!empty($_POST['time_end'])){
            $date = array_reverse(explode('/', $_POST['time_end']));
            $_POST['time_end'] = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
          }
        
        
        
        if(!empty($_POST['old'])){
            if($_POST['route_type'] == 'gorod'){
                $_POST['route_type'] = $_POST['route_type_sub'];
            }
            
        $block = 0;
        if(isset($_POST['is_validate'])){
            $block = 1;
        }
            
            DB::update('add_route_step_1')->set(array(
                'bloket'=>$block,
                'name'=>$_POST['name'],
                'name_i18n'=>$_POST['name_i18n'],
                'name_i18n_ua'=>$_POST['name_i18n_ua'],
                'name_i18n_en'=>$_POST['name_i18n_en'],
                'name_i18n_cs'=>$_POST['name_i18n_cs'],
                'route_type'=>$_POST['route_type'],
                'country_id'=>$_POST['country_id'],
                'country_id_to'=>$_POST['country_id_to'],
                'time_end'=>$_POST['time_end'],
                ))->where('id','=',$_POST['old'])->execute();
        }else {
          
          
          $block = 0;
        if(isset($_POST['is_validate'])){
            $block = 1;
        }
          
          
          if($_POST['route_type'] == 'gorod'){
            $_POST['route_type'] = $_POST['route_type_sub'];
          }
          $res = DB::insert('add_route_step_1',array(
            'bloket',
            'route_id',
            'name',
            'name_i18n',
            'name_i18n_ua',
            'name_i18n_en',
            'name_i18n_cs',
            'route_type',
            'country_id',
            'country_id_to',
            'time_end'
            ))->values(array(
            $block,
            $_POST['route_id'],
            $_POST['name'],
            $_POST['name_i18n'],
            $_POST['name_i18n_ua'],
            $_POST['name_i18n_en'],
            $_POST['name_i18n_cs'],
            $_POST['route_type'],
            $_POST['country_id'],
            $_POST['country_id_to'],
            $_POST['time_end']
            ))->execute();
            
            $this->redirect('roz/save_route_db_new?id='.$res[0]);
            echo '</pre>';
            print_r($_POST);
            echo '</pre>';
            die;
            
            
            } // empty old
        }
        $data = array();
        $this->template->content_admin = View::factory('/roz/add_route_step_1',$data);
       
    }
    
    
    
    public function action_save_route_db_new() {
        $this->chek_permition();
        if($_GET){
            $step_id = $_GET['id'];

            ///*
            $sp1 = DB::select()->from('add_route_step_1')->where('id','=',$step_id)->execute()->current();
            //print_r($sp1);
            //die;
            ///*
            $res1 = DB::insert('routename',array(
                'country_main_id',
                'route_id',
                'name',
                'start_from',
                //'created',
                //'lifetime',
                'is_public',
                'is_public_country_id',
                'is_public_country_to_id',
                'life',
                'period',
                'subtypes',
                'types',
                'site_id'
            ))->values(array(
                $sp1['country_id'],
                $sp1['route_id'],
                $sp1['name'],
                $sp1['time_end'],
                //date('Y-m-d h:i:s'),
                //date('Y-m-d h:i:s'),
                1,
                $sp1['country_id'],
                $sp1['country_id_to'],
                2,
                3,
                0,
                $sp1['route_type'],
                1
            ))->execute();
            
            $res2 = DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'ru',
                $sp1['name_i18n']
            ))->execute(); 
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'uk',
                $sp1['name_i18n_ua']
            ))->execute();
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'en',
                $sp1['name_i18n_en']
            ))->execute();
            
            DB::insert('routename_i18n',array(
                'route_name_id',
                'culture',
                'name_i18n'
            ))->values(array(
                $res1[0],
                'cs',
                $sp1['name_i18n_cs']
            ))->execute();
            

                $ses_user = Session::instance()->get('ses_user');
                
                DB::insert('system_users_routes',array(
                    'sysuser_id',
                    'route_name_id',
                ))->values(array(
                    $ses_user[0]['id'],
                    $res1[0],
                ))->execute();
                
                DB::insert('system_users_edit_routes',array(
                    'user_id',
                    'route_name_id',
                ))->values(array(
                    $ses_user[0]['id'],
                    $res1[0],
                ))->execute();
                
                $this->redirect('/roz/del_route_step?id='.$step_id);
            } // end post
    }
    
} // End Admin
