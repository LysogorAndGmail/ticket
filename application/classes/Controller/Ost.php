<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ost extends Controller_Disp {
    
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
        $data['lang'] = $lang;
        $data['content'] = '';
        if($_POST){
            $data['all'] = array();
            if(!empty($_POST['ost_id'])){
                $data['all'] = Model::factory('OstMod')->get_all_ost_id($_POST['ost_id'],$lang);
            }
            if(!empty($_POST['ost_name'])){
                $data['all'] = Model::factory('OstMod')->get_all_ost_name($_POST['ost_name'],$lang);
            }
            //*/
            if(!empty($_POST['ost_city'])){
                $data['all'] = Model::factory('OstMod')->get_all_ost_city($_POST['ost_city'],$lang);
            }
            if(!empty($_POST['ost_vill'])){
                $data['all'] = Model::factory('OstMod')->get_all_ost_vill($_POST['ost_vill'],$lang);          
            }
            $con = View::factory('ost/search_table',$data);
            $data['content'] = $con;
        }else{
            $data['content'] = View::factory('ost/see_all_new',$data);
        }
        $data['osts'] = DB::select()->from('routecity')->execute()->as_array();
        //$this->template->left_sidebar_admin = View::factory('ost/left_for_sort');
        $this->template->content_admin = View::factory('ost/index',$data);
	}
    
        //////////
    public function action_ajax_ost() {
        if($_POST) {
            //if(strlen($_POST['val']) > 2) {
                //$res = Model::factory('Ost')->get_ajax_ost($_POST['ost_name']);
                
                $res = array();
                switch($_POST['sort']){
                    case'ost_id':
                        $res = Model::factory('OstMod')->get_all_ost_id($_POST['val'],$_POST['lang']);          
                    break;
                    case'ost_name':
                        $res = Model::factory('OstMod')->get_all_ost_name($_POST['val'],$_POST['lang']);          
                    break;
                    case'ost_city':
                        $res = Model::factory('OstMod')->get_all_ost_city($_POST['val'],$_POST['lang']);          
                    break;
                    case'ost_vill':
                        $res = Model::factory('OstMod')->get_all_ost_vill($_POST['val'],$_POST['lang']);          
                    break;
                }
                //print_r($res);
                //die;
                echo '<div class="left-padding-content-select">';
			    echo '<table class="table table-striped table-fixed-layout table-hover" id="emails"><thead>';
                echo "<tr class='nohover'>
                        <th class='first'>ID</th>
                        <th>".__('Name')."</th>
                        <th>".__('City')."</th>
                        <th>".__('Village')."</th>
                        <th>".__('Validate')."</th>
                        <th>".__('Routes')."</th>
                        <th>".__('Region')."</th>
                        <th><i class=\"fa fa-globe\"></i></td>
                        <th class='last'>".__('Actions')."</th>
                        </tr></thead><tbody>";
                //print_r($res);
                //die;
                foreach($res as $re) {
                    $nnn = $re['route_city_id'];
                    $count = Model::factory('OstMod')->get_ajax_ost_route($nnn);
                    $region = DB::select()->from('ost_regions')->where('ost_id','=',$nnn)->execute()->current();
                    if(!empty($region['region_id'])) {
                        $reg = DB::select()->from('regions')->join('regions_i18n')->on('regions.region_id','=','regions_i18n.region_id')->where('regions.region_id','=',$region['region_id'])->and_where('regions_i18n.culture','=','ru')->execute()->current();
                        $reg = $reg['name'];
                    }else {
                        $reg = 'нет';
                    }
                    echo "<tr class='newspaper-c'>
                    <td class='first'>".$nnn."</th>
                    <td >".$re['name_i18n']."</td>
                    <td >".$re['city_i18n']."</td>
                    <td >".$re['village']."</td>
                    <td>".$re['is_validate']."</td>
                    <td>".$count."</td>
                    <td>".$reg."</td>
                    <td>Langs</td>
                    <td class='last'>
                        <a href='/ost/update_ost?ost_id=".$nnn."&lang=ru'><i class=\"fa fa-edit\"></i></a>&nbsp;
                        <a class='shure' href='/ost/delete_ost?ost_id=".$nnn."&lang=ru'><i class=\"fa fa-times\"></i></a>
                    </td>
                    </tr>";
                
				
				}
                //echo '</tbody></table><table id="table-footer"><tr><td>sdsd</td></tr></table>';
                echo '</div>';
 		 
    		//}else {
            //    echo 1;
            //}
            die;
        }
    }
    
    public function action_update_ost() {  
        //$this->chek_permition(); 
        $id = $_GET['ost_id'];
        if($_POST){
            
            //echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';
            
            ///*
            $mod = Model::factory('OstMod');
            
             DB::update('routecity_i18n')->set(array(
                'name_i18n'=>$_POST['name_i18n'],
                'desc_i18n'=>$_POST['desc_i18n'],
                'address'=>$_POST['address'],
                'city_i18n'=>$_POST['city_i18n'],
                'village'=>$_POST['village']
            ))->where('route_city_id','=',$id)->and_where('culture','=','ru')->execute();
            
            $ua = $mod->get_ost($id,'uk');
            if(!empty($ua)){
                DB::update('routecity_i18n')->set(array(
                    'name_i18n'=>$_POST['name_i18n_ua'],
                    'desc_i18n'=>$_POST['desc_i18n_ua'],
                    'address'=>$_POST['address_ua'],
                    'city_i18n'=>$_POST['city_i18n_ua'],
                    'village'=>$_POST['village_ua']
                ))->where('route_city_id','=',$id)->and_where('culture','=','uk')->execute();
            }else{
                DB::insert('routecity_i18n',array(
                    'route_city_id',
                    'name_i18n',
                    'desc_i18n',
                    'address',
                    'city_i18n',
                    'village',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_ua'],
                    $_POST['desc_i18n_ua'],
                    $_POST['address_ua'],
                    $_POST['city_i18n_ua'],
                    $_POST['village_ua'],
                    'uk'
                ))->execute();
            }
            $en = $mod->get_ost($id,'en');
            if(!empty($en)){
                DB::update('routecity_i18n')->set(array(
                    'name_i18n'=>$_POST['name_i18n_en'],
                    'desc_i18n'=>$_POST['desc_i18n_en'],
                    'address'=>$_POST['address_en'],
                    'city_i18n'=>$_POST['city_i18n_en'],
                    'village'=>$_POST['village_en']
                ))->where('route_city_id','=',$id)->and_where('culture','=','en')->execute();
            }else{
                DB::insert('routecity_i18n',array(
                    'route_city_id',
                    'name_i18n',
                    'desc_i18n',
                    'address',
                    'city_i18n',
                    'village',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_en'],
                    $_POST['desc_i18n_en'],
                    $_POST['address_en'],
                    $_POST['city_i18n_en'],
                    $_POST['village_en'],
                    'en'
                ))->execute();
            }
            $cs = $mod->get_ost($id,'cs');
            if(!empty($cs)){
                DB::update('routecity_i18n')->set(array(
                    'name_i18n'=>$_POST['name_i18n_cs'],
                    'desc_i18n'=>$_POST['desc_i18n_cs'],
                    'address'=>$_POST['address_cs'],
                    'city_i18n'=>$_POST['city_i18n_cs'],
                    'village'=>$_POST['village_cs']
                ))->where('route_city_id','=',$id)->and_where('culture','=','cs')->execute();
            }else{
                DB::insert('routecity_i18n',array(
                    'route_city_id',
                    'name_i18n',
                    'desc_i18n',
                    'address',
                    'city_i18n',
                    'village',
                    'culture'
                ))->values(array(
                    $id,
                    $_POST['name_i18n_cs'],
                    $_POST['desc_i18n_cs'],
                    $_POST['address_cs'],
                    $_POST['city_i18n_cs'],
                    $_POST['village_cs'],
                    'cs'
                ))->execute();
            }
            //*/
            DB::update('routecity')->set(array(
                'lat'=>$_POST['lat'],
                'lng'=>$_POST['lng'],
                'cordon'=>$_POST['cordon'],
                'fax'=>$_POST['fax'],
                'phone'=>$_POST['phone'],
                'postal'=>$_POST['postal'],
                'is_validate'=>$_POST['is_validate']
                //'city_types'=>$_POST['city_types']
            ))->where('route_city_id','=',$_POST['id'])->execute();
            
            DB::delete('ost_types')->where('route_city_id','=',$id)->execute();
            
            foreach($_POST['city_type'] as $it) {
                DB::insert('ost_types',array(
                'route_city_id',
                'type_id'
            ))->values(array(
                $id,
                $it
            ))->execute();
            }
            
            //$this->redirect('/ost');
            
        }
        $mod = Model::factory('OstMod');
        $data = array();
        $data['edit'] = DB::select()->from('routecity')->where('route_city_id','=',$id)->execute()->current();
        
        $data['edit_ost'] = $mod->get_ost($id,'ru');
        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';
        $data['edit_ost_ua'] = $mod->get_ost($id,'uk');
        $data['edit_ost_en'] = $mod->get_ost($id,'en');
        $data['edit_ost_cs'] = $mod->get_ost($id,'cs');
        //$this->template->left_sidebar_admin = View::factory('ost/left_for_sort');
        $this->template->content_admin = View::factory('ost/update_ost',$data);
	}
    
    public function action_add_ost() {  
        $this->chek_permition(); 
        if($_POST){

            $id = DB::insert('routecity',array(
                    'lat',
                    'lng',
                    'cordon',
                    'fax',
                    'phone',
                    'postal',
                    'is_validate'
                ))->values(array(
                    $_POST['lat'],
                    $_POST['lng'],
                    $_POST['cordon'],
                    $_POST['fax'],
                    $_POST['phone'],
                    $_POST['postal'],
                    $_POST['is_validate']
                ))->execute();
                
            $id = $id[0];
            
            foreach($_POST['city_type'] as $it) {
                DB::insert('ost_types',array(
                'route_city_id',
                'type_id'
            ))->values(array(
                $id,
                $it
            ))->execute();
            }

           DB::insert('routecity_i18n',array(
                'route_city_id',
                'name_i18n',
                'desc_i18n',
                'address',
                'city_i18n',
                'village',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n'],
                $_POST['desc_i18n'],
                $_POST['address'],
                $_POST['city_i18n'],
                $_POST['village'],
                'ru'
            ))->execute();
               

            DB::insert('routecity_i18n',array(
                'route_city_id',
                'name_i18n',
                'desc_i18n',
                'address',
                'city_i18n',
                'village',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_ua'],
                $_POST['desc_i18n_ua'],
                $_POST['address_ua'],
                $_POST['city_i18n_ua'],
                $_POST['village_ua'],
                'ua'
            ))->execute();
                
            DB::insert('routecity_i18n',array(
                'route_city_id',
                'name_i18n',
                'desc_i18n',
                'address',
                'city_i18n',
                'village',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_en'],
                $_POST['desc_i18n_en'],
                $_POST['address_en'],
                $_POST['city_i18n_en'],
                $_POST['village_en'],
                'en'
            ))->execute();

            DB::insert('routecity_i18n',array(
                'route_city_id',
                'name_i18n',
                'desc_i18n',
                'address',
                'city_i18n',
                'village',
                'culture'
            ))->values(array(
                $id,
                $_POST['name_i18n_cs'],
                $_POST['desc_i18n_cs'],
                $_POST['address_cs'],
                $_POST['city_i18n_cs'],
                $_POST['village_cs'],
                'cs'
            ))->execute();
            $this->redirect('/ost');

        }
        $data = array();
        //$this->template->left_sidebar_admin = View::factory('ost/left_for_sort');
        $this->template->content_admin = View::factory('ost/add_ost',$data);
	}
    
    
    public function action_see_all() {
        $this->chek_permition();
        $lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'en';
        }
        $data = array();
        $data['res'] = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')->and_where('routecity_i18n.culture','=',$lang)->order_by('routecity.route_city_id','DESC')->limit(30)->execute()->as_array();
        $this->template->left_sidebar_admin = View::factory('ost/left_for_sort');
        $this->template->content_admin = View::factory('ost/see_all',$data);
    }
    
    public function action_scroll(){
        $this->chek_permition();
        if($_POST){
            $lang = $_POST['lang'];
            $ofset = $_POST['ofset'];
            $search_arr = array();
            $search_arr = DB::select()->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')
            ->and_where('routecity_i18n.culture','=','ru')
            ->order_by('routecity.route_city_id','DESC')->limit(30)->offset($ofset)->execute()->as_array();
            //print_r($search_arr);
            //die;
            //print_r($search_arr);
            foreach($search_arr as $re){
                    $nnn = $re['route_city_id'];
                    
                    $ukr = Model::factory('OstMod')->get_ajax_ost_id($nnn,'ua');
                    $en = Model::factory('OstMod')->get_ajax_ost_id($nnn,'en');
                    $cs = Model::factory('OstMod')->get_ajax_ost_id($nnn,'cs');
                    $count = Model::factory('OstMod')->get_ajax_ost_route($nnn);
                    $region = DB::select()->from('ost_regions')->where('ost_id','=',$nnn)->execute()->current();
                    if(!empty($region['region_id'])) {
                        $reg = DB::select()->from('regions')->join('regions_i18n')->on('regions.region_id','=','regions_i18n.region_id')->where('regions.region_id','=',$region['region_id'])->and_where('regions_i18n.culture','=','ru')->execute()->current();
                        $reg = $reg['name'];
                    }else {
                        $reg = 'нет';
                    }
                    echo "<tr class='newspaper-c'>
                    <td class='first'>".$nnn."</th>
                    <td >".$re['name_i18n']."</td>
                    <td >".$re['city_i18n']."</td>
                    <td >".$re['village']."</td>
                    <td>".$re['is_validate']."</td>
                    <td>".$count."</td>
                    <td>".$reg."</td>
                    <td>".$ukr."</td>
                    <td>".$en."</td>
                    <td>".$cs."</td>
                    <td class='last'>
                        <a href='/ost/update_ost?ost_id=".$nnn."&lang=ru'><img src='".Kohana::$base_url."img/ui/edit-document.png' width='16' height='16' title='".__('Edit')."' /></a>&nbsp;
                        <a class='shure' href='/ost/del_ost?id=".$nnn."'><img src='".Kohana::$base_url."img/ui/delete.png' width='16' height='16' title='".__('Dell')."' /></a>
                    </td>
                    </tr>";
                }
            
            die;
        }
    }
    
    public function action_delete_ost(){
        $this->chek_permition();
        DB::delete('routecity')->where('route_city_id','=',$_GET['ost_id'])->execute();
        DB::delete('routecity_i18n')->where('route_city_id','=',$_GET['ost_id'])->execute();
        $this->redirect('/ost');
    }
    
    public function action_search_ajax_city(){
        if($_POST){
            echo '<script type="text/javascript">
                    $(\'.ajax_p\').click(function(){
                        $(".city_ajax").val($(this).text());
                        $(".ajax_bl").html("");
                    })
                </script>';
            $lang = $_POST['lang'];
            $search_arr = array();
            $search = DB::select('city_i18n')->from('routecity_i18n')->join('routecity')->on('routecity_i18n.route_city_id','=','routecity.route_city_id')
            ->where('routecity_i18n.city_i18n','LIKE','%'.$_POST['ost'].'%')
            ->and_where('routecity_i18n.culture','=',$lang)
            ->order_by('routecity.route_city_id','DESC')->limit(30)->execute()->as_array();
            if(!empty($search)){
                echo '<div style="padding:0 20px;">';
                foreach($search as $re){
                    echo '<p style="cursor:pointer;" class="ajax_p">'.$re['city_i18n'].'</p>';
                }
                echo '</div>';
            }
            die;
        }
    }
    
    public function action_del_ost_types_2(){
        $this->chek_permition();
        $al_ost = DB::select()->from('routecity')->join('ost_types')->on('routecity.route_city_id','=','ost_types.route_city_id')->where('type_id','=',2)->execute()->as_array();
        foreach($al_ost as $os){
            DB::delete('routecity')->where('route_city_id','=',$os['route_city_id'])->execute();
            DB::delete('routecity_i18n')->where('route_city_id','=',$os['route_city_id'])->execute();
        }
        echo count($al_ost);
        die;
        //$this->redirect('/ost/see_all');
    }
    
} // End ost
