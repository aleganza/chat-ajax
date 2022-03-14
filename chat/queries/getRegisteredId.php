<?php
    require("../funzioni.php");

    // ottengo id dell'account registrato
    $registeredId = $_COOKIE['Id'];

    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti WHERE Id = '$registeredId'";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();
    
    $risposta = array(
        "a" => $registeredId,
        "b" => $record['nome']
    );
    echo json_encode($risposta);

    $db->close();
?>