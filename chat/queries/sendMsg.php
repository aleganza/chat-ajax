<?php
    require("../funzioni.php");

    $chatId= $_COOKIE['IdChat'];
    $utenteId = $_COOKIE["Id"];
    
    // ricevo nome del contatto dal fetch post
    $json = file_get_contents('php://input');
    $messaggio = json_decode($json);
    
    /* se il messaggio è vuoto non lo inserisce in database */
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "INSERT INTO messaggi(chatId, utenteId, testo) VALUES ($chatId, $utenteId, '$messaggio')";
    $rs = $db->query($sql);
?>