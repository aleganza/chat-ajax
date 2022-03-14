<?php
    require("../funzioni.php");

    // ricevo nome del contatto dal fetch post
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // seleziono utente premuto
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti WHERE nome = '$data'";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    // Id del contatto da messaggiare
    $IdPass = $record['Id'];
    // Id dell'utente loggato
    $registeredId = $_COOKIE["Id"];

    // cerco la chat
    $sql = "SELECT * FROM chat Where (utente1Id = $registeredId AND utente2Id = $IdPass) OR (utente1Id = $IdPass AND utente2Id = $registeredId)";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    // se la chat non esiste, la creo
    if($rs->num_rows == 0){
        // echo("chat creata ");
        $sqlCreateChat = "INSERT INTO chat(utente1Id, utente2Id) VALUES ($registeredId, $IdPass)";
        $rsCreateChat = $db->query($sqlCreateChat);
        
        // rimando sql per mostrare chat
        $rs = $db->query($sql);
        $record = $rs->fetch_assoc();
    }
    // Id della chat (me la salvo anche in cookie)
    $IdChat = $record['Id'];
    setcookie("IdChat", $record['Id'], time() + 60 * 30, "/");

    // seleziono i messaggi
    $sqlShowChat = "SELECT messaggi.testo, messaggi.utenteId FROM messaggi WHERE messaggi.chatId = $IdChat";
    $rsShowChat = $db->query($sqlShowChat);
    $recordShowChat = $rsShowChat->fetch_all(MYSQLI_ASSOC);
    
    $risposta = array(
        "chat" => $record,
        "messaggi" => $recordShowChat,
        "registeredId" => $registeredId
    );
    echo json_encode($risposta);

    $db->close();
?>