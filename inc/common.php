<?php

function getFile($file){
    if($file=='gnotification')  return '/gnotification.json';

    return '/settingsv2.json';
}
function recursiveMerge($old, $new) {
    foreach ($new as $key => $value) {
        if (is_array($value) && isset($old[$key]) && is_array($old[$key])) {
            $old[$key] = recursiveMerge($old[$key], $value);
        } else {
            $old[$key] = $value;
        }
    }
    return $old;
}

function write($data,$file='/settingsv2.json'){
    $old = get($file);
    $mainData = null;
    if(!$old){
        $mainData = $data;
        file_put_contents(autoindex_upload. getFile($file), json_encode($data, JSON_PRETTY_PRINT));
    }else{
        $oldArray = json_decode(json_encode($old), true); // Convert $old to an associative array
        $mergedData = recursiveMerge($oldArray, $data); // Recursively merge the arrays
        $mainData = $mergedData;

        file_put_contents(autoindex_upload. getFile($file), json_encode($mergedData, JSON_PRETTY_PRINT));


    }
}

function get($file='/settingsv2.json'){

    try{
        $get = file_get_contents(autoindex_upload .getFile($file));
        if(!$get)  return false;
        $data = json_decode($get);
        return $data;
    
    }catch(\Exception $e){
        return false;
    }
    
}

function getUserData(){
    $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
    $configapi = json_decode($configapi);
    try{

        $stor = get();
        $postRequest = [
            "email" => $stor->email,
            "site" => $stor->url
        ];
        $args = array(
            'body' => $postRequest,
            'timeout' => '30',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
        );
       
        try{
            $apiResponse = wp_remote_post($configapi->getUser, $args);
           
        }catch(\Error $e){
             addLog($e,'apiRequest',$postRequest);
        }
        $apiResponse = $apiResponse['body'];
     
        return json_decode($apiResponse);

    }catch(\Exception $e){
   
    }


}



?>