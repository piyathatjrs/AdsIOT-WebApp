<?php

$Uid_Notify = $_GET['Uid'];
$message = $_GET['message'];
$val = $_GET['val'];
$unit = $_GET['unit'];
 
$strAccessToken = "Trkk6NZiJgsrk7qFr1klaMA32EKjvqmigI48XGk6hKPw2AIVyxw6IU6tdj5rOBQRrU+H/dm0IZoQNoqtVsjfttxAlmTwoVggvUBGgyDRaFqT6ZVQTeN99kqaDJx9ycxKTGYUXwxuxq7k6hv/qVkJvQdB04t89/1O/w1cDnyilFU=";
 
$strUrl = "https://api.line.me/v2/bot/message/push";
 
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
 
$arrPostData = array();
$arrPostData['to'] = "$Uid_Notify";
// $arrPostData['to'] = "U1222b3980cb7a3c2ef703b59a4784d3d";
$arrPostData['messages'][0]['type'] = "text";
$arrPostData['messages'][0]['text'] = "$message".$val."$unit ]]";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);
 
?>