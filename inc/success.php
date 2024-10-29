<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Logs</title>
    <?php wp_enqueue_script("jquery"); ?>
    <?php
    wp_enqueue_style('bootstrap4', plugins_url('../assets/css/bootstrap.css', __FILE__));
    wp_enqueue_style('datatable', plugins_url('../assets/css/DataTable.css', __FILE__));
    wp_enqueue_script('datatable', plugins_url('../assets/js/DataTable.js', __FILE__));
    ?>
    <style>
          #wpcontent{
            padding-left:0px !important
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
        </style>
</head>

<body>
<header class="header">
        <h1>AutoFast - Intelligent Indexing Bot</h1>
        <h4>Only for ranking</h4>
    </header>
<?php
$configapi = file_get_contents(plugin_dir_path(__FILE__) . '../api/config.json');
$configapi = json_decode($configapi);
$api_url = $configapi->logs;

if (!file_exists(autoindex_upload . '/settingsv2.json')) {
    $message = __('Please Register, ', 'sample-text-domain') . "  <a href='" . admin_url('admin.php?page=AutoFastindex') . "' >Click Here</a>";
    $class = 'notice notice-error';
    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    exit;
}
?>

<br/>
<div class=" col-sm-12 p-4">
<p>Here you can only see the last 300 records </p><br/>
<table id="example" class="responsive display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Url</th>
            <th>Status</th>
            <th>Code</th>
            <th>Type</th>
            <th>Index Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $get = file_get_contents(autoindex_upload . '/settingsv2.json');
    $data = json_decode($get);

    $email = $data->email;

    $postRequest = [
        "logs" => 1,
        "email" => $email,
        "site" => $data->url
    ];

    $args = array(
        'body' => $postRequest,
        'timeout' => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array(),
    );

    $apiResponse = wp_remote_post($api_url, $args);
    $apiResponse = $apiResponse['body'];

    $i = 1;
    $d = @json_decode($apiResponse);

    if ($d) {
        foreach ($d as $data) {
    ?>
        <tr>
            <td><?php echo esc_html($data->url); ?></td>
            <td><?php echo esc_html($data->status); ?></td>
            <td><?php echo esc_html($data->code); ?></td>
            <td><?php echo esc_html($data->type); ?></td>
            <td><?php echo esc_html($data->indexStatus); ?><br/><a target="_blank" href="https://www.google.com/search?q=site:<?= $data->url; ?>">Validate</a></td>
            <td><?php echo esc_html($data->date); ?></td>
        </tr>
    <?php 
        } 
    } 
    ?>
    </tbody>
</table>
</div>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('#example').DataTable({
            "paging": true,
            "pageLength": 10
        });
    });
</script>

</body>

</html>
