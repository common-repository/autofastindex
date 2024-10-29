<?php
include_once('logs.php');


function complete($site,$data,$email,$perma,$originalUrl = null){

    try{

        $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
        $configapi = json_decode($configapi);
        $api_url = $configapi->completeIndex;
        $post_url = $configapi->sendRequest;
        $notificationAfterIndex = $configapi->notificationAfterIndex;
    
        $userId=$data->yandex_UserId;
        $hostId=$data->yandex_HostId;
        $auth=$data->yandex_AuthKey;
        $api=$data->bingapi;
       
        $data->google_json_text = base64_decode($data->google_json_text);

        $postData=[
            'data'=>json_encode([
                'version' => '3.1.0',
                'data' => $data,
                "email" =>$email,
                "site" => $site,
                "originalUrl" => $originalUrl?$originalUrl:'https://'.$site,
                "test" => false,
                "link" => $perma,
                "userId"=>$userId,
                "hostId"=>$hostId,
                "auth"=>$auth,
                "bingapi" => $api
            ]),
            'url'=>$api_url,
            'method'=>"POST"
            ];
        $args = array(
            'body' => $postData,
            'timeout' => '30',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
        );
        try{
            $apiResponse = wp_remote_post($post_url, $args);
        }catch(\Error $e){
            addLog($e,'apiRequest',$postData);
        }

        $args['body'] = [
            "email" =>$email,
            "site" => $site,
            "test" => false,
        ];
        try{
            $apiResponse = wp_remote_post($notificationAfterIndex, $args);
        }catch(\Error $e){
            addLog($e,'apiRequest',$postData);
        }

        $apiResponse = base64_encode(wp_json_encode($data, JSON_PRETTY_PRINT));
        //$apiResponse['bod'] = $apiResponse['body'];

        if (isset(json_decode($apiResponse)->notification)) {
    
            file_put_contents(autoindex_upload. '/notification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->notification], JSON_PRETTY_PRINT));
        }
    
        if (isset(json_decode($apiResponse)->globalNotification) !== '') {
            file_put_contents(autoindex_upload. '/gnotification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->globalNotification,"globalNotificationHref"=>json_decode($apiResponse)->globalNotificationHref ], JSON_PRETTY_PRINT));
        }
    
        return json_decode($apiResponse);


    }catch(\Error $e){
        addLog($e,'complete');

    }

 

}


function google($site, $data, $email, $perma = null)
{


    try{

        $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
        $configapi = json_decode($configapi);
        $api_url = $configapi->request_api;
    
        if (!$perma) {
            $perma = $site;
        }
    
        $send = [];
        $send['err'] = 1;
    
    
        $data->google_json_text = base64_decode($data->google_json_text);
       

        $postRequest = [
            "data" =>  $data,
            "type" => "google",
            "email" => $email,
            "version" => "3.1.0",
            "site" => $site,
            "test" => $perma==null?true:false,
            "link" => $perma
        ];
    
        $args = array(
            'body' => $postRequest,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
        );
    
            
        try{
            $apiResponse = wp_remote_post($api_url, $args);
        }catch(\Error $e){
            addLog($e,'apiRequest',$postRequest);
        }

        $apiResponse = $apiResponse['body'];

      
        if (isset(json_decode($apiResponse)->notification)) {
    
    
            file_put_contents(autoindex_upload. '/notification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->notification], JSON_PRETTY_PRINT));
    
        }
    
    
        return json_decode($apiResponse);

    }catch(\Error $e){
        addLog($e,'google');

    }


}

function bing($site, $link, $api, $email,$data)
{

    try{

        
    $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
    $configapi = json_decode($configapi);
    $api_url = $configapi->request_api;


    $postRequest = [
        "data" =>  $data,
        "type" => "bing",
        "version" => "3.1.0",
        "email" => $email,
        "site" => $site,
        "link" => $link,
        "bing_api" => $api
    ];


    $args = array(
        'body' => $postRequest,
        'timeout' => '5',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array(),
    );

                
    try{
        $apiResponse = wp_remote_post($api_url, $args);
    }catch(\Error $e){
        addLog($e,'apiRequest',$postRequest);
    }
    $apiResponse = $apiResponse['body'];

    if (isset(json_decode($apiResponse)->notification)) {


        file_put_contents(autoindex_upload. '/notification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->notification], JSON_PRETTY_PRINT));

    }

    return json_decode($apiResponse);

    }catch(\Error $e){
        addLog($e,'bing');


    }



}


function direct($site, $link,$data,$email){


    try{

        $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
        $configapi = json_decode($configapi);
        $api_url = $configapi->request_api;
    
    
        $postRequest = [
            "data" =>  $data,
            "type" => "direct",
            "version" => "3.1.0",
            "email" => $email,
            "site" => $site,
            "link" => $link,
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
            $apiResponse = wp_remote_post($api_url, $args);
        }catch(\Error $e){
            addLog($e,'apiRequest',$postRequest);
        }
        $apiResponse = $apiResponse['body'];

        if (isset(json_decode($apiResponse)->notification)) {
    
    
            file_put_contents(autoindex_upload. '/notification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->notification], JSON_PRETTY_PRINT));
    
        }
    
        return json_decode($apiResponse);
    

    }catch(\Error $e){
        addLog($e,'direct');


    }
  

}


function yandex($site, $link, $userId,$hostId, $auth,$data,$email)
{


    try{

        $configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
        $configapi = json_decode($configapi);
        $api_url = $configapi->request_api;
    
    
        $postRequest = [
            "data" =>  $data,
            "version" => "3.1.0",
            "type" => "yandex",
            "userId"=>$userId,
            "hostId"=>$hostId,
            "auth"=>$auth,
            "email" => $email,
            "site" => $site,
            "link" => $link,
        ];
    
    
        $args = array(
            'body' => $postRequest,
            'timeout' => '80',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
        );
    
                
        try{
            $apiResponse = wp_remote_post($api_url, $args);
        }catch(\Error $e){
            addLog($e,'apiRequest',$postRequest);
        }
    
        $apiResponse = $apiResponse['body'];
    
    
    
        if (isset(json_decode($apiResponse)->notification)) {
    
    
            file_put_contents(autoindex_upload. '/notification.json', wp_json_encode(["request_notify" => json_decode($apiResponse)->notification], JSON_PRETTY_PRINT));
    
        }
    
        return json_decode($apiResponse);

    }catch(\Error $e){
        addLog($e,'yandex');


    }

 

}


?>