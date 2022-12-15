<?php
    include "functions.php";
    include "session.php";

    $result = [];

    if(array_key_exists("blog_id", $_GET)) {
        $result['deleted'] = false;

        if(delete_blog($_SESSION['id'], $_GET['blog_id'])) {
            $result['deleted'] = true;
        }
    }

    echo json_encode($result);

?>