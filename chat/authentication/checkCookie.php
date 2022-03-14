<?php
    if(!isset($_COOKIE['authenticate']) || $_COOKIE['authenticate'] == "false"){
        http_response_code(401);
        header('Location: ../chat/index.php?scelta=login');
        exit;
    }
?>