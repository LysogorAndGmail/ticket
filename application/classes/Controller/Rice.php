<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Rice extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }
    
    public function action_add_rice() {  
        $this->chek_permition(); 
        $id = $_GET['route_name_id'];
        if($_POST){
            
            
        }
        $mod = Model::factory('OstMod');
        $data = array();
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['name_i18n_ua'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
        $data['name_i18n_en'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
        $data['name_i18n_cs'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=','ru')->execute()->as_array();
        $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$id)->order_by('weight')->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('rice/left_for_sort');
        $this->template->content_admin = View::factory('rice/add_rice_1',$data);
	}
    
    public function action_add_rice2() {  
        $this->chek_permition(); 
        $id = $_GET['route_name_id'];
        if($_POST){
            
            
        }
        $mod = Model::factory('OstMod');
        $data = array();
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['all_dates'] = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$id)->execute()->as_array();
        //print_r($data['all_dates']);
        //die;
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('rice/left_for_sort');
        $this->template->content_admin = View::factory('rice/add_rice_2',$data);
	}
    
     public function action_add_rice1() {
        $this->chek_permition();
        if($_POST) {
            
            
            $cou_arr = array(); 
            
            $html = $_POST['html'];
            preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $html, $prices);
            $val_arr = $_POST['val'];
            $wee = array_chunk($val_arr, 2);
            $de = array_chunk($wee,7);
            
            foreach($prices[0] as $p){
                preg_match_all('!<td(.*?)>(.*?)</td>!si', $p, $ne);
                preg_match_all('!<span(.*?)>(.*?)</span>!si', $ne[2][0], $id_ars);
                $r_id = DB::select('r_id')->from('route')->where('route_name_id','=',$_POST['step_id'])->and_where('route_city_id','=',$id_ars[2][0])->execute()->current();
                $id_ar[] = $r_id['r_id'];
            }
            
            $ro = DB::select()->from('routename')->where('route_name_id','=',$_POST['step_id'])->execute()->current();
            
            foreach($de as $onei => $one_ost){
                foreach($one_ost as $deyi=>$dey){
                    if(empty($dey[1])){
                        $dey[1] = null;
                    }
                    if(empty($dey[0])){
                        $dey[0] = null;
                    }
                    //echo '<pre>';
                    //print_r($id_ar[$onei]);
                    //print_r($dey[0]);
                    //echo '</pre>';
                    //die;
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
                        $deyi,
                        $ro['name'],
                        $id_ar[$onei],
                        1,
                        1,
                        $dey[1],
                        $dey[1],
                        date('Y-m-d h:i:s'),
                        0,
                        0,
                        $_POST['rice'],
                        $ro['route_id'],
                        $ro['route_name_id'],
                        $dey[0],
                        $dey[0],
                    ))->execute();
                    
                    $cou_arr[] = 1;
                }
                
            }
            echo '<pre>';
            echo print_r($cou_arr);
            echo '</pre>';
            die;
        }
    }
    
    public function action_add_rice_ajax_2() {
        
        if($_POST) {            
            //print_r($_POST);
            //die;
            foreach($_POST['d_arr'] as $d){
                DB::insert('routeferrymanweek',array(
                    'route_name_id',
                    'ferryman_id',
                    'date',
                    'buses_id',
                    'rice',
                    'is_public'
                ))->values(array(
                    $_POST['step_id'],
                    $_POST['fer_id'],
                    $d,
                    $_POST['bus'],
                    $_POST['rice'],
                    1
                ))->execute();
            }
            //echo 'ok';
            die;
        }
        die;
    }
    
    public function action_delete_rice(){
        $this->chek_permition();
        if($_GET){
            DB::delete('routeweek')->where('route_name_id','=',$_GET['route_name_id'])->and_where('rice','=',$_GET['rice'])->execute();
            DB::delete('routeferrymanweek')->where('route_name_id','=',$_GET['route_name_id'])->and_where('rice','=',$_GET['rice'])->execute();
            $this->redirect('/route');
        }
    }
    
    public function action_see() {  
        $this->chek_permition(); 
        $id = $_GET['route_name_id'];
        $mod = Model::factory('OstMod');
        $data = array();
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['name_i18n_ua'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
        $data['name_i18n_en'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
        $data['name_i18n_cs'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=','ru')->execute()->as_array();
        $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$id)->order_by('weight')->execute()->as_array();
        $this->template->left_sidebar_admin = View::factory('rice/left_for_see');
        $this->template->content_admin = View::factory('rice/see1',$data);
	}
    
    public function action_see2() {  
        $this->chek_permition(); 
        $id = $_GET['route_name_id'];
        $mod = Model::factory('OstMod');
        $data = array();
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['all_dates'] = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$id)->and_where('rice','=',$_GET['rice'])->execute()->as_array();
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();
        $this->template->left_sidebar_admin = View::factory('rice/left_for_see');
        $this->template->content_admin = View::factory('rice/see2',$data);
	}
    
    public function action_fer_dates(){
        $this->chek_permition();
        if($_POST){
            $all_days = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ferryman_id','=',$_POST['id'])->and_where('rice','=',$_POST['rice'])->execute()->as_array();
            foreach($all_days as $d){
                if($_POST['day'] == $d['date']){
                echo $d['date'];
                die;
                }
            }
        }
    }
    
    public function action_ajax_update_rice1() {
        //$this->chek_permition();
        if($_POST) {
            
            
            
            DB::delete('routeweek')->where('route_name_id','=',$_POST['step_id'])->and_where('rice','=',$_POST['rice'])->execute();
            
           
            
            $cou_arr = array(); 
            
            $html = $_POST['html'];
            preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $html, $prices);
            
            
            $val_arr = $_POST['val'];
            $wee = array_chunk($val_arr, 2);
            $de = array_chunk($wee,7);
            
           
            
            foreach($prices[0] as $p){
                preg_match_all('!<td(.*?)>(.*?)</td>!si', $p, $ne);
                preg_match_all('!<span(.*?)>(.*?)</span>!si', $ne[2][0], $id_ars);
                $r_id = DB::select('r_id')->from('route')->where('route_name_id','=',$_POST['step_id'])->and_where('route_city_id','=',$id_ars[2][0])->execute()->current();
                $id_ar[] = $r_id['r_id'];
            }
            
            
           //   echo '<pre>';
           //print_r($_POST);
           // echo '</pre>';
           // die;
           
            $ro = DB::select()->from('routename')->where('route_name_id','=',$_POST['step_id'])->execute()->current();
            
            foreach($de as $onei => $one_ost){
                foreach($one_ost as $deyi=>$dey){
                    if(empty($dey[1])){
                        $dey[1] = null;
                    }
                    if(empty($dey[0])){
                        $dey[0] = null;
                    }
                    
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
                        $deyi,
                        $ro['name'],
                        $id_ar[$onei],
                        1,
                        1,
                        $dey[1],
                        $dey[1],
                        date('Y-m-d h:i:s'),
                        0,
                        0,
                        $_POST['rice'],
                        $ro['route_id'],
                        $ro['route_name_id'],
                        $dey[0],
                        $dey[0],
                    ))->execute();
                    
                    $cou_arr[] = 1;
                }
             } 
             die;  
        }
    }
    
    public function action_add_rice_ajax_2_new() {
        
        if($_POST) {            
            //print_r($_POST);
            //die;
            foreach($_POST['d_arr'] as $d){
                DB::insert('routeferrymanweek',array(
                    'route_name_id',
                    'ferryman_id',
                    'date',
                    'buses_id',
                    'rice',
                    'is_public'
                ))->values(array(
                    $_POST['step_id'],
                    $_POST['fer_id'],
                    $d,
                    $_POST['bus'],
                    $_POST['rice'],
                    1
                ))->execute();
            }
            //echo 'ok';
            die;
        }
        die;
    }
    
    public function action_del_see2(){
        //$this->chek_permition();
        DB::delete('routeferrymanweek')->where('route_name_id','=',$_GET['route_name_id'])->and_where('ferryman_id','=',$_GET['fer_id'])->and_where('buses_id','=',$_GET['bus_id'])->and_where('rice','=',$_GET['rice'])->execute();
        //DB::delete('add_route_step_4')->where('step_1_id','=',$_GET['step_id'])->and_where('fer_id','=',$_GET['fer_id'])->execute();
        $this->redirect('/rice/see2?route_name_id='.$_GET['route_name_id'].'&rice='.$_GET['rice']);
    }
    
    
} // End ost
