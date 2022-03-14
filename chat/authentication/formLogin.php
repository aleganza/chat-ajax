<?php
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
        </div>
    ");
?>