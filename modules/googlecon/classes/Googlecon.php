<?
class Googlecon {

    public static function con($cur,$need,$amo) {
        $ret = array($amo,$cur);
        if($amo != '0.00'){
            if($cur != $need && $need != ''){
                $xml = file_get_contents('https://www.google.com/finance/converter?a='.$amo.'&from='.$cur.'&to='.$need);
                preg_match_all('!<span(.*?)>(.*?)</span>!si', $xml, $prices);
                //$pieces = explode(" ", $prices[2][0]);
                $new = $prices[2][0];
                $ret = explode(" ", $new);
                $ret[0] = round($ret[0],2);
            }
        }
        return $ret;
    }
    
    public static function con_sam($amo,$kurs) {
        //$ret = array($amo,$cur);
        //if($amo != '0.00'){
        //    if($cur != $need && $need != ''){
                //$xml = file_get_contents('https://www.google.com/finance/converter?a='.$amo.'&from='.$cur.'&to='.$need);
                //preg_match_all('!<span(.*?)>(.*?)</span>!si', $xml, $prices);
                //$pieces = explode(" ", $prices[2][0]);
                
                
                
                
         //       $new = $prices[2][0];
         $new_pri = $amo * $kurs;
         //$ret = array($new_pri);
        //        $ret[0] = round($ret[0],2);
        //    }
        //}
        return array($new_pri);
    }
}

