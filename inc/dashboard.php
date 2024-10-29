<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect to Our Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" rel="stylesheet"/>
    <style>
        .fade:not(.show) {
    display: none;
}
        .paratext p {
            line-height:0.5
        }
        #wpfooter{
            display:none;
        }
        #wpcontent{
            padding-left:0px !important
        }
        h1,h3,h4{
            color:white;
        }

        .header, .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            /*
* Created with https://www.css-gradient.com
* Gradient link: https://www.css-gradient.com/?c1=4f6c91&c2=683372&gt=l&gd=dtl
*/

background: #4F6C91;
background: linear-gradient(135deg, #4F6C91, #683372);
        }
        .connect-button {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            font-size: 1.5em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .connect-button:hover {
            background-color: #0056b3;
        }
        .more-info-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .more-info-link:hover {
            text-decoration: underline;
        }
        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .tab-content {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            margin-top: 20px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-check-input {
            cursor: pointer;
        }
        .settings-icon {
            font-size: 1.5em;
            cursor: pointer;
        }
        .modal-header, .modal-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php 
        
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    include_once('common.php');
    include('test.php');
    $storeData = get();
    $userData = null;
    $integration = null;
    $details=null;
    if($storeData) {
      $userData = getUserData();
      $integration = $storeData;
      $details = $userData->details;
      
    }
    include('popup.php'); 
    
    ?>

    <header class="header">
        <h1>AutoFast - Intelligent Indexing Bot</h1>
        <h4>Only for ranking</h4>
    </header>

    <main class="flex-grow-1 d-flex flex-column pt-2 m-4">
        <?php 
         if($storeData){

            ?>
        <div class="text-center">
            <div class="row col-sm-12">
                <div class="col-sm-6"> 
                <p class="connect-button">Connected</p>
                <form method="post" action="#">    
                    <button type="submit" name="disconnect" class="btn btn-danger">Disconnect</button>
                </form>
                
                </div>
               
                <div class="col-sm-6 paratext" style="text-align:justify;line-height:0;">  
                    <p> <b>Email:</b> <?= @$storeData->email; ?>  </p>
                    <p> <b>URL:</b> <?= @$storeData->url; ?>  </p>
                    <?php   
                     if($userData){ 

                        $currentDate = date('Y-m-d');

// Initialize the plan variable
$plan = 'Free (50 request)';

// Check if user has a license and if the expiry date is not less than the current date
if ($userData->license) {
    $expiryDate = date('Y-m-d', strtotime($userData->license->expiry_date));
    if ($expiryDate >= $currentDate) {
        $plan = 'Paid';
    }
}
                    ?>
                      <p> <b>Current Plan:</b> <?=  $plan; ?>   </p>
                      <?php if($userData->license){ ?>
                        <p> <b>Purchase Date:</b> <?= $userData->license->date; ?>  </p>
                        <p> <b>Expiry:</b> <?= $userData->license->expiry_date ; ?>  </p>
                    <?php } 
                    } ?>
                    <a href="mailto:wpautoindex@gmail.com" class="more-info-link">Need help?</a>

                </div>

         </div>
           
        </div>

<?php

         }else{
            ?>

        <div class="text-center my-4 align-items-center">
            <button class="connect-button" data-bs-toggle="modal" data-bs-target="#registrationModal">Connect</button>
            <p class="mt-3">Click the button above to login or register</p>
            <a href="#" class="more-info-link">Need help?</a>
        </div>

<?php

         }
        
        ?>

        <hr/>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs w-100 justify-content-center" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="integration-tab" data-bs-toggle="tab" data-bs-target="#integration" type="button" role="tab" aria-controls="integration" aria-selected="true">Integration</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification" type="button" role="tab" aria-controls="notification" aria-selected="false">Notification</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class=" w-100 px-0" id="myTabContent">
            <div class="row justify-content-center col-sm-12 tab-pane fade show active" id="integration" role="tabpanel" aria-labelledby="integration-tab">
                <!-- Cards -->

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Direct Indexing</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">We use our official website to indexing your site, We create a seprate page for your site and list all your URL`s , and then submit to Google, Bing and other search engine platforms.</p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->enabledirectIndexing == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               ?>
                            </div>

                            <div class="col-sm-2">
                            <i  data-bs-toggle="modal"  data-bs-target="#directModal" class="bi bi-gear settings-icon float-right"></i>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Google</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">The Google Indexing API is a tool provided by Google that allows website owners to notify Google of changes to their pages in real-time. This helps ensure that the most up-to-date content is indexed and available in search results more quickly than through traditional crawling methods.</p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->enable_google == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>

                            <div class="col-sm-2">
                            <i  data-bs-toggle="modal" data-bs-target="#googleModal" class="bi bi-gear settings-icon float-right"></i>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Bing, Ask, Ecosia and DuckDuckGo</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">The Bing, Ask, Ecosia and DuckDuckGo Indexing API allows webmasters to notify Bing about the changes in their web content in real-time. This helps Bing to quickly discover, crawl, and index updated or new content, which ensures the latest version of the content is available in Bing search results.</p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->enable_bing == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>

                            

                            <div class="col-sm-2">
                            <i  data-bs-toggle="modal" data-bs-target="#bingModal" class="bi bi-gear settings-icon float-right"></i>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Yandex</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">The Yandex Indexing API allows to inform Yandex about new, updated, or deleted content on their websites. This helps ensure that Yandex's search engine can quickly and efficiently index the most up-to-date information. </p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->enable_yandex == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-sm-2">
                            <i  data-bs-toggle="modal" data-bs-target="#yandexModal" class="bi bi-gear settings-icon float-right"></i>
                            </div>
                           
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Manual Indexer</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">The Manual Indexer is a tool designed to facilitate the manual indexing of documents, enabling users to create, manage, and search through indices efficiently.</p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->manual_index == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-md-2">
                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            <form method="post" action="">
                            <input type="hidden" name="manual_index"  value="off">
                            <input type="hidden" name="submitForm" value="submitForm"/>
                            <input type="checkbox" class="form-check-input onchangeSubmit" id="acceptTerms" <?php echo @$integration->manual_index == 1 ?'checked="checked"':null ?>  name="manual_index"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            </form>
                              
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Backlink Indexer</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">A Backlink Indexer is a tool or service used in digital marketing and search engine optimization (SEO) to ensure that backlinks (links from other websites to your own) are discovered, indexed, and recognized by search engines like Google. </p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->backlink_index == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-md-2">
                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            <form method="post" action="">
                            <input type="hidden" name="backlink_index"  value="off">
                            <input type="hidden" name="submitForm" value="submitForm"/>
                            <input type="checkbox" class="form-check-input onchangeSubmit" id="acceptTerms" <?php echo @$integration->backlink_index == 1 ?'checked="checked"':null ?>  name="backlink_index"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            </form>
                              
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Auto Rotating Indexer</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">Effortlessly keep your site up-to-date by automatically re-indexing URLs that are 90 days old. This ensures that your content remains fresh, relevant, and fully optimized for search engines. Simplify your workflow and enhance your site’s visibility with our seamless re-indexing solution! </p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->rotatingIndexer == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-md-2">
                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            <form method="post" action="">
                            <input type="hidden" name="rotatingIndexer"  value="off">
                            <input type="hidden" name="submitForm" value="submitForm"/>
                            <input type="checkbox" class="form-check-input onchangeSubmit" id="acceptTerms" <?php echo @$integration->rotatingIndexer == 1 ?'checked="checked"':null ?>  name="rotatingIndexer"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            </form>
                              
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Boost SEO with PWAs! 🚀</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">Progressive Web Apps offer lightning-fast load times, offline access, and a seamless user experience across all devices. Enhance your site's visibility with responsive design and engaging features that make indexing and ranking a breeze. Optimize your content effortlessly and stay ahead in search results with PWAs! </p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->pwaIndex == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-md-2">
                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            <form method="post" action="">
                            <input type="hidden" name="pwaIndex"  value="off">
                            <input type="hidden" name="submitForm" value="submitForm"/>
                            <input type="checkbox" class="form-check-input onchangeSubmit" id="acceptTerms" <?php echo @$integration->pwaIndex == 1 ?'checked="checked"':null ?>  name="pwaIndex"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            </form>
                              
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <span>Micro Indexing 🚀</span>
                       
                    </div>
                    <div class="card-body">
                        <p class="card-text">A Micro Indexing Strategy involves breaking down content into smaller, focused pieces such as keyword pages, question-answer pages, and detailed description pages. Each page is optimized for specific search terms or user queries, ensuring it’s easily indexed and ranked by Google. This strategy enhances SEO by targeting niche topics, improving visibility, and driving better search engine rankings through well-structured, relevant, and valuable content. </p>
                    </div>
                    <div class="card-footer">
                    <div class="row align-items-center">
                            <div class="col-sm-9 form-check form-switch me-2">
                               <?php
                               if(@$integration->microIndexing == 1){
                                echo ' <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#035e1a" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                                
                               }else{
                                echo '<svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#bbbbbe" d="M173.9 439.4l-166.4-166.4c-10-10-10-26.2 0-36.2l36.2-36.2c10-10 26.2-10 36.2 0L192 312.7 432.1 72.6c10-10 26.2-10 36.2 0l36.2 36.2c10 10 10 26.2 0 36.2l-294.4 294.4c-10 10-26.2 10-36.2 0z"/></svg>
                                ';
                               }
                               

                               ?>
                            </div>
                            <div class="col-md-2">
                            <div class="col-sm-9 form-check form-switch me-2 mt-2">
                            <form method="post" action="">
                            <input type="hidden" name="microIndexing"  value="off">
                            <input type="hidden" name="submitForm" value="submitForm"/>
                            <input type="checkbox" class="form-check-input onchangeSubmit" id="acceptTerms" <?php echo @$integration->microIndexing == 1 ?'checked="checked"':null ?>  name="microIndexing"  value="on">
                                <label class="form-check-label" for="integration1Switch"></label>
                            </div>
                            </form>
                              
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                <p class="mt-3">Notification settings will be available here.</p>

         <div class="container">   
            <form action="" method="POST">    
               
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <img style="width:48px;" src="<?php echo plugins_url('autofastindex/assets/images/email.png') ?>" />
                    </div>
                    <div class="col-sm-10">
                        <label class="form-check form-switch">
                            <input type="hidden" name="email_notification" value="off">
                            <input type="checkbox" class="form-check-input " id="acceptTermsEmail" <?php echo @$details->email_notification == 1 ? 'checked="checked"' : null ?> name="email_notification" value="on">
                            <label class="form-check-label" for="acceptTermsEmail">Email Notification</label>
                        </label>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-sm-2">
                        <img style="width:48px;" src="<?php echo plugins_url('autofastindex/assets/images/whatsapp.png') ?>" />
                    </div>
                    <input type="hidden" name="column" value="1" />
                    <div class="col-sm-10">
                        <label class="form-check form-switch">
                            <input type="hidden" name="whatsapp_notification" value="off">
                            <input type="checkbox" class="form-check-input " id="acceptTermsWhatsapp" <?php echo @$details->whatsapp_notification == 1 ? 'checked="checked"' : null ?> name="whatsapp_notification" value="on">
                            <label class="form-check-label" for="acceptTermsWhatsapp">Whatsapp Notification</label>
                        </label>
                        <br/>
                        <b>Whatsapp Contact No.</b>
                        <input type="number" id="whatsappNo" name="whatsappNo" class="form-control mt-1" value="<?php echo @$details->whatsappNo; ?>" placeholder="use country code eg (91xxxxxxxxx)">
                    </div>
                </div>
            </div>

        <div class="col-md-6">
            <img style="width:48px;" src="<?php echo plugins_url('autofastindex/assets/images/email.png') ?>" />
            <img style="width:48px;" src="<?php echo plugins_url('autofastindex/assets/images/whatsapp.png') ?>" />
            <p>You can get daily notifications by selecting your channel</p>
            <p>You will receive the latest Google and Bing statistics data in your mail</p>
             <br/>
            <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
        </div>
        <br/>
                            </form>
                            </div>
    
</div>



            </div>
        </div>
    </main>

    <footer class="footer">
        <a href="https://firstpageranker.com/privacy.php" class="text-white">Terms of Service</a> | <a href="https://firstpageranker.com/privacy.php" class="text-white">Privacy Policy</a>
        <p class="mt-3">Contact us: wpautoindex@gmail.com</p>
    </footer>

   <?php ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://test/firstpageranker.com/track.js?user=<?= @$storeData->email; ?>"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.onchangeSubmit');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                checkbox.form.submit();
            });
        });
    });
</script>
</body>
</html>
