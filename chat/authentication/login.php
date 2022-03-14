<?php
    $nome = isset($_REQUEST['nome']) ? $_REQUEST['nome'] : "";
    $password = isset($_REQUEST['password']) ? md5($_REQUEST['password']) : "";

    // controllo se utente esiste già
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT * FROM utenti Where nome = '$nome' AND password = '$password'";
    $rs = $db->query($sql);
    
    $record = $rs->fetch_assoc();

    if($rs->num_rows != 0){
        if($db->query($sql)){

            /* settaggio cookie */
            setcookie("Id", $record['Id'], time() + 60 * 30, "/");
            setcookie("authenticate", "true", time() + 60 * 30, "/");

            header('Location: ../chat/index.php?scelta=chat');
        }
        else
            echo("<p class=\"error\">Errore...</p>");
    }else{
        echo("
            <div class=\"auth\">
                <h1>Login</h1>
                <form action=\"../chat/index.php\" method=\"POST\">
                    <input type=\"text\" name=\"nome\" id=\"emailId\" placeholder=\"Inserisci nome\" required>
                    <input type=\"password\" name=\"password\" id=\"passwordId\" placeholder=\"Inserisci password\" required>
                    
                    <input type=\"hidden\" name=\"scelta\" value=\"login\">
                    <button type=\"submit\">Login</button>
                </form>
                <a href=\"../chat/index.php?scelta=formRegister\">Non hai un account? vai a registrarne uno.</a>
                <p class=\"error\">Nome o password errati.</p>
            </div>
        ");
    }

    $db->close();
?>