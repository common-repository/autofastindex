<?php

if (isset($_POST['testgoogle'])) {
    include_once('bingtest.php');

    try{
        $get = get('userDetails');
        $obj_merged = (object) array_merge((array) $get, (array) get());
        $data = $obj_merged;
        $site = $data->url;
        $email = $data->email;
    
        $file = $data->google_json_file;
    

    
        $result = google($site, $data, $email,$data->originalUrl);
        echo "<div class='notice notice-success'>" . esc_attr($result->msg ? $result->msg : "Try again") . "</div>";
    }catch(\Error $e){
        addLog($e,'testGoogle');
    }

}

if (isset($_POST['direct'])) {
    include_once('bingtest.php');
    $get = get('userDetails');
    $obj_merged = (object) array_merge((array) $get, (array) get());
    $data = $obj_merged;
    $site = $data->url;
    $email = $data->email;

    $file = $data->google_json_file;

    $result = direct($site, $site, $data, $email);

   // $result = complete($site, $data, $email,$site);
    echo "<div class='notice notice-success'>" . esc_attr($result->msg) . "</div>";
}

if (isset($_POST['testbing'])) {


    include_once('bingtest.php');

    try{
        $get = get('userDetails');
    $obj_merged = (object) array_merge((array) $get, (array) get());
    $data = $obj_merged;
        $site = $data->originalUrl;
        $bingapi = $data->bingapi;
        //  $file=$data->google_json_file;
        $email = $data->email;
    
    
        $result = bing($site, $site, $bingapi, $email,$data);
        echo "<div class='notice notice-success'>" . esc_attr($result->msg ? $result->msg : "Try Again") . "</div>";

    }catch(\Error $e){
        addLog($e,'testBing');

    }
}

if (isset($_POST['yandex'])) {
    include_once('bingtest.php');

    try{
        $get = get('userDetails');
        $obj_merged = (object) array_merge((array) $get, (array) get());
        $data = $obj_merged;
        $site = $data->url;
        $userId=$data->yandex_UserId;
        $hostId=$data->yandex_HostId;
        $auth=$data->yandex_AuthKey;
        $email = $data->email;
    
        $result = yandex($site, $site,$userId,$hostId,$auth,$data,$email);
    
    
        echo "<div class='notice notice-success'>" . esc_attr($result->msg) . "</div>";
    
    }catch(\Error $e){
        addLog($e,'testYandex');
    }
}

if(isset($_POST['disconnect'])){
    unlink(autoindex_upload. '/userDetailV2.json');
    unlink(autoindex_upload. '/settingsV2.json');
    unlink(autoindex_upload. '/notification.json');
    unlink(autoindex_upload. '/settingsv2.json');
    echo "<div class='notice notice-success'>" . esc_attr("Account Disconnected") . "</div>";
}



?>