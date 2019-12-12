<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pdf extends Model {
    
    public function save_pdf($name,$path,$html) {
        
        $root = $_SERVER['DOCUMENT_ROOT'].'/';
        $full_path = $root.$path.$name;
        $mpdf=new mpdf('');         
        $mpdf->h2toc = array('H3'=>0, 'H4'=>1);
        $mpdf->h2bookmarks = array('H3'=>0, 'H4'=>1);
        $mpdf->open_layer_pane = false;
        $mpdf->layerDetails[1]['state']='hidden';	// Set initial state of layer - "hidden" or nothing
        $mpdf->layerDetails[1]['name']='Correct Answers';
        $mpdf->layerDetails[2]['state']='hidden';	// Set initial state of layer - "hidden" or nothing
        $mpdf->layerDetails[2]['name']='Wrong Answers';
        $mpdf->WriteHTML($html);
        //$mpdf->Output();
        $mpdf->Output($full_path.'.pdf','F');
        return $path.$name.'.pdf';
        //exit;
        
    }
    
    public function sendmail($to,$tikets_array,$user,$order_id,$amount,$lang,$valute,$pincod){
        //$to = 'LysogorAnd@i.ua';
        //$massege = "<p><a href='http://svitgo.com/filename.pdf'>Скачать</a></p>";
        //Model::factory('Tiket')->sen($to,$massege);
        $config = Kohana::$config->load('mailer');
        $conf = $config->options;
        //print_r($conf);
        //die;
        //$swift = Email::connect($config);
        //$to = 'LysogorAnd@i.ua';
        $data = array();
        $data['user'] = $user;
        $data['tikets_array'] = $tikets_array;
        $data['order_id'] = $order_id;
        $data['amount'] = $amount;
        $data['lang'] = $lang;
        $data['valute'] = $valute;
        $data['pincod'] = $pincod;
        $from = 'order@svitgo.com';
        $from_name = 'Svitgo';
        $sub = ''. View::factory('pay/subgect_for_email',$data);
        $mes = ''. View::factory('pay/example_susses',$data); 
        $mailer = new Mailer(); 
        $sen = $mailer->send($from,$from_name,$to,$conf,$tikets_array,$sub,$mes);
        if($sen === true){
            echo 'ok';
        }else {
            echo 'her';
        }
    }
    
    public function sendmail_order_nikolo($order_id,$email){
        //$to = 'LysogorAnd@i.ua';
        //$massege = "<p><a href='http://svitgo.com/filename.pdf'>Скачать</a></p>";
        //Model::factory('Tiket')->sen($to,$massege);
        $config = Kohana::$config->load('mailer');
        $conf = $config->options;
        
        
        $res_tik_people = DB::select()->from('user_tiket')->where('join_tiket_id','=',$order_id)->execute()->current();
        $res_tik_user = DB::select()->from('users')->where('user_id','=',$res_tik_people['user_id'])->execute()->current();
        //$swift = Email::connect($config);
        //$to = 'info@svitstudio.com';
        $to = $email;//$res_tik_user['email'];//'svitstudio@gmail.com';
        $res = DB::select()->from('join_ticket')->where('id','=',$order_id)->execute()->current();
       
        
        $data = array();
        //$data['user'] = $user;
        $tikets_array = explode(',',$res['tikets']);
        array_pop($tikets_array);
        $data['tikets_array'] = $tikets_array;
        $data['order_id'] = $order_id;
        $data['amount'] = $res['full_price'];
        $data['lang'] = $res['lang'];
        $data['valute'] = $res['valute'];
        $data['pincod'] = $res['pincod'];
        $from = 'info@nikolo.cz';
        $from_name = 'Nikolo';
        
        $sub = ''. View::factory('pay/subgect_for_email',$data);
        
        $mes = ''. View::factory('pay/pdf_html_nikolo',$data); 
        //print_r($res);
        //die;
        $mailer = new Mailer(); 
        
        $sen = $mailer->send_simple($from,$to,$conf,$sub,$mes);
        //print_r($mailer);
        //die;
        if($sen === true){
            echo 'Send';
        }else {
            echo 'No send';
        }
    }
    
    public function has_dir($path){
        $root = $_SERVER['DOCUMENT_ROOT'].'/';
        $full_path = $root.$path;
        if(file_exists($full_path)){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function create_dir($path){
        $root = $_SERVER['DOCUMENT_ROOT'].'/';
        $full_path = $root.$path;
        mkdir($full_path, 0777);
        
    }
    
    function chek_dir_date(){
        $start_path = 'pdf_tickets/'.date('Y').'/'.date('m').'/'.date('d').'/';
        if($this->has_dir('pdf_tickets/'.date('Y')) == 0){
            $this->create_dir('pdf_tickets/'.date('Y'));
        }
        if($this->has_dir('pdf_tickets/'.date('Y').'/'.date('m')) == 0){
            $this->create_dir('pdf_tickets/'.date('Y').'/'.date('m'));
        }
        if($this->has_dir('pdf_tickets/'.date('Y').'/'.date('m').'/'.date('d')) == 0){
            $this->create_dir('pdf_tickets/'.date('Y').'/'.date('m').'/'.date('d'));
        }
        return $start_path;
    }
    
} // End PDF
