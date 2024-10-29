<?php
/**
 * Plugin Name:       AutoFastindex
 * Plugin URI:        https://firstpageranker.com
 * Description:       Accelerate your website indexing with Autoindex. Our plugin seamlessly integrates with Google Search Console and Bing Webmaster tools, ensuring faster indexing and improved search engine visibility.
 * Version:           3.1.0
 * Author:            AutoFastindex
 * License:           GPLv2 or later
 */


error_reporting(1);
if (!defined('ABSPATH')) {
    die("You Can not Access this file directly");
}
//If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}





add_filter(
    'upload_mimes',
    function ($types) {
        return array_merge($types, array('json' => 'text/plain'));
    }
);


function autoin_media_uploader_enqueue()
{
    wp_enqueue_media();
    wp_register_script('media-uploader', plugins_url('media-uploader.js', __FILE__), array('jquery'));
    wp_enqueue_script('media-uploader');
}

add_action('admin_enqueue_scripts', 'autoin_media_uploader_enqueue');

function autoin_send_notification($id, $post_obj)
{
    include('inc/autoindex.php');

}


function autoin_admin_connect_notification() {
    $class = 'notice notice notice-error';
    $message = " <a href='" . admin_url("admin.php?page=AutoFastindex") . "' >" . __("Your indexing service is not connected", 'sample-text-domain') . "</a>";
    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class),'' . $message);
}

add_action('publish_post', 'autoin_send_notification', 10, 2);
add_action( 'publish_product',  'autoin_send_notification', 10, 2);

function autoin_register_menu_pages()
{
    $get = file_get_contents(autoindex_upload .'/settingsv2.json');
    $storeData = json_decode($get);
    if(!$storeData){
        add_action('admin_notices', 'autoin_admin_connect_notification');
    }
   
    add_menu_page('AutoFast Index', 'AutoFast', 'manage_options', 'AutoFastindex', 'autoin_dashboard', 'https://firstpageranker.com/wpautoicon.ico');
    //add_menu_page('Dashboard', 'Dashboard', 'manage_options', 'AutoFastindex', 'autoin_dashboard', 'dashicons-thumbs-up');
    #add_submenu_page('AutoFastindex', 'Dashboard', 'Dashboard', 'manage_options', 'autoin dashboard', 'autoin_dashboard');
    // add_submenu_page('my-menu', 'Submenu Page Title', 'Settings', 'manage_options', 'Settings','my' );
    if($storeData && $storeData->manual_index){
        add_submenu_page('AutoFastindex', 'Manual Indexing', 'Manual Indexing', 'manage_options', 'Manual_Indexing', 'autoin_manual');
    }

    if($storeData && $storeData->backlink_index){
        add_submenu_page('AutoFastindex', 'Backlink Indexing', 'Backlink Indexing', 'manage_options', 'Backlink_Indexing', 'autoin_backlink');
    }


    add_submenu_page('AutoFastindex', 'Success logs', 'Success Logs', 'manage_options', 'successlogs', 'autoin_successlog');
    add_submenu_page('AutoFastindex', 'Lisense', 'Lisense', 'manage_options', 'lisense', 'autoin_lisense');
    #add_submenu_page('AutoFastindex', 'Notices', 'Notices', 'manage_options', 'notice', 'autoin_notice');

}

//require('microIndex/index.php');
$upload_dir = wp_upload_dir();
$autoindex_dirname = $upload_dir['basedir'].'/autoindex_do_not_delete_this_file';
if ( ! file_exists( $autoindex_dirname ) ) {
    wp_mkdir_p( $autoindex_dirname );
}


require('pwa/index.php');
require('microIndex/index.php');
function pwawp_add_rewrite_rules() {

    add_rewrite_rule(
        '^pwa',                    // URL pattern
        'index.php?custom_pid=',         // Rewrite to this query variable
        'top'                            // Priority
    );

    //add_rewrite_rule('^pwa/([a-zA-Z0-9-_~!$&\'()*+,;=:@]+)/?', 'index.php?p=$matches[1]', 'top');
}

add_action('init', 'pwawp_add_rewrite_rules');

add_action('init', 'microindexwp_add_rewrite_rules');
function microindexwp_add_rewrite_rules() {
    add_rewrite_rule(
        '^keywords',                    // URL pattern
        'index.php?custom_pid=',         // Rewrite to this query variable
        'top'                            // Priority
    );
    add_rewrite_rule(
        '^questionAnswers',                    // URL pattern
        'index.php?custom_pid=',         // Rewrite to this query variable
        'top'                            // Priority
    );
    //add_rewrite_rule('^keywords/([a-zA-Z0-9-_~!$&\'()*+,;=:@]+)/?', 'index.php?micro_post_id=$matches[1]', 'top');
    //add_rewrite_rule('^questionAnswers/([a-zA-Z0-9-_~!$&\'()*+,;=:@]+)/?', 'index.php?micro_post_id=$matches[1]', 'top');
    //add_rewrite_rule('^/([a-zA-Z0-9-_~!$&\'()*+,;=:@]+)/?', 'index.php?pwa_post_id=$matches[1]', 'top');
}

define('autoindex_upload',$autoindex_dirname);


add_action('admin_menu', 'autoin_register_menu_pages');

//notification


function autoin_setting()
{
    add_action('wp-ajax_nopriv_public_ajax_request', 'handle_ajax_request_public');
    include_once('inc/setting.php');

}

function autoin_dashboard()
{
    add_action('wp-ajax_nopriv_public_ajax_request', 'handle_ajax_request_public');
    include_once('inc/dashboard.php');

}

include('inc/main.php');


function autoin_successlog()
{

    include('inc/success.php');

}

function autoin_lisense()
{
    include('inc/lisense.php');
}

function autoin_notice()
{
    include('inc/notice.php');

}

function autoin_manual()
{
    include('inc/manualIndex.php');

}

function autoin_backlink(){
    include('inc/backlinkindex.php');
}
?>