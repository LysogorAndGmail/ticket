<?
class Valute {

    public static function get_val() {
        //define('IP',$_SERVER['REMOTE_ADDR']);
        //$xml = file_get_contents('https://privat24.privatbank.ua/p24/accountorder?oper=prp&PUREXML&apicour&country=&full');
        $ch = curl_init();
   
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
       curl_setopt($ch, CURLOPT_URL, 'http://www.bank.gov.ua/control/uk/curmetal/detail/currency?period=daily');
       
       $val = curl_exec($ch);
       curl_close($ch);
       
        preg_match_all('!<table(.*?)>(.*?)</table>!si', $val, $prices);
        preg_match_all('!<tr(.*?)>(.*?)</tr>!si', $prices[0][3], $tr);
       // $val = new SimpleXMLElement($data);
      //  $valute = $val;
      //  $ewn = array($tr[0][6],$tr[0][7]);
      //$ewn = $tr;
        for($i = 1; $i<=27; $i++){
            $ewn[] = $tr[0][$i];
        }
        foreach($ewn as $cl){
            preg_match_all('!<td(.*?)>(.*?)</td>!si', $cl, $ner);
            $vv[$ner[2][1]] = $ner[2][4];
            
        }
        //echo '<pre>';
        //print_r($vv);
        //echo '</pre>';
        //die;
        //if(empty($country)){
        //    $country = 'Не определено!';
        //}
        return $vv;
    }
}

