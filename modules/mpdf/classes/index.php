<?php

//ini_set("memory_limit","1024M");

include("mpdf.php");

$mpdf=new mPDF(''); 
//==============================================================
//$html = file_get_contents('http://svitgo.com/registration');
$html = '<p>Hello</p><h1>Drunia</h1>';

$mpdf->h2toc = array('H3'=>0, 'H4'=>1);
$mpdf->h2bookmarks = array('H3'=>0, 'H4'=>1);

$mpdf->open_layer_pane = false;
$mpdf->layerDetails[1]['state']='hidden';	// Set initial state of layer - "hidden" or nothing
$mpdf->layerDetails[1]['name']='Correct Answers';
$mpdf->layerDetails[2]['state']='hidden';	// Set initial state of layer - "hidden" or nothing
$mpdf->layerDetails[2]['name']='Wrong Answers';

$mpdf->WriteHTML($html);

$mpdf->Output(); exit; ?>