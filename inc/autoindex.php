<?php
include_once('bingtest.php');
include_once('logs.php');
// check();

$get = file_get_contents(autoindex_upload . '/settingsv2.json');
$data = json_decode($get);
$site = $data->url;

$bingapi = $data->bingapi;
$file = $data->google_json_file;
$email = $data->email;
$url = $data->url;
$originalUrl = $data->originalUrl;
$permalink = get_permalink($id);

  try{
    $result = complete($url, $data, $email, $permalink,$originalUrl);
  }catch(\Error $e){
    //addLog($e,'autoIndex');
  }
   
   


?>