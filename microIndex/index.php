<?php
//error_reporting(1);
include('micro.php');

// Add query variable to catch post ID
function micro_add_query_vars($vars) {
    $vars[] = 'micro_post_id';
    return $vars;
}
add_filter('query_vars', 'micro_add_query_vars');

$get = file_get_contents(autoindex_upload .'/settingsv2.json');
$storeData = json_decode($get);

if($storeData && $storeData->microIndexing){
    add_filter('the_content', 'add_micro_icon_to_content');
}


function micro_template_redirect() {
    $post = get_post($_GET['pid']);
    if (!$post) {
    return;
    }
    // Get the current URL path
    $request_uri = $_SERVER['REQUEST_URI'];
    $permalink = get_permalink($post->ID);
    // Check if the URL contains "pwa"
    if (strpos($request_uri, '/keywords') !== false) {
        if ($post) {
            // Optionally set up post data if you're using WordPress template tags
            setup_postdata($post);

            //add_action('wp_head', 'pwa_enqueue_scripts');
            $readedPostData = getData($post->ID,$post);

            // Hook the function to 'the_content' filter
            $keywords = $readedPostData['keywords'];
            $description = $readedPostData['description'];
            // Include the custom template
            include plugin_dir_path(__FILE__) . 'keyword-template.php';

            // Stop further processing
            exit;
        }
    }
    if (strpos($request_uri, '/questionAnswers') !== false) {
        if ($post) {
            // Optionally set up post data if you're using WordPress template tags
            setup_postdata($post);
            $readedPostData = getData($post->ID,$post);
         
            $qna = $readedPostData['qna'];
            //add_action('wp_head', 'pwa_enqueue_scripts');
            
            // Hook the function to 'the_content' filter
            
            // Include the custom template
            include plugin_dir_path(__FILE__) . 'question-template.php';

            // Stop further processing
            exit;
        }
    }


}

add_action('template_redirect', 'micro_template_redirect');

function add_micro_icon_to_content($content) {
    if (!is_admin()) {
        global $post;
        $request_uri = $_SERVER['REQUEST_URI'];
        $pwa_url = home_url('/keywords?pid='.$post->ID.'&title='.$post->post_title); // Adjust URL as needed
        $pwa_url1 = home_url('/questionAnswers?pid='.$post->ID.'&title='.$post->post_title); // Adjust URL as needed
        // HTML for the icon link
        $icon_html = '<div style="display:none;" class="pwa-icon"><a alt="keywords content by firstpagerankers.com" href="' . esc_url($pwa_url) . '">Keywords Content</a></div>';
        $icon_html.= '<div style="display:none;" class="pwa-icon"><a alt="question answer by firstpagerankers.com" href="' . esc_url($pwa_url1) . '">Question answer Content</a></div>';

        // Append the icon HTML to the content
        $content .= $icon_html;
    }

    return $content;
}



?>