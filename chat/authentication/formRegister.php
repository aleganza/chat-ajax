<?php
    echo("
        <div class=\"authFlex\">
        <div class=\"auth\">
                    <h1>Registrazione</h1>
                    <form action=\"../chat/index.php\" method=\"POST\">
                        <input type=\"text\" name=\"nome\" id=\"emailId\" placeholder=\"Inserisci nome\" required>
                        <input type=\"password\" name=\"password\" id=\"passwordId\" placeholder=\"Inserisci password\" required>
                        
                        <input type=\"hidden\" name=\"scelta\" value=\"register\">
                        <button type=\"submit\">Registrati</button>
                    </form>
                    <a href=\"../chat/index.php?scelta=formLogin\">Hai già un account? vai al login.</a>
                </div>
        </div>        
    ");
?>

