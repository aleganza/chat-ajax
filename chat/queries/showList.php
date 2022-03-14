<?php
    require("../funzioni.php");

    /* salvo id con cui sono loggato */
    $registeredId = $_COOKIE["Id"];

    /* ricavo ultimo messaggio di ogni chat */
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti WHERE Id != '$registeredId'";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    /* array per archiviare l'ultimo messaggio di ogni chat */
    $lastMsgArray = [];
    $i = 0;

    while($record){
        $IdContact = $record['Id'];

        /* query per prendere ultimo messaggio inviato */
        $sqlLast = "SELECT messaggi.testo
                    FROM messaggi, chat
                    WHERE ((chat.utente1Id = $registeredId AND chat.utente2Id = $IdContact)
                    OR (chat.utente1Id = $IdContact AND chat.utente2Id = $registeredId))
                    AND messaggi.chatId = chat.Id
                    ORDER BY messaggi.Id DESC LIMIT 1";
        $rsLast = $db->query($sqlLast);
        if($rsLast->num_rows == 0)
            $lastMsgArray[$i] = "";
        else
            $lastMsgArray[$i] = $rsLast->fetch_assoc()['testo'];

        $i = $i + 1;
        $record = $rs->fetch_assoc();
    }

    /* mostro ogni persona registrata, tranne il profilo con cui sono loggato */
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti WHERE Id != '$registeredId'";
    $rs = $db->query($sql);
    /* $record = $rs->fetch_assoc(); */
    $record = $rs->fetch_all(MYSQLI_ASSOC); // a matrice

    /* (a: utenti, b: ultimo messaggio) */
    $risposta = array(
        "a" => $record,
        "b" => $lastMsgArray
    );
    echo json_encode($risposta);

    $db->close();
?>