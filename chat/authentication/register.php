<?php 
    $nome = $_REQUEST['nome'];
    $pwNotMD5 = $_REQUEST['password']; // per loggarsi dopo register
    $password = md5($_REQUEST['password']);

    // controllo se utente esiste già
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti Where nome = '$nome'";
    $result = $db->query($sql);

    if($result->num_rows == 0){
        // se l'utente non è già presente, proseguo con il suo inserimento nel database
        $sql = "INSERT INTO utenti(nome, password) VALUES('$nome', '$password')";

        if($db->query($sql))
            header("Location: ../chat/index.php?scelta=login&nome=$nome&password=$pwNotMD5");
        else
            echo("<p class=\"error\">Errore in registrazione...</p>");
    }else{
        // se l'utente è già presente, comunico, non inserisco nel database e rimostro il form di registrazione 
        echo("
            <div class=\"auth\">
                <h1>Registrazione</h1>
                <form action=\"../chat/index.php\" method=\"POST\">
                    <input type=\"text\" name=\"nome\" id=\"emailId\" placeholder=\"Inserisci nome\" required>
                    <input type=\"password\" name=\"password\" id=\"passwordId\" placeholder=\"Inserisci password\" required>
                    
                    <input type=\"hidden\" name=\"scelta\" value=\"register\">
                    <button type=\"submit\">Registrati</button>
                </form>
                <a href=\"../chat/index.php?scelta=formLogin\">Hai già un account? vai al login.</a>
                <p class=\"error\">Utente già registrato! Scegli un altro nome.</p>
            </div>
        ");
    }
    $db->close();
?>