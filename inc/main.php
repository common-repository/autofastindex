<?php
error_reporting(0);

if(isset($_POST['removenotification'])){
    unlink(autoindex_upload. '/gnotification.json');

}

$notification = @file_get_contents(autoindex_upload . '/notification.json');
$notification = json_decode($notification);

$gnotification = @file_get_contents(autoindex_upload . '/gnotification.json');
$gnotification = json_decode($gnotification);


if (@$notification->request_notify) {
    add_action('admin_notices', 'autoin_admin_notice__error_notification');
}

if (@$gnotification->request_notify) {
    add_action('admin_notices', 'autoin_admin_notice_notification');
}

function autoin_admin_notice_notification() {
    $get = @file_get_contents(autoindex_upload . '/gnotification.json');
    $data = json_decode($get);
    $class = 'notice is-dismissible notice-info';
    $message = " <a href='" . admin_url($data->globalNotificationHref) . "' >" . __($data->request_notify, 'sample-text-domain') . "</a>";
    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), '<form action="" method="POST"><button  name="removenotification" type="submit" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></form>' . $message);
}



function autoin_admin_notice__error_notification() {
    $get = @file_get_contents(autoindex_upload . '/notification.json');
    $data = json_decode($get);
    $class = 'notice notice-error';
    if ($data->valid == 0) {
        $message = __(esc_attr($data->request_notify), 'sample-text-domain') . "  <a href='" . admin_url('admin.php?page=lisense') . "' >Click Here</a>";
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    }
}

?>
