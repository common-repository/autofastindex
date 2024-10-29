<?php
$configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
$configapi = json_decode($configapi);

function get_domain_name($url) {
    // Add scheme if missing
    if (strpos($url, '://') === false) {
        $url = 'http://' . $url;
    }
    // Validate URL
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return false;
    }
    // Parse URL and get host
    $host = parse_url($url, PHP_URL_HOST);
    // If no host, return false
    if (!$host) {
        return false;
    }
    // Remove "www." if it exists
    if (substr($host, 0, 4) == "www.") {
        $host = substr($host, 4);
    }
    return $host;
}


if (isset($_POST['submitRegister'])) {

    try{
        $url = esc_url_raw(sanitize_text_field($_POST['url']));
        $url = rtrim($url,"/");
        $data["originalUrl"] = $url;
        $data["url"] = get_domain_name($url);
        $data['email'] = sanitize_email($_POST['email']);
        $postRequest = [
            "add" => "3",
            "email" => $data['email'],
            "site" => $data["url"],
            "version" => '3.1.0',
            "data" =>  base64_encode(wp_json_encode($data, JSON_PRETTY_PRINT))
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

        $response = wp_remote_post($configapi->api_url, $args);
        $response=json_decode($response['body']);

        write($data);
        echo "<script>window.location.reload();  </script>";
       // file_put_contents(autoindex_upload. '/settingsV2.json', wp_json_encode($data, JSON_PRETTY_PRINT));
    
    }catch(\Exceptio $e){

    }
}


if (isset($_POST['submitForm'])) {

    try{
        $storeData = get();
        if(!$storeData || !$storeData->email){
            echo "<script> alert('Please Connect Your Devices'); window.location.reload();  </script>";
            exit;
        }
        $userDetails = get('userDetails');
        $url = esc_url_raw(sanitize_text_field($storeData->url));
        $email = $storeData->email;
        $checkbox= ["pwaIndex", "microIndexing", "rotatingIndexer","enable_google","email_notification","whatsapp_notification", "enabledirectIndexing","enable_yandex","enable_bing","manual_index","backlink_index"];
        foreach($_POST as $k=>$v){
            if(in_array($k,$checkbox))  $_POST[$k] = $v=='on'? 1 : 0;
        }

        if(isset($_POST['google_json_text'])){
            $_POST['google_json_text'] = str_replace('\n','#n#',$_POST['google_json_text']);
            $_POST['google_json_text'] = str_replace('\\','',$_POST['google_json_text']);
            $_POST['google_json_text'] = str_replace('#n#','\n',$_POST['google_json_text']);
            $_POST['google_json_text'] = base64_encode($_POST['google_json_text']);
        }
        $oldArray = (array) $userDetails; // Convert $old to an array if it’s an object
        $_POST = array_merge($oldArray, $_POST); // Recursively merge the arrays

        $postRequest = [
            "email" => $email,
            "site" => $url,
            "version" => '3.1.0',
            "data" => wp_json_encode($_POST,JSON_PRETTY_PRINT)
        ];
        
        if(isset($_POST['column'])){
            foreach($_POST as $k=>$v) {
                $postRequest[$k] = $v;
            }  
        }

        $args = array(
            'body' => $postRequest,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array(),
        );

        $response = wp_remote_post($configapi->updateUser, $args);
        $response=json_decode($response['body']);

        // use details 
        $args['body'] = [
            'body'=>json_encode([
                "email" => $email,
                "site" => $url,
                'product' => 1,
                "version" => '3.1.0',
                "data" => $_POST
            ]),
            'method'=>"POST",
            'root'=>"firstPageRankersUsers",
            'querydata' =>json_encode(["email"=>$email,"site"=>$storeData->url])
        ];

        $response = wp_remote_post($configapi->userDetailsStats, $args);

        // Flush rewrite rules once after adding new rules
        flush_rewrite_rules(false);
        write($_POST,'userDetails');
        echo "<script> window.location.reload();  </script>";

       // file_put_contents(autoindex_upload. '/settingsV2.json', wp_json_encode($data, JSON_PRETTY_PRINT));
    
    }catch(\Exceptio $e){
        echo "<script> alert('Try again Later'); window.location.reload();  </script>";
    }
}
    ?> 

<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Registration Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">URL</label>
                            <input type="text" class="form-control" id="password" value="" name="url" required>
                        </div>
                        <button type="submit" name="submitRegister" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--    Google Popup -->
    <div class="modal fade" id="googleModal" tabindex="-1" aria-labelledby="googleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="googleModal">Google Integration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                            <label class="form-check-label" for="integration1Switch">Enable Google Indexing</label>

                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            
                            <input type="hidden" name="enable_google"  value="off">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" <?php echo @$integration->enable_google == 1 ?'checked="checked"':null ?>  name="enable_google"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            <div class="mb-3">
                                <label for="google_json_text" class="form-label">Google Json Content:</label>
                                <textarea class="form-control" id="jsonInput" name="google_json_text" rows="5" required><?= base64_decode(str_replace('\\','',@$integration->google_json_text));  ?></textarea>
                            </div>
                              
                            </div>
                            <div class="col-md-6">
                                <div class="ratio ratio-16x9">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/mB1q5tjs22I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                            <input type="hidden" name="formType" value="google"/>
                            <input type="hidden" name="google_json_text_enable" value="1"/>

                            

                        </div>
                        <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
                            <form action="post" action="">    
                               <button type="submit" name="testgoogle" class="btn btn-primary">Test</button>
                            </form>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!--    DirectModal Popup -->
        <div class="modal fade" id="directModal" tabindex="-1" aria-labelledby="directModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="directModal">Direct Integration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                            <label class="form-check-label" for="integration1Switch">Enable Direct Indexing</label>

                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            
                            <input type="hidden" name="enabledirectIndexing"  value="off">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" <?php echo @$integration->enabledirectIndexing == 1 ?'checked="checked"':null ?>  name="enabledirectIndexing"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                              
                            </div>
                        </div>
                        <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
                            <form action="post" action="">    
                               <button type="submit" name="direct" class="btn btn-primary">Test</button>
                            </form>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

            <!--    BingModal Popup -->
            <div class="modal fade" id="bingModal" tabindex="-1" aria-labelledby="bingModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="bingModal">Bing Integration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label class="form-check-label" for="integration1Switch">Enable Service</label>

                                    <div class="col-sm-9 form-check form-switch me-2 mt-2">
                                    
                                    <input type="hidden" name="enable_bing"  value="off">
                                    <input type="checkbox" class="form-check-input" id="acceptTerms" <?php echo @$integration->enable_bing == 1 ?'checked="checked"':null ?>  name="enable_bing"  value="on">
                                        <label class="form-check-label" for="integration1Switch"></label>
                                    </div>

                                    <div class="col-md-12">
                                    <label class="control-label col-sm-12" for="pwd">Bing Api Key:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="pwd" placeholder="" name="bingapi"
                                            value="<?php echo esc_html($integration->bingapi); ?>">
                                    </div>

                                    </div>


                                    <div class="col-md-12">
                                    <label class="control-label col-sm-12" for="pwd">Bing Url: (as mentioned in webmaster)</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="pwd" placeholder="" name="bingHostUrl"
                                            value="<?php echo esc_html($integration->bingHostUrl); ?>">
                                    </div>

                                    </div>


                                    </div>

                                    <div class="col-md-6">
                                        <div class="ratio ratio-16x9">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/J30T9M1uKss" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
                                    <form action="post" action="">    
                                    <button type="submit" name="testbing" class="btn btn-primary">Test</button>
                                    </form>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>



                <!--    YandexModal Popup -->
                <div class="modal fade" id="yandexModal" tabindex="-1" aria-labelledby="yandexModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                    <h5 class="modal-title" id="yandexModal">Yandex Integration</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <label class="form-check-label" for="integration1Switch">Enable Service</label>

                                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                                            
                                            <input type="hidden" name="enable_yandex"  value="off">
                                            <input type="checkbox" class="form-check-input" id="acceptTerms" <?php echo @$integration->enable_yandex == 1 ?'checked="checked"':null ?>  name="enable_yandex"  value="on">
                                                <label class="form-check-label" for="integration1Switch"></label>
                                            </div>

                                            <div class="col-md-12">
                                            <label class="control-label col-sm-2" for="pwd">User Id:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="pwd" placeholder="" name="yandex_UserId"
                                    value="<?php echo esc_html($integration->yandex_UserId); ?>">
                            </div>

                                            </div>

                                            <div class="col-md-12">
                                            <label class="control-label col-sm-2" for="pwd">Host Id:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="pwd" placeholder="" name="yandex_HostId"
                                    value="<?php echo esc_html($integration->yandex_HostId); ?>">
                            </div>
                </div>

<div class="col-md-12">
<label class="control-label col-sm-12" for="pwd">Authorization key:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="pwd" placeholder="" name="yandex_AuthKey"
                       value="<?php echo esc_html($integration->yandex_AuthKey); ?>">
            </div>
</div>
                            </div>


                            <div class="col-md-6">
                            <a target="_blank"
           href="https://firstpageranker.com/yandexApi.php">
            Generate Key </a>
        <br/>
                                <div class="ratio ratio-16x9">
                                    
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/gJf9rMvH1Bg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
                            <form action="post" action="">    
                               <button type="submit" name="yandex" class="btn btn-primary">Test</button>
                            </form>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>














