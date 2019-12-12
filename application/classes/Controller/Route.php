<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Route extends Controller_Disp {
    
    public function before() {
        parent::before();
         $this->chek_admin_enter(); 
    }
                
	public function action_index() {  
        $this->chek_permition(); 
        $ses_user = $this->ses_user;
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['content'] = '';
        $limit = 300;
        $pub = 1;
        if(isset($_GET['limit'])){
            $limit = $_GET['limit'];
            $pub = $_GET['pub'];
        }
        if($ses_user['group_id'] == 1){
            
            $data['routes'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->as_array();
            
            }else{
                $all_routes = DB::select()->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
            //echo '<pre>';
            //print_r($all_routes);
            //echo '</pre>';
            //die;
                foreach($all_routes as $rou){
                    $data['routes'][] = DB::select()->distinct(true)->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
                    ->and_where('culture','=',$lang)
                    ->and_where('routename.route_name_id','=',$rou['route_name_id'])
                    ->limit($limit)->order_by('routename.route_name_id','DESC')->execute()->current();
                }
                
            }
        
        //$this->template->left_sidebar_admin = View::factory('route/left_for_sort');
        $this->template->content_admin = View::factory('route/index',$data);
        
	}
    
    public function action_search_sort(){
        $this->chek_permition();
        if($_POST){
            $search_arr = array();
            $lang = $_POST['lang'];
            $pub = $_POST['pub'];
            switch($_POST['sort']){
            case'route_name':
                $search_arr = Model::factory('RouteMod')->get_route_name_i18n($_POST['val'],$lang,$pub);          
            break;
            case'nom':
                $search_arr = Model::factory('RouteMod')->get_route_nom($_POST['val'],$lang,$pub);          
            break;
            case'route_id':
                $search_arr = Model::factory('RouteMod')->get_route_id($_POST['val'],$lang,$pub);          
            break;
            case'route_name_id':
                $search_arr = Model::factory('RouteMod')->get_route_route_id($_POST['val'],$lang,$pub);          
            break;
            }
            $data = array();
            $data['all'] = $search_arr;
            echo View::factory('route/search_table',$data);            
            die;
        }
    }
    
    public function action_scroll(){
        $this->chek_permition();
        if($_POST){
            $lang = $_POST['lang'];
            $ofset = $_POST['ofset'];
            $search_arr = array();
            $search_arr = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',1)
            ->limit(30)->offset($ofset)->order_by('routename.route_name_id','DESC')->execute()->as_array();
            //print_r($search_arr);
            //die;
            //print_r($search_arr);
            foreach($search_arr as $a){
                    echo '<tr class="insert_af">
                        <td ><input type="checkbox" name="route_name_id[]" value="'.$a['route_name_id'].'" class="one_r_id" />'.$a['route_name_id'].'</td>
                        <td >'.$a['route_id'].'</td>
                        <td >'.$a['name'].'</td>
                        <td >'.$a['name_i18n'].'</td>
                        <td >
                        <div>';
                            $cou = array(); for($i=2;$i<=10;$i++){
                                $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                if(!empty($ch)){  
                                    $cou[] = 1;
                                }
                            }  $cou = count($cou)+2;
                                   echo '</div>
                        <span data-tooltip class="has-tip" title="'.$cou.'"><a href="/rice/add_rice?route_name_id='.$a['route_name_id'].'">add</a></span></td>
                        <td >';
                            $chch = ''; 
                            $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->execute()->current(); 
                            $reverse_route = DB::select()->from('route_reverse')->where('reverse_id','=',$a['route_name_id'])->execute()->current();
                            if(!empty($reverse_route)){
                                $chch = $reverse_route['reverse_id'];
                            } 
                            if(!empty($main_route)){
                                $chch = $main_route['main_id'];
                            }
                            if(!empty($chch)){
                                echo '<span data-tooltip class="has-tip" title="'.$chch.'"><a href="/route/reverse?id='.$a['route_name_id'].'">add</a><span>';
                            }else{
                                echo '<a href="/route/reverse?id='.$a['route_name_id'].'">add</a>';
                            }
                        echo '</td>
                        <td >';
                         if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; }
                         echo '</td>
                        <td >
                            <a href="/route/edit_route?route_name_id='.$a['route_name_id'].'">edit</a> |
                            <a class="shure" href="/route/delete_route?route_name_id='.$a['route_name_id'].'">del</a>
                        </td>
                    </tr>';
                }
            
            die;
        }
    }
    
    public function action_scroll_no(){
        $this->chek_permition();
        if($_POST){
            $lang = $_POST['lang'];
            $ofset = $_POST['ofset'];
            $search_arr = array();
            $search_arr = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
            ->and_where('culture','=',$lang)
            ->and_where('is_public','=',0)
            ->limit(30)->offset($ofset)->order_by('routename.route_name_id','DESC')->execute()->as_array();
            //print_r($search_arr);
            //die;
            //print_r($search_arr);
            foreach($search_arr as $a){
                    echo '<tr class="insert_af_no">
                        <td ><input type="checkbox" name="route_name_id[]" value="'.$a['route_name_id'].'" class="one_r_id" />'.$a['route_name_id'].'</td>
                        <td >'.$a['route_id'].'</td>
                        <td >'.$a['name'].'</td>
                        <td >'.$a['name_i18n'].'</td>
                        <td >
                        <div>';
                            $cou = array(); for($i=2;$i<=10;$i++){
                                $ch = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$a['route_name_id'])->and_where('rice','=',$i)->execute()->current();
                                if(!empty($ch)){  
                                    $cou[] = 1;
                                }
                            }  $cou = count($cou)+2;
                                   echo '</div>
                        <span data-tooltip class="has-tip" title="'.$cou.'"><a href="/rice/add_rice?route_name_id='.$a['route_name_id'].'">add</a></span></td>
                        <td >';
                            $chch = ''; 
                            $main_route = DB::select()->from('route_reverse')->where('main_id','=',$a['route_name_id'])->execute()->current(); 
                            $reverse_route = DB::select()->from('route_reverse')->where('reverse_id','=',$a['route_name_id'])->execute()->current();
                            if(!empty($reverse_route)){
                                $chch = $reverse_route['reverse_id'];
                            } 
                            if(!empty($main_route)){
                                $chch = $main_route['main_id'];
                            }
                            if(!empty($chch)){
                                echo '<span data-tooltip class="has-tip" title="'.$chch.'"><a href="/route/reverse?id='.$a['route_name_id'].'">add</a><span>';
                            }else{
                                echo '<a href="/route/reverse?id='.$a['route_name_id'].'">add</a>';
                            }
                        echo '</td>
                        <td >';
                         if($a['is_public'] == 1){ echo 'Yes';}else{ echo 'No'; }
                         echo '</td>
                        <td >
                            <a href="/route/edit_route?route_name_id='.$a['route_name_id'].'">edit</a> |
                            <a class="shure" href="/route/delete_route?route_name_id='.$a['route_name_id'].'">del</a>
                        </td>
                    </tr>';
                }
            
            die;
        }
    }
    
    public function action_ajax_fer_dates(){
        if($_POST){
            //die;
            $all_days = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ferryman_id','=',$_POST['id'])->and_where('buses_id','=',$_POST['bus_id'])->and_where('rice','=',$_POST['rice'])->execute()->as_array();
            foreach($all_days as $d){
                if($_POST['day'] == $d['date']){
                echo $d['date'];
                die;
                }
            }
        }
    }
    
    public function action_ajax_fer_dates_only(){
        if($_POST){
            
            $all_days = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->order_by('date','DESC')->limit(120)->execute()->as_array();
            
            
            //echo '<pre>';
            //print_r($all_days);
            //echo '</pre>';
            //die;
            
            $al_dat = '';
            $data_cut = Date('Y-m-d');
            
            $del_cur = 0;
            
  
            foreach($all_days as $d){
                
                //if($_POST['day'] == $d['date']){
                //echo $d['date'];
                //die;
                //}
                if($d['date'] == Date('Y-m-d')){
                    
                    if(isset($_POST['from'])){
                    $day = Date('w');
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
                    
                    
                    
                    $r_id = DB::select('r_id')->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
                    $wek = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('week_id','=',$day_week)->and_where('r_id','=',$r_id['r_id'])->execute()->current();
                    
                    
                    //echo '<pre>';
                    //print_r($wek);
                    //echo '</pre>';
                    //die; 
                    
                    $str = strtotime(Date('Y-m-d').' '.$wek['time']);
                    $now = strtotime('now');
                    
                    if($str < $now){
                        //array_pop();
                        $del_cur = 1;
                    }
                    //print_r($all_days);
                    //die;
                }
                    
                    
                    
                    
                    
                    if($del_cur == 0){
                        $al_dat .= $d['date'].',';
                    }
                }else{
                    $al_dat .= $d['date'].',';
                }
                
            }
            echo $al_dat;
            die;
        }
    }
    
    public function action_ajax_fer_dates_only_blocket_plase(){
        if($_POST){
            
            $all_days = DB::select('date')->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('ferryman_id','=',$_POST['fer'])->order_by('date','DESC')->limit(120)->execute()->as_array();
            
            
            //echo '<pre>';
            //print_r($all_days);
            //echo '</pre>';
            //die;
            
            $al_dat = '';
            $data_cut = Date('Y-m-d');
            
            $del_cur = 0;
            
  
            foreach($all_days as $d){
                
                //if($_POST['day'] == $d['date']){
                //echo $d['date'];
                //die;
                //}
                if($d['date'] == Date('Y-m-d')){
                    
                    if(isset($_POST['from'])){
                    $day = Date('w');
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
                    
                    
                    
                    $r_id = DB::select('r_id')->from('route')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$_POST['from'])->execute()->current();
                    $wek = DB::select()->from('routeweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('week_id','=',$day_week)->and_where('r_id','=',$r_id['r_id'])->execute()->current();
                    
                    
                    //echo '<pre>';
                    //print_r($wek);
                    //echo '</pre>';
                    //die; 
                    
                    $str = strtotime(Date('Y-m-d').' '.$wek['time']);
                    $now = strtotime('now');
                    
                    if($str < $now){
                        //array_pop();
                        $del_cur = 1;
                    }
                    //print_r($all_days);
                    //die;
                }
                    
                    
                    
                    
                    
                    if($del_cur == 0){
                        $al_dat .= $d['date'].',';
                    }
                }else{
                    $al_dat .= $d['date'].',';
                }
                
            }
            echo $al_dat;
            die;
        }
    }
    
    public function action_ajax_fer_dates_only_open(){
        if($_POST){
            $all_days = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$_POST['route_name_id'])->and_where('rice','=',1)->execute()->as_array();
            $al_dat = '';
            foreach($all_days as $d){
                //if($_POST['day'] == $d['date']){
                //echo $d['date'];
                //die;
                //}
                $al_dat .= $d['date'].',';
            }
            echo $al_dat;
            die;
        }
    }
    
    public function action_add_route_lang(){
        $this->chek_permition();
        if($_POST){
            $res = DB::insert('routename_i18n',array(
            'route_name_id',
            'name_i18n',
            'culture'
            ))->values(array(
            $_POST['id'],
            $_POST['name_i18n'],
            $_POST['culture']
            ))->execute();
            $this->redirect('/route');
        }
        $data = array();
        $id = $_GET['id'];
        $data['id'] = $id;
        $data['rou'] = Model::factory('RouteMod')->get_route_id_one($id,'ru');
        $data['langvige'] = DB::select()->from('Language')->execute()->as_array();
        $this->template->content_admin = View::factory('route/add_route_lang',$data);
          
    }
    
    public function action_update_route_lang(){
        $this->chek_permition();
        if($_POST){            
            DB::update('routename_i18n')->set(array(
            'name_i18n'=>$_POST['name_i18n']            
            ))->where('route_name_id','=',$_POST['id'])->and_where('culture','=',$_POST['culture'])->execute();
            $this->redirect('/route');
        }
        $data = array();
        $id = $_GET['id'];
        $lang = $_GET['lang'];
        $data['id'] = $id;
        $data['rou'] = Model::factory('RouteMod')->get_route_id_one($id,$lang);
        //print_r($data);
        //die;
        $this->template->content_admin = View::factory('route/update_route_lang',$data);
          
    }
    
    public function action_edit_route() {
        //$this->chek_permition();
        $id = $_GET['route_name_id'];
        if($_POST){
          
          if(!isset($_POST['is_validate'])){
            $_POST['is_validate'] = 0;
          }
          //else{
          //  $_POST['is_validate'] = 1;
          //}
          //echo '<pre>';
          //print_r($_POST);
          //echo '</pre>';
          //die;
          
          if(!empty($_POST['time_end'])){
            $date = array_reverse(explode('/', $_POST['time_end']));
            $_POST['time_end'] = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
          }
        
          
          if($_POST['route_type'] == 'gorod'){
                $_POST['route_type'] = $_POST['route_type_sub'];
            }
            DB::update('routename')->set(array(
                'is_public'=>$_POST['is_validate'],
                'route_id'=>$_POST['route_id'],
                'name'=>$_POST['name'],
                'types'=>$_POST['route_type'],
                'country_id'=>$_POST['country_id'],
                'country_to_id'=>$_POST['country_id_to'],
                'start_from'=>$_POST['time_end'],
                ))->where('route_name_id','=',$id)->execute(); 
                
            DB::update('routename_i18n')->set(array(
                'name_i18n'=>trim($_POST['name_i18n']),
            ))->where('route_name_id','=',$id)->and_where('culture','=','ru')->execute();
            
            $uk = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
            if(!empty($uk)){
                DB::update('routename_i18n')->set(array(
                'name_i18n'=>trim($_POST['name_i18n_ua']),
                ))->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute();
            }else{
                $res = DB::insert('routename_i18n',array(
                    'route_name_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_ua'],
                    'uk'
                ))->execute();
            }
            $en = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
            if(!empty($en)){
                DB::update('routename_i18n')->set(array(
                'name_i18n'=>trim($_POST['name_i18n_en']),
                ))->where('route_name_id','=',$id)->and_where('culture','=','en')->execute();
            }else{
                $res = DB::insert('routename_i18n',array(
                    'route_name_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_en'],
                    'en'
                ))->execute();
            }
            $cs = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
            if(!empty($cs)){
                DB::update('routename_i18n')->set(array(
                'name_i18n'=>trim($_POST['name_i18n_cs']),
                ))->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute();
            }else{
                $res = DB::insert('routename_i18n',array(
                    'route_name_id',
                    'name_i18n',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_cs'],
                    'cs'
                ))->execute();
            }
                          
        }
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['name_i18n_ua'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
        $data['name_i18n_en'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
        $data['name_i18n_cs'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=','ru')->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('/route/left_edit',$data);
        $this->template->content_admin = View::factory('/route/update_route_1',$data);
       
    }
    
    public function action_edit_route2() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
        if($_POST){
          //echo '<pre>';
          //  print_r($_POST);
          //  echo '</pre>';
          //  die;            
        }
        $id = $_GET['route_name_id'];
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        $data['name_i18n_ua'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
        $data['name_i18n_en'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
        $data['name_i18n_cs'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['all_ost'] = DB::select()->from('route')->where('route.route_name_id','=',$id)->order_by('weight')->execute()->as_array();
        //$data['route_name'] = DB::select()->from('RouteName_i18n')->where('route_name_id','=',$id)->execute()->current();
        //echo '<pre>';
        //print_r($data['all_ost']);
        //echo '</pre>';
        //die; 
        //$data['all_fer'] = DB::select()->from('Ferryman')->execute()->as_array();
        //$data['last_rout'] = DB::select('route_id')->from('RouteName')->order_by('route_id','DESC')->limit(1)->execute()->current();
        //$this->template->left_sidebar_admin = View::factory('/route/left_edit',$data);
        $this->template->content_admin = View::factory('/route/update_route_2',$data);
       
    }
    
    public function action_update_route2() {
        $this->chek_permition();
        if($_POST) {
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
            
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
            
            
            foreach($id_ar as $ii=>$id){
                //print_r($id);
                //die;
                
                
                $ch_platform = $r_id = DB::select()->from('routedistance')->where('route_name_id','=',$_POST['step_id'])->and_where('r_id','=',$id)->execute()->current();
                if(!empty($ch_platform)){
                    $platform = DB::update('routedistance')->set(array(
                //'r_id',
                //'route_type_id',
                //'route_name_id',
                'platform'=>$_POST['platform'][$ii]
                //))->values(array(
                //$res4[0],
                //1,
                //$res1[0], // мы всавляем route_name_id
                //$s2['platform']
                ))->where('route_name_id','=',$_POST['step_id'])->and_where('r_id','=',$id)->execute();
                }else{
                    DB::insert('routedistance',array(
                                'r_id',
                                'route_name_id',
                                'platform'
                            ))->values(array(
                                $id,
                                $_POST['step_id'],
                                $_POST['platform'][$ii]
                            ))->execute();
                }
                
                //))->execute(); 
                /*
                DB::update('RouteWeek')->set(array(
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
                */
                for($i=0; $i<=6; $i++){
                    if(empty($de[$ii][$i][1])){
                        $de[$ii][$i][1] = null;
                    }
                    if(empty($de[$ii][$i][0])){
                        $de[$ii][$i][0] = null;
                    }
                    $ch_week = DB::select()->from('routeweek')->where('r_id','=',$id)->execute()->current();
                    $ro = DB::select()->from('routename')->where('route_name_id','=',$_POST['step_id'])->execute()->current();
                    if(!empty($ch_week)){
                        DB::update('routeweek')->set(array(
                            'hours'=>$de[$ii][$i][1],
                            'time'=>$de[$ii][$i][1],
                            'a_hours'=>$de[$ii][$i][0],
                            'a_time'=>$de[$ii][$i][0]
                        ))->where('route_name_id','=',$_POST['step_id'])->and_where('r_id','=',$id)->and_where('week_id','=',$i)->execute();
                    }else{
                        for($bb=0; $bb<=6; $bb++){
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
                                'rice',
                                'route_id',
                                'route_name_id',
                                'a_hours',
                                'a_time'
                            ))->values(array(
                                $bb,
                                $ro['name'],
                                $id,
                                1,
                                1,
                                $de[$ii][$bb][1],
                                $de[$ii][$bb][1],
                                date('Y-m-d h:i:s'),
                                0,
                                0,
                                1,
                                $ro['route_id'],
                                $_POST['step_id'],
                                $de[$ii][$bb][0],
                                $de[$ii][$bb][0],
                            ))->execute();
                        }
                    }
                    
                }
                
            }
            //print_r($de[0][0]);
            //die;
        }
        die;
    }
    
    public function action_add_ost_step_2() {
        //$this->chek_permition();
        if($_POST) {
            
            $route = DB::select()->from('route')->where('route_name_id','=',$_POST['step_id'])->execute()->as_array();
            $weight = count($route);
            
            //print_r($route);
            //die;
            $r_id = DB::insert('route',array(
                'route_id',
                'route_name_id',
                'country_id',
                'route_city_id',
                'weight',
                'route_type_id',
            ))->values(array(
                $_POST['step_id'],
                $_POST['step_id'],
                1,
                $_POST['id'],
                $weight+1,
                1
            ))->execute();
            
            $r_id = DB::insert('routedistance',array(
                'r_id',
                'route_name_id',
                'platform'
            ))->values(array(
                $r_id[0],
                $_POST['step_id'],
                ''
            ))->execute();
            
            //echo 'ok';
        }
        die;
    }
    
    public function action_edit_route3() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        if($_POST){
          //echo '<pre>';
          //  print_r($_POST);
          //  echo '</pre>';
          //  die;            
        }
        $id = $_GET['route_name_id'];
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['all_dates'] = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$id)->and_where('rice','=',1)->execute()->as_array();
        if($ses_user['group_id'] == 1){
            $data['all_fer'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')
            //->where('system_users_ferryman.sys_id','=',$ses_user[0]['id'])
            ->execute()->as_array();
        }else{
            $data['all_fer'] = DB::select()->from('system_users_ferryman')->join('ferryman')->on('system_users_ferryman.fer_id','=','ferryman.ferryman_id')
            ->where('system_users_ferryman.sys_id','=',$ses_user[0]['id'])
            ->execute()->as_array();
        }
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();
        //$data['route_name'] = DB::select()->from('RouteName_i18n')->where('route_name_id','=',$id)->execute()->current();
        //echo '<pre>';
        //print_r($data);
        //echo '</pre>'; 
        //$data['all_fer'] = DB::select()->from('Ferryman')->execute()->as_array();
        //$data['last_rout'] = DB::select('route_id')->from('RouteName')->order_by('route_id','DESC')->limit(1)->execute()->current();
        //$this->template->left_sidebar_admin = View::factory('/route/left_edit',$data);
        $this->template->content_admin = View::factory('/route/update_route_3',$data);
       
    }
    
    public function action_save_edit_route_3() {
        $this->chek_permition();
        if($_POST) {            
            //print_r($_POST);
            //die;
            $ch_cron = DB::select()->from('cron')->where('route_name_id','=',$_POST['step_id'])->and_where('ferryman_id','=',$_POST['fer_id'])->execute()->current();
            if(!empty($ch_cron)){
                DB::update('cron')->set(array(
                    'type'=>$_POST['user_choise'],
                ))->where('route_name_id','=',$_POST['step_id'])
                ->and_where('ferryman_id','=',$_POST['fer_id'])
                ->execute();
            }else{
                DB::insert('cron',array(
                    'route_name_id',
                    'type',
                    'ferryman_id'
                ))->values(array(
                    $_POST['step_id'],
                    $_POST['user_choise'],
                    $_POST['fer_id']
                ))->execute();
            }
            
            $route_type = DB::select()->from('routename')->where('route_name_id','=',$_POST['step_id'])->execute()->current();
            $old_route = DB::select()->from('routename')->where('parent','=',$_POST['step_id'])->execute()->current();
            if(!empty($old_route)){
                foreach($_POST['d_arr'] as $d){
                    $start_date = strtotime($old_route['start_from'].' 00:00:00');
                    $cur = strtotime($d.' 00:00:00');
                    if($cur > $start_date){
                        DB::insert('routeferrymanweek',array(
                            'route_name_id',
                            'ferryman_id',
                            'date',
                            'rice',
                            'buses_id',
                            'route_type_id'
                        ))->values(array(
                            $_POST['step_id'],
                            $_POST['fer_id'],
                            $d,
                            1,
                            $_POST['bus'],
                            $route_type['types']
                        ))->execute();
                    }
                    
                }
                
                
            }else{
                foreach($_POST['d_arr'] as $d){
                    DB::insert('routeferrymanweek',array(
                        'route_name_id',
                        'ferryman_id',
                        'date',
                        'rice',
                        'buses_id',
                        'route_type_id'
                    ))->values(array(
                        $_POST['step_id'],
                        $_POST['fer_id'],
                        $d,
                        1,
                        $_POST['bus'],
                        $route_type['types']
                    ))->execute();
                }
            }
            echo 'ok';
            die;
        }
        die;
    }
    
    public function action_edit_route4() {
        $this->chek_permition();
        $id = $_GET['route_name_id'];
        $ses_user = $this->ses_user;
        if($_POST){
          $valute = $_POST['valute'];
            array_shift($_POST);
            
            $new_ar = $_POST;
            foreach($new_ar as $i=>$ne){
                $new_i = explode('_',$i);
                $new_i['val'] = $ne;
                $n[] = $new_i;
            }
            
            DB::delete('routeprice')->where('route_name_id','=',$_GET['route_name_id'])->and_where('valute','=',$valute)->execute();
            /////////////////
            $i = 1;
            foreach($n as $v){
                if($v['val'] != ''){
                    DB::insert('routeprice',array(
                        'route_name_id',
                        'route_city_from_id',
                        'route_city_to_id',
                        'valute',
                        'price',
                        'weight',
                        'route_price_id'
                        ))->values(array(
                        $id,
                        $v[0],
                        $v[1],
                        $valute,
                        $v['val'],
                        $i,
                        1
                        ))->execute();
                        $i++;
                } 
            }
            /////////////////
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            //die;
          // die;
            $this->redirect('route/edit_route4?route_name_id='.$id);            
        }
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=','ru')->execute()->current();
        $data['all_dates'] = DB::select()->from('routeferrymanweek')->where('route_name_id','=',$id)->execute()->as_array();
        $data['all_fer'] = DB::select()->from('ferryman')->execute()->as_array();
        $data['all_bus'] = DB::select()->from('ferryman_buses')->where('fer_id','=',3)->execute()->as_array();
        $data['valutes'] = DB::select()->from('system_users_valutes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();
        $data['sel_val'] = DB::select()->from('routeprice')->where('route_name_id','=',$id)->execute()->as_array();
        $data['all_ost'] = DB::select()->from('route')->where('route_name_id','=',$id)->order_by('weight')->execute()->as_array();
        //print_r($data['all_ost']);
        //die;
        //$data['route_name'] = DB::select()->from('RouteName_i18n')->where('route_name_id','=',$id)->execute()->current();
        //echo '<pre>';
        //print_r($data['sel_val']);
        //echo '</pre>'; 
        //$data['all_fer'] = DB::select()->from('Ferryman')->execute()->as_array();
        //$data['last_rout'] = DB::select('route_id')->from('RouteName')->order_by('route_id','DESC')->limit(1)->execute()->current();
        //$this->template->left_sidebar_admin = View::factory('/route/left_edit',$data);
        $this->template->content_admin = View::factory('/route/update_route_4',$data);
       
    }
    
    public function action_del_edit_route3(){
        $this->chek_permition();
        DB::delete('routeferrymanweek')->where('route_name_id','=',$_GET['route_name_id'])->and_where('ferryman_id','=',$_GET['fer_id'])->and_where('buses_id','=',$_GET['bus_id'])->execute();
        //DB::delete('add_route_step_4')->where('step_1_id','=',$_GET['step_id'])->and_where('fer_id','=',$_GET['fer_id'])->execute();
        $this->redirect('route/edit_route3?route_name_id='.$_GET['route_name_id']);
    }
    
    public function action_delete_route() { 
       $this->chek_permition();
       $route_id = DB::select()->from('routename')->where('route_name_id','=',$_GET['route_name_id'])->execute()->current();
       DB::delete('routename')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('routename_i18n')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('route')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('routeferrymanweek')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('routeprice')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('routeweek')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       //DB::delete('routecountry')->where('route_id','=',$route_id['route_id'])->execute(); //// сюда вставляем route_id
       DB::delete('routedistance')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       DB::delete('system_users_routes')->where('route_name_id','=',$_GET['route_name_id'])->execute();
       $this->redirect('/route');
    }
    
    public function action_del_ost() {
        $this->chek_permition();
        if($_POST) {
            $route = DB::select()->from('route')->where('route_name_id','=',$_POST['step_id'])->and_where('route_city_id','=',$_POST['id'])->execute()->current();
            //print_r($route);
            //die;
            DB::delete('route')->where('route_name_id','=',$_POST['step_id'])->and_where('route_city_id','=',$_POST['id'])->execute();
            DB::delete('routeweek')->where('r_id','=',$route['r_id'])->execute();
        }
        die;
    }
    
    public function action_see_all() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'en';
         }
        $data['all'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
        ->where('culture','=',$lang)
        ->and_where('routename.is_public','=',1)
        ->order_by('routename.route_name_id','DESC')->execute()->as_array();
        $data['all_no'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')
        ->where('culture','=',$lang)
        ->and_where('routename.is_public','=',0)
        ->order_by('routename.route_name_id','DESC')->execute()->as_array();
        //print_r($data);
        //$this->template->left_sidebar_admin = View::factory('/route/left_for_sort',$data);
        $this->template->content_admin = View::factory('/route/see_all',$data);
    }
    
    public function action_reverse() {
        $this->chek_permition();
        $ses_user = $this->ses_user;
        if($ses_user['group_id'] == 1){
            $data['all'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('culture','=','ru')->order_by('routename.route_name_id','DESC')->limit(30)->execute()->as_array();
            }else{
                $all_routes = DB::select('route_name_id')->from('system_users_routes')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array();

                $data['all'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','in',$all_routes)->where('culture','=','ru')->order_by('routename.route_name_id','DESC')->limit(30)->execute()->as_array();
                //print_r($all);
                //die;
                
            }
        
        //print_r($data);
        //$this->template->left_sidebar_admin = View::factory('/route/left_for_sort',$data);
        $this->template->content_admin = View::factory('/route/reverse',$data);
    }
    
    public function action_search_join(){
        $this->chek_permition();
        if($_POST){
            echo '<script type="text/javascript">
                $(".sel_rou").click(function(){
                    var Par = $(this).parents(".input-ost");
                    Par.find(".route_name").val($(this).text());
                    Par.find(".show_route").html("");
                    Par.find(".rid").val($(this).find("span").text());
                    //alert();
                })
            </script>';
            $lang = $_POST['lang'];
            $name = $_POST['val'];
            $ses_user = $this->ses_user;
            
            if($ses_user['group_id'] == 1){
                $res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('name_i18n','LIKE','%'.$name.'%')->and_where('culture','=',$lang)->execute()->as_array();
            }else{
                $res = DB::select()->from('system_users_routes')
                ->join('routename_i18n')->on('system_users_routes.route_name_id','=','routename_i18n.route_name_id')
                ->where('name_i18n','LIKE','%'.$name.'%')
                ->and_where('culture','=',$lang)
                ->and_where('sysuser_id','=',$ses_user[0]['id'])
                ->execute()->as_array();
                //print_r($res);
                //die;
                //$res = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','in',$all_routes)->and_where('name_i18n','LIKE','%'.$name.'%')->where('culture','=','ru')->order_by('routename.route_name_id','DESC')->limit(30)->execute()->as_array();
                //print_r($all);
                //die;
                
            }
            
            echo '<ul>';
            foreach($res as $r){
                echo '<li class="sel_rou"><div><span>'.$r['route_name_id'].'</span>'.$r['name_i18n'].'</div></li>';
            }
            echo '</ul>';
            //print_r($res);
            die;
        }
    }
    
    public function action_save_reverse_routes(){
        $this->chek_permition();
        if($_POST){
            DB::insert('route_reverse',array(
                'main_id',
                'reverse_id'
            ))->values(array(
                $_POST['main'],
                $_POST['rev']
            ))->execute();
            echo 'ok';
            die;
        }
    }
    
    public function action_all_pub(){
        $this->chek_permition();
        if($_POST){
            foreach($_POST['arr'] as $ar){
                DB::update('routename')->set(array(
                    'is_public'=>$_POST['dodo'],
                ))->where('route_name_id','=',$ar)->execute();
            }
            echo 'ok';
            die;
        }
    }
    
    public function action_save_start_date(){
        $this->chek_permition();
        $id = $_GET['route_name_id'];
        if($_POST){
            if(!empty($_POST['time_end'])){
                $date = array_reverse(explode('/', $_POST['time_end']));
                $_POST['time_end'] = date('Y-m-d', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            }
            DB::update('routename')->set(array(
                'start_from'=>$_POST['time_end'],
            ))->where('route_name_id','=',$id)->execute();
            
            $old_route_name = DB::select()->from('routename')->where('route_name_id','=',$id)->execute()->current();
            $this->redirect("/route");   
                          
        }
        $data = array();
        $data['info'] = 'Добавление даты';
        //$this->template->left_sidebar_admin = View::factory('/route/left_edit',$data);
        $this->template->content_admin = View::factory('/route/save_start_date',$data);
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
            //print_r($new_ar);
            //die;
            foreach($new_ar as $i=>$wi){
                DB::update('route')->set(array(
                'weight'=>$i,        
                ))->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_id','=',$wi)->execute();
            }
            die;
        }
        die;
    }
    
    public function action_delete_route_type_2() { 
       $this->chek_permition();
       $rou_all = DB::select()->distinct(true)->from('routename')->where('types','=',2)->execute()->as_array();
       
       foreach($rou_all as $al){
           DB::delete('routename')->where('route_name_id','=',$al['route_name_id'])->execute();
           DB::delete('routename_i18n')->where('route_name_id','=',$al['route_name_id'])->execute();
           DB::delete('route')->where('route_name_id','=',$al['route_name_id'])->execute();
           DB::delete('routeferrymanweek')->where('route_name_id','=',$al['route_name_id'])->execute();
           DB::delete('routeprice')->where('route_name_id','=',$al['route_name_id'])->execute();
           DB::delete('routeweek')->where('route_name_id','=',$al['route_name_id'])->execute();
           //DB::delete('routecountry')->where('route_id','=',$al['route_id'])->execute(); //// сюда вставляем route_id
           DB::delete('routedistance')->where('route_id','=',$al['route_name_id'])->execute();
       }
       //print_r($route_id);
       echo count($rou_all);
       die;
       
       $this->redirect('/route');
    }
    
     public function action_ajax_get_price_all() {
        if($_POST) {
            $route_price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('valute','=',$_POST['valute'])->order_by('weight','DESC')->execute()->as_array();
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
    
     public function action_ajax_dell_price() {
        if($_POST) {
            DB::delete('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('valute','=',$_POST['valute'])->execute();
            die;
        }
        die;
    }
    
    
    public function action_ajax_update_price() {
        
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
                
                $check = DB::select()->from('routeprice')
                    ->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])
                    ->execute()->current();
                if(!empty($check)){
                    DB::update('routeprice')->set(array(
                        'price'=>$price
                    ))->where('route_city_from_id','=',$citys[0])
                    ->and_where('route_name_id','=',$route_id)
                    ->and_where('route_city_to_id','=',$citys[1])
                    ->and_where('valute','=',$_POST['valute'])->execute();
                }else{
                    DB::insert('routeprice',array(
                        'route_name_id',
                        'route_city_from_id',
                        'route_city_to_id',
                        'valute',
                        'price',
                        'route_price_id'
                        ))->values(array(
                        $route_id,
                        $citys[0],
                        $citys[1],
                        $_POST['valute'],
                        $price,
                        1
                        ))->execute();
                }
            }
            echo 'Update!';    
            die;   
        }
    }
    
    public function action_platform() {
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $id = $_GET['route_name_id'];
        $data = array();
        $data['info'] = 'Добавление нового маршрута';
        $data['route_name'] = DB::select()->from('routename')->join('routename_i18n')->on('routename.route_name_id','=','routename_i18n.route_name_id')->where('routename.route_name_id','=',$id)->and_where('culture','=',$lang)->execute()->current();
        $data['name_i18n_ua'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','uk')->execute()->current();
        $data['name_i18n_en'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','en')->execute()->current();
        $data['name_i18n_cs'] = DB::select()->from('routename_i18n')->where('route_name_id','=',$id)->and_where('culture','=','cs')->execute()->current();
        $data['all_countrys'] = DB::select()->from('country_i18n')->where('culture','=',$lang)->execute()->as_array();
        $data['all_ost'] = DB::select()->from('route')->where('route.route_name_id','=',$id)->order_by('weight')->execute()->as_array();
        $this->template->content_admin = View::factory('/route/platform',$data);
    }
    
    public function action_ajax_update_platform() {
        //$this->chek_permition();
        if($_POST){
            $array = array_chunk($_POST['val'],7);
            
            foreach($_POST['osts'] as $i=>$ost){
                for($ii=0;$ii<count($array[$i]);$ii++){
                     //echo '</pre>';
                     //print_r($array[$i][$ii]);
                     //echo '</pre>';
                     $platform_chekk = Model::factory('RouteMod')->get_platform($_POST['route'],$ii,$ost,3);
                     if(empty($platform_chekk)){
                        if(!empty($array[$i][$ii])){
                            DB::insert('platform',array(
                                'route_name_id',
                                'day_week',
                                'value',
                                'ost_id'
                            ))->values(array(
                                $_POST['route'],
                                $ii,
                                $array[$i][$ii],
                                $ost
                            ))->execute();
                        }
                     }else{
                        DB::update('platform')->set(array(
                            'value'=>$array[$i][$ii]
                        ))->where('route_name_id','=',$_POST['route'])
                            ->and_where('day_week','=',$ii)
                            ->and_where('ost_id','=',$ost)
                        ->execute();
                     }
                }
               
            }
            
            die;
        }
    }
    
    public function action_cron_refresh_info() {
        //$this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        }
        $data = array();
        $data['info'] = __("Cron refresh infirmation!");
        $this->template->content_admin = View::factory('/route/cron_refresh_information',$data);
    }
    
} // End Admin














