<?php

function getData($postId, $post) {
    try {
        $dir = autoindex_upload . "/$postId";
        $filePath = $dir . "/data.json";

        if (file_exists($filePath)) {
            $jsonData = file_get_contents($filePath);
            $data = json_decode($jsonData, true);

            if (isset($data['updatedAt'])) {
                $updatedAt = new \DateTime($data['updatedAt']);
                $now = new \DateTime();
                $timeDiff = $now->getTimestamp() - $updatedAt->getTimestamp();

                if ($timeDiff < 10000) {
                    return $data['data'];
                }
            }
        }

        $apiUrl = "https://logs.firstpageranker.com/api/public/extractData";
        $postData = array(
            'postId' => $postId,
            'title' => $post->post_title,
            'content' => $post->post_content
        );

        $response = wp_remote_post($apiUrl, array('body' => $postData));

        $data = wp_remote_retrieve_body($response);
        $data = json_decode($data, true);
        $data['updatedAt'] = (new \DateTime())->format('Y-m-d H:i:s');

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        if($data['data']){
            file_put_contents($filePath, wp_json_encode($data, JSON_PRETTY_PRINT));
        }
        

        return $data['data'];
    } catch (\Exception $e) {
        return false;
    }
}

?>
