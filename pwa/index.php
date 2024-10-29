<?php
error_reporting(1);
define('autoindex_upload',$autoindex_dirname);

// Add query variable to catch post ID
function pwa_add_query_vars($vars) {
    $vars[] = 'pwa_post_id';
    $vars[] = 'custom_pid';
    return $vars;
}
add_filter('query_vars', 'pwa_add_query_vars');

function pwa_template_redirect() {
    $post = get_post($_GET['pid']);
        // Uncomment for debugging:

    if (!$post) {
    return;
    }
    $permalink = get_permalink($post->ID);

          // Get the current URL path
    $request_uri = $_SERVER['REQUEST_URI'];
    // Check if the URL contains "pwa"
    if (strpos($request_uri, '/pwa') !== false) {
        if ($post) {
            // Optionally set up post data if you're using WordPress template tags
            setup_postdata($post);

            add_action('wp_head', 'pwa_enqueue_scripts');
            
            // Hook the function to 'the_content' filter
            
            // Include the custom template
            include plugin_dir_path(__FILE__) . 'pwa-template.php';

            // Stop further processing
            exit;
        }
    }
}



add_action('template_redirect', 'pwa_template_redirect');

// Enqueue the service worker and manifest
function pwa_enqueue_scripts() {
    echo '<link rel="manifest" href="' . plugin_dir_url(__FILE__) . 'manifest.json">';
    echo '<script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("' . plugin_dir_url(__FILE__) . 'service-worker.js")
            .then(function(reg) {
                console.log("Service Worker registered with scope: ", reg.scope);
            })
            .catch(function(err) {
                console.log("Service Worker registration failed: ", err);
            });
        }
    </script>';
}

$get = file_get_contents(autoindex_upload .'/settingsv2.json');
$storeData = json_decode($get);

if($storeData && $storeData->pwaIndex){
    add_filter('the_content', 'add_pwa_icon_to_content');
}


function add_pwa_icon_to_content($content) {
  
    global $post;
    if (!is_admin()) {
       
        $request_uri = $_SERVER['REQUEST_URI'];
        $pwa_url = home_url('/pwa?pid='.$post->ID.'&title='.$post->post_title); // Adjust URL as needed
        // HTML for the icon link
        $icon_html = '<div style="display:none;" class="pwa-icon"><a alt="pwa by firstpagerankers.com" href="' . esc_url($pwa_url) . '">PWA Content</a></div>';

        // Append the icon HTML to the content
        $content .= $icon_html;
    }

    return $content;
}


?>